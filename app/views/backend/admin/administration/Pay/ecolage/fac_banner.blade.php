  <header class="border-b border-gray-200 bg-white dark:bg-gray-800 dark:border-gray-800">
    <div class="container mx-auto xl:max-w-6xl ">
      <!-- Navbar -->
      <nav class="flex flex-row flex-nowrap items-center justify-between mt-0 py-4 px-6" id="desktop-menu">
      <!-- logo -->
      <a class="flex items-center py-2 mr-4 text-xl" href="{{ URL::route('panel.admin') }}">
        <h2 class="text-2xl font-semibold text-gray-200 px-4 max-h-10 overflow-hidden">
          <img class="inline-block w-8 h-auto mr-2 -mt-1" src="{{ url() }}/public/uploads/logo/{{$control->logo}}"}}></h2>
      </a>
      <!-- menu -->
      <ul class="flex ml-auto mt-2 mt-0">
        <!-- Customizer (Only for demo purpose) -->
        <li x-data="{ open: false }" class="relative">
          <a href="{{ URL::route('indexPay') }}" class="block py-3 px-4 flex text-sm rounded-full focus:outline-none" aria-controls="mobile-canvas" @click="open = !open" aria-expanded="false" x-bind:aria-expanded="open.toString()">
            <svg class="inline-block w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
          </a>
        </li><!-- End Customizer (Only for demo purpose) -->
      </ul>
      </nav>
    </div>
  </header> 