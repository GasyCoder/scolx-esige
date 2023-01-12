<!-- Recent Posts -->
            <div class="card p-5 flex flex-col">
                <h3>Paiement récente</h3>
                <table class="table table_list mt-3 w-full">
                    <thead>
                        <tr>
                            <th class="ltr:text-left rtl:text-right">Etudiants</th>
                            <th class="">Niveau</th>
                            <th class="">Parcours</th>
                            <th class="">Mois</th>
                            <th class="">Montant</th>
                            <th class="">Status</th>
                            <th class="">Temps</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payement_r as $ecolage)
                        <tr>
                            <td><span class="la la-user-graduate text-xl"></span> {{$ecolage->etudiant->fname}} {{$ecolage->etudiant->lname}}</td>
                            <td class="text-center">{{$ecolage->niveau->short}}</td>
                            <td class="text-center">{{$ecolage->parcour->abr}}</td>
                            <td class="text-center">{{$ecolage->nbreMois}}</td>
                            <td class="text-center">{{$ecolage->montant.''.$control->payment_unit}}</td>
                            <td class="text-center">
                                <div class="badge badge_success">Payé</div>
                            <td class="text-center">{{timeAgo($ecolage->created_at)}}</td>    
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-auto">
                    <a href="/admin/paiement/ecolage" class="btn btn_primary mt-5">En savoir</a>
                </div> 
            </div>
            