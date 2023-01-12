@extends('backend.main')
<?php $path = Session::get('language'); ?>
@section('title') {{$title}} @stop
@section('content') 
<!-- Workspace -->
<main class="workspace">
<section class="breadcrumb">        
        <div>
        <h3>{{$title}}</h3>
        <ul>
            <li><a href="#no-link" class="link" data-target="[data-menu=ui]" data-toggle="tooltip-menu" data-tippy-content="UI">Menu</a></li>
            <li class="divider la la-arrow-right"></li>
            <li>Déliberation</li>
        </ul>
        </div>
</section>
@include('backend.pages.alerts')   
        <div class="grid lg:grid-cols-3 gap-5">
            <!-- Content -->
            <div class="lg:col-span-2">
            <div class="card p-5">
                    <table class="table table_striped w-full mt-3">
                        <thead>
                            <tr>
                                <th class="ltr:text-left rtl:text-right ">#</th>
                                <th class="ltr:text-left rtl:text-right ">Moyenne déliberé</th>
                                <th class="ltr:text-left rtl:text-right ">Session</th>
                                <th class="ltr:text-left rtl:text-right ">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($delibers as $key => $deliber)    
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td class="font-bold">{{ $deliber->moyenne }}</td>
                                <td class="font-bold">{{ $deliber->session }}</td>
                                <td>
                                <div class="inline-flex ltr:ml-auto rtl:mr-auto">
                                    @if(Auth::user()->is_admin) @if(!Auth::user()->is_secretaire)
                                    <a onclick="return confirm('{{ Lang::get($path.'.delete') }}')" href="{{ URL::route('deleteDeliber', $deliber->id) }}" class="btn btn-icon btn_outlined btn_danger ltr:ml-2 rtl:mr-2">
                                        <span class="la la-trash-alt"></span>
                                    </a>
                                    @endif @endif
                                </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @if(Auth::user()->is_admin)
            @if(!Auth::user()->is_secretaire)
            <div class="flex flex-col gap-y-5 lg:col-span-2 xl:col-span-1">
                <!-- Publish -->
                <div class="card p-5 flex flex-col gap-y-5">
                    <h3>Ajouter Moyenne</h3>
                    <div id="resultajax" class="center"></div>
                    {{ Form::open(['route'=>'savedeliber', 'class'=>'', 'id'=>'myForm', 'data-toggle'=>'validator']) }} 
                        <div class="mb-5">
                            <label class="label block mb-2" for="title">Moyenne delibérer</label>
                            <input id="moyenne" name="moyenne" type="number" value="10.00" class="form-control">
                        </div>
                        <div class="mb-5">
                            <label class="label block mb-2" for="content">Session</label>
                           <input id="session" name="session" type="number" value="1" class="form-control">
                        </div>
                        <div class="mt-10">
                            <button type="submit" class="btn btn_primary"><i class="la la-plus"></i> Ajouter</button>
                        </div>
                {{ Form::close() }}
                {{ HTML::script('public/assets/js/jquery-3.6.0.js') }}
                {{ HTML::script('public/assets/validator/validator.js') }}
                <script type="text/javascript">
                        $('#myForm').submit(function(event) {
                          event.preventDefault();
                          $('#resultajax').append('<img src="{{ url() }}/public/assets/images/loader.gif" alt="{{Lang::get($path.'.please_wait')}}" />');
                          $('#myForm input.btn').hide();
                           $.ajax({
                            type: 'POST',
                            url: '{{ route("savedeliber") }}',
                            data: $(this).serialize(),
                            success: function(data) {
                                if(data == 'true') {   
                                  $('#resultajax').html("<div class='alert alert_success'><strong class=''><bdi>Succès!</bdi> {{ Lang::get($path.'.add_successfully') }}</strong></div>");
                                  $('#myForm input.btn').show();
                                  setInterval(refresh, 1000);
                                 }
                                if(data == 'false') {
                                  $('#resultajax').html("<div class='alert alert_danger'><strong class=''><bdi>Erreur!</bdi> {{ Lang::get($path.'.error_please_try_again') }}</strong></div>");
                                  $('#myForm input.btn').show();
                                  setInterval(refresh, 1000);
                                }                    
                              }
                            });         
                          });
                          function refresh() {
                            // to current URL
                            window.location='{{ URL::current() }}';
                          }
                </script>
                </div>
            </div>
            @endif
            @endif
        </div>
@include('backend.pages.footer')        
    </main>
@stop