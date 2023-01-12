<?php

class EcolageController extends BaseController {

	public function indexEcot()
	{
		$title 			= 'Configurations';
		$sous       	= 'Paramètres d\'écolage et Droit';
		$classes  		= TheClass::all();
		$ecolage 		= Ecolage::orderBy('id', 'asc')->paginate(15);
		return View::make('backend.admin.parametre.Ecolage.index', compact('ecolage', 'classes'))->with('title', $title)->with('sous', $sous);
	}


	public function store()
	{
		if (Request::ajax()){

	
			$inputs = Input::all();
			$validation = Validator::make($inputs, ['class_id'=>'required', 'total'=>'required']);
			if ($validation->fails()) {
				return 'false';
			} 

			else {
	
				$ecolage = Ecolage::create([

					'class_id' 	=> e($inputs['class_id']),
					'total' 	=> e($inputs['total']),
					'status' 	=> e($inputs['status']),
					'priceU' 	=> e($inputs['priceU']),
					'droit' 	=> e($inputs['droit'])
				]);

				return 'true';
			}

        }
	}

	
	public function updateEcolage($id) {

		if (Request::ajax()){

			$inputs = Input::all();
			$validation = Validator::make($inputs, ['class_id'=>'required', 'total'=>'required']);
			if ($validation->fails()) {
				
				return 'false';
			} 

			else {

				$ecoT = Ecolage::find($id);

				$ecoT->class_id 	= e($inputs['class_id']);
				$ecoT->total 		= e($inputs['total']);
				$ecoT->priceU 		= e($inputs['priceU']);
				$ecoT->droit 		= e($inputs['droit']);
			  }
			
			if (Input::has('status'))
				   {
				    $ecoT->status = 1;
				   }
				   else {
				   $ecoT->status = 0;
				}

			$ecoT->save();
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
		
		$ecolage = Ecolage::find($id);

		if ($ecolage !== null) {
			$ecolage->delete();
			$path = Session::get('language');
			return Redirect::back()->with('success', Lang::get($path.'.Deleted_successfully'));
		} 

		else {
			return Redirect::back();
		}

		

		
	}


}
