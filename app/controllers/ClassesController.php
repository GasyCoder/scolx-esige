<?php

class ClassesController extends BaseController {



	public function indexNiveau()
	{
		$title = 'Classes';
		$sous  = 'Listes';
		$niveau = TheClass::orderBy('id', 'asc')->paginate(15);
		return View::make('backend.admin.pedagogie.Niveau.index', compact('niveau'))->with('title', $title)->with('sous', $sous);
	}


	public function store()
	{
		if (Request::ajax()){

	
			$inputs = Input::all();
			$validation = Validator::make($inputs, ['name'=>'required']);
			if ($validation->fails()) {
				return 'false';
			} 

			else {
	
				$class = TheClass::create([

					'name' => e($inputs['name']),
					'short' => e($inputs['short']),
                    'note' => e($inputs['note'])
				]);

				return 'true';
			}

        }
	}

	/*public function edit($id)
	{
		$niveaux = TheClass::find($id);
		if ($niveaux !== null) {
			return View::make('admin.niveau.update', compact('niveaux'));
		} else {
			return Redirect::route('indexNiveau');
		}
*/
	
	public function update($id)
	{
		if (Request::ajax()){
			$inputs = Input::all();
			$validation = Validator::make($inputs, ['name'=>'required']);
			if ($validation->fails()) {
				return 'false';
			} 
			else {
				$up = TheClass::find($id);
				$up->name 	= e($inputs['name']);
				$up->short 	= e($inputs['short']);
              	$up->note 	= e($inputs['note']);
			}
			if (Input::has('status'))
			   {
			    $up->status = 1;

			   }else {
			   $up->status = 0;
			}
		$up->save();
		return 'true';

        }
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		
		$class = TheClass::find($id);

		if ($class !== null) {

			// remove class from this CahierTexte
			$cahierTexte = CahierTexte::where('class_id', $class->id)->get();
			foreach ($cahierTexte as $txt) {
				$txt->class_id = 0;
				$txt->save();
			}

			// remove class from this emploi
			$emploi = Emploi::where('class_id', $class->id)->get();
			foreach ($emploi as $em) {
				$em->class_id = 0;
				$em->save();
			}

			// remove as class from students table
			$as_class = User::where('class_id', $class->id)->get();
			foreach ($as_class as $class) {
				$class->class_id = 0;
				$class->save();
			}

			// remove subjects from this class
			$subjects = Subject::where('class_id', $class->id)->get();
			foreach ($subjects as $subject) {
				$subject->class_id = 0;
				$subject->save();
			}

			// delete all lessons of this class
			$lessons = Lesson::where('class_id', $class->id)->get();
			foreach ($lessons as $lesson) {
				$lesson->delete();
			}

			$class->delete();

			$path = Session::get('language');
			return Redirect::back()->with('success', Lang::get($path.'.Deleted_successfully'));
		} 

		else {
			return Redirect::back();
		}

		

		
	}


}
