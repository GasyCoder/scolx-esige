@extends('backend.main')
<?php $path = Session::get('language'); ?>
@section('title') Parcours @stop
@section('content') 
<!-- Workspace -->
<main class="workspace">
<section class="breadcrumb">        
@include('backend.break')
</section>
        <div class="grid lg:grid-cols-3 gap-5">
            <!-- Content -->
            <div class="lg:col-span-2">
            <div class="card p-5">
                    <h3>Listes des parcours <small class="font-bold">Total:( {{(count($parcours))}} )</small></h3>
                    <table class="table-sorter table table_striped w-full mt-3">
                        <thead>
                            <tr>
                                <th class="ltr:text-left rtl:text-right ">#</th>
                                <th class="ltr:text-left rtl:text-right ">Intitulé</th>
                                <th class="ltr:text-left rtl:text-right ">Abréviation</th>
                                <th class="ltr:text-left rtl:text-right ">Classes</th>
                                <th class="ltr:text-left rtl:text-right ">Activer</th>
                                <th class="ltr:text-left rtl:text-right ">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($parcours as $parcour)    
                            <tr>
                                <td>{{ $parcour->id }}</td>
                                <td class="font-bold">{{ $parcour->name }}</td>
                                <td class="font-bold">{{ $parcour->abr }}</td>
                                <td class="font-bold">{{ $parcour->niveau->short }}</td>
                                <td>
                                @if($parcour->status == 1)<div class="badge badge_outlined badge_success">Oui</div> @else <div class="badge badge_outlined badge_danger">Non</div> @endif
                                </td>
                                <td>
                                <div class="inline-flex ltr:ml-auto rtl:mr-auto">
                                    <a href="{{ URL::current() . '?id=' . $parcour->id }}" class="btn btn-icon btn_outlined btn_success ltr:ml-2 rtl:mr-2">
                                        <span class="la la-pen-fancy"></span>
                                    </a>
                                    @if(Auth::user()->is_admin) @if(!Auth::user()->is_secretaire)
                                    <a onclick="return confirm('{{ Lang::get($path.'.delete') }}')" href="{{ URL::route('deleteP', $parcour->id) }}" class="btn btn-icon btn_outlined btn_danger ltr:ml-2 rtl:mr-2">
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
            <div class="flex flex-col gap-y-5 lg:col-span-2 xl:col-span-1">
                <!-- Publish -->
                <div class="card p-5 flex flex-col gap-y-5">
                    <h3>Ajouter Parcours</h3>
                    <div id="resultajax" class="center"></div>
                    {{ Form::open(['route'=>'storeParcour', 'class'=>'', 'id'=>'myForm', 'data-toggle'=>'validator']) }} 
                        <div class="mb-5">
                            <label class="label block mb-2" for="title">Intitulé</label>
                            <input id="name" name="name" type="text" class="form-control">
                        </div>
                        <div class="mb-5">
                            <label class="label block mb-2" for="content">Abréviation</label>
                           <input id="abr" name="abr" type="text" class="form-control">
                        </div>
                        <div class="mb-5">
                            <label class="label block mb-2" for="category">Classes</label>
                            <div class="custom-select">
                                <select class="form-control" name="class_id">
                                    <option selected disabled>Choisir</option>
                                    @foreach($classes as $class)
                                       <option value="{{ $class->id }}">{{ $class->short }}</option>
                                    @endforeach
                                </select>
                                <div class="custom-select-icon la la-caret-down"></div>
                            </div>
                        </div>
                        <div class="mt-10">
                            <button type="submit" class="btn btn_primary uppercase">Ajouter</button>
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
                            url: '{{ route("storeParcour") }}',
                            data: $(this).serialize(),
                            success: function(data) {
                                if(data == 'true') {   
                                  $('#resultajax').html("<div class='alert alert_success'><strong class=''><bdi>Succès!</bdi> {{ Lang::get($path.'.add_successfully') }}</strong></div>");
                                  $('#myForm input.btn').show();
                                  //setInterval(refresh, 1000);
                                 }
                                if(data == 'false') {
                                  $('#resultajax').html("<div class='alert alert_danger'><strong class=''><bdi>Erreur!</bdi> {{ Lang::get($path.'.error_please_try_again') }}</strong></div>");
                                  $('#myForm input.btn').show();
                                  setInterval(refresh, 2000);
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
        </div>
@include('backend.pages.footer')        
    </main>
@stop