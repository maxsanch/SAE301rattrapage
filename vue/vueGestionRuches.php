<?php

if ($user[0]['Statut'] == 'admin') {

    $header = HEADER_admin;
} else {
    $header = HEADER_connecté;
}


$footer = Footer_déconnecté;

$contenu = '';

if (file_exists('img/imported/' . $user[0]['Id_utilisateur'] . '.jpg')) {
    $photo = 'img/imported/' .$user[0]['Id_utilisateur']. '.jpg';
    // Si l'image existe, l'affiche
} else if (file_exists('img/imported/' .$user[0]['Id_utilisateur']. '.png')) {
    $photo = 'img/imported/' .$user[0]['Id_utilisateur']. '.png';
} else {
    // Sinon, affiche une image par défaut
    $photo = 'img/imported/no-user-image.jpg';
}

if (count($mesruches)) {
    // Affichage des lignes du tableau


    foreach ($mesruches as $ligne) {
        if (file_exists('img/imported/' . $ligne['ID_Ruches'] . '.jpg')) {
            $phototest = 'img/imported/' . $ligne['ID_Ruches'] . '.jpg';
            // Si l'image existe, l'affiche
        } else if (file_exists('img/imported/' . $ligne['ID_Ruches'] . '.png')) {
            $phototest = 'img/imported/' . $ligne['ID_Ruches'] . '.png';
        } else {
            // Sinon, affiche une image par défaut
            $phototest = 'img/imported/no_image_ruche.png';
        }
        $contenu .= '<div class="case"><a href="index.php?page=Photo_ruche&idRuche=' . $ligne['ID_Ruches'] . '" class="photo"><img src="../' . $phototest . '" alt=""></a><b>' . $ligne['nom'] . '</b><a class="bout" href="index.php?page=Ruches&jsruche=Ruche N°'.$ligne['ID_Ruches'].'">Informations</a><a href="index.php?page=modif&ruche=' . $ligne['ID_Ruches'] . '" class="bout">Modifier</a><a href="index.php?page=suppression&ruche=' . $ligne['ID_Ruches'] . '" class="bout">Supprimer</a></div>';
    }
} else
    echo "<div class='reponse'>Aucune ruche enregistrée.</div>";

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion ruches</title>

    <link rel="stylesheet" media="(min-width: 620px)" href="../styles/styles_index_non_connecte.css">
    <link rel="stylesheet" href="../styles/styles_commun_mobile.css">
    <link rel="stylesheet" href="../styles/GestionRuches.css">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
</head>

<body>
    <header>
        <?= $header ?>
    </header>

    <div class="titre_top_centre">
        <h1 class="titre_normal">Gestion des ruches</h1>
    </div>

    <div class="grid_ajout_ruche">
        <form action="<?= $_SERVER['PHP_SELF'] . '?page=ajoutRuche' ?>" method="post">
            <h2>Ajout de ruche</h2>
            <div class="ajout_ruches">
                <div class="nom_ruche">
                    <div>Nom de la ruche</div>
                    <input type="text" name="nomruche">
                </div>
                <div class="ID_appareil">
                    <div>ID de l'appareil</div>
                    <input type="number" name="id_ruche">
                </div>
            </div>
            <?= $erreur1 ?>
            <button>Envoyer</button>
        </form>
        <div class="espace">

        </div>
        <div class="carte_ruche">
            <div id="map"></div>
        </div>
    </div>
    <div class="partie2">
        <div class="titre_top_centre">
            <h2>Gérer mes ruches</h2>
        </div>

        <div class="gridcentre">
            <?= $contenu ?>
        </div>
    </div>

    <div class="grid_ajout_ruche">
        <div class="carte_ruche">
            <!-- mettre une image ici -->
            <div></div>
        </div>
        <div class="parentdoubleFormulaire">
            <div class="profile_picture">
                <img src="../<?= $photo ?>" alt="photo de profile">
                <form method="post" action="index.php?page=changeprofilepicture&idUser=<?= $user[0]['Id_utilisateur'] ?>" enctype="multipart/form-data">
                    <h2>Photo de profile</h2>
                    <div class="form_elt">
                        <input type="hidden" name="MAX_FILE_SIZE" value="500000">
                        <input type="file" class="texte" name="photoUser" accept="image/jpeg, image/png">
                    </div>
                    <?= $erreur2 ?>
                    <input type="submit" class="valid" name="ok" value="Valider">
                </form>
            </div>

            <form action="<?= $_SERVER['PHP_SELF'] . '?page=modifprofil&idUser='.$user[0]['Id_utilisateur'] ?>" method="post">
                <h2>Mes informations</h2>
                <div class="ajout_ruches">
                    <div class="nom_ruche">
                        <label>Nom</label>
                        <input type="text" name="nomuser" value="<?= $user[0]['Nom'] ?>" required>
                        <label>Prenom</label>
                        <input type="text" name="prenomuser" value="<?= $user[0]['Prenom'] ?>" required>
                    </div>
                    <div class="email">
                        <div>Mon adresse mail : <?= $user[0]['Mail'] ?> </div>
                    </div>
                    <div class="mdp">
                        <div>Changer de mot de passe</div>
                        <label>Nouveau mot de passe</label>
                        <input type="password" name="NewPassword" placeholder="entrez votre nouveau mot de passe">
                        <label>Confirmez le mot de passe</label>
                        <input type="password" name="ConfirmationNewPassword"
                            placeholder="confirmez votre mot de passe">
                    </div>
                    <div class="validation">
                        <div>Pour enregistrer les modifications, vous devez entrer votre mot de passe</div>
                        <input type="password" name="ancienmdp" placeholder="entrez votre mot de passe">
                    </div>
                </div>
                <?= $erreur3 ?>
                <button>Modifier</button>
            </form>
        </div>

        <div class="espace">

        </div>

    </div>


    <footer>
        <?= $footer ?>
    </footer>

    <script>
        var map = L.map('map').setView([51.505, -0.09], 13);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        document.querySelectorAll('.case').forEach(e => {
            e.querySelector('.bout:last-child').addEventListener('click', () => {
                document.startViewTransition(() => {
                    e.style.transform = 'translateY(-100%)';
                    e.style.animation = 'test 0.7s linear'
                    e.style.transition = 'transform 0.7s';

                    setTimeout(() => e.remove(), 700);

                    e.nextElementSibling.style.transform = 'translateX(-100%) translateX(-20px)'
                    setTimeout(() => e.nextElementSibling.style.transform = 'translate(0)', 700);

                });
            });
        });
    </script>
</body>

</html>