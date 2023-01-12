<?php

class ExamenController extends BaseController {


	public function indexExamen() {

		$title 		= 'Choisir le class';
		$sous       = 'Absence page';
		$parcours  	= Parcour::where('status', 1)->orderBy('id', 'asc')->paginate(10);
		$classes  	= TheClass::all();
		$etudiants 	= Student::orderBy('id', 'asc')->paginate(10);

		$kilasy  	= TheClass::where('id', 1)->first();

		$examens    = EC::where('status', 1)->get();

		return View::make('backend.admin.administration.examens.index', compact('kilasy', 'classes', 'etudiants', 'parcours', 'absences'))->with('title', $title)->with('sous', $sous);
	}



	public function parcoursExamen($class)
	{
		$title 			 = 'Liste des parcours';
		$sous            = 'Gestion des absences';
		$class   		 = TheClass::find($class);
		$parcours 		 = Parcour::where('class_id', $class->id)->where('status', 1)->get();
		$elements 		 = EC::where('class_id', $class->id)->where('status', 1)->get();
		
		return View::make('backend.admin.administration.examens.parcours', compact('elements', 'parcours', 'class', 'ues'))->with('title', $title)->with('sous', $sous);
	}


	//Take Students absente or presente

	public function matieres($class, $parcour)
	{
		$title 	 = 'Gestion des examens';
		$sous    = 'Listes des elements constitutifs';
		$class   = TheClass::find($class);
		$parcour = Parcour::find($parcour);

		$elements = EC::where('status', 1)->where('class_id', $class->id)->where('parcour_id', $parcour->id)->get();

		return View::make('backend.admin.administration.examens.matieres', compact('class', 'parcour', 'elements'))->with('title', $title)->with('sous', $sous);
	}

	
}