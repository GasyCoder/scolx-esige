<?php
class DomaineController extends BaseController {

	public function index()
	{
		$title 		= 'Domaines';
		$sous       = 'Domaines de formation';
		$parcours   = Parcour::where('status', 1)
								->where('class_id', '>=', 2)
								->groupBy('name')
								->orderBy('id', 'asc')
								->get();

		$domaines   = Domaine::where('status', 1)
								->groupBy('name')
								->orderBy('id', 'asc')
								->get();

		$classes  	= TheClass::all();

		return View::make('backend.admin.pedagogie.Domaines.index', compact('domaines', 'classes', 'parcours'))->with('title', $title)->with('sous', $sous);
	}

	public function storeD()
	{
		if (Request::ajax()) {
		
			$inputs = Input::all();
			$validation = Validator::make($inputs, ['name'=>'required']);
			if ($validation->fails()) {
				return 'false';
			} 
			else {

			foreach ($inputs['parcour_id'] as $parcour) {

				$domaine = new Domaine();
				
				$domaine->parcour_id    	= $parcour;
				$domaine->name 				= $inputs['name'];
				$domaine->status			= 1;
				$domaine->save();

			 }
				return 'true';
			}

        }
	}

	
	public function edit_domaine($id, $parcour)
	{
		$title 		= 'Modifier domaine';
		$sous       = 'Domaines de formation';
		$parcour   	= Parcour::find($parcour);
		$domaine    = Domaine::find($id);
		$domaines    = Domaine::where('status', 1)
							  ->where('id', $parcour->id)
							  ->get();
		$parcours 	= Parcour::where('status', 1)
								->where('id', '!=', $parcour->id)
								->where('class_id', '>=', 2)
								->groupBy('name')
								->orderBy('id', 'asc')
								->get();

		return View::make('backend.admin.pedagogie.Domaines.edite_domaine', compact('domaine', 'parcour', 'parcours','domaines'))->with('title', $title)->with('sous', $sous);
	}


	public function updateD($id)
	{
		if (Request::ajax()){

			$inputs = Input::all();
			$validation = Validator::make($inputs, ['name'=>'required']);
			if ($validation->fails()) {
				return 'false';
			} 

			else {
				foreach ($inputs['parcour_id'] as $parcour) {

				$domaine = Domaine::find($id);

				$domaine->name 			= e($inputs['name']);
				$domaine->parcour_id    = $parcour;
				//$domaine->parcour_id 	= e($inputs['parcour_id']);
				
				}
			}
			if (Input::has('status')) {

			         $domaine->status = 1;

			    } else {

			         $domaine->status = 0;
				
				}

				$domaine->save();
				return 'true';		
        }
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function delete($id)
	{
		
		$domaine = Domaine::find($id);
		if ($domaine !== null) {

			// delete parcour from Etudiant
			$students = Student::where('parcour_id', $parcour->id)->get();
			foreach ($students as $student) {
				$student->parcour_id = 0;
				$student->save();
			}

			$domaine->delete();
			$path = Session::get('language');
			return Redirect::back()->with('success', ('Parcour a été supprimé avec succès!'));
		} 

		else {
			return Redirect::back();
		}
		
	}


}
