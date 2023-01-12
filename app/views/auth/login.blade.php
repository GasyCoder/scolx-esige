@extends('auth.pages.top')
<?php $control = Control::find(1); ?>
@section('title') Authentification @stop
@section('content')
    <!-- Top Bar -->
    <section class="top-bar">
        <!-- Brand -->
        <span class="brand">SCOLX</span>
        <nav class="flex items-center ltr:ml-auto rtl:mr-auto">
            <!-- Dark Mode -->
            <label class="switch switch_outlined" data-toggle="tooltip" data-tippy-content="Toggle Dark Mode">
                <input id="darkModeToggler" type="checkbox">
                <span></span>
            </label>
            <!-- Fullscreen -->
            <button id="fullScreenToggler" type="button"
                class="hidden lg:inline-block btn-link ltr:ml-5 rtl:mr-5 text-2xl leading-none la la-expand-arrows-alt"
                data-toggle="tooltip" data-tippy-content="Fullscreen"></button>
        </nav>
    </section>
    <div class="container flex items-center justify-center mt-0 py-3">
        <div class="w-full md:w-1/2 xl:w-1/3">
                    <div class="flex items-center justify-center gap-x-4 mt-4">
                        <div class="avatar w-20 h-20">
                            <img src="{{ url() }}/public/uploads/logo/{{$control->logo}}">
                        </div>
                    </div>
@include('auth.pages.alerts')
            {{ Form::open(['route'=>'users.check', 'id'=>'', 'class'=>'card mt-5 p-5 md:p-10'])  }}  	
                <div class="mb-5">
                    <label class="label block mb-2" for="email">Email</label>
                    <input id="email" name="email" type="text" class="form-control" placeholder="Saisir adresse e-mail">
                    <div class="help-block with-errors"></div>
                    @if($errors->first('email'))
                    <span class="text-red-700">{{ $errors->first('email') }}</span>
                    @endif  
                </div>
                <div class="mb-5">
                    <label class="label block mb-2" for="password">Mot de passe</label>
                    <label class="form-control-addon-within">
                        <input id="password" name="password" type="password" class="form-control border-none" placeholder="Saisir mot de passe">
                        <span class="flex items-center ltr:pr-4 rtl:pl-4">
                            <button type="button" class="btn btn-link text-gray-300 dark:text-gray-700 la la-eye text-xl leading-none" data-toggle="password-visibility">
                            </button>
                        </span>
                    </label>
                    <div class="help-block with-errors"></div>
                        @if($errors->first('password'))
                        <span class="text-red-700">{{ $errors->first('password') }}</span>
                        @endif
                </div>
                 <label class="custom-checkbox">
                           {{ Form::checkbox('remember', 'remember', false) }}
                            <span></span>
                            <span>Se souvenir de moi</span>
                </label>
                <div class="flex items-center">
                    <button type="submit" class="btn btn_success ltr:ml-auto rtl:mr-auto"><span class="la la-lock"></span> Se connecter</button>
                </div>
             {{ Form::close() }}

            <div class="mx-5 md:mx-10 footer flex justify-center items-center ">
                <center class="center">Created by <a href="https://gasycoder.com/" target="_blank">Gasy Coder</a> with ❤️</center>
            </div>
        </div>
    </div> 

@stop