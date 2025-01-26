<?php

// Détermine quel en-tête afficher en fonction du statut de l'utilisateur.
if ($user[0]['Statut'] == 'admin') {
    $header = HEADER_admin; // Si l'utilisateur est admin, on affiche l'en-tête admin.
} else {
    $header = HEADER_connecté; // Sinon, on affiche l'en-tête pour un utilisateur connecté.
}

$footer = Footer_connecté;

$contenu = ''; // Initialisation de la variable pour stocker le contenu dynamique des ruches.

// Vérifie s'il existe des ruches dans la variable $mesruches.
if (count($mesruches)) {
    // Si des ruches existent, on génère le contenu pour chaque ruche
    foreach ($mesruches as $ligne) {
        if (file_exists('img/imported/' . $ligne['ID_Ruches'] . '.jpg')) {
            $phototest = 'img/imported/' . $ligne['ID_Ruches'] . '.jpg';
        } else if (file_exists('img/imported/' . $ligne['ID_Ruches'] . '.png')) {
            $phototest = 'img/imported/' . $ligne['ID_Ruches'] . '.png';
        } else {
            // Image par défaut si aucune image spécifique n'est trouvée
            $phototest = 'img/imported/no_image_ruche.png';
        }
        // Construction du contenu à afficher pour chaque ruche
        $contenu .= '<div class="case"><a href="index.php?page=Photo_ruche&idRuche=' . $ligne['ID_Ruches'] . '" class="photo"><img src="../' . $phototest . '" alt=""></a><b>' . $ligne['nom'] . '</b><a class="bout" href="index.php?page=Ruches&jsruche=Ruche N°' . $ligne['ID_Ruches'] . '">Informations</a><a href="index.php?page=modif&ruche=' . $ligne['ID_Ruches'] . '" class="bout">Modifier</a><a href="index.php?page=suppression&ruche=' . $ligne['ID_Ruches'] . '" class="bout">Supprimer</a></div>';
    }
} else {
    // Si aucune ruche n'est enregistrée, un message est affiché.
    echo "<div class='reponse'>Aucune ruche enregistrée.</div>";
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion ruches</title>
    <link rel="stylesheet" href="../styles/styles_index_non_connecte.css">
    <link rel="stylesheet" href="../styles/GestionRuches.css">
    <link rel="stylesheet" media="(max-width: 620px)" href="../styles/styles_commun_mobile.css">
</head>

<body>
    <header>
        <!-- Affichage de l'en-tête dynamique selon le statut de l'utilisateur. -->
        <?= $header ?>
    </header>

    <div class="cache_fond"></div>
    <div class="pop_up_admin_demande">
        <div class="topinfo">
            <h2>Boite de récéption</h2>
            <img id="croixboite" src="../img/svgcroixrefus.svg" alt="croix fermeture">
        </div>
        <!-- Affichage des demandes de ruches administratives -->
        <?= $demandes_ruches ?>
    </div>

    <div class="titre_top_centre">
        <h1 class="titre_normal">Modification de la ruche n°<?= $_GET['ruche'] ?></h1>
    </div>

    <div class="grid_ajout_ruche">
        <form action="<?= $_SERVER['PHP_SELF'] . '?page=modifier&ruche=' . $_GET['ruche'] ?>" method="post">
            <h2>Modification de ruche</h2>
            <div class="ajout_ruches">
                <div class="nom_ruche">
                    <div>Nom de la ruche</div>
                    <input  type="text" maxlength="30" name="nomruche">
                </div>
            </div>
            <!-- Affichage des erreurs éventuelles lors de la modification. -->
            <?= $erreur ?>
            <button>Envoyer</button>
        </form>

        <div class="espace"></div>
        <!-- photo responsiv -->
        <div class="carte_ruche">
            <img sizes="(max-width: 1400px) 100vw, 1400px" srcset="
../img/sandy-millar-7O7xz_hOsjc-unsplash_qwr0ib_c_scale,w_200.jpg 200w,
../img/sandy-millar-7O7xz_hOsjc-unsplash_qwr0ib_c_scale,w_713.jpg 713w,
../img/sandy-millar-7O7xz_hOsjc-unsplash_qwr0ib_c_scale,w_1035.jpg 1035w,
../img/sandy-millar-7O7xz_hOsjc-unsplash_qwr0ib_c_scale,w_1342.jpg 1342w,
../img/sandy-millar-7O7xz_hOsjc-unsplash_qwr0ib_c_scale,w_1400.jpg 1400w"
                src="../img/sandy-millar-7O7xz_hOsjc-unsplash_qwr0ib_c_scale,w_1400.jpg" alt="fleure illustration">
        </div>
    </div>

    <div class="partie2">
        <div class="titre_top_centre">
            <h2>Gérer mes ruches</h2>
        </div>

        <div class="gridcentre">
            <!-- Affichage du contenu dynamique des ruches généré précédemment. -->
            <?= $contenu ?>
        </div>
    </div>

    <footer>
        <!-- Affichage du pied de page dynamique. -->
        <?= $footer ?>
    </footer>
    
    <script src="../js/script_commun_header.js"></script>
    <script>
        // Fonction JavaScript pour gérer des actions spécifiques sur les demandes d'administration et les éléments interactifs.

        <?= $fonctionadmin ?> // Inclut les fonctions administratives si l'utilisateur est admin.
        <?= $lenombre ?> // Affiche un nombre ou une valeur spécifique définie en PHP.

        // Initialisation de la carte avec Leaflet.
        var map = L.map('map').setView([51.505, -0.09], 13);

        // Ajout des tuiles OpenStreetMap sur la carte.
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        // Gestion des animations et transitions des éléments de la page pour la suppression des ruches.
        document.querySelectorAll('.case').forEach(e => {
            e.querySelector('.bout:last-child').addEventListener('click', () => {
                document.startViewTransition(() => {
                    // Animation de suppression des éléments.
                    e.style.transform = 'translateY(-100%)';
                    e.style.animation = 'test 0.7s linear';
                    e.style.transition = 'transform 0.7s';

                    setTimeout(() => e.remove(), 700);

                    e.nextElementSibling.style.transform = 'translateX(-100%) translateX(-20px)';
                    setTimeout(() => e.nextElementSibling.style.transform = 'translate(0)', 700);
                });
            });
        });
    </script>
</body>

</html>