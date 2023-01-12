<?php
class MentionController extends BaseController {

	protected function makeSlug($string = null, $separator = "-") {
	
	if (is_null($string)) {
	        return "";
	    }
	    $string = trim($string);
	    $string = mb_strtolower($string, "UTF-8");;
	    $string = preg_replace("/[\s-]+/", " ", $string);
	    $string = preg_replace("/[\s_]/", $separator, $string);

	    return $string;

	}

	public function index()
	{
		$title 		= 'Mentions';
		$sous       = 'Mentions';
		$mentions  	= Mention::where('status', 1)
								->groupBy('name')
								->orderBy('id', 'asc')
								->get();

		$parcours   = Parcour::where('class_id', '>=', 2)
								->orderBy('id', 'asc')
								->groupBy('name')
								->get();
		
		$domaines   = Domaine::where('status', 1)
								->groupBy('name')
								->orderBy('id', 'asc')
								->get();

		$classes  	= TheClass::all();

		return View::make('backend.admin.pedagogie.Mentions.index', compact('mentions', 'domaines', 'classes', 'parcours'))->with('title', $title)->with('sous', $sous);
	}


	public function storeM()
	{
		if (Request::ajax()){

	
			$inputs = Input::all();
			$validation = Validator::make($inputs, ['name'=>'required']);
			
			if ($validation->fails()) {
				return 'false';
			} 

			else {
				foreach ($inputs['parcour_id'] as $parcour) {

				$mention = new Mention();

				$mention->name 			= e($inputs['name']);
				$mention->domaine_id 	= e($inputs['domaine_id']);
				$mention->parcour_id    = $parcour;
				$mention->status 		= 1;
				$mention->save();

				}
				
				return 'true';
			}

        }
	}


	public function updateD($id)
	{
		if (Request::ajax()){

			$inputs = Input::all();
			$validation = Validator::make($inputs, ['name'=>'required']);
			if ($validation->fails()) {
				return 'false';
			} 

			else {


				$mention = Mention::find($id);

				$mention->name 			= e($inputs['name']);
				/*$mention->abr 			= e($inputs['abr']);
				$mention->class_id 		= e($inputs['class_id']);
				$mention->parcour_id 	= e($inputs['parcour_id']);*/
				$mention->domaine_id 	= e($inputs['domaine_id']);
				
			}
			
			if (Input::has('status')) {

			         $mention->status = 1;

			    } else {

			         $mention->status = 0;
				
				}

				$mention->save();
				return 'true';		
        }
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function delete($id)
	{
		
		$mention = Mention::find($id);
		if ($mention !== null) {

			// delete parcour from Etudiant
			/*$students = Student::where('parcour_id', $parcour->id)->get();
			foreach ($students as $student) {
				$student->parcour_id = 0;
				$student->save();
			}*/

			$mention->delete();
			$path = Session::get('language');
			return Redirect::back()->with('success', ('Parcour a été supprimé avec succès!'));
		} 

		else {
			return Redirect::back();
		}
		
	}


}
