<?php

class EtudiantController extends BaseController {

	protected $layouts = 'backend.admin';

	protected $studentRules = [	
			'fname'			=>'required',
			'phone_1'		=>'required',
			'parcour_id'	=>'required',  
			'matricule'		=>'required',
			'birth'    		=> 'required',
			'birthLocation' => 'required',
			'sexe'  		=> 'required',
			'nationality'   => 'required',
			'yearsUniv'   	=> 'required',
			'address'   	=> 'required',
			//'email'         => 'required|unique:users'
	];

	protected $file_rules = [
			'csv_file'=>'required'
	];

	public function index()
	
	{	$title 		= 'Inscription';
		$sous       = 'Liste des classes';
		$year       = Year::where('status', 1)->first();
		$parcours  	= Parcour::where('status', 1)->orderBy('id', 'asc')->paginate(10);
		$classes  	= TheClass::all();
		$kilasy  	= TheClass::where('id', 1)->first();
		//$etudiants 	= Student::orderBy('id', 'asc')->paginate(10);
		return View::make('backend.admin.pedagogie.Etudiants.index', compact('kilasy', 'classes', 'etudiants', 'parcours', 'year'))->with('title', $title)->with('sous', $sous);
	}

	public function PDF()
	{
		$etudiants = Student::all();
		return View::make('pdf', compact('etudiants'));
	}


	public function findStudent()
	{	
		$title 			= 'Listes des étudiants';
		$sous       	= 'Tous nos étudiants';
		$inputs 		= Input::all();
		$mpianatra   	= Student::all();
		$taona      	= Year::all();
		$id 			= e(Input::get('student'));
		$promo_id 		= e(Input::get('promo'));
		//$year      		= Promo::where('status', 1)->first();

			if(Input::has('promo')) {
				
				$instancer = Instance::find($id);

				if ($instancer !== null) {

					$students = Student::all();
					//$years = Promo::all();

					if(Input::has('promo')) {

						$instances = Instance::where('id', $id)->where('promo', $promo_id)->orderBy('id', 'desc')->get();

						return View::make('backend.admin.pedagogie.Etudiants.showStudent', compact('instancer', 'instances', 'years', 'students', 'mpianatra', 'year', 'taona'))->with('title', $title)->with('sous', $sous);
					} 
				}

				else {
					return Redirect::route('indexEtudiant');
				}
			} 
	}

	public function studentsAll()
	{
		$title 			= 'Listes des étudiants';
		$sous       	= 'Tous nos étudiants';
		$year      		= Year::where('status', 1)->first();
		$parcours  		= Parcour::where('status', 1)->get();
		$classes  		= TheClass::where('status', 1)->get();

		$students 		= Student::where('yearsUniv', $year->yearsUniv)
									->orderBy('id', 'asc')
									->get();

		$promos      	= Promo::all();

		return View::make('backend.admin.pedagogie.Etudiants.allstudents', compact('classes', 'students', 'parcours', 'students', 'year', 'promos', 'mpianatra'))->with('title', $title)->with('sous', $sous);
	}

	public function filterOne()
	{	
		$title 	    = 'Filtre';
		$year       = Year::where('status', 1)->first();
		$classes  	= TheClass::all();
		return View::make('backend.admin.pedagogie.Etudiants.filterOne', compact('classes'))->with('title', $title);
	}

	public function filterTo($class)
	{
		$title 			 = 'Filtrer';
		$class   		 = TheClass::find($class);
		$years   		 = Year::where('status', 1)->get();
		$parcours 		 = Parcour::where('class_id', $class->id)->where('status', 1)->get();

		return View::make('backend.admin.pedagogie.Etudiants.filterTo', compact('parcours', 'class', 'years'))->with('title', $title);
	}

	public function selectParcour($class)
	{
		$title 			 = 'Inscription';
		$sous       	 = 'Liste des parcours';
		$class   		 = TheClass::find($class);
		$years   		 = Year::where('status', 1)->get();
		$parcours 		 = Parcour::where('class_id', $class->id)
          							->where('status', 1)
          							->get();

		return View::make('backend.admin.pedagogie.Etudiants.parcours', compact('parcours', 'class', 'years'))->with('title', $title)->with('sous', $sous);
	}

	public function selectPromo($class, $parcour)
	{
		$title 			 = 'Inscription';
		$sous       	 = 'Liste des promotions';
		$class   		 = TheClass::find($class);
		$parcours 		 = Parcour::find($parcour);
		$years   		 = Year::where('status', 1)->get();
		$promos 		 = Promo::where('status', 1)->get();

		return View::make('backend.admin.pedagogie.Etudiants.promotion', compact('parcours', 'class', 'years', 'promos'))->with('title', $title)->with('sous', $sous);
	}

	public function inscriptions($class, $parcour,  $promo)
	{
		$title 			 = 'Inscription';
		$sous       	 = 'Liste des parcours';
		$class   		 = TheClass::find($class);
		$parcour 		 = Parcour::find($parcour);
		$promotion 		 = Promo::find($promo);
		$years   		 = Year::where('status', 1)->first();
		$parcours 		 = Parcour::where('class_id',    $class->id)
									->where('id', '!=',  $parcour->id)
									->where('status', 1)
									->get();

		$etudiants 		 = Student::where('class_id',      $class->id)
									 ->where('parcour_id', $parcour->id)
									 ->where('yearsUniv',  $years->yearsUniv)
									 ->count();

		$allStud 		 = Student::where('yearsUniv', $years->yearsUniv)->count();	


		return View::make('backend.admin.pedagogie.Etudiants.addEtudiant', compact('parcour', 'parcours', 'class', 'years', 'etudiants', 'allStud', 'promotion'))->with('title', $title)->with('sous', $sous);
	}



	public function listStudents($class, $parcour)
	{	
		$title 			= 'Liste des étudiants';
		$sous       	= 'par classe et parcours';
		$class   		= TheClass::find($class);
		$parcour 		= Parcour::find($parcour);
		$years   		= Year::all();
		$year   		= Year::where('status', 1)->first();
		$parcours 		= Parcour::where('class_id', $class->id)
									->where('id', '!=', $parcour->id)
									->where('status', 1)
									->get();
		
		$etudiants 		= Student::where('class_id', $class->id)
									->where('parcour_id', $parcour->id)
									->where('yearsUniv', $year->yearsUniv)
									->orderBy('id', 'asc')->get();

		$libres 		= Student::where('grade', 'AL')
								->where('yearsUniv', $year->yearsUniv)
								->orderBy('id', 'asc')->get();


		$studs 			= Student::where('class_id', 		$class->id)
									->where('parcour_id', 	$parcour->id)
									->where('yearsUniv', 	$year->yearsUniv)
									->orderBy('id', 'asc')
									->count();

		$Mixt 			= Student::where('grade', 'AL')
									->where('yearsUniv', $year->yearsUniv)
									->orderBy('id', 'asc')
									->count();

		return View::make('backend.admin.pedagogie.Etudiants.lists', compact('etudiants', 'class', 'parcour', 'parcours', 'years', 'libres', 'studs', 'Mixt', 'year'))->with('title', $title)->with('sous', $sous);
	}


//Store Data Students

	public function EtudiantStore($class)
	{
			$inputs 		= Input::all();
			$class   		= TheClass::find($class);
			$years          = Year::where('status', 1)->first();
			$user_id        = Auth::user()->id;
			$validation     = Validator::make($inputs, $this->studentRules);
		   if ($validation->fails()) {
				return Redirect::back()->withInput()->withErrors($validation);
			} 
			else {
			if (Input::hasFile('file')) {
				$date = date('d-M-Y');
				$files = Input::file('file');
				$files_array = array();
				if (count($files_array) > 6) {
				   return Redirect::back()->withInput()->with('error', 'maximum 6 fichiers');
				}
				foreach($files as $file) {
				$path = 'uploads/files_students/'.$date.'/';
				$filename = $file->getClientOriginalName();
				$filename = strtolower($filename);
				$filename = $filename;
				$new_name = $filename;
				$upload_file = $file->move($path, $new_name);
				$files_array[] = 	$new_name;
				}
				$all_files = implode(",", $files_array);
				$students 		    = Student::create([
				'class_id'    		=> $class->id,
				'parcour_id' 		=> e(Input::get('parcour_id')),
				'matricule' 		=> e(Input::get('matricule')),
				'yearsUniv' 		=> e(Input::get('yearsUniv')),
				'fname' 			=> e(Input::get('fname')),
				'lname' 			=> e(Input::get('lname')),
				'birth' 			=> e(Input::get('birth')),
				'birthLocation' 	=> e(Input::get('birthLocation')),
				'address' 			=> e(Input::get('address')),
				'email' 			=> e(Input::get('email')),
				'phone_1' 			=> e(Input::get('phone_1')),
				'phone_2' 			=> e(Input::get('phone_2')),
				]);
			if (Input::get('grade')) {
					$students->grade = 'AL';
				} 
			else { $students->grade = NULL; }
			$fichier        = new Fichier ([
				'jointe'			=> $date . '/' .$all_files,
				]);
			$instances 		= new Instance ([
			    'user_id' 			=> $user_id,
			    'groupe_id' 		=> e(Input::get('groupe_id')),
				'nationality' 		=> e(Input::get('nationality')),
				'promo' 		    => e(Input::get('promo')),
				'sexe' 				=> e(Input::get('sexe')),
				'yearsUniv' 		=> e(Input::get('yearsUniv')),
				'status' 			=> 0,
			]);
			$parents 		= new Parents ([
			    'facebook' 			=> e(Input::get('facebook')),
				'papa' 				=> e(Input::get('papa')),
				'mama' 				=> e(Input::get('mama')),
				'jobpapa' 			=> e(Input::get('jobpapa')),
				'jobmama' 			=> e(Input::get('jobmama')),
				'nametiteur' 		=> e(Input::get('nametiteur')),
				'adresseParent' 	=> e(Input::get('adresseParent')),
				'contactParent' 	=> e(Input::get('contactParent')),
				'ctiteur' 			=> e(Input::get('ctiteur')),
				'adtiteur' 			=> e(Input::get('adtiteur')),
			]);
			$fichier->save();
			}
			else {
				$students 		    = Student::create([
				'class_id'    		=> $class->id,
				'parcour_id' 		=> e(Input::get('parcour_id')),
				'matricule' 		=> e(Input::get('matricule')),
				'yearsUniv' 		=> e(Input::get('yearsUniv')),
				'fname' 			=> e(Input::get('fname')),
				'lname' 			=> e(Input::get('lname')),
				'birth' 			=> e(Input::get('birth')),
				'birthLocation' 	=> e(Input::get('birthLocation')),
				'address' 			=> e(Input::get('address')),
				'email' 			=> e(Input::get('email')),
				'phone_1' 			=> e(Input::get('phone_1')),
				'phone_2' 			=> e(Input::get('phone_2')),
				]);
				
				if (Input::get('grade')) {
					$students->grade = 'AL';
				} else { $students->grade = NULL; }
			}

			$instances = new Instance ([
			    'user_id' 			=> $user_id,
			    'groupe_id' 		=> e(Input::get('groupe_id')),
				'nationality' 		=> e(Input::get('nationality')),
				'promo' 		    => e(Input::get('promo')),
				'sexe' 				=> e(Input::get('sexe')),
				'yearsUniv' 		=> e(Input::get('yearsUniv')),
				'status' 			=> 0,
			]);

			$parents 		= new Parents ([
			    'facebook' 			=> e(Input::get('facebook')),
				'papa' 				=> e(Input::get('papa')),
				'mama' 				=> e(Input::get('mama')),
				'jobpapa' 			=> e(Input::get('jobpapa')),
				'jobmama' 			=> e(Input::get('jobmama')),
				'nametiteur' 		=> e(Input::get('nametiteur')),
				'adresseParent' 	=> e(Input::get('adresseParent')),
				'contactParent' 	=> e(Input::get('contactParent')),
				'ctiteur' 			=> e(Input::get('ctiteur')),
				'adtiteur' 			=> e(Input::get('adtiteur')),
			]);

			$students->save();
			$instances->save();
			$parents->save();
			return Redirect::back()->with('success', 'Etudiant '.$inputs['fname'].' ajouté avec succès!');  
        }
	}
	
//Update Data Students

	public function etudiantEdit($id, $class, $parcour)
	{
		$title 		= 'Modifier';
		$sous       = 'Etudiant';
		$class   	= TheClass::find($class);
		$parcour   	= Parcour::find($parcour);
		$parcours   = Parcour::where('class_id', $class->id)
								->where('status', 1)
								->get();
      
		$classes   = TheClass::where('status', 1)
								->get();
      
      	$groupes   	= Groupe::all();
		$years   	= Year::where('status', 1)->first();

		$student 	= Student::find($id);
		$instances 	= Instance::find($id);
		$parents 	= Parents::find($id);
		return View::make('backend.admin.pedagogie.Etudiants.updateEtudiant', compact('student', 'instances', 'years', 'groupes', 'class', 'parcours', 'classes', 'parcour', 'parents'))->with('title', $title)->with('sous', $sous);

	}

	
	public function updateStudent($id)
	{
		$student 				= Student::find($id);
		$user_id 				= Auth::user()->id;
		$instances 				= Instance::find($id);
		$parents 				= Parents::find($id);

		if ($student !== null) {

				$inputs = Input::all();

				$validation = Validator::make($inputs, ['']);

				if ($validation->fails()) {
						return Redirect::back()->withInput()->withErrors($validation);
					} 

				else {

						$student->fname 		= e($inputs['fname']);
						$student->lname 		= e($inputs['lname']);
						$student->birth 		= e($inputs['birth']);
						$student->birthLocation = e($inputs['birthLocation']);
						$student->parcour_id 	= e($inputs['parcour_id']);
                  		$student->class_id 		= e($inputs['class_id']);
						$student->matricule 	= e($inputs['matricule']);
						$student->email 		= e($inputs['email']);
						$student->phone_1 		= e($inputs['phone_1']);
						$student->phone_2 		= e($inputs['phone_2']);
						$student->address 		= e($inputs['address']);

						$instances->sexe 		= e($inputs['sexe']);
						$instances->nationality = e($inputs['nationality']);
						$instances->user_id 	= Auth::user()->id;
						//$instances->groupe_id 	= e($inputs['groupe_id']);
						
						$parents->facebook 		= e($inputs['facebook']);
						$parents->papa 			= e($inputs['papa']);
						$parents->mama 			= e($inputs['mama']);
						$parents->nametiteur 	= e($inputs['nametiteur']);
						$parents->jobpapa 		= e($inputs['jobpapa']);
						$parents->jobmama 		= e($inputs['jobmama']);
						$parents->contactParent = e($inputs['contactParent']);
						$parents->adresseParent = e($inputs['adresseParent']);

						$parents->ctiteur 		= e($inputs['ctiteur']);
						$parents->adtiteur 		= e($inputs['adtiteur']);


					
						$student->save();
						$instances->save();
						$parents->save();
						return Redirect::back()->withSuccess(('Etudiant '.$inputs['fname'].' a été modifié avec succès!'));
					}

				} else {
					return Redirect::route('indexEtudiant');
				}
	}

	public function uploader_file($id)
	{
		$uploadfile 		= Fichier::find($id);
		$inputs  			= Input::all();
		$validation 		= Validator::make($inputs, ['']); 
		if ($validation->fails()) {
			return Redirect::back()->withInput()->withErrors($validation);
		} else {
			if (Input::hasFile('jointe')) {
				$date = date('d-M-Y');
				$filePrimo = Input::file('jointe');

				$destinationPath = 'uploads/files_students/'.$date.'/';
				$filename = $filePrimo->getClientOriginalName();
				$filename = strtolower($filename);
				$filename = str_ireplace(' ', '_', $filename);
				$filename = round(microtime(true)).'_'. $filename;
				$upload_success = $filePrimo->move($destinationPath, $filename);
				
				$uploadfile->jointe = $date . '/' .$filename;

				$uploadfile->save();

				return Redirect::back()->withSuccess('Fichier a été ajouté avec succès!');
			} 	
		}
	}

	public function otherFile($id)
	{
		$otherfile 	= Fichier::find($id);
		$inputs  	= Input::all();
		$validation = Validator::make($inputs, ['']); 
		if ($validation->fails()) {
			return Redirect::back()->withInput()->withErrors($validation);
		} else {
			if (Input::hasFile('otherFile')) {
				$date = date('d-M-Y');
				// delete old file
				if (!empty($otherfile->otherFile)) {
					unlink(public_path()."/uploads/autre_files_students/".$otherfile->otherFile);
				}
				$fileother = Input::file('otherFile');
				$destinationPath = 'uploads/autre_files_students/'.$date.'/';
				$filename = $fileother->getClientOriginalName();
				$filename = strtolower($filename);
				$filename = str_ireplace(' ', '_', $filename);
				$filename = round(microtime(true)).'_'. $filename;
				$upload_success = $fileother->move($destinationPath, $filename);
				$otherfile->otherFile = $date . '/' .$filename;
				$otherfile->save();

				return Redirect::back()->withSuccess('Autre fichier a été ajouté avec succès!');
			} 	
		}
	}

	
	public function profileEtudiant($class, $parcour, $profile)
	{
		$class   	= TheClass::find($class);
		$parcour 	= Parcour::find($parcour);
		$profile 	= base64_decode(str_pad(strtr($profile, '-_', '+/'), strlen($profile) % 4, '=', STR_PAD_RIGHT));
		$profile 	= Student::find($profile);
		$releves_ones 	= Result::where('id_student',            $profile->id)
										->where('class_id',      $class->id)
										->where('parcour_id',    $parcour->id)
										->where('session', 1)
										->groupBy('id_student')
										->get();

		$releves_tws 	= Result::where('id_student',    		 $profile->id)
										->where('class_id',      $class->id)
										->where('parcour_id',    $parcour->id)
										->where('session', 2)
										->groupBy('id_student')
										->get();

		$annee      	= Year::orderBy('status', 1)->get();
		$years      	= Year::where('status', 1)->first();

		$instance		= Instance::where('id', $profile->id)->first();
		$parent 		= Parents::where('id',  $profile->id)->first();												
		$fichier 		= Fichier::where('id',  $profile->id)->first();
		if ($profile !== null) {
			return View::make('backend.admin.pedagogie.Etudiants.show', compact('instance', 'profile', 'parent', 'fichier' ,'parcour', 'class', 'years', 'annee', 'releves_ones', 'releves_tws'));
		} 
		else {
			return Redirect::route('indexEtudiant');
		}
	}


//PDP
	public function pdpStudent($id)
	{
		$student = Fichier::find($id);
		$inputs  = Input::all();
		$validation = Validator::make($inputs, 
			['image'=>'image',]
		); 

		if ($validation->fails()) {
			return Redirect::back()->withInput()->withErrors($validation);

		} else {

			if (Input::hasFile('image')) {

				// delete old image
				if (!empty($student->image)) {
					unlink(public_path()."/uploads/profiles/students/".$student->image);
				}

				$image = Input::file('image');
		
				$destinationPath = 'uploads/profiles/students/';

				$filename = $image->getClientOriginalName();
				$filename = strtolower($filename);
				$filename = str_ireplace(' ', '_', $filename);
				$filename = round(microtime(true)).'_'. $filename;

				$upload_success = $image->move($destinationPath, $filename);

				$student->image = $filename;
				$student->save();
				return Redirect::back()->withSuccess('Photo de profil a été changé avec succès!');
			} 	
		}
	}


	public function deleteStudent($id)
	{
		$student = Student::find($id);

		if ($student !== null) {

			$absences = Absence::where('id_student', $student->matricule)->get();
			foreach ($absences as $absence) {
				$absence->delete();
			}

			$payments = Pay::where('id_etudiant', $student->id)->get();
			foreach ($payments as $payment) {
				$payment->delete();
			}

			$notes = Note::where('id_student', $student->id)->get();
			foreach ($notes as $note) {
				$note->delete();
			}

			$resultats = Result::where('id_student', $student->id)->get();
			foreach ($resultats as $resultat) {
				$resultat->delete();
			}

			$student->delete();

			$path = Session::get('language');
			return Redirect::back()->with('success', Lang::get($path.'.Deleted_successfully'));

		}

		else {
			return Redirect::back('indexEtudiant');
		}

	}

	public function deletePdp($id)
	{
		$filepdp = Fichier::find($id);
		if ($filepdp !== null) {
			$filepdp->image = NULL;
			$filepdp->save();
			return Redirect::back()->with('success', ('Photo de profil a été supprimé!'));
		}
		else {
			return Redirect::back('indexEtudiant');
		}
	}

	public function supfile($id)
	{
		$supfile = Fichier::find($id);
		if ($supfile !== null) {
			$supfile->jointe = NULL;
			$supfile->save();
			return Redirect::back()->with('success', ('Fichier a été supprimé!'));
		}
		else {
			return Redirect::back('indexEtudiant');
		}
	}

	public function supotherfile($id)
	{
		$supother = Fichier::find($id);
		if ($supother !== null) {
			$supother->otherFile = NULL;
			$supother->save();
			return Redirect::back()->with('success', ('Autre fichier a été supprimé!'));
		}
		else {
			return Redirect::back('indexEtudiant');
		}
	}
}