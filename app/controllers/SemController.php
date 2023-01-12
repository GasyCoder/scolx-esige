<?php

class SemController extends BaseController {



	public function index()
	{
		$title 			= 'Semestres Universitaire';
		$sous       	= 'Semestres';
		$years  		= Year::where('status', 1)->get();
		//$classes  		= TheClass::where('id', '>=', 2)->get();
		$semestres 	    = Sem::orderBy('id', 'asc')->paginate(15);
		return View::make('backend.admin.administration.Semestres.index', compact('semestres', 'years'))->with('title', $title)->with('sous', $sous);
	}


	public function storeSem()
	{
		if (Request::ajax()){

			$inputs = Input::all();
			$validation = Validator::make($inputs, ['codeSem'=>'required']);
			if ($validation->fails()) {
				return 'false';
			} 

			else {
				$sem = Sem::create([

					'codeSem' 	=> e($inputs['codeSem']),
					'semestre' 	=> e($inputs['semestre']),
					'yearsUniv' => e($inputs['yearsUniv']),
					'dateStart' => e($inputs['dateStart']),
					'dateEnd' 	=> e($inputs['dateEnd'])

				]);

				return 'true';
			}

        }
	}


	public function updateSem($id)
	{
		if (Request::ajax()){

			$inputs = Input::all();
			$validation = Validator::make($inputs, ['codeSem'=>'required']);
			if ($validation->fails()) {
				return 'false';
			} 

			else {


				$sem = Sem::find($id);

				$sem->codeSem 		= e($inputs['codeSem']);
				$sem->semestre 		= e($inputs['semestre']);
				$sem->yearsUniv 	= e($inputs['yearsUniv']);
				$sem->dateStart 	= e($inputs['dateStart']);
				$sem->dateEnd 		= e($inputs['dateEnd']);
				
			}

			if (Input::has('status'))
			   {
			    $sem->status = 1;
			  }
			else {
			    $sem->status = 0;
			  }

			$sem->save();
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
		
		$sem = Sem::find($id);

		if ($sem !== null) {

			$sem->delete();

			$path = Session::get('language');
			return Redirect::route('index')->with('success', ('Semestre a été supprimé avec succès!'));
		} 

		else {
			return Redirect::back();
		}

		

		
	}


}
