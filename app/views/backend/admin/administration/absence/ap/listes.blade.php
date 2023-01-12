@extends('backend.main')
<?php $path = Session::get('language'); ?>
@section('title') Gestion d'absence @stop
@section('content')
<!-- Workspace -->
    <main class="workspace workspace_with-sidebar">
        <!-- Breadcrumb -->
        <section class="breadcrumb lg:flex items-start">
            <div>
@include('backend.break')
            </div>
        </section>
        <div class="breadcrumb breadcrumb_alt p-3 flex flex-wrap gap-2 mt-2">  
            <a href="{{ URL::to('/admin/absences/etudiants/anne_preparatoire').'/'.$class->id.'/'.rtrim(strtr(base64_encode($element->id), '+/', '-_'), '=').'/absence/ap'}}" class="btn btn-icon btn-icon_large btn_outlined btn_primary">
                <span class="la la-undo"></span>
            </a>
            <div class="flex flex-wrap gap-5 ltr:ml-auto rtl:mr-auto">
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
                            <option value="{{ URL::to('/admin/absences/etudiants').'/'.$mat->class_id.'/'.rtrim(strtr(base64_encode($mat->id), '+/', '-_'), '=')}}">{{ $mat->name }}</option>
                        @endforeach
                        </select>
                    <div class="custom-select-icon la la-caret-down"></div>
                </div>
            </div>
        </div>
    @if(count($absences) > 0)
      <div class="flex flex-col gap-y-5 ">
            <div class="card relative p-5">
                <table class="table-sorter table table_bordered w-full mt-3">
                        <thead>
                            <tr>
                                <th class="ltr:text-left rtl:text-right">Dates</th>
                                <th class="ltr:text-left rtl:text-right">Heurs</th>
                                <th class="" style="text-align:center">Présents</th>
                                <th class="" style="text-align:center">Absents</th>
                                <th class="ltr:text-left rtl:text-right">Matières</th>
                                <th class="text-center" style="text-align:center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                           @foreach($absences as $key => $absence)  
                            <?php 
                            $present = Absence::where('class_id', $absence->class_id)
                            ->where('parcour_id', $absence->parcour_id)
                            ->where('dateStart', $absence->dateStart)
                            ->where('dateEnd', $absence->dateEnd)
                            ->where('timeStart', $absence->timeStart)
                            ->where('timeEnd', $absence->timeEnd)
                            ->where('status', 1)->get();

                            $absent = Absence::where('class_id', $absence->class_id)
                            ->where('dateStart', $absence->dateStart)
                            ->where('dateEnd', $absence->dateEnd)
                            ->where('timeStart', $absence->timeStart)
                            ->where('timeEnd', $absence->timeEnd)
                            ->where('status', 0)->get();
                            ?>
                            <tr>
                                <td class="font-bold">
                                    <span class="la la-calendar"></span> {{ \Carbon\Carbon::parse($absence->dateStart)->format('d M')}} au 
                                    {{ \Carbon\Carbon::parse($absence->dateEnd)->format('d M Y')}}
                                </td>
                                <td class="font-bold">
                                    <span class="la la-clock"></span> {{ \Carbon\Carbon::parse($absence->timeStart)->format('H:i')}} à 
                                    {{ \Carbon\Carbon::parse($absence->timeEnd)->format('H:i')}}
                                </td>
                                <td class="font-bold text-center"><span class="badge badge_success">{{count($present)}}</span></td>
                                <td class="font-bold text-center"><span class="badge badge_danger">{{count($absent)}}</span></td>
                                <td>{{ $element->name }}</td>
                                <td class="text-center">
                                <div class="inline-flex ltr:ml-auto rtl:mr-auto">
                                    <a href="{{URL::route('print', $absence->class_id.'/'.rtrim(strtr(base64_encode($absence->element_id), '+/', '-_'), '=').'/'.rtrim(strtr(base64_encode($absence->dateStart), '+/', '-_'), '=').'/'.rtrim(strtr(base64_encode($absence->dateEnd), '+/', '-_'), '='))}}" target="_blank" class="btn btn-icon btn_outlined btn_secondary">
                                        <span class="la la-print"></span>
                                    </a>
                                    <a href="{{ URL::current().'/'.rtrim(strtr(base64_encode($absence->dateStart), '+/', '-_'), '=').'/'.rtrim(strtr(base64_encode($absence->dateEnd), '+/', '-_'), '=') }}" class="btn btn-icon btn_outlined btn_success ltr:ml-2 rtl:mr-2">
                                        <span class="la la-eye"></span>
                                    </a>
                                    @if(Auth::user()->is_admin) @if(!Auth::user()->is_secretaire)
                                    <a href="{{ URL::current().'/'.rtrim(strtr(base64_encode($absence->created_at), '+/', '-_'), '=') }}" class="btn btn-icon btn_outlined btn_danger ltr:ml-2 rtl:mr-2">
                                        <span class="la la-trash-alt"></span>
                                    </a>@endif @endif
                                </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>  
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
        <h2 class="p-5">Informations</h2>
        <hr>
        <div class="flex flex-col gap-y-5 p-5">
            <a href="#" class="flex items-center text-normal">
                <span class="la la-check-circle text-2xl leading-none ltr:mr-2 rtl:ml-2"></span>
                Classe
                <span class="badge badge_success ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">{{ $class->short }}</span>
            </a>
            <a href="#" class="flex items-center text-normal">
                <span class="la la-check-circle text-2xl leading-none ltr:mr-2 rtl:ml-2"></span>
                Matière
                <span class="badge badge_success ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">{{ $element->name }}</span>
            </a>
            <a href="#" class="flex items-center text-normal">
                <span class="la la-flag text-2xl leading-none ltr:mr-2 rtl:ml-2"></span>
                Année Universitaire
                <span class="badge badge_primary ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">{{$year->yearsUniv}}</span>
            </a>
        </div>
    </aside>
@stop