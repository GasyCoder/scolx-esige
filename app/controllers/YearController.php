<?php

class YearController extends BaseController {



	public function index()
	{
		$title          = 'Année Universitaire';
		$sous       	= 'Année d\'étude';
		$years 	    	= Year::orderBy('id', 'asc')->paginate(15);
		return View::make('backend.admin.administration.Years.index', compact('years'))->with('title', $title)->with('sous', $sous);
	}


	public function storeYear()
	{
		if (Request::ajax()){

	
			$inputs = Input::all();
			$validation = Validator::make($inputs, ['yearsUniv' => 'required']);
			if ($validation->fails()) {
				return 'false';
			} 

			else {
				$year = Year::create([

					'dateStart' => e($inputs['dateStart']),
					'dateEnd' => e($inputs['dateEnd']),
					'yearsUniv' => e($inputs['yearsUniv'])
				]);

				return 'true';
			}

        }
	}


	public function updateYear($id)
	{
		if (Request::ajax()){
			$inputs = Input::all();
			$validation = Validator::make($inputs, ['yearsUniv' => 'required']);
			if ($validation->fails()) {
				return 'false';
			} 
			else {
				$year 				= Year::find($id);
				$year->dateStart 	= e($inputs['dateStart']);
				$year->dateEnd 		= e($inputs['dateEnd']);
				$year->yearsUniv 	= e($inputs['yearsUniv']);
			}

			if (Input::has('status'))
			   {
			    $year->status = 1;
			  }
			else {
			    $year->status = 0;
			  }

			$year->save();
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
		
		$year = Year::find($id);

		if ($year !== null) {

			$year->delete();

			$path = Session::get('language');
			return Redirect::route('index')->with('success', ('Parcour a été supprimé avec succès!'));
		} 

		else {
			return Redirect::back();
		}

		

		
	}


}
