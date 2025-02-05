<x-app-layout>
    <div class="fondo">
        <div x-data="{ imageSrc: '/images/userImage.jpg' }" class="relative background-container">
            
            <div :style="{ backgroundImage: 'url(' + imageSrc + ')' }" class="absolute inset-0 background-image"></div>

            <div class="dark-overlay"></div>

            <div class="w-2/4 p-4 space-y-4 sidebar">
                <a href="#" @mouseover="imageSrc = '/images/userImage.jpg'" class="link">Link 1</a>
                <a href="#" @mouseover="imageSrc = '/images/DownUsers.jpg'" class="link">Link 2</a>
                <a href="#" @mouseover="imageSrc = '/images/UpUsers.jpg'" class="link">Link 3</a>
                <a href="#" @mouseover="imageSrc = '/images/image4.jpg'" class="link">Link 4</a>
            </div>
        </div>
    </div>
</x-app-layout>
