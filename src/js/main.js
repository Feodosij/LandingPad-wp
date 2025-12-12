import '../scss/main.scss';
import { initNavigation } from './modules/navigation';


document.addEventListener( 'DOMContentLoaded', () => {
    // navigation menu
    initNavigation();

    // testimonials slick slider
    if ( document.querySelector( '#testimonials' ) ) {
        import( './modules/sliders' ).then( module => {
            module.initTestimonialsSlider();
        });
    }

    // apartment slick slider
    if ( document.querySelector( '#js-apartment-slider' ) ) {
        import( './modules/sliders' ).then( module => {
            module.initApartmentSlider();
        });
    }

    // google map
    if ( document.querySelector( '.acf-map' ) ) {
        import( './modules/google-map' ).then( module => {
            module.initGoogleMap();
        });
    }

    // accordion
    if ( document.querySelector( '.accordion__details' ) ) {
        import( './modules/accordion' ).then( module => {
            module.initAccordion();
        });
    }

    // table of content
    if ( document.querySelector('.toc__link' ) ) {
        import( './modules/table-of-content' ).then( module => {
            module.initTableOfContent();
        });
    }

    // lightbox
    if ( document.getElementById('simple-lightbox' ) ) {
        import( './modules/lightbox' ).then( module => {
            module.initLightbox();
        });
    }

    // ajax Load More for apartments
    if ( document.querySelector( '#apartments-load-more' ) ) {
        import( './modules/load-more-ajax' ).then( module => {
            module.initApartmentLoader();
        });
    }

    // Ajax Load More for Blog Posts
    if ( document.querySelector( '#load-more-btn' ) ) {
        import( './modules/load-more-ajax' ).then( module => {
            module.initBlogLoader();
        });
    }

    addInstagramOverlayText();

});

// add "View post" text to instagram card overlay 
function addInstagramOverlayText() {
    const instagramItems = document.querySelectorAll('#sb_instagram #sbi_images .sbi_item');
    
    instagramItems.forEach(item => {
        const photoWrap = item.querySelector('.sbi_photo_wrap');

        if (photoWrap) {
            if (!item.querySelector('.sbi_overlay_text')) { 
                const viewPostText = document.createElement('span');
                viewPostText.className = 'sbi_overlay_text';
                viewPostText.textContent = 'View post';

                photoWrap.appendChild(viewPostText);
            }
        }
    });
}
