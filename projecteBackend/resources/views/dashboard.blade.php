<x-app-layout>
    @vite('resources/css/index.css')
    <div class="container">
        <div x-data="{ imageSrc: '/images/users.png' }" class="layout-container">
            <!-- Sidebar con enlaces -->
            <div class="sidebar">
                <a href="http://conectasalud.batoi.es" @mouseover="imageSrc = '/images/users.png'" class="link">Usuarios</a>
                <a href="altabaja" @mouseover="imageSrc = '/images/asignarOperadores.png'" class="link">Dar de baja y alta</a>
                <a href="webzones" @mouseover="imageSrc = '/images/Zonas.png'" class="link">Zonas</a>
                <a href="assignusers" @mouseover="imageSrc = '/images/AltaBaja.png'" class="link">Asignar usuarios</a>
                <a href="llamadas" @mouseover="imageSrc = '/images/llamadas.png'" class="link">Llamadas</a>
            </div>

            <!-- Contenedor de la imagen a la derecha -->
            <div class="image-container">
                <div :style="{ backgroundImage: 'url(' + imageSrc + ')' }" class="background-image"></div>
                <div class="dark-overlay"></div>
            </div>
        </div>
    </div>
</x-app-layout>
