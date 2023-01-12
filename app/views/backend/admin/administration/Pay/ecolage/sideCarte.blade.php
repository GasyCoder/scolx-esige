 <!-- Sidebar -->
    <aside class="sidebar">
        <!-- Toggler - Mobile -->
        <button class="sidebar-toggler la la-ellipsis-v" data-toggle="sidebar"></button>
        <h3 class="p-5">Informations</h3>
            <hr>
            <div class="p-5 leading-normal">
            <a href="" class="flex items-center text-normal">
                <span class="la la-check-circle text-2xl leading-none ltr:mr-2 rtl:ml-2"></span>
                  Ecolage+Droit
                <span class="badge badge_outlined badge_success ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">            
                     {{$sumEcolage. '' .$control->payment_unit }}
                </span>
            </a>
            <a href="" class="flex items-center text-normal mt-2"> 
              <span class="la la-check-circle text-2xl leading-none ltr:mr-2 rtl:ml-2"></span>
                 Droit d'inscription
                <span class="badge badge_outlined badge_warning ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto" style="color:#333">
                    {{$droitSum. '' .$control->payment_unit }}
                </span>
             </a>
             <a href="" class="flex items-center text-normal mt-2"> 
              <span class="la la-check-circle text-2xl leading-none ltr:mr-2 rtl:ml-2"></span>
                  Ecolage par mois
                <span class="badge badge_outlined badge_primary ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">
                    {{$pricU. '' .$control->payment_unit }}
                </span>
             </a>
            <hr class="border-dashed mt-5"> 
             <a href="" class="flex items-center text-normal">
                <span class="la la-plus-circle text-2xl leading-none ltr:mr-2 rtl:ml-2" style="color:blue;"></span>
                  Reste à payer
                <span class="badge badge_danger ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">
                    +{{$restePay. '' .$control->payment_unit }}
                </span>
            </a>
            <a href="" class="flex items-center text-normal mt-2">
                <span class="la la-times-circle text-2xl leading-none ltr:mr-2 rtl:ml-2" style="color:#059669;"></span>
                  Total à Payé
                <span class="badge badge_success ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">
                    -{{$varPay. '' .$control->payment_unit }}
                </span>
            </a>
        </div>
            <hr class="">
            <div class="p-5 leading-normal"> 
            <a href="" class="flex items-center text-normal">
                <span class="la la-plus-circle text-2xl leading-none ltr:mr-2 rtl:ml-2" style="color:green;"></span>
                Mois déjà payé
                <span class="badge badge_success ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">
                    {{$TotalMois}} mois</span>
            </a>
            <a href="" class="flex items-center text-normal mt-2">
                <span class="la la-times-circle text-2xl leading-none ltr:mr-2 rtl:ml-2" style="color:red;"></span>
                Mois restant non payer
                <span class="badge badge_danger ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">
                    {{$sisaMois}} mois</span>
            </a>   
            </div>
        </div>
        <!-- Sidebar Footer -->
        <div class="mt-auto">
            <hr>
            <div class="flex p-5">
       
                <a href="{{ URL::route('all_invoice', [$instance->id,$class->id,$parcour->id]) }}" target="_blank" class="btn btn_primary"><span class="la la-print text-xl leading-none"></span> Tous les reçus</a>
           
                <a href="/admin/etudiants/{{ $instance->student->class_id }}/{{ $instance->student->parcour_id }}/{{rtrim(strtr(base64_encode($instance->id), '+/', '-_'), '=')}}" target="_blank" class="btn btn_success ltr:ml-auto rtl:mr-auto"><span class="la la-user-graduate text-xl leading-none"></span> Profil</a>
            </div>
        </div>       
    </aside>