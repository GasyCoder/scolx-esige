@extends('backend.main')
<?php $path = Session::get('language'); $control = Control::find(1);?>
@section('title') Gestion d'absence @stop
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
        <div class="card p-4 flex flex-wrap gap-2 mt-5">  
 			<a href="#" class="btn btn-icon btn-icon_large btn_outlined btn_primary">
        		<span class="la la-undo"></span>
    		</a>
            <div class="flex flex-wrap gap-2 ltr:ml-auto rtl:mr-auto">
                <button class="btn btn_primary">
                    <span class="la la-check-square text-xl leading-none ltr:mr-2 rtl:ml-2"></span>
                    {{ $class->name }}
                </button>
                 <button class="btn btn_warning">
                    <span class="la la-check-square text-xl leading-none ltr:mr-2 rtl:ml-2"></span>
                    {{ $parcour->name }}
                </button>
                 <button class="btn btn_info">
                    <span class="la la-check-square text-xl leading-none ltr:mr-2 rtl:ml-2"></span>
                    {{ $element->name }}
                </button>
            </div>
        </div>
        <div class="mt-5">
            <div class="lg:col-span-2 xl:col-span-3">

{{ Form::open(['route'=>['updateabsence', $class->id, $parcour->id, $element->id], 'novalidate'])  }} 

                <div class=" flex flex-wrap flex-row -mx-4 mb-5">
                  <div class="mt-3 flex-shrink px-4 w-full xl:w-1/2">
                    <label class="label block mb-2" for="fname">Date début *</label>
                    <input type="date" name="dateStart" value="{{$missing->dateStart}}" class="form-control">
                      @if($errors->first('dateStart'))
                      <span class="help-block text-red-700">{{ $errors->first('dateStart') }}</span>
                      @endif
                   </div>
                   <div class="mt-3 flex-shrink px-4 w-full xl:w-1/2">
                    <label class="label block mb-2" for="fname">Date Fin *</label>
                      <input type="date" name="dateEnd" class="form-control">
                      @if($errors->first('dateEnd'))
                      <span class="help-block text-red-700">{{ $errors->first('dateEnd') }}</span>
                      @endif
                   </div>
                </div>

                <div class="grid sm:grid-cols-2 xl:grid-cols-3 gap-5">
                @foreach($absences as $key => $missing)  
                    <div class="card card_hoverable card_list">
                        <div class=" avatar w-20 h-20">
                            <img src="{{ url() }}/public/uploads/logo/{{$control->logo}}">
                        </div>
                        <div class="body">
                            <h6>{{$missing->student->fname}} {{$missing->student->lname}}</h6>
                            <code>{{$missing->student->matricule}}</code>
                            <b>{{$missing->niveau->short}}</b>
                        </div>
                        <div class="actions">
                        <label class="" for="s{{ $key+1 }}">
                        	@if($missing->absent == 1)
                                <input type="checkbox" class="c6" checked>
                            @else
                            <input type="checkbox" class="c6" id="s{{ $key+1 }}" name="matricule[]" value="{{ $missing->id }}">
                            @endif
                                <span>@if($missing->student->sexe == 1)Absent @else Absente @endif</span>
                         </label>
                        </div>
                    </div>
                @endforeach            
                </div>
        @if(count($absences) > 0)
            <div class="mt-auto">
                <hr class="my-4 border-dashed">
                <div class="flex p-5">
                    <button class="btn btn_primary uppercase ltr:ml-auto rtl:mr-auto"><span class="la la-plus-square text-xl"></span> Mettre à jour</button>
                </div>
            </div>
        @endif    
{{ Form::close() }}
            </div>
        </div>
@include('backend.pages.footer')
</main>
    <!-- Sidebar -->
    <aside class="sidebar">
        <!-- Toggler - Mobile -->
        <button class="sidebar-toggler la la-ellipsis-v" data-toggle="sidebar"></button>
        <!-- Tags -->
        <h2 class="p-5">Objets selected</h2>
        <hr>
        <div class="flex flex-col gap-y-5 p-5">
           
            <a href="#" class="flex items-center text-normal">
                <span class="la la-check-circle text-2xl leading-none ltr:mr-2 rtl:ml-2"></span>
                Parcour
                <span class="badge badge_outlined badge_success ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">{{ $parcour->abr }}</span>
            </a>
            <a href="#" class="flex items-center text-normal">
                <span class="la la-check-circle text-2xl leading-none ltr:mr-2 rtl:ml-2"></span>
                EC
                <span class="badge badge_outlined badge_success ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">{{ $element->abr }}</span>
            </a>
        </div>
<?php $absences = Absence::where('class_id', $class->id)->where('parcour_id', $parcour->id)->where('element_id', $element->id)->where('status', 1)->groupBy('dateStart')->get(); ?>
@if(count($absences) > 0)        
         <!-- Sidebar Footer -->
        <div class="mt-auto">
            <hr>
            <div class="flex p-5">   
                <a href="{{URL::route('all_absence', ['class'=>$class->id, 'parcour'=>$parcour->id, 'element'=>$element->id])}}" class="btn btn_success"><span class="la la-eye text-xl"></span> Voir les listes</a>
            </div>
        </div>
@endif      
    </aside>
@stop