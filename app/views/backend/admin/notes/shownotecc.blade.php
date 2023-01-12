@extends('backend.main')
<?php $path = Session::get('language'); $control = Control::find(1);?>
@section('title') Liste notes par matières @stop
@section('content')
<style type="text/css">
input[type=float] {
  background-color:#D1FAE5;
  border: 1px solid #15803D;
}
</style>
<main class="workspace workspace_with-sidebar">
        <!-- Breadcrumb -->
        <section class="breadcrumb lg:flex items-start">
            <div>
@include('backend.break')
            </div>
        </section>
        @include('backend.pages.alerts')
        <div class="breadcrumb breadcrumb_alt p-3 flex flex-wrap gap-2 mt-2">  
            <a href="/admin/notes/etudiants/{{$class->id}}/{{$parcour->id}}/{{$semestre->id}}" class="btn btn-icon btn-icon_large btn_outlined btn_primary">
                <span class="la la-undo"></span>
            </a>
            <div class="custom-select mt-0">
                      <select name="select_class_name" id="select_class_name" onchange="goToClass(this)" class="form-control">
                        <option value="" selected disabled>--Autre niveau--</option>
                          <option value="etudiants">Ajouter nouvel niveau</option>
                        </select>
                    <div class="custom-select-icon la la-caret-down"></div>
            </div>
           <div class="custom-select mt-0">
                  <select name="select_element_name" id="select_element_name" onchange="goToNext(this)" class="form-control">
                    @if(!empty($element->id))
                        <option value="{{ $element->id }}" selected class="font-bold text-primary">{{ $element->name }}</option>
                    @else
                        <option value="" selected disabled>--Autre matières--</option>
                    @endif
                    @foreach($elements as $mat)
                        <option value="{{ URL::to('/admin/notes/etudiants').'/'.$mat->class_id.'/'.$mat->parcour_id.'/'.$semestre->codeSem.'/2/'.rtrim(strtr(base64_encode($mat->id), '+/', '-_'), '=').'/'.rtrim(strtr(base64_encode($mat->codeEc), '+/', '-_'), '=').'/afficher/notes/cc'}}">{{ $mat->name }}</option>
                    @endforeach
                    </select>
                <div class="custom-select-icon la la-caret-down"></div>
            </div>
            <div class="flex flex-wrap gap-2 ltr:ml-auto rtl:mr-auto">
               <span class="badge badge_outlined badge_success font-bold">
                    <span class="la la-flag text-xl leading-none"></span>
                    Session: 1 
                </span>
                <span class="badge badge_outlined badge_success font-bold">
                    <span class="la la-flag text-xl leading-none"></span>
                    Semestre : {{$semestre->codeSem}}                
                </span>
                <span class="badge badge_outlined badge_primary font-bold">
                    <span class="la la-check-square text-xl leading-none"></span>
                    Parcours: {{ $parcour->abr }}
                </span>
                <span class="badge badge_outlined badge_primary font-bold">
                    <span class="la la-check-square text-xl leading-none"></span>
                    Niveau: {{ $class->short }}
                </span>
            </div>
        </div> 
       <form method="post" action="{{ URL::current() }}">     
            <!-- Bordered -->
                <div class="card p-5">
                    <table class="table-sorter table table_bordered w-full mt-3">
                        <thead>
                            <tr class="text-xl"> 
                             <th colspan="7" style="text-align:center;"><span class="la la-book"></span> {{$element->name}}<br>
                                @if($element->id_teacher >= 1)
                                 <p class="text-sm" style="color:#262626">Enseignant: @if($element->teacher->sexe == 1) Mr. 
                                @else Mme. @endif {{$element->teacher->fname}} {{$element->teacher->lname}}</p>
                                @else  
                                @endif
                             </th>
                            </tr>
                            <tr style="color:#334155">
                                <th class="" width="5">#</th>
                                <th class="" width="5" style="text-align:center;">Photo</th>
                                <th class="ltr:text-left rtl:text-right">Etudiants</th>
                                <th class="" style="text-align:center;">Niveau</th>
                                <th class="text-center" style="text-align:center;">Note CC1</th>
                                 <th class="text-center" style="text-align:center;">Note CC2</th>
                                 @if(Auth::user()->is_admin) @if(!Auth::user()->is_secretaire)<th class="text-center" style="text-align:center;" width="4">Modifier</th>@endif @endif
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($notes as $key => $mark) 
                        <?php $student = Student::where('class_id', $mark->class_id)
                                                    ->where('parcour_id', $mark->parcour_id)
                                                    ->where('id', $mark->id_student)
                                                    ->first(); 
                            $noty = Notecc::where('notecc1', $mark->notecc1)
                                                    ->where('notecc2', $mark->notecc2)
                                                    ->first();
                            $matiere = EC::where('id', $mark->element_id)->first();  
                        ?>     
                            <tr>
                                <td class="text-center" width="5">{{$key+1}}</td>
                                <td>
                                <center>
                                 <a href="">    
                                <div class="avatar w-4 h-4">
                                   @if(!empty($student->image))
                                    <?php echo HTML::image('uploads/profiles/students/'.$student->image.'', '', ['class'=>'', 'width'=>'','height'=>'']) ?>
                                    @elseif($student->sexe == 1)
                                    {{ HTML::image('public/assets/avatar/man.png', '', ['class'=>'', 'width'=>'','height'=>'']) }}
                                     @else {{ HTML::image('public/assets/avatar/woman.png', '', ['class'=>'', 'width'=>'','height'=>'']) }}
                                    @endif
                                </div>
                                </a>
                                </center>
                                </td>
                                <td>
                                    <a href="{{URL::route('profileEtudiant', [$student->class_id, $student->parcour_id.'/'.rtrim(strtr(base64_encode($student->id), '+/', '-_'), '=')])}}">
                                    {{$student->fname}} {{$student->lname}}
                                    </a>
                                </td>
                                <td class="text-center">
                                {{$student->niveau->short}}
                                @if($student->grade == 'AL')
                                Mixte
                                @endif
                                </td>
                                <td class="text-center">
                                  @if($mark->notecc1 >= 10) 
                                   <span class="badge badge_success"> {{number_format($mark->notecc1, 2, ',', '')}}</span>
                                   @else
                                    <span class="badge badge_danger"> {{number_format($mark->notecc1, 2, ',', '')}}</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                  @if($mark->notecc2 >= 10) 
                                   <span class="badge badge_success"> {{number_format($mark->notecc2, 2, ',', '')}}</span>
                                   @else
                                    <span class="badge badge_danger"> {{number_format($mark->notecc2, 2, ',', '')}}</span>
                                    @endif
                                </td>
                                @if(Auth::user()->is_admin) @if(!Auth::user()->is_secretaire)
                                <td class="text-center">
                                <div class="inline-flex ltr:ml-auto rtl:mr-auto">
                                    <a href="{{URL::route('editNotecc', [$mark->id, $mark->class_id, $mark->parcour_id.'/'.rtrim(strtr(base64_encode($mark->element_id), '+/', '-_'), '=')])}}" class="btn btn-icon btn_outlined btn_success ltr:ml-5 rtl:mr-5">
                                        <span class="la la-pen-fancy"></span>
                                    </a>
                                    <a onclick="return confirm('{{ Lang::get($path.'.delete') }}')" href="{{ URL::route('removeNote', $mark->id )}}" class="btn btn-icon btn_outlined btn_danger ltr:ml-2 rtl:mr-2">    
                                        <span class="la la-trash-alt"></span>
                                    </a>
                                </div>
                                </td>
                                @endif
                                @endif
                              </tr>
                        @endforeach     
                        </tbody>
                    </table>
                </div>
            </form>
            </div>
            @include('backend.pages.footer')
@section('js')
<script type="text/javascript">
function goToNext(c) {
  if(c.value != '') {
    window.location = '/admin/notes/etudiants/{{ $class->id}}/'+c.value;
  }
}
</script>
<script type="text/javascript">
 var urlmenu = document.getElementById( 'select_element_name' );
 urlmenu.onchange = function() {
      window.open( this.options[ this.selectedIndex ].value, '_self');
 };
</script>
@endsection
</main>
@stop