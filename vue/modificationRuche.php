<?php

if($user[0]['Statut'] == 'admin'){
    
    $header = HEADER_admin;
}
else{
    $header = HEADER_connecté;
}

$footer = Footer_déconnecté;

$contenu = '';

if (count($mesruches)) {
    // Affichage des lignes du tableau
        foreach ($mesruches as $ligne) {
            var_dump($ligne);
            $contenu .= '<div class="case"><div class="photo"><img src="../img/Ruches.jpg" alt=""></div><b>'.$ligne['nom'].'</b><a class="bout" href="index.php?page=Ruches&jsruche=Ruche N°'.$ligne['ID_Ruches'].'">Informations</a><a href="index.php?page=modif&ruche='.$ligne['ID_Ruches'].'" class="bout">Modifier</a><a href="index.php?page=suppression&ruche='.$ligne['ID_Ruches'].'" class="bout">Supprimer</a></div>';
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
        <h1 class="titre_normal">Modification de la ruche n°<?= $_GET['ruche'] ?></h1>
    </div>

    <div class="grid_ajout_ruche">
        <form action="<?= $_SERVER['PHP_SELF'] . '?page=modifier&ruche=' .$_GET['ruche']  ?>" method="post">
            <h2>Modification de ruche</h2>
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
            <div class="infosuite">
                <p>Localisation de la ruche (cliquez sur la carte pour placer)</p>
                <div class="minigrid">
                    <div class="long">
                        <label class="longitude">
                            Longitude
                        </label>
                        <input type="text" name="longitude">
                    </div>
                    <div class="lat">
                        <label class="longitude">
                            Latitude
                        </label>
                        <input type="text" name="latitude">
                    </div>
                    <div class="espace">

                    </div>
                </div>
                <?= $erreur ?>
            </div>

            <div class="localisation">
                <p>Vous possédez un traceur GPS ? Localisez la ruche !</p>
                <div class="boutons">
                    <a class="loc">
                        Localiser
                    </a>
                    <input type="submit" value="Ajouter">
                    </input>
                </div>
            </div>
        </form>
        <div class="espace">

        </div>
        <div class="carte_ruche">
            <div id="map"></div>
        </div>
        </form>
    </div>
    <div class="partie2">
        <div class="titre_top_centre">
            <h2>Gérer mes ruches</h2>
        </div>

        <div class="gridcentre">
            <?= $contenu ?>
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