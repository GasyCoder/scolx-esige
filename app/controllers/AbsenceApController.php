<?php

class AbsenceApController extends BaseController {


	protected $rules = [

		'status' => 'required',
		'dateStart' => 'required',
		'dateEnd'   => 'required',
		'timeStart' => 'required',
		'timeEnd'   => 'required',

	];

	public function ap($class)
	{
		$title 			 = 'Liste des parcours';
		$sous            = 'Gestion des absences';
		$class   		 = TheClass::find($class);
		$matieres 		 = EC::where('class_id', $class->id)->where('class_id', $class->id)->where('status', 1)->get();
		
		return View::make('backend.admin.administration.absence.ap.matieres', compact('matieres', 'class'))->with('title', $title)->with('sous', $sous);
	}


	//Take Students absente or presente
	public function takeAp($class, $element)
	{
		$title 			= 'Gestion d\'absence';
		$sous    		= 'Vérifier les absence';
		$class 			= TheClass::find($class);
		$year           = Year::where('status', 1)->first();
		$element 	 	= base64_decode(str_pad(strtr($element, '-_', '+/'), strlen($element) % 4, '=', STR_PAD_RIGHT));
		$element 		= EC::find($element);

		$mat            = EC::where('status', 1)
									     ->where('class_id', $class->id)
									     ->where('id', $element->id)
									     ->first();

		$elements 			= EC::where('status', 1)->where('class_id', $class->id)
													->where('id', '!=',$element->id)
													->get();

		$studentsAp 		= Student::where('class_id', $class->id)
		                               ->where('status', 0)
		                               ->get();

		$mixtes 		    = Student::where('class_id', '!=', $class->id)
										->where('grade', 'AL')
		                                ->where('status', 0)
		                                ->get();                                                                               
		return View::make('backend.admin.administration.absence.ap.take', compact('class', 'element', 'mixtes', 'elements', 'studentsAp', 'mat', 'year', 'show'))->with('title', $title)->with('sous', $sous);															 
	}


	public function submitAp($class, $element)
	{
		$class 			 = $class;
		$year            = Year::where('status', 1)->first();
		$element 	     = base64_decode(str_pad(strtr($element, '-_', '+/'), strlen($element) % 4, '=', STR_PAD_RIGHT));
		$element 		 = $element;

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
				$absence->parcour_id 	= 1;
				$absence->al_value 		= 1;
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
			//return Redirect::back()->with('success', ('Ajouté avec succès!'));
			return Redirect::to('/admin/absences/etudiants/anne_preparatoire/'.$class)->withSuccess('Ajouté avec succès!');
		}
	}

	public function listeAp($class, $element)
	{
		$title    = 'Listes par dates et heurs';
		$sous     = 'Gestion des absence';
		$class    = TheClass::find($class);
		$year     = Year::where('status', 1)->first();
		
		$element = base64_decode(str_pad(strtr($element, '-_', '+/'), strlen($element) % 4, '=', STR_PAD_RIGHT));

		$element = EC::find($element);

		$elements = EC::where('status', 1)->where('class_id', $class->id)->get();
		$students = Student::where('status', 0)->where('class_id', $class->id)
												 ->get();
		$absences = Absence::where('class_id', $class->id)
							->where('element_id', $element->id)
							->where('yearsUniv',  $year->yearsUniv)
							->where('active', 1)
							->groupBy('created_at')
							->get();										 

		return View::make('backend.admin.administration.absence.ap.listes', compact('class', 'element', 'absences', 'students', 'elements', 'year'))->with('title', $title)->with('sous', $sous);
	}


	public function view($class, $element, $dateStart, $dateEnd)
	{
		$title 	    = 'Les absents et présents';
		$sous    	= 'Etudiants';
		$class 		= TheClass::find($class);
		$year       = Year::where('status', 1)->first();
		$element 	= base64_decode(str_pad(strtr($element, '-_', '+/'), strlen($element) % 4, '=', STR_PAD_RIGHT));
		$element 	= EC::find($element);
		$elements = EC::where('status', 1)->where('class_id', $class->id)->get();
		$dateStart  = base64_decode(str_pad(strtr($dateStart, '-_', '+/'), strlen($dateStart) % 4, '=', STR_PAD_RIGHT));
		$dateEnd 	= base64_decode(str_pad(strtr($dateEnd, '-_', '+/'), strlen($dateEnd) % 4, '=', STR_PAD_RIGHT));
		
		$absenceShow = Absence::where('class_id', $class->id)
														 ->where('dateStart', $dateStart)
														 ->where('dateEnd',   $dateEnd)
														 ->where('active', 1)
														 ->get();

		$presents = Absence::where('class_id', $class->id)
							                            ->where('dateStart', $dateStart)
							                            ->where('dateEnd', $dateEnd)
							                            ->where('status', 1)->count();

		$absents = Absence::where('class_id', $class->id)
							                            ->where('dateStart', $dateStart)
							                            ->where('dateEnd', $dateEnd)
							                            ->where('status', 0)->count();

		$mode = Absence::where('class_id', $class->id)
										 				->where('dateStart', $dateStart)
														->where('dateEnd',   $dateEnd)
										 				->where('active', 1)
										 				->first();

		return View::make('backend.admin.administration.absence.ap.show', compact('class', 'element', 'presents', 'absenceShow', 'absents', 'mode', 'dates', 'elements', 'year'))->with('title', $title)->with('sous', $sous);	
	}



	public function print($class, $element, $dateStart, $dateEnd)
	{
		$title 	    = 'Les étudiants absents';
		$sous    	= 'Imprimer';
		$class 		= TheClass::find($class);
		$year       = Year::where('status', 1)->first();
		$element 	= base64_decode(str_pad(strtr($element, '-_', '+/'), strlen($element) % 4, '=', STR_PAD_RIGHT));
		$element 	= EC::find($element);
		$dateStart  = base64_decode(str_pad(strtr($dateStart, '-_', '+/'), strlen($dateStart) % 4, '=', STR_PAD_RIGHT));
		$dateEnd 	= base64_decode(str_pad(strtr($dateEnd, '-_', '+/'), strlen($dateEnd) % 4, '=', STR_PAD_RIGHT));

		$absencePrint = Absence::where('class_id', $class->id)
														 ->where('dateStart', $dateStart)
														 ->where('dateEnd',   $dateEnd)
														 ->where('yearsUniv', $year->yearsUniv)
														 ->where('active', 1)
														 ->get();


		$datyPrint = Absence::where('class_id', $class->id)
												->where('class_id', $class->id)
								 				->where('dateStart', $dateStart)
												->where('dateEnd',   $dateEnd)
								 				->where('active', 1)
								 				->first();	

	    $presents = Absence::where('class_id', $class->id)
							                            ->where('dateStart', $dateStart)
							                            ->where('dateEnd', $dateEnd)
							                            ->where('status', 1)->count();

		$absents = Absence::where('class_id', $class->id)
							                            ->where('dateStart', $dateStart)
							                            ->where('dateEnd', $dateEnd)
							                            ->where('status', 0)->count();

		return View::make('backend.admin.administration.absence.ap.print', compact('class', 'element', 'presents', 'absencePrint', 'absents', 'datyPrint', 'year'))->with('title', $title)->with('sous', $sous);
	}


}