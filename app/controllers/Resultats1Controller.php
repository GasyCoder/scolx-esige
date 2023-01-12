<?php
class Resultats1Controller extends BaseController {

	public function __construct(Student $student)
	{
	        $this->student = $student;
	}

	public function session_1() {

		$title 		= 'Résultats des examens';
		$sous       = 'Liste des classes';
		$ui         = 'Résultats';
		$parcours  	= Parcour::where('status', 1)->orderBy('id', 'asc')->paginate(10);
		$classes  	= TheClass::all();
		$etudiants 	= Student::all();
		$year       = Year::where('status', 1)->first();
		$kilasy  	= TheClass::where('id', 1)->first();

		return View::make('backend.admin.notes.result.index', compact('kilasy', 'classes', 'etudiants', 'parcours', 'year'))->with('title', $title)->with('sous', $sous)->with('ui', $ui);
	}


	public function byParcour($class)
	{
		$title 			 = 'Résultats des examens';
		$sous            = 'Résultats des examens';
		$ui         	 = 'Notes';
		$class   		 = TheClass::find($class);
		$parcours 		 = Parcour::where('class_id', $class->id)->where('status', 1)->get();
		$year            = Year::where('status', 1)->first();
		$elements 		 = EC::where('class_id', $class->id)->where('status', 1)->get();
		
		return View::make('backend.admin.notes.result.parcours', compact('elements','parcours', 'class', 'ues', 'year'))->with('title', $title)->with('sous', $sous)->with('ui', $ui);
	}

	public function selectresult($class, $parcour)
	{
		$title 			 	= 'Traitements des résultats d\'examens';
		$sous            	= 'Résultats des examens';
		$ui         	 	= 'Notes';
		$class   		 	= TheClass::find($class);
		$parcour 		 	= Parcour::find($parcour);
		$year            	= Year::where('status', 1)->first();
		$elements 		 	= EC::where('class_id', $class->id)->where('status', 1)->get();

		$students 		 	= Student::where('class_id',    $class->id)
									  ->where('parcour_id', $parcour->id)
									  ->where('yearsUniv', 	$year->yearsUniv) 
									  ->get();

	    $notes_1      	 	= Note::where('yearsUniv', 		$year->yearsUniv)
	                         	 	->where('class_id', 	$class->id)
	                         	 	->where('parcour_id', 	$parcour->id)
	                         	 	->where('semestre', 1)
	                         	 	->where('session', 1)
	                         	 	->where('status', 1)
	                         	 	//->orderBy('id', 'asc')
	                         	 	//->groupBy('codeEc')
	                         	 	->get(); 

	    $ponders      	 	= Note::where('yearsUniv', $year->yearsUniv)
	                         	 	->where('class_id', $class->id)
	                         	 	->where('parcour_id', $parcour->id)
	                         	 	->where('semestre', 1)
	                         	 	->where('session', 1)
	                         	 	->groupBy('codeUe')
	                         	 	->count();                      	 	                 	 	                     	 
        $s1existe 	 		= Credit::where('status', 1)
			        			->where('semestre', 1)
			        			->where('session', 1)
			        			->where('yearsUniv', $year->yearsUniv)
			        			->count();

		$existeS1     		= Delibera::where('yearsUniv',  $year->yearsUniv)
	                         	 ->where('class_id',    $class->id)
	                         	 ->where('parcour_id',  $parcour->id)
	                         	 ->where('session', 1)
	                         	 ->where('semestre', 1)
	                         	 ->count(); 	        			

        $admisession_1 	 	= Result::where('admis', 1)
	        					->where('yearsUniv', $year->yearsUniv)
	        					->count();

	    $notes_2      	 	= Note::where('yearsUniv', $year->yearsUniv)
	                         	 ->where('class_id', $class->id)
	                         	 ->where('parcour_id', $parcour->id)
	                         	 ->where('semestre', 2)
	                         	 //->groupBy('codeEc')
	                         	 ->get();  

		$resultats     	= Delibera::where('yearsUniv',  $year->yearsUniv)
	                         	 ->where('class_id',    $class->id)
	                         	 ->where('parcour_id',  $parcour->id)
	                         	 ->where('session', 1)
	                         	 ->groupBy('id_student')
	                         	 ->get();

	    $existeS2     	= Delibera::where('yearsUniv',  $year->yearsUniv)
	                         	 ->where('class_id',    $class->id)
	                         	 ->where('parcour_id',  $parcour->id)
	                         	 ->where('session', 1)
	                         	 ->where('semestre', 2)
	                         	 ->count(); 

	    $s2existe 	 		= Credit::where('status', 1)
	    						->where('semestre', 2)
	    						->where('session', 1)
			        			->where('yearsUniv', $year->yearsUniv)
			        			->count();                      	                     	  

	    $checkvalid     	= Credit::where('yearsUniv', $year->yearsUniv)
		                         	 ->where('class_id', $class->id)
		                         	 ->where('parcour_id', $parcour->id)
		                         	 ->where('session', 2)
		                         	 ->where('semestre', 1)
		                         	 ->where('status', 1)
		                         	 ->groupBy('id_student')
		                         	 ->get();                     	 

		$resultat_existe 	= Result::where('status', 1)
				        			->where('session', 1)
				        			->where('yearsUniv', $year->yearsUniv)
				        			->count();

	    //Traitement 2e session

		$deuxieme_sessions     	= Credit::where('yearsUniv', $year->yearsUniv)
		                         	 ->where('class_id', 	 $class->id)
		                         	 ->where('parcour_id',   $parcour->id)
		                         	 ->where('session', 2)
		                         	 ->where('semestre', 1)
		                         	 ->where('status', 1)
		                         	 ->groupBy('id_student')
		                         	 ->get();
		
		$session2_existe 	= Delibera::where('session', 2)
				        			->where('yearsUniv', $year->yearsUniv)
				        			->count();	

		$session_2 	 		= Credit::where('status', 1)
				        			->where('session', 2)
				        			->where('semestre', 1)
			        				->where('yearsUniv', $year->yearsUniv)
			        				->count(); 	

		return View::make('backend.admin.notes.result.selects', compact('elements','parcour', 'class', 'session2_existe', 'year', 'myNote', 'students', 's1existe', 'notes_1', 'deuxieme_sessions', 'notes_2', 'existeS2', 'test1', 'session1_existe', 'checkvalid', 'resultat_existe', 'session_2', 'ponders', 'test2', 'resultats', 's2existe', 'existeS1'))->with('title', $title)->with('sous', $sous)->with('ui', $ui);
	}


	public function confirmSemestre_1($class, $parcour)
	{
		$input = Input::all();
		$validation = Validator::make($input, []);
		if($validation->fails()) {
			return Redirect::back()->withInput()->withErrors($validation);
		}
		else {

			//$al    		= $input['grade'];
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
				$result->session        = 1;
				$result->status         = 1;

				$result->codeUe 		= $ue[$i];
				$result->codeEc 		= $ec[$i];
				$result->NoteEc 		= $noteec[$i];
				$result->coef 			= $coefs[$i];
				$result->Noteponder 	= $totale[$i];

                $result->save();
			}
			return Redirect::to('/admin/resultats_examen/semestre_1/vérification/'.$class.'/'.$parcour)->withSuccess('Vérification avant d\'activer les résultats Semestre 1!');
		}
	}

	public function Examensemestres_1($class, $parcour)
	{
		$title 			 	= 'Résultats 1er Semestre';
		$sous            	= 'Bilan';
		$year 			 	= Year::where('status', 1)->first();
		$class   		 	= TheClass::find($class);
		$parcour 		 	= Parcour::find($parcour);
		$classes         	= TheClass::all();

		$checks     		= Note::where('yearsUniv', 			$year->yearsUniv)
			                         	 ->where('class_id', 	$class->id)
			                         	 ->where('parcour_id', 	$parcour->id)
			                         	 ->where('semestre', 1)
			                         	 ->where('session', 1)
			                         	 ->groupBy('id_student')
			                         	 ->orderBy('id', 'asc')
			                         	 ->get(); 

		return View::make('backend.admin.notes.result.semestre_1', compact('year', 'class', 'presents', 'parcour', 'checks', 'lists'))->with('title', $title)->with('sous', $sous);
	}


	public function detailsofnotes_1($class, $parcour, $student)
	{
		$title 			 	= 'Résultats 1er Semestre';
		$sous            	= 'Bilan';
		$years 			 	= Year::where('status', 1)->first();
		$class   		 	= TheClass::find($class);
		$parcour 		 	= Parcour::find($parcour);
		$student 			= Student::find($student);
		$ifhas1 			= Result::where('status', 1)
			        					->where('yearsUniv', $years->yearsUniv)
			        					->where('session', 1)
			        					->count();

		$classes         	= TheClass::all();

		$detailNotes        = Credit::where('class_id', 	$class->id)
									->where('parcour_id', 	$parcour->id)
								    ->where('id_student', 	$student->id)
								    ->where('semestre', 1)
								    ->where('session', 1)
								     ->groupBy('codeUe')
								    ->get();

		$check        		= Credit::where('class_id', 	$class->id)
									->where('parcour_id', 	$parcour->id)
								    ->where('id_student', 	$student->id)
								    ->where('semestre', 2)
								     ->where('session', 1)
								     ->groupBy('codeUe')
								    ->count();						    


		return View::make('backend.admin.notes.result.detailnotes_1', compact('years', 'class', 'parcour', 'detailNotes', 'student', 'check'))->with('title', $title)->with('sous', $sous);
	}



	public function restore_s1($class, $parcour)
	{
		$restores1 = Credit::where('semestre', 1)
								->where('session', 1)
								->get();
				foreach ($restores1 as $restore1) {
						$restore1->delete();
				}
		$delete_S1 = Delibera::where('semestre', 1)
								->where('session', 1)
								->get();
				foreach ($delete_S1 as $del_1) {
					$del_1->delete();
				}
		return Redirect::to('/admin/resultats_examen/'.$class.'/'.$parcour)->withWarning('Vous avez réinitialisé votre résultats 1er Semestre!');
	}


	public function confirmResult($class, $parcour)
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
				$result->session       	= 1;
				$result->status         = 1;

                $result->save();
			}

			return Redirect::to('/admin/resultats_examen/session_1/version-officiel/résultats/'.$class.'/'.$parcour)->withSuccess('Les résultats officiel a été confirmé!');
		}
	}


	public function officiel_session_1($class, $parcour)
	{
		$title 			 	= 'Résultats des examens 1ère session';
		$sous            	= 'Bilan';
		$year 			 	= Year::where('status', 1)->first();
		$class   		 	= TheClass::find($class);
		$parcour 		 	= Parcour::find($parcour);

		$officials 			= Result::orderBy('admis', 'desc')
										->where('yearsUniv', $year->yearsUniv)
										//->where('admis', 1)
										->where('status', 1)
										->where('session', 1)
										->groupBy('id_student')
										->get();

		$admis              = Result::where('admis', 1)
										->where('session', 1)
										->where('status', 1)->count();

		$nonadmis           = Result::where('admis', 0)
										->where('session', 1)
										->where('status', 1)->count();

		$ifhaofficial 		= Result::where('status', 1)
			        					->where('yearsUniv', $year->yearsUniv)
			        					->where('session', 1)
			        					->count();

		$classes         	= TheClass::all();

		return View::make('backend.admin.notes.result.resultatSession1', compact('officials', 'rank', 'year', 'class', 'admis', 'nonadmis', 'ifhaofficial', 'parcour'))->with('title', $title)->with('sous', $sous);
	}

	public function restoreOfficiel($class, $parcour)
	{
		$restore = DB::table('resultats')->truncate();

		return Redirect::to('/admin/resultats_examen/'.$class.'/'.$parcour)->withWarning('Vous avez réinitialisé votre résulats 1er Session!');
	}

	public function releve_notes_1($class, $parcour, $student)
	{
		$title 			= 'Relevé de notes 1er Semestre';
		$sous           = 'Relevé de notes';
		$ui             = 'Relevé de notes';
		$class   		= TheClass::find($class);
		$parcour   		= Parcour::find($parcour);
		$years          = Year::where('status', 1)->first();
		$student 		= base64_decode(str_pad(strtr($student, '-_', '+/'), strlen($student) % 4, '=', STR_PAD_RIGHT));
		$student 		= Student::find($student);
		
		$noteYear       = Note::where('id_student', $student->id)
								->where('class_id', $student->class_id)
							   	->where('yearsUniv', $years->yearsUniv)
							   	->groupBy('yearsUniv')
							   	->first();

		$totalNote 		= DB::table('notesexam')->where('class_id', $student->class_id)
								->where('id_student', $student->id)
								->sum('noteExam');

		$countEc 		= DB::table('notesexam')->where('class_id', $student->class_id)
								->where('id_student', $student->id)
								->count();						

		$Moyenne        = DB::table('notesexam')->where('class_id', $student->class_id)
								->where('id_student', $student->id)
								->avg('noteExam');
		
								
		$releves_s1     = Credit::where('class_id', $student->class_id)
								    ->where('id_student', $student->id)
								    ->where('session', 1)
								    ->where('semestre', 1)
								    ->where('status', 1)
								    ->groupBy('codeUe')
								    ->get();

		$releves_s2     = Credit::where('class_id', $student->class_id)
								    ->where('id_student', $student->id)
								    ->where('session', 1)
								    ->where('semestre', 2)
								    ->groupBy('codeUe')
								    ->get();						    

		$noteSem        = Sem::where('status', 1)->first();

		$valid 			= Result::where('admis', 1)
		                            ->where('session', 1)
		                            ->where('class_id', $class->id)
		                            ->where('parcour_id', $parcour->id)
		                            ->where('id_student', $student->id)
		                            ->count();

		if ($student !== null) {
			return View::make('backend.admin.notes.result.relevesnotes_1', compact('releves_s1', 'releves_s2', 'student', 'class', 'countEc', 'mention', 'years', 'totalNote', 'Moyenne', 'noteSem', 'noteYear', 'parcour', 'valid'))->with('title', $title)->with('sous', $sous)->with('ui', $ui);
		} 
		else {
			return Redirect::route('indexReleve');
		}
	}

	public function affichagesprint($class, $parcour)
	{
		$class   		= TheClass::find($class);
		$years          = Year::where('status', 1)->first();
		$parcour 		= Parcour::find($parcour);
		
		$affichages     = Result::where('session', 1)
								->where('class_id',    $class->id)
								->where('parcour_id',  $parcour->id)
							   	->where('yearsUniv',   $years->yearsUniv)
							   	->where('admis', 1)
							   	->where('status', 1)
							   	->orderBy('admis', 'desc')
							   	->groupBy('id_student')
							   	->get();

		return View::make('backend.admin.notes.result.affichage', compact('parcour', 'class', 'years', 'affichages'));
	}


	public function listajournee($class, $parcour)
	{
		$class   		= TheClass::find($class);
		$years          = Year::where('status', 1)->first();
		$parcour 		= Parcour::find($parcour);
		
		$affichages     = Result::where('class_id',    $class->id)
								->where('parcour_id',  $parcour->id)
							   	->where('yearsUniv',   $years->yearsUniv)
							   	->where('admis', 0)
							   	->where('status', 1)
							   	->orderBy('admis', 'asc')
							   	->groupBy('id_student')
							   	->get();

		return View::make('backend.admin.notes.result.ajournee', compact('parcour', 'class', 'years', 'affichages'));
	}

//**************************************///
	public function alertOpen()
	{
		
		$alertOpen = Control::find(1);
		// active page note Etudiant
		$alertOpen->openNote  = 1;

		$alertOpen->save();

		return Redirect::to('/admin/resultats_examen_bilan/class/etudiants');
	}

	public function alertOpenX()
	{
		
		$alertOpenX = Control::find(1);
		// active page note Etudiant
		$alertOpenX->openNote  = 1;

		$alertOpenX->save();

		return Redirect::to('/admin/resultats_examen');

	}


	public function sendExam($class, $parcour, $student)
	{
		$class   		 = TheClass::find($class);
		$parcour   		 = Parcour::find($parcour);
		$student   		 = Student::find($student);
		$input 			 = Input::all();

		$resultats       = Result::where('class_id', 		 $class->id)
									  ->where('parcour_id',  $parcour->id)
									  ->where('id_student',  $student->id)
									  ->where('admis', 1)
									  ->where('session', 1)
									  //->orderBy('moyenne', '>=', 15)
									  ->get();

		$session  = Result::where('session', 1)->first();							  
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