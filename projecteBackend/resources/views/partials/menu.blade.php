<div class="flex space-x-4 ">
    <div class="menu-item hidden sm:flex items-center">
        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="nav-link text-white font-semibold hover:text-gray-300 transition duration-300 ease-in-out">
            {{ __('Dashboard') }}
        </x-nav-link>
    </div>
    <div class="menu-item hidden sm:flex items-center">
        <x-nav-link :href="route('assignusers.index')" :active="request()->routeIs('assignusers.index')" class="nav-link text-white font-semibold hover:text-gray-300 transition duration-300 ease-in-out">
            {{ __('Asignar un usuario') }}
        </x-nav-link>
    </div>
    <div class="menu-item hidden sm:flex items-center"> 
        <x-nav-link :href="route('webzones.index')" :active="request()->routeIs('webzones.index')" class="nav-link text-white font-semibold hover:text-gray-300 transition duration-300 ease-in-out">
            {{ __('Zonas') }}
        </x-nav-link>
    </div> 
    <div class="menu-item hidden sm:flex items-center">
        <x-nav-link :href="route('altabaja.index')" :active="request()->routeIs('altabaja.index')" class="nav-link text-white font-semibold hover:text-gray-300 transition duration-300 ease-in-out">
            {{ __('Dar de alta o baja') }}
        </x-nav-link>
    </div>
</div>
