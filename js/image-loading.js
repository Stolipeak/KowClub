// Gestion du chargement progressif des images
document.addEventListener('DOMContentLoaded', function() {
    const images = document.querySelectorAll('img[loading="lazy"]');
    
    // Observer pour le chargement lazy
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                if (img.dataset.src) {
                    img.src = img.dataset.src;
                    img.removeAttribute('data-src');
                }
                observer.unobserve(img);
            }
        });
    });

    // Application de l'observer sur toutes les images
    images.forEach(img => {
        imageObserver.observe(img);
    });

    // Gestion des erreurs de chargement d'image
    images.forEach(img => {
        img.addEventListener('error', function() {
            this.style.display = 'none';
            const fallbackText = document.createElement('span');
            fallbackText.textContent = this.alt || 'Image non disponible';
            fallbackText.className = 'image-fallback';
            this.parentNode.insertBefore(fallbackText, this);
        });
    });
});
