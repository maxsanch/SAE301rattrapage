// Sélectionner tous les éléments avec la classe 'oeil' et ajouter un événement au clic
document.querySelectorAll('.oeil').forEach(e => {
    e.addEventListener('click', show)

    // Fonction qui gère l'affichage ou le masquage du mot de passe
    function show() {
        // Vérifier si l'icône est fermée (mot de passe masqué)
        if (this.querySelector('img').id == "fermé") {
            // Changer le type de champ en texte pour afficher le mot de passe
            e.parentElement.querySelector('.motdepasse').type = 'text'
            // Changer l'icône pour l'oeil ouvert
            this.querySelector('img').id = 'ouvert'
            this.querySelector('img').src = "../img/oeilouvert.svg";
        }
        else {
            // Masquer le mot de passe en changeant le type du champ
            e.parentElement.querySelector('.motdepasse').type = 'password'
            // Changer l'icône pour l'oeil fermé
            this.querySelector('img').id = 'fermé'
            this.querySelector('img').src = "../img/oeilfermé.svg";
        }

        // Basculer les classes pour changer le style (fermé / ouvert)
        this.classList.toggle('oeilferme')
        this.classList.toggle('oeilouvert')
    }
})