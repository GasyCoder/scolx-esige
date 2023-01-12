<?php

class TeacherController extends BaseController {

	protected $layouts = 'backend.admin';

	protected $rules = [	
			'fname'			=>'required',
			'phone_1'		=>'required',
			'birth'    		=> 'required',
			'birthLocation' => 'required',
			'sexe'  		=> 'required',
			'nationality'   => 'required'
	];

	protected $file_rules = [
			'csv_file'=>'required'
	];

	public function index()
	
	{	$title 		= 'Enseignants';
		$sous       = 'Liste des enseignants';
		$teachers 	= Teacher::orderBy('id', 'desc')->paginate(10);
		$teacher  	= Teacher::where('id', 1)->first();
		return View::make('backend.admin.pedagogie.Teachers.index', compact('teachers', 'teacher'))->with('title', $title)->with('sous', $sous);
	}

	public function add()
	{
		$title 			 = 'Ajouter';
		$sous       	 = 'Enseignants';
		return View::make('backend.admin.pedagogie.Teachers.add')->with('title', $title)->with('sous', $sous);
	}


	public function SaveTeacher()
	{
			$inputs 		= Input::all();
			$user_id        = Auth::user()->id;
			$validation     = Validator::make($inputs, $this->rules);
		
		   if ($validation->fails()) {

				return Redirect::back()->withInput()->withErrors($validation);
			} 

			else {
			
			if (Input::hasFile('image')) {

				$image = Input::file('image');

				$destinationPath = 'uploads/profiles/teachers';

				$filename = $image->getClientOriginalName();
				$filename = strtolower($filename);
				$filename = str_ireplace(' ', '_', $filename);
				$filename = round(microtime(true)).'_'. $filename;

				$upload_success = $image->move($destinationPath, $filename);

				$teachers 		    = Teacher::create([
				'user_id' 			=> $user_id,

				'grade' 		    => e(Input::get('grade')),
				'nationality' 		=> e(Input::get('nationality')),

				'fname' 			=> e(Input::get('fname')),
				'lname' 			=> e(Input::get('lname')),
				'sexe' 				=> e(Input::get('sexe')),
				'birth' 			=> e(Input::get('birth')),
				'birthLocation' 	=> e(Input::get('birthLocation')),

				'address' 			=> e(Input::get('address')),
				'email' 			=> e(Input::get('email')),
				'phone_1' 			=> e(Input::get('phone_1')),
				'phone_2' 			=> e(Input::get('phone_2')),
				'facebook' 			=> e(Input::get('facebook')),

				'status' 			=> 1,

				'image' => $filename

				]);

				}

			else {
				
				$teachers 		    = Teacher::create([
				
				'user_id' 			=> $user_id,
				'grade' 		    => e(Input::get('grade')),
				'nationality' 		=> e(Input::get('nationality')),
				
				'fname' 			=> e(Input::get('fname')),
				'lname' 			=> e(Input::get('lname')),
				'sexe' 				=> e(Input::get('sexe')),
				'birth' 			=> e(Input::get('birth')),
				'birthLocation' 	=> e(Input::get('birthLocation')),

				'address' 			=> e(Input::get('address')),
				'email' 			=> e(Input::get('email')),
				'phone_1' 			=> e(Input::get('phone_1')),
				'phone_2' 			=> e(Input::get('phone_2')),
				'facebook' 			=> e(Input::get('facebook')),

				'status' 			=> 1
				]);


		}

			$teachers->save();
			return Redirect::back()->with('success', 'Enseignant '.$inputs['fname'].' ajouté avec succès!');  
        }
	}
	

	public function TeacherEdit($id)
	{
		$title 		= 'Modifier';
		$sous       = 'Enseignant';
		$teacher 	= Teacher::find($id);
		return View::make('backend.admin.pedagogie.Teachers.updateTeacher', compact('teacher'))->with('title', $title)->with('sous', $sous);

	}

	
	public function updateTeacher($id)
	{
		$teacher 				= Teacher::find($id);
		$user_id 				= Auth::user()->id;

		if ($teacher !== null) {

				$inputs = Input::all();

				$validation = Validator::make($inputs, $this->rules);

				if ($validation->fails()) {
						return Redirect::back()->withInput()->withErrors($validation);
					} 

				else {
				
					if (Input::hasFile('image')) {

						$image = Input::file('image');

						$destinationPath = 'uploads/profiles/teachers';

						$filename = $image->getClientOriginalName();
						$filename = strtolower($filename);
						$filename = str_ireplace(' ', '_', $filename);
						$filename = round(microtime(true)).'_'. $filename;

						$upload_success = $image->move($destinationPath, $filename);
						
						$user_id 				= Auth::user()->id;
						$teacher->image 		=  $filename;

						$teacher->fname 		= e($inputs['fname']);
						$teacher->lname 		= e($inputs['lname']);
						$teacher->sexe 			= e($inputs['sexe']);
						$teacher->birth 		= e($inputs['birth']);
						$teacher->birthLocation = e($inputs['birthLocation']);
						$teacher->nationality 	= e($inputs['nationality']);
						$teacher->grade 		= e($inputs['grade']);

						$teacher->email 		= e($inputs['email']);
						$teacher->phone_1 		= e($inputs['phone_1']);
						$teacher->phone_2 		= e($inputs['phone_2']);
						$teacher->address 		= e($inputs['address']);
						$teacher->facebook 		= e($inputs['facebook']);
					} 

					else {
						
						$teacher->user_id 		= Auth::user()->id;

						$teacher->fname 		= e($inputs['fname']);
						$teacher->lname 		= e($inputs['lname']);
						$teacher->sexe 			= e($inputs['sexe']);
						$teacher->birth 		= e($inputs['birth']);
						$teacher->birthLocation = e($inputs['birthLocation']);
						$teacher->nationality 	= e($inputs['nationality']);
						$teacher->grade 		= e($inputs['grade']);

						$teacher->email 		= e($inputs['email']);
						$teacher->phone_1 		= e($inputs['phone_1']);
						$teacher->phone_2 		= e($inputs['phone_2']);
						$teacher->address 		= e($inputs['address']);
						$teacher->facebook 		= e($inputs['facebook']);

					}
						$teacher->save();
						return Redirect::back()->withSuccess(('Enseignant '.$inputs['fname'].' a été modifié avec succès!'));
					}

				} else {
					return Redirect::route('indexTeacher');
				}
	}



	
	public function profile($profile)
	{

		$profile = base64_decode(str_pad(strtr($profile, '-_', '+/'), strlen($profile) % 4, '=', STR_PAD_RIGHT));
		$teacher = Teacher::find($profile);
		$matieres = EC::where('id_teacher', $profile)->where('status', 1)->get();

		if ($teacher !== null) {
			return View::make('backend.admin.pedagogie.Teachers.profile', compact('teacher', 'matieres'));
		} 
		else {
			return Redirect::route('indexTeacher');
		}
	}


//PDP
	public function pdp_teacher($id)
	{
		$teacher = Teacher::find($id);
		$inputs  = Input::all();

		$validation = Validator::make($inputs, 
			[
				'image'=>'image',
			]
		); 

		if ($validation->fails()) {
			return Redirect::back()->withInput()->withErrors($validation);

		} else {


			if (Input::hasFile('image')) {

				// delete old image
				if (!empty($teacher->image)) {
					unlink(public_path()."/uploads/profiles/teachers/".$teacher->image);
				}

				$image = Input::file('image');
		
				$destinationPath = 'uploads/profiles/teachers/';

				$filename = $image->getClientOriginalName();
				$filename = strtolower($filename);
				$filename = str_ireplace(' ', '_', $filename);
				$filename = round(microtime(true)).'_'. $filename;

				$upload_success = $image->move($destinationPath, $filename);

				$teacher->image = $filename;
				$teacher->save();
				return Redirect::back()->withSuccess('Photo de profil a été changé avec succès!');
			} 	
		}
	}

	public function deleteteacher($id)
	{
		$teacher = Teacher::find($id);

		if ($teacher !== null) {

			$elements = EC::where('id_teacher', $teacher->id)->get();
			foreach ($elements as $element) {
				$element->id_teacher = 0;
				$element->save();
			}
			$teacher->delete();

			$path = Session::get('language');
			return Redirect::back()->with('success', Lang::get($path.'.Deleted_successfully'));

		}

		else {
			return Redirect::back('indexTeacher');
		}

	}

}