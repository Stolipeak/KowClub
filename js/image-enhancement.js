// Chargement progressif des images
document.addEventListener('DOMContentLoaded', function() {
    const images = document.querySelectorAll('.item img');

    const imageOptions = {
        threshold: 0.1,
        rootMargin: '50px'
    };

    function preloadImage(img) {
        const src = img.getAttribute('src');
        if (!src) return;

        img.classList.add('loading');
        
        const newImage = new Image();
        newImage.src = src;
        newImage.onload = function() {
            img.classList.remove('loading');
            img.classList.add('loaded');
        };
    }

    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                preloadImage(entry.target);
                observer.unobserve(entry.target);
            }
        });
    }, imageOptions);

    images.forEach(img => {
        img.classList.add('loading');
        imageObserver.observe(img);
    });

    // Zoom au clic sur mobile
    if (window.innerWidth < 1024) {
        images.forEach(img => {
            img.addEventListener('click', function() {
                this.classList.toggle('zoomed');
            });
        });
    }
});
