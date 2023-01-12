<?php

class AbsencesController extends BaseController {


	protected $rules = [

		'status' 	=> 'required',
		'dateStart' => 'required',
		'dateEnd'   => 'required',
		'timeStart' => 'required',
		'timeEnd'   => 'required'

	];

	public function starAbsence() {

		$title 		= 'Choisir le niveau';
		$sous       = 'Absence page';
		$parcours  	= Parcour::where('status', 1)->orderBy('id', 'asc')->paginate(10);
		$classes  	= TheClass::all();
		$etudiants 	= Student::orderBy('id', 'asc')->paginate(10);

		$kilasy  	= TheClass::where('id', 1)->first();

		$absences   = Absence::where('active', 1)->get();

		return View::make('backend.admin.administration.absence.homepage', compact('kilasy', 'classes', 'etudiants', 'parcours', 'absences'))->with('title', $title)->with('sous', $sous);
	}



	public function parcoursAbsence($class)
	{
		$title 			 = 'Liste des parcours';
		$sous            = 'Gestion des absences';
		$class   		 = TheClass::find($class);
		$parcours 		 = Parcour::where('class_id', $class->id)->where('status', 1)->get();
		$elements 		 = EC::where('class_id', $class->id)->where('status', 1)->get();
		
		return View::make('backend.admin.administration.absence.parcours', compact('elements', 'parcours', 'class', 'ues'))->with('title', $title)->with('sous', $sous);
	}


	//Take Students absente or presente

	public function elementAbsence($class, $parcour)
	{
		$title 	 = 'Gestion des absence';
		$sous    = 'Listes des elements constitutifs';
		$class   = TheClass::find($class);
		$parcour = Parcour::find($parcour);

		$elements = EC::where('tronc', 0)->where('status', 1)->where('class_id', $class->id)->where('parcour_id', $parcour->id)->get();

		return View::make('backend.admin.administration.absence.elements', compact('class', 'parcour', 'elements'))->with('title', $title)->with('sous', $sous);
	}


	//Take Students absente or presente
	public function take($class, $parcour, $element, $codeEc)
	{
		$title 			= 'Gestion d\'absence';
		$sous    		= 'Vérifier les absence';
		$class 			= TheClass::find($class);
		$parcour 		= Parcour::find($parcour);
		$year           = Year::where('status', 1)->first();
		$parcours 		= Parcour::where('status', 1)->where('class_id', $class->id)->get();

		$element 	 	= base64_decode(str_pad(strtr($element, '-_', '+/'), strlen($element) % 4, '=', STR_PAD_RIGHT));
		$element 		= EC::find($element);

		$code 	 	= base64_decode(str_pad(strtr($codeEc, '-_', '+/'), strlen($codeEc) % 4, '=', STR_PAD_RIGHT));
		$code 		= EC::find($codeEc);

		$elements = EC::where('tronc', 0)->where('status', 1)->where('class_id', $class->id)->where('parcour_id', $parcour->id)->get();

		$students 		    = Student::where('class_id', $class->id)
												->where('parcour_id', $parcour->id)
												->where('yearsUniv', $year->yearsUniv)
		                                        ->where('status', 0)->get();

		$students_tronc_commun 		    = Student::where('class_id', $class->id)
												->where('parcour_id', '!=', $parcour->id)
		                                        ->where('status', 0)->get();

		return View::make('backend.admin.administration.absence.takestudent', compact('class', 'parcour', 'element', 'students', 'elements', 'parcours', 'students_tronc_commun', 'year'))->with('title', $title)->with('sous', $sous);															 
	}


	public function submit($class, $parcour, $element)
	{
		$class 			 = $class;
		$parcour 		 = $parcour;
		$year            = Year::where('status', 1)->first();
		$element 	     = base64_decode(str_pad(strtr($element, '-_', '+/'), strlen($element) % 4, '=', STR_PAD_RIGHT));
		$element 		 = $element;

		///$students 		 = Student::where('id', $user_id)->get();

		$input = Input::all();
		$validation = Validator::make($input, $this->rules);
		$path = Session::get('language');
		if($validation->fails()) {
			return Redirect::back()->withInput()->withErrors($validation);
		}
		else {
			//$input = array("status", "matricule");
			$types = $input['matricule'];
			foreach ($input['status'] as $i => $student)
			{
				$absence = new Absence();
				$absence->class_id 		= $class;
				$absence->parcour_id 	= $parcour;
				$absence->element_id 	= $element;
				$absence->timeStart 	= $input['timeStart'];
				$absence->timeEnd 		= $input['timeEnd'];
				$absence->dateStart 	= $input['dateStart'];
				$absence->dateEnd 		= $input['dateEnd'];
				$absence->yearsUniv 	= $year->yearsUniv;
				$absence->user_id 		= Auth::id();
				$absence->status 	    = $student;
				$absence->id_student 	= $types[$i];
                $absence->save();
			}
			return Redirect::back()->with('success', ('Ajouté avec succès!'));
		}
	}

	public function voirlist($class, $parcour, $element)
	{
		$title    = 'Listes par dates et heurs';
		$sous     = 'Gestion des absence';
		$class    = TheClass::find($class);
		$parcour  = Parcour::find($parcour);
		$year     = Year::where('status', 1)->first();
		$parcours = Parcour::where('status', 1)->where('class_id', $class->id)->get();
		$elements = EC::where('tronc', 0)->where('status', 1)->where('class_id', $class->id)->where('parcour_id', $parcour->id)->get();

		$element = base64_decode(str_pad(strtr($element, '-_', '+/'), strlen($element) % 4, '=', STR_PAD_RIGHT));
		$element = EC::find($element);

		$students = Student::where('status', 0)->where('class_id', $class->id)
												->where('parcour_id', $parcour->id)
												->get();
		$absences = Absence::where('class_id', $class->id)
							->where('parcour_id', $parcour->id)
							->where('element_id', $element->id)
							->where('yearsUniv', $year->yearsUniv)
							->where('active', 1)
							->groupBy('created_at')->get();										 

		return View::make('backend.admin.administration.absence.listes', compact('class', 'parcour', 'element', 'absences', 'students', 'elements', 'parcours', 'year'))->with('title', $title)->with('sous', $sous);
	}


	public function view($class, $parcour, $element, $dateStart, $dateEnd)
	{
		$title 	    = 'Les absents et présents';
		$sous    	= 'Etudiants';
		$class 		= TheClass::find($class);
		$parcour 	= Parcour::find($parcour);
		$year       = Year::where('status', 1)->first();
		$element 	= base64_decode(str_pad(strtr($element, '-_', '+/'), strlen($element) % 4, '=', STR_PAD_RIGHT));
		$element 	= EC::find($element);
		$elements   = EC::where('tronc', 0)->where('status', 1)->where('class_id', $class->id)->where('parcour_id', $parcour->id)->get();
		$parcours = Parcour::where('status', 1)->where('class_id', $class->id)->get();

		$dateStart  = base64_decode(str_pad(strtr($dateStart, '-_', '+/'), strlen($dateStart) % 4, '=', STR_PAD_RIGHT));
		$dateEnd 	= base64_decode(str_pad(strtr($dateEnd, '-_', '+/'), strlen($dateEnd) % 4, '=', STR_PAD_RIGHT));
		
		
		$absenceShow = Absence::where('class_id', $class->id)
														 ->where('parcour_id', $parcour->id)
														 ->where('dateStart', $dateStart)
														 ->where('dateEnd',   $dateEnd)
														 ->where('element_id', $element->id)
														 ->where('yearsUniv', $year->yearsUniv)
														 ->where('active', 1)
														 ->orderBy('element_id')
														 ->get();

		$presents = Absence::where('class_id', $class->id)
							                            ->where('parcour_id', $parcour->id)
							                            ->where('dateStart', $dateStart)
							                            ->where('dateEnd', $dateEnd)
							                            ->where('status', 1)->count();

		$absents = Absence::where('class_id', $class->id)
							                            ->where('parcour_id', $parcour->id)
							                            ->where('dateStart', $dateStart)
							                            ->where('dateEnd', $dateEnd)
							                            ->where('status', 0)->count();

		$mode = Absence::where('class_id', $class->id)
								 				->where('parcour_id', $parcour->id)
								 				->where('dateStart', $dateStart)
												->where('dateEnd',   $dateEnd)
								 				->where('active', 1)
								 				->first();
								 									                            
		return View::make('backend.admin.administration.absence.show', compact('class', 'parcour', 'element', 'presents', 'absenceShow', 'absents', 'mode', 'dates', 'parcours', 'elements', 'year'))->with('title', $title)->with('sous', $sous);	
	}



	public function print($class, $parcour, $element, $dateStart, $dateEnd)
	{
		$title 	    = 'Les étudiants absents';
		$sous    	= 'Imprimer';
		$class 		= TheClass::find($class);
		$parcour 	= Parcour::find($parcour);
		$year       = Year::where('status', 1)->first();
		$element 	= base64_decode(str_pad(strtr($element, '-_', '+/'), strlen($element) % 4, '=', STR_PAD_RIGHT));
		$element 	= EC::find($element);
		$dateStart  = base64_decode(str_pad(strtr($dateStart, '-_', '+/'), strlen($dateStart) % 4, '=', STR_PAD_RIGHT));
		$dateEnd 	= base64_decode(str_pad(strtr($dateEnd, '-_', '+/'), strlen($dateEnd) % 4, '=', STR_PAD_RIGHT));

		$absencePrint = Absence::where('class_id', $class->id)
												 ->where('parcour_id', $parcour->id)
												 ->where('dateStart', $dateStart)
												 ->where('dateEnd',   $dateEnd)
												 ->where('yearsUniv', $year->yearsUniv)
												 ->where('active', 1)
												 ->get();
											 

		$datyPrint = Absence::where('class_id', $class->id)
												->where('class_id', $class->id)
								 				->where('parcour_id', $parcour->id)
								 				->where('dateStart', $dateStart)
												->where('dateEnd',   $dateEnd)
								 				->where('active', 1)
								 				->first();	

	    $presents = Absence::where('class_id', $class->id)
							                            ->where('parcour_id', $parcour->id)
							                            ->where('dateStart', $dateStart)
							                            ->where('dateEnd', $dateEnd)
							                            ->where('status', 1)->count();

		$absents = Absence::where('class_id', $class->id)
							                            ->where('parcour_id', $parcour->id)
							                            ->where('dateStart', $dateStart)
							                            ->where('dateEnd', $dateEnd)
							                            ->where('status', 0)->count();

		return View::make('backend.admin.administration.absence.modeprint', compact('class', 'parcour', 'element', 'presents', 'absencePrint', 'absents', 'datyPrint', 'year'))->with('title', $title)->with('sous', $sous);
	}

}