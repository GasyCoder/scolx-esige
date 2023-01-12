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
        <div class="flex gap-x-2 mb-5">
            <a href="/admin/absences/etudiants/{{$class->id}}/{{$parcour->id}}" class="btn btn-icon btn-icon_large btn_outlined btn_primary">
                <span class="la la-undo"></span>
            </a>
        </div>
 <!-- Actions -->
      <div class="container flex items-center justify-center mb-2 px-4 py-3">
        <div class="border border-dashed p-4 flex flex-wrap gap-2 mt-5">  
            <div class="flex flex-wrap gap-2 px-5">
                <span class="badge badge_outlined badge_success">
                    <span class="la la-check-square text-xl leading-none ltr:mr-2 rtl:ml-2"></span>
                    <b>{{ $class->name }}</b>
                </span>
                <span class="badge badge_outlined badge_success">
                    <span class="la la-check-square text-xl leading-none ltr:mr-2 rtl:ml-2"></span>
                    <b>{{ $parcour->name }}</b>
                </span>
                <span class="badge badge_outlined badge_success">
                    <span class="la la-check-square text-xl leading-none ltr:mr-2 rtl:ml-2"></span>
                    <b>{{ $element->name }}</b>
                </span>
            </div>
                <div class="flex">
                    <a href="{{ URL::current() }}/absence/take" class="badge badge_primary font-bold" style="color:#F1F5F9"><span class="la la-eye text-xl"></span> Afficher étudiants</a>
                </div>
            </div> 
        </div>
    @if(count($absences) > 0)
    <h3 class="mb-3"><span class="la la-calendar-check"></span> Listes par dates</h3>
      <div class="flex flex-col gap-y-5 ">
            <div class="card relative p-5">
                <table class="table-sorter table table_bordered w-full mt-3">
                        <thead>
                            <tr>
                                <th class="ltr:text-left rtl:text-right">Heur</th>
                                <th class="ltr:text-left rtl:text-right">Date</th>
                                <th class="" style="text-align:center">Présents</th>
                                <th class="" style="text-align:center">Absents</th>
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
                            ->where('parcour_id', $absence->parcour_id)
                            ->where('dateStart', $absence->dateStart)
                            ->where('dateEnd', $absence->dateEnd)
                            ->where('timeStart', $absence->timeStart)
                            ->where('timeEnd', $absence->timeEnd)
                            ->where('status', 0)->get();
                            ?>
                            <tr>
                                <td class="font-bold">
                                    {{ \Carbon\Carbon::parse($absence->timeStart)->format('H:i')}} à 
                                    {{ \Carbon\Carbon::parse($absence->timeEnd)->format('H:i')}}
                                </td>

                                <td class="font-bold">{{ \Carbon\Carbon::parse($absence->dateStart)->format('d M')}} au {{ \Carbon\Carbon::parse($absence->dateEnd)->format('d M Y')}}</td>
                                
                                <td class="font-bold text-center"><span class="badge badge_success">{{count($present)}}</span></td>
                                <td class="font-bold text-center"><span class="badge badge_danger">{{count($absent)}}</span></td>

                                <td class="text-center">
                                <div class="inline-flex ltr:ml-auto rtl:mr-auto">
                                    <a href="{{URL::route('print', [$absence->class_id, $absence->parcour_id.'/'.rtrim(strtr(base64_encode($absence->element_id), '+/', '-_'), '=').'/'.rtrim(strtr(base64_encode($absence->dateStart), '+/', '-_'), '=').'/'.rtrim(strtr(base64_encode($absence->dateEnd), '+/', '-_'), '=')])}}" target="_blank" class="btn btn-icon btn_outlined btn_secondary">
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
                <span class="badge badge_success ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">{{ $class->short }}</span>
            </a>
            <a href="#" class="flex items-center text-normal">
                <span class="la la-check-circle text-2xl leading-none ltr:mr-2 rtl:ml-2"></span>
                Parcours
                <span class="badge badge_success ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">{{ $parcour->name }}</span>
            </a>
            <a href="#" class="flex items-center text-normal">
                <span class="la la-check-circle text-2xl leading-none ltr:mr-2 rtl:ml-2"></span>
                Matière
                <span class="badge badge_success ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">{{ $element->name }}</span>
            </a>
        </div>
    </aside>
@stop