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
                <label class="mdpconnex">
                    <input type="password" name="MDP" class="motdepasse" required placeholder="Mot de passe">
                    <div class="oeil oeilferme">
                        <img id="fermé" src="../img/oeilfermé.svg" alt="icone d'oeil">
                    </div>
                </label>
                <label class="mdpconnex">
                    <input type="password" name="MDP2" class="motdepasse" required placeholder="Confirmer le mot de passe">
                    <div class="oeil oeilferme">
                        <img id="fermé" src="../img/oeilfermé.svg" alt="icone d'oeil">
                    </div>
                </label>
            </div>
            <?= $erreur ?>
            <button>Créer mon compte</button>
            <hr>
            <div class="inscription">
                <div>Vous avez déjà un compte ? <a href="index.php?page=Connexion"><span>Connectez-vous</span></a></div>
            </div>
        </form>
    </div>
    <script>
        document.querySelectorAll('.oeil').forEach(e => {
            e.addEventListener('click', show)
            function show() {
                if (this.querySelector('img').id == "fermé") {
                    e.parentElement.querySelector('.motdepasse').type = 'text'
                    this.querySelector('img').id = 'ouvert'
                    this.querySelector('img').src = "../img/oeilouvert.svg";
                }
                else {
                    e.parentElement.querySelector('.motdepasse').type = 'password'
                    this.querySelector('img').id = 'fermé'
                    this.querySelector('img').src = "../img/oeilfermé.svg";
                }

                this.classList.toggle('oeilferme')
                this.classList.toggle('oeilouvert')
            }
        })
    </script>
</body>

</html>