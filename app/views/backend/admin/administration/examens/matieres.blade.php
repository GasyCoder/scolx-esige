@extends('backend.main')
<?php $path = Session::get('language'); ?>
@section('title') Gestion d'examens @stop
@section('content')
    <main class="workspace">
        <!-- Breadcrumb -->
        <section class="breadcrumb lg:flex items-start">
            <div>
@include('backend.break')
            </div>
        </section>

         <!-- Layout -->
        <div class="flex gap-x-2 mb-5">
            <a href="/admin/absences/etudiants/{{$class->id}}" class="btn btn-icon btn-icon_large btn_outlined btn_primary">
                <span class="la la-undo"></span>
            </a>
        </div>
        <div class="card p-5">
            <div class="overflow-x-auto">
                <div class="mb-5">
                            <label class="label block mb-2" for="semestre">Choisir semestre</label>
                            <div class="custom-select semestre">
                                <select class="form-control" name="semestre">
                                    <option value="1">Semestre 1</option>
                                    <option value="2">Semestre 2</option>
                                </select>
                            </div>
                </div>
                <div class="mb-5">
                            <label class="label block mb-2" for="teacher">Filtrer matière</label>
                            <div class="custom-select teacher">
                                <select class="form-control" name="element_id" id="matiere">
                                   @foreach($elements as $key=> $element)
                                     <option value="{{ $element->id }}">{{ $element->name }}</option>
                                   @endforeach
                                </select>
                                <div class="custom-select-icon la la-caret-down"></div>
                            </div>
                </div>
            </div>
        </div>
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
                Classe
                <span class="badge badge_primary ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">{{ $class->short }}</span>
            </a>
            <a href="#" class="flex items-center text-normal">
                <span class="la la-check-circle text-2xl leading-none ltr:mr-2 rtl:ml-2"></span>
                Parcour
                <span class="badge badge_primary ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">{{ $parcour->abr }}</span>
            </a>
        </div>
    </aside>
@stop
@section('js')
<script type="text/javascript">
 $('#matiere').select2();
</script>
@endsection 