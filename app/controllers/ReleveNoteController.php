<?php

class ReleveNoteController extends BaseController {


	protected $rules = [
		'note' => 'required'
	];

	public function index() {

		$title 		= 'Releve des notes';
		$sous       = 'Liste des classes';
		$ui         = 'Releve de notes';
		$parcours  	= Parcour::where('status', 1)->orderBy('id', 'asc')->paginate(10);
		$classes  	= TheClass::all();
		$etudiants 	= Student::all();
		$year       = Year::where('status', 1)->first();
		$kilasy  	= TheClass::where('id', 1)->first();

		return View::make('backend.admin.notes.releve.index', compact('kilasy', 'classes', 'etudiants', 'parcours', 'year'))->with('title', $title)->with('sous', $sous)->with('ui', $ui);
	}

	public function listsnoteStudents($class)
	{
		$title 			 = 'Relevé des notes';
		$sous            = 'Relevé des notes';
		$ui              = 'Relevé des notes';
		$class   		 = TheClass::find($class);
		$parcours 		 = Parcour::where('class_id', $class->id)->where('status', 1)->get();
		$year       	 = Year::where('status', 1)->first();
		$students 		 = Student::where('class_id', $class->id)
									->where('yearsUniv', $year->yearsUniv)
									->where('status', 0)
									->get();
									
		$theNote 		 = Result::where('class_id', $class->id)
								->where('yearsUniv', $year->yearsUniv)
								->count();
		
		return View::make('backend.admin.notes.releve.etudiants', compact('students','class', 'theNote', 'year'))->with('title', $title)->with('sous', $sous)->with('ui', $ui);
	}

	public function releveNote($class, $student)
	{
		$title 			= 'Liste des étudiants';
		$sous           = 'Gestion des notes';
		$ui             = 'Releve de notes';
		$class   		= TheClass::find($class);
		$years          = Year::where('status', 1)->first();
		$student 		= base64_decode(str_pad(strtr($student, '-_', '+/'), strlen($student) % 4, '=', STR_PAD_RIGHT));
		$student 		= Student::find($student);
		
		$noteYear       = Note::where('id_student', $student->id)
								->where('class_id', $student->class_id)
							   	->where('yearsUniv', $years->yearsUniv)
							   	->where('semestre', 1)
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
		
								
		$myNote_s1     = Credit::where('class_id', $student->class_id)
								    ->where('id_student', $student->id)
								    ->where('semestre', 1)
								    ->where('session', 1)
								    ->where('status', 1)
								    ->groupBy('codeUe')
								    ->get();

		$myNote_s2     = Credit::where('class_id', $student->class_id)
								    ->where('id_student', $student->id)
								    ->where('semestre', 2)
								    ->where('session', 1)
								    ->groupBy('codeUe')
								    ->get();						    

		$noteSem        = Sem::where('status', 1)->first();

		if ($student !== null) {
			return View::make('backend.admin.notes.releve.releve_note', compact('myNote_s1', 'myNote_s2', 'student', 'class', 'countEc', 'mention', 'years', 'totalNote', 'Moyenne', 'noteSem', 'noteYear'))->with('title', $title)->with('sous', $sous)->with('ui', $ui);
		} 
		else {
			return Redirect::route('indexReleve');
		}
	}

}