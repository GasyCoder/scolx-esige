<?php
class Resultats2Controller extends BaseController {

	public function __construct(Student $student)
	{
	        $this->student = $student;
	}

	public function confirmSemestre_2($class, $parcour)
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
				$result->semestre       = 2;
				$result->session        = 1;
				$result->status         = 1;

				$result->codeUe 		= $ue[$i];
				$result->codeEc 		= $ec[$i];
				$result->NoteEc 		= $noteec[$i];
				$result->coef 			= $coefs[$i];
				$result->Noteponder 	= $totale[$i];

                $result->save();
			}

			return Redirect::to('/admin/resultats_examen/semestre_2/vérification/'.$class.'/'.$parcour)->withSuccess('Vérification avant de publier les résultats!');
		}
	}

	public function Examensemestres_2($class, $parcour)
	{
		$title 			 	= 'Résultats 2e Semestre';
		$sous            	= 'Bilan';
		$year 			 	= Year::where('status', 1)->first();
		$class   		 	= TheClass::find($class);
		$parcour 		 	= Parcour::find($parcour);

		$classes         	= TheClass::all();

		$checks     		= Note::where('yearsUniv', 			$year->yearsUniv)
			                         	 ->where('class_id', 	$class->id)
			                         	 ->where('parcour_id', 	$parcour->id)
			                         	 ->where('semestre', 2)
			                         	 ->where('session', 1)
			                         	 ->groupBy('id_student')
			                         	 ->orderBy('id', 'asc')
			                         	 ->get();  

		return View::make('backend.admin.notes.result.semestre_2', compact('year', 'class', 'parcour', 'checks'))->with('title', $title)->with('sous', $sous);
	}


	public function detailsofnotes_2($class, $parcour, $student)
	{
		$title 			 	= 'Résultats 2ème Semestre';
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

		$detailNotes       = Credit::where('class_id', 		$student->class_id)
									->where('parcour_id', 	$parcour->id)
								    ->where('id_student', 	$student->id)
								    ->where('semestre', 2)
								    ->groupBy('codeUe')
								    ->get(); 

		$check        		= Credit::where('class_id', 	$student->class_id)
									->where('parcour_id', 	$parcour->id)
								    ->where('id_student', 	$student->id)
								    ->where('semestre', 1)
								     ->where('session', 1)
								    ->groupBy('codeUe')
								    ->count();

		return View::make('backend.admin.notes.result.detailnotes_2', compact('years', 'class', 'parcour', 'detailNotes', 'student', 'check'))->with('title', $title)->with('sous', $sous);
	}

	public function restore_s2($class, $parcour)
	{
		$restores2 = Credit::where('semestre', 2)
								->where('session', 1)
								->get();
			foreach ($restores2 as $restore2) {
					$restore2->delete();
			}
		$delete_S2 = Delibera::where('semestre', 2)
								->where('session', 1)
								->where('status', 1)
								->get();
			foreach ($delete_S2 as $del_2) {
				$del_2->delete();
			}
		return Redirect::to('/admin/resultats_examen/'.$class.'/'.$parcour)->withWarning('Vous avez réinitialisé votre résultats 2em Semestre!');
	}

	public function session2Result($class, $parcour)
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

			return Redirect::to('/admin/resultats_examen/session_2/version-officiel/résultats/'.$class.'/'.$parcour)->withSuccess('Les résultats officiel a été confirmé!');
		}
	}




	public function officiel_session_2($class, $parcour)
	{
		$title 			 	= 'Résultats des examens 2ème session';
		$sous            	= 'Bilan';
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

		return View::make('backend.admin.notes.result.resultatSession2', compact('officials', 'rank', 'year', 'class', 'admis', 'nonadmis', 'ifhaofficial', 'parcour'))->with('title', $title)->with('sous', $sous);
	}


	public function print_s2($class, $parcour)
	{
		$class   		= TheClass::find($class);
		$years          = Year::where('status', 1)->first();
		$parcour 		= Parcour::find($parcour);
		
		$fecths     = Result::where('session', 2)
								->where('class_id',    $class->id)
								->where('parcour_id',  $parcour->id)
							   	->where('yearsUniv',   $years->yearsUniv)
							   	->where('admis', 1)
							   	->orderBy('admis', 'desc')
							   	->groupBy('id_student')
							   	->get();

		return View::make('backend.admin.notes.result.print_s2', compact('parcour', 'class', 'years', 'fecths'));
	}

}