@extends('backend.main')
<?php $path = Session::get('language'); $control = Control::find(1);?>
@section('title') Ajouter notes Examen {{$class->short}} @stop
@section('content')
<style type="text/css">
input[type=number]:focus {
  background-color:#F0FDF4;
  border: 1px solid #1E40AF;
}
</style>
<main class="workspace workspace_with-sidebar">
        <!-- Breadcrumb -->
        <section class="breadcrumb lg:flex items-start">
            <div>
        <!-- Breadcrumb -->
            <h3>{{$title}} - {{$class->short}} - année d'étude: {{$years->yearsUniv}}</h3>
            <ul>
                <li><a href="#no-link" class="link" data-target="[data-menu=ui]" data-toggle="tooltip-menu" data-tippy-content="UI">Menu</a></li>
                <li class="divider la la-arrow-right"></li>
                <li>{{$sous}}</li>
            </ul>
            </div>
        </section>      
        <div class="breadcrumb breadcrumb_alt p-3 flex flex-wrap gap-2 mt-2">  
            <a href="/admin/notes/etudiants/{{ $class->id }}/{{ $parcour->id }}" class="btn btn-icon btn-icon_large btn_outlined btn_primary">
                <span class="la la-undo"></span>
            </a>
            <div class="flex flex-wrap gap-5 ltr:ml-auto rtl:mr-auto">
                <div class="">  
                    <div class="mt-2">
                        <span class="badge badge_outlined badge_success font-bold">
                            <span class="la la-check-square text-xl leading-none"></span>
                            Matière: {{ $element->name }}
                        </span>
                    </div>
                </div>  
            <div class="custom-select mt-0">
              <select name="select_class_name" id="select_class_name" onchange="goToClass(this)" class="form-control">
                <option value="" selected disabled>--Autre classes--</option>
                  <option value="etudiants">Ajouter nouvel classe</option>
                </select>
            <div class="custom-select-icon la la-caret-down"></div>
            </div>
            <div class="custom-select mt-0">
                      <select name="select_parcour_name" id="select_parcour_name" onchange="goToNext(this)" class="form-control">
                        <option value="" selected disabled>--Autre parcours--</option>
                        @foreach($parcours as $select_parcour)
                          <option value="{{ $select_parcour->id}}">{{ $select_parcour->name }}</option>
                        @endforeach
                        </select>
                <div class="custom-select-icon la la-caret-down"></div>
            </div>
            <div class="custom-select mt-0">
                  <select name="select_element_name" id="select_element_name" onchange="goToNext(this)" class="form-control">
                    <option value="" selected disabled>--Autre matières--</option>
                    @foreach($elements as $mat)
                        <option value="{{ URL::to('/admin/notes/etudiants').'/'.$mat->class_id.'/'.$mat->parcour_id.'/'.$semestre->id.'/'.$type->id.'/'.rtrim(strtr(base64_encode($mat->id), '+/', '-_'), '=').'/'.rtrim(strtr(base64_encode($mat->codeEc), '+/', '-_'), '=').'/notes/add'}}">{{ $mat->name }}</option>
                    @endforeach
                    </select>
                <div class="custom-select-icon la la-caret-down"></div>
            </div>
            </div>
        </div>

@if($fixes > 0)        
        <div class="mt-3">
            <div class="lg:col-span-2 xl:col-span-3">
            <div class="alert alert_info mt-5">
                <strong class="uppercase"><bdi>Info!</bdi></strong>
                Le note de cet étudiant a été ajouté!
                <button type="button" class="dismiss la la-times" data-dismiss="alert"></button>
            </div> 
            @else 
            <div class="custom-select mt-0">
                <select name="semestre"class="form-control">
                  <option selected>@if($element->semestre == 1) Semestre 1 @else Semestre 2 @endif</option>
                </select>
            </div>              
            <form method="post" action="{{ URL::current() }}">  
            <div class="">   
                <div class="card p-5 mt-3">
                    <table class="table-sorter table table_bordered w-full mt-0">
                        <thead>
                            <tr style="color:#334155">
                                <th class="" style="text-align:center;" width="110">Photo</th>
                                <th class="ltr:text-left rtl:text-right" width="250">Nom complet</th>
                                <th class="" style="text-align:center;" width="50">Classe</th>
                                <th class="" style="text-align:center;" width="50">Parcour</th>
                                <th class="text-center" style="text-align:center;" width="110">Notes Examen</th>
                            </tr>
                        </thead>
                        <tbody>
                         @foreach($students as $key => $student)
                            <tr>
                                <td class="text-center">
                                <center>
                                <div class="avatar w-4 h-4">
                                   @if(!empty($student->image))
                                    <?php echo HTML::image('uploads/profiles/students/'.$student->image.'', '', ['class'=>'', 'width'=>'','height'=>'']) ?>
                                    @elseif($student->sexe == 1)
                                    {{ HTML::image('public/assets/avatar/man.png', '', ['class'=>'', 'width'=>'','height'=>'']) }}
                                     @else {{ HTML::image('public/assets/avatar/woman.png', '', ['class'=>'', 'width'=>'','height'=>'']) }}
                                    @endif
                                </div>
                                </center>
                                </td>
                                <td>
                                <a href="{{URL::route('profileEtudiant', [$student->class_id, $student->parcour_id.'/'.rtrim(strtr(base64_encode($student->id), '+/', '-_'), '=')])}}">
                                    {{$student->fname}} {{$student->lname}}
                                </a>
                                </td>
                                <td class="text-center">
                                @if($student->grade == 'AL')
                                Auditeur Libre
                                @else
                                {{$student->niveau->short}}
                                @endif
                                <input type="hidden" name="grade[]"         value="{{$student->grade}}">
                                <input type="hidden" name="id_student[]"    value="{{$student->id}}">
                                <input type="hidden" name="id_unite[]"      value="{{$ues->id}}">
                                <input type="hidden" name="codeUe[]"        value="{{$ues->codeUe}}">
                                <input type="hidden" name="yearsUniv[]"     value="{{$years->yearsUniv}}">
                                <input type="hidden" name="coef[]"          value="{{ $element->coef }}">
                                </td>
                                <td class="text-center">{{$student->parcour->abr}}</td>
                                <td class="text-center px-4">
                                <input type="number" step="any" value="00.0" max="20" pattern="[0-9]+([\.][0-9]+)?" class="form-control" placeholder="Saisir le note sur 20" id="s{{ $key+1 }}" name="noteExam[]" required>
                                <div class="help-block with-errors"></div>
                                @if($errors->first('noteExam'))
                                <span class="text-red-700">{{ $errors->first('noteExam') }}</span>
                                @endif
                                </td>
                            </tr>
                        @endforeach 
                        </tbody>
                    </table>
                   <div class="omt-aut">
                    <hr class="my-2 border-dashed">
                    <div class="flex px-0 flex flex-wrap gap-2 ltr:ml-auto rtl:mr-auto">
                        <button class="btn btn_primary ltr:ml-auto rtl:mr-auto"><span class="la la-plus text-xl"></span> Ajouter note</button>
                     </div>   
                    </div>
                     
                </div>
            </div>
            </form>
        </div>
        </div>
    @endif  
@include('backend.pages.footer')
@section('js')
<script type="text/javascript">
 var urlmenu = document.getElementById( 'select_element_name' );
 urlmenu.onchange = function() {
      window.open( this.options[ this.selectedIndex ].value, '_self');
 };
</script>
<script type="text/javascript">
function goToNext(c) {
  if(c.value != '') {
    window.location = '/admin/notes/etudiants/{{ $class->id}}/'+c.value;
  }
}
</script>
<script type="text/javascript">
function goToClass(x) {
  if(x.value != '') {
    window.location = '/admin/notes/'+x.value;
  }
}
</script>
@endsection
</main>
@stop