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
                
                <!-- Bouton pour soumettre le formulaire de connexion -->
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
    <script src="../js/script_commun_header.js"></script>
    <script>
        // Fonction pour afficher ou masquer le mot de passe
        document.querySelector('.oeil').addEventListener('click', show)
        
        function show(){
            // Vérifie si l'icône d'œil est fermée ou ouverte pour changer le type de champ mot de passe
            if(this.querySelector('img').id == "fermé"){
                document.querySelector('.motdepasse').type='text'  // Change le type en texte pour afficher le mot de passe
                this.querySelector('img').id= 'ouvert'
                this.querySelector('img').src= "../img/oeilouvert.svg";  // Change l'icône en œil ouvert
            }
            else{
                document.querySelector('.motdepasse').type='password'  // Rechange le type en mot de passe pour masquer
                this.querySelector('img').id= 'fermé'
                this.querySelector('img').src= "../img/oeilfermé.svg";  // Change l'icône en œil fermé
            }
            
            // Bascule les classes pour appliquer les styles correspondants à l'œil ouvert/fermé
            this.classList.toggle('oeilferme')
            this.classList.toggle('oeilouvert')
        }
    </script>
</body>

</html>