@extends('backend.main')
<?php $path = Session::get('language'); ?>
@section('title') Modifier paiement {{$editPay->fname}}- {{$editPay->payment_index}}@stop
@section('content')
<main class="workspace workspace_with-sidebar">
        <!-- Breadcrumb -->
        <section class="breadcrumb lg:flex items-start">
            <div>
@include('backend.break')
            </div>
        </section>
         <!-- Layout -->
        <div class="flex gap-x-2 mb-5">
            <a href="{{URL::route('indexPay')}}" class="btn btn-icon btn-icon_large btn_outlined btn_primary">
                <span class="la la-undo"></span>
            </a>
        </div>  
@include('backend.admin.administration.Pay.return')
<div class="card p-5">  
<div class="tabs wizard wizard-style-2">
{{ Form::open(['route'=>['payUpdate', $editPay->id], 'files'=>'true', 'id'=>'myForm', 'class'=>'', 'data-toggle'=>'validator'])  }} 
                    <div class="flex flex-wrap flex-row -mx-4 collapse open">
                        <div class="mb-5 flex-shrink px-4 w-full">
                                <label class="label block mb-2" for="title">Titre de paiment</label>
                                <div class="custom-select">
                                <select class="form-control" name="title" id="title" required>
                                    @if(!empty($editPay->title !== NULL))
                                    <option value="{{$editPay->title}}" selected>{{$editPay->title}}</option>
                                    @else
                                    <option disabled>Select</option>
                                    @endif
                                    <option value="Droit d'inscription + FG">Droit d'inscription + FG</option>
                                    <optgroup label="Trances">
                                    <option value="Ecolage 1er trance">Ecolage 1er trance</option>
                                    <option value="Ecolage 2e trance">Ecolage 2e trance</option>
                                    <option value="Ecolage 3e trance">Ecolage 3e trance</option>
                                    </optgroup>
                                    <option value="Droit d'éxamen">Droit d'éxamen</option>
                                    <option value="Polycopes">Polycopes</option>
                                    <option value="Autres">Autres</option>
                                </select>
                                    <div class="custom-select-icon la la-caret-down"></div>
                                </div>
                        </div>
                        <div class="mb-5 flex-shrink px-4 w-full">
                                <label class="label block mb-2" for="nbreMois">Nombre de mois ( <small style="color:#991B1B">Max {{ $editPay->nbreMois }}</small> )</label>
                                {{ Form::number('nbreMois', $editPay->nbreMois, ['id'=>'nbreMois', 'class'=>'form-control']) }}
                            @if($errors->first('nbreMois'))
                             <span class="help-block text-red-700">{{ $errors->first('nbreMois') }}</span>
                            @endif       
                        </div>
                        <div class="mb-5 flex-shrink px-4 w-full">
                            <label class="label block mb-2" for="title">Mois</label>
                            <div class="custom-select">
                                <select class="form-control custom-select cursor-pointer focus:outline-none" name="mois[]" id="field1" multiple onchange="console.log(Array.from(this.selectedOptions).map(x=>x.value??x.text))" multiselect-hide-x="true" autocomplete="off">    
                                       @if(!empty($editPay->mois))
                                        <option value="{{ $editPay->mois }}" selected="selected" style="color:#059669" class="font-bold">{{ $editPay->mois }}</option>
                                        @else
                                        <option value="" disabled>Choisir</option>
                                        @endif
                                        <optgroup label="1er trances">
                                        <option value="Jan">Janvier</option>
                                        <option value="Fev">Février</option>
                                        <option value="Mar">Mars</option>
                                        </optgroup>
                                        <optgroup label="2e trances">
                                        <option value="Avr">Avril</option>
                                        <option value="Mai">Mai</option>
                                        <option value="Jui">Juin</option>
                                        </optgroup>
                                        <optgroup label="3e trances">
                                        <option value="Juil">Juillet</option>
                                        <option value="Aout">Août</option>
                                        <option value="Setp">Septembre</option>
                                        <option value="Oct">Octobre</option>
                                        </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="mb-5 flex-shrink px-4 w-full">
                                <label class="label block mb-2" for="montant">Montant du paiement </label>
                                {{ Form::text('montant', $editPay->montant, ['id'=>'montant', 'class'=>'form-control']) }}
                            @if($errors->first('montant'))
                             <span class="help-block text-red-700">{{ $errors->first('montant') }}</span>
                            @endif 
                        </div>
                        <div class="flex-shrink px-4 flex items-center">
                        <div class="w-1/2">
                            <label class="label block">Status</label>
                        </div>
                        <div class="w-3/4 ml-2">
                            <label class="label switch">
                            @if($editPay->status == 1)    
                            <input type="checkbox" name="status" id="status" checked value="1">
                            <span></span>
                            <span>Payer</span>
                            @else
                            <input type="checkbox" name="status" value="0">
                            <span></span>
                            <span style="color:#B91C1C">Activer</span>
                            @endif
                            </label>
                        </div>
                        </div>
                    </div>                  
                    <div class="mt-0">
                     <div class="flex items-center">
                        <button type="submit" class="btn btn_primary ltr:ml-auto rtl:mr-0"><span class="la la-user-plus"></span> Mettre à jour</button>
                    </div> 
                </div>                         
            </div> 
{{ Form::close() }}
</div>

 @include('backend.pages.footer')       
</main>   
  <!-- Sidebar -->
    <aside class="sidebar">
        <!-- Toggler - Mobile -->
        <button class="sidebar-toggler la la-ellipsis-v" data-toggle="sidebar"></button>
        <h3 class="p-5">Informations</h3>
            <hr>
            <div class="p-5 leading-normal">
                <a href="#" class="flex items-center text-normal font-bold">
                    <span class="la la-user-graduate text-muted text-2xl ltr:mr-2 rtl:ml-2"></span>
                    {{$editPay->fname}} {{$editPay->lname}}
                </a>
                <a href="#" class="flex items-center text-normal font-bold">
                    <span class="la la-check-circle text-muted text-2xl ltr:mr-2 rtl:ml-2"></span>
                    Classe: 
                    <span class="badge badge_outlined badge_success ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">
                        {{$editPay->niveau->short}}
                    </span>
                </a>

                <a href="#" class="flex items-center text-normal font-bold">
                    <span class="la la-check-circle text-muted text-2xl ltr:mr-2 rtl:ml-2"></span>
                    Parcour:
                    <span class="badge badge_outlined badge_primary ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">
                        {{$editPay->parcour->abr}}
                    </span>
                </a>
            </div>
        <!-- Sidebar Footer 
        <div class="mt-auto">
            <hr>
            <div class="flex p-5">
                <button type="button" class="btn btn_success ltr:ml-auto rtl:mr-auto"><span class="la la-print text-xl ltr:mr-2 rtl:ml-2"></span> Facture</button>
            </div>
        </div>-->
    </aside>

@stop
