<?php

class ImportController extends BaseController {


	protected $file_rules = [
			'csv_file'=>'required'
	];


	public function pageImport() {
		$title 			= 'Import Etudiants';
		$sous       	= 'fichier .CSV';
		$etudiants 		= Student::all();

		return View::make('backend.admin.pedagogie.Etudiants.import', compact('etudiants', 'class', 'parcour', 'parcours', 'years'))->with('title', $title)->with('sous', $sous);
	}

	public function data_export() {

		$table 		= Student::all();
	    $filename 	= public_path().'/uploads/data/' . strtotime('etudiants') . 'etudiants.csv';
	    $handle 	= fopen($filename, 'w+');
	    
		fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));
	    //add BOM to fix UTF-8 in Excel 
		//fputs($handle, $filename =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));
	    fputcsv($handle, array('Nom', 'Prenom', 'Matricule', 'Niveau', 'Parcours', 'Date de naissance', 'Lieu de naissance', 'Nationalite', 'Annee Universitaire', 'Telephone', 'Email'), $delimiter=';');
	    foreach($table as $row) {
	        fputcsv($handle, array($row['fname'], mb_convert_encoding($row['lname'],'UTF-8', 'Windows-1252'), $row['matricule'], $row->niveau['short'], $row->parcour['abr'], $row['birth'], $row['birthLocation'], $row->instance['nationality'], $row['yearsUniv'], $row['phone_1'], $row['email']), $delimiter=';');
	    }
	    fclose($handle);
	    return Redirect::back()->with('download', ''. strtotime('etudiants') . 'etudiants.csv');
	}



	public function importStore() {

			$inputs = Input::all();

			$validation = Validator::make($inputs, $this->file_rules);

			if ($validation->fails()) {
				return Redirect::back()->withInput()->withErrors($validation);
			} 

			else {

				if (Input::hasFile('csv_file')) {

					$extension = Input::file('csv_file')->getClientOriginalExtension();

					if ($extension == "csv" OR $extension == "CSV") {

						$file = Input::file('csv_file')->getRealPath();
					
						//$csvFile = public_path().'/uploads/data/CSV_sample.csv';

						function csv_to_array($filename='', $delimiter=';')
	                    {
	                        if(!file_exists($filename) || !is_readable($filename))
	                            return FALSE;
	                     
	                        $header = NULL;
	                        $data = array();
	                        if (($handle = fopen($filename, 'r')) !== FALSE)
	                        {
	                            while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
	                            {
	                                if(!$header)
	                                    $header = $row;
	                                else
	                                    $data[] = array_combine($header, $row);
	                            }
	                            fclose($handle);
	                        }
	                        return $data;
	                    }

			          	$areas = csv_to_array($file);

			         	DB::table('students')->insert($areas);	
						return Redirect::back()->with('success', ('Fichier a été importé avec succès!'));
						
					} else {
						return Redirect::back();
					}
				}
			}
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