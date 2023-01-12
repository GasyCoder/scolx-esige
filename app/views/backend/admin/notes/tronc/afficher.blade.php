@extends('backend.main')
<?php $path = Session::get('language'); $control = Control::find(1);?>
@section('title') Liste notes par matières @stop
@section('content')
<main class="workspace workspace_with-sidebar">
        <!-- Breadcrumb -->
        <section class="breadcrumb lg:flex items-start">
            <div>
@include('backend.break')
            </div>
        </section>
        <div class="breadcrumb breadcrumb_alt p-3 flex flex-wrap gap-2 mt-2">  
            <a href="/admin/notes/commun-tronc/{{$class->id}}" class="btn btn-icon btn-icon_large btn_outlined btn_primary">
                <span class="la la-undo"></span>
            </a>
            <div class="custom-select mt-0">
                      <select name="select_class_name" id="select_class_name" onchange="goToClass(this)" class="form-control">
                        <option value="" selected disabled>--Autre classes--</option>
                          <option value="etudiants">Ajouter nouvel classe</option>
                        </select>
                    <div class="custom-select-icon la la-caret-down"></div>
            </div>
            <div class="custom-select mt-0">
                  <select name="select_element_name" id="select_element_name" onchange="goToNext(this)" class="form-control">
                    <option value="" selected disabled>--Autre matières--</option>
                    @foreach($elements as $mat)
                        <option value="{{ URL::to('/admin/notes/etudiants/afficher_note_tronc').'/'.$mat->class_id.'/'.rtrim(strtr(base64_encode($mat->id), '+/', '-_'), '=').'/'.rtrim(strtr(base64_encode($mat->codeEc), '+/', '-_'), '=')}}">{{ $mat->name }}</option>
                    @endforeach
                    </select>
                <div class="custom-select-icon la la-caret-down"></div>
            </div>
            <div class="flex flex-wrap gap-2 ltr:ml-auto rtl:mr-auto">
                <span class="badge badge_outlined badge_success font-bold">
                    <span class="la la-flag text-xl leading-none"></span>
                    Année Universitaire: {{$years->yearsUniv}} 
                </span>
                 <span class="badge badge_outlined badge_danger font-bold">
                    <span class="la la-check-square text-xl leading-none"></span>
                    Matière Tronc Commun : Oui
                </span>
            </div>
        </div>  
            <!-- Bordered -->
                <div class="card p-5">
                    <table class="table-sorter table table_bordered w-full mt-3">
                        <thead>
                            <tr class="text-xl"> 
                             <th colspan="7" style="text-align:center;"><span class="la la-book"></span> {{$element->name}}<br>
                                @if($element->id_teacher >=1)
                                <p class="text-sm" style="color:#262626">Enseignant: {{$element->teacher->grade}} {{$element->teacher->fname}} {{$element->teacher->lname}}</p>
                                @else  @endif
                             </th>
                            </tr>
                            <tr style="color:#334155">
                                <th class="ltr:text-left rtl:text-right" style="text-align:center;">#</th>
                                <th class="ltr:text-left rtl:text-right" style="text-align:center;">Photo</th>
                                <th class="ltr:text-left rtl:text-right">Etudiants</th>
                                <th class="" style="text-align:center;">Classe</th>
                                <th class="" style="text-align:center;">Parcour</th>
                                <th class="text-center" style="text-align:center;">Note</th>
                                 @if(Auth::user()->is_admin) @if(!Auth::user()->is_secretaire)<th class="text-center" style="text-align:center;" width="4">Modifier</th>@endif @endif
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($notestronc as $key => $mark) 
                        <?php $student = Student::where('class_id', $mark->class_id)
                                                    ->where('id', $mark->id_student)
                                                    ->groupBy('id')
                                                    ->first(); 

                            $matiere = EC::where('id', $mark->element_id)
                                            ->groupBy('codeEc')
                                            ->first();  
                        ?>     
                            <tr>
                                <td class="text-center">{{$key+1}}</td>
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
                                    <a href="">
                                    {{$student->fname}} {{$student->lname}}
                                    </a>
                                </td>
                                <td class="text-center">
                                @if($student->grade == 'AL')
                                Auditeur Libre
                                @else
                                {{$student->niveau->short}}
                                @endif
                                </td>
                                <td class="text-center">{{$student->parcour->abr}}</td>
                                <td class="text-center">
                                  @if($mark->note >= 10) 
                                   <span class="badge badge_success"> {{number_format($mark->note, 2, ',', '')}}</span>
                                   @else
                                    <span class="badge badge_danger"> {{number_format($mark->note, 2, ',', '')}}</span>
                                    @endif
                                </td>
                                @if(Auth::user()->is_admin) @if(!Auth::user()->is_secretaire)
                                <td class="text-center">
                                <div class="inline-flex ltr:ml-auto rtl:mr-auto">
                                    <a href="{{URL::route('soloyNote', [$mark->id, $mark->class_id, $student->id.'/'.rtrim(strtr(base64_encode($element->id), '+/', '-_'), '=')])}}" class="btn btn-icon btn_outlined btn_success ltr:ml-5 rtl:mr-5">
                                        <span class="la la-pen-fancy"></span>
                                    </a>
                                    <a onclick="return confirm('{{ Lang::get($path.'.delete') }}')" href="{{ URL::current() . '?id=' . $mark->id }}" class="btn btn-icon btn_outlined btn_danger ltr:ml-2 rtl:mr-2">
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