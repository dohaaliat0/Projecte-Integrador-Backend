<x-app-layout>
        <div x-data="{ imageSrc: '/images/userImage.jpg' }" class="relative background-container">
            
            <div :style="{ backgroundImage: 'url(' + imageSrc + ')' }" class="absolute inset-0 background-image"></div>

            <div class="dark-overlay"></div>

            <div class="w-2/4 p-4 space-y-4 sidebar">
                <a href="#" @mouseover="imageSrc = '/images/userImage.jpg'" class="link">Usuarios</a>
                <a href="#" @mouseover="imageSrc = '/images/DownUsers.jpg'" class="link">Dar de baja</a>
                <a href="webzones" @mouseover="imageSrc = '/images/UpUsers.jpg'" class="link">Zonas</a>
                <a href="#" @mouseover="imageSrc = '/images/ModifiUser.jpg'" class="link">Modificar usuarios</a>
            </div>
        </div>
</x-app-layout>

