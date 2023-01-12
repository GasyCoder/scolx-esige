@extends('backend.main')
<?php $path = Session::get('language'); ?>
@section('title') Modifier note de {{$mark->stud->fname.' '. $mark->stud->lname}} @stop
@section('content')
<style type="text/css">
input[type=number] {
  background-color:#D1FAE5;
  border: 1px solid #15803D;
  font-weight: bold;
}
</style>
    <main class="workspace">
<section class="breadcrumb lg:flex items-start">   
<div>   
</div>
</section>
<div class="breadcrumb breadcrumb_alt p-3 flex flex-wrap gap-2 mt-2">  
           <a href="/admin/notes/etudiants/matieres/anne_preparatoire/{{$class->id.'/1/'.rtrim(strtr(base64_encode($element->id), '+/', '-_'), '=').'/'.$element->codeEc}}/afficher/notes_ap" class="btn btn_primary">
                <span class="la la-undo text-xl leading-none ltr:mr-1 rtl:ml-1"></span>
                Retour
            </a>
</div>
    <div class="container flex items-center justify-center mb-2 py-1">
        <div class="card p-5 flex flex-col gap-y-2 w-full md:w-1/2 xl:w-1/4">
            <div class="mx-2 md:mx-3">
                <h3 class=""> <span class="la la-edit"></span>{{$title}}</h3>
            </div>
            <hr class="border-dashed">
            <div id="resultajax2" class="center"></div>
            {{ Form::open(['route'=>['updateNoteStd', $mark->id], 'class'=>'', 'id'=>'myForm2', 'data-toggle'=>'validator'])  }}   
                <div class="mb-5 w-full">
                <label class=" block mb-2" for="fname">Etudiant</label>
                <input type="text" name="" disabled value="{{$mark->stud->fname.' '.$mark->stud->lname }}" class="form-control">
                </div>
                <div class="mb-5 w-full">
                <label class=" block mb-2" for="mat">Matière</label>
                <input type="text" name="" disabled value="{{$elex->name}}" class="form-control">
                </div>
                <div class="mb-5 w-full">
                <label class="label block mb-2" for="fname">Note</label>
                <input type="number" name="note" value="{{$mark->note}}" class="form-control">
                </div>     
                <div class="mt-5">

                    <button class="btn btn_success"><span class="la la-sync"></span> Modifier</button>
                </div>
            {{ Form::close() }}

            @include('backend.admin.notes.update.ajax')
        </div>
    </div>
@include('backend.pages.footer')
@section('js')
<script type="text/javascript">
 $('#teacher').select2();
</script>

<script type="text/javascript">
 var urlmenu = document.getElementById( 'select_licence_name' );
 urlmenu.onchange = function() {
      window.open( this.options[ this.selectedIndex ].value, '_self');
 };
</script>

<script type="text/javascript">
 var urlmenu = document.getElementById( 'select_al_name' );
 urlmenu.onchange = function() {
      window.open( this.options[ this.selectedIndex ].value, '_self');
 };
</script>

@endsection   
</main>
 <!-- Sidebar -->
    <aside class="sidebar">
        <!-- Toggler - Mobile -->
        <button class="sidebar-toggler la la-ellipsis-v" data-toggle="sidebar"></button>
        <!-- Tags -->
       <h2 class="p-5">Objets sélectionnés</h2>
        <hr>
         <div class="flex flex-col gap-y-5 p-5">
            <a href="#" class="flex items-center text-normal">
                <span class="la la-check-circle text-2xl leading-none ltr:mr-2 rtl:ml-2"></span>
                Niveau
                <span class="badge badge_success ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">{{$class->name}}</span>
            </a>
        </div>
    </aside>
@stop