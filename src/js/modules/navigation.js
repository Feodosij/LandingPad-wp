
export function initNavigation() {
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
    const burger = document.querySelector('#burger');
    const menuOverlay = document.querySelector('#js-menu-overlay');
    const body = document.body;

    if (header && burger && menuOverlay) {
        burger.addEventListener('click', () => {
            const isOpen = header.classList.toggle('mobile-menu-open');
            burger.setAttribute('aria-expanded', isOpen);
            body.classList.toggle( 'no-scroll' );
        });

        menuOverlay.addEventListener('click', () => {
            header.classList.remove('mobile-menu-open');
            burger.setAttribute('aria-expanded', 'false');
            body.classList.remove( 'no-scroll' );
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
}