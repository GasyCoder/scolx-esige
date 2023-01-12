<?php

class SecretaireController extends BaseController {


	protected $rules = [

			'fname'=>'required', 
			'email' => 'email|unique:users',
			'password'=>'required|min:4'

	];


	public function index()
	{
		$title 			= 'Sécretaires';
		$sous       	= 'Scolarité';
		$secretaires 	= User::where('is_secretaire', true)->orderBy('fname', 'asc')->paginate(15);
		if (!Auth::user()->is_secretaire) {
			return View::make('backend.admin.administration.Secretaire.index', compact('secretaires'))->with('title', $title)->with('sous', $sous);
		} else {
			return Redirect::route('panel.admin');
		}
		
	}


	public function storeSec()
	{
		if (Request::ajax()) {
			$inputs = Input::all();
			$validation = Validator::make($inputs, $this->rules);
			if ($validation->fails()) {
				return 'false';
			} 		
			else {
				$sec = User::create([

					'fname' 		=> e($inputs['fname']),
					'lname' 		=> e($inputs['lname']),
					'email' 		=> e($inputs['email']),
					'password' 		=> Hash::make(e(Input::get('password'))),
					'is_secretaire' => 1,
					'is_admin' 		=> 1,
					'confirmed'		=> 1

				]);

				return 'true';
			}
        }
}


	public function updateSec($id)
	{
		if (Request::ajax()){

			$inputs = Input::all();
			$validation = Validator::make($inputs, ['fname'=>'required', 'email' => 'email|unique:users']);
			if ($validation->fails()) {
				return 'false';
			} 

			else {

				$secUp 			= User::find($id);
				$secUp->fname 	= e($inputs['fname']);
				$secUp->lname 	= e($inputs['lname']);
				$secUp->email 	= e($inputs['email']);
			}
			
			if (Input::has('confirmed'))
			   {
			    $secUp->confirmed = 1;
			  }
			else {
			    $secUp->confirmed = 0;
			  }

			$secUp->save();
			return 'true';

        }
	}

public function updateCode($id)
{
		

		//$user_id = Auth::user()->id;
		$user = User::find($id);

		$inputs = Input::all();

		$validation = Validator::make($inputs, ['old_password'=>'required', 'password'=>'required|min:4', 'password_confirm'=>'required|same:password']);


		if ($validation->fails()) {

			return Redirect::back()->withErrors($validation);

		} else {

			$old_password = Input::get('old_password');

			if (Hash::check($old_password, $user->password)) {

				$user->password = Hash::make($inputs['password']);
				$user->save();

				return Redirect::back()->withSuccess('Le mot de passe a été changé avec succès!');

			}

			else {

				return Redirect::back()->withError(Lang::get($path.'.password_error'));

			}


		}


	}


	public function deleteSec($id)
	{
		$user = User::find($id);

		if ($user !== null) {

	        // remove form library
			$students = Student::where('user_id', $user->id)->get();
			foreach ($students as $sec) {
				$sec->user_id = 0;
				$sec->save();
			}

			$user->delete();

			$path = Session::get('language');
			return Redirect::back()->with('success', Lang::get($path.'.Deleted_successfully'));

		} 

		else {
			return Redirect::back();
		}
	}

}
