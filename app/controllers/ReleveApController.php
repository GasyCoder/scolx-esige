<?php

class ReleveApController extends BaseController {


	protected $rules = [
		'note' => 'required|numeric|min:0|max:20'
	];


	public function students_ap($class)
	{
		$title 			 = 'Relevé des notes';
		$sous            = 'Relevé des notes à chaque étudiants';
		$class   		 = TheClass::find($class);
		$year            = Year::where('status', 1)->first();    
		$parcours 		 = Parcour::where('class_id', $class->id)->where('status', 1)->get();
		
		$studentsAp      = Student::where('class_id', $class->id)
									->where('yearsUniv', $year->yearsUniv)
		                            ->where('status', 0)->get();

		/*$ifhas           = Note::where('class_id', $class->id)
									->where('yearsUniv', $year->yearsUniv)
									->first();

		$how             = Student::where('class_id', $ifhas->class_id)
									//->where('id', $ifhas->id_student)
									->where('yearsUniv', $ifhas->yearsUniv)
									->count();	*/						
		                            
		$mixtes 		 = Student::where('class_id', '!=', $class->id)
									->where('yearsUniv', $year->yearsUniv)
									->where('grade', 'AL')
		                            ->where('status', 0)->get();

		$theNote 		 = Note::where('class_id', $class->id)
									->where('yearsUniv', $year->yearsUniv)
									->count();
		
		return View::make('backend.admin.notes.ap.etudiants', compact('mixtes', 'studentsAp','class', 'theNote', 'year', 'how'))->with('title', $title)->with('sous', $sous);
	}

	public function releveNoteAp($class, $student)
	{
		$title 				= 'Liste des étudiants';
		$sous           	= 'Gestion des notes';
		$class   			= TheClass::find($class);
		$years          	= Year::where('status', 1)->first();
		$student 			= base64_decode(str_pad(strtr($student, '-_', '+/'), strlen($student) % 4, '=', STR_PAD_RIGHT));
		$student 			= Student::find($student);
		
		$noteYear       	= Note::where('id_student', $student->id)
								   ->where('class_id', $class->id)
								   ->where('yearsUniv', $years->yearsUniv)
								   ->groupBy('yearsUniv')
								   ->first();

		$totalNote 			= DB::table('notes')
									->where('class_id', $class->id)
									->where('id_student', $student->id)
									->where('yearsUniv', $years->yearsUniv)
									->sum('noteExam');

		$Moyenne 			= DB::table('notes')
									->where('class_id', $class->id)
									->where('id_student', $student->id)
									->where('yearsUniv', $years->yearsUniv)
									->avg('noteExam');						

		//$Moyenne            = $totalNote/$countNote;
		
								
		$myNote     		= Note::where('class_id', $class->id)
								    ->where('id_student', $student->id)
								    ->orderBy('tronc')
								    ->groupBy('codeUe')
								    ->get();

		
		$noteSem            = Sem::where('class_id', $class->id)->get();

		if ($student !== null) {
			return View::make('backend.admin.notes.ap.releve_ap', compact('myNote', 'student', 'class', 'countNote', 'mention', 'years', 'sumNote_1', 'sumNote_2', 'totalNote', 'Moyenne', 'noteSem', 'noteYear'))->with('title', $title)->with('sous', $sous);
		} 
		else {
			return Redirect::route('indexReleve');
		}
	}

}