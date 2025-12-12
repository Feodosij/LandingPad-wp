
// gallery lightbox on single apartment
export function initLightbox() {
    const lightbox = document.getElementById('simple-lightbox');

    if (lightbox) {
        const lightboxImg = lightbox.querySelector('.lightbox__image');
        const closeBtn = lightbox.querySelector('.lightbox__close');
        const lightboxCounter = lightbox.querySelector('.lightbox__counter');

        const prevBtn = lightbox.querySelector('.lightbox__prev');
        const nextBtn = lightbox.querySelector('.lightbox__next');
        
        let galleryLinks = document.querySelectorAll('.js-lightbox-trigger:not(.slick-cloned)');
        let currentIndex = 0;

        function updateCounter() {
            if (lightboxCounter) {
                lightboxCounter.textContent = `${currentIndex + 1} of ${galleryLinks.length}`;
            }
        }

        function openLightbox(index) {
            currentIndex = index;
            const url = galleryLinks[currentIndex].getAttribute('href');
            
            lightboxImg.src = url;
            lightbox.classList.add('is-open');
            document.body.classList.add('no-scroll');

            updateCounter();
        }

        function closeLightbox() {
            lightbox.classList.remove('is-open');
            lightboxImg.src = '';
            document.body.classList.remove('no-scroll');
        }

        function changeSlide(n) {
            currentIndex += n;
            
            if (currentIndex >= galleryLinks.length) currentIndex = 0;
            if (currentIndex < 0) currentIndex = galleryLinks.length - 1;
            
            const url = galleryLinks[currentIndex].getAttribute('href');
            lightboxImg.src = url;

            updateCounter();
        }

        galleryLinks.forEach((link, index) => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                openLightbox(index);
            });
        });

        closeBtn.onclick = closeLightbox;
        prevBtn.onclick = () => changeSlide(-1);
        nextBtn.onclick = () => changeSlide(1);

        lightbox.onclick = (e) => {
            if (e.target === lightbox) closeLightbox();
        }
    }
}