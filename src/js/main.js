import '../scss/main.scss';

import $ from 'jquery';

// google map init
window.init_map = function($el) {
    const $markers = $el.find('.marker');
    const args = {
        zoom: 16,
        center: new google.maps.LatLng(0, 0),
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        disableDefaultUI: true,
        zoomControl: true,
        mapTypeControl: true,
        streetViewControl: false,
        fullscreenControl: false,

        mapTypeControlOptions: {
            style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
            position: google.maps.ControlPosition.BOTTOM_LEFT
        },
    };

    const map = new google.maps.Map($el[0], args);
    map.markers = [];

    $markers.each(function() {
        add_marker($(this), map);
    });

    center_map(map);
    return map;
};

// add marker adress on map
function add_marker($marker, map) {
    const lat = $marker.attr('data-lat') || $marker.data('lat');
    const lng = $marker.attr('data-lng') || $marker.data('lng');
    
    if (!lat || !lng) return;

    const latlng = new google.maps.LatLng(lat, lng);
    const marker = new google.maps.Marker({
        position: latlng,
        map: map,
        title: $marker.data('title')
    });

    map.markers.push(marker);

    let content = $marker.html();
    
    const addressText = $marker.attr('data-address') || $marker.data('address');
    
    if (addressText) {
        content = '<div class="map-infowindow">' + addressText + '</div>';
    }

    if (content) {
        const infowindow = new google.maps.InfoWindow({
            content: content
        });

        infowindow.open(map, marker);

        google.maps.event.addListener(marker, 'click', function() {
            infowindow.open(map, marker);
        });
    }
}

// centered markeron map
function center_map(map) {
    const bounds = new google.maps.LatLngBounds();
    $.each(map.markers, function(i, marker) {
        var latlng = new google.maps.LatLng(marker.position.lat(), marker.position.lng());
        bounds.extend(latlng);
    });

    if (map.markers.length == 1) {
        map.setCenter(bounds.getCenter());
        map.setZoom(15);
    } else {
        map.fitBounds(bounds);
    }
}

// callback for render google map 
window.acf_init_maps = function() {
    $('.acf-map').each(function() {
        window.init_map($(this));
    });
};

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


    // default open one accordion
    const TARGET_PAGE_CLASS = 'single-services';
    const isTargetPage = document.body.classList.contains(TARGET_PAGE_CLASS);

    if (isTargetPage) {
        if (window.location.hash) {
            const targetId = window.location.hash;
            const targetElement = document.querySelector(targetId);

            if (targetElement && targetElement.tagName === 'DETAILS') {
                targetElement.setAttribute('open', true);
            } 

        } else {
            const allAccordions = document.querySelectorAll(".accordion__details");

            if (allAccordions.length === 0) {
                return; 
            }

            const first = allAccordions[0];
            first.setAttribute("open", true);
        }
    }

    // table of content
    const tocLinks = document.querySelectorAll('.toc__link');
    const headings = document.querySelectorAll('.single-blog__content h2, .single-blog__content h3');
    
    if (tocLinks.length === 0 || headings.length === 0) return;

    const observerOptions = {
        root: null,
        rootMargin: '-100px 0px -60% 0px',
        threshold: 0
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                tocLinks.forEach(link => link.classList.remove('active'));
                
                const activeId = entry.target.getAttribute('id');
                const activeLink = document.querySelector(`.toc__link[href="#${activeId}"]`);
                
                if (activeLink) {
                    activeLink.classList.add('active');
                }
            }
        });
    }, observerOptions);

    headings.forEach(heading => {
        observer.observe(heading);
    });
    
    tocLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href').substring(1);
            const targetSection = document.getElementById(targetId);
            
            if(targetSection){
                window.scrollTo({
                    top: targetSection.offsetTop - 120,
                    behavior: 'smooth'
                });
            }
        });
    });

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


jQuery(function($) {    
    // waiting for load google map api (max 5 sec)
    let tries = 0;
    const maxTries = 50;

    let checkGoogleMaps = setInterval(function() {
        if (typeof google !== 'undefined' && typeof google.maps !== 'undefined') {
            clearInterval(checkGoogleMaps);
            window.acf_init_maps();
        }
        tries++;
        if (tries >= maxTries) {
            clearInterval(checkGoogleMaps);
            console.warn('Google Maps API not loaded after timeout');
        }
    }, 100);

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

    // apartment slider
    const $apartmentSlider = $('#js-apartment-slider');

    if ($apartmentSlider.length) {
        $apartmentSlider.slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: true,
            dots: true,
            fade: true,
            
            prevArrow: `<button type="button" class="slick-prev">
                            <svg width="10" height="19" viewBox="0 0 10 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.17005 18.2811C9.29503 18.1571 9.39422 18.0096 9.46191 17.8472C9.5296 17.6847 9.56445 17.5104 9.56445 17.3344C9.56445 17.1584 9.5296 16.9841 9.46191 16.8216C9.39422 16.6591 9.29503 16.5117 9.17005 16.3877L3.06339 10.2811C2.93842 10.1571 2.83923 10.0096 2.77153 9.84716C2.70384 9.68468 2.66899 9.51041 2.66899 9.33439C2.66899 9.15837 2.70384 8.9841 2.77153 8.82162C2.83923 8.65914 2.93842 8.51167 3.06339 8.38772L9.17006 2.28106C9.29503 2.15711 9.39422 2.00964 9.46191 1.84716C9.5296 1.68468 9.56445 1.51041 9.56445 1.33439C9.56445 1.15837 9.5296 0.9841 9.46191 0.821621C9.39422 0.659142 9.29503 0.511674 9.17006 0.387723C8.92024 0.139389 8.5823 -4.29311e-08 8.23006 -5.83284e-08C7.87781 -7.37256e-08 7.53987 0.139389 7.29006 0.387723L1.17006 6.50772C0.420986 7.25773 0.000240918 8.27439 0.000240872 9.33439C0.000240825 10.3944 0.420986 11.4111 1.17005 12.1611L7.29005 18.2811C7.53987 18.5294 7.87781 18.6688 8.23005 18.6688C8.5823 18.6688 8.92024 18.5294 9.17005 18.2811Z" fill="white" />
                            </svg>
                        </button>`,
            nextArrow: `<button type="button" class="slick-next">
                            <svg width="10" height="19" viewBox="0 0 10 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0.394398 0.387737C0.269427 0.511688 0.170234 0.659155 0.102542 0.821632C0.0348509 0.984112 2.0881e-07 1.15839 2.06711e-07 1.3344C2.04612e-07 1.51042 0.0348509 1.68469 0.102542 1.84717C0.170234 2.00965 0.269427 2.15712 0.394398 2.28107L6.50106 8.38774C6.62604 8.51169 6.72523 8.65915 6.79292 8.82163C6.86061 8.98411 6.89546 9.15839 6.89546 9.3344C6.89546 9.51042 6.86061 9.68469 6.79292 9.84717C6.72523 10.0097 6.62604 10.1571 6.50106 10.2811L0.394398 16.3877C0.269427 16.5117 0.170234 16.6592 0.102542 16.8216C0.0348507 16.9841 1.80114e-08 17.1584 1.59124e-08 17.3344C1.38135e-08 17.5104 0.0348507 17.6847 0.102542 17.8472C0.170234 18.0097 0.269427 18.1571 0.394398 18.2811C0.644214 18.5294 0.98215 18.6688 1.3344 18.6688C1.68665 18.6688 2.02458 18.5294 2.2744 18.2811L8.3944 12.1611C9.14347 11.4111 9.56421 10.3944 9.56421 9.3344C9.56421 8.2744 9.14347 7.25774 8.3944 6.50774L2.2744 0.387737C2.02458 0.139402 1.68665 1.14642e-05 1.3344 1.146e-05C0.98215 1.14558e-05 0.644215 0.139402 0.394398 0.387737Z" fill="white" />
                            </svg>
                        </button>`,
            customPaging: function(slider, i) {
                return (i + 1) + ' of ' + slider.slideCount;
            }
        });
    }

    // ajax Load More for apartments
    const loadMoreBtn = $('#apartments-load-more');
    const wrapper = $('#apartments-wrapper');
    const originalBtnText = loadMoreBtn.text();

    loadMoreBtn.on('click', function(e) {
        e.preventDefault();

        const currentPage = parseInt(wrapper.data('current-page'));
        const maxPages = parseInt(wrapper.data('max-pages'));
        const term = wrapper.data('term');
        const perPage = wrapper.data('per-page');
        
        if (currentPage >= maxPages || loadMoreBtn.hasClass('loading')) {
            return;
        }

        loadMoreBtn.addClass('loading');
        loadMoreBtn.prop('disabled', true);
        loadMoreBtn.text('Loading...');


        const nextPage = currentPage + 1;

        $.ajax({
            url: landingpad_vars.ajax_url,
            type: 'POST',
            data: {
                action: 'load_more_apartments',
                nonce: landingpad_vars.nonce,
                page: nextPage,
                term: term,
                per_page: perPage
            },
            success: function(response) {
                wrapper.append(response);

                wrapper.data('current-page', nextPage);

                loadMoreBtn.removeClass('loading');

                if (nextPage >= maxPages) {
                    $('.apartments__load-more').slideUp();
                } else {
                    loadMoreBtn.prop('disabled', false);
                    loadMoreBtn.text(originalBtnText);
                }
            },
            error: function(error) {
                console.log('Error loading apartments:', error);
                loadMoreBtn.removeClass('loading');
                loadMoreBtn.prop('disabled', false);
                loadMoreBtn.text(originalBtnText);
            }
        });
    });

    // Ajax Load More for Blog Posts
    const loadMoreBlogBtn = $('#load-more-btn');
    const blogWrapper = $('.blog-list__wrapper');
    const originalBlogBtnText = loadMoreBlogBtn.text();

    loadMoreBlogBtn.on('click', function(e) {
        e.preventDefault();

        const currentPage = parseInt(loadMoreBlogBtn.attr('data-current-page'));
        const maxPages = parseInt(loadMoreBlogBtn.attr('data-max-pages'));
        
        if (currentPage >= maxPages || loadMoreBlogBtn.hasClass('loading')) {
            return;
        }

        loadMoreBlogBtn.addClass('loading');
        loadMoreBlogBtn.prop('disabled', true);
        loadMoreBlogBtn.text('Loading...');

        const nextPage = currentPage + 1;

        $.ajax({
            url: landingpad_vars.ajax_url,
            type: 'POST',
            data: {
                action: 'load_more_posts',
                security: landingpad_vars.nonce,
                page: nextPage
            },
            success: function(response) {
                if (response) {
                    blogWrapper.append(response);

                    loadMoreBlogBtn.attr('data-current-page', nextPage);

                    loadMoreBlogBtn.removeClass('loading');

                    if (nextPage >= maxPages) {
                        loadMoreBlogBtn.parent().slideUp(); 
                        loadMoreBlogBtn.remove();
                    } else {
                        loadMoreBlogBtn.prop('disabled', false);
                        loadMoreBlogBtn.text(originalBlogBtnText);
                    }
                } else {
                    loadMoreBlogBtn.remove();
                }
            },
            error: function(error) {
                console.log('Error loading posts:', error);
                loadMoreBlogBtn.removeClass('loading');
                loadMoreBlogBtn.prop('disabled', false);
                loadMoreBlogBtn.text(originalBlogBtnText);
            }
        });
    });
});


// gallery ligtbox
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