<!-- Top Bar -->
    <header class="top-bar">
        <!-- Menu Toggler -->
        <button type="button" class="menu-toggler la la-bars" data-toggle="menu"></button>
        <!-- Brand -->
        <span class="brand">SCOLX</span>
        @if(Auth::user()->is_admin)
        @if(!Auth::user()->is_secretaire) 
        <!-- Search -->
        <form class="hidden md:block ltr:ml-10 rtl:mr-10" action="#">
            <label class="form-control-addon-within rounded-full">
                <input type="text" class="form-control border-none" placeholder="Search">
                <button type="button"
                    class="btn btn-link text-gray-300 dark:text-gray-700 dark:hover:text-primary text-xl leading-none la la-search ltr:mr-4 rtl:ml-4"></button>
            </label>
        </form>
        @endif
        @endif
        <!-- Right -->
        <div class="flex items-center ltr:ml-auto rtl:mr-auto">
            <!-- Dark Mode -->
            <label class="switch switch_outlined" data-toggle="tooltip" data-tippy-content="Basculer en mode sombre">
                <input id="darkModeToggler" type="checkbox">
                <span></span>
            </label>
            <!-- Fullscreen -->
            <button id="fullScreenToggler" type="button"
                class="hidden lg:inline-block btn-link ltr:ml-3 rtl:mr-3 px-2 text-2xl leading-none la la-expand-arrows-alt"
                data-toggle="tooltip" data-tippy-content="Plein écran"></button>

@if(Auth::user()->is_admin)
@if(!Auth::user()->is_secretaire)             
            <!-- Apps -->
            <div class="dropdown self-stretch">
                <button type="button"
                    class="flex items-center h-full btn-link ltr:ml-4 rtl:mr-4 lg:ltr:ml-1 lg:rtl:mr-1 px-2 text-2xl leading-none la la-box"
                    data-toggle="custom-dropdown-menu" data-tippy-arrow="true" data-tippy-placement="bottom">
                </button>
                <div class="custom-dropdown-menu p-5 text-center">
                    <div class="flex justify-around">
                        <a href="#" class="p-5 text-normal hover:text-primary">
                            <span class="block la la-cog text-5xl leading-none"></span>
                            <span>Settings</span>
                        </a>
                        <a href="#" class="p-5 text-normal hover:text-primary">
                            <span class="block la la-users text-5xl leading-none"></span>
                            <span>Users</span>
                        </a>
                    </div>
                    <div class="flex justify-around">
                        <a href="#" class="p-5 text-normal hover:text-primary">
                            <span class="block la la-book text-5xl leading-none"></span>
                            <span>Docs</span>
                        </a>
                        <a href="#" class="p-5 text-normal hover:text-primary">
                            <span class="block la la-dollar text-5xl leading-none"></span>
                            <span>Shop</span>
                        </a>
                    </div>
                </div>
            </div>
           <!-- Notifications -->
            <div class="dropdown self-stretch">
                <button type="button"
                    class="relative flex items-center h-full btn-link ltr:ml-1 rtl:mr-1 px-2 text-2xl leading-none la la-bell"
                    data-toggle="custom-dropdown-menu" data-tippy-arrow="true" data-tippy-placement="bottom-end">
                    <span
                        class="absolute top-0 right-0 rounded-full border border-primary -mt-1 -mr-1 px-2 leading-tight text-xs font-body text-primary">3</span>
                </button>
                <div class="custom-dropdown-menu">
                    <div class="flex items-center px-5 py-2">
                        <h5 class="mb-0 uppercase">Notifications</h5>
                        <button class="btn btn_outlined btn_warning uppercase ltr:ml-auto rtl:mr-auto">Clear All</button>
                    </div>
                    <hr>
                    <div class="p-5 hover:bg-primary hover:bg-opacity-5">
                        <a href="#">
                            <h6 class="uppercase">Heading One</h6>
                        </a>
                        <p>Lorem ipsum dolor, sit amet consectetur.</p>
                        <small>Today</small>
                    </div>
                    <hr>
                    <div class="p-5 hover:bg-primary hover:bg-opacity-5">
                        <a href="#">
                            <h6 class="uppercase">Heading Two</h6>
                        </a>
                        <p>Mollitia sequi dolor architecto aut deserunt.</p>
                        <small>Yesterday</small>
                    </div>
                    <hr>
                    <div class="p-5 hover:bg-primary hover:bg-opacity-5">
                        <a href="#">
                            <h6 class="uppercase">Heading Three</h6>
                        </a>
                        <p>Nobis reprehenderit sed quos deserunt</p>
                        <small>Last Week</small>
                    </div>
                </div>
            </div>
            @endif
            @endif 

@if(Auth::check()) 
@if(Auth::user()->is_admin)
@if(!Auth::user()->is_secretaire)            
            <!-- User Menu -->
            <div class="dropdown">
                <button class="flex items-center ltr:ml-4 rtl:mr-4" data-toggle="custom-dropdown-menu"
                    data-tippy-arrow="true" data-tippy-placement="bottom-end">
                    <span class="avatar font-bold">{{ substr(Auth::user()->fname,0,2) }}</span>
                </button>
                <div class="custom-dropdown-menu w-64">
                    <div class="p-5">
                        <h5 class="uppercase">{{ Auth::user()->fname }}</h5>
                        <p>Admin</p>
                    </div>
                    <hr>
                    <div class="p-5">
                        <a href="#" class="flex items-center text-normal hover:text-primary">
                            <span class="la la-user-circle text-2xl leading-none ltr:mr-2 rtl:ml-2"></span>
                            Voir le profil
                        </a>
                        <a href="#" class="flex items-center text-normal hover:text-primary mt-5">
                            <span class="la la-key text-2xl leading-none ltr:mr-2 rtl:ml-2"></span>
                            Changer mot de passe
                        </a>
                    </div>
                    <hr>
                    <div class="p-5">
                        <a href="{{ URL::route('users.logout') }}" class="flex items-center text-normal hover:text-primary">
                            <span class="la la-power-off text-2xl leading-none ltr:mr-2 rtl:ml-2 text-red-700"></span>
                            Déconnexion
                        </a>
                    </div>
                </div>
            </div>
  
@else
            <!-- User Menu -->
            <div class="dropdown">
                <button class="flex items-center ltr:ml-4 rtl:mr-4" data-toggle="custom-dropdown-menu"
                    data-tippy-arrow="true" data-tippy-placement="bottom-end">
                    <span class="avatar font-bold">{{ substr(Auth::user()->fname,0,2) }}</span>
                </button>
                <div class="custom-dropdown-menu w-64">
                    <div class="p-5">
                        <h5 class="">{{ Auth::user()->fname. ' ' .Auth::user()->lname }}</h5>
                        <p>Sécretaire #{{ Auth::user()->id }}</p>
                    </div>
                    <hr>
                    <div class="p-5">
                        <a href="#" class="flex items-center text-normal hover:text-primary">
                            <span class="la la-user-circle text-2xl leading-none ltr:mr-2 rtl:ml-2"></span>
                             Voir le profil
                        </a>
                    </div>
                    <hr>
                    <div class="p-5">
                        <a href="{{ URL::route('users.logout') }}" class="flex items-center text-normal hover:text-primary">
                            <span class="la la-power-off text-2xl leading-none ltr:mr-2 rtl:ml-2 text-red-700"></span>
                            Déconnexion
                        </a>
                    </div>
                </div>
            </div>
@endif
@endif
@endif          
        </div>
    </header>
