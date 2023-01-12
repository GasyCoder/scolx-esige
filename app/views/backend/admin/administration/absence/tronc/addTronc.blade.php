@extends('backend.main')
<?php $path = Session::get('language'); $control = Control::find(1);?>
@section('title')   Ajouter absences - Tronc Commun @stop
@section('content')

<style type="text/css">
.c1 { filter: hue-rotate(0deg)   }
.c2 { filter: hue-rotate(30deg)  }
.c3 { filter: hue-rotate(60deg)  }
.c4 { filter: hue-rotate(90deg)  }
.c5 { filter: hue-rotate(120deg) }
.c6 { filter: hue-rotate(150deg) }
.c7 { filter: hue-rotate(180deg) }
.c8 { filter: hue-rotate(210deg) }
.c9 { filter: hue-rotate(240deg) }

input[type=checkbox] {
  transform: scale(2);
  margin: 10px;
  cursor: pointer;
}
body { cursor: default }
code{
    color: #10a9c1;
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
            <a href="/admin/absences/etudiants/{{ $class->id }}" class="btn btn-icon btn-icon_large btn_outlined btn_primary">
                <span class="la la-undo"></span>
            </a>
            <div class="flex flex-wrap gap-5 ltr:ml-auto rtl:mr-auto">
            <div class="custom-select mt-0">
              <select name="select_class_name" id="select_class_name" onchange="goToClass(this)" class="form-control">
                <option value="" selected disabled>--Autre niveau--</option>
                  <option value="etudiants">Ajouter nouvel niveau</option>
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
                        <option value="{{ URL::to('/admin/absences/etudiants').'/'.$mat->class_id.'/'.$mat->parcour_id.'/'.rtrim(strtr(base64_encode($mat->id), '+/', '-_'), '=').'/'.rtrim(strtr(base64_encode($mat->codeEc), '+/', '-_'), '=').'/absence/take'}}">{{ $mat->name }}</option>
                    @endforeach
                    </select>
                <div class="custom-select-icon la la-caret-down"></div>
            </div>
            </div>
        </div>
@if(count($studentsTronc) > 0)        
        <div class="mt-5">
            <div class="lg:col-span-2 xl:col-span-3">
             <form method="post" action="{{ URL::current() }}">
             <div class="breadcrumb breadcrumb_alt p-5">   
                <div class="flex flex-wrap flex-row -mx-4 mb-5">
                  <div class="mt-3 flex-shrink px-4 w-full xl:w-1/2">
                    <label class="label block mb-2" for="date">Date début *</label>
                    <input type="date" name="dateStart" value="" class="form-control">
                      @if($errors->first('dateStart'))
                      <span class="help-block text-red-700">{{ $errors->first('dateStart') }}</span>
                      @endif
                   </div>
                   <div class="mt-3 flex-shrink px-4 w-full xl:w-1/2">
                    <label class="label block mb-2" for="date">Date Fin *</label>
                      <input type="date" name="dateEnd" class="form-control">
                      @if($errors->first('dateEnd'))
                      <span class="help-block text-red-700">{{ $errors->first('dateEnd') }}</span>
                      @endif
                   </div>
                </div>
                <div class="flex flex-wrap flex-row -mx-4 mb-0">
                  <div class="mt-3 flex-shrink px-4 w-full xl:w-1/2">
                    <label class="label block mb-2" for="time">Heur début *</label>
                    <input type="time" name="timeStart" value="" class="form-control">
                      @if($errors->first('timeStart'))
                      <span class="help-block text-red-700">{{ $errors->first('timeStart') }}</span>
                      @endif
                   </div>
                   <div class="mt-3 flex-shrink px-4 w-full xl:w-1/2">
                    <label class="label block mb-2" for="time">Heur Fin *</label>
                      <input type="time" name="timeEnd" class="form-control">
                      @if($errors->first('timeEnd'))
                      <span class="help-block text-red-700">{{ $errors->first('timeEnd') }}</span>
                      @endif
                   </div>
                </div>
                </div>
                <div class="card p-5 mt-5">
                    <table class="table-sorter table table_bordered w-full mt-0">
                        <thead>
                            <tr style="color:#334155">
                                <th class="" style="text-align:center;">Photo</th>
                                <th class="ltr:text-left rtl:text-right">Nom complet</th>
                                <th class="" style="text-align:center;">Niveau</th>
                                <th class="" style="text-align:center;">Parcours</th>
                                <th class="text-center" style="text-align:center;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $matieres = EC::where('tronc', 1)->where('status', 1)->where('class_id', $class->id)->where('codeEc', $element->codeEc)->get(); ?> 
                        @if(count($matieres) > 0)
                        @foreach($studentsTronc as $key => $student) 
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
                                <input type="hidden" name="matricule[]" value="{{ $student->matricule }}">
                                </td>
                                <td class="text-center">{{$student->parcour->abr}}</td>
                                <td class="text-center">
                                <label class="px-4" for="s{{ $key+1 }}">
                                <input type="checkbox" class="c9" id="s{{ $key+1 }}" name="status[]" value="1">
                                <span style="color:#059669">@if($student->sexe == 1)Présent @else Présente @endif</span>
                                </label>
                                <label class="px-4" for="s{{ $key+1 }}">
                                <input type="checkbox" class="c6" id="s{{ $key+1 }}" name="status[]" value="0">
                                <span style="color:#C2410C">@if($student->sexe == 1)Absent @else Absente @endif</span>
                                </label>
                                </td>
                            </tr>
                        @endforeach     
                        @endif    
                        </tbody>
                    </table>
                   <div class="mt-auto">
                    <hr class="my-4 border-dashed">
                    <div class="flex px-4 flex flex-wrap gap-2 ltr:ml-auto rtl:mr-auto">
                        <button class="btn btn_primary ltr:ml-auto rtl:mr-auto"><span class="la la-plus text-xl"></span> Ajouter</button>
                    
                    <?php $absences = Absence::where('class_id', $class->id)
                                                ->where('element_id', $element->id)
                                                ->where('yearsUniv', $year->yearsUniv)
                                                ->where('status', 1)
                                                ->groupBy('dateStart')
                                                ->get(); 
                    ?>
                    @if(count($absences) > 0)    
                        <a href="{{URL::route('alltronc', $class->id.'/'.rtrim(strtr(base64_encode($element->id), '+/', '-_'), '='))}}" class="btn btn_success">    
                            <span class="la la-eye text-xl leading-none ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto"></span>
                            Voir les listes
                        </a>
                    @endif 

                     </div>   
                    </div>   
                </div>
            </form>
          @else
          <div class="alert alert_info mt-5">
                <strong class="uppercase"><bdi>Info!</bdi></strong>
                Il y n'a pas des étudiants disponible pour l'instant.
                <button type="button" class="dismiss la la-times" data-dismiss="alert"></button>
            </div>
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
    window.location = '/admin/absences/etudiants/{{ $class->id}}/'+c.value;
  }
}
</script>
<script type="text/javascript">
function goToClass(x) {
  if(x.value != '') {
    window.location = '/admin/absences/'+x.value;
  }
}
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
            <a href="#" class="flex items-center text-normal font-bold">
                <span class="la la-check-circle text-2xl leading-none ltr:mr-2 rtl:ml-2"></span>
                Matière
                <span class="badge badge_info ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">{{ $element->name }}</span>
            </a>
            <a href="#" class="flex items-center text-normal font-bold">
                <span class="la la-check-circle text-2xl leading-none ltr:mr-2 rtl:ml-2"></span>
               Tronc commun
                <span class="badge badge_danger ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">
                    @if($element->tronc == 1) Oui @else Non @endif
                </span>
            </a>
        </div>
        <hr class="border-dashed">
        <div class="flex flex-col gap-y-5 p-5">
            <a href="#" class="flex items-center text-normal">
                <span class="la la-users text-2xl leading-none ltr:mr-2 rtl:ml-2"></span>
                Total étudiants
                <?php $students = Student::where('class_id', $class->id)
                                            ->where('status', 0)->count() ?>
                <span class="badge badge_primary ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">{{ $students }}</span>
            </a>
            <a href="#" class="flex items-center text-normal">
                <span class="la la-flag text-2xl leading-none ltr:mr-2 rtl:ml-2"></span>
                Année Universitaire
                <span class="badge badge_primary ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">{{$year->yearsUniv}}</span>
            </a>
        </div>    
        <div class="mt-auto">
        <hr class="my-4 border-dashed">
        <div class="flex p-5">
        <?php $absences = Absence::where('class_id', $class->id)
                                                ->where('element_id', $element->id)
                                                ->where('yearsUniv', $year->yearsUniv)
                                                ->where('status', 1)
                                                ->groupBy('dateStart')
                                                ->get(); 
        ?>
        @if(count($absences) > 0)    
            <a href="{{URL::route('alltronc', $class->id.'/'.rtrim(strtr(base64_encode($element->id), '+/', '-_'), '='))}}" class="btn btn_success">    
                <span class="la la-eye text-xl leading-none ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto"></span>
                Voir les listes
            </a>
        @endif    
         </div>   
        </div>    
    </aside>
@stop