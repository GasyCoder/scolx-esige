<?php

class PayController extends BaseController {

	protected $layouts = 'layouts.backend';

	protected $rules_ecolage = [	
			'title'		=>'required',
			//'nbreMois'	=>'required',
			//'mois'		=> 'required',
			'montant'	=>'required',  
			'status'	=>'required'

	];

	public function indexPay()
	
	{	$title 		= 'Gestion des paiements';
		$sous       = 'Paiement';
		$parcours  	= Parcour::where('status', 1)->orderBy('id', 'asc')->paginate(10);
		$classes  	= TheClass::all();
		$kilasy  	= TheClass::where('id', 1)->first();
		$year       = Year::where('status', 1)->first();
		$etudiants 	= Student::orderBy('id', 'asc')->paginate(10);
		return View::make('backend.admin.administration.Pay.ecolage.index', compact('classes', 'etudiants', 'parcours', 'year', 'kilasy'))->with('title', $title)->with('sous', $sous);
	}

	public function pageEcolage()
	{
		$title 	    = 'Niveau';
		$sous       = 'Gestion des paiements';
		$classes    = TheClass::all();
		$kilasy  	= TheClass::where('id', 1)->first();
		$year       = Year::where('status', 1)->first();
		return View::make('backend.admin.administration.Pay.ecolage.classe', compact('classes', 'year', 'kilasy'))->with('title', $title)->with('sous', $sous);
	}

	public function studParcour($class)
	{
		$title 			 = 'Parcours';
		$sous     		 = 'Gestion des paiements';
		$class   		 = TheClass::find($class);
		$years   		 = Year::all();
		$year   		 = Year::where('status', 1)->first();
		$parcours 		 = Parcour::where('class_id', $class->id)
									->where('status', 1)
									->get();

		return View::make('backend.admin.administration.Pay.ecolage.parcours', compact('parcours', 'class', 'years', 'year'))->with('title', $title)->with('sous', $sous);
	}


	public function etudiantEcolage($class, $parcour)
	{	
		$title 			= 'Gestion des paiements';
		$sous       	= 'Liste des étudiants';
		$inputs 		= Input::all();
		$text_query 	= e(Input::get('q'));
		$class   		= TheClass::find($class);
		$kilasy  	    = TheClass::where('id', 1)->count();
		$parcour 		= Parcour::find($parcour);
		$year   		= Year::where('status', 1)->first();
		$years   		= Year::all();
		$parcours 		= Parcour::where('class_id', $class->id)
									->where('id', '!=', $parcour->id)
									->where('status', 1)
									->get();

		$ecolages  		= Pay::where('class_id', $class->id)
								->where('parcour_id', $parcour->id)
								->get();

		$etudiants 		= Student::where('class_id',  $class->id)
								->where('parcour_id', $parcour->id)
								->where('yearsUniv',  $year->yearsUniv)
								->orderBy('fname', 'asc')
								->get();

		/*$auditeurLibre 		= Student::where('grade', 'AL')
								->where('yearsUniv', $year->yearsUniv)
								->orderBy('fname', 'asc')
								->get();*/						
		
		return View::make('backend.admin.administration.Pay.ecolage.etudiants', compact('etudiants','class', 'parcour', 'parcours', 'ecolages', 'years', 'year', 'auditeurLibre', 'kilasy'))->with('title', $title)->with('sous', $sous);

}

	public function checkPay($id)
	{	
		$title 				= 'Paiement d\'écolage';
		$sous               = 'Vérification de paiement';
		//$years   			= Year::all();
		$year   		    = Year::where('status', 1)->first();
		$classes  			= TheClass::all();
		$allstudents 		= Student::all();
		$instance 			= Instance::find($id);
		
		$ecolages  			= Instance::where('id',  $id)
									->where('yearsUniv', $year->yearsUniv)
									->where('mois_reste', 0)
									->count();

		return View::make('backend.admin.administration.Pay.ecolage.addEcolage', compact('allstudents', 'instance', 'classes', 'years', 'ecolages', 'year'))->with('title', $title)->with('sous', $sous);
	}


  public function payStore($id) 
  {
	$student 	= Instance::find($id);

	if ($student !== null) {
			
			$inputs = Input::all();

			if ($student->mois_reste < e(Input::get('nbreMois'))) {

				return Redirect::back()->withError('Désolé! le mois doit être inférieur = 10!');
			}


			$validation = Validator::make($inputs, $this->rules_ecolage);
			if ($validation->fails()) {
				return Redirect::back()->withInput()->withErrors($validation);

			} else {

				$payment_index 	= rand(11111, 99999);	

				if (Input::has('mois')) {
				$mois 			= implode(",", $inputs['mois']);

				$ecolage 			= Pay::create([
					'user_id'		=> Auth::user()->id,
					'id_etudiant' 	=> e($inputs['id_etudiant']),
					'class_id' 		=> e($inputs['class_id']),
					'parcour_id' 	=> e($inputs['parcour_id']),
					'yearsUniv' 	=> e($inputs['yearsUniv']),
					//'lname' 		=> e($inputs['lname']),

					'title' 		=> e($inputs['title']),
					'nbreMois' 		=> e($inputs['nbreMois']),
					'montant' 		=> e($inputs['montant']),
					'status' 		=> e($inputs['status']),
					'mois' 			=> $mois,
					'payment_index' => $payment_index

				]);
			}	
			else {

				$ecolage 			= Pay::create([
					'user_id'		=> Auth::user()->id,
					'id_etudiant' 	=> e($inputs['id_etudiant']),
					'class_id' 		=> e($inputs['class_id']),
					'parcour_id' 	=> e($inputs['parcour_id']),
					'yearsUniv' 	=> e($inputs['yearsUniv']),
					//'lname' 		=> e($inputs['lname']),
					'title' 		=> e($inputs['title']),
					'montant' 		=> e($inputs['montant']),
					'status' 		=> e($inputs['status']),
					'payment_index' => $payment_index

				]);
				
			}

		$ecolage->save();
		 if (Input::has('nbreMois')) {
			$student->mois_reste                = $student->mois_reste - e($inputs['nbreMois']);
			$student->payed 					= 1;
		   }
		  $student->otherpayed 					= 1;
		  $student->user_getmoney 	= Auth::user()->id;
		  $student->save();
		  return Redirect::back()->with('success', ('Paiement a été fait avec succès!'));
		}
	}
}
	public function editPay($id)
	{
		$title 		= 'Modifier';
		$sous       = 'Informations';
		$editPay 	= Pay::find($id);
		if ($editPay !== null) {
			return View::make('backend.admin.administration.Pay.ecolage.update', compact('editPay'))->with('title', $title)->with('sous', $sous);
		} else {
			return Redirect::route('indexPay');
		}
	}

public function payUpdate($id) {

$updatePay 					= Pay::find($id);

if ($updatePay !== null) {
			
			$inputs 	= Input::all();
			$student 	= Student::find($id);
			if ($student->mois_reste < e(Input::get('nbreMois'))) {

				return Redirect::back()->withError('Désolé! le mois doit être inférieur = 10!');
			} 

			$validation = Validator::make($inputs, $this->rules_ecolage);
			if ($validation->fails()) {
				return Redirect::back()->withInput()->withErrors($validation);

			} else {

				//$payment_index 	= round(microtime(true));
				$payment_index 	= rand(11111, 99999);	
				$mois 			= implode(",", $inputs['mois']);
				
				$updatePay->user_id 		= Auth::user()->id;

				$updatePay->title 			= e($inputs['title']);
				$updatePay->nbreMois 		= e($inputs['nbreMois']);
				$updatePay->montant 		= e($inputs['montant']);
				$updatePay->mois 			= $mois;
				$updatePay->payment_index 	= $payment_index;	
			}
			
				if (Input::has('status'))
				   {
				    $updatePay->status = 1;
				   }else {
				    $updatePay->status = 0;
				}

			$updatePay->save();
			return Redirect::back()->with('success', ('Informations de paiement a été changé avec succès!'));
		}
	}


	public function cartePay($instance, $class, $parcour)
	{	
		$title          = 'Details';
		$sous       	= 'Paiement';
		$year           = Year::where('status', 1)->first();
		$class 			= TheClass::find($class);
		$parcour 		= Parcour::find($parcour);
		$instance       = Instance::find($instance);

		$cartes 		= Pay::where('id_etudiant', 		$instance->id)
								   ->where('class_id', 		$class->id)
								   ->where('parcour_id', 	$parcour->id)
								   ->where('yearsUniv', 	$year->yearsUniv)
								   ->get();

		$TotalMois      = Pay::where('id_etudiant', 		$instance->id)
								   ->where('class_id', 		$class->id)
								   ->where('parcour_id', 	$parcour->id)
								   ->where('nbreMois', '>=', 1)
								   ->where('yearsUniv', 	$year->yearsUniv)
								   ->sum('nbreMois');

		$retenu         = Pay::where('id_etudiant', 		$instance->id)
								   ->where('class_id', 		$class->id)
								   ->where('parcour_id', 	$parcour->id)
								   ->where('nbreMois', '<=', 0)
								   ->where('yearsUniv', 	$year->yearsUniv)
								   ->sum('nbreMois');

		$sisaMois           = 10-$TotalMois;

		$sumEcolage 	= Ecolage::where('class_id', $class->id)
									->sum('total');
		$droitSum 		= Ecolage::where('class_id', $class->id)
									->sum('droit');	
		$pricU 			= Ecolage::where('class_id', $class->id)
									->sum('priceU');	
		//Calcule
		$varPay 		= Pay::where('id_etudiant', $instance->id)->sum('montant');												
		$restePay       = $sumEcolage-$varPay;

		return View::make('backend.admin.administration.Pay.ecolage.carte', compact('cartes', 'instance', 'retenu', 'sisaMois', 'TotalMois', 'class', 'parcour', 'sumEcolage', 'droitSum', 'pricU', 'restePay', 'varPay'))->with('title', $title)->with('sous', $sous);
	}


	public function pay_invoice($id, $class)
	{
		$title          = 'Facture de paiement';
		$sous       	= 'Facture 1/1';
		$allFacture 	= Pay::find($id);
		$year           = Year::where('status', 1)->first();
		$control 		= Control::find(1);
		$class          = TheClass::find($class);
		$pay_total 		= Ecolage::where('class_id', $class->id)
										->sum('total');
		$pricU 			= Ecolage::where('class_id', $class->id)
									->sum('priceU');
		$droitU 		= Ecolage::where('class_id', $class->id)
									->sum('droit');													
		$payment_Tax 	= $control->payment_tax;
		$payment_Remise = $control->remise;

		$tax 			= $pay_total * $payment_Tax / 100 ; // 1000000*10/100 = 20%
		$remise 		= $pay_total * $payment_Remise / 100;

		$qte 		 	= $allFacture->nbreMois;
		$subtotal1   	= $qte*$pricU;
		//$subtotal2   	= $qte*$droitU;

		return View::make('backend.admin.administration.Pay.ecolage.facture', 
			compact('allFacture', 'tax', 'ecolage', 'remise', 'total', 'control', 'class', 'pricU', 'droitU', 'subtotal1', 'qte'))->with('title', $title)->with('sous', $sous);
	}

	public function all_invoice($student, $class, $parcour)
	{
		$title          = 'Facture de paiement';
		$sous       	= 'Tous les factures';
		$year           = Year::where('status', 1)->first();
		$student 		= Student::find($student);
		//$facture 		= Pay::find($facture);
		$class 			= TheClass::find($class);
		$parcour 		= Parcour::find($parcour);
		$control 		= Control::find(1);
		
		$allFactures   = Pay::where('id_etudiant', 			$student->id)
							->where('class_id', 			$class->id)
							->where('parcour_id', 			$parcour->id)
							->get(); 

		$allFacture   = Pay::where('id_etudiant', 			$student->id)
							->where('class_id', 			$class->id)
							->where('parcour_id', 			$parcour->id)
							->first();					
		
		$pay_total 		= Ecolage::where('class_id', 		$class->id)
									->sum('total');
		$pricU 			= Ecolage::where('class_id', 		$class->id)
									->sum('priceU');
		$droitU 		= Ecolage::where('class_id', $class->id)
									->sum('droit');

		$payment_Tax 	= $control->payment_tax;
		$payment_Remise = $control->remise;

		$tax 			= $pay_total * $payment_Tax / 100 ;
		$remise 		= $pay_total * $payment_Remise / 100;

		$qte 		 	= $allFacture->nbreMois;
		$subtotal1   	= $qte*$pricU;

		return View::make('backend.admin.administration.Pay.ecolage.allfacture', 
			compact('student', 'pay_total', 'tax', 'remise', 'control', 'class', 'allFactures', 'class', 'parcour', 'pricU', 'droitU', 'subtotal1', 'qte'))->with('title', $title)->with('sous', $sous);

	}

	public function deletePay($id)
	{
		$disabled = Pay::find($id);
		
		if ($disabled !== null) {
			$disabled->blocage = 1;
			$disabled->status = 0;
			$disabled->save();
			// delete payment from Etudiant table
			
			/*$instances = Instance::where('id', $disabled->id)->get();
			foreach ($instances as $instance) {
				$instance->payBloq 		= 1;
				$instance->save();
			}*/
			return Redirect::back()->with('success', ('Cet étudiant a été deplacé dans la corbeille!'));
		} 
		else {
			return Redirect::back();
		}
	}

}