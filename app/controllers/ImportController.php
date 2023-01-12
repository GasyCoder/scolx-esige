<?php

class ImportController extends BaseController {


	protected $file_rules = [
			'csv_file'=>'required'
	];


	public function data_export() {

		$table 		= Student::all();
	    $filename 	= public_path().'/uploads/data/' . strtotime('etudiants') . 'etudiants.csv';
	    $handle 	= fopen($filename, 'w+');
	    
	    fputcsv($handle, array('Nom', 'Prenom', 'Matricule', 'Niveau', 'Parcours', 'Date de naissance', 'Lieu de naissance', 'Nationalite', 'Annee Universitaire', 'Telephone', 'Email'), $delimiter=';');

	    foreach($table as $row) {

	    	$fname 		= utf8_decode($row['fname']);
            $lname 		= utf8_decode($row['lname']);
            $phone_1 	= utf8_decode($row['phone_1']);
            $email 		= utf8_decode($row['email']);
            $birthLocation 	= utf8_decode($row['birthLocation']);
            $nationality = utf8_decode($row->instance['nationality']);

	        fputcsv($handle, array($row['fname'], $row['lname'], $row['matricule'], $row->niveau['short'], $row->parcour['abr'], $row['birth'], $row['birthLocation'], $row->instance['nationality'], $row['yearsUniv'], $row['phone_1'], $row['email']), $delimiter=';');
	    }
	    fclose($handle);
	    return Redirect::back()->with('download', ''. strtotime('etudiants') . 'etudiants.csv');
	}


	//Export Note Student 

	public function exportNote() {

		$exports 		= Note::where('semestre', 1)->get();
	    $filename 		= public_path().'/uploads/notes/' . strtotime('note_examen_s_1') . 'note_examen_s_1.csv';
	    $handle 		= fopen($filename, 'w+');
	    
		fputs($handle, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));
	    //add BOM to fix UTF-8 in Excel 
		//fputs($handle, $filename =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));
	    fputcsv($handle, array('Nom', 'Prenom', 'Matricule', 'Niveau', 'Parcours', 'UE', 'EC', 'Note', 'Coef', 'Session', 'Semestre', 'Annee Universitaire'), $delimiter=';');
	    foreach($exports as $export) {
	        fputcsv($handle, array($export->stud['fname'], $export->stud['lname'], $export->stud['matricule'], $export->niveau['short'], $export->parcour['abr'], $export->unite['name'], ucfirst($export->mat['slug']), $export['noteExam'], $export['coef'], $export['session'], $export['semestre'], $export['yearsUniv']), $delimiter=';');
	    }
	    fclose($handle);
	    return Redirect::back()->with('download', ''. strtotime('note_examen_s_1') . 'note_examen_s_1.csv');
	}
}