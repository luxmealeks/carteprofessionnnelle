// Sidebar toggle for mobile

import './bootstrap';


document.addEventListener('DOMContentLoaded', function() {
    const navbarToggler = document.querySelector('.navbar-toggler');
    const sidebar = document.querySelector('.sidebar');

    if (navbarToggler && sidebar) {
        navbarToggler.addEventListener('click', function() {
            sidebar.classList.toggle('show');
        });
    }

    // Close sidebar when clicking outside
    document.addEventListener('click', function(event) {
        if (!sidebar.contains(event.target) && !navbarToggler.contains(event.target)) {
            sidebar.classList.remove('show');
        }
    });
});