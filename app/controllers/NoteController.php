<?php

class NoteController extends BaseController {

	protected $rulesexam = [
		'noteExam' => 'required'
	];

	protected $rulescc = [
		'notecc1' => 'required',
		'notecc2' => 'required'
	];

	public function index_one() {

		$title 		= 'Ajouter des notes';
		$sous       = 'Liste des niveaux';
		$ui         = 'Notes';
		$parcours  	= Parcour::where('status', 1)->orderBy('id', 'asc')->paginate(10);
		$classes  	= TheClass::all();
		$year       = Year::where('status', 1)->first();
		$etudiants 	= Student::orderBy('id', 'asc')->paginate(10);

		$kilasy  	= TheClass::where('id', 1)->first();

		return View::make('backend.admin.notes.index_one', compact('kilasy', 'classes', 'etudiants', 'parcours', 'year'))->with('title', $title)->with('sous', $sous)->with('ui', $ui);
	}
	

	public function parcourNote($class)
	{
		$title 			 = 'Ajouter note';
		$sous            = 'Gestion des notes';
		$ui         	 = 'Notes';
		$class   		 = TheClass::find($class);
		$year 			 = Year::where('status', 1)->first();
		$parcours 		 = Parcour::where('class_id', $class->id)
									->where('status', 1)->get();
		
		$elements 		 = EC::where('class_id', $class->id)->where('status', 1)->get();
		
		return View::make('backend.admin.notes.parcours', compact('elements','parcours', 'class', 'ues', 'year'))->with('title', $title)->with('sous', $sous)->with('ui', $ui);
	}

	public function semMatiere($class, $parcour){
		{
			//$title 			 = 'Liste des parcours';
			//$sous            = 'Gestion des absences';
			$class   		 = TheClass::find($class);
			$parcours 		 = Parcour::where('class_id', $class->id)->where('status', 1)->get();
			$semestres 		 = Sem::where('status', 1)->get();

			return View::make('backend.admin.notes.semestres', compact('semestres', 'parcours', 'class', 'ues'));
		}
	}
	

	public function element($class, $parcour, $semestre)
	{
		$title 	 = 'Ajouter les notes examen par matières';
		$sous    = 'Listes des matières';
		$ui      = 'Notes';
		$class   = TheClass::find($class);
		$year    = Year::where('status', 1)->first();
		$parcour = Parcour::find($parcour);
		$semestre = Semestre::find($semestre);

		$matieres = EC::where('status', 1)->where('class_id', $class->id)
						->where('parcour_id', $parcour->id)
						->where('semestre', $semestre->id)
						->get();

		return View::make('backend.admin.notes.matieres', compact('class', 'parcour', 'matieres', 'year'))->with('title', $title)->with('sous', $sous)->with('ui', $ui);
	}


	//Add Notes by elements and Parcours---------------------------------------------
	public function addNoteExam($class, $parcour, $semestre, $type, $element, $codeEc)
	{
		$title 			= 'Ajouter notes';
		$sous    		= 'Etudiants';
		$ui         	= 'Notes';
		$class 			= TheClass::find($class);
		$parcour 		= Parcour::find($parcour);
		$parcours 		= Parcour::where('status', 1)->where('class_id', $class->id)->get();
		$years 			= Year::where('status', 1)->first();
		$type 			= ChoixAdd::find($type);
		$semestre 		= Semestre::find($semestre);
		$element 	 	= base64_decode(str_pad(strtr($element, '-_', '+/'), strlen($element) % 4, '=', STR_PAD_RIGHT));
		$element 		= EC::find($element);

		$code 	 		= base64_decode(str_pad(strtr($codeEc, '-_', '+/'), strlen($codeEc) % 4, '=', STR_PAD_RIGHT));
		$code 			= EC::find($codeEc);

		$elements 		= EC::where('status', 1)
										->where('class_id', $class->id)
										->where('parcour_id', $parcour->id)
										->where('id', '!=', $element->id)
										->get();

		$ues   			= UE::where('status', 1)
										->where('class_id', $class->id)
										->where('parcour_id', $parcour->id)
										->where('codeUe', $element->codeUe)
										->first();

		$students   	= Student::where('class_id', $class->id)
									  ->where('parcour_id', $parcour->id)
									  ->where('yearsUniv', $years->yearsUniv)
				                      ->get();


		$fixes 			= Note::where('class_id', $class->id)
									->where('parcour_id', $parcour->id)
									->where('element_id', $element->id)
									->where('yearsUniv', $years->yearsUniv)
									->where('status', 1)
									->count();

														
		return View::make('backend.admin.notes.tapeNoteExam', compact('class', 'parcour', 'element', 'students', 'elements', 'parcours', 'years', 'semestre', 'ues', 'fixes', 'type'))->with('title', $title)->with('sous', $sous)->with('ui', $ui);															
	}

	public function sendNoteExam($class, $parcour, $semestre, $type, $element, $codeEc)
	{
		$class 			 = $class;
		$parcour 		 = $parcour;
		$semestre 		 = $semestre;
		
		$element 	     = base64_decode(str_pad(strtr($element, '-_', '+/'), strlen($element) % 4, '=', STR_PAD_RIGHT));
		$element 		 = $element;

		$input = Input::all();
		$validation = Validator::make($input, $this->rulesexam);
		if($validation->fails()) {
			return Redirect::back()->withInput()->withErrors($validation);
		}
		else {

			$ue 			= $input['id_unite'];
			$codeue 		= $input['codeUe'];

			$idStud 		= $input['id_student'];
			$al 			= $input['grade'];
			$year 			= $input['yearsUniv'];
			$coefi 			= $input['coef'];

			foreach ($input['noteExam'] as $i => $examen)
			{
				$notes = new Note();
				$notes->class_id 	= $class;
				$notes->parcour_id 	= $parcour; 
				$notes->element_id 	= $element;
				$notes->codeEc 		= $codeEc;
				$notes->user_id 	= Auth::id();
				$notes->noteExam 	= $examen;
				$notes->semestre 	= $semestre;

				$notes->id_unite 	= $ue[$i];
				$notes->codeUe 		= $codeue[$i];

				$notes->id_student 	= $idStud[$i];
				$notes->grade 		= $al[$i];
				$notes->yearsUniv 	= $year[$i];

				$notes->coef 		= $coefi[$i];

				$notes->session 	= 1;
				$notes->status 		= 1;
                $notes->save();
			}

			return Redirect::to('/admin/notes/etudiants/'.$class.'/'.$parcour.'/'.$semestre.'/'.$type)->withSuccess('Le note a été ajouté avec succès!');
		}
	}
	//Add Notes by elements and Parcours---------------------------------------------

	public function showNote($class, $parcour, $semestre, $element, $codeEc)
	{
		$title 			= 'Notes Examen par matières';
		$sous    		= 'Gestion des notes';
		$ui         	= 'Notes';
		$class 			= TheClass::find($class);
		$parcour 		= Parcour::find($parcour);
		$semestre 		= Sem::find($semestre);
		$years 			= Year::where('status', 1)->first();
		$semestres		= Sem::all();

		$element 	 	= base64_decode(str_pad(strtr($element, '-_', '+/'), strlen($element) % 4, '=', STR_PAD_RIGHT));
		$element 		= EC::find($element);

		$notes 			= Note::where('status', 1)
												->where('class_id', $class->id)
												->where('parcour_id', $parcour->id)
												->where('element_id', $element->id)
												->where('yearsUniv', $years->yearsUniv)
												->get();

		$students 		= Student::where('class_id', $class->id)
												->where('parcour_id', $parcour->id)
		                                        ->get();

        $elements       = EC::where('status', 1)
												->where('class_id', $class->id)
												->where('parcour_id', $parcour->id)
												->where('id', '!=', $element->id)
												->where('semestre', $semestre->codeSem)
												->get();

		return View::make('backend.admin.notes.display', compact('class', 'parcour', 'element', 'students', 'notes', 'parcours', 'years', 'semestres', 'elements', 'semestre'))->with('title', $title)->with('sous', $sous)->with('ui', $ui);															
	}



	public function modifierNote($id, $class, $parcour, $element)
	{
		$title 		= 'Modifier';
		$sous       = 'Note';
		$class      = TheClass::find($class);
		$parcour    = Parcour::find($parcour);
		$element = base64_decode(str_pad(strtr($element, '-_', '+/'), strlen($element) % 4, '=', STR_PAD_RIGHT));

		$element   	= EC::find($element);
		$mark 		= Note::find($id);
		//$student    = Student::find($id);
		
		$students   = Student::where('class_id', $class->id)
								  ->where('parcour_id', $parcour->id)
								  ->where('id', '!=', 	$mark->id_student)
								  ->where('grade', NULL)
								  ->get();

		$auditeurs   = Student::where('class_id', 		$class->id)
								  ->where('parcour_id', $parcour->id)
								  ->where('id', '!=', 	$mark->id_student)
								  ->where('grade', 'AL')
								  ->get();

		return View::make('backend.admin.notes.update.edit', compact('mark', 'element', 'students', 'class', 'parcour', 'auditeurs'))->with('title', $title)->with('sous', $sous);

	}
	public function updateNoteStd($id)
	{
		if (Request::ajax()) {

			$inputs = Input::all();
			$validation = Validator::make($inputs, ['noteExam'=>'required']);
			if ($validation->fails()) {
				return 'false';
			} 
			else {

				$mark 				= Note::find($id);
				$mark->noteExam 	= e($inputs['noteExam']);
			}
			$mark->save();
			return 'true';  
        }

	}

	public function soloyNote($id, $class, $user, $element)
	{
		$title 		= 'Modifier';
		$sous       = 'Note';
		$class      = TheClass::find($class);
		$element 	= base64_decode(str_pad(strtr($element, '-_', '+/'), strlen($element) % 4, '=', STR_PAD_RIGHT));

		$element 		= EC::find($element);
		$mark 		 	= Note::find($id);
		$student     	= Student::find($user);
		
		$elex   	= EC::where('status', 1)
							->where('codeEc', $element->codeEc)
							->where('id', $element->id)
							->where('class_id', $class->id)
							->first();


		return View::make('backend.admin.notes.update.edit_tronc', compact('mark', 'element', 'class', 'elex'))->with('title', $title)->with('sous', $sous);

	}

	public function showNoteAll($class, $element, $codeEc)
	{
		$title 			= 'Liste notes tronc commun';
		$sous    		= 'Gestion des notes';
		$ui      		= 'Notes';
		$class 			= TheClass::find($class);
		$years 			= Year::where('status', 1)->first();
		$semestres		= Sem::where('class_id', $class->id)->get();

		$element 	 	= base64_decode(str_pad(strtr($element, '-_', '+/'), strlen($element) % 4, '=', STR_PAD_RIGHT));
		$element 		= EC::find($element);

		$codeEc 	 	= base64_decode(str_pad(strtr($codeEc, '-_', '+/'), strlen($codeEc) % 4, '=', STR_PAD_RIGHT));
		$codeEc 		= EC::find($codeEc);

		$elements   = EC::where('status', 1)
								->where('class_id', $class->id)
								->groupBy('codeEc')
								->get();

		$notestronc 	= Note::where('status', 1)
												->where('class_id', $class->id)
												->where('codeEc', $element->codeEc)
												->where('yearsUniv', $years->yearsUniv)
												->groupBy('id_student')
												->get();

		$students 		= Student::where('class_id', $class->id)
								   ->where('yearsUniv', $years->yearsUniv)
		                           ->where('status', 0)->get();


		return View::make('backend.admin.notes.tronc.afficher', compact('class', 'element', 'students', 'notestronc', 'years', 'semestres', 'elements'))->with('title', $title)->with('sous', $sous)->with('ui', $ui);															
	}


	public function recap() {

		$title 		= 'Récapitulatif';
		$sous       = 'Liste des classes';
		$ui         = 'Notes';
		$parcours  	= Parcour::where('status', 1)->orderBy('id', 'asc')->paginate(10);
		$classes  	= TheClass::all();
		$year       = Year::where('status', 1)->first();
		$etudiants 	= Student::orderBy('id', 'asc')->paginate(10);

		$kilasy  	= TheClass::where('id', 1)->first();

		return View::make('backend.admin.notes.recap', compact('kilasy', 'classes', 'etudiants', 'parcours', 'year'))->with('title', $title)->with('sous', $sous)->with('ui', $ui);
	}

	public function all_notes_recap($class)
	{
		$title 			 = 'Liste des parcours';
		$sous            = 'Gestion des absences';
		$class   		 = TheClass::find($class);
		$parcours 		 = Parcour::where('class_id', $class->id)->where('status', 1)->get();
		$elements 		 = EC::where('class_id', $class->id)->where('status', 1)->get();
		
		return View::make('backend.admin.notes.recap_parcour', compact('elements', 'parcours', 'class', 'ues'))->with('title', $title)->with('sous', $sous);
	}

	public function list_recap($class, $parcour)
	{
		$title 	 	= 'Tous les notes des étudiants';
		$sous    	= 'Notes des étudiants';
		$class   	= TheClass::find($class);
		$parcour 	= Parcour::find($parcour);
		$year       = Year::where('status', 1)->first();
		$recapNotes   = Note::where('status', 1)
							->where('class_id', $class->id)
							->where('parcour_id', $parcour->id)
							->where('yearsUniv', $year->yearsUniv)
							->get();

		return View::make('backend.admin.notes.recap_all', compact('class', 'parcour', 'recapNotes'))->with('title', $title)->with('sous', $sous);
	}

	public function removeNote($id)
	{
		$rnote = Note::find($id);

		if ($rnote !== null) {

			$rnote->delete();
			return Redirect::back()->with('success', ('Note a été supprimé avec succès!'));

		}

		else {
			return Redirect::back();
		}

	}

 /** *********** CC ********************/
	public function choixNotes($class, $parcour, $type){
		{
			//$title 			 = 'Liste des parcours';
			//$sous            = 'Gestion des absences';
			$class   		 = TheClass::find($class);
			$parcours 		 = Parcour::where('class_id', $class->id)->where('status', 1)->get();
			$types 	 		 = ChoixAdd::orderBy('id', 'desc')->get();
			
			return View::make('backend.admin.notes.choixNotes', compact('types', 'parcours', 'class', 'ues'));
		}
	}
 public function matierecc($class, $parcour, $semestre)
	{
		$title 	 	= 'Choisir matière CC';
		$sous    	= 'Listes des matières';
		$ui      	= 'Notes';
		$class   	= TheClass::find($class);
		$year    	= Year::where('status', 1)->first();
		$parcour 	= Parcour::find($parcour);
		$semestre 	= Semestre::find($semestre);

		$matieres = EC::where('status', 1)
						->where('class_id',   $class->id)
						->where('parcour_id', $parcour->id)
						->where('semestre',   $semestre->id)
						->get();

		return View::make('backend.admin.notes.matierecc', compact('class', 'parcour', 'matieres', 'year', 'semestre'))->with('title', $title)->with('sous', $sous)->with('ui', $ui);
	}

	public function addNoteCC($class, $parcour, $semestre, $type, $element, $codeEc)
	{
		$title 			= 'Ajouter notes';
		$sous    		= 'Etudiants';
		$ui         	= 'Notes';
		$class 			= TheClass::find($class);
		$parcour 		= Parcour::find($parcour);
		$parcours 		= Parcour::where('status', 1)->where('class_id', $class->id)->get();
		$years 			= Year::where('status', 1)->first();
		$type 			= Semestre::find($type);
		$semestre 		= Semestre::find($semestre);
		$element 	 	= base64_decode(str_pad(strtr($element, '-_', '+/'), strlen($element) % 4, '=', STR_PAD_RIGHT));
		$element 		= EC::find($element);

		$code 	 		= base64_decode(str_pad(strtr($codeEc, '-_', '+/'), strlen($codeEc) % 4, '=', STR_PAD_RIGHT));
		$code 			= EC::find($codeEc);

		$elements 		= EC::where('status', 1)
										->where('class_id', $class->id)
										->where('parcour_id', $parcour->id)
										->where('id', '!=', $element->id)
										->get();

		$ues   			= UE::where('status', 1)
										->where('class_id', $class->id)
										->where('parcour_id', $parcour->id)
										->where('codeUe', $element->codeUe)
										->first();

		$students   	= Student::where('class_id', $class->id)
									  ->where('parcour_id', $parcour->id)
									  ->where('yearsUniv', $years->yearsUniv)
				                      ->get();


		$fixes 			= Notecc::where('class_id', $class->id)
									->where('parcour_id', $parcour->id)
									->where('element_id', $element->id)
									->where('yearsUniv', $years->yearsUniv)
									->count();

														
		return View::make('backend.admin.notes.tapeNoteCC', compact('class', 'parcour', 'element', 'students', 'elements', 'parcours', 'years', 'semestre', 'ues', 'fixes', 'type'))->with('title', $title)->with('sous', $sous)->with('ui', $ui);															
	}

	public function sendNoteCC($class, $parcour, $semestre, $type, $element, $codeEc)
	{
		$class 			 = $class;
		$parcour 		 = $parcour;
		$semestre 		 = $semestre;
		
		$element 	     = base64_decode(str_pad(strtr($element, '-_', '+/'), strlen($element) % 4, '=', STR_PAD_RIGHT));
		$element 		 = $element;

		$input = Input::all();
		$validation = Validator::make($input, $this->rulescc);
		if($validation->fails()) {
			return Redirect::back()->withInput()->withErrors($validation);
		}
		else {

			$ue 			= $input['id_unite'];
			$codeue 		= $input['codeUe'];
			$cc2 			= $input['notecc2'];

			$idStud 		= $input['id_student'];
			$al 			= $input['grade'];
			$year 			= $input['yearsUniv'];

			foreach ($input['notecc1'] as $i => $controle)
			{
				$notes = new Notecc();
				$notes->class_id 	= $class;
				$notes->parcour_id 	= $parcour; 
				$notes->element_id 	= $element;
				$notes->semestre 	= $semestre;
				$notes->codeEc 		= $codeEc;
				$notes->user_id 	= Auth::id();
				$notes->notecc1 	= $controle;

				$notes->notecc2 	= $cc2[$i];
				$notes->id_unite 	= $ue[$i];
				$notes->codeUe 		= $codeue[$i];

				$notes->id_student 	= $idStud[$i];
				$notes->grade 		= $al[$i];
				$notes->yearsUniv 	= $year[$i];

				$notes->session 	= 1;
                $notes->save();
			}

			return Redirect::to('/admin/notes/etudiants/'.$class.'/'.$parcour.'/'.$semestre.'/'.$type)->withSuccess('Le note CC a été ajouté avec succès!');
		}
	}

	public function showNotecc($class, $parcour, $semestre, $element, $codeEc)
	{
		$title 			= 'Ajouter note CC';
		$sous    		= 'Gestion des notes';
		$ui         	= 'Notes';
		$class 			= TheClass::find($class);
		$parcour 		= Parcour::find($parcour);
		$semestre 		= Sem::find($semestre);
		$years 			= Year::where('status', 1)->first();
		$semestres		= Sem::all();

		$element 	 	= base64_decode(str_pad(strtr($element, '-_', '+/'), strlen($element) % 4, '=', STR_PAD_RIGHT));
		$element 		= EC::find($element);

		$notes 			= Notecc::where('session', 1)
												->where('class_id', $class->id)
												->where('parcour_id', $parcour->id)
												->where('element_id', $element->id)
												->where('yearsUniv', $years->yearsUniv)
												->get();

		$students 		= Student::where('class_id', $class->id)
												->where('parcour_id', $parcour->id)
		                                        ->get();

        $elements       = EC::where('status', 1)
												->where('class_id', $class->id)
												->where('parcour_id', $parcour->id)
												->where('id', '!=', $element->id)
												->where('semestre', $semestre->codeSem)
												->get();

		return View::make('backend.admin.notes.shownotecc', compact('class', 'parcour', 'element', 'students', 'notes', 'parcours', 'years', 'semestres', 'elements', 'semestre'))->with('title', $title)->with('sous', $sous)->with('ui', $ui);															
	}

	public function editNotecc($id, $class, $parcour, $element)
	{
		$title 		= 'Modifier';
		$sous       = 'Note';
		$class      = TheClass::find($class);
		$parcour    = Parcour::find($parcour);
		$element = base64_decode(str_pad(strtr($element, '-_', '+/'), strlen($element) % 4, '=', STR_PAD_RIGHT));

		$element   	= EC::find($element);
		$mark 		= Notecc::find($id);
		//$student    = Student::find($id);
		
		$students   = Student::where('class_id', $class->id)
								  ->where('parcour_id', $mark->parcour_id)
								  ->where('id', '!=', $mark->id_student)
								  ->where('grade', NULL)
								  ->get();

		$auditeurs   = Student::where('class_id', 		$class->id)
								  ->where('parcour_id', $parcour->id)
								  ->where('id', '!=', 	$mark->id_student)
								  ->where('grade', 'AL')
								  ->get();

		return View::make('backend.admin.notes.update.updatecc', compact('mark', 'element', 'students', 'class', 'parcour', 'auditeurs'))->with('title', $title)->with('sous', $sous);

	}
	public function updateNoteCC($id)
	{
		if (Request::ajax()) {

			$inputs = Input::all();
			$validation = Validator::make($inputs, ['notecc1'=>'required', 'notecc2'=>'required']);
			if ($validation->fails()) {
				return 'false';
			} 
			else {

				$mark 			= Notecc::find($id);
				$mark->notecc1 	= e($inputs['notecc1']);
				$mark->notecc2 	= e($inputs['notecc2']);
			}
			$mark->save();
			return 'true';  
        }

	}

}