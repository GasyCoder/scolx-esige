<?php

class AbsencesTroncController extends BaseController {


	protected $rules = [

		'status' 	=> 'required',
		'dateStart' => 'required',
		'dateEnd'   => 'required',
		'timeStart' => 'required',
		'timeEnd'   => 'required'

	];


	public function matiereTronc($class)
	{
		$title 	 = 'Absence Tronc Commun';
		$sous    = 'Listes des matières tronc commun';
		$class   = TheClass::find($class);

		$ecTronc = EC::where('tronc', 1)->where('status', 1)
					   ->where('class_id', $class->id)
					   ->groupBy('codeEc')
					   ->get();

		return View::make('backend.admin.administration.absence.tronc.ecTronc', compact('class','ecTronc'))->with('title', $title)->with('sous', $sous);
	}

		//Take Students absente or presente
	public function takeAll($class, $element, $codeEc)
	{
		$title 			= 'Ajouter absence';
		$sous    		= 'Absence tronc commun';
		$class 			= TheClass::find($class);
		$year           = Year::where('status', 1)->first();
		$parcours 		= Parcour::where('status', 1)->where('class_id', $class->id)->get();

		$element 	 	= base64_decode(str_pad(strtr($element, '-_', '+/'), strlen($element) % 4, '=', STR_PAD_RIGHT));
		$element 		= EC::find($element);

		$code 	 	= base64_decode(str_pad(strtr($codeEc, '-_', '+/'), strlen($codeEc) % 4, '=', STR_PAD_RIGHT));
		$code 		= EC::find($codeEc);

		$elements   = EC::where('tronc', 1)->where('status', 1)
										  ->where('class_id', $class->id)
										  ->get();

		$studentsTronc 		    = Student::where('class_id', $class->id)
												//->where('parcour_id', '!=', $parcour->id)
		                                        ->where('status', 0)->get();

		return View::make('backend.admin.administration.absence.tronc.addTronc', compact('class', 'element', 'elements', 'studentsTronc', 'parcours', 'year'))->with('title', $title)->with('sous', $sous);															 
	}


	public function submitTronc($class, $element)
	{
		$class 			 = $class;
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
				$absence->parcour_id 	= 0;
				$absence->element_id 	= $element;
				$absence->timeStart 	= $input['timeStart'];
				$absence->timeEnd 		= $input['timeEnd'];
				$absence->dateStart 	= $input['dateStart'];
				$absence->dateEnd 		= $input['dateEnd'];
				$absence->yearsUniv 	= $year->yearsUniv;
				$absence->user_id 		= Auth::id();
				$absence->status 	    = $student;
				$absence->id_student 	= $types[$i];
				$absence->tronc 		= 1;
                $absence->save();
			}
			return Redirect::back()->with('success', ('Ajouté avec succès!'));
		}
	}

	public function alltronc($class, $element)
	{
		$title    = 'Listes par dates et heurs';
		$sous     = 'Tronc commun';
		$class    = TheClass::find($class);
		$year     = Year::where('status', 1)->first();
		$parcours = Parcour::where('status', 1)->where('class_id', $class->id)->get();
		
		$elements = EC::where('tronc', 1)->where('status', 1)
										 ->where('class_id', $class->id)
										 ->groupBy('codeEc')
										 ->get();

		$element = base64_decode(str_pad(strtr($element, '-_', '+/'), strlen($element) % 4, '=', STR_PAD_RIGHT));
		$element = EC::find($element);

		$students = Student::where('status', 0)->where('class_id', $class->id)
												 ->get();

		$absencesTronc = Absence::where('class_id', $class->id)
							->where('element_id', $element->id)
							->where('yearsUniv', $year->yearsUniv)
							->where('tronc', 1)
							->where('active', 1)
							->groupBy('element_id')
							->get();										 

		return View::make('backend.admin.administration.absence.tronc.all', compact('class', 'parcour', 'element', 'absencesTronc', 'students', 'elements', 'parcours', 'year'))->with('title', $title)->with('sous', $sous);
	}


	public function showTroncAb($class, $element, $dateStart, $dateEnd)
	{
		$title 	    = 'Les absents et présents';
		$sous    	= 'Etudiants';
		$class 		= TheClass::find($class);
		$year       = Year::where('status', 1)->first();
		$element 	= base64_decode(str_pad(strtr($element, '-_', '+/'), strlen($element) % 4, '=', STR_PAD_RIGHT));
		$element 	= EC::find($element);

		$mat        = EC::where('tronc', 1)->where('status', 1)
									     ->where('class_id', $class->id)
									     ->where('id', $element->id)
									     ->first();

		$elements   = EC::where('tronc', 1)->where('status', 1)
									     ->where('class_id', $class->id)
									     ->groupBy('codeEc')
									     ->get();

		$parcours = Parcour::where('status', 1)->where('class_id', $class->id)->get();

		$dateStart  = base64_decode(str_pad(strtr($dateStart, '-_', '+/'), strlen($dateStart) % 4, '=', STR_PAD_RIGHT));
		$dateEnd 	= base64_decode(str_pad(strtr($dateEnd, '-_', '+/'), strlen($dateEnd) % 4, '=', STR_PAD_RIGHT));
		
		
		$absenceShow = Absence::where('class_id', $class->id)
														 ->where('dateStart', $dateStart)
														 ->where('dateEnd',   $dateEnd)
														 ->where('yearsUniv', $year->yearsUniv)
														 ->where('tronc', 1)
														 ->where('active', 1)
														 ->get();

		$presents = Absence::where('class_id', $class->id)
							                            ->where('dateStart', $dateStart)
							                            ->where('dateEnd', $dateEnd)
							                            ->where('tronc', 1)
							                            ->where('status', 1)->count();

		$absents = Absence::where('class_id', $class->id)
							                            ->where('dateStart', $dateStart)
							                            ->where('dateEnd', $dateEnd)
							                            ->where('tronc', 1)
							                            ->where('status', 0)->count();

		$mode = Absence::where('class_id', $class->id)
								 				->where('dateStart', $dateStart)
												->where('dateEnd',   $dateEnd)
												->where('tronc', 1)
								 				->where('active', 1)
								 				->first();
								 									                            
		return View::make('backend.admin.administration.absence.tronc.affiche', compact('class', 'element', 'presents', 'absenceShow', 'absents', 'mode', 'dates', 'parcours', 'elements', 'mat', 'year'))->with('title', $title)->with('sous', $sous);	
	}



	public function printAll($class, $element, $dateStart, $dateEnd)
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
														 //->where('parcour_id', $parcour->id)
														 ->where('dateStart', $dateStart)
														 ->where('dateEnd',   $dateEnd)
														 ->where('yearsUniv', $year->yearsUniv)
														 ->where('active', 1)
														 ->get();
											 

		$datyPrint = Absence::where('class_id', $class->id)
												->where('class_id', $class->id)
								 				//->where('parcour_id', $parcour->id)
								 				->where('dateStart', $dateStart)
												->where('dateEnd',   $dateEnd)
								 				->where('active', 1)
								 				->first();	

	    $presents = Absence::where('class_id', $class->id)
							                            //->where('parcour_id', $parcour->id)
							                            ->where('dateStart', $dateStart)
							                            ->where('dateEnd', $dateEnd)
							                            ->where('status', 1)->count();

		$absents = Absence::where('class_id', $class->id)
							                            //->where('parcour_id', $parcour->id)
							                            ->where('dateStart', $dateStart)
							                            ->where('dateEnd', $dateEnd)
							                            ->where('status', 0)->count();

		return View::make('backend.admin.administration.absence.tronc.allprint', compact('class', 'parcour', 'element', 'presents', 'absencePrint', 'absents', 'datyPrint', 'year'))->with('title', $title)->with('sous', $sous);
	}

}