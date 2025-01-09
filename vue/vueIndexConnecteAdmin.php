<?php
$header = HEADER_admin;
$footer = Footer_connecté;


$contenu = '';

if (count($GetAllUser)) {

    if (count($GetAllUser) > 3) {
        $lesruches1 = rucheSingleUser($GetAllUser[count($GetAllUser) - 1]['Id_utilisateur']);
        $lesruches2 = rucheSingleUser($GetAllUser[count($GetAllUser) - 2]['Id_utilisateur']);
        $lesruches3 = rucheSingleUser($GetAllUser[count($GetAllUser) - 3]['Id_utilisateur']);
        if (file_exists('img/imported/' . $GetAllUser[count($GetAllUser) - 1]['Id_utilisateur'] . '.jpg')) {
            $phototest1 = 'img/imported/' . $GetAllUser[count($GetAllUser) - 1]['Id_utilisateur'] . '.jpg';
            // Si l'image existe, l'affiche
        } else if (file_exists('img/imported/' . $GetAllUser[count($GetAllUser) - 1]['Id_utilisateur'] . '.png')) {
            $phototest1 = 'img/imported/' . $GetAllUser[count($GetAllUser) - 1]['Id_utilisateur'] . '.png';
        } else {
            // Sinon, affiche une image par défaut
            $phototest1 = 'img/imported/no-user-image.jpg';
        }
        if (file_exists('img/imported/' . $GetAllUser[count($GetAllUser) - 2]['Id_utilisateur'] . '.jpg')) {
            $phototest2 = 'img/imported/' . $GetAllUser[count($GetAllUser) - 2]['Id_utilisateur'] . '.jpg';
            // Si l'image existe, l'affiche
        } else if (file_exists('img/imported/' . $GetAllUser[count($GetAllUser) - 2]['Id_utilisateur'] . '.png')) {
            $phototest2 = 'img/imported/' . $GetAllUser[count($GetAllUser) - 2]['Id_utilisateur'] . '.png';
        } else {
            // Sinon, affiche une image par défaut
            $phototest2 = 'img/imported/no-user-image.jpg';
        }
        if (file_exists('img/imported/' . $GetAllUser[count($GetAllUser) - 3]['Id_utilisateur'] . '.jpg')) {
            $phototest3 = 'img/imported/' . $GetAllUser[count($GetAllUser) - 3]['Id_utilisateur'] . '.jpg';
            // Si l'image existe, l'affiche
        } else if (file_exists('img/imported/' . $GetAllUser[count($GetAllUser) - 3]['Id_utilisateur'] . '.png')) {
            $phototest3 = 'img/imported/' . $GetAllUser[count($GetAllUser) - 3]['Id_utilisateur'] . '.png';
        } else {
            // Sinon, affiche une image par défaut
            $phototest3 = 'img/imported/no-user-image.jpg';
        }
        $contenu .= "<div class='ContourRuche'><div class='UneRuche'><img class='ImageDeLaRuche' src='../$phototest1' alt='Tes ruches'><div class='MaRucheTitre'>" . $GetAllUser[count($GetAllUser) - 1]['Prenom'] . "</div><div class='InfoRuche'>dernière connexion : " . $GetAllUser[count($GetAllUser) - 1]['connexion'] . "</div><div class='InfoRuche'>Nombre de ruches : " . count($lesruches1) . "</div><a href='index.php?page=informationsUser&idUser=" . $GetAllUser[count($GetAllUser) - 1]['Id_utilisateur'] . "' class='MaRucheBouton'>Informations</a></div></div><div class='ContourRuche'><div class='UneRuche'><img class='ImageDeLaRuche' src='../$phototest2' alt='Tes ruches'><div class='MaRucheTitre'>" . $GetAllUser[count($GetAllUser) - 2]['Prenom'] . "</div><div class='InfoRuche'>dernière connexion : " . $GetAllUser[count($GetAllUser) - 2]['connexion'] . "</div><div class='InfoRuche'>Nombre de ruches : " . count($lesruches2) . "</div><a href='index.php?page=informationsUser&idUser=" . $GetAllUser[count($GetAllUser) - 2]['Id_utilisateur'] . "' class='MaRucheBouton'>Informations</a></div></div><div class='ContourRuche'><div class='UneRuche'><img class='ImageDeLaRuche' src='../$phototest3' alt='Tes ruches'><div class='MaRucheTitre'>" . $GetAllUser[count($GetAllUser) - 3]['Prenom'] . "</div><div class='InfoRuche'>dernière connexion : " . $GetAllUser[count($GetAllUser) - 3]['connexion'] . "</div><div class='InfoRuche'>Nombre de ruches : " . count($lesruches3) . "</div><a href='index.php?page=informationsUser&idUser=" . $GetAllUser[count($GetAllUser) - 3]['Id_utilisateur'] . "' class='MaRucheBouton'>Informations</a></div></div>";
    } else {
        // Affichage des lignes du tableau
        foreach ($GetAllUser as $ligne) {
            if (file_exists('img/imported/' . $ligne['Id_utilisateur'] . '.jpg')) {
                $phototest = 'img/imported/' . $ligne['Id_utilisateur'] . '.jpg';
                // Si l'image existe, l'affiche
            } else if (file_exists('img/imported/' . $ligne['Id_utilisateur'] . '.png')) {
                $phototest = 'img/imported/' . $ligne['Id_utilisateur'] . '.png';
            } else {
                // Sinon, affiche une image par défaut
                $phototest = 'img/imported/no-user-image.jpg';
            }
            $lesruches = rucheSingleUser($ligne['Id_utilisateur']);
            $contenu .= "<div class='ContourRuche'><div class='UneRuche'><img class='ImageDeLaRuche' src='../$phototest' alt='Tes ruches'><div class='MaRucheTitre'>" . $ligne['Prenom'] . "</div><div class='InfoRuche'>dernière connexion : " . $ligne['connexion'] . "</div><div class='InfoRuche'>Nombre de ruches : " . count($lesruches) . "</div><a href='index.php?page=informationsUser&idUser=" . $ligne['Id_utilisateur'] . "' class='MaRucheBouton'>Informations</a></div></div>";
        }
    }
} else
    echo "<div class='reponse'>Aucun Utilisateur n'est enregistré</div>";


$contenu2 = '';
$markers = '';

$mapcenter = "var map = L.map('map').setView([50, 50], 13);";

if (count($getruche)) {
    
    $i = $getruche[0]["ID_Ruches"];
    if (isset($ruches->$i)) {
        if (count($getruche) > 3) {
            $i = $getruche[count($getruche) - 1]["ID_Ruches"];
            $i2 = $getruche[count($getruche) - 2]["ID_Ruches"];
            $i3 = $getruche[count($getruche) - 3]["ID_Ruches"];
            $contenu2 .= '<div class="ContourRuche"><div class="UneRuche"><img class="ImageDeLaRuche" src="../img/TesRuches.png" alt="Tes ruches"><div class="MaRucheTitre">' . $getruche[count($getruche) - 1]["nom"] . '</div><div class="InfoRuche">Pas encore prête</div><div class="InfoRuche">température : ' . $ruches->$i->data[count($ruches->$i->data) - 1]->temperature . ' °</div><a href="index.php?page=Ruches&jsruche=Ruche N°' . $getruche[count($getruche) - 1]["ID_Ruches"] . '" class="MaRucheBouton">Consulter</a></div></div><div class="ContourRuche"><div class="UneRuche"><img class="ImageDeLaRuche" src="../img/TesRuches.png" alt="Tes ruches"><div class="MaRucheTitre">' . $getruche[count($getruche) - 2]["nom"] . '</div><div class="InfoRuche">Pas encore prête</div><div class="InfoRuche">température : ' . $ruches->$i2->data[count($ruches->$i2->data) - 1]->temperature . ' °</div><a href="index.php?page=Ruches&jsruche=Ruche N°' . $getruche[count($getruche) - 2]["ID_Ruches"] . '" class="MaRucheBouton">Consulter</a></div></div><div class="ContourRuche"><div class="UneRuche"><img class="ImageDeLaRuche" src="../img/TesRuches.png" alt="Tes ruches"><div class="MaRucheTitre">' . $getruche[count($getruche) - 3]["nom"] . '</div><div class="InfoRuche">Pas encore prête</div><div class="InfoRuche">température : ' . $ruches->$i3->data[count($ruches->$i3->data) - 1]->temperature . ' °</div><a href="index.php?page=Ruches&jsruche=Ruche N°' . $getruche[count($getruche) - 3]["ID_Ruches"] . '" class="MaRucheBouton">Consulter</a></div></div>';
        } else {
            // Affichage des lignes du tableau
            foreach ($getruche as $r) {
                $i = $r["ID_Ruches"];
    
                if (isset($ruches->$i)) {
                    if (file_exists('img/imported/' . $r['ID_Ruches'] . '.jpg')) {
                        $phototest = 'img/imported/' . $r['ID_Ruches'] . '.jpg';
                        // Si l'image existe, l'affiche
                    } else if (file_exists('img/imported/' . $r['ID_Ruches'] . '.png')) {
                        $phototest = 'img/imported/' . $r['ID_Ruches'] . '.png';
                    } else {
                        // Sinon, affiche une image par défaut
                        $phototest = 'img/imported/no_image_ruche.png';
                    }
                    $contenu2 .= '<div class="ContourRuche"><div class="UneRuche"><img class="ImageDeLaRuche" src="../' . $phototest . '" alt="Tes ruches"><div class="MaRucheTitre">' . $r['nom'] . '</div><div class="InfoRuche">Pas encore prête</div><div class="InfoRuche">température : ' . $ruches->$i->data[count($ruches->$i->data) - 1]->temperature . ' °</div><a href="index.php?page=Ruches&jsruche=Ruche N°' . $r["ID_Ruches"] . '" class="MaRucheBouton">Consulter</a></div></div>';
                } else {
                    $contenu2 .= 'ruche innexistante, veuillez la supprimer.';
                }
            }
        }
    }
    else{
        $contenu2 .= 'ruche(s) innexistante, veuillez la/les supprimer.';
    }



    if (isset($ruches->$i)) {
        $mapcenter = "var map = L.map('map').setView([" . $ruches->$i->gps[0] . ", " . $ruches->$i->gps[1] . "], 13);";
    } else {
        $mapcenter = "var map = L.map('map').setView([50, 50], 13);";
    }


    foreach ($getruche as $r) {
        $i = $r["ID_Ruches"];
        if (isset($ruches->$i)) {
            $markers .= 'var marker' . $i . ' = L.marker([' . $ruches->$i->gps[0] . ', ' . $ruches->$i->gps[1] . ']).addTo(map);';
        } else {
            $markers .= "";
        }
    }


} else
    $contenu2 =  "<div class='reponse'>Aucune ruche enregistrée.</div>";

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ruches connectées - Accueil</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <link rel="stylesheet" href="../styles/styles_index_non_connecte.css">
    <link rel="stylesheet" media="(max-width: 620px)" href="../styles/styles_commun_mobile.css">
    <link rel="stylesheet" href="../styles/style_admin.css">
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

    <div class="Decoration">
        <img class="AbeilleDeco1" src="../img/abeille_fond.svg" alt="une petite abeille qui décore la page">
        <img class="AbeilleDeco2" src="../img/abeille_fond.svg" alt="une petite abeille qui décore la page">
        <img class="AbeilleDeco3" src="../img/abeille_fond.svg" alt="une petite abeille qui décore la page">
        <svg width="1819" height="1184" viewBox="0 0 1819 1184" fill="none" xmlns="http://www.w3.org/2000/svg"
            class="SVG1">
            <path
                d="M1817.41 1.27776C1501.62 350.755 1057.94 435.72 875.573 434.518C667.467 447.632 201.309 615.67 1.52767 1182.91"
                stroke="#CFCFCF" stroke-width="3" stroke-dasharray="10 10" />
        </svg>
        <svg width="2713" height="699" viewBox="0 0 2713 699" fill="none" xmlns="http://www.w3.org/2000/svg"
            class="SVG2">
            <path
                d="M2712.62 688.616C2131.61 751.304 1624.21 426.17 1443.14 255.766C1225.5 76.0547 632.47 -185.393 1.52173 206.506"
                stroke="#CFCFCF" stroke-width="3" stroke-dasharray="10 10" />
        </svg>

    </div>

    <main>
        <div class="ParentPartie1">
            <div class="Partie1">
                <div class="Partie1Texte">
                    <div class="SousTitre">Optimisez votre apiculture, <span
                            id="récupnom"><?= $utilisateur[0]['Prenom'] ?></span></div>
                    <h1 class="TitrePrincipal">RUCHES CONNECTEES</h1>
                    <div class="Partie1Paragraphe">
                        <p>Le projet des ruches connectées est un projet <b>réalisé par un
                                groupe d’étudiants</b> au sein de
                            l’IUT
                            de Mulhouse. La formation GEII de l’IUT a réalisé un appareil
                            <b>capable d’effectuer
                                différentes
                                mesures au sein des ruches.</b>
                        </p>
                        <p>Retrouvez même vos ruches perdues avec le traceur GPS ! Ce dernier suivra vos ruches et les
                            retrouvera. Ainsi, <b>vous ne pourrez jamais les égarer.</b>
                        </p>
                    </div>
                    <div class="Partie1Bouton">
                        <a href="#Information" class="Partie1Bouton1">Découvrir plus</a>
                        <a href="index.php?page=Ruches&jsruche=null" class="Partie1Bouton2">Mes ruches</a>
                    </div>
                </div>
                <div class="Partie1Image">
                    <img src="../img/RucheEtAbeille.png" alt="Des abeille et du miel">
                </div>
            </div>
        </div>

        <div class="ParentPartie6">
            <div class="Partie6">
                <h2 class="Partie4Titre">Utilisateurs</h2>
                <div class="MesRuches">
                    <?= $contenu ?>
                </div>
                <div class="ParentPartie4Bouton">
                    <a href="index.php?page=Utilisateurs" class="Partie4Bouton">Voir tous les utilisateurs</a>
                </div>
            </div>
        </div>

        <div class="ParentPartie4">
            <div class="Partie4">
                <h2 class="Partie4Titre">Mes Ruches</h2>
                <div class="MesRuches">
                    <?= $contenu2 ?>
                </div>
                <div class="ParentPartie4Bouton">
                    <a href="index.php?page=Gestion" class="Partie4Bouton">Ajouter</a>
                </div>
            </div>
        </div>

        <div class="ParentPartie5">
            <div class="Partie5">
                <h2 class="Partie5Titre">Trouve tes ruches</h2>
                <div id="map"></div>
            </div>
        </div>

        <div class="ParentPartie2">
            <div class="Partie2" id="Information">
                <div class="Partie2Image">
                    <img src="../img/GEII.jpg" alt="Les GEII qui ont fait la ruches connectées">
                </div>
                <div class="Partie2Texte">
                    <h2 class="Partie2Titre">Qu'est ce que le projet ruches connectées</h2>
                    <div>
                        <p><b>Réalisé par les GEII</b>, le projet ruches connectées a d’abord été un projet de fin de
                            semestre.
                        </p>
                        <p>Ce dernier avait un objectif simple : <b>être placé à l’intérieur des ruches de l’IUT dans le
                                but de
                                faciliter la vie des apiculteurs.</b> Ces derniers devaient pouvoir facilement accéder
                            aux
                            informations sur leurs ruches. Pour ce faire, <b>l’appareil a permis la mesure de plusieurs
                                valeurs.</b></p>
                    </div>
                    <div>
                        <p>voici les mesures prises par l’appareil : </p>
                        <ul>
                            <li>Fréquence de battement des ailes</li>
                            <li>température interieur de a ruche</li>
                            <li>poids du miel</li>
                            <li>température exterieur</li>
                            <li>Humidité dans la ruche</li>
                        </ul>
                        <p>Ce site permet aux apiculteurs de <b>savoir si le miel dans leurs ruches est prêt ou non à
                                être récolté</b></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="ParentPartie3">
            <div class="Partie3">
                <div class="Partie3Image1"></div>
                <div class="Partie3Image2"></div>
                <div class="Partie3Image3"></div>
                <div class="Partie3Image4"></div>
                <div class="Partie3Image5"></div>
                <div class="Partie3Image6"></div>
            </div>
        </div>
    </main>

    <footer>
        <?= $footer ?>
    </footer>

    <script>

        <?= $fonctionadmin ?>
        <?= $lenombre ?>

        <?= $mapcenter ?>

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        <?= $markers ?>


    </script>
</body>

</html>