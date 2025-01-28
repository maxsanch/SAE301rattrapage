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
    <link rel="stylesheet" media="(max-width: 1200px)" href="../styles/Tablette.css">
    <link rel="stylesheet" media="(max-width: 620px)" href="../styles/kgs.css">
    <link rel="stylesheet" media="(max-width: 620px)" href="../styles/styles_commun_mobile.css">
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
                        <input maxlength="30" type="text" name="prenom" required placeholder="Prénom">
                    </label>
                    <label>
                        <input maxlength="30" type="text" name="nom" required placeholder="Nom">
                    </label>
                </div>

                <!-- Champ pour l'email -->
                <label>
                    <input type="email" maxlength="50" name="email" required placeholder="Email">
                </label>

                <!-- Champs pour les mots de passe avec icône d'oeil pour afficher/masquer -->
                <label class="mdpconnex">
                    <input maxlength="50" type="password" name="MDP" class="motdepasse" required placeholder="Mot de passe">
                    <!-- Icône pour afficher/masquer le mot de passe -->
                    <div class="oeil oeilferme">
                        <img id="fermé" src="../img/oeilfermé.svg" alt="icone d'œil">
                    </div>
                </label>

                <!-- Champ pour confirmer le mot de passe -->
                <label class="mdpconnex">
                    <input type="password" maxlength="50" name="MDP2" class="motdepasse" required placeholder="Confirmer le mot de passe">
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
    <!-- Script JavaScript pour gérer l'affichage/masquage des mots de passe -->
    <script src="../js/oeil.js"></script>
</body>

</html>