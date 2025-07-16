// Add any JavaScript functionality here
// This file will be compiled with Laravel Mix
// This file is ready for your custom JavaScript.
// For example, you could add logic for a mobile navigation menu,
// scroll animations, or form handling.

document.addEventListener('DOMContentLoaded', function () {
    console.log('Ben Tito\'s portfolio site is loaded!');

    // Example: Smooth scrolling for anchor links in the header
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);

            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });
});