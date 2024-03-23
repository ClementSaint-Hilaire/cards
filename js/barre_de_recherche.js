
document.addEventListener('DOMContentLoaded', function() {
    var loupeButton = document.querySelector('.loupe');
    var closeButton = document.querySelector('.close');
    var form = document.querySelector('.rechercher');

    loupeButton.addEventListener('click', function() {
        form.style.display = 'flex';
        loupeButton.style.display = 'none';
    });

    closeButton.addEventListener('click', function() {
        form.style.display = 'none';
    });
});

document.addEventListener('DOMContentLoaded', function() {
var loupeButton = document.querySelector('.loupe');
var closeButton = document.querySelector('.close');
var form = document.querySelector('.rechercher');
var input = form.querySelector('input[type="text"]'); // Sélectionner l'élément d'entrée de texte

// Ecouter les événements clavier
document.addEventListener('keydown', function(event) {
    // Vérifier si Ctrl et K sont pressés simultanément
    if (event.ctrlKey && event.key === 'k') {
        // Empêcher l'action par défaut du navigateur
        event.preventDefault();
        // Déclencher le clic sur le bouton de la loupe
        loupeButton.click();
        // Mettre le focus sur l'élément d'entrée de texte
        input.focus();
    }
});

loupeButton.addEventListener('click', function() {
    form.style.display = 'flex';
    loupeButton.style.display = 'none';
    input.focus(); // Mettre également le focus sur l'élément d'entrée de texte lorsque la loupe est cliquée
});

closeButton.addEventListener('click', function() {
    form.style.display = 'none';
});
});

