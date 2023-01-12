@extends('backend.main')
<?php $path = Session::get('language'); $control = Control::find(1);?>
@section('title') Details des absences @stop
@section('content')

<main class="workspace workspace_with-sidebar">
        <!-- Breadcrumb -->
        <section class="breadcrumb lg:flex items-start">
            <div>
@include('backend.break')
            </div>
        </section>
        <div class="breadcrumb breadcrumb_alt p-3 flex flex-wrap gap-2 mt-2">  
            <a href="/admin/absences/etudiants/{{ $class->id }}/{{ $parcour->id.'/'.rtrim(strtr(base64_encode($element->id), '+/', '-_'), '=') }}" class="btn btn-icon btn-icon_large btn_outlined btn_primary">
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
                      <select name="select_parcour_name" id="select_parcour_name" onchange="goToNext(this)" class="form-control">
                        <option value="" selected disabled>--Autre parcours--</option>
                        @foreach($parcours as $select_parcour)
                          <option value="{{ $select_parcour->id}}">{{ $select_parcour->name }}</option>
                        @endforeach
                        </select>
                    <div class="custom-select-icon la la-caret-down"></div>
            </div>
            <div class="flex flex-wrap gap-2 ltr:ml-auto rtl:mr-auto">
                <span class="badge badge_outlined badge_info font-bold">
                    <span class="la la-flag text-xl leading-none"></span>
                    Année Universitaire: {{$year->yearsUniv}}
                </span>
                 <span class="badge badge_warning font-bold" style="color:#333">
                    <span class="la la-check-square text-xl leading-none"></span>
                    Parcours: {{ $parcour->name }}
                </span>
                <a href="{{URL::route('print', [$class->id, $parcour->id.'/'.rtrim(strtr(base64_encode($element->id), '+/', '-_'), '=').'/'.rtrim(strtr(base64_encode($mode->dateStart), '+/', '-_'), '=').'/'.rtrim(strtr(base64_encode($mode->dateEnd), '+/', '-_'), '=')])}}" target="_blank" class="badge badge_secondary font-bold">
                    <span class="la la-print text-xl leading-none"></span>
                    Mode Impression
                </a>
            </div>
        </div>  
            <!-- Bordered -->
                <div class="card p-5">
                    <table class="table-sorter table table_bordered w-full mt-3">
                        <thead>
                            <tr class="text-xl"> 
                             <th colspan="7" style="text-align:center;">
                                <span class="la la-calendar"></span> <code> {{ \Carbon\Carbon::parse($mode->dateStart)->format('d M')}} au {{ \Carbon\Carbon::parse($mode->dateEnd)->format('d M Y')}} </code><br>
                                <small><u style="color:#16A34A">Présents</u> : <b>{{$presents}}</b></small> | <small><u style="color:#DC2626">Absents</u> : <b>{{$absents}}</b><br>
                                <?php $students = Student::where('class_id', $class->id)->where('parcour_id', $parcour->id)->count();?>
                                    Eff Total: <b>{{$students}}</b>    
                                </small>
                                <h4><u>Matière</u>: <span style="color:#000">{{$element->name}}</span></h4>
                             </th>
                            </tr>
                            <tr style="color:#334155">
                                <th class="ltr:text-left rtl:text-right" style="text-align:center;">#</th>
                                <th class="ltr:text-left rtl:text-right" style="text-align:center;">Photo</th>
                                <th class="ltr:text-left rtl:text-right">Etudiants</th>
                                <th class="" style="text-align:center;">Niveaux</th>
                                <th class="text-center" style="text-align:center;">Heurs</th>
                                <th class="text-center" style="text-align:center;">Statuts</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($absenceShow as $key => $showabs) 
                            <?php 
                                $student = Student::where('matricule', $showabs->id_student)->first();
                                $ec = EC::where('id', $showabs->element_id)->first();  
                            ?>   
                            <tr>
                                <td class="text-center">{{$key+1}}</td>
                                <td>
                                <center>
                                 <a href="{{URL::route('profileEtudiant', [$student->class_id, $student->parcour_id.'/'.rtrim(strtr(base64_encode($student->id), '+/', '-_'), '=')])}}">    
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
                                <td class="text-center">{{$student->niveau->short}} @if($student->grade == 'AL') mixte @endif</td>
                                <td class="text-center">
                                    {{ \Carbon\Carbon::parse($showabs->timeStart)->format('H:i')}} à 
                                    {{ \Carbon\Carbon::parse($showabs->timeEnd)->format('H:i')}}
                                </td>
                                @if($showabs->status == 0)
                                    <td class="text-center"><span class="badge badge_danger inline-block leading-none text-center py-1 px-2 font-bold" style="font-size: .75em;">
                                    @if($student->sexe == 1)Absent @else Absente @endif</span></td>
                                @else
                                    <td class="text-center"><span class="badge badge_success inline-block leading-none text-center py-1 px-2 font-bold" style="font-size: .75em;">
                                    @if($student->sexe == 1)Présente @else Présent @endif</span></td> 
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
function goToClass(x) {
  if(x.value != '') {
    window.location = '/admin/absences/'+x.value;
  }
}
</script>
<script type="text/javascript">
function goToNext(c) {
  if(c.value != '') {
    window.location = '/admin/absences/etudiants/{{ $class->id}}/'+c.value;
  }
}
</script>
@endsection
</main>
@stop