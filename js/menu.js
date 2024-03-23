document.addEventListener('DOMContentLoaded', function() {
    var menuButton = document.querySelector('.menu');
    var closeButton = document.querySelector('.close');
    var menuPage = document.querySelectorAll('.liens');
    var navbar = document.querySelector('.navbar');
    var container = document.querySelector('.container');
    var contentR = document.querySelector('.content_right');
    var contentL = document.querySelector('.content_left');
    var liens = document.querySelector('.liens');
    var pages = document.querySelector('.pages');

    menuButton.addEventListener('click', function() {
        navbar.classList.add('navbar_mobile');
        container.classList.add('container_mobile');
        contentR.classList.add('content_right_mobile');
        contentL.classList.add('content_left_mobile');
        liens.classList.add('liens_mobile');
        pages.classList.add('pages_mobile');

        menuButton.style.display = 'none';
        closeButton.style.display = 'flex';
        menuPage.forEach(function(page) {
            page.style.display = 'flex';
        });  
    });

    closeButton.addEventListener('click', function() {
        navbar.classList.remove('navbar_mobile');
        container.classList.remove('container_mobile');
        contentR.classList.remove('content_right_mobile');
        contentL.classList.remove('content_left_mobile');
        liens.classList.remove('liens_mobile');
        pages.classList.remove('pages_mobile');

        menuPage.forEach(function(page) {
            page.style.display = 'none';
        });
        closeButton.style.display = 'none';
        menuButton.style.display = 'flex';
    });
});