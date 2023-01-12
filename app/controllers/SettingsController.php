<?php

class SettingsController extends BaseController {


	public function index()
	{
		$title 				= 'Tableau de bord';
		$sous       		= 'Accueil';
		$ui         		= 'Tableau de bord';
		$years              = Year::orderBy('status', 1)->first();
		$foad 				= User::where('is_student', true)->count();
		$ues 				= UE::where('status', true)->count();
		$ecs 	    		= EC::where('status', true)->count();
		$parcours 			= Parcour::count();
		$managers 			= User::where('is_secretaire', true)->count();
		$etudiants  		= Student::count();
		$trangers  		    = Instance::where('nationality', '!=', 'MG')->count();
		$male  		    	= Instance::where('sexe', '=', 1)->count();
		$female  		    = Instance::where('sexe', '=', 2)->count();
		$teachers       	= Teacher::where('status', 1)->count();
		$absences 	    	= Absence::where('yearsUniv', $years->yearsUniv)
										->where('status', 0)
										->count();
		$presences 	    	= Absence::where('yearsUniv', $years->yearsUniv)
										->where('status', 1)
										->count();
		$payement_r 	    = Pay::where('status', 1)
										->where('yearsUniv', $years->yearsUniv)
										->where('nbreMois', '>=', 1 )
										->orderBy('created_at', 'desc')
										->take('6')
										->get();
		$payed  		    = Instance::where('yearsUniv', $years->yearsUniv)
										->where('payed', 1)
										->count();
		$notes 				= TheNotes::orderBy('typeclass', 'asc')->get();
		$classe  			= TheClass::where('status', 1)->get();
		$semestre_one       = Sem::where('codeSem', 1)->first();
		$semestre_two       = Sem::where('codeSem', 2)->first();
		
		return View::make('backend.admin.homeAdmin', compact('etudiants', 'foad', 'parcours','ues', 'ecs', 'managers', 'payement_r', 'payed', 'teachers', 'notes', 'absences', 'presences', 'years', 'classe', 'trangers', 'male', 'female', 'semestre_one', 'semestre_two'))->with('title', $title)->with('sous', $sous)->with('ui', $ui);

	}



	public function configindex()
	{
		$title 		= 'Configurations';
		$sous       = 'Paramètres';
		$control 	= Control::find(1);
		$user_id 	= Auth::user()->id;
		$user 		= User::find($user_id);
		$keywords 	= Keywords::orderBy('id', 'desc')->get();

		if (!Auth::user()->is_secretaire) {
			return View::make('backend.admin.parametre.settings.index', compact('control', 'user', 'keywords'))->with('title', $title)->with('sous', $sous);
		} else {
			return Redirect::route('panel.admin');
		}


	}

	public function settingsOne()
	{

		$control = Control::find(1);
		$inputs = Input::all();

			$validation = Validator::make($inputs, ['email'=>'email|required', 'school_name'=>'required', 'description'=> 'required']);

			if ($validation->fails()) {
				return Redirect::back()->withInput()->withErrors($validation);

			} else {

				$control->school_name 	= e($inputs['school_name']);
				$control->sigle 		= e($inputs['sigle']);
				$control->slogan 		= e($inputs['slogan']);
				$control->email 		= e($inputs['email']);
				$control->phone 		= e($inputs['phone']);
				$control->address 		= e($inputs['address']);

				$control->facebook 		= e($inputs['facebook']);
				$control->twitter 		= e($inputs['twitter']);
				$control->youtube 		= e($inputs['youtube']);
				$control->description 	= e($inputs['description']);
				
				$control->save();

				$path = Session::get('language');
				return Redirect::back()->withSuccess(Lang::get($path.'.Modified_successfully'));
			}
	}



	public function keyWords() {
	
	if (Request::ajax()) {

		    $inputs = Input::all();
			$validation = Validator::make($inputs, ['the_keywords'=> 'required']);

			if ($validation->fails()) {
				return 'false';
			} 

			 else {
				$keyswords 		= Keywords::create([
				'the_keywords' 	=> e(Input::get('the_keywords'))
				]);	
			}

			return 'true';
	}

}

	public function deletekeywords($id)
	{
		$keyword = Keywords::find($id);

		if ($keyword !== null) {
			
			$keyword->delete();

			return Redirect::back()->with('success', 'Mot clé été supprimer avec succès!');

		 }

		 else {
			return Redirect::route('admin_settings');
		}
	}

	public function nombreMois()
	{

		$control = Control::find(1);
		$inputs = Input::all();

			$validation = Validator::make($inputs, []);

			if ($validation->fails()) {
				return Redirect::back()->withInput()->withErrors($validation);

			} else {

				$control->nbre_mois = e($inputs['nbre_mois']);
				$control->save();

				$path = Session::get('language');
				return Redirect::back()->withSuccess(Lang::get($path.'.Modified_successfully'));
			}
	}


	public function paymentUnit()
	{

		$control = Control::find(1);
		$inputs = Input::all();

			$validation = Validator::make($inputs, []);

			if ($validation->fails()) {
				return Redirect::back()->withInput()->withErrors($validation);

			} else {

				$control->payment_unit = e($inputs['payment_unit']);

				$control->save();

				$path = Session::get('language');
				return Redirect::back()->withSuccess(Lang::get($path.'.Modified_successfully'));
			}
	}

	//Desativer Remise
	public function activeRemise()
	{

		$control = Control::find(1);
		$inputs = Input::all();

			$validation = Validator::make($inputs, []);

			if ($validation->fails()) {
				return Redirect::back()->withInput()->withErrors($validation);

			} else {
				
				$control->remise = e($inputs['remise']);
			}
			if (Input::has('activeRemise'))
			   {
			   $control->activeRemise = 1;
			}else {
			   $control->activeRemise = 0;
			}
			  $control->save();
			  $path = Session::get('language');
			  return Redirect::back()->withSuccess('Paramètre remise a été changer avec succès!');

	}

	//Desativer Taxe
	public function activeTax()
	{

		$control = Control::find(1);
		$inputs = Input::all();

			$validation = Validator::make($inputs, []);

			if ($validation->fails()) {
				return Redirect::back()->withInput()->withErrors($validation);

			} else {

				$control->payment_tax 	= e($inputs['payment_tax']);
			}
			if (Input::has('activeTax'))
			   {
			   $control->activeTax = 1;
			}else {
			   $control->activeTax = 0;
		}
			  $control->save();
			  $path = Session::get('language');
			  return Redirect::back()->withSuccess('Paramètre taxe a été changer avec succès!');

	}



	//Message pour desactivation site
	public function messageClose()
	{
		$control = Control::find(1);
		$inputs = Input::all();

			$validation = Validator::make($inputs, []);
			if ($validation->fails()) {
				return Redirect::back()->withInput()->withErrors($validation);

			} else {
				$control->closing_msg 	= e($inputs['closing_msg']);
				$control->save();
				$path = Session::get('language');
				return Redirect::back()->withSuccess(Lang::get($path.'.Modified_successfully'));
			}
	}


	//Desativer Site
	public function closeApp()
	{

		$control = Control::find(1);
		$inputs = Input::all();

			$validation = Validator::make($inputs, []);

			if ($validation->fails()) {
				return Redirect::back()->withInput()->withErrors($validation);

			} else {

				$control->close_site = e($inputs['close_site']);
				$control->save();

				$path = Session::get('language');
				return Redirect::back()->withSuccess('Votre application a été à jour!');
			}
	}

	public function update_admin()
	{

		$user_id = Auth::user()->id;

		$user = User::find($user_id);

		$inputs = Input::all();

		$validation = Validator::make($inputs, ['email'=>'email']);

		if ($validation->fails()) {

			return Redirect::back()->withErrors($validation);

		} else {


				if (Input::hasFile('image')) {

					// delete old image
					if (!empty($user->image)) {
						unlink(public_path()."/uploads/profiles/".$user->image);
					}

					$image = Input::file('image');

					$destinationPath = 'uploads/profiles';

					$filename = $image->getClientOriginalName();
					$filename = strtolower($filename);
					$filename = str_ireplace(' ', '_', $filename);
					$filename = round(microtime(true)).'_'. $filename;

					$upload_success = $image->move($destinationPath, $filename);


					$user->email = e($inputs['email']);
					$user->image = $filename;


				} else {
					$user->email = e($inputs['email']);
				}


				$user->save();

				$path = Session::get('language');
				return Redirect::back()->withSuccess(Lang::get($path.'.Modified_successfully'));


		}

	}


	public function admin_password()
	{

		$path = Session::get('language');

		$user_id = Auth::user()->id;
		$user = User::find($user_id);

		$inputs = Input::all();

		$validation = Validator::make($inputs, ['old_password'=>'required', 'password'=>'required|min:4', 'password_confirm'=>'required|same:password']);


		if ($validation->fails()) {

			return Redirect::back()->withErrors($validation);

		} else {

			$old_password = Input::get('old_password');

			if (Hash::check($old_password, $user->password)) {

				$user->password = Hash::make($inputs['password']);
				$user->save();
				return Redirect::back()->withSuccess(Lang::get($path.'.Information_modified'));
			}

			else {

				return Redirect::back()->withError(Lang::get($path.'.password_error'));
			}
		}
	}

	
	public function applogo()
	{
		$control = Control::find(1);
		$inputs = Input::all();

		$validation = Validator::make($inputs, 
			[
				'logo'=>'image',
			]
		); 

		if ($validation->fails()) {
			return Redirect::back()->withInput()->withErrors($validation);

		} else {


			if (Input::hasFile('logo')) {

				// delete old image
				if (!empty($control->logo)) {
					unlink(public_path()."/public/uploads/logo/".$control->logo);
				}

				$image = Input::file('logo');
		
				$destinationPath = 'public/uploads/logo/';

				$filename = $image->getClientOriginalName();
				$filename = strtolower($filename);
				$filename = str_ireplace(' ', '_', $filename);
				$filename = round(microtime(true)).'_'. $filename;

				$upload_success = $image->move($destinationPath, $filename);

				$control->logo = $filename;
				$control->save();
				return Redirect::back()->withSuccess('Votre logo a été changé avec succès!');
			} 	
		}
	}

	//Favicon
	public function favicon()
	{
		$control = Control::find(1);
		$inputs = Input::all();

		$validation = Validator::make($inputs, 
			[
				'favicon'=>'image',
			]
		); 

		if ($validation->fails()) {
			return Redirect::back()->withInput()->withErrors($validation);

		} else {


			if (Input::hasFile('favicon')) {

				// delete old image
				if (!empty($control->favicon)) {
					unlink(public_path()."/public/uploads/favicon/".$control->favicon);
				}

				$image = Input::file('favicon');
		
				$destinationPath = 'public/uploads/favicon/';

				$filename = $image->getClientOriginalName();
				$filename = strtolower($filename);
				$filename = str_ireplace(' ', '_', $filename);
				$filename = round(microtime(true)).'_'. $filename;

				$upload_success = $image->move($destinationPath, $filename);

				$control->favicon = $filename;
				$control->save();
				return Redirect::back()->withSuccess('Votre favicon a été changé avec succès!');
			} 	
		}
	}

	//Desativer inscription
	public function inscrit()
	{

		$control = Control::find(1);
		$inputs = Input::all();

			$validation = Validator::make($inputs, []);

			if ($validation->fails()) {
				return Redirect::back()->withInput()->withErrors($validation);
			} 

			if (Input::has('inscrit'))
			   {
			   
			   $control->inscrit = 1;

			}else {

			   $control->inscrit = 0;
		}
			  $control->save();
			  $path = Session::get('language');
			  return Redirect::back()->withSuccess('La période d\'inscription a été changé!');

	}

	//Desativer Ré-inscription
	public function reSinscrit()
	{

		$control = Control::find(1);
		$inputs = Input::all();

			$validation = Validator::make($inputs, []);

			if ($validation->fails()) {
				return Redirect::back()->withInput()->withErrors($validation);
			} 
			if (Input::has('reSinscrit'))
			   {
			   $control->reSinscrit = 1;
			}else {
			   $control->reSinscrit = 0;
		}
			  $control->save();
			  $path = Session::get('language');
			  return Redirect::back()->withSuccess('La période de ré-inscription a été changé!');

	}
	//La page openNote
	public function openNotePage()
	{

		$control = Control::find(1);
		$inputs = Input::all();

			$validation = Validator::make($inputs, []);

			if ($validation->fails()) {
				return Redirect::back()->withInput()->withErrors($validation);
			} 
			if (Input::has('openNote'))
			   {
			   $control->openNote = 1;
			}else {
			   $control->openNote = 0;
		}
			  $control->save();
			  $path = Session::get('language');
			  return Redirect::back()->withSuccess('Votre mis à jour a été changé!');

	}

	//La page controlSession_1
	public function controlSession_1()
	{

		$control = Control::find(1);
		$inputs = Input::all();

			$validation = Validator::make($inputs, []);

			if ($validation->fails()) {
				return Redirect::back()->withInput()->withErrors($validation);
			} 
			if (Input::has('session_1'))
			   {
			   $control->session_1 = 1;
			}else {
			   $control->session_1 = 0;
		}
			  $control->save();
			  $path = Session::get('language');
			  return Redirect::back()->withSuccess('Session d\'examen a été changé!');

	}

	//La page controlSession_2
	public function controlSession_2()
	{

		$control = Control::find(1);
		$inputs = Input::all();

			$validation = Validator::make($inputs, []);

			if ($validation->fails()) {
				return Redirect::back()->withInput()->withErrors($validation);
			} 
			if (Input::has('session_2'))
			   {
			   $control->session_2 = 1;
			}else {
			   $control->session_2 = 0;
		}
			  $control->save();
			  $path = Session::get('language');
			  return Redirect::back()->withSuccess('Session d\'examen a été changé!');

	}
/*-------------------------------------
			notes
-----------------------------------*/



	public function admin_notes_store() {
		$user_id        = Auth::user()->id;
		$inputs 		= Input::all();

			$validation = Validator::make($inputs, ['priority'=> 'required']); 

			if ($validation->fails()) {

				return Redirect::back()->withInput()->withErrors($validation);
				//return Redirect::back()->with('error', ('Une erreur est survenue. Veuillez réessayer!'));

			} else {

				if (Input::get('priority') == 'Urgent') {
					$typeclass = 'badge_danger';
				}

				elseif (Input::get('priority') == 'Intéressant') {
					$typeclass = 'badge_success';
				}

				elseif (Input::get('priority') == 'Archive') {
					$typeclass = 'badge_secondary';
				}

				
				$notes = TheNotes::create([
					'id_user' 			=> $user_id,
					'typepriority' 		=> e(Input::get('priority')),
					'typeclass' 		=> $typeclass,
					'textnote' 			=> e(Input::get('note'))
				]);
					
				
				$notes->save();
				return Redirect::back()->withSuccess('Ajouter avec succès!');
			}
}
	public function notes_destroy($id)
	{
		$note = TheNotes::find($id);

		if ($note !== null) {
			
			$note->delete();

			return Redirect::back()->with('success', 'note été supprimer avec succès!');

		 }

		 else {
			return Redirect::route('admin_cpanel');
		}
	}
}
