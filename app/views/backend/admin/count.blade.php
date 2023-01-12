            <!-- Summaries -->
            <div id="sortable-style-3" class="sortable grid sm:grid-cols-4 gap-2" style="cursor: grab;">
                <div class="card px-0 py-2 flex justify-center items-center text-center lg:transform hover:scale-110 hover:shadow-lg transition-transform duration-200">
                    <div>
                        <span class="text-primary text-5xl leading-none la la-users"></span>
                        <p class="mt-2">Etudiants</p>
                        <div class="text-primary mt-5 text-3xl leading-none">{{$etudiants}}</div>
                    </div>
                </div>
                 <div class="card px-0 py-2 flex justify-center items-center text-center lg:transform hover:scale-110 hover:shadow-lg transition-transform duration-200">
                    <div>
                        <span class="text-primary text-5xl leading-none la la-flag-usa"></span>
                        <p class="mt-2">Etudiants étrangèrs</p>
                        <div class="text-primary mt-5 text-3xl leading-none">{{$trangers}}</div>
                    </div>
                </div>
                 <div class="card px-0 py-2 flex justify-center items-center text-center lg:transform hover:scale-110 hover:shadow-lg transition-transform duration-200">
                    <div>
                        <span class="text-primary text-5xl leading-none la la-female"></span>
                        <p class="mt-2">Etudiantes feminine</p>
                        <div class="text-primary mt-5 text-3xl leading-none">{{$female}}</div>
                    </div>
                </div>
                 <div class="card px-0 py-2 flex justify-center items-center text-center lg:transform hover:scale-110 hover:shadow-lg transition-transform duration-200">
                    <div>
                        <span class="text-primary text-5xl leading-none la la-male"></span>
                        <p class="mt-2">Etudiants masculin</p>
                        <div class="text-primary mt-5 text-3xl leading-none">{{$male}}</div>
                    </div>
                </div>
                <div class="card px-0 py-2 flex justify-center items-center text-center lg:transform hover:scale-110 hover:shadow-lg transition-transform duration-200">
                    <div>
                        <span class="text-primary text-5xl leading-none la la-chalkboard-teacher"></span>
                        <p class="mt-0">Enseignants</p>
                        <div class="text-primary mt-5 text-3xl leading-none">{{$teachers}}</div>
                    </div>
                </div>
                <div class="card px-0 py-2 flex justify-center items-center text-center lg:transform hover:scale-110 hover:shadow-lg transition-transform duration-200">
                    <div>
                        <span class="text-primary text-5xl leading-none la la-clipboard-list"></span>
                        <p class="mt-2">Parcours</p>
                        <div class="text-primary mt-5 text-3xl leading-none">{{$parcours}}</div>
                    </div>
                </div>
                 <div class="card px-0 py-2 flex justify-center items-center text-center lg:transform hover:scale-110 hover:shadow-lg transition-transform duration-200">
                    <div>
                        <span class="text-primary text-5xl leading-none la la-business-time"></span>
                        <p class="mt-2">Secretaire</p>
                        <div class="text-primary mt-5 text-3xl leading-none">{{$managers}}</div>
                    </div>
                </div>
                 <div class="card px-0 py-2 flex justify-center items-center text-center lg:transform hover:scale-110 hover:shadow-lg transition-transform duration-200">
                    <div>
                        <span class="text-primary text-5xl leading-none la la-layer-group"></span>
                        <p class="mt-2">Unités d'enseignements</p>
                        <div class="text-primary mt-5 text-3xl leading-none">{{$ues}}</div>
                    </div>
                </div>
                 <div class="card px-0 py-2 flex justify-center items-center text-center lg:transform hover:scale-110 hover:shadow-lg transition-transform duration-200">
                    <div>
                        <span class="text-primary text-5xl leading-none la la-list"></span>
                        <p class="mt-2">Elements constitutifs</p>
                        <div class="text-primary mt-5 text-3xl leading-none">{{$ecs}}</div>
                    </div>
                </div>
                 <div class="card px-0 py-2 flex justify-center items-center text-center lg:transform hover:scale-110 hover:shadow-lg transition-transform duration-200">
                    <div>
                        <span class="text-primary text-5xl leading-none la la-check-square"></span>
                        <div class="mt-5 leading-none">
                           <p> Absences:  <span class="text-red-700">{{$absences}}</span></p>
                           <p>Présences:  <span class="text-primary">{{$presences}}</span></p>
                        </div>
                    </div>
                </div>
                <div class="lg:col-span-2 xl:col-span-1">
                    <div class="card p-5">
                        <h3>Semestre 1</h3>
                        <div class="mt-5 leading-normal">
                            <p>Début : {{ \Carbon\Carbon::parse($semestre_one->dateStart)->format('d M Y')}}</p>
                            <p>Fin : {{ \Carbon\Carbon::parse($semestre_one->dateEnd)->format('d M Y')}}</p>
                        </div>
                    </div>
                </div>
                 <div class="lg:col-span-2 xl:col-span-1">
                    <div class="card p-5">
                        <h3>Semestre 2</h3>
                        <div class="mt-5 leading-normal">
                            <p>Début : {{ \Carbon\Carbon::parse($semestre_two->dateStart)->format('d M Y')}}</p>
                            <p>Fin : {{ \Carbon\Carbon::parse($semestre_two->dateEnd)->format('d M Y')}}</p>
                        </div>
                    </div>
                </div>
            </div>
        @section('js')
        <script src="{{url()}}/public/assets/js/Sortable.min.js"></script>
        @endsection