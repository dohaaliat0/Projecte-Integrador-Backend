document.addEventListener('alpine:init', () => {
    Alpine.data('imageChanger', () => ({
        imageSrc: '/images/defaultImage.jpg', 
    }));
});