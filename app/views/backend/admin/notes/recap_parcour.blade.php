@extends('backend.main')
<?php $path = Session::get('language'); ?>
@section('title') Récapitulatif - parcours @stop
@section('content')
<!-- Workspace -->
    <main class="workspace workspace_with-sidebar">
         <!-- Layout -->
        <div class="flex gap-x-2 mb-0">
            <a href="{{URL::route('absence')}}" class="btn btn-icon btn-icon_large btn_outlined btn_primary">
                <span class="la la-undo"></span>
            </a>
        </div>        
<div class="container flex items-center justify-center py-10">
        <div class="w-full md:w-1/2 xl:w-1/3">
            <h3><span class="la la-check-square text-xl leading-none"></span>Choisir parcour</h3>
            <div class="breadcrumb breadcrumb_alt mt-2 p-5 md:p-10" action="#">
                <div class="custom-select mt-2">
                      <select name="select_parcour_name" id="select_parcour_name" onchange="goToNext(this)" class="form-control">
                            <option value="" selected disabled>-- Choisir parcours --</option>
                              @foreach($parcours as $parcour)
                                    <option value="{{ $parcour->id}}">{{ $parcour->name }}</option>
                              @endforeach
                        </select>
                    <div class="custom-select-icon la la-caret-down"></div>
                </div>
            </div>
        </div>
</div>
@include('backend.pages.footer')


@section('js')
<script type="text/javascript">
function goToNext(c) {
  if(c.value != '') {
    window.location = '{{ URL::current() }}/'+c.value;
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
            <a href="#" class="flex items-center text-normal">
                <span class="la la-check-circle text-2xl leading-none ltr:mr-2 rtl:ml-2"></span>
                Niveau
                <span class="badge badge_success ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">{{ $class->short }}</span>
            </a>
        </div>
                 <!-- Toggler - Mobile -->
        <button class="sidebar-toggler la la-ellipsis-v" data-toggle="sidebar"></button>
        <!-- Status -->
        <h3 class="p-5">Tronc communs</h3>
        <hr>
        <div class="flex flex-col gap-y-5 p-5">
        <div class="flex gap-2 p-2">   
        <a href="{{URL::route('openTronc', $class->id)}}" class="badge badge_info badge_success font-bold uppercase"><span class="la la-plus-square text-2xl leading-none ltr:mr-2 rtl:ml-2"></span> Ajouter absence tronc communs</a>
        </div>
        </div>
    </aside>
@stop