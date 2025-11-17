import '../scss/main.scss';

document.addEventListener('DOMContentLoaded', () => {
    // menu scroll
    const header = document.querySelector( '.header' );

    if ( header ) {
        window.addEventListener( 'scroll', () => {
            if ( window.scrollY > 5 ) {
                header.classList.add( 'is_scrolled' );
            } else {
                header.classList.remove( 'is_scrolled' );
            }
        });
    }

    // mobile menu, burger
    const burger = document.querySelector( '#burger' );
    const mobileMenu = document.querySelector( '#mobile-menu' );
    const body = document.body;

    const menuOverlay = document.querySelector('#js-menu-overlay');

    if ( burger && mobileMenu ) {
        burger.addEventListener( 'click', () => {
            burger.classList.toggle( 'is-active' );
            mobileMenu.classList.toggle( 'is-open' );
            body.classList.toggle( 'no-scroll' );

            menuOverlay.classList.toggle('is-open');

            const isExpanded = burger.classList.contains( 'is-active' );
            burger.setAttribute( 'aria-expanded', isExpanded );
        });

        menuOverlay.addEventListener('click', () => {
            burger.classList.remove('is-active');
            mobileMenu.classList.remove('is-open');
            menuOverlay.classList.remove('is-open');
            body.classList.remove('no-scroll');
            burger.setAttribute('aria-expanded', 'false');
        });
    }

    
    const parentLinks = document.querySelectorAll('.mobile-menu .menu-item-has-children > a');

    parentLinks.forEach((link) => {
        link.addEventListener('click', (e) => {
            e.preventDefault(); 
            
            const parentLi = link.parentElement;
            parentLi.classList.toggle('is-open');
        });
    });
});

jQuery(function($) {    
    // slick slider
    const $slider = $( '#testimonials' );

    if ( $slider.length ) {
        $slider.slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            infinite: true,
            arrows: true,
            dots: false,

            prevArrow: `
                <button type="button" class="slick-prev slick-arrow" aria-label="Previous">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15 18L9 12L15 6" stroke="#2967F0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>`,
            
            nextArrow: `
                <button type="button" class="slick-next slick-arrow" aria-label="Next">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 18L15 12L9 6" stroke="#2967F0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>`,

            responsive: [
                {
                    breakpoint: 1024,
                    settings: { slidesToShow: 2 }
                },
                {
                    breakpoint: 768,
                    settings: { slidesToShow: 1, arrows: false, dots: true }
                }
            ]
        });
    }
});