document.addEventListener('alpine:init', () => {
    Alpine.data('imageChanger', () => ({
        imageSrc: 'image1.jpg', // Imagen por defecto
    }));
});