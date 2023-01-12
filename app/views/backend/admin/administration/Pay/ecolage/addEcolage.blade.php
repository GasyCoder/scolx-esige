@extends('backend.main')
<?php 
$path = Session::get('language'); 
$control = Control::find(1); 
?>
@section('title') Ajouter paiement @stop
@section('content')
<main class="workspace workspace_with-sidebar">
        <!-- Breadcrumb -->
        <section class="breadcrumb lg:flex items-start">
            <a href="/admin/paiement/ecolage/{{$instance->student->class_id}}/{{$instance->student->parcour_id}}" class="btn btn-icon btn-icon_large btn_outlined btn_primary">
                <span class="la la-undo"></span>
            </a> 
           <div class="flex flex-wrap gap-2 items-center ltr:ml-auto rtl:mr-auto mt-5 lg:mt-0">
                <div class="flex gap-x-2">
                <div class="avatar w-16 h-16 ltr:mr-5 rtl:ml-5">
                <div class="status bg-success"></div>
                @if(!empty($instance->student->image))
                <?php echo HTML::image('uploads/profiles/students/'.$instance->student->image.'', '', ['class'=>'', 'width'=>'180','height'=>'80']) ?>
                @elseif($instance->student->sexe == 1)
                {{ HTML::image('public/assets/avatar/man.png', '', ['class'=>'', 'width'=>'','height'=>'']) }}
                 @else {{ HTML::image('public/assets/avatar/woman.png', '', ['class'=>'', 'width'=>'','height'=>'50']) }}
                @endif
                </div>
                <div>
                <h5>{{$instance->student->fname}} {{$instance->student->lname}}</h5>
                <p>Niveau : {{$instance->student->niveau->short}} | Parcours : {{$instance->student->parcour->abr}} <br> Année Universitaire : {{$year->yearsUniv}}</p>
                </div>
                </div>
            </div>            
        </section>
        <hr>
        <div class="mt-2 flex items-center justify-center py-3 px-4"> 
        <div class="p-5 flex flex-col gap-y-3 md:w-1/2 xl:w-1/4 w-full">    
        <div class="custom-select mt-0">
                  <select name="select_student_name" id="select_student_name" onchange="goToNext(this)" class="form-control">
                    <option value="" selected disabled>--Rechercher autres étudiants--</option>
                    @foreach($allstudents as $etudiant)
                        <option value="/admin/paiement/ajouter-paiment/{{$etudiant->id}}">{{ $etudiant->fname }} {{ $etudiant->lname }}</option>
                    @endforeach
                    </select>
                <div class="custom-select-icon la la-caret-down"></div>
        </div>
        </div>
        </div>
         <!-- Layout -->
<div class="container flex items-center justify-center mb-2 py-1">
@if($ecolages <= 0)
<div class="card p-5 flex flex-col gap-y-2 w-full md:w-1/2 xl:w-1/4">
@include('backend.admin.administration.Pay.return') 
{{ Form::open(['route'=>['payStore', $instance->id], 'files'=>'true', 'id'=>'myForm', 'class'=>'', 'data-toggle'=>'validator'])  }} 

                    <div class="flex flex-wrap flex-row -mx-4 collapse open">
                        <input type="hidden" name="id_etudiant"  value="{{$instance->id}}" class="form-control">
                        <input type="hidden" name="parcour_id"   value="{{$instance->student->parcour_id}}" class="form-control">
                        <input type="hidden" name="class_id"     value="{{$instance->student->class_id}}" class="form-control">
                        <input type="hidden" name="yearsUniv"     value="{{$year->yearsUniv}}" class="form-control">
                        <div class="mb-5 flex-shrink px-4 w-full">
                                <label class="label block mb-2" for="title">Motifs</label>
                                <div class="custom-select">
                                <select class="form-control" name="title" id="title" required>
                                    @if($instance->otherpayed == 0)
                                    <option value="Droit d'inscription + FG">Droit d'inscription + FG</option>
                                    @else
                                    <option value="Ecolage" selected>Ecolage</option>
                                    @endif
                                </select>
                                    <div class="custom-select-icon la la-caret-down"></div>
                                </div>
                        </div>
                        @if($instance->otherpayed != 0)
                        <div class="w-full border border-dashed mb-5" style="display:block; border-color:#65A30D;" id="Ecolage">
                         <div class="mb-5 flex-shrink px-4 w-full mt-4">
                        
                        {{ Form::number('nbreMois', '', ['id'=>'nbreMois', 'min'=>'1', 'max'=>$instance->mois_reste, 'class'=>'form-control']) }}
                        
                            @if($errors->first('nbreMois'))
                             <span class="help-block text-red-700">{{ $errors->first('nbreMois') }}</span>
                            @endif       
                        </div>
                        <div class="mb-5 flex-shrink px-4 w-full">
                            <label class="label block mb-2" for="title">Mois</label>
                            <div class="custom-select">
                                <select class="form-control" name="mois[]" id="mois" multiple>    
                                    <option value="Jan">Janvier</option>
                                    <option value="Fev">Février</option>
                                    <option value="Mar">Mars</option>
                                    <option value="Avr">Avril</option>
                                    <option value="Mai">Mai</option>
                                    <option value="Juin">Juin</option>
                                    <option value="Juil">Juillet</option>
                                    <option value="Août">Août</option>
                                    <option value="Sept">Septembre</option>
                                    <option value="Oct">Octobre</option>
                                </select>
                            </div>
                        </div>    
                        </div>
                        @endif
                        <div class="mb-5 flex-shrink px-4 w-full">
                        <label class="label block mb-2" for="montant">Montant à payer </label>
                        <?php $do = Ecolage::where('class_id', $instance->student->class_id)->orderBy('id', 'desc')->first(); ?>
                        @if($instance->otherpayed == 0)
                        {{ Form::text('montant', $do->droit, ['id'=>'montant', 'class'=>'form-control']) }}
                        @else
                        {{ Form::text('montant', '', ['id'=>'montant', 'class'=>'form-control']) }}
                        @endif
                        @if($errors->first('montant'))
                             <span class="help-block text-red-700">{{ $errors->first('montant') }}</span>
                        @endif 
                        @if($instance->otherpayed >= 1)
                        <h4 style="color:#BE185D;">Total montants écolage: <u><strong id="result">0</strong></u> {{$control->payment_unit}}</h4>
                        @endif
                        </div>
                        <div class="flex-shrink px-4 flex items-center">
                            <div class="w-1/2">
                                <label class="label block">Status</label>
                            </div>
                            <div class="w-3/4 ml-2">
                                <label class="label switch">
                                <input type="checkbox" name="status" id="status" value="1" required>
                                <span></span>
                                <span>Payer</span>
                                </label>
                            </div>
                        </div>
                    </div>                  
                    <div class="mt-0">
                     <div class="flex items-center">
                        <button type="submit" class="btn btn_primary ltr:ml-auto rtl:mr-0"><span class="la la-user-plus"></span> Accepter le paiement</button>
                    </div> 
                </div>                         
{{ Form::close() }}
</div>
@else
        <div class="card p-5 flex flex-col gap-y-2 w-full md:w-1/2 xl:w-1/4">
            <div class="mx-2 md:mx-3">
                <h3 class="" style="color:#16A34A"> <span class="la la-thumbs-up"></span>Bravo!</h3>
            </div>
            <hr class="border-dashed">
                <div class="modal-body text-xl">
                    Cet étudiant a été reglé son écolage à 100% sur cette année d'étude!
                </div>
                @if(Auth::user()->is_admin) @if(!Auth::user()->is_secretaire)
                <div class="modal-footer">
                    <div class="flex ltr:ml-auto rtl:mr-auto">
                        <a href="{{ URL::route('cartePay', [$instance->id,$instance->student->class_id,$instance->student->parcour_id]) }}" class="btn btn_success ltr:ml-2 rtl:mr-2">Voir tous les transactions</a>
                    </div>
                </div>
                @endif @endif   
        </div>
@endif
</div>
</div>
 @include('backend.pages.footer')     
 @section('js')

<?php $carts = Ecolage::where('class_id', $instance->student->class_id)
                        ->orderBy('id', 'desc')
                        ->first();
?>

<script type="text/javascript">
@if($instance->otherpayed >= 1)
const $inputs = $('input[type="number"]')
$inputs.change(function() {
  var total = 0;
  $inputs.each(function() {
    if ($(this).val() != '') {
      total += parseInt($(this).val());
    }
  });
  $('#result').html(total*{{$carts->priceU}});
});
@endif
 document.getElementById('title').addEventListener("change", function (e) 
 {
      if (e.target.value === 'Ecolage') {
            document.getElementById('Ecolage').style.display = 'block';
        } 
      else {
          document.getElementById('Ecolage').style.display = 'none';
        }
  });
</script>

<script type="text/javascript">
 $('#mois').select2();
</script>

<script type="text/javascript">
 var urlmenu = document.getElementById( 'select_student_name' );
 urlmenu.onchange = function() {
      window.open( this.options[ this.selectedIndex ].value, '_self');
 };
</script>

<script type="text/javascript">
 $('#select_student_name').select2();
</script>

@endsection    
</main>   
@include('backend.admin.administration.Pay.ecolage.side')
@stop
