<!DOCTYPE html>
<html lang="fr">

<head>
    <!-- Déclaration de l'encodage des caractères et de la vue sur les appareils mobiles -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Titre de la page -->
    <title>Page d'inscription</title>
    <!-- Lien vers la feuille de style CSS pour la mise en forme de la page -->
    <link rel="stylesheet" href="../styles/connexion.css">
    <link rel="stylesheet" media="(max-width: 620px)" href="../styles/kgs.css">
</head>

<body>
    <!-- Conteneur principal de la page d'inscription -->
    <div class="back">
        <div class="photo">
            <!-- Section photo (peut-être utilisée pour un arrière-plan ou une image décorative) -->
        </div>

        <!-- Formulaire d'inscription avec méthode POST pour envoyer les données -->
        <form action="<?= $_SERVER['PHP_SELF'] . '?page=signin' ?>" method="post">
            <div class="connectez">Inscrivez-vous</div>

            <div class="epc">
                <div class="civil">
                    <!-- Champs pour le prénom et le nom -->
                    <label>
                        <input type="text" name="prenom" required placeholder="Prénom">
                    </label>
                    <label>
                        <input type="text" name="nom" required placeholder="Nom">
                    </label>
                </div>

                <!-- Champ pour l'email -->
                <label>
                    <input type="email" name="email" required placeholder="Email">
                </label>

                <!-- Champs pour les mots de passe avec icône d'œil pour afficher/masquer -->
                <label class="mdpconnex">
                    <input type="password" name="MDP" class="motdepasse" required placeholder="Mot de passe">
                    <!-- Icône pour afficher/masquer le mot de passe -->
                    <div class="oeil oeilferme">
                        <img id="fermé" src="../img/oeilfermé.svg" alt="icone d'œil">
                    </div>
                </label>

                <!-- Champ pour confirmer le mot de passe -->
                <label class="mdpconnex">
                    <input type="password" name="MDP2" class="motdepasse" required placeholder="Confirmer le mot de passe">
                    <!-- Icône pour afficher/masquer le mot de passe -->
                    <div class="oeil oeilferme">
                        <img id="fermé" src="../img/oeilfermé.svg" alt="icone d'œil">
                    </div>
                </label>
            </div>

            <!-- Affichage des erreurs s'il y en a (variable PHP) -->
            <?= $erreur ?>

            <!-- Bouton pour soumettre le formulaire -->
            <button>Créer mon compte</button>

            <hr>

            <!-- Lien vers la page de connexion si l'utilisateur a déjà un compte -->
            <div class="inscription">
                <div>Vous avez déjà un compte ? <a href="index.php?page=Connexion"><span>Connectez-vous</span></a></div>
            </div>
        </form>
    </div>
    <script src="../js/script_commun_header.js"></script>
    <!-- Script JavaScript pour gérer l'affichage/masquage des mots de passe -->
     
    <script>
        // Sélectionner tous les éléments avec la classe 'oeil' et ajouter un événement au clic
        document.querySelectorAll('.oeil').forEach(e => {
            e.addEventListener('click', show)

            // Fonction qui gère l'affichage ou le masquage du mot de passe
            function show() {
                // Vérifier si l'icône est fermée (mot de passe masqué)
                if (this.querySelector('img').id == "fermé") {
                    // Changer le type de champ en texte pour afficher le mot de passe
                    e.parentElement.querySelector('.motdepasse').type = 'text'
                    // Changer l'icône pour l'œil ouvert
                    this.querySelector('img').id = 'ouvert'
                    this.querySelector('img').src = "../img/oeilouvert.svg";
                }
                else {
                    // Masquer le mot de passe en changeant le type du champ
                    e.parentElement.querySelector('.motdepasse').type = 'password'
                    // Changer l'icône pour l'œil fermé
                    this.querySelector('img').id = 'fermé'
                    this.querySelector('img').src = "../img/oeilfermé.svg";
                }

                // Basculer les classes pour changer le style (fermé / ouvert)
                this.classList.toggle('oeilferme')
                this.classList.toggle('oeilouvert')
            }
        })
    </script>
</body>

</html>