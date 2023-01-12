<?php

class HomeController extends BaseController {


	public function showWelcome()
	{

		$control = Control::find(1);
		return View::make('auth.login');

	}

	public function sitemap()
	{

		$articles = Article::orderBy('updated_at', 'desc')->get();
		$categories = Category::all();
		$pages = Page::all();

        $content = View::make('sitemap', compact('categories', 'articles', 'pages'));
        return Response::make($content)->header('Content-Type', 'text/xml;charset=utf-8');
        
	}

	public function close()
	{
		$control = Control::find(1);

		if ($control->close_site == 0) {
			return Redirect::route('login');
		} 
		else {
			$msg = $control->closing_msg;
			return View::make('close', compact('msg'));
		}
		
	}

}
