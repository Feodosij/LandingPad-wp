
// table of content
export function initTableOfContent() {
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
}