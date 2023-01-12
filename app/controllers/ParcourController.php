<?php

class ParcourController extends BaseController {



	public function index()
	{
		$title 		= 'Parcours';
		$sous       = 'Parcours';
		$classes  	= TheClass::all();
		$students  	= Student::all();
		$parcours 	= Parcour::orderBy('id', 'asc')->get();
		return View::make('backend.admin.pedagogie.Parcours.index', compact('parcours', 'classes', 'students'))->with('title', $title)->with('sous', $sous);
	}


	public function storeParcour()
	{
		if (Request::ajax()){

	
			$inputs = Input::all();
			$validation = Validator::make($inputs, ['name'=>'required']);
			
			if ($validation->fails()) {
				return 'false';
			} 

			else {
				$parcour = Parcour::create([

					'name' 		=> e($inputs['name']),
					'abr' 		=> e($inputs['abr']),
					'class_id' 	=> e($inputs['class_id']),
					//'status' 	=> e($inputs['status'])
				]);
				
			if (Input::get('status'))

			    {
			        $parcour->status = 1;

			    }else {
			    	
			        $parcour->status = 0;
			    }

				return 'true';
			}

        }
	}


	public function updateParcour($id)
	{
		if (Request::ajax()){

			$inputs = Input::all();
			$validation = Validator::make($inputs, ['name'=>'required']);
			if ($validation->fails()) {
				return 'false';
			} 

			else {


				$parcour = Parcour::find($id);

				$parcour->name = e($inputs['name']);
				$parcour->abr = e($inputs['abr']);
				$parcour->class_id = e($inputs['class_id']);
				
			}
			
			if (Input::has('status')) {

			         $parcour->status = 1;

			    } else {

			         $parcour->status = 0;
				
				}

				$parcour->save();
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
		
		$parcour = Parcour::find($id);
		if ($parcour !== null) {

			// delete parcour from Etudiant
			$students = Student::where('parcour_id', $parcour->id)->get();
			foreach ($students as $student) {
				$student->parcour_id = 0;
				$student->save();
			}

			$parcour->delete();
			$path = Session::get('language');
			return Redirect::back()->with('success', ('Parcour a été supprimé avec succès!'));
		} 

		else {
			return Redirect::back();
		}
		
	}


}
