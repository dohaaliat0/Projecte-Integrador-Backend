<x-app-layout>
    <div x-data="{ imageSrc: '/images/default.jpg' }" class="flex">
        <!-- Sidebar de Links -->
        <div class="w-1/4 p-4 space-y-4">
            <a href="#" @mouseover="imageSrc = '/images/userImage.jpg'" class="link">Link 1</a>
            <a href="#" @mouseover="imageSrc = '/images/image2.jpg'" class="link">Link 2</a>
            <hr class="border-t-2 border-gray-300">
            <a href="#" @mouseover="imageSrc = '/images/image3.jpg'" class="link">Link 3</a>
            <a href="#" @mouseover="imageSrc = '/images/image4.jpg'" class="link">Link 4</a>
        </div>

        <!-- Línea Vertical -->
        <div class="border-l-2 border-gray-300 mx-4"></div>

        <!-- Imagen que cambia -->
        <div class="w-3/4 p-4">
            <img :src="imageSrc" alt="Image" class="w-full h-auto object-cover transition-all duration-500 ease-in-out">
        </div>
    </div>
</x-app-layout>