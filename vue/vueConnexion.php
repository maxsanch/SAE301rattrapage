<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/connexion.css">
    <title>Page connexion</title>

</head>

<body>
    <div class="back">
        <div class="photo">

        </div>
        <form action="<?= $_SERVER['PHP_SELF'] . '?page=login' ?>" method="post">
            <div class="connectez">Connectez-vous</div>
            <div class="epc">
                <label>
                    <input type="email" name="email" required placeholder="Email">
                </label>
                <label class="mdpconnex">
                    <input type="password" name="MDP" class="motdepasse" required placeholder="Mot de passe">
                    <div class="oeil oeilferme">
                        <img id="fermé" src="../img/oeilfermé.svg" alt="icone d'oeil">
                    </div>
                </label>
                <button>Me connecter</button>
                <?= $erreur ?>
                <hr>
                <div class="inscription">
                    <div>Vous n'avez pas de compte ? <a
                            href="index.php?page=Inscription"><span>Inscrivez-vous</span></a>
                    </div>
                </div>
            </div>

        </form>
    </div>
    <script>
        document.querySelector('.oeil').addEventListener('click', show)
        function show(){
            if(this.querySelector('img').id == "fermé"){
                document.querySelector('.motdepasse').type='text'
                this.querySelector('img').id= 'ouvert'
                this.querySelector('img').src= "../img/oeilouvert.svg";
            }
            else{
                document.querySelector('.motdepasse').type='password'
                this.querySelector('img').id= 'fermé'
                this.querySelector('img').src= "../img/oeilfermé.svg";
            }
            
            this.classList.toggle('oeilferme')
            this.classList.toggle('oeilouvert')
        }

    </script>
</body>

</html>