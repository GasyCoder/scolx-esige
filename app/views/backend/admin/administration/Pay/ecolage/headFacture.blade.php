          <div id="btn-invoice" class="flex flex-wrap flex-row -mx-6 justify-center">
              <button type="button" id="btn-invoice" onclick="window.print();" class="py-2 px-4 inline-block text-center mb-3 rounded leading-5 text-gray-100 bg-indigo-500 border border-indigo-500 hover:text-white hover:bg-indigo-600 hover:ring-0 hover:border-indigo-600 focus:bg-indigo-600 focus:border-indigo-600 focus:outline-none focus:ring-0"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="mr-2 inline-block bi bi-printer" viewbox="0 0 16 16">
                <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"></path>
                <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z"></path>
              </svg>Imprimer</button>
            </div>
             <div class="flex-shrink max-w-full px-4 w-full mb-6">
              <div class="p-5 bg-white">
                <div class="flex justify-between items-center pb-4 border-b border-gray-200 dark:border-gray-700 mb-3">
                  <div class="flex flex-col">
                    <img src="{{url()}}/public/assets/images/tete.png" class="img">
                  </div>
                </div>
                <div class="flex flex-row justify-between py-3" style="font-size:0.8rem">
                  <div class="flex-1">
                    <p><strong class="text-lg"><u>Doit</u>:</strong><br>
                    <strong>@if($allFacture->etudiant->sexe == 1)Mr: @else Mlle/Mme:@endif</strong> {{$allFacture->etudiant->fname}} {{$allFacture->etudiant->lname}}<br>
                    <strong>Niveau:</strong> {{$allFacture->niveau->short}} @if($allFacture->etudiant->grade == 'AL')Auditeur Libre @endif<br>
                    <strong>Parcours:</strong> {{$allFacture->parcour->abr}}<br></p>
                  </div>
                  <div class="flex-1" style="font-size:0.8rem">
                    <div class="flex justify-between mb-0">
                      <div class="flex-1 font-semibold">Facture N°:</div>
                      <div class="flex-1 text-right font-bold">#{{$allFacture->payment_index}}</div>
                    </div>
                    <div class="flex justify-between mb-0">
                      <div class="flex-1 font-semibold">Date:</div><div class="flex-1 text-right">{{ \Carbon\Carbon::parse($allFacture->created_at)->format('d/m/y')}}</div>
                    </div>
                    <div class="flex justify-between mb-0">
                      <div class="flex-1 font-semibold">Status:</div><div class="flex-1 text-right">@if($allFacture->status = 1)<span class="inline-block leading-none text-center py-1 px-2 bg-green-700 text-gray-100 font-bold rounded pay" style="font-size: .75em;">Payé en espèce</span> @endif</div>
                    </div>
                  </div>
                </div>
                 <div class="py-4">
                  <table class="table-bordered w-full text-left text-gray-600">
                    <thead class="border-b dark:border-gray-700">
                      <tr class="bg-gray-100 dark:bg-gray-900 dark:bg-opacity-20">
                        <th>Motifs</th>
                        @if($allFacture->nbreMois >= 1)
                        <th class="text-center">Mois</th>
                        @else<th></th>@endif
                        <th class="text-center">Prix U</th>
                        <th class="text-center">Somme</th>
                      </tr>
                    </thead>