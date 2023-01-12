<?php
class FindNoteController extends BaseController {

	/*public function indexFind()
	{
	   	$title 		= 'Résultats des examens';
	   	$sous       = 'Liste des classes';  

	   	$parcours  	= Parcour::where('status', 1)->orderBy('id', 'asc')->paginate(10);
		$classes  	= TheClass::all();
		$etudiants 	= Student::all();
		$notes 		= Note::groupBy('class_id')->get();
		$year       = Year::where('status', 1)->first();

	   return View::make('backend.admin.notes.search.index', compact('classes', 'parcours', 'etudiants', 'year', 'notes'))->with('title', $title)->with('sous', $sous);
	}*/

	
	public function findNote()
	{
		$title 		= 'Résultats de recherche - relevé des notes';
	   	$sous       = 'Liste des classes';
		$inputs 	= Input::all();
		$year       = Year::where('status', 1)->first();
		$notes 		= Result::all();

		$text_query = e(Input::get('q'));

		if (!empty($text_query)) {

			//$students = Student::where('status', 0)->orWhere('status', 1);

			if(Input::has('q')) {
				$students = Student::where('fname', 'like', '%' .$text_query. '%')->orWhere('lname', 'like', '%' .$text_query. '%')->orWhere('matricule', $text_query);
			}

			$students = $students->paginate(10);
			return View::make('backend.admin.notes.search.searchNote', compact('students', 'year', 'notes'), [ 'students' => $students->appends(Input::except('page')) ])->with('title', $title)->with('sous', $sous);
		}

		else {
			$students = Student::orderBy('fname', 'asc')->paginate(10);
			return View::make('backend.admin.notes.search.index', compact('students', 'year', 'notes'))->with('title', $title)->with('sous', $sous);
		}
	}


	public function openNote($class, $parcour, $etudiant)
	{
	   	$title 		= 'Résultats des examens';
	   	$sous       = 'Liste des classes';  
	   	$parcour  	= Parcour::find($parcour);
		$classes  	= TheClass::all();
		$class  	= TheClass::find($class);
		//$etudiant 	= base64_decode(str_pad(strtr($etudiant, '-_', '+/'), strlen($etudiant) % 4, '=', STR_PAD_RIGHT));
		$etudiant 	= Student::find($etudiant);

		$Onenotes 	= Result::where('id_student', $etudiant->id)
							  ->where('class_id', $class->id)
							  //->groupBy('class_id')
							  ->get();

		$years      = Year::all();
		$year       = Year::where('status', 1)->first();
	    return View::make('backend.admin.notes.search.detailNote', compact('class', 'classes', 'parcour', 'etudiant', 'years', 'Onenotes', 'year'))->with('title', $title)->with('sous', $sous);
	}


	public function releveFind($id, $class, $yearsUniv)
	{
		$title 			= 'Liste des étudiants';
		$sous           = 'Gestion des notes';
		$ui             = 'Releve de notes';

		//$year           = Year::find($id);
		$years          = Year::where('status', 1)->first();
		$class   		= TheClass::find($class);
		
		$student 		= Student::find($id);

		$mark           = Note::where('id_student', $student->id)
								->where('class_id', $class->id)
								->where('yearsUniv', $yearsUniv)
								->first();

		$totalNote 		= DB::table('notes')
								->where('id_student', $student->id)
								->where('class_id',   $class->id)
								->where('yearsUniv',  $yearsUniv)
								->sum('note');

		$countEc 		= DB::table('notes')
								->where('id_student', $student->id)
								->where('class_id',   $class->id)
								->where('yearsUniv',  $yearsUniv)
								->count();						

		$Moyenne        = DB::table('notes')
								->where('id_student', $student->id)
								->where('class_id',   $class->id)
								->where('yearsUniv',  $yearsUniv)
								->avg('note');
										
		$myNote         = Note::where('id_student', 	$mark->id_student)
								->where('yearsUniv', 	$mark->yearsUniv)
								->where('class_id', 	$mark->class_id)
								->where('parcour_id', 	$mark->parcour_id)
								->orderBy('id')
								->groupBy('codeUe')
								->get();

		$myNote_s1     	= Note::where('class_id', 			$student->class_id)
								    ->where('id_student', 	$student->id)
								    ->where('semestre', 1)
								    ->groupBy('codeUe')
								    ->get();

		$myNote_s2      = Note::where('class_id', 			$student->class_id)
								    ->where('id_student', 	$student->id)
								    ->where('semestre', 2)
								    ->groupBy('codeUe')
								    ->get();	

		$noteYear      	= Note::where('id_student', $student->id)
							   ->where('yearsUniv', $yearsUniv)
							   ->where('class_id', '>=', 2)
							   ->where('parcour_id', '>=', 2)
							   ->groupBy('yearsUniv')
							   ->first();

		$noteSem       	= Sem::where('status', 1)->first();

		return View::make('backend.admin.notes.search.releve', compact('myNote', 'student', 'class', 'countEc', 'mention', 'noteYear', 'totalNote', 'Moyenne', 'noteSem', 'mark', 'myNote_s1', 'myNote_s2'))->with('title', $title)->with('sous', $sous)->with('ui', $ui);
		
	}


	public function ReleveForAp($id, $class, $yearsUniv)
	{
		$title 			= 'Liste des étudiants';
		$sous           = 'Gestion des notes';
		$ui             = 'Releve de notes';

		//$year           = Year::find($id);
		$class   		= TheClass::find($class);
		
		$student 		= Student::find($id);
		
		$totalNote 		= DB::table('notes')
								->where('id_student', $id)
								->where('yearsUniv', $yearsUniv)
								->where('class_id',  1)
								->sum('note');

		$countEc 		= DB::table('notes')
								->where('id_student', $student->id)
								->where('yearsUniv', $yearsUniv)
								->where('class_id',  1)
								->count();						

		$Moyenne        = DB::table('notes')
								->where('id_student', $id)
								->where('class_id',  1)
								->where('yearsUniv', $yearsUniv)
								->avg('note');
		
								
		$myNoteLibre         = Note::where('id_student', $student->id)
								->where('class_id', 1)
								//->where('parcour_id', 1)
								->where('yearsUniv', $yearsUniv)
								->orderBy('tronc')
								->groupBy('codeUe')
								->get();

		
		$noteYear      = Note::where('id_student', $student->id)
							   ->where('yearsUniv', $yearsUniv)
							   ->groupBy('yearsUniv')
							   ->first();

		$noteSem            = Sem::where('class_id', $class->id)
								  ->where('status', 1)
								  ->get();

		return View::make('backend.admin.notes.search.ReleveForAp', compact('myNoteLibre', 'student', 'class', 'countEc', 'mention', 'noteYear', 'totalNote', 'Moyenne', 'noteSem'))->with('title', $title)->with('sous', $sous)->with('ui', $ui);
		
	}
}