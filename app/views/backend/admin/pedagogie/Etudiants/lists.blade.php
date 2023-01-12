@extends('backend.main')
<?php $path = Session::get('language'); 
$control = Control::find(1);
?>
@section('title') {{ $title. ' '.$year->yearsUniv}} @stop

@section('content')
    <main class="workspace">
        <!-- Breadcrumb -->
        <section class="breadcrumb lg:flex items-start">
            <div class="p-8">
            <h3>Listes des étudiants - {{$class->short}}</h3>
            <ul>
                <li><a href="#">Etudiants</a></li>
                <li class="divider la la-arrow-right"></li>
                <li>Listes des étudiants</li>
            </ul>
            </div>
        </section>
         <div class="breadcrumb breadcrumb_alt p-3 flex flex-wrap gap-2 mt-2">  
            <a href="/admin/etudiants/inscription/{{$class->id}}/{{$parcour->id}}" class="btn btn_outlined btn_primary">
                <span class="la la-undo text-xl leading-none ltr:mr-1 rtl:ml-1"></span>
                Retour
            </a>
            <div class="flex flex-wrap gap-5 ltr:ml-auto rtl:mr-auto">
            <div class="custom-select mt-0">
              <select name="select_class_name" id="select_class_name" onchange="goToNext(this)" class="form-control">
                <option value="" selected disabled>--Autre classes--</option>
                  <option value="/admin/etudiants/inscription">Ajouter nouvel niveau</option>
                </select>
            <div class="custom-select-icon la la-caret-down"></div>
            </div>
             @if($class->id >=2)
            <div class="custom-select mt-0">
                      <select name="select_parcour_name" id="select_parcour_name" onchange="goToNext(this)" class="form-control">
                        <option value="" selected disabled>--Autre parcours--</option>
                        @foreach($parcours as $parcour)
                          <option value="{{ URL::to('/admin/etudiants').'/'.$class->id.'/'.$parcour->id}}/etudiants">{{ $parcour->name }}</option>
                        @endforeach
                        </select>
                    <div class="custom-select-icon la la-caret-down"></div>
            </div>
            @endif
            @if($class->id == 1)
            <button class="btn btn_primary">
                   <code>  Total: {{($studs)+($Mixt)}}</code>
            </button> 
            @endif
            @if($class->id >= 2)
            <button class="btn btn_primary">
                    <code> Total: {{$studs}}</code>
            </button> 
            @endif    
            </div>
        </div>       
@if(count($etudiants) >= 1)
        <div class="card p-5 mt-5">
            <div class="overflow-x-auto">
                <table class="table-sorter table table-auto table_hoverable w-full">
                    <thead>
                        <tr>
                            <th class="ltr:text-left rtl:text-right">Photo</th>
                            <th class="ltr:text-left rtl:text-right">Matricule</th>
                            <th class="ltr:text-left rtl:text-right">Nom complet</th>
                            <th class="ltr:text-left rtl:text-right">Niveau </th> 
                            @if($class->id >=2)
                            <th class="ltr:text-left rtl:text-right">Parcours </th>
                            @endif                    
                            <th class="text-center" style="text-align:center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($etudiants as $student)
                        <?php $instance = Instance::where('id', $student->id)
                                                    ->where('yearsUniv', $student->yearsUniv)
                                                    ->first();
                            $fichier  = Fichier::where('id', $student->id)
                                                    ->first();                        
                        ?>
                        <tr>
                            <td>
                            <div class=" avatar w-5 h-5">
                                @if(!empty($fichier->image))
                                <?php echo HTML::image('uploads/profiles/students/'.$student->fichier->image.'', '', ['class'=>'', 'width'=>'','height'=>'']) ?>
                                @elseif($instance->sexe == 1)
                                {{ HTML::image('public/assets/avatar/man.png', '', ['class'=>'', 'width'=>'','height'=>'']) }}
                                 @else {{ HTML::image('public/assets/avatar/woman.png', '', ['class'=>'', 'width'=>'','height'=>'']) }}
                                @endif
                            </div>
                            </td>
                            <td class="font-bold">{{$student->matricule}}</td>
                            <td class="font-bold">{{$student->fname}} {{$student->lname}}</td>
                            <td class="font-bold">{{$student->niveau->short}} @if($student->grade == 'AL')<span style="color:#4F46E5">Mixte</span>@endif
                            </td>
                            @if($class->id >=2)
                                <td class="font-bold">{{$student->parcour->abr}}</td>
                            @endif
                             <td class="text-center">
                                <div class="inline-flex ltr:ml-auto rtl:mr-auto">
                                <a href="{{URL::route('profileEtudiant', [$student->class_id, $student->parcour_id.'/'.rtrim(strtr(base64_encode($student->id), '+/', '-_'), '=')])}}" class="btn btn-icon btn_success">
                                  <span class="la la-user"></span>
                                </a>    
                                <a href="{{ URL::route('etudiantEdit', [$student->id, $class->id, $parcour->id])}}" class="btn btn_outlined btn-icon btn_primary ltr:ml-2 rtl:mr-2"> <span class="la la-pen-fancy"></span></a>
                            @if(Auth::user()->is_admin) 
                            @if(!Auth::user()->is_secretaire)
                                <a onclick="return confirm('{{ Lang::get($path.'.delete') }}')" href="{{ URL::route('deleteStudent', $student->id)}}" class="btn btn-icon btn_danger ltr:ml-2 rtl:mr-2">
                                 <span class="la la-trash-alt"></span>
                                </a>
                            @endif 
                            @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
@else
<br>
<div class="alert alert_outlined alert_danger">
<strong class="uppercase"><bdi>Désolé!</bdi></strong>
 Il n'y a pas des données disponible ici. Veuillez ajouter votre <b><a href="{{ URL::route('inscriptions', [$class->id, $parcour->id])}}" class="underline">étudiants</a></b>.  
<button type="button" class="dismiss la la-times" data-dismiss="alert"></button>
</div>
@endif     
@include('backend.pages.footer')
@section('js')
<script type="text/javascript">
 var urlmenu = document.getElementById( 'select_parcour_name' );
 urlmenu.onchange = function() {
      window.open( this.options[ this.selectedIndex ].value, '_self');
 };
</script>
<script type="text/javascript">
/*function goToClass(x) {
  if(x.value != '') {
    window.location = '/admin/etudiants/inscription/'+x.value;
  }
}*/
var urlmenu = document.getElementById( 'select_class_name' );
 urlmenu.onchange = function() {
      window.open( this.options[ this.selectedIndex ].value, '_self');
 };    
</script>
@endsection
</main>
@include('backend.admin.pedagogie.Etudiants.formAdd')
@stop