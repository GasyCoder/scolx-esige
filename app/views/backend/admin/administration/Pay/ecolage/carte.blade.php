@extends('backend.main')
<?php $path = Session::get('language'); 
$control = Control::find(1); 
?>
@include('backend.timeAgo')
@section('title') Carte écolage - {{$instance->student->fname.' '.$instance->student->lname}} @stop
@section('content')
    <!-- Workspace -->
    <main class="workspace workspace_with-sidebar">
        <!-- Breadcrumb -->
        <section class="breadcrumb lg:flex items-start">
            <div>
            @include('backend.break')
            </div>
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
                <p>Niveau: {{$instance->student->niveau->short}} | Parcours: {{$instance->student->parcour->abr}}</p>
                </div>
                </div>
            </div>            
        </section>
         <!-- Layout -->
        <div class="flex gap-x-2 mb-5">
            <a href="/admin/paiement?voir={{$instance->student->class_id}}" class="btn btn-icon btn-icon_large btn_outlined btn_primary">
                <span class="la la-undo"></span>
            </a>
        </div>        
            @include('backend.admin.administration.Pay.return')
                <div class="card p-5">
                    <span class="text-xl"><span class="la la-history"></span> Historique de paiement</span>
                    <table class="table table_bordered w-full mt-3">
                        <thead>
                            <tr>
                                <th class="ltr:text-left rtl:text-right">N° Ordre</th>
                                <th class="ltr:text-left rtl:text-right">Motifs</th>
                                <th class="text-center" style="text-align:center;">Montant</th>
                                <th class="text-center" style="text-align:center;">Status</th>
                                <th class="text-center" style="text-align:left;">Reçu de l'argent</th>
                                <th class="text-center" style="text-align:left;">Date et heur</th>
                                <th class="text-center" style="text-align:center;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                         @foreach($cartes as $key=> $carte) 
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                <div class="font-bold"> 
                                   @if($carte->title == 'Ecolage'){{$carte->title}} pour {{$carte->nbreMois}} mois @else {{$carte->title}} 
                                   @endif
                                </div>
                                </td>
                                <td class="text-center font-bold">{{$carte->montant. '' .$control->payment_unit }}</td>
                                <td class="text-center" style="text-align:center;">
                                @if($carte->status == 1) 
                                <div class="badge badge_success">Payé</div>
                                @endif
                                </td>
                                <td>
                                   <span class="la la-user"></span> {{$carte->user->fname}}
                                </td>
                                <td>
                                    {{ $carte->created_at->format('d M Y à H:i:s') }}
                                </td>
                                <td class="text-center" style="text-align:center;">
                                <div class="inline-flex ltr:ml-auto rtl:mr-auto">
                                   <a href="{{ URL::route('pay_invoice', [$carte->id,$class->id,$parcour->id, $carte->payment_index]) }}" target="_blank" class="btn btn-icon btn_primary ltr:ml-2 rtl:mr-2">
                                        <span class="la la-print text-2xl"></span>
                                    </a> 
                                    <a href="{{ URL::route('editPay', [$carte->id,$carte->payment_index,$carte->class_id,$carte->parcour_id]) }}" class="btn btn-icon btn_outlined btn_success ltr:ml-2 rtl:mr-2">
                                        <span class="la la-pen-fancy"></span>
                                    </a>
                                    @if(Auth::user()->is_admin) 
                                    @if(!Auth::user()->is_secretaire)     
                                        <a onclick="return confirm('Desactiver paiement!')" href="{{ URL::route('deletePay', $instance->id) }}" class="btn btn-icon btn_outlined btn_danger ltr:ml-2 rtl:mr-2">
                                            <span class="la la-ban"></span>
                                        </a>
                                    @endif 
                                    @endif
                                </div>
                                </td>
                            </tr>
                         @endforeach
                        </tbody>
                    </table>
                </div>
@include('backend.pages.footer')
</main>
 @include('backend.admin.administration.Pay.ecolage.sideCarte')
@stop