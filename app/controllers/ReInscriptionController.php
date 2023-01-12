<?php
class ReInscriptionController extends BaseController {

	public function reInscrit()
	{
		$title 		= 'Ré-inscription';
	   	$sous       = 'Vérification';
		$inputs 	= Input::all();
		$year       = Year::where('status', 1)->first();
		$notes 		= Note::all();

		$text_query = e(Input::get('q'));

		if (!empty($text_query)) {

			//$students = Student::where('status', 0)->orWhere('status', 1);

			if(Input::has('q')) {
				$students = Student::where('fname', 'like', '%' .$text_query. '%')->orWhere('lname', 'like', '%' .$text_query. '%')->orWhere('matricule', $text_query);
			}

			$students = $students->paginate(10);
			return View::make('backend.admin.pedagogie.reinscription.resultSearch', compact('students', 'year', 'notes'), [ 'students' => $students->appends(Input::except('page')) ])->with('title', $title)->with('sous', $sous);
		}

		else {
			$students = Student::orderBy('fname', 'asc')->paginate(10);
			return View::make('backend.admin.pedagogie.reinscription.index', compact('students', 'year', 'notes'))->with('title', $title)->with('sous', $sous);
		}
	}


	public function checkEtudiant($class, $parcour, $profile)
	{
		$class   	= TheClass::find($class);
		$parcour 	= Parcour::find($parcour);
		$years      = Year::where('status', 1)->first();
		$annee      = Year::orderBy('status', 1)->get();
		$profile 	= base64_decode(str_pad(strtr($profile, '-_', '+/'), strlen($profile) % 4, '=', STR_PAD_RIGHT));
		
		$student 	= Student::find($profile);
		
		$Onenotes 	= Note::where('id_student', $profile)
							->groupBy('class_id')
							->get();
	
		$mysum      = Note::where('id_student', $student->id)
								->where('class_id', $class->id)
								->where('yearsUniv', $student->yearsUniv)
								->avg('note');

		$classes    = TheClass::groupBy('name')->get();
		$active     = TheClass::where('id', '>', $class->id)
								->orWhere('id', '<', $student->class_id)
								->first();

		if ($student !== null) {
			return View::make('backend.admin.pedagogie.reinscription.check', compact('student', 'parcour', 'class', 'years', 'annee', 'Onenotes', 'mysum', 'classes', 'reo', 'active'));
		} 
		else {
			return Redirect::route('reInscrit');
		}
	}

	public function Uplevel($id)
	{
		
		if (Request::ajax()) {

			$inputs = Input::all();
			$validation = Validator::make($inputs, ['admis'=> 'required', 'user_id'=> 'required']);
			if ($validation->fails()) {
				return 'false';
			} 
			else {

				$Uplevel 				    = Student::find($id);
				$Uplevel->user_id			= Auth::user()->id;
				$Uplevel->admis 		    = e($inputs['admis']);
				$Uplevel->yearsUniv 		= e($inputs['yearsUniv']);
				$Uplevel->class_id 		    = e($inputs['class_id']);
				$Uplevel->grade 		    = NULL;
				
				//Valeur de paiement sont initié
				$Uplevel->mois_reste 		= 10;
				$Uplevel->payed 			= 0;
				$Uplevel->otherpayed 		= 0;
				$Uplevel->user_getmoney 	= 0;
			}
			$Uplevel->save();
			return 'true';  
        }

	}
	/*public function openNote($id)
	{
	   	$title 		= 'Résultats des examens';
	   	$sous       = 'Liste des classes';  

	   	$parcours  	= Parcour::where('status', 1)->orderBy('id', 'asc')->paginate(10);
		$classes  	= TheClass::all();
		$etudiants 	= Student::find($id);

		$Onenotes 	= Note::where('id_student', $id)->groupBy('yearsUniv')->get();

		$years      = Year::all();

	    return View::make('backend.admin.notes.search.detailNote', compact('classes', 'parcours', 'etudiants', 'years', 'Onenotes'))->with('title', $title)->with('sous', $sous);
	}


	public function myReleve($id, $class, $yearsUniv)
	{
		$title 			= 'Liste des étudiants';
		$sous           = 'Gestion des notes';
		$ui             = 'Releve de notes';

		//$year           = Year::find($id);
		$class   		= TheClass::find($class);
		
		$student 		= Student::find($id);
		
		$totalNote 		= DB::table('notes')
								->where('id_student', $student->id)
								->where('yearsUniv', $yearsUniv)
								->sum('note');

		$countEc 		= DB::table('notes')
								->where('id_student', $student->id)
								->where('yearsUniv', $yearsUniv)
								->count();						

		$Moyenne        = DB::table('notes')
								->where('id_student', $student->id)
								->where('yearsUniv', $yearsUniv)
								->avg('note');
		
								
		$myNote         = Note::where('id_student', $student->id)
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

		return View::make('backend.admin.notes.search.releve', compact('myNote', 'student', 'class', 'countEc', 'mention', 'noteYear', 'totalNote', 'Moyenne', 'noteSem'))->with('title', $title)->with('sous', $sous)->with('ui', $ui);
	}*/
}