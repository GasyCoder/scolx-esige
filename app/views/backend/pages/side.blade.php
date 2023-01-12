 <!-- Menu Bar -->
    <aside class="menu-bar menu-sticky">
        <div class="menu-items">
            <div class="menu-header hidden">
                <a href="#" class="flex items-center mx-8 mt-8">
                    <span class="avatar w-16 h-16">JD</span>
                    <div class="ltr:ml-4 rtl:mr-4 ltr:text-left rtl:text-right">
                        <h5>John Doe</h5>
                        <p class="mt-2">Editor</p>
                    </div>
                </a>
                <hr class="mx-8 my-4">
            </div>
            <a href="{{URL::route('panel.admin')}}" class="link" data-toggle="tooltip-menu" data-tippy-content="Tableau de bord">
                <span class="icon la la-home"></span>
                <span class="title">Accueil</span>
            </a>
            <a href="#no-link" class="link" data-target="[data-menu=ui]" data-toggle="tooltip-menu" data-tippy-content="UI">
                <span class="icon la la-book-open"></span>
                <span class="title">Pédagogies</span>
            </a>
            <a href="#no-link" class="link" data-target="[data-menu=pages]" data-toggle="tooltip-menu"
                data-tippy-content="Pages">
                <span class="icon la la-university"></span>
                <span class="title">Scolarités</span>
            </a>
            <a href="#no-link" class="link" data-target="[data-menu=addnotes]" data-toggle="tooltip-menu"
                data-tippy-content="Notes">
                <span class="icon la la-folder-plus"></span>
                <span class="title">Gestions des notes</span>
            </a>
            <a href="#no-link" class="link" data-target="[data-menu=notes]" data-toggle="tooltip-menu"
                data-tippy-content="Notes">
                <span class="icon la la-file-alt"></span>
                <span class="title">Résultats d'examen</span>
            </a>

            @if(!Auth::user()->is_secretaire)
            <a href="#no-link" class="link" data-target="[data-menu=menu]" data-toggle="tooltip-menu"
                data-tippy-content="Menu">
                <span class="icon la la-cog"></span>
                <span class="title">Paramètres</span>
            </a>
            @else
            <a href="#no-link" class="link" data-target="[data-menu=menu]" data-toggle="tooltip-menu"
                data-tippy-content="Menu">
                <span class="icon la la-layer-group"></span>
                <span class="title">Réglages</span>
            </a>
            @endif
        </div>

        <!-- Pedagogies -->
        <div class="menu-detail" data-menu="ui">
            <div class="menu-detail-wrapper">
                <h6 class="uppercase">Pédagogies</h6>
                @if($control->inscrit == 1)
                <a href="{{ URL::route('indexEtudiant') }}">
                    <span class="la la-user-plus"></span>
                    Inscription
                </a>
                @endif
                @if($control->reSinscrit == 1)
                <a href="{{URL::route('reInscrit')}}">
                    <span class="la la-edit"></span>
                    Ré-inscription
                </a>
                @endif
                 <hr class="border-dashed">
                <a href="{{URL::route('indexUe')}}">
                    <span class="la la-bookmark"></span>
                    Unité d'Enseignement
                </a>
                <a href="{{URL::route('indexEc')}}">
                    <span class="la la-list-ul"></span>
                    Elements Constitutifs
                </a>
                <hr class="border-dashed">
                 <a href="{{URL::route('studentsAll')}}">
                    <span class="la la-user-graduate"></span>
                    Etudiants
                </a>
                <a href="{{URL::route('indexTeacher')}}">
                    <span class="la la-chalkboard-teacher"></span>
                    Enseignants
                </a>
                <hr class="border-dashed">
                <a href="{{URL::route('indexNiveau')}}">
                    <span class="la la-cubes"></span>
                    Niveaux
                </a>
                <a href="{{ URL::route('indexD') }}">
                    <span class="la la-th-large"></span>
                    Domaines
                </a>
                 <a href="{{ URL::route('indexM') }}">
                    <span class="la la-th"></span>
                    Mentions
                </a>
                 <a href="{{ URL::route('indexParcour') }}">
                    <span class="la la-th-list"></span>
                    Parcours
                </a>
                <a href="{{ URL::route('indexGroupe') }}">
                    <span class="la la-users"></span>
                    Groupes
                </a>
            </div>
        </div>
        <!--Fin pedagogies -->

        <!-- Administration -->
        <div class="menu-detail" data-menu="pages">
            <div class="menu-detail-wrapper">
                <h6 class="uppercase">Gestions</h6>
                <hr>
                <a href="{{URL::route('indexPay')}}">
                    <span class="la la-file-invoice-dollar"></span>
                    Gestion des paiements
                </a>
                <a href="{{ URL::route('absence') }}">
                    <span class="la la-check-square"></span>
                    Gestion des absences
                </a>
                <hr>
                <a href="#">
                    <span class="la la-calendar"></span>
                    Emploi du temps
                </a>
              	<a href="{{URL::route('indexCerti')}}">
                    <span class="la la-certificate"></span>
                    Certificat de Scolarité
                </a>
                @if(Auth::user()->is_admin)
                @if(!Auth::user()->is_secretaire)
                <hr>
                <h6 class="uppercase">Année/Semestres Universitaire</h6>
                <a href="{{URL::route('indexYear')}}">
                    <span class="la la-calendar-plus"></span>
                    Année Universitaire
                </a>
                <hr class="border-dashed">
                <a href="{{URL::route('indexSemestre')}}">
                    <span class="la la-calendar-week"></span>
                    Semestre Universitaire
                </a>
                <h6 class="uppercase">Gestion des Sécretariats</h6>
                <a href="{{URL::route('secretaires')}}">
                    <span class="la la-user-tie"></span>
                    Listes des Sécretaires
                </a>
                @endif @endif
            </div>
        </div>
        <!-- Fin Administration -->

        <!-- Administration -->
        <div class="menu-detail" data-menu="addnotes">
            <div class="menu-detail-wrapper">
                <h6 class="uppercase">Ajouter les notes</h6>
                <hr class="border-dashed">
                <a href="{{URL::route('addnote_one')}}">
                    <span class="la la-plus-circle"></span>
                    Notes des étudiants
                </a>
                 <a href="{{URL::route('recap')}}">
                    <span class="la la-layer-group"></span>
                    Récapitulatif
                </a>
            </div>
        </div>

                <!-- Administration -->
        <div class="menu-detail" data-menu="notes">
            <div class="menu-detail-wrapper">
                 <h6 class="uppercase">Résultats par année</h6>
                 <hr class="border-dashed">
                 <a href="{{URL::route('indexdeliber')}}">
                    <span class="la la-wpforms"></span>
                    Déliberation
                </a>
                <a href="{{URL::route('indexResult_1')}}" class="">
                    <span class="collapse-indicator la la-arrow-circle-down"></span>
                    Résultats d'examens
                </a>
                @if($control->openNote == 1)
                <!--<a href="{{URL::route('bilan')}}">
                    <span class="la la-list"></span>
                    Bilan par année d'étude
                </a>-->
                @endif
            </div>
        </div>
        <!--  Actualités 
                <div class="menu-detail" data-menu="applications">
                    <div class="menu-detail-wrapper">
                        <a href="#">
                            <span class="la la-plus-square"></span>
                            Actualités du site
                        </a>
                        <a href="#">
                            <span class="la la-image"></span>
                            Galéries
                        </a>
                        <a href="#">
                            <span class="la la-calendar-plus"></span>
                            Agenda
                        </a>
                    </div>
                </div>
        Fin  Actualités -->
        <!-- Paramètres -->
        <div class="menu-detail" data-menu="menu">
        @if(Auth::user()->is_admin) @if(!Auth::user()->is_secretaire)      
                <h6 class="uppercase">Paramètres</h6>
                <a href="{{URL::route('configindex')}}">
                    <span class="la la-toolbox"></span>
                    Paramètrede du site
                </a>
                <hr>
                <a href="{{URL::route('indexEcot')}}">
                    <span class="la la-tenge"></span>
                    Configuration d'écolage
                </a>
                <hr>
            @endif @endif
                <h6 class="uppercase">Reglages des contenus</h6>
                <a href="#no-link" data-toggle="menu-type" data-value="default">
                    <span class="la la-hand-point-right"></span>
                    Default
                </a>
                <a href="#no-link" data-toggle="menu-type" data-value="hidden">
                    <span class="la la-hand-point-left"></span>
                    Hidden
                </a>
                <a href="#no-link" data-toggle="menu-type" data-value="icon-only">
                    <span class="la la-th-large"></span>
                    Icons Only
                </a>
                <a href="#no-link" data-toggle="menu-type" data-value="wide">
                    <span class="la la-arrows-alt-h"></span>
                    Wide
                </a>
            </div>
        </div>
    </aside>