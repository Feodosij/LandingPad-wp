import $ from 'jquery';

// ajax Load More for apartments
export function initApartmentLoader() {
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
} 

// Ajax Load More for Blog Posts
export function initBlogLoader() {
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
}

