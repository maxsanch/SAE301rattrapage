<?php

if ($user[0]['Statut'] == 'admin') {
    $header = HEADER_admin;
} else {
    $header = HEADER_connecté;
}


$footer = Footer_déconnecté;

$contenu = '';

if (file_exists('img/imported/' . $user[0]['Id_utilisateur'] . '.jpg')) {
    $photo = 'img/imported/' . $user[0]['Id_utilisateur'] . '.jpg';
    // Si l'image existe, l'affiche
} else if (file_exists('img/imported/' . $user[0]['Id_utilisateur'] . '.png')) {
    $photo = 'img/imported/' . $user[0]['Id_utilisateur'] . '.png';
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
        $contenu .= '<div class="case"><a href="index.php?page=Photo_ruche&idRuche=' . $ligne['ID_Ruches'] . '" class="photo"><img src="../' . $phototest . '" alt=""></a><b>' . $ligne['nom'] . '</b><a class="bout" href="index.php?page=Ruches&jsruche=Ruche N°' . $ligne['ID_Ruches'] . '">Informations</a><a href="index.php?page=modif&ruche=' . $ligne['ID_Ruches'] . '" class="bout">Modifier</a><a href="index.php?page=suppression&ruche=' . $ligne['ID_Ruches'] . '" class="bout">Supprimer</a></div>';
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

    <link rel="stylesheet" href="../styles/styles_index_non_connecte.css">
    <link rel="stylesheet" media="(max-width: 620px)" href="../styles/styles_commun_mobile.css">
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

    <div class="cache_fond">

    </div>
    <div class="pop_up_admin_demande">
        <div class="topinfo">
            <h2>Boite de récéption</h2>
            <img id="croixboite" src="../img/svgcroixrefus.svg" alt="croix fermeture">
        </div>
        <?= $demandes_ruches ?>
    </div>

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
            <?= $contenu ?>
        </div>
    </div>

    <div class="grid_ajout_user">
        <div class="photo">
            <img src="../<?= $photo ?>" alt="photo de profile">
        </div>
        <div class="parentdoubleFormulaire">
            <div class="profile_picture">
                <form method="post" class="photoprofil"
                    action="index.php?page=changeprofilepicture&prevpage=gestionruche&idUser=<?= $user[0]['Id_utilisateur'] ?>"
                    enctype="multipart/form-data">
                    <h2>Photo de profile</h2>
                    <div class="form_elt">
                        <input type="hidden" name="MAX_FILE_SIZE" value="500000">
                        <label class="file-upload">
                            <span class="orange">Ajoutez</span><span> votre fichier ici</span>
                            <input id="photoUser" type="file" name="photoUser" accept="image/jpeg, image/png" hidden>
                        </label>
                        <input type="submit" class="valid" name="ok" value="Valider">
                    </div>
                    <?= $erreur2 ?>
                </form>
            </div>
            <main>
                
            </main>
            <form action="<?= $_SERVER['PHP_SELF'] . '?page=modifprofil&idUser=' . $user[0]['Id_utilisateur'] ?>"
                method="post">
                <h2>Mes informations</h2>
                <div class="ajout_ruches">
                    <div class="nom_ruche">
                        <label>
                            <p>Nom</p><input type="text" name="nomuser" value="<?= $user[0]['Nom'] ?>" required>
                        </label>
                        <label>
                            <p>Prenom</p><input type="text" name="prenomuser" value="<?= $user[0]['Prenom'] ?>"
                                required>
                        </label>
                        <label>
                            <p>E-mail</p><input type="text" name="prenomuser" value="<?= $user[0]['Mail'] ?>" required
                                disabled>
                        </label>
                    </div>
                    <div class="mdp">
                        <div><b>Changer de mot de passe</b></div>
                        <label>
                            <p>Nouveau mot de passe</p> <input type="password" name="NewPassword"
                                placeholder="entrez votre nouveau mot de passe">
                        </label>

                        <label>
                            <p>Confirmez le mot de passe</p><input type="password" name="ConfirmationNewPassword"
                                placeholder="confirmez votre mot de passe">
                        </label>

                    </div>
                    <div class="validation">
                        <label>
                            <p>Pour enregistrer les modifications, vous devez entrer votre mot de passe</p><input
                                type="password" name="ancienmdp" placeholder="entrez votre mot de passe">
                        </label>
                    </div>
                </div>
                <?= $erreur3 ?>
                <button>Modifier</button>
            </form>
        </div>
    </div>


    <footer>
        <?= $footer ?>
    </footer>

    <script>

        <?= $fonctionadmin ?>
        <?= $lenombre ?>

        var map = L.map('map').setView([51.505, -0.09], 13);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        document.querySelectorAll('.case').forEach(e => {
            e.querySelector('.bout:last-child').addEventListener('click', (event) => {
                event.preventDefault()
                e.classList.add('deletruche')

                setTimeout(removecase, 550)

                function removecase() {
                    window.location = e.querySelector('.bout:last-child').href
                }
            });
        });
    </script>
</body>

</html>