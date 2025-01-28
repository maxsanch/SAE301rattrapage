<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/connexion.css">
    <link rel="stylesheet" media="(max-width: 620px)" href="../styles/kgs.css">
    <link rel="stylesheet" media="(max-width: 620px)" href="../styles/styles_commun_mobile.css">

    <title>Page connexion</title>
</head>

<body>
    <div class="back">
        <!-- Section d'arrière-plan (image de fond) -->
        <div class="photo">
            <!-- Contenu d'image ici (possiblement vide ou dynamique) -->
        </div>
        
        <!-- Formulaire de connexion -->
        <form action="<?= $_SERVER['PHP_SELF'] . '?page=login' ?>" method="post">
            <div class="connectez">Connectez-vous</div>
            <div class="epc">
                <!-- Champ pour l'email -->
                <label>
                    <input type="email" maxlength="50" name="email" required placeholder="Email">
                </label>
                
                <!-- Champ pour le mot de passe avec l'option d'afficher ou de masquer le mot de passe -->
                <label class="mdpconnex">
                    <input type="password" maxlength="50" name="MDP" class="motdepasse" required placeholder="Mot de passe">
                    <!-- Icône pour afficher/masquer le mot de passe -->
                    <div class="oeil oeilferme">
                        <img id="fermé" src="../img/oeilfermé.svg" alt="icone d'oeil">
                    </div>
                </label>
                
                <!-- Bouton -->
                <button>Me connecter</button>
                
                <!-- Affichage des erreurs, si présentes -->
                <?= $erreur ?>
                <hr>
                
                <!-- Lien vers la page d'inscription pour les nouveaux utilisateurs -->
                <div class="inscription">
                    <div>Vous n'avez pas de compte ? <a href="index.php?page=Inscription"><span>Inscrivez-vous</span></a>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script src="../js/oeil.js"></script>
</body>

</html>