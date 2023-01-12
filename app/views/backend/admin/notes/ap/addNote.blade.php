@extends('backend.main')
<?php $path = Session::get('language'); $control = Control::find(1);?>
@section('title') Ajouter les notes - {{$class->name}} @stop
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
            <h3>Ajouter les notes - {{$class->short}} - année d'étude {{$years->yearsUniv}}</h3>
            <ul>
                <li><a href="#no-link" class="link" data-target="[data-menu=ui]" data-toggle="tooltip-menu" data-tippy-content="UI">Notes</a></li>
                <li class="divider la la-arrow-right"></li>
                <li>{{$sous}}</li>
            </ul>
            </div>
        </section>
@include('backend.pages.alerts')        
        <div class="breadcrumb breadcrumb_alt p-3 flex flex-wrap gap-2 mt-2">  
            <a href="/admin/notes/etudiants/matieres/anne_preparatoire/{{$class->id}}" class="btn btn-icon btn-icon_large btn_outlined btn_primary">
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
                  <select name="select_element_name" id="select_element_name" onchange="goToNext(this)" class="form-control">
                    <option value="" selected disabled>--Autre matières--</option>
                    @foreach($elements as $mat)
                        <option value="{{ URL::to('/admin/notes/etudiants').'/'.$mat->class_id.'/'.rtrim(strtr(base64_encode($mat->id), '+/', '-_'), '=').'/'.rtrim(strtr(base64_encode($mat->codeEc), '+/', '-_'), '=').'/notes/add'}}">{{ $mat->name }}</option>
                    @endforeach
                    </select>
                <div class="custom-select-icon la la-caret-down"></div>
            </div>
            </div>
        </div>
@if(count($fixes) > 0)        
        <div class="mt-3">
            <div class="lg:col-span-2 xl:col-span-3">
            <div class="alert alert_info mt-5">
                <strong class="uppercase"><bdi>Info!</bdi></strong>
                Le note de cet étudiant a été ajouté!
                <button type="button" class="dismiss la la-times" data-dismiss="alert"></button>
            </div> 
            @else 
             <form method="post" action="{{ URL::current() }}">
            <div class="">   
                <div class="flex flex-wrap flex-row -mx-4 mb-5">
                   <input type="hidden" name="yearsUniv" value="{{$years->yearsUniv}}">
                </div> 
                 <div class="flex flex-wrap flex-row -mx-4 mb-5">
                   <input type="hidden" name="codeUe" value="{{$ues->codeUe}}">
                </div>    
                <div class="card p-5 mt-3">
                    <table class="table-sorter table table_bordered w-full mt-0">
                        <thead>
                            <tr style="color:#334155">
                                <th class="" style="text-align:center;">Photo</th>
                                <th class="ltr:text-left rtl:text-right">Nom complet</th>
                                <th class="" style="text-align:center;">Classe</th>
                                <th class="" style="text-align:center;">Parccour</th>
                                <th class="text-center" style="text-align:center;">Ajouter note</th>
                            </tr>
                        </thead>
                        <tbody>
                         @foreach($studentsAp as $key => $student)      
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
                                <input type="hidden" name="grade[]" value="{{$student->grade}}">
                                <input type="hidden" name="etudiant_id[]" value="{{$student->id}}">
                                </td>
                                <td class="text-center">{{$student->parcour->abr}}</td>
                                <td class="text-center px-4">
                                <input type="number" step="any" value="0.0" max="20" pattern="[0-9]+([\.][0-9]+)?" class="form-control" placeholder="Saisir le note sur 20" id="s{{ $key+1 }}" name="note[]" required>
                                <div class="help-block with-errors"></div>
                                @if($errors->first('note'))
                                <span class="text-red-700">{{ $errors->first('note') }}</span>
                                @endif
                                </td>
                            </tr>
                        @endforeach
                        <!--Etudiants Mixte -->
                        @foreach($mixtes as $key => $al)      
                            <tr>
                                <td class="text-center">
                                <center>
                                <div class="avatar w-4 h-4">
                                   @if(!empty($al->image))
                                    <?php echo HTML::image('uploads/profiles/students/'.$al->image.'', '', ['class'=>'', 'width'=>'','height'=>'']) ?>
                                    @elseif($al->sexe == 1)
                                    {{ HTML::image('public/assets/avatar/man.png', '', ['class'=>'', 'width'=>'','height'=>'']) }}
                                     @else {{ HTML::image('public/assets/avatar/woman.png', '', ['class'=>'', 'width'=>'','height'=>'']) }}
                                    @endif
                                </div>
                                </center>
                                </td>
                                <td>
                                <a href="{{URL::route('profileEtudiant', [$al->class_id, $al->parcour_id.'/'.rtrim(strtr(base64_encode($al->id), '+/', '-_'), '=')])}}">
                                    {{$al->fname}} {{$al->lname}}
                                </a>
                                </td>
                                <td class="text-center">
                                @if($al->grade == 'AL')
                                Auditeur Libre
                                @else
                                {{$al->niveau->short}}
                                @endif
                                <input type="hidden" name="grade[]" value="{{$al->grade}}">
                                <input type="hidden" name="etudiant_id[]" value="{{$al->id}}">
                                </td>
                                <td class="text-center">{{$al->parcour->abr}}</td>
                                <td class="text-center px-4">
                                <input type="number" step="any" value="0.0" max="20" pattern="[0-9]+([\.][0-9]+)?" class="form-control" placeholder="Saisir le note sur 20" id="s{{ $key+1 }}" name="note[]" required>
                                <div class="help-block with-errors"></div>
                                @if($errors->first('note'))
                                <span class="text-red-700">{{ $errors->first('note') }}</span>
                                @endif
                                </td>
                            </tr>
                        @endforeach 
                        </tbody>
                    </table>
                   <div class="mt-auto">
                    <hr class="my-4 border-dashed">
                    <div class="flex px-4 flex flex-wrap gap-2 ltr:ml-auto rtl:mr-auto">
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
function goToClass(x) {
  if(x.value != '') {
    window.location = '/admin/notes/'+x.value;
  }
}
</script>
<script type="text/javascript">
    var Inputs = document.querySelectorAll('input');
for (var i=0; i<Inputs.length; i++) {
  Inputs[i].onblur = function() {
    this.value = this.value.replace(',','.');
  }
}

function multiplyAndPopulate() {
  var A1 = theForm.A1field.value.replace('.',',');
  var A2 = theForm.A2field.value.replace('.',',');
  var R1 = (A1*A2);
  if (isNaN(R1) == true) {
    alert('Invalid.');
    return false;
  }
  else {
    theForm.R1field.value = R1;
    theForm.R1field.value = theForm.R1field.value.replace(',','.');
  }
}
</script>
@endsection
</main>
@stop