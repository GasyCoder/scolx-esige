<?php

class CertificatController extends BaseController {

	protected $layouts = 'backend.admin';

	public function indexCerti()
	
	{	$title 		= 'Certificat de Scolarité';
		$sous       = 'Liste des classes';
		$year       = Year::where('status', 1)->first();
		$parcours  	= Parcour::where('status', 1)->orderBy('id', 'asc')->paginate(10);
		$classes  	= TheClass::all();
		$kilasy  	= TheClass::where('id', 1)->first();
		$etudiants 	= Student::orderBy('id', 'asc')->paginate(10);
		return View::make('backend.admin.pedagogie.Etudiants.certificat.indexCerti', compact('kilasy', 'classes', 'etudiants', 'parcours', 'year'))->with('title', $title)->with('sous', $sous);
	}


	public function certifParcour($class)
	{
		$title 			 = 'Certificat de Scolarité';
		$sous       	 = 'Liste des parcours';
		$class   		 = TheClass::find($class);
		$years   		 = Year::where('status', 1)->get();
		$parcours 		 = Parcour::where('class_id', $class->id)->where('status', 1)->get();

		return View::make('backend.admin.pedagogie.Etudiants.certificat.parcours', compact('parcours', 'class', 'years'))->with('title', $title)->with('sous', $sous);
	}


	public function studentsCertfi($class, $parcour)
	{	
		$title 			= 'Liste des étudiants';
		$sous       	= 'par classe et parcours';
		$class   		= TheClass::find($class);
		$parcour 		= Parcour::find($parcour);
		$years   		= Year::all();
		$year   		= Year::where('status', 1)->first();
		$parcours 		= Parcour::where('class_id', $class->id)
									->where('id', '!=', $parcour->id)
									->where('status', 1)
									->get();
		
		$etudiants 		= Student::where('class_id', $class->id)
									->where('parcour_id', $parcour->id)
									->where('yearsUniv', $year->yearsUniv)
									->orderBy('id', 'asc')->get();

		$libres 		= Student::where('grade', 'AL')
								->where('yearsUniv', $year->yearsUniv)
								->orderBy('id', 'asc')->get();


		$studs 			= Student::where('class_id', $class->id)
									->where('parcour_id', $parcour->id)
									->where('yearsUniv', $year->yearsUniv)
									->orderBy('id', 'asc')
									->count();

		$Mixt 			= Student::where('grade', 'AL')
									->where('yearsUniv', $year->yearsUniv)
									->orderBy('id', 'asc')
									->count();

		return View::make('backend.admin.pedagogie.Etudiants.certificat.students', compact('etudiants', 'class', 'parcour', 'parcours', 'years', 'libres', 'studs', 'Mixt', 'year'))->with('title', $title)->with('sous', $sous);
	}

	public function motifCertifi($student, $class, $parcour)
	{
		$title 			 = 'Certificat de Scolarité';
		$sous       	 = 'Motif de demande';
		$student 		 = Student::find($student);
		$class   		 = TheClass::find($class);
		$parcours 		 = Parcour::find($parcour);
		$years   		 = Year::where('status', 1)->get();
		$certifi    	 = Certifica::where('id_student',   $student->id)
									  //->where('class_id',   $class->id)
									  //->where('parcour_id', $parcour->id)
									  ->count();

		return View::make('backend.admin.pedagogie.Etudiants.certificat.motif', compact('parcours', 'class', 'years', 'student', 'certifi'))->with('title', $title)->with('sous', $sous);
	}


	public function submitCertifi($student, $class, $parcour)
	{
		$input = Input::all();
		$validation = Validator::make($input, ['motif'=>'required']);
		if($validation->fails()) {
			return Redirect::back()->withInput()->withErrors($validation);
		}
		else {
				$ref 		= rand(11111, 99999);
				$certifica 	= new Certifica();
			
				$certifica->id_student 	    = $student;
				$certifica->class_id 		= $class;
				$certifica->parcour_id 		= $parcour;
				$certifica->motif 			= $input['motif'];
				$certifica->ref   			= $ref;
				$certifica->status   		= 0;

                $certifica->save();

               return Redirect::to('/admin/certificat-scolarite/etudiants/show/'.$student.'/'.$class.'/'.$parcour)->withSuccess('Certificat de Scolarité a été confirmé!');
		}
	}

	public function readCertif($student, $class, $parcour)
	{
		$title 			 	= 'Liste des certificats de scolarité';
		$sous            	= 'Certificat de Scolarité';
		$year 			 	= Year::where('status', 1)->first();
		$class   		 	= TheClass::find($class);
		$parcour 		 	= Parcour::find($parcour);
		$student 		 	= Student::find($student);

		$certif 			= Certifica::where('status', 0)->first();

		$certificates       = Certifica::where('id_student', 	$student->id)
			                         	 ->where('class_id', 	$class->id)
			                         	 ->where('parcour_id', 	$parcour->id)
			                         	 ->orderBy('id', 'asc')
			                         	 ->get(); 

		return View::make('backend.admin.pedagogie.Etudiants.certificat.show', compact('year', 'class', 'parcour', 'student', 'certificates', 'certif'))->with('title', $title)->with('sous', $sous);
	}


	public function printCertifi($id, $class, $parcour, $ref)
	{
		$title 			 = 'Certificat de Scolarité';
		$sous       	 = 'Motif de demande';
		$certifi 		 = Certifica::find($id);
		$years   		 = Year::where('status', 1)->first();
		
		//$certifi    	 = Certifica::where('id_student', $student->id)->get();

		return View::make('backend.admin.pedagogie.Etudiants.certificat.print', compact('years', 'certifi'))->with('title', $title)->with('sous', $sous);
	}
  
  	public function supprimer($id)
	{
		$certifica = Certifica::find($id);
		if ($certifica !== null) {
			$certifica->delete();
			return Redirect::back()->with('error', ('Certificat de Scolarité a été supprimé avec succès!'));
		} 
		else {
			return Redirect::back();
		}
	}
}