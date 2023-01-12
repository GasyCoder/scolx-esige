<?php

class UserController extends BaseController {

	protected $layouts = 'layouts.frontend';

	protected $user_rules = [	

			'fname'=>'required',
			'email'=>'email|required|unique:users',
			'password'=>'required|min:4',
			//'accept' => 'required'
			//'password_confirm'=>'required|same:password'

	];


	public function login()
	{
		return View::make('auth.login');
	}

	public function logout() {

		Auth::logout();
		return Redirect::route('home');

	}



	/*public function register() {

		return View::make('auth.register');
	}*/

	/*public function register_store() {

			$inputs = Input::all();
			$validation = Validator::make($inputs, $this->user_rules); 
			if ($validation->fails()) {
				return Redirect::back()->withInput()->withErrors($validation);
			} else {

			$control = Control::find(1);
			$user = User::all();
			$confirmation_code = str_random(30);

			if ($control->close_site == 0) {

					$user = User::create([
						'is_student' => 1,
						'fname' => e(Input::get('fname')),
						'lname' => e(Input::get('lname')),
						'password' => Hash::make(e(Input::get('password'))),
						'email' => e(Input::get('email')),
						'confirmation_code' => $confirmation_code
					]);

				$user->save();

				Mail::send('emails.verify', compact('confirmation_code', 'fname'), function($message) {
		            $message->to(Input::get('email'), Input::get('fname'))->subject('Confirmez l\'adresse e-mail de votre compte');
		        });

				 return Redirect::route('login')->withWarning('Votre inscription est terminé. Veuillez vérifier votre boîte email et suivre les instructions pour terminer le processus d\'inscription! (Pensez à vérifier dans le spams)');
			} 
			else {
				Auth::logout();
				return Redirect::route('home');
			}

		}

}*/


   public function confirm($confirmation_code)
    {
        if( ! $confirmation_code)
        {
            return Redirect::home();
        }

        $user = User::whereConfirmationCode($confirmation_code)->first();

        if ( ! $user)
        {
            return Redirect::home();
        }

        $user->confirmed = 1;
        $user->confirmation_code = null;
        $user->save();

        //Flash::message('You have successfully verified your account. You can now login.');
        //return Redirect::route('auth')->withSuccess('Vous avez vérifié votre compte avec succès.  Connectez-vous.');
        return View::make('auth.login')->with('success', ('Votre a été activé.'));
    }

	public function check()
	{
		$inputs = Input::all();
		$validation = Validator::make($inputs, $this->user_rules); 
		if (Input::get('rememberme')) {
			$remember = true;
		} else { 
			$remember = false; 
		}


		$email = e($inputs['email']);
		$password = e($inputs['password']);

		$validation = Validator::make($inputs, ['email'=>'required', 'password'=>'required']);

		if ($validation->fails()) {

			return Redirect::back()->withErrors($validation);

		}

		$credentials = [
            'email' => Input::get('email'),
            'password' => Input::get('password'),
            'confirmed' => 1
        ];

       if ( !Auth::attempt($credentials))

          {
            return Redirect::back()->withInput()->withError('Nous n\'avons pas pu vous connecter');
        }

		 else {

		$control = Control::find(1);
		if ($control->close_site == 0) {

			if (Auth::attempt(['email'=>$email, 'password'=>$password], $remember)) {

				Auth::attempt(['email'=>$email, 'password'=>$password], $remember);

				if (Auth::check()) {

					if(Auth::user()->is_admin) {
						return Redirect::route('panel.admin');
					}
					elseif(Auth::user()->is_student) {
						return Redirect::route('student_panel');
					}
					elseif(Auth::user()->is_teacher) {
						return Redirect::route('teacher_panel');
					}
					else {
						return Redirect::route('home');
					}
				}
			} 

			}

			else {
				$path = Session::get('language');
				return Redirect::back()->with('error', Lang::get($path.'.username_or_password_error'));
			}
		}
	}

}
