// public/js/admin.js
document.addEventListener('DOMContentLoaded', function () {
    // Example: Toggle sidebar visibility on small screens
    const toggleButton = document.querySelector('.sidebar-toggle');
    const sidebar = document.querySelector('.sidebar');

    if (toggleButton) {
        toggleButton.addEventListener('click', function () {
            sidebar.classList.toggle('collapsed');
        });
    }
});
