<?php

class Session2Controller extends BaseController {

	public function theSession($class, $parcour)
	{
		$title 			 	= 'Semestre';
		$sous            	= '2e session';
		$ui         	 	= 'Notes';
		$class   			= TheClass::find($class);
		$year    			= Year::where('status', 1)->first();
		$parcour 			= Parcour::find($parcour);
		
		$semestres 		 	= Sem::where('status', 1)->get();

		return View::make('backend.admin.notes.2session.thesemestre', compact('thesemestres', 'parcours', 'class', 'ues', 'year', 'semestres'))->with('title', $title)->with('sous', $sous)->with('ui', $ui);
	}


	public function repesage_1($class, $parcour)
	{
		$title 	 = 'Etudiants en 2e session | Semestre';
		$sous    = 'Semestre';
		$ui      = 'Notes';
		//$semestre   = Sem::find($semestre);
		$class   = TheClass::find($class);
		$year    = Year::where('status', 1)->first();
		$parcour = Parcour::find($parcour);

		$moyenneSem     = Credit::where('semestre', 1)
								 ->where('session', 1)
								 ->where('class_id',   $class->id)
								 ->where('parcour_id', $parcour->id)
								 ->where('yearsUniv',  $year->yearsUniv)
								 ->sum('Noteponder');

		$coef   		= Credit::where('semestre', 1)
								->where('session', 1)
                                ->where('class_id',   $class->id)
								->where('parcour_id', $parcour->id)
								->where('yearsUniv',  $year->yearsUniv)
                                ->sum('coef');

		$semestre_1     =  ($moyenneSem/$coef);   

		$semestreOne 	= Delibera::where('semestre', 1)
								 //->where('session', 1)
								 ->where('class_id',   $class->id)
								 ->where('parcour_id', $parcour->id)
								 ->where('yearsUniv',  $year->yearsUniv)
								 ->orderBy('id', 'asc')
								 ->get();

		$notes 	 		= Result::where('admis', 0)
								 ->where('class_id', $class->id)
								 ->where('parcour_id', $parcour->id)
								 ->where('yearsUniv', $year->yearsUniv)
								 ->where('session', 1)
								 ->groupBy('id_student')
								 ->orderBy('id', 'desc')
								 ->get();				 
		

		return View::make('backend.admin.notes.2session.etudiants_1', compact('class', 'parcour', 'notes', 'year', 'dsexist', 'semestreOne', 'semestre_1', 'moyenneSem', 'semestre'))->with('title', $title)->with('sous', $sous)->with('ui', $ui);
	}



public function selectSession1($class, $parcour, $student)
	{
		$title 			= 'Liste des matières en';
		$sous    		= 'par étudiant';
		$ui         	= 'Notes';
		$class 			= TheClass::find($class);
		$parcour 		= Parcour::find($parcour);
		$parcours 		= Parcour::where('status', 1)->where('class_id', $class->id)->get();
		$years 			= Year::where('status', 1)->first();

		$student 	 	= base64_decode(str_pad(strtr($student, '-_', '+/'), strlen($student) % 4, '=', STR_PAD_RIGHT));
		$student 		= Student::find($student);

		$ues_1        	= Credit::where('class_id', 				$class->id)
										    ->where('id_student', 	$student->id)
										    ->where('parcour_id', 	$parcour->id)
										    ->where('semestre', 1)
										    ->where('session', 1)
										    ->groupBy('codeUe')
										    ->orderBy('id', 'asc')
										    ->get();	

		$noteStuds      = Credit::where('yearsUniv', 		       $years->yearsUniv)
				                         	 ->where('class_id',   $class->id)
				                         	 ->where('parcour_id', $parcour->id)
				                         	 ->where('id_student', $student->id)
				                         	 ->where('semestre', 1)
				                         	 ->where('session', 1)
				                         	 ->get();     								    

		$dsexist     	= Credit::where('session', 2)
											->where('semestre', 1)
		                                     ->where('class_id', 	$class->id)
		                                     ->where('parcour_id', 	$parcour->id)
		                                     ->where('yearsUniv', 	$years->yearsUniv)
		                                     ->where('id_student', 	$student->id)
		                                     ->count(); 

		$students 	 	= Delibera::where('semestre', 1)
											 ->where('class_id', 			$class->id)
											 ->where('parcour_id', 			$parcour->id)
											 ->where('yearsUniv', 			$years->yearsUniv)
											 ->where('session', 1)
											 ->where('id_student', '!=', 	$student->id)
											 ->groupBy('id_student')
											 ->orderBy('id', 'desc')
											 ->get();

		$matieresNotes 	= Note::where('class_id', 						$class->id)
											->where('parcour_id', 			$parcour->id)
											->where('id_student', 			$student->id)
											->where('yearsUniv', 			$years->yearsUniv)
											->orderBy('codeUe', 'asc')
											->get();

		
		return View::make('backend.admin.notes.2session.checks_1', compact('class', 'parcour', 'note', 'students', 'elements', 'parcours', 'years', 'semestres', 'ues_1', 'matieresNotes', 'student', 'CoefPondere', 'notes', 'noteStuds', 'dsexist', 'addNotestuds'))->with('title', $title)->with('sous', $sous)->with('ui', $ui);															
	}



	public function repesage_2($class, $parcour)
	{
		$title 	 = 'Etudiants en 2e session | Semestre';
		$sous    = 'Semestre';
		$ui      = 'Notes';
		//$semestre   = Sem::find($semestre);
		$class   = TheClass::find($class);
		$year    = Year::where('status', 1)->first();
		$parcour = Parcour::find($parcour);

		$moyenneSem      = Credit::where('semestre', 2)
								 ->where('session', 1)
								 ->where('class_id',   $class->id)
								 ->where('parcour_id', $parcour->id)
								 ->where('yearsUniv',  $year->yearsUniv)
								 ->sum('Noteponder');

		$coef   		= Credit::where('semestre', 2)
								->where('session', 1)
                                ->where('class_id',   $class->id)
								->where('parcour_id', $parcour->id)
								->where('yearsUniv',  $year->yearsUniv)
                                ->sum('coef');

		$semestre_2     =  ($moyenneSem/$coef);   

		$semestreTwo 	= Delibera::where('semestre', 2)
								 //->where('session', 1)
								 ->where('class_id',   $class->id)
								 ->where('parcour_id', $parcour->id)
								 ->where('yearsUniv',  $year->yearsUniv)
								 ->orderBy('id', 'asc')
								 ->get();

		$notes 	 		= Result::where('admis', 0)
								 ->where('class_id', $class->id)
								 ->where('parcour_id', $parcour->id)
								 ->where('yearsUniv', $year->yearsUniv)
								 ->where('session', 1)
								 ->groupBy('id_student')
								 ->orderBy('id', 'desc')
								 ->get();				 
		

		return View::make('backend.admin.notes.2session.etudiants_2', compact('class', 'parcour', 'notes', 'year', 'dsexist', 'semestreTwo', 'semestre_2', 'moyenneSem', 'semestre'))->with('title', $title)->with('sous', $sous)->with('ui', $ui);
	}

public function selectSession2($class, $parcour, $student)
	{
		$title 			= 'Liste des matières en';
		$sous    		= 'par étudiant';
		$ui         	= 'Notes';
		$class 			= TheClass::find($class);
		$parcour 		= Parcour::find($parcour);
		$parcours 		= Parcour::where('status', 1)->where('class_id', $class->id)->get();
		$years 			= Year::where('status', 1)->first();

		$student 	 	= base64_decode(str_pad(strtr($student, '-_', '+/'), strlen($student) % 4, '=', STR_PAD_RIGHT));
		$student 		= Student::find($student);
									
		$ues_2        	= Credit::where('class_id', 				$class->id)
										    ->where('id_student', 	$student->id)
										    ->where('parcour_id', 	$parcour->id)
										    ->where('semestre', 2)
										    ->where('session', 1)
										    ->groupBy('codeUe')
										    ->orderBy('id', 'asc')
										    ->get();	
										    								    
		$dsexist     	= Credit::where('session', 2)
		                                     ->where('class_id', 	$class->id)
		                                     ->where('parcour_id', 	$parcour->id)
		                                     ->where('yearsUniv', 	$years->yearsUniv)
		                                     ->where('id_student', 	$student->id)
		                                     ->count();

		$students 	 	= Delibera::where('semestre', 2)
											 ->where('class_id', 			$class->id)
											 ->where('parcour_id', 			$parcour->id)
											 ->where('yearsUniv', 			$years->yearsUniv)
											 ->where('session', 1)
											 ->where('id_student', '!=', 	$student->id)
											 ->groupBy('id_student')
											 ->orderBy('id', 'desc')
											 ->get();

		$matieresNotes 	= Note::where('class_id', 						$class->id)
											->where('parcour_id', 			$parcour->id)
											->where('id_student', 			$student->id)
											->where('yearsUniv', 			$years->yearsUniv)
											->orderBy('codeUe', 'asc')
											->get();

		$noteStuds      = Credit::where('yearsUniv', 		   $years->yearsUniv)
				                         	 ->where('class_id',   $class->id)
				                         	 ->where('parcour_id', $parcour->id)
				                         	 ->where('id_student', $student->id)
				                         	 ->where('semestre', 2)
				                         	 ->where('session', 1)
				                         	 ->orderBy('id', 'asc')
				                         	 ->get();     

		return View::make('backend.admin.notes.2session.checks_2', compact('class', 'parcour', 'note', 'students', 'elements', 'parcours', 'years', 'semestres', 'ues_2', 'matieresNotes', 'student', 'CoefPondere', 'notes', 'noteStuds', 'dsexist', 'addNotestuds'))->with('title', $title)->with('sous', $sous)->with('ui', $ui);															
	}
	public function addNoteSession_1($class, $parcour, $student, $id)
	{
		$title 			= 'Ajouter note semestre 1 |';
		$sous    		= 'par étudiant et matière';
		$ui         	= 'Notes';
		$class 			= TheClass::find($class);
		$parcour 		= Parcour::find($parcour);
		$parcours 		= Parcour::where('status', 1)->where('class_id', $class->id)->get();
		$years 			= Year::where('status', 1)->first();

		//$note 	 		= base64_decode(str_pad(strtr($note, '-_', '+/'), strlen($note) % 4, '=', STR_PAD_RIGHT));
		$note 			= Note::find($id);

		$student 	 	= base64_decode(str_pad(strtr($student, '-_', '+/'), strlen($student) % 4, '=', STR_PAD_RIGHT));
		$student 		= Student::find($student);

		$elements 		= EC::where('tronc', 0)->where('status', 1)
											->where('class_id', $class->id)
											->where('parcour_id', $parcour->id)
											//->where('id', '!=', $note->element_id)
											->get();

		$ues   			= UE::where('tronc', 0)->where('status', 1)
											->where('class_id', $class->id)
											->where('parcour_id', $parcour->id)
											//->where('codeUe', $note->codeUe)
											->first();

		$students   	= Student::where('class_id', $class->id)
											  ->where('parcour_id', $parcour->id)
											  ->where('yearsUniv', $years->yearsUniv)
						                      ->get();

		$matieres 		= Note::where('class_id', $class->id)
											->where('parcour_id', $parcour->id)
											->where('id_student', $student->id)
											///->where('id', 		  $note->id)
											->where('yearsUniv',  $years->yearsUniv)
											//->where('noteExam', '<=', 9.99)
											->get();
														
		return View::make('backend.admin.notes.2session.ajoutNote_1', compact('class', 'parcour', 'note', 'students', 'elements', 'parcours', 'years', 'semestres', 'ues', 'matieres', 'student'))->with('title', $title)->with('sous', $sous)->with('ui', $ui);															
	}
	
	public function submitSession_1($class, $parcour, $student, $id)
	{
		$class 			= TheClass::find($class);
		$parcour 		= Parcour::find($parcour);
		$student 	 	= base64_decode(str_pad(strtr($student, '-_', '+/'), strlen($student) % 4, '=', STR_PAD_RIGHT));
		$student 		= Student::find($student);

		$input = Input::all();
		$validation = Validator::make($input, ['noteExam'=>'required']);
		if($validation->fails()) {
			return Redirect::back()->withInput()->withErrors($validation);
		}
		else {
				$session2 				= Note::find($id);

				$session2->user_id 		= Auth::id();
				$session2->noteExam 	= e($input['noteExam']);
				$session2->session 	    = 2;
				$session2->status 	    = 2;
                $session2->save();
			    
              return Redirect::to('/admin/notes/etudiants/notes/ajouter-1-session/'.$class->id.'/'.$parcour->id.'/1/'.rtrim(strtr(base64_encode($student->id), '+/', '-_'), '='))->withSuccess('Le note 2e session a été ajouté avec succès!');
		}
	}

	///+++++++================================+++++++++++
	public function addNoteSession_2($class, $parcour, $student, $id)
	{
		$title 			= 'Ajouter note semestre 2 |';
		$sous    		= 'par étudiant et matière';
		$ui         	= 'Notes';
		$class 			= TheClass::find($class);
		$parcour 		= Parcour::find($parcour);
		$parcours 		= Parcour::where('status', 1)->where('class_id', $class->id)->get();
		$years 			= Year::where('status', 1)->first();

		//$note 	 		= base64_decode(str_pad(strtr($note, '-_', '+/'), strlen($note) % 4, '=', STR_PAD_RIGHT));
		$note 			= Note::find($id);

		$student 	 	= base64_decode(str_pad(strtr($student, '-_', '+/'), strlen($student) % 4, '=', STR_PAD_RIGHT));
		$student 		= Student::find($student);

		$elements 		= EC::where('tronc', 0)->where('status', 1)
											->where('class_id', $class->id)
											->where('parcour_id', $parcour->id)
											//->where('id', '!=', $note->element_id)
											->get();

		$ues   			= UE::where('tronc', 0)->where('status', 1)
											->where('class_id', $class->id)
											->where('parcour_id', $parcour->id)
											//->where('codeUe', $note->codeUe)
											->first();

		$students   	= Student::where('class_id', $class->id)
											  ->where('parcour_id', $parcour->id)
											  ->where('yearsUniv', $years->yearsUniv)
						                      ->get();

		$matieres 		= Note::where('class_id', $class->id)
											->where('parcour_id', $parcour->id)
											->where('id_student', $student->id)
											///->where('id', 		  $note->id)
											->where('yearsUniv',  $years->yearsUniv)
											//->where('noteExam', '<=', 9.99)
											->get();
														
		return View::make('backend.admin.notes.2session.ajoutNote_2', compact('class', 'parcour', 'note', 'students', 'elements', 'parcours', 'years', 'semestres', 'ues', 'matieres', 'student'))->with('title', $title)->with('sous', $sous)->with('ui', $ui);															
	}

	public function submitSession_2($class, $parcour, $student, $id)
	{
		$class 			= TheClass::find($class);
		$parcour 		= Parcour::find($parcour);
		$student 	 	= base64_decode(str_pad(strtr($student, '-_', '+/'), strlen($student) % 4, '=', STR_PAD_RIGHT));
		$student 		= Student::find($student);

		$input = Input::all();
		$validation = Validator::make($input, ['noteExam'=>'required']);
		if($validation->fails()) {
			return Redirect::back()->withInput()->withErrors($validation);
		}
		else {
				$session2 				= Note::find($id);

				$session2->user_id 		= Auth::id();
				$session2->noteExam 	= e($input['noteExam']);
				$session2->session 	    = 2;
				$session2->status 	    = 2;
                $session2->save();
			    
              return Redirect::to('/admin/notes/etudiants/notes/ajouter-2-session/'.$class->id.'/'.$parcour->id.'/2/'.rtrim(strtr(base64_encode($student->id), '+/', '-_'), '='))->withSuccess('Le note 2e session a été ajouté avec succès!');
		}
	}

	
	public function resultat2Session_1($class, $parcour)
	{
		$input = Input::all();
		$validation = Validator::make($input, []);
		if($validation->fails()) {
			return Redirect::back()->withInput()->withErrors($validation);
		}
		else {

			$clas  		= $input['class_id'];
			$par   		= $input['parcour_id'];
			$years  	= $input['yearsUniv'];
			$ue   		= $input['codeUe'];
			$ec   		= $input['codeEc'];
			$noteec   	= $input['NoteEc'];
			$coefs   	= $input['coef'];
			$totale   	= $input['Noteponder'];

			foreach ($input['id_student'] as $i => $id)
			{
				$result = new Credit();
				$result->id_student 	= $id;
				//$result->grade 			= $al[$i];
				$result->class_id 		= $clas[$i];
				$result->parcour_id 	= $par[$i];
				$result->yearsUniv 		= $years[$i];
				$result->semestre       = 1;
				$result->session        = 2;
				$result->status         = 1;
				$result->codeUe 		= $ue[$i];
				$result->codeEc 		= $ec[$i];
				$result->NoteEc 		= $noteec[$i];
				$result->coef 			= $coefs[$i];
				$result->Noteponder 	= $totale[$i];
                $result->save();
			}

			return Redirect::to('/admin/notes/2e_session/'.$class.'/'.$parcour.'/1')->withSuccess('Résultats 2e Session S1 a été ajouté!');
		}
	}

	public function resultat2Session_2($class, $parcour)
	{
		$input = Input::all();
		$validation = Validator::make($input, []);
		if($validation->fails()) {
			return Redirect::back()->withInput()->withErrors($validation);
		}
		else {

			$clas  		= $input['class_id'];
			$par   		= $input['parcour_id'];
			$years  	= $input['yearsUniv'];
			$ue   		= $input['codeUe'];
			$ec   		= $input['codeEc'];
			$noteec   	= $input['NoteEc'];
			$coefs   	= $input['coef'];
			$totale   	= $input['Noteponder'];

			foreach ($input['id_student'] as $i => $id)
			{
				$result = new Credit();
				$result->id_student 	= $id;
				//$result->grade 			= $al[$i];
				$result->class_id 		= $clas[$i];
				$result->parcour_id 	= $par[$i];
				$result->yearsUniv 		= $years[$i];
				$result->semestre       = 2;
				$result->session        = 2;
				$result->status         = 1;
				$result->codeUe 		= $ue[$i];
				$result->codeEc 		= $ec[$i];
				$result->NoteEc 		= $noteec[$i];
				$result->coef 			= $coefs[$i];
				$result->Noteponder 	= $totale[$i];
                $result->save();
			}

			return Redirect::to('/admin/notes/2e_session/'.$class.'/'.$parcour.'/2')->withSuccess('Résultats 2e Session - S2 a été ajouté!');
		}
	}

	//Generate Result FINAL
	public function submit2sessionfinal($class, $parcour)
	{
		$input = Input::all();
		$validation = Validator::make($input, []);
		if($validation->fails()) {
			return Redirect::back()->withInput()->withErrors($validation);
		}
		else {

			$al    = $input['grade'];
			$par   = $input['parcour_id'];
			$year  = $input['yearsUniv'];
			$clas  = $input['class_id'];
			$moy   = $input['moyenne'];
			$som   = $input['somme'];
			$delib = $input['deliberation'];

			foreach ($input['id_student'] as $i => $done)
			{
				$result = new Delibera();
			
				$result->deliberation 	    	= $delib[$i];
				$result->id_student 			= $done;
				$result->grade 					= $al[$i];
				$result->parcour_id 			= $par[$i];
				$result->yearsUniv 				= $year[$i];
				$result->class_id 				= $clas[$i];
				$result->moyenne 				= $moy[$i];
				$result->somme 					= $som[$i];
				$result->semestre        		= 3;
				$result->session        		= 2;
				$result->status         		= 1;

                $result->save();
			}

			return Redirect::to('/admin/resultats_examen/session_2/vérification/'.$class.'/'.$parcour)->withSuccess('Liste des admis en 2em Session sur cette année!');
		}
	}

	public function supprimer2($class, $parcour)
	{
		$supprimers = Delibera::where('semestre', 3)
								->where('session', 2)
								->get();
			foreach ($supprimers as $supprimer) 
			{
				$supprimer->delete();
		}

		return Redirect::to('/admin/resultats_examen/'.$class.'/'.$parcour)->withWarning('Vous avez réinitialisé votre résulats 2ème Session!');
	
}
	public function checkSession2($class, $parcour)
	{
		$title 			 	= 'Vérification 2ème Session';
		$year 			 	= Year::where('status', 1)->first();
		$class   		 	= TheClass::find($class);
		$parcour 		 	= Parcour::find($parcour);
		$classes         	= TheClass::all();

		$checks     		= Delibera::where('yearsUniv', 	    $year->yearsUniv)
			                         	 ->where('class_id', 	$class->id)
			                         	 ->where('parcour_id', 	$parcour->id)
			                         	 ->where('semestre', 3)
			                         	 ->where('session', 2)
			                         	 ->where('status', 1)
			                         	 ->groupBy('id_student')
			                         	 ->orderBy('id', 'asc')
			                         	 ->get(); 

		return View::make('backend.admin.notes.2session.checkresult', compact('year', 'class', 'parcour', 'checks'))->with('title', $title);
	}

	public function activateS2($class, $parcour)
	{
		$title 			 	= 'Déliberation 2ème Session';
		$sous            	= 'déliberation';
		$year 			 	= Year::where('status', 1)->first();
		$class   		 	= TheClass::find($class);
		$parcour 		 	= Parcour::find($parcour);

		$delibers     		= Delibera::where('yearsUniv', 	    $year->yearsUniv)
			                         	 ->where('class_id', 	$class->id)
			                         	 ->where('parcour_id', 	$parcour->id)
			                         	 ->where('session', 2)
			                         	 ->where('semestre', 3)
			                         	 ->where('status', 1)
			                         	 ->groupBy('id_student')
			                         	 ->get(); 

		

		$students 	 		= Delibera::where('session', 2)
			                    ->where('semestre', 3)
			                    ->where('status', 1)
			        			->where('parcour_id', 	$parcour->id)
			        			->where('class_id', 	$class->id)
			        			->groupBy('id_student')
			        			->where('yearsUniv',    $year->yearsUniv)
			        			->get();

		return View::make('backend.admin.notes.2session.activate', compact('var_1','year', 'class', 'delibers', 'parcour', 'students'))->with('title', $title)->with('sous', $sous);
	}


	public function valid2session($class, $parcour)
	{
		$input = Input::all();
		$validation = Validator::make($input, []);
		if($validation->fails()) {
			return Redirect::back()->withInput()->withErrors($validation);
		}
		else {
				$al    		= $input['grade'];
				$par   		= $input['parcour_id'];
				$year  		= $input['yearsUniv'];
				$clas  		= $input['class_id'];
				$moy   		= $input['moyenne'];
				$som   		= $input['somme'];
				$admis 		= $input['admis'];
				$pay 		= $input['moisPayed'];

			foreach ($input['id_student'] as $i => $done)
			{
				$result = new Result();
			
				$result->admis 	    	= $admis[$i];
				$result->id_student 	= $done;
				$result->grade 			= $al[$i];
				$result->parcour_id 	= $par[$i];
				$result->yearsUniv 		= $year[$i];
				$result->class_id 		= $clas[$i];
				$result->moyenne 		= $moy[$i];
				$result->somme 			= $som[$i];
				$result->moisPayed 		= $pay[$i];
				$result->session       	= 2;
				$result->status         = 1;

                $result->save();
			}

			return Redirect::to('/admin/resultats_examen/session_2e/officiel/'.$class.'/'.$parcour)->withSuccess('Les résultats officiel a été confirmé!');
		}
	}


	public function fetchresultS2($class, $parcour)
	{
		$title 			 	= 'Résultats des examens 2em session';
		$year 			 	= Year::where('status', 1)->first();
		$class   		 	= TheClass::find($class);
		$parcour 		 	= Parcour::find($parcour);

		$officials 			= Result::orderBy('admis', 'desc')
										->where('yearsUniv', $year->yearsUniv)
										//->where('admis', 1)
										->where('status', 1)
										->where('session', 2)
										->groupBy('id_student')
										->get();

		$admis              = Result::where('admis', 1)
										->where('session', 2)
										->where('status', 1)->count();

		$nonadmis           = Result::where('admis', 0)
										->where('session', 2)
										->where('status', 1)->count();

		$ifhaofficial 		= Result::where('status', 1)
			        					->where('yearsUniv', $year->yearsUniv)
			        					->where('session', 2)
			        					->count();

		$classes         	= TheClass::all();

		return View::make('backend.admin.notes.2session.admis', compact('officials', 'rank', 'year', 'class', 'admis', 'nonadmis', 'ifhaofficial', 'parcour'))->with('title', $title);
	}

	public function delete_resultS2($class, $parcour)
	{
		$restores1 = Result::where('session', 2)->get();
				foreach ($restores1 as $restore1) {
						$restore1->delete();
				}
		$delete_S1 = Delibera::where('semestre', 3)->where('session', 2)->get();
				foreach ($delete_S1 as $del_1) {
					$del_1->delete();
				}
		return Redirect::to('/admin/resultats_examen/'.$class.'/'.$parcour)->withWarning('Vous avez réinitialisé votre résultats 2ème Session!');
	}


		public function releve_notes2($class, $parcour, $student)
	{
		$title 			= 'Relevé de notes 1er Semestre';
		$sous           = 'Relevé de notes';
		$ui             = 'Relevé de notes';
		$class   		= TheClass::find($class);
		$parcour   		= Parcour::find($parcour);
		$years          = Year::where('status', 1)->first();
		$student 		= base64_decode(str_pad(strtr($student, '-_', '+/'), strlen($student) % 4, '=', STR_PAD_RIGHT));
		$student 		= Student::find($student);
		
		$valMoyene      = Credit::where('id_student', $student->id)
									->where('class_id', $class->id)
									->where('parcour_id', $parcour->id)
								   	->where('yearsUniv', $years->yearsUniv)
								   	->where('semestre', 1)
								   	->where('session', 1)
								   	->sum('Noteponder');
		$var1 = $valMoyene/30;						
		
	if($var1 >= 10)
	{
		$releves_s1     = Credit::where('class_id', 	  $class->id)
								    ->where('id_student', $student->id)
								    ->where('session', 1)
								    ->where('semestre', 1)
								    ->where('status', 1)
								    ->groupBy('codeUe')
								    ->get();
	}else{

		  $releves_s1     = Credit::where('class_id', 	  $class->id)
								    ->where('id_student', $student->id)
								    ->where('session', 2)
								    ->where('semestre', 1)
								    ->where('status', 1)
								    ->groupBy('codeUe')
								    ->get();
	}

	 	$valMoyene2      = Credit::where('id_student', $student->id)
									->where('class_id', $class->id)
									->where('parcour_id', $parcour->id)
								   	->where('yearsUniv', $years->yearsUniv)
								   	->where('semestre', 2)
								   	->where('session', 1)
								   	->sum('Noteponder');
		$var2 = $valMoyene2/30;

		if($var2 >= 10) {	
			$releves_s2     = Credit::where('class_id', $student->class_id)
								    ->where('id_student', $student->id)
								    ->where('session', 1)
								    ->where('semestre', 2)
								    ->groupBy('codeUe')
								    ->get();						    
		}else{
			$releves_s2     = Credit::where('class_id', $student->class_id)
								    ->where('id_student', $student->id)
								    ->where('session', 2)
								    ->where('semestre', 2)
								    ->groupBy('codeUe')
								    ->get();
		}	

		$noteSem        = Sem::where('status', 1)->first();

		$valid 			= Result::where('admis', 1)
		                            ->where('session', 2)
		                            ->where('class_id', $class->id)
		                            ->where('parcour_id', $parcour->id)
		                            ->where('id_student', $student->id)
		                            ->count();

		$tests_1         = Delibera::where('class_id',           $class->id)
	                                ->where('parcour_id',        $parcour->id)
	                                ->where('id_student',        $student->id)
	                                ->where('session', 2)
	                                ->where('semestre', 3)
	                                ->groupBy('id_student')
	                                ->first();

         $var            = $tests_1->deliberation;

		if ($student !== null) {
			return View::make('backend.admin.notes.2session.releveNote', compact('releves_s1', 'releves_s2', 'student', 'class', 'var1', 'mention', 'years', 'var', 'parcour', 'valid'))->with('title', $title)->with('sous', $sous)->with('ui', $ui);
		} 
		else {
			return Redirect::route('indexReleve');
		}
	}

	public function affichageAdmis2($class, $parcour)
	{
		$class   		= TheClass::find($class);
		$years          = Year::where('status', 1)->first();
		$parcour 		= Parcour::find($parcour);
		
		$affichages     = Result::where('session', 2)
								->where('class_id',    $class->id)
								->where('parcour_id',  $parcour->id)
							   	->where('yearsUniv',   $years->yearsUniv)
							   	->where('admis', 1)
							   	->where('status', 1)
							   	->orderBy('admis', 'desc')
							   	->groupBy('id_student')
							   	->get();

		return View::make('backend.admin.notes.2session.affichageAdmis', compact('parcour', 'class', 'years', 'affichages'));
	}

	public function affichageNoAdmis2($class, $parcour)
	{
		$class   		= TheClass::find($class);
		$years          = Year::where('status', 1)->first();
		$parcour 		= Parcour::find($parcour);
		
		$affichages     = Result::where('session', 2)
								->where('class_id',    $class->id)
								->where('parcour_id',  $parcour->id)
							   	->where('yearsUniv',   $years->yearsUniv)
							   	->where('admis', 0)
							   	->where('status', 1)
							   	->orderBy('admis', 'desc')
							   	->groupBy('id_student')
							   	->get();

		return View::make('backend.admin.notes.2session.affichageNoadmis', compact('parcour', 'class', 'years', 'affichages'));
	}


	public function sendExam2($class, $parcour)
	{
		$class   		 = TheClass::find($class);
		$parcour   		 = Parcour::find($parcour);
		//$student   		 = Student::find($student);
		$input 			 = Input::all();

		$resultats       = Result::where('class_id', 		 $class->id)
									  ->where('parcour_id',  $parcour->id)
									  //->where('id_student',  $student->id)
									  ->where('admis', 1)
									  ->where('session', 2)
									  ->where('moisPayed', '==', 0)
									  ->get();

		$session  		  = Result::where('session', 2)->first();							  

        /*Mail::send('emails.exam', array('etudiants' => $etudiants, 'notes' => $notes), function ($message) use ($etudiants, $notes) {
                $message->from('POS@gmail.com', 'POS');
                $message->subject('Notification Mail');
                foreach ($etudiants as $mail) {
                    $message->to($mail->email);
                }    
            });*/
            
        $noteSem  = Sem::where('status', 1)->get();    
		foreach ($input['email'] as $email)			
        $resultats->email = $email;
		Mail::send('emails.result', compact('resultats', 'class', 'parcour', 'noteSem', 'student', 'session'), function($message){
		$message->to(Input::get('email'))
				->subject('Résultats des examens - ESIGE');
		});

		return Redirect::back()->with('success', ('Résultats envoyer par email avec succès!'));
	}

}