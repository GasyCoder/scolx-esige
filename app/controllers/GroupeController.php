<?php

class GroupeController extends BaseController {

/*-------------- pages -------------------*/

	protected $rules = [

			'name'=>'required|max:25',

	];

	public function indexGroupe()
	{	
		$title 		= 'Groupes';
		$sous       = 'Groupe';
		$groupes 	= Groupe::orderBy('id', 'desc')->paginate(15);
		$parcours   = Parcour::all();
		$groupe   	= Groupe::all();
		$classes  	= TheClass::all();
		return View::make('backend.admin.pedagogie.Groupes.index', compact('classes', 'parcours', 'groupes'))->with('title', $title)->with('sous', $sous);
	}



	public function groupeStore()
	{
		if (Request::ajax()){

	
			$inputs = Input::all();
			$validation = Validator::make($inputs, $this->rules);
			if ($validation->fails()) {
				return 'false';
			} 

			else {

				$groupes = Groupe::create([

					'name'		=>e($inputs['name']),
					'parcour_id'=>e($inputs['parcour_id']),
					'class_id'	=>e($inputs['class_id']),
					'status' 	=> e($inputs['status'])
					
				]);

				return 'true';
			}

        }
	}


	public function groupeUpdate($id)
	{
		if (Request::ajax()){

			$inputs = Input::all();
			$validation = Validator::make($inputs, $this->rules);
			if ($validation->fails()) {
				return 'false';
			} 

			else {


				$groupe 			= Groupe::find($id);
				$groupe->name 		= e($inputs['name']);
				$groupe->class_id 	= e($inputs['class_id']);
				$groupe->parcour_id = e($inputs['parcour_id']);
				$groupe->status 	= e($inputs['status']);
				$groupe->save();

				return 'true';
			}

        }
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function groupeDelete($id)
	{
		
		$groupe = Groupe::find($id);

		if ($groupe !== null) {

			// delete parcour from Etudiant
			$students = Student::where('parcour_id', $groupe->id)->get();
			foreach ($students as $student) {
				$student->groupe_id = 0;
				$student->save();
			}



			$groupe->delete();
			$path = Session::get('language');
			return Redirect::back()->with('success', ('Groupe a été supprimé avec succès!'));
		} 

		else {
			return Redirect::back();
		}

		

		
	}


}
