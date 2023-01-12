<?php
class DeliberController extends BaseController {

	public function deliberation_1($class, $parcour)
	{
		$title 			 	= 'Déliberation 1er Semestre';
		$sous            	= 'déliberation';
		$year 			 	= Year::where('status', 1)->first();
		$class   		 	= TheClass::find($class);
		$parcour 		 	= Parcour::find($parcour);

		$delibers     		= Note::where('yearsUniv', 			$year->yearsUniv)
			                         	 ->where('class_id', 	$class->id)
			                         	 ->where('parcour_id', 	$parcour->id)
			                         	 ->where('semestre', 1)
			                         	 ->groupBy('id_student')
			                         	 ->get(); 

		$students 	 		= Credit::where('status', 1)
			        			->where('semestre', 1)
			        			->where('session', 1)
			        			->where('parcour_id', 	$parcour->id)
			        			->where('class_id', 	$class->id)
			        			->groupBy('id_student')
			        			->where('yearsUniv', $year->yearsUniv)
			        			->get();

		return View::make('backend.admin.notes.result.deliberation.deliberation_1', compact('year', 'class', 'delibers', 'parcour', 'students'))->with('title', $title)->with('sous', $sous);
	}

	public function submitDeliber($class, $parcour)
	{
		$input = Input::all();
		$validation = Validator::make($input, []);
		if($validation->fails()) {
			return Redirect::back()->withInput()->withErrors($validation);
		}
		else {

			$al    		= $input['grade'];
			$par   		= $input['parcour_id'];
			$clas  		= $input['class_id'];
			$year  		= $input['yearsUniv'];
			$moy   		= $input['moyenne'];
			$som   		= $input['somme'];
			$deli 		= $input['deliberation'];

			foreach ($input['id_student'] as $i => $done)
			{
				$deliber = new Delibera();
				
				$deliber->id_student 		= $done;
				$deliber->grade 			= $al[$i];

				$deliber->deliberation 	    = $deli[$i];
				$deliber->parcour_id 		= $par[$i];
				$deliber->class_id 			= $clas[$i];
				$deliber->yearsUniv 		= $year[$i];

				$deliber->moyenne 			= $moy[$i];
				$deliber->somme 			= $som[$i];

				$deliber->semestre 			= 1;
				$deliber->session       	= 1;
				$deliber->status         	= 1;

                $deliber->save();
			}

			return Redirect::to('/admin/resultats_examen/semestre_1/vérification/'.$class.'/'.$parcour)->withSuccess('Résultats d\'examen a été activé!');
		}
	}


	public function restoreDeliber($class, $parcour)
	{
		$restores1 = Deliberation::where('semestre', 1)->where('session', 1)->get();
		foreach ($restores1 as $restore1) {
				$restore1->delete();
		}
		return Redirect::to('/admin/resultats_examen/semestre_1/vérification/'.$class.'/'.$parcour)->withWarning('Vous avez réinitialisé la déliberation 1er Semestre!');
	}


////////////////////SEMESTRE 2//////////////////////

	public function deliberation_2($class, $parcour)
	{
		$title 			 	= 'Déliberation 1er Semestre';
		$sous            	= 'déliberation';
		$year 			 	= Year::where('status', 1)->first();
		$class   		 	= TheClass::find($class);
		$parcour 		 	= Parcour::find($parcour);

		$delibers     		= Note::where('yearsUniv', 			$year->yearsUniv)
			                         	 ->where('class_id', 	$class->id)
			                         	 ->where('parcour_id', 	$parcour->id)
			                         	 ->where('semestre', 2)
			                         	 ->groupBy('id_student')
			                         	 ->get(); 

		$students 	 		= Credit::where('status', 1)
			        			->where('semestre', 2)
			        			->where('session', 1)
			        			->where('parcour_id', 	$parcour->id)
			        			->where('class_id', 	$class->id)
			        			->groupBy('id_student')
			        			->where('yearsUniv', $year->yearsUniv)
			        			->get();

		return View::make('backend.admin.notes.result.deliberation.deliberation_2', compact('year', 'class', 'delibers', 'parcour', 'students'))->with('title', $title)->with('sous', $sous);
	}

	public function submitDeliber_2($class, $parcour)
	{
		$input = Input::all();
		$validation = Validator::make($input, []);
		if($validation->fails()) {
			return Redirect::back()->withInput()->withErrors($validation);
		}
		else {

			$al    		= $input['grade'];
			$par   		= $input['parcour_id'];
			$clas  		= $input['class_id'];
			$year  		= $input['yearsUniv'];
			$moy   		= $input['moyenne'];
			$som   		= $input['somme'];
			$deli 		= $input['deliberation'];

			foreach ($input['id_student'] as $i => $done)
			{
				$deliber = new Delibera();
				
				$deliber->id_student 		= $done;
				$deliber->grade 			= $al[$i];

				$deliber->deliberation 	    = $deli[$i];
				$deliber->parcour_id 		= $par[$i];
				$deliber->class_id 			= $clas[$i];
				$deliber->yearsUniv 		= $year[$i];

				$deliber->moyenne 			= $moy[$i];
				$deliber->somme 			= $som[$i];

				$deliber->semestre 			= 2;
				$deliber->session       	= 1;
				$deliber->status         	= 1;

                $deliber->save();
			}

			return Redirect::to('/admin/resultats_examen/semestre_2/vérification/'.$class.'/'.$parcour)->withSuccess('La déliberation semestre 2 a été confirmé!');
		}
	}


	public function restoreDeliber_2($class, $parcour)
	{
		$restores2 = Delibera::where('semestre', 2)->where('session', 1)->get();
		foreach ($restores1 as $restore2) {
				$restore2->delete();
		}
		return Redirect::to('/admin/resultats_examen/semestre_2/vérification/'.$class.'/'.$parcour)->withWarning('Vous avez réinitialisé la déliberation 2em Semestre!');
	}

///Déliberations
	public function indexdeliber()
	{
		$title 		= 'Déliberation';
		$delibers 	= Deliberation::orderBy('id', 'asc')->get();
		return View::make('backend.admin.notes.result.deliberation.config.index', compact('delibers'))->with('title', $title);
	}

	public function savedeliber()
	{
		if (Request::ajax()){

	
			$inputs = Input::all();
			$validation = Validator::make($inputs, ['moyenne'=>'required']);
			
			if ($validation->fails()) {
				return 'false';
			} 

			else {
				$deliber = Deliberation::create([

					'moyenne' 		=> e($inputs['moyenne']),
					'session' 		=> e($inputs['session'])
				]);
				return 'true';
			}

        }
	}

	public function deleteDeliber($id) {

		$delete  = Deliberation::find($id);

		$delete->delete();

		return Redirect::back()->with('success', ('Déliberation a été supprimé avec succès!'));
	}

}