
document.addEventListener('DOMContentLoaded', function() {
    var loupeButton = document.querySelector('.rechercher input');

    loupeButton.addEventListener('click', function() {
        form.style.display = 'flex';
        loupeButton.style.display = 'none';
    });

    closeButton.addEventListener('click', function() {
        form.style.display = 'none';
    });
});