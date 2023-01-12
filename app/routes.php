<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

// ------> language
Route::get('/lang', ['uses'=>'HomeController@language']);
// ------> sitemap
Route::get('/sitemap.xml', 'HomeController@sitemap');

Route::group(['before'=>'closed'], function(){
	// ------> home
	Route::get('/', ['as'=>'home', 'uses'=>'HomeController@showWelcome']);
});

Route::get('logout', ['as'=>'users.logout', 'uses'=>'UserController@logout']);

//--------> if users in auth redirect to home
Route::group(['before'=>'user_in_auth'], function(){

		// ------> login
		Route::get('login', ['as'=>'login', 'uses'=>'UserController@login']);
		Route::post('check', ['as'=>'users.check', 'uses'=>'UserController@check']);

		// ------> register
		Route::get('register', ['as'=>'register', 'uses'=>'UserController@register']);
		
		Route::post('register/store', ['as'=>'register_store', 'uses'=>'UserController@register_store']);

		Route::get('register/verify/{confirmationCode}', [
	    'as' => 'confirmation_path',
	    'uses' => 'UserController@confirm'
		]);

		// ------> password
		Route::get('password/reset', ['as'=>'remind_users_reset', 'uses'=>'PasswordController@remind']);
		Route::post('password/reset', ['as'=>'remind_password_request', 'uses'=>'PasswordController@request']);
		Route::get('password/reset/{token}', ['as'=>'remind_password_reset', 'uses'=>'PasswordController@reset']);
		Route::post('password/reset/{token}', ['as'=>'remind_password_update', 'uses'=>'PasswordController@update']);



});


// ------> closing mode
Route::get('close', ['as'=>'close', 'uses'=>'HomeController@close']);

//--> only users can access
Route::group(['before'=>'auth'], function(){
//Ajax Parcours
	Route::get('/ajax-parcour',function () {
		$class_id = Input::get('class_id');
		$socle = DB::table('parcours')->where('class_id','>',0)->where('class_id','=',$class_id)->where('status', 1)->lists('id', 'name');
		return Response::json($socle);
	});


//Ajax Groupe
	Route::get('/ajax-groupe',function () {

		$class_id = Input::get('class_id');
		$groupeclass = DB::table('groupes')->where('class_id','>',0)->where('class_id','=',$class_id)->where('status', 1)->lists('id', 'name');
		return Response::json($groupeclass);
	});



	//Ajax UE  => EC
	Route::get('/ajax-ues',function () {
		$parcour_id = Input::get('parcour_id');
		$tronc = DB::table('ues')->where('parcour_id','>',0)->where('parcour_id','=',$parcour_id)->where('tronc', 1)->where('status', 1)->lists('codeUe', 'name');
		return Response::json($tronc);
	});


	//Ajax EC => UE
	Route::get('/ajax-ec',function () {
		$class_id = Input::get('class_id');
		$classes = DB::table('elements')->where('class_id','>',0)->where('class_id','=',$class_id)->where('status', 1)->lists('id', 'name');
		return Response::json($classes);
	});

	//Ajax Students
	Route::get('/ajax-students',function () {

		$parcour_id = Input::get('parcour_id');
		$students = DB::table('students')->where('parcour_id','>',0)->where('parcour_id','=',$parcour_id)->where('blocage', 0)->lists('id', 'fname');
		return Response::json($students);
	});

	//Ajax Students
	Route::get('/ajax_promo',function () {

		$student = Input::get('student');
		$instance = Instance::where('id', $student)->first();
		$promos = DB::table('promos')->where('year','=', $instance->promo)->lists('year', 'year');
		return Response::json($promos);

		//$years = DB::table('promos')->where('year','=', $etudiant->promo)->lists('yearsUniv', 'yearsUniv');
		//return Response::json($years);
	});



	Route::get('/ajax-semestre',function () {

		$semestre 	= Input::get('codeUe');
		$semes		= UE::where('codeUe', $semestre)->first();
		$sem 		= DB::table('semestres')->where('codeSem','=', $semes->codeSem)->lists('id', 'semestre');
		return Response::json($sem);
	});

	Route::get('/ajax-choix',function () {

		$choix 	= Input::get('codeUe');
		$chois 	= UE::where('codeUe', $choix)->first();
		$ch 	= DB::table('choixs')->where('id', '=', $chois->choix)->lists('id', 'name');
		return Response::json($ch);
	});

});


//--> only admin can access here
Route::group(['before'=>'admin'], function() {

	Route::get('admin', ['as'=>'panel.admin', 'uses'=>'SettingsController@index']);
	// -------> settings
	Route::get('admin/settings', ['as'=>'configindex', 'uses'=>'SettingsController@configindex']);

	Route::post('admin/settings1/update-01', ['as'=>'settingsOne', 'uses'=>'SettingsController@settingsOne']);

	//Logo
	Route::post('admin/change-logo/webapp-lg', ['as'=>'applogo', 'uses'=>'SettingsController@applogo']);
	//Favicon
	Route::post('admin/change-favicon/webapp-fav', ['as'=>'favicon', 'uses'=>'SettingsController@favicon']);

	//Mots clés du site
	Route::post('admin/keywords', ['as'=>'keyWords', 'uses'=>'SettingsController@keyWords']);
	Route::get('admin/keywords-{id}-delete', ['as'=>'deletekeywords', 'uses'=>'SettingsController@deletekeywords']);
	//Nombre Mois
	Route::post('admin/nombreMois', ['as'=>'nombreMois', 'uses'=>'SettingsController@nombreMois']);

	//Message display after disabled App
	Route::post('admin/message-display', ['as'=>'messageClose', 'uses'=>'SettingsController@messageClose']);
	Route::post('admin/close-app', ['as'=>'closeApp', 'uses'=>'SettingsController@closeApp']);

	//CONFID TAXE & REMISE 1 OTHERS
	Route::post('admin/unite_argent', ['as'=>'paymentUnit', 'uses'=>'SettingsController@paymentUnit']);
	Route::post('admin/disabled-taxe', ['as'=>'activeTax', 'uses'=>'SettingsController@activeTax']);
	Route::post('admin/disabled-remise', ['as'=>'activeRemise', 'uses'=>'SettingsController@activeRemise']);

	Route::post('admin/settings/admin', ['as'=>'update_admin', 'uses'=>'SettingsController@update_admin']);
	Route::post('admin/settings/admin/password', ['as'=>'admin_password', 'uses'=>'SettingsController@admin_password']);

	//Pedagogies Inscription or Re-inscription
	Route::post('admin/disabled-inscription', ['as'=>'inscrit', 'uses'=>'SettingsController@inscrit']);
	Route::post('admin/disabled-re_inscription', ['as'=>'reSinscrit', 'uses'=>'SettingsController@reSinscrit']);
	//Bilan d'examen
	Route::post('admin/active-page-open-note', ['as'=>'openNotePage', 'uses'=>'SettingsController@openNotePage']);
	Route::post('admin/controler-session_1-examen', ['as'=>'controlSession_1', 'uses'=>'SettingsController@controlSession_1']);
	Route::post('admin/controler-session_2-examen', ['as'=>'controlSession_2', 'uses'=>'SettingsController@controlSession_2']);
	// -------> Ecolage
	Route::get('admin/paiement', ['as'=>'indexPay', 'uses'=>'PayController@indexPay']);

	//Route::get('admin/paiement/search/student', ['as'=>'searchTopay', 'uses'=>'PayController@searchTopay']);

	Route::get('admin/paiement/ecolage', ['as'=>'pageEcolage', 'uses'=>'PayController@pageEcolage']);
	Route::get('admin/paiement/ecolage/{class}', ['uses'=>'PayController@studParcour']);

	Route::get('admin/paiement/ecolage/{class}/{parcour}', ['as'=>'etudiantEcolage', 'uses'=>'PayController@etudiantEcolage']);

	Route::post('admin/paiement-ajouter/store-{id}', ['as'=>'payStore', 'uses'=>'PayController@payStore']);
	Route::get('admin/paiement/{id}/modifier-paiement-N°{index}/{class}/{parcour}', ['as'=>'editPay', 'uses'=>'PayController@editPay']);
	Route::post('admin/paiement-{id}', ['as'=>'payUpdate', 'uses'=>'PayController@payUpdate']);
	Route::get('admin/paiement/ajouter-paiment/{instance}', ['as'=>'checkPay', 'uses'=>'PayController@checkPay']);
	Route::get('admin/paiement/{instance}/{class}/{parcour}/info-paiement', ['as'=>'cartePay', 'uses'=>'PayController@cartePay']);

	Route::get('admin/original-facture/{id}/{class}/{parcour}/N-{index}', ['as'=>'pay_invoice', 'uses'=>'PayController@pay_invoice']);

	Route::get('admin/tous-factures/ecolages/{student}/{class}/{parcour}', ['as'=>'all_invoice', 'uses'=>'PayController@all_invoice']);

	Route::get('admin/paiement-etudiant/{id}/desactiver', ['as'=>'deletePay', 'uses'=>'PayController@deletePay']);

	// -------> Paramètres Ecolage
	Route::get('admin/ecolage/ajouter', ['as'=>'indexEcot', 'uses'=>'EcolageController@indexEcot']);
	Route::post('admin/ecolage/new', ['as'=>'store', 'uses'=>'EcolageController@store']);
	Route::post('admin/ecolage/{id}-update', ['as'=>'updateEcolage', 'uses'=>'EcolageController@updateEcolage']);
	Route::get('admin/ecolage/{id}-supprimer', ['as'=>'deleteEcolage', 'uses'=>'EcolageController@delete']);

	// ------> secretaire
	Route::get('admin/secretaires', ['as'=>'secretaires', 'uses'=>'SecretaireController@index']);
	Route::post('admin/secretaire/created', ['as'=>'storeSec', 'uses'=>'SecretaireController@storeSec']);
	Route::post('admin/secretaire/{id}/update', ['as'=>'updateSec', 'uses'=>'SecretaireController@updateSec']);
	Route::post('admin/secretaire/{id}/edit_password', ['as'=>'updateCode', 'uses'=>'SecretaireController@updateCode']);
	Route::get('admin/scolarite/{id}/delete', ['as'=>'deleteSec', 'uses'=>'SecretaireController@deleteSec']);


	// -------> Niveaux
	Route::get('admin/niveau/ajouter', ['as'=>'indexNiveau', 'uses'=>'ClassesController@indexNiveau']);
	Route::post('admin/classes/new', ['as'=>'store_class', 'uses'=>'ClassesController@store']);
	Route::get('admin/class/{id}/delete', ['as'=>'class_delete', 'uses'=>'ClassesController@destroy']);
	Route::get('admin/class/{id}/edit_niveau', ['as'=>'editNiveau', 'uses'=>'ClassesController@edit']);
	Route::post('admin/classes/{id}/update', ['as'=>'class_update', 'uses'=>'ClassesController@update']);

	//Groupes
	Route::get('admin/groupes', ['as'=>'indexGroupe', 'uses'=>'GroupeController@indexGroupe']);
	Route::get('admin/groupes/new', ['as'=>'groupeCreate', 'uses'=>'GroupeController@groupeCreate']);
	Route::post('admin/groupes/new', ['as'=>'groupeStore', 'uses'=>'GroupeController@groupeStore']);
	Route::get('admin/groupes/{id}/edit', ['as'=>'groupeEdit', 'uses'=>'GroupeController@groupeEdit']);
	Route::post('admin/groupes/{id}/update', ['as'=>'groupeUpdate', 'uses'=>'GroupeController@groupeUpdate']);
	Route::get('admin/groupes/{id}/delete', ['as'=>'groupeDelete', 'uses'=>'GroupeController@groupeDelete']);

	// -------> etudiantsFp
	Route::get('admin/etudiants/inscription/', ['as'=>'indexEtudiant', 'uses'=>'EtudiantController@index']);

	Route::get('admin/etudiants/find', ['as'=>'findStudent', 'uses'=>'EtudiantController@findStudent']);

	Route::get('admin/etudiants/inscription/{class}', ['as'=>'selectParcour', 'uses'=>'EtudiantController@selectParcour']);

	Route::get('admin/etudiants/inscription/{class}/{parcour}', ['as'=>'selectPromo', 'uses'=>'EtudiantController@selectPromo']);

	Route::get('admin/etudiants/inscription/{class}/{parcour}/{promotion}', ['as'=>'inscriptions', 'uses'=>'EtudiantController@inscriptions']);

	Route::get('admin/tous-etudiants/listes', ['as'=>'studentsAll', 'uses'=>'EtudiantController@studentsAll']);

	Route::get('admin/etudiants/{class}/{parcour}/etudiants', ['as'=>'sameStudents', 'uses'=>'EtudiantController@listStudents']);

	Route::post('admin/etudiants/store/{class}', ['as'=>'EtudiantStore', 'uses'=>'EtudiantController@EtudiantStore']);
	Route::post('admin/etudiant/{id}/update', ['as'=>'updateStudent', 'uses'=>'EtudiantController@updateStudent']);
	
	Route::get('admin/etudiant/{id}/{class}/{parcour}/modifier', ['as'=>'etudiantEdit', 'uses'=>'EtudiantController@etudiantEdit']);

	Route::post('admin/etudiant/{id}/photo-profil', ['as'=>'pdpStudent', 'uses'=>'EtudiantController@pdpStudent']);
	Route::get('admin/etudiant/{id}/supprimer-photo', ['as'=>'deletePdp', 'uses'=>'EtudiantController@deletePdp']);

	Route::get('admin/etudiant/{id}/supprimer', ['as'=>'deleteStudent', 'uses'=>'EtudiantController@deleteStudent']);

	Route::get('admin/etudiants/{class}/{parcour}/{id}', ['as'=>'profileEtudiant', 'uses'=>'EtudiantController@profileEtudiant']);

	Route::post('admin/etudiant/{id}/upload-fichier-principale', ['as'=>'uploader_file', 'uses'=>'EtudiantController@uploader_file']);
	Route::get('admin/etudiant/{id}/supprimer-fichier', ['as'=>'supfile', 'uses'=>'EtudiantController@supfile']);
	
	Route::post('admin/etudiant/{id}/autre_fichier', ['as'=>'otherFile', 'uses'=>'EtudiantController@otherFile']);
	Route::get('admin/etudiant/{id}/supprimer-autre-fichier', ['as'=>'supotherfile', 'uses'=>'EtudiantController@supotherfile']);

	//Import&Export fichier
	Route::get('admin/etudiants/import', ['as'=>'pageImport', 'uses'=>'ImportController@pageImport']);
	Route::post('admin/import/store', ['as'=>'importStore', 'uses'=>'ImportController@importStore']);
	Route::post('admin/export/file', ['as'=>'data_export', 'uses'=>'ImportController@data_export']);
	//Export Notes Student
	Route::post('admin/export-note/file-csv', ['as'=>'exportNote', 'uses'=>'ImportController@exportNote']);
	
	//Filter Student
	Route::get('admin/etudiants/filter', ['as'=>'filterOne', 'uses'=>'EtudiantController@filterOne']);
	Route::get('admin/etudiants/filter/{class}', ['as'=>'filterTo', 'uses'=>'EtudiantController@filterTo']);
	Route::get('admin/etudiants/filter/{class}/{parcour}/list_etudiants', ['as'=>'listStudentsFilter', 'uses'=>'EtudiantController@listStudents']);
	
  	//Certificat de scolarité
	Route::get('admin/certificat-scolarite/etudiants', ['as'=>'indexCerti', 'uses'=>'CertificatController@indexCerti']);
	Route::get('admin/certificat-scolarite/etudiants/{class}', ['as'=>'certifParcour', 'uses'=>'CertificatController@certifParcour']);
	Route::get('admin/certificat-scolarite/etudiants/{class}/{parcour}', ['as'=>'studentsCertfi', 'uses'=>'CertificatController@studentsCertfi']);
	Route::get('admin/certificat-scolarite/etudiants/{student}/{class}/{parcour}', ['as'=>'motifCertifi', 'uses'=>'CertificatController@motifCertifi']);
	Route::post('admin/certificat-scolarite/etudiants/{student}/{class}/{parcour}', ['as'=>'submitCertifi', 'uses'=> 'CertificatController@submitCertifi']);
	Route::get('admin/certificat-scolarite/etudiants/show/{student}/{class}/{parcour}', ['as'=>'readCertif', 'uses'=>'CertificatController@readCertif']);
	Route::get('admin/certificat-scolarite/etudiants/imprimer/{id}/{class}/{parcour}/ref-{ref}', ['as'=>'printCertifi', 'uses'=>'CertificatController@printCertifi']);
  	Route::get('admin/certificat-scolarite/supprimer/{id}', ['as'=>'deleteCertificat', 'uses'=>'CertificatController@supprimer']);
  
	// -------> Année Universitaire
	Route::get('admin/annee_universitaire/ajouter', ['as'=>'indexYear', 'uses'=>'YearController@index']);
	Route::post('admin/annee_universitaire/new', ['as'=>'storeYear', 'uses'=>'YearController@storeYear']);
	Route::post('admin/annee_universitaire/{id}/update', ['as'=>'updateYear', 'uses'=>'YearController@updateYear']);
	Route::get('admin/annee_universitaire/{id}/delete', ['as'=>'delete', 'uses'=>'YearController@delete']);

	// -------> Semestres
	Route::get('admin/semestre/ajouter', ['as'=>'indexSemestre', 'uses'=>'SemController@index']);
	Route::post('admin/semestre/new', ['as'=>'storeSem', 'uses'=>'SemController@storeSem']);
	Route::post('admin/semestre/{id}/update', ['as'=>'updateSem', 'uses'=>'SemController@updateSem']);
	Route::get('admin/semestre/{id}/delete', ['as'=>'delete', 'uses'=>'SemController@delete']);

	// -------> Domaines
	Route::get('admin/domaines', ['as'=>'indexD', 'uses'=>'DomaineController@index']);
	Route::post('admin/domaines/new', ['as'=>'storeD', 'uses'=>'DomaineController@storeD']);
	Route::get('admin/domaines/{id}/delete', ['as'=>'deleteD', 'uses'=>'DomaineController@delete']);
	Route::get('admin/domainesde-formation/{id}/{parcour}/modifier', ['as'=>'edit_domaine', 'uses'=>'DomaineController@edit_domaine']);
	Route::post('admin/domainesde-formation/{id}/update', ['as'=>'updateD', 'uses'=>'DomaineController@updateD']);

	// -------> Mentions
	Route::get('admin/mentions', ['as'=>'indexM', 'uses'=>'MentionController@index']);
	Route::post('admin/mentions/new', ['as'=>'storeM', 'uses'=>'MentionController@storeM']);
	Route::get('admin/mentions/{id}/delete', ['as'=>'deleteM', 'uses'=>'MentionController@delete']);
	Route::post('admin/mentions/{id}/update', ['as'=>'updateM', 'uses'=>'MentionController@updateM']);

	// -------> Parcours
	Route::get('admin/parcours', ['as'=>'indexParcour', 'uses'=>'ParcourController@index']);
	Route::post('admin/parcours/new', ['as'=>'storeParcour', 'uses'=>'ParcourController@storeParcour']);
	Route::get('admin/parcours/{id}/delete', ['as'=>'deleteP', 'uses'=>'ParcourController@delete']);
	Route::post('admin/parcours/{id}/update', ['as'=>'updateParcour', 'uses'=>'ParcourController@updateParcour']);

	// -------> UE
	Route::get('admin/ues_ap-{class}/{parcour}', ['as'=>'showAp', 'uses'=>'UEController@showAp']);

	Route::get('admin/ues-{class}/{parcour}', ['as'=>'detailsUe', 'uses'=>'UEController@show']);
	Route::get('admin/ue/unite_enseignements', ['as'=>'indexUe', 'uses'=>'UEController@index']);
	Route::get('admin/ue/unite_enseignements/{class}', ['uses'=>'UEController@ue_parcour']);

	Route::get('admin/ue-tronc/ajouter-ue/{class}', ['as'=>'UEtroncCommun', 'uses'=>'UEController@UEtroncCommun']);

	Route::post('admin/ue-tronc/addTronc-ue/{class}', ['as'=>'saveUETronc', 'uses'=>'UEController@saveUETronc']);

	Route::post('admin/ue/new/{class}-{parcour}', ['as'=>'storeUe', 'uses'=>'UEController@storeUe']);

	Route::get('admin/ue/{class}/{parcour}', ['as'=>'detailsUe', 'uses'=>'UEController@show']);

	Route::get('admin/ue/impression/{class}/{parcour}', ['as'=>'print_ue', 'uses'=>'UEController@print_ue']);

	Route::get('admin/ue/{class}/{parcour}/{ue}/edit', ['as'=>'editue', 'uses'=>'UEController@editue']);

	Route::post('admin/ue/{id}/update', ['as'=>'updateUe', 'uses'=>'UEController@updateUe']);
	Route::get('admin/unite_enseignement/{id}/supprimer', ['as'=>'deleteUe', 'uses'=>'UEController@deleteUe']);
	
	// -------> EC
	Route::get('admin/element_constitutifs', ['as'=>'indexEc', 'uses'=>'EcController@index']);

	Route::get('admin/element_constitutifs/{class}', ['uses'=>'EcController@ec_parcour']);

	Route::get('admin/ec-tronc/ajouter-matiere/{class}', ['as'=>'AddtroncCommun', 'uses'=>'EcController@AddtroncCommun']);

	Route::post('admin/ec-tronc/addTronc/{class}', ['as'=>'saveTronc', 'uses'=>'EcController@saveTronc']);

	Route::post('admin/element_constitutif/new/{class}-{parcour}', ['as'=>'storeEc', 'uses'=>'EcController@storeEc']);

	Route::get('admin/element_constitutif/{id}/delete', ['as'=>'remove_ec', 'uses'=>'EcController@remove_ec']);

	Route::get('admin/element_constitutif/{class}/{parcour}', ['as'=>'addnew', 'uses'=>'EcController@addnew']);

	Route::get('admin/element_constitutif/modifier/{class}/{parcour}/{element}', ['as'=>'edit_ec', 'uses'=>'EcController@edit']);

	Route::post('admin/element_constitutif/{id}/update', ['as'=>'updateEc', 'uses'=>'EcController@updateEc']);

	Route::post('admin/element_constitutif/{id}/ajouter-teacher', ['as'=>'ajouterTeacher', 'uses'=>'EcController@ajouterTeacher']);

	Route::get('admin/element_constitutif/ajouter-enseignant/{class}/{parcour}/{element}', ['as'=>'addTeacher_ec', 'uses'=>'EcController@addTeacher_ec']);

	Route::get('admin/element_constitutif/{class}/{parcour}/{id}/details-elements-constitutifs', ['as'=>'checkElement', 'uses'=>'EcController@checkElement']);

	//Route::get('admin/element_constitutif/{class}/{parcour}/{element}/details-elements-constitutifs-tronc', ['as'=>'checkElement', 'uses'=>'EcController@checkTronc']);

	Route::get('admin/ec/impression/{class}/{parcour}', ['as'=>'print_element', 'uses'=>'EcController@print_element']);

	Route::post('admin/element_constitutif/{class}/{parcour}/{element}', 'EcController@rajouter');

	Route::get('admin/matiere_tronc_commun/{element_id}/fafana', ['as'=>'delete_tronc', 'uses'=>'EcController@purge']);


	//Absence Gestions => Année Préparatoire

	Route::get('admin/absences/etudiants/anne_preparatoire/{class}', ['as'=>'ap', 'uses'=>'AbsenceApController@ap']);

	Route::get('admin/absences/etudiants/anne_preparatoire/{class}/{element}/absence/ap', ['as'=>'takeap','uses'=>'AbsenceApController@takeAp']);

	Route::post('admin/absences/etudiants/anne_preparatoire/{class}/{element}/absence/ap', 'AbsenceApController@submitAp');
	
	Route::get('admin/absences/etudiants/anne_preparatoire/{class}/{element}', ['as'=>'listeAp','uses'=>'AbsenceApController@listeAp']);

	//Route::get('admin/absences/etudiants/ap/{class}/{element}', ['as'=>'voirlistAp','uses'=>'AbsencesController@voirlistAp']);

	Route::get('admin/absences/etudiants/anne_preparatoire/{class}/{element}/{dateStart}/{dateEnd}', 'AbsenceApController@view');

	Route::get('admin/absences/print/{class}/{element}/{dateStart}/{dateEnd}', ['as'=>'print_ap', 'uses'=>'AbsenceApController@print']);

	// Absence Tronc Commun 
	Route::get('admin/absences/etudiants_tronc/{class}', ['as'=>'openTronc', 'uses'=>'AbsencesTroncController@matiereTronc']);

	Route::get('admin/absences/etudiants_tronc/{class}/{element}/{codeEc}/absence_tronc/add', ['uses'=>'AbsencesTroncController@takeAll']);

	Route::get('admin/absences/etudiants_tronc/{class}/{element}', ['as'=>'alltronc','uses'=>'AbsencesTroncController@alltronc']);

	Route::post('admin/absences/etudiants_tronc/{class}/{element}/{codeEc}/absence_tronc/add', 'AbsencesTroncController@submitTronc');

	Route::get('admin/absences/etudiants_tronc/{class}/{element}/{dateStart}/{dateEnd}', 'AbsencesTroncController@showTroncAb');

	Route::get('admin/absences/tronc/print/{class}/{element}/{dateStart}/{dateEnd}', ['as'=>'printAll', 'uses'=>'AbsencesTroncController@printAll']);

	//Absence Gestions L1 -> M2
	Route::get('admin/absences/etudiants', ['as'=>'absence', 'uses'=>'AbsencesController@starAbsence']);
	Route::get('admin/absences/etudiants/{class}', ['uses'=>'AbsencesController@parcoursAbsence']);

	Route::get('admin/absences/etudiants/{class}/{parcour}', ['as'=>'checkparcour', 'uses'=>'AbsencesController@elementAbsence']);

	Route::get('admin/absences/etudiants/{class}/{parcour}/{element}', ['as'=>'voirlist','uses'=>'AbsencesController@voirlist']);

	Route::get('admin/absences/etudiants/{class}/{parcour}/{element}/{codeEc}/absence/take', ['uses'=>'AbsencesController@take']);

	Route::post('admin/absences/etudiants/{class}/{parcour}/{element}/{codeEc}/absence/take', 'AbsencesController@submit');

	Route::get('admin/start/{class}/{parcour}/{element}/absence/{dateStart}/{dateEnd}', ['as'=>'all_absence', 'uses'=>'AbsencesController@index']);

	Route::get('admin/start/{class}/{parcour}/{element}/absence/{absence}/remove', ['as'=>'remove', 'uses'=>'AbsencesController@remove']);

	Route::get('admin/absences/etudiants/{class}/{parcour}/{element}/{dateStart}/{dateEnd}', 'AbsencesController@view');

	Route::get('admin/absences/print/{class}/{parcour}/{element}/{dateStart}/{dateEnd}', ['as'=>'print', 'uses'=>'AbsencesController@print']);

	Route::get('admin/start/{class}/{parcour}/{element}/edit', ['as'=>'editabsence', 'uses'=>'AbsencesController@edit']);
	Route::post('admin/start/{class}/{parcour}/{element}/{date}/update', ['as'=>'updateabsence', 'uses'=>'AbsencesController@update']);


	//Teachers 
	Route::get('admin/enseignants/', ['as'=>'indexTeacher', 'uses'=>'TeacherController@index']);
	Route::get('admin/enseignants/ajouter', ['as'=>'add_enseignant', 'uses'=>'TeacherController@add']);

	Route::post('admin/enseignants/save-enseignant', ['as'=>'SaveTeacher', 'uses'=>'TeacherController@SaveTeacher']);
	Route::post('admin/enseignants/modifier-enseignant-{id}', ['as'=>'updateTeacher', 'uses'=>'TeacherController@updateTeacher']);
	Route::get('admin/enseignants/{id}/modifier', ['as'=>'TeacherEdit', 'uses'=>'TeacherController@TeacherEdit']);

	Route::post('admin/enseignants/{id}/photo-profil', ['as'=>'pdp_teacher', 'uses'=>'TeacherController@pdp']);

	Route::get('admin/enseignants/{id}/delete', ['as'=>'deleteteacher', 'uses'=>'TeacherController@deleteteacher']);

	Route::get('admin/enseignants/{profile}', ['as'=>'profileteacher', 'uses'=>'TeacherController@profileteacher']);



	//Releve des Notes
	Route::get('admin/releve_notes/class/etudiants', ['as'=>'indexReleve', 'uses'=>'ReleveNoteController@index']);

	Route::get('admin/releve_notes/class/etudiants/{class}', ['uses'=>'ReleveNoteController@listsnoteStudents']);

	Route::get('admin/releve_notes/class/etudiants/{class}/{student}', ['uses'=>'ReleveNoteController@releveNote']);

	// Gestion des Notes Class et Tronc commun
	Route::get('admin/notes/etudiants', ['as'=>'addnote_one', 'uses'=>'NoteController@index_one']);

	Route::get('admin/recap_notes/etudiants', ['as'=>'recap', 'uses'=>'NoteController@recap']);
	Route::get('admin/recap_notes/etudiants/{class}', ['uses'=>'NoteController@all_notes_recap']);

	Route::get('admin/recap_notes/etudiants/{class}/{parcour}', ['as'=>'list_recap', 'uses'=>'NoteController@list_recap']);

	Route::get('admin/notes/etudiants/{class}', ['uses'=>'NoteController@parcourNote']);
	
	Route::get('admin/notes/etudiants/{class}/{parcour}', ['uses'=>'NoteController@semMatiere']);

	Route::get('admin/notes/etudiants/{class}/{parcour}/{semestre}', ['uses'=>'NoteController@choixNotes']);

	Route::get('admin/notes/etudiants/{class}/{parcour}/{semestre}/1', ['uses'=>'NoteController@element']);

	Route::get('admin/notes/etudiants/{class}/{parcour}/{semestre}/2', ['uses'=>'NoteController@matierecc']);

	Route::get('admin/notes/etudiants/{class}/{parcour}/{semestre}/{type}/{element}/{codeEc}/notes/ajouter', ['uses'=>'NoteController@addNoteExam']);

	Route::get('admin/notes/etudiants/{class}/{parcour}/{semestre}/{type}/{element}/{codeEc}/notes/ajoutercc', ['uses'=>'NoteController@addNoteCC']);

	Route::post('admin/notes/etudiants/{class}/{parcour}/{semestre}/{type}/{element}/{codeEc}/notes/ajouter', 'NoteController@sendNoteExam');

	Route::post('admin/notes/etudiants/{class}/{parcour}/{semestre}/{type}/{element}/{codeEc}/notes/ajoutercc', 'NoteController@sendNoteCC');

	//Show note by EC
	Route::get('admin/notes/etudiants/{class}/{parcour}/{semestre}/1/{element}/{codeEc}/afficher/notes/examen', ['uses'=>'NoteController@showNote']);

	Route::get('admin/notes/etudiants/{class}/{parcour}/{semestre}/2/{element}/{codeEc}/afficher/notes/cc', ['uses'=>'NoteController@showNotecc']);

	//Show note by EC-Tronc-Commun
	Route::get('admin/notes/etudiants/afficher_note_tronc/{class}/{element}/{codeEc}', ['as'=>'displayAll', 'uses'=>'NoteController@showNoteAll']);

	//Modifier Note
	Route::get('admin/note-cc/etudiant/modifier/id_{id}/{class}/{parcour}/{element}', ['as'=>'editNotecc', 'uses'=>'NoteController@editNotecc']);

	Route::post('admin/notecc/etudiant/modifier/note-id_{id}', ['as'=>'updateNoteCC', 'uses'=>'NoteController@updateNoteCC']);

	Route::get('admin/note/etudiant/modifier/id_{id}/{class}/{parcour}/{element}', ['as'=>'modifierNote', 'uses'=>'NoteController@modifierNote']);

	Route::post('admin/mark/etudiant/modifier/note-id_{id}', ['as'=>'updateNoteStd', 'uses'=>'NoteController@updateNoteStd']);
	
	Route::get('admin/note/etudiant/remove/{id}', ['as'=>'removeNote', 'uses'=>'NoteController@removeNote']);

	//Modifier Note-Tronc
	Route::get('admin/note/etudiant-tronc/modifier/{id}/{class}/{user}/{element}', ['as'=>'soloyNote', 'uses'=>'NoteController@soloyNote']);


	//2e Sessions
	Route::get('admin/notes/2e_session/{class}/{parcour}', ['as'=>'deux_session', 'uses'=>'Session2Controller@theSession']);

	Route::get('admin/notes/2e_session/{class}/{parcour}/1', ['as'=>'Session_semestre_1', 'uses'=>'Session2Controller@repesage_1']);

	Route::get('admin/notes/2e_session/{class}/{parcour}/2', ['as'=>'Session_semestre_2', 'uses'=>'Session2Controller@repesage_2']);
	
	Route::post('admin/resultats_2esession/{class}/{parcour}/1', ['as'=>'resultat2Session_1', 'uses'=> 'Session2Controller@resultat2Session_1']);

	Route::post('admin/resultats_2esession/{class}/{parcour}/2', ['as'=>'resultat2Session_2', 'uses'=> 'Session2Controller@resultat2Session_2']);

	Route::get('admin/notes/etudiants/notes/ajouter-1-session/{class}/{parcour}/1/{student}', ['as'=>'selectSession1', 'uses'=>'Session2Controller@selectSession1']);

	Route::get('admin/notes/etudiants/notes/ajouter-1-session/add/{class}/{parcour}/{student}/{id}', ['as'=>'addNoteSession_1', 'uses'=>'Session2Controller@addNoteSession_1']);

	Route::post('admin/notes/etudiants/notes/ajouter-1-session/add/{class}/{parcour}/{student}/{id}', ['as'=>'submitSession_1', 'uses'=>'Session2Controller@submitSession_1']);

	Route::get('admin/notes/etudiants/notes/ajouter-2-session/{class}/{parcour}/2/{student}', ['as'=>'selectSession2', 'uses'=>'Session2Controller@selectSession2']);

	Route::get('admin/notes/etudiants/notes/ajouter-2-session/add/{class}/{parcour}/{student}/{id}', ['as'=>'addNoteSession_2', 'uses'=>'Session2Controller@addNoteSession_2']);

	Route::post('admin/notes/etudiants/notes/ajouter-2-session/add/{class}/{parcour}/{student}/{id}', ['as'=>'submitSession_2', 'uses'=> 'Session2Controller@submitSession_2']);

	//***
	Route::post('admin/resultats_examen/session_2/vérification/{class}/{parcour}', ['as'=>'submit2sessionfinal', 'uses'=> 'Session2Controller@submit2sessionfinal']);

	 Route::get('admin/resultats_examen/session_2/vérification/{class}/{parcour}', ['as'=>'checkSession2', 'uses'=>'Session2Controller@checkSession2']);

	Route::get('admin/resultats_examen/session_2/activation/{class}/{parcour}', ['as'=>'activateS2', 'uses'=>'Session2Controller@activateS2']);

	Route::get('admin/resultats_examen/session_2e/officiel/{class}/{parcour}', ['as'=>'fetchresultS2', 'uses'=> 'Session2Controller@fetchresultS2']);

	Route::post('admin/resultats_examen/session_2e/confirm-officiel/{class}/{parcour}', ['as'=>'valid2session', 'uses'=> 'Session2Controller@valid2session']);

	Route::get('admin/resultats_examen/session_2e/restore/{class}/{parcour}', ['as'=>'supprimer2', 'uses'=>'Session2Controller@supprimer2']);

    Route::get('admin/resultats_examen/session_2/officiel/affichage/mode-impression/{class}/{parcour}', ['as'=>'print2session','uses'=>'Resultats1Controller@print2session']);

 	Route::get('admin/resultats_examen/session_2/restore/{class}/{parcour}', ['as'=>'delete_resultS2', 'uses'=>'Session2Controller@delete_resultS2']);

 	Route::get('admin/resultats_examen/session_2e/officiel/{class}/{parcour}/{student}/relevenote_2session', ['as'=>'releve_notes2','uses'=>'Session2Controller@releve_notes2']);

 	Route::get('admin/resultats_examen/session_2/paramètre-releve-note/{class}/{parcour}', ['as'=>'datafoRV', 'uses'=>'Session2Controller@datafoRV']);

 	Route::get('admin/resultats_examen/session_2/admis-officiel/{class}/{parcour}', ['as'=>'affichageAdmis2','uses'=>'Session2Controller@affichageAdmis2']);
 	Route::get('admin/resultats_examen/session_2/non-admis-officiel/{class}/{parcour}', ['as'=>'affichageNoAdmis2','uses'=>'Session2Controller@affichageNoAdmis2']);

 	Route::post('admin/resultats_examen/session_2e/officiel/{class}/{parcour}', 'Session2Controller@sendExam2');
	//**

	Route::get('admin/notes/commun-tronc/{class}', ['as'=>'commun', 'uses'=>'NoteController@troncCommun']);

	Route::get('admin/notes/commun-tronc/{class}/{element}/{codeEc}/notes_tronc/add', ['uses'=>'NoteController@addNotetronc']);

	Route::post('admin/notes/commun-tronc/{class}/{element}/{codeEc}/notes_tronc/add', 'NoteController@sendNoteTronc');

	//Année Preparatoire Gestion des Notes
	Route::get('admin/ajouter_notes/anne_preparatoire/{class}', ['as'=>'openAp', 'uses'=>'NoteApController@openAp']);

	Route::get('admin/ajouter_notes/anne_preparatoire/{class}/{element}/{codeEc}/noteAp/ajouter', ['as'=>'addNoteAp','uses'=>'NoteApController@addNoteAp']);

	Route::post('admin/ajouter_notes/anne_preparatoire/{class}/{element}/{codeEc}/noteAp/ajouter', 'NoteApController@submitNoteAp');
	
	Route::get('admin/ajouter_notes/anne_preparatoire/{class}/{element}', ['as'=>'listeNoteAp','uses'=>'NoteApController@listeAp']);

	Route::get('admin/ajouter_notes/anne_preparatoire/{class}/{parcour}/{element}/{codeEc}/afficher/notes_ap', ['uses'=>'NoteApController@showNoteAp']);

	//Releve des Notes-AP
	Route::get('admin/releve_notes/ap/etudiants/{class}', ['as'=>'students_ap','uses'=>'ReleveApController@students_ap']);

	Route::get('admin/releve_notes/ap/etudiants/{class}/{student}', ['as'=>'pureAp', 'uses'=>'ReleveApController@releveNoteAp']);

	//Resulats d'examen 1ère session
	Route::get('admin/resultats_examen', ['as'=>'indexResult_1', 'uses'=>'Resultats1Controller@session_1']);

	Route::get('admin/resultats_examen/{class}', ['uses'=>'Resultats1Controller@byParcour']);

	Route::get('admin/resultats_examen/{class}/{parcour}', ['uses'=>'Resultats1Controller@selectresult']);

    Route::get('admin/resultats_examen/semestre_1/vérification/{class}/{parcour}', ['as'=>'resultats_semestre_1', 'uses'=>'Resultats1Controller@Examensemestres_1']);

    Route::get('admin/resultats_examen/semestre_2/vérification/{class}/{parcour}', ['as'=>'resultats_semestre_2', 'uses'=>'Resultats2Controller@Examensemestres_2']);

    Route::post('admin/resultats_examen/semestre_1/vérification/{class}/{parcour}', ['as'=>'confirmSemestre_1', 'uses'=> 'Resultats1Controller@confirmSemestre_1']);

    Route::post('admin/resultats_examen/semestre_2/vérification/{class}/{parcour}', ['as'=>'confirmSemestre_2', 'uses'=> 'Resultats2Controller@confirmSemestre_2']);

    Route::get('admin/detailnotes/semestre_1/niveau/etudiants/{class}/{parcour}/{student}', ['as'=>'detailsofnotes_1','uses'=>'Resultats1Controller@detailsofnotes_1']);

    Route::get('admin/detailnotes/semestre_2/niveau/etudiants/{class}/{parcour}/{student}', ['as'=>'detailsofnotes_2','uses'=>'Resultats2Controller@detailsofnotes_2']);

    //Déliberation
    Route::get('admin/resultats-semestre_1/deliberation/{class}/{parcour}/1', ['as'=>'deliberation_1', 'uses'=>'DeliberController@deliberation_1']);

    Route::post('admin/resultats-semestre_1/deliberation/confirmer/{class}/{parcour}', ['as'=>'submitDeliber', 'uses'=> 'DeliberController@submitDeliber']);

    Route::get('admin/resultats-semestre_1/deliberation/restore/{class}/{parcour}', ['as'=>'restoreDeliber', 'uses'=>'DeliberController@restoreDeliber']);

    //Deliberation_2
    Route::get('admin/resultats-semestre_2/deliberation/{class}/{parcour}/2', ['as'=>'deliberation_2', 'uses'=>'DeliberController@deliberation_2']);

    Route::post('admin/resultats-semestre_2/deliberation/confirmer/{class}/{parcour}', ['as'=>'submitDeliber_2', 'uses'=> 'DeliberController@submitDeliber_2']);

    Route::get('admin/resultats-semestre_2/deliberation/restore/{class}/{parcour}', ['as'=>'restoreDeliber_2', 'uses'=>'DeliberController@restoreDeliber_2']);

    Route::get('admin/deliberation/examen', ['as'=>'indexdeliber', 'uses'=>'DeliberController@indexdeliber']);

    Route::post('admin/deliberation/examen/save', ['as'=>'savedeliber', 'uses'=> 'DeliberController@savedeliber']);
    Route::get('admin/deliberation/examen/delete/{id}', ['as'=>'deleteDeliber', 'uses'=>'DeliberController@deleteDeliber']);
     //DELIBERATION END

    Route::get('admin/resultats_examen/semestre_1/restore/{class}/{parcour}', ['as'=>'restore_s1', 'uses'=>'Resultats1Controller@restore_s1']);

    Route::get('admin/resultats_examen/semestre_2/restore/{class}/{parcour}', ['as'=>'restore_s2', 'uses'=>'Resultats2Controller@restore_s2']);

    Route::get('admin/resultats_examen/session_1/version-officiel/affichage/restore/{class}/{parcour}', ['as'=>'restoreOfficiel', 'uses'=>'Resultats1Controller@restoreOfficiel']);
    
    Route::post('admin/resultats_examen/session_1/version-officiel/{class}/{parcour}', ['as'=>'confirmResult', 'uses'=> 'Resultats1Controller@confirmResult']);

    Route::get('admin/resultats_examen/session_1/version-officiel/résultats/{class}/{parcour}', ['as'=>'resultats_examen_officiel_session_1', 'uses'=>'Resultats1Controller@officiel_session_1']);

    Route::get('admin/resultats_examen/session_1/version-officiel/résultats/{class}/{parcour}/{student}/relevenote_semestre_1', ['as'=>'releve_notes_1','uses'=>'Resultats1Controller@releve_notes_1']);

	Route::get('admin/resultats_examen/1er_Session_1/officiel/{class}/{parcour}', ['as'=>'affichagesprint','uses'=>'Resultats1Controller@affichagesprint']);

	Route::get('admin/resultats_examen/2em_Session/officiel/{class}/{parcour}', ['as'=>'print_s2','uses'=>'Resultats2Controller@print_s2']);

	Route::get('admin/resultats_examen/session_1/liste-ajournee/{class}/{parcour}', ['as'=>'listajournee','uses'=>'Resultats1Controller@listajournee']);

	Route::post('admin/resultats_examen/session_1/version-officiel/résultats/{class}/{parcour}/{student}', 'Resultats1Controller@sendExam');


	Route::get('admin/releve_notes/class/etudiants/{class}/{student}', ['as'=>'minireleve','uses'=>'ReleveNoteController@releveNote']);

// --> Bloc notes
	Route::post('admin/notes/store', ['as'=>'admin_notes_store', 'uses'=>'SettingsController@admin_notes_store']);
	Route::get('admin/notes/{id}/destroy', ['as'=>'admin_notes_destroy', 'uses'=>'SettingsController@notes_destroy']);

	Route::get('admin/note/etudiant-ap/modifier/{id}/{class}/{user}/{element}', ['as'=>'modifierNoteAp', 'uses'=>'NoteApController@modifierNoteAp']);

	Route::get('admin/recherche/note/etudiant', ['as'=>'findNote', 'uses'=>'FindNoteController@findNote']);

	Route::get('admin/detail/note/etudiant/{class}/{parcour}/{etudiant}', ['as'=>'openNote', 'uses'=>'FindNoteController@openNote']);

	Route::get('admin/myreleve/etudiant/{class}/{parcour}/{yearsUniv}/{id}', ['as'=>'releveFind','uses'=>'FindNoteController@releveFind']);

	Route::get('admin/myreleve/etudiant-ap/{id}/{class}/{yearsUniv}', ['as'=>'ReleveForAp','uses'=>'FindNoteController@ReleveForAp']);

	//Re-inscrit
	Route::get('admin/reinscription/esige/etudiant', ['as'=>'reInscrit', 'uses'=>'ReInscriptionController@reInscrit']);

	Route::get('admin/reinscription/check-etudiant/{class}/{parcour}/{profile}', ['as'=>'checkEtudiant', 'uses'=>'ReInscriptionController@checkEtudiant']);

	Route::post('admin/reinscription/etudiant/confirmer/{id}', ['as'=>'Uplevel', 'uses'=>'ReInscriptionController@Uplevel']);

	//Bilan d'examen
	Route::get('admin/message-conditions/gestions-des-notes/page/1', ['as'=>'alertOpen', 'uses'=>'Resultats1Controller@alertOpen']);

	Route::get('admin/message-conditions/gestions-des-notes', ['as'=>'alertOpenX', 'uses'=>'Resultats1Controller@alertOpenX']);

	Route::get('admin/resultats_examen_bilan/class/etudiants', ['as'=>'bilan', 'uses'=>'Resultats1Controller@bilan']);
	
	//return admis
	Route::get('admin/bilan_des_admis/tous-classes', ['as'=>'returnAdmis', 'uses'=>'Resultats1Controller@returnAdmis']);

	Route::post('admin/resultats_examen_bilan_admis/class/etudiants', ['as'=>'bilanadmis', 'uses'=> 'Resultats1Controller@SubmitAdmis']);
	
	//Return non admis
	Route::get('admin/bilan_des_non_admis/tous-classes', ['as'=>'returnNonAdmis', 'uses'=>'Resultats1Controller@returnNonAdmis']);

	Route::post('admin/resultats_examen_bilan_non_admis/class/etudiants', ['as'=>'bilanNonadmis', 'uses'=> 'Resultats1Controller@SubmitNonAdmis']);

  
	Route::get('admin/examens_gestion/etudiants', ['as'=>'examens_gestion', 'uses'=>'ExamenController@indexExamen']);
	Route::get('admin/examens_gestion/etudiants/{class}', ['uses'=>'ExamenController@parcoursExamen']);
	Route::get('admin/examens_gestion/etudiants/{class}/{parcour}', ['as'=>'gererMatiere', 'uses'=>'ExamenController@matieres']);
});




