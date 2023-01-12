<?php

class NoteApController extends BaseController {


	protected $rules = [

		'note' => 'required'

	];

	public function openAp($class)
	{
		$title 			 = 'Liste des matières';
		$sous            = 'Gestion des notes';
		$class   		 = TheClass::find($class);
		$years 			 = Year::where('status', 1)->first();
		$cours 		 	 = EC::where('class_id', $class->id)->where('status', 1)->get();
		
		return View::make('backend.admin.notes.ap.matieresAp', compact('cours', 'class', 'years'))->with('title', $title)->with('sous', $sous);
	}


	//Take Students absente or presente
	public function addNoteAp($class, $element)
	{
		$title 			= 'Ajouter notes';
		$sous    		= 'Gestion des notes';
		$class 			= TheClass::find($class);
		$years 			= Year::where('status', 1)->first();
		$element 	 	= base64_decode(str_pad(strtr($element, '-_', '+/'), strlen($element) % 4, '=', STR_PAD_RIGHT));
		$element 		= EC::find($element);

		$elements 			= EC::where('status', 1)
								->where('id', '!=', $element->id)
								->where('class_id', $class->id)
								->get();

		$studentsAp 		= Student::where('class_id', $class->id)
									   ->where('yearsUniv', $years->yearsUniv)
		                               ->where('status', 0)->get();

		$mixtes 		    = Student::where('class_id', '!=', $class->id)
												->where('yearsUniv', $years->yearsUniv)
												->where('grade', 'AL')
		                                        ->where('status', 0)->get();                                                                                
		$ues   		= UE::where('tronc', 0)->where('status', 1)
												->where('class_id', $class->id)
												->where('codeUe', $element->codeUe)
												->first();

		$fixes 		= Note::where('class_id', $class->id)
								->where('element_id', $element->id)
								->where('yearsUniv', $years->yearsUniv)
								->first();

		return View::make('backend.admin.notes.ap.addNote', compact('class', 'element', 'mixtes', 'elements', 'studentsAp', 'years', 'ues', 'fixes'))->with('title', $title)->with('sous', $sous);															 
	}


	public function submitNoteAp($class, $element, $codeEc)
	{
		$class 			 = $class;
		$element 	     = base64_decode(str_pad(strtr($element, '-_', '+/'), strlen($element) % 4, '=', STR_PAD_RIGHT));
		$element 		 = $element;

		$input = Input::all();
		$validation = Validator::make($input, $this->rules);
		$path = Session::get('language');
		if($validation->fails()) {
			return Redirect::back()->withInput()->withErrors($validation);
		}
		else {

			$id = $input['etudiant_id'];
			$al = $input['grade'];
			foreach ($input['note'] as $i => $student)
			{
				$notes = new Note();
				$notes->class_id 	= $class;
				$notes->parcour_id 	= 1; 
				$notes->element_id 	= $element;
				$notes->codeEc 		= $codeEc;
				$notes->user_id 	= Auth::id();
				$notes->note 	    = $student;
				$notes->id_student 	= $id[$i];
				$notes->yearsUniv 	= $input['yearsUniv'];
				$notes->grade 		= $al[$i];
				$notes->codeUe 		= $input['codeUe'];
                $notes->save();
			}
			//return Redirect::back()->with('success', ('Ajouté avec succès!'));
			return Redirect::to('admin/ajouter_notes/anne_preparatoire/'.$class)->withSuccess('Le note a été ajouté avec succès!');
		}
	}

	public function showNoteAp($class, $parcour, $element, $codeEc)
	{
		$title 			= 'Notes par matières';
		$sous    		= 'Gestion des notes';
		$ui         	= 'Notes';
		$class 			= TheClass::find($class);
		$parcour 		= Parcour::find($parcour);
		$years 			= Year::where('status', 1)->first();
		$semestres		= Sem::all();

		$element 	 	= base64_decode(str_pad(strtr($element, '-_', '+/'), strlen($element) % 4, '=', STR_PAD_RIGHT));
		$element 		= EC::find($element);

		$Marks 			= Note::where('status', 1)
											->where('class_id', 1)
											->where('parcour_id', 1)
											->where('element_id', $element->id)
											->get();

		$students 		= Student::where('class_id', 1)
												->where('parcour_id', 1)
		                                        ->where('status', 0)->get();

        $elements       = EC::where('tronc', 0)->where('status', 1)
												->where('class_id', 1)
												->where('parcour_id', 1)
												->where('id', '!=', $element->id)
												->get();

		return View::make('backend.admin.notes.ap.shownote', compact('class', 'parcour', 'element', 'students', 'Marks', 'parcours', 'years', 'semestres', 'elements'))->with('title', $title)->with('sous', $sous)->with('ui', $ui);															
	}

	public function modifierNoteAp($id, $class, $user, $element)
	{
		$title 		= 'Modifier';
		$sous       = 'Note';
		$class      = TheClass::find($class);
		$element = base64_decode(str_pad(strtr($element, '-_', '+/'), strlen($element) % 4, '=', STR_PAD_RIGHT));

		$element 		= EC::find($element);
		$mark 		 	= Note::find($id);
		$student     	= Student::find($user);
		
		$elex   	    = EC::where('tronc', 0)->where('status', 1)
											->where('codeEc', $element->codeEc)
											->where('id', $element->id)
											->where('class_id', $class->id)
											->first();


		return View::make('backend.admin.notes.update.modifierAp', compact('mark', 'element', 'class', 'elex'))->with('title', $title)->with('sous', $sous);

	}

}