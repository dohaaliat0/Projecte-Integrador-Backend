<x-app-layout>
    <div :style="{ backgroundImage: 'url(' + imageSrc + ')', backgroundRepeat: 'no-repeat', backgroundSize: 'cover', minHeight: '100vh' }" x-data="{ imageSrc: '/images/default.jpg' }" class="relative">
        <!-- Sidebar de Links -->
        <div class="w-2/4 p-4 space-y-4" style="position: absolute; top: 0; left: 0; min-height: 100vh;">
            <a href="#" @mouseover="imageSrc = '/images/userImage.jpg'" class="link">Link 1</a>
            <a href="#" @mouseover="imageSrc = '/images/DownUsers.jpg'" class="link">Link 2</a>
            <hr class="border-t-2 border-gray-300">
            <a href="#" @mouseover="imageSrc = '/images/UpUsers.jpg'" class="link">Link 3</a>
            <a href="#" @mouseover="imageSrc = '/images/image4.jpg'" class="link">Link 4</a>
        </div>

        <!-- Línea Vertical -->


    </div>
</x-app-layout>