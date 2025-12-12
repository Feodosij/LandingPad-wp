
// default open one accordion
export function initAccordion() {
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