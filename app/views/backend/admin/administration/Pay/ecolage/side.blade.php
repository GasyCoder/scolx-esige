  <!-- Sidebar -->
    <aside class="sidebar">
        <!-- Toggler - Mobile -->
        <button class="sidebar-toggler la la-ellipsis-v" data-toggle="sidebar"></button>
        <h3 class="p-5">Informations</h3>
            <hr class="border-dashed">
            <div class="p-5 leading-normal">
            <h4 class="p-2"><u>Ecolage/Droit</u></h4>    
            <a href="" class="flex items-center text-normal mt-2">
                <span class="la la-check-circle text-2xl leading-none ltr:mr-2 rtl:ml-2"></span>
                 Ecolage+Droit
                <span class="badge badge_outlined badge_success ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">
                <?php $ecolage_value = Ecolage::where('class_id', $instance->student->class_id)->orderBy('id', 'desc')->get(); ?> 
                    @foreach($ecolage_value as $to)                
                     {{$to->total. '' .$control->payment_unit }}
                    @endforeach
                </span>
            </a>
            <a href="" class="flex items-center text-normal mt-2"> 
              <span class="la la-check-circle text-2xl leading-none ltr:mr-2 rtl:ml-2"></span>
                 Droit d'inscription
                <span class="badge badge_outlined badge_warning ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto" style="color:#333">
                    {{$to->droit. '' .$control->payment_unit }}
                </span>
             </a>
             <a href="" class="flex items-center text-normal mt-2"> 
              <span class="la la-check-circle text-2xl leading-none ltr:mr-2 rtl:ml-2"></span>
                 Ecolage par mois
                <span class="badge badge_outlined badge_primary ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">
                    {{$to->priceU. '' .$control->payment_unit }}
                </span>
             </a>
            <hr class="border-dashed mt-5"> 
            <a href="" class="flex items-center text-normal mt-5">
                <span class="la la-check-circle text-2xl leading-none ltr:mr-2 rtl:ml-2"></span>
                  Somme à Payé
                <span class="badge badge_outlined badge_danger ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto font-bold">
                <?php $droitSum = Pay::where('id_etudiant',       $instance->id)
                                        ->where('class_id',       $instance->student->class_id)
                                        ->where('parcour_id',     $instance->student->parcour_id)
                                        ->sum('montant');
                ?>
                @if(count($instance->payed) <= 0)
                    -0Ar
                @else
                    -{{$droitSum. '' .$control->payment_unit }}
                @endif
                </span>
            </a>
            <a href="" class="flex items-center text-normal mt-2">
                <span class="la la-check-circle text-2xl leading-none ltr:mr-2 rtl:ml-2"></span>
                  Reste à payer
                <span class="badge badge_outlined badge_success ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto font-bold">
                @if(count($instance->payed) <= 0)
                    {{$to->total. '' .$control->payment_unit }}
                @else
                    +{{$to->total-($droitSum). '' .$control->payment_unit }}
                @endif
                </span>
             </a>
            <?php 
                /*$poly = Pay::where('nbreMois', 0)
                                ->where('id_etudiant', $etudiant->id)
                                ->where('mois', NULL)
                                ->where('yearsUniv', $year->yearsUniv)
                                ->first();*/
            ?>
            @if($instance->otherpayed <= 0)
            <hr class="border-dashed mt-5">
            <div class="alert alert_danger mt-5">
                    <strong class="uppercase"><bdi>Alert!</bdi></strong>
                    Cet étudiant n'est pas encore payer le Droit d'inscription + FG.
                </div>
            @else
             <hr class="border-dashed mt-5">
             <a href="{{ URL::route('cartePay', [$instance->id, $instance->student->class_id,$instance->student->parcour_id]) }}" target="_blank" class="flex items-center text-normal mt-5">
                <span class="la la-check-square text-2xl leading-none ltr:mr-2 rtl:ml-2" style="color:#1D4ED8"></span>
                <span style="color:#D97706;text-decoration:;">Droit d'Inscription</D></span>
                <span class="badge badge_success ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">Payé</span>
             </a>
            @endif
        </div>
        <?php 
            $mois = DB::table('payments')
                        ->where('mois', '>=', 1)
                        ->where('id_etudiant', '=', $instance->id)
                        ->get();
        ?>

        @if(count($mois)>=1)
        <div class="p-5 leading-normal">
        <h3 class="p-2 mt-3"><u>Mois payé</u></h3>
         @foreach($mois as $month)
            <a href="" class="flex items-center text-normal mt-2">
                <span class="la la-calendar text-2xl leading-none ltr:mr-2 rtl:ml-2"></span>
                 {{$month->mois}}
                <span class="badge badge_success ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">
                    payé
                </span>
            </a>
        @endforeach
         </div>    
        @endif
        <hr class="border-dashed">    
        <div class="mt-auto">
            <hr>
            <div class="flex p-5">
                <?php $ecolax = Instance::where('id', $instance->id)->first(); ?>
                @if($ecolax->payed >= 1)
                <a href="{{ URL::route('cartePay', [$instance->id,$instance->student->class_id,$instance->student->parcour_id]) }}" class="btn btn_success"><span class="la la-money-check text-xl ltr:mr-0 rtl:ml-0"></span> Detail des paiment</a>
                @endif
            </div>
        </div>
    </aside>
