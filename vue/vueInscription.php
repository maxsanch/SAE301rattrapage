<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'inscription</title>
    <link rel="stylesheet" href="../styles/connexion.css">
</head>

<body>
    <div class="back">
        <div class="photo">

        </div>
        <form action="<?= $_SERVER['PHP_SELF'] . '?page=signin' ?>" method="post">
            <div class="connectez">Inscrivez-vous</div>
            <div class="epc">
                <div class="civil"><label>
                        <input type="text" name="prenom" required placeholder="Prénom">
                    </label>
                    <label>
                        <input type="text" name="nom" required placeholder="Nom">
                    </label>
                </div>

                <label>
                    <input type="email" name="email" required placeholder="Email">
                </label>
                <label>
                    <input type="password" name="MDP" required placeholder="Mot de passe">
                </label>
                <label>
                    <input type="password" name="MDP2" required placeholder="Confirmer le mot de passe">
                </label>
            </div>

            <label class="cookie">
                <input type="Checkbox" name="accepter" value="oui">
                <span>Accepter les conditions d'utilisation</span>
            </label>
            <?= $erreur ?>
            <button>Créer mon compte</button>
            <hr>
            <div class="inscription">
                <div>Vous avez déjà un compte ? <a href="index.php?page=Connexion"><span>Connectez-vous</span></a></div>
            </div>
        </form>
    </div>

</body>

</html>