<?php

if ($utilisateur[0]['Statut'] == 'admin') {
    $header = HEADER_admin;
} else {
    $header = HEADER_connecté;
}


$footer = Footer_connecté;

$content = "";

// graphique pour l'humidité
$graphhumid = "";

// graphique pour la température

$graphhtemp = "";

$markers = "";
$choixruche = "";
$mapcenter = "var map = L.map('map').setView([50, 50], 13);";

if (count($getruche)) {
    $i = $getruche[0]["ID_Ruches"];
    // centre de la carte
    if (isset($ruches->$i)) {
        $mapcenter = "var map = L.map('map').setView([" . $ruches->$i->gps[0] . ", " . $ruches->$i->gps[1] . "], 13);";
    } else {
        $mapcenter = "var map = L.map('map').setView([50, 50], 13);";
    }

    foreach ($getruche as $r) {
        $i = $r["ID_Ruches"];
        // mise en place des marker si des ruches sont disponibles
        if (isset($ruches->$i)) {
            $markers .= 'var marker' . $i . ' = L.marker([' . $ruches->$i->gps[0] . ', ' . $ruches->$i->gps[1] . ']).addTo(map); marker' . $i . '.bindPopup("Ruche : ' . $r['nom'] . '");';
        } else {
            $markers .= "";
        }

        $notesingle = afficher_notes($i);
        $compter_note = 0;
        $bouton_note = "";
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
        }

        if (!empty($notesingle)) {
            $liensuppr = 'index.php?page=supprnote&jsruche=null&idnote=' . $notesingle[0]['ID_note'];
        } else {
            $liensuppr = "#";
        }


        // regroupes les informations pour les graphiques d'humidité et de temérature dans un tableau

        $total = [];
        $dates = [];

        if (isset($ruches->$i)) {
            foreach ($ruches->$i->data as $valeur) {
                $total[] = $valeur->temperature;
                $separer = explode("-", explode('T', $valeur->date)[0]);
                $heures = explode(":", explode('T', $valeur->date)[1]);
                $jours = $separer[2];
                $mois = $separer[1];
                $années = $separer[0];
                $dates[] = "'" . $jours . '/' . $mois . ' : ' . $heures[0] . 'h' . "'";
            }

        } else {
            $total[] = '';
            $dates[] = "";
        }

        $heureshumid = join(",", $dates);
        $variable = join(",", $total);
        $total2 = [];
        $dates2 = [];

        if (isset($ruches->$i)) {
            foreach ($ruches->$i->data as $valeur) {
                $total2[] = $valeur->humidite;
                $separer = explode("-", explode('T', $valeur->date)[0]);
                $heures = explode(":", explode('T', $valeur->date)[1]);
                $jours = $separer[2];
                $mois = $separer[1];
                $années = $separer[0];
                $dates2[] = "'" . $jours . '/' . $mois . ' : ' . $heures[0] . 'h' . "'";
            }
        } else {
            $total2[] = "";
        }

        $variable2 = join(",", $total2);
        $heurestemp = join(",", $dates2);

        if (count($notesingle) > 0) {

            // verification de l'existence et affichage des notes

            $noteexist = '';
            if (count($notesingle) > 3) {
                $first_note = $notesingle[0];
                $sec_note = $notesingle[1];
                $trois_note = $notesingle[2];
                // html entity decode permet de retranscrire un vrai code html au lieu d'une chaine de caractère
                $contenunote1 = html_entity_decode($notesingle[0]['Contenu']);
                $contenunote2 = html_entity_decode($notesingle[1]['Contenu']);
                $contenunote3 = html_entity_decode($notesingle[2]['Contenu']);
                // boutons des notes
                $bouton_note .= "<div id='" . $first_note['ID_note'] . "' class='bouton_note'>Note n°1</div><div id='" . $sec_note['ID_note'] . "' class='bouton_note'>Note n°2</div><div id='" . $trois_note['ID_note'] . "' class='bouton_note'>Note n°3</div>";
                $noteexist = '<div class="note" id="note' . $first_note['ID_note'] . '"><p>Note n°' . $first_note['ID_note'] . ' : note du ' . $first_note['Date'] . '</p><div id="contenu' . $first_note['ID_note'] . '">' . $contenunote1 . '</div></div><div class="note disabled" id="note' . $sec_note['ID_note'] . '"><p>Note n°' . $sec_note['ID_note'] . ' : note du ' . $sec_note['Date'] . '</p><div id="contenu' . $sec_note['ID_note'] . '">' . $contenunote2 . '</div></div><div class="note disabled" id="note' . $trois_note['ID_note'] . '"><p>Note n°' . $trois_note['ID_note'] . ' : note du ' . $trois_note['Date'] . '</p><div id="contenu' . $trois_note['ID_note'] . '">' . $contenunote3 . '</div></div>';

            } else {
                foreach ($notesingle as $test) {
                    $compter_note = $compter_note + 1;
                    $bouton_note .= '<div id="' . $test['ID_note'] . '" class="bouton_note">Note n°' . $compter_note . '</div>';
                    $noteexist .= '<div class="note disabled" id="note' . $test['ID_note'] . '"><p>Note n°' . $compter_note . ' : note du ' . $test['Date'] . '</p><div id="contenu' . $test['ID_note'] . '">' . html_entity_decode($test['Contenu']) . '</div></div>';
                }
            }
        } else {
            $noteexist = "<div class='reponse'>Aucune note pour cette ruche</div>";
        }
        if (isset($ruches->$i)) {

            $choixruche .= "<div class='choix' id='choixruche'>Ruche N°" . $i . "</div>";

            // informations générales des ruches

            $content .= "<div class='ruche_informations_contour'>
            <h2><span class='recup'>Ruche N°" . $i . "</span> : " . $r['nom'] . " </h2>
            <div class='ruche_informations'>
                <div class='informations_base_note'>
                    <div class='flex_image_info'>
                        <div class='image_ruche'>
                            <img src='../" . $phototest . "' alt='photo_ruche'>
                        </div>
                        <div class='informations_ruche'>
                            <p>Humidité actuelle : <b>" . $ruches->$i->data[count($ruches->$i->data) - 1]->humidite . " %</b></p>
                            <p>Température interne : <b class='temp'>" . $ruches->$i->data[count($ruches->$i->data) - 1]->temperature . " °</b></p>
                            <p>Poid du miel : <b class='pounds'>" . $ruches->$i->data[count($ruches->$i->data) - 1]->poids . " kg</b></p>
                            <p>Frequence de battement des ailes: <b class='batps'>" . $ruches->$i->data[count($ruches->$i->data) - 1]->frequence . " bps</b></p>
                        </div>
                    </div>
                    <div class='boutons_note'>
                        <a href='index.php?page=Notes' class='left_button'>
                            <b>Gérer les notes</b>
                        </a>
                        <div class='right_button' id='" . $i . "'>
                            <b>Ajouter une note</b>
                        </div>
                    </div>
                    <!-- petit grid juste pour placer le titre correctement par rapport au reste -->
                    <div class='grid_placement_titre'>
                        <div class='void'>
    
                        </div>
                        <div class='titre_note'>
                            Mes notes :
                        </div>
                    </div>
                    <div class='grid_notes' id='ruche_note" . $i . "'>
                        <div class='boutons'>
                            <div class='top_bouton'>
                                " . $bouton_note . "
                                <a href='index.php?page=Notes'>
                                    <div class='bouton_voir_plus'>
                                        Voir plus
                                    </div>
                                </a>
                            </div>
                            <div class='bottom_bouton'>
                                <div class='modifier'>
                                    Modifier
                                </div>
                                <a class='supprimer' href='$liensuppr' >
                                    Supprimer
                                </a>
                            </div>
                        </div>
                            $noteexist
                    </div>
                </div>
                <div class='espace'>
    
                </div>
                <div class='graphiques'>
                    <div class='g1'>
                        <div class='titre_graphique'>
                            Evolution de l'humidité (en %)
                        </div>
                        <div>
                            <canvas id='" . $i . "_1'></canvas>
                        </div>
                    </div>
                    <div class='g2'>
                        <div class='titre_graphique'>
                            Evolution de la température (en degrés)
                        </div><div><canvas id='" . $i . "_2'>
                                    </canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>";

            // informations pour chaques graphiques

            $graphhumid .= "const humid" . $i . " = document.getElementById('" . $i . "_1');
    
            new Chart(humid" . $i . ", {
                type: 'line',
                data: {
                    labels: [" . $heureshumid . "],
                    datasets: [{
                        label: 'Humidité en %',
                        data: [" . $variable2 . "],
                        borderColor: '#B95E06',
                        backgroundColor: 'transparent',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });";

            // informations our le graphique sur la température

            $graphhtemp .= "const temp" . $i . " = document.getElementById('" . $i . "_2');
    
            new Chart(temp" . $i . ", {
                type: 'line',
                data: {
                    labels: [" . $heurestemp . "],
                    datasets: [{
                        label: 'Température en degré',
                        data: [" . $variable . "],
                        borderColor: '#B95E06',
                        backgroundColor: 'transparent',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });";


        } else {
            // au cas ou une ruche est mal acceptée
            $content .= "<div class='centrenoruche'>Nous avons sans le vouloir accepté une ruche qui n'existe pas, nous nous en excusons, pouvez vous supprimer cette dernière ou contacter un administrateur ?</div>";
            $graphhtemp .= "";
            $graphhumid .= "";
        }
    }
} else {
    $content .= "<div class='centrenoruche'>Vous n'avez aucune ruche.</div>";
}





?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Information ruches</title>
    <link rel="stylesheet" href="../styles/styles_index_non_connecte.css">
    <link rel="stylesheet" href="../styles/inforuches.css">
    <link rel="stylesheet" media="(max-width: 1200px)" href="../styles/Tablette.css">
    <link rel="stylesheet" media="(max-width: 1200px)" href="../styles/Tabletteinforuche.css">
    <link rel="stylesheet" media="(max-width: 620px)" href="../styles/stylesinforuchemobile.css">
    <link rel="stylesheet" media="(max-width: 620px)" href="../styles/styles_commun_mobile.css">
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.bubble.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
</head>

<body>
    <!-- header du site -->
    <header>
        <?= $header ?>
    </header>

    <!-- pop up demandes admin -->

    <div class="pop_up_admin_demande">
        <div class="topinfo">
            <h2>Boite de récéption</h2>
            <img id="croixboite" src="../img/svgcroixrefus.svg" alt="croix fermeture">
        </div>
        <?= $demandes_ruches ?>
    </div>

    <!-- carte en position fixed -->

    <div class="fixed_carte">
        <div id="map"></div>
        <div class="croixfixed">
            <img src="img/svgcroixrefus.svg" alt="">
        </div>
    </div>

    <!-- icone pour ouvrir la carte  -->
    <div class="iconcarte"><img src="img/clacarte.svg" alt="icone de la carte"></div>

    <!-- cache de fond -->

    <div class="cache_fond">

    </div>
    <!-- pour enregistrer une note -->
    <div class="confirmation">
        <div class="titresec">
            <h4>Enregistrement de la note</h4>
            <div class="croix">
                <img src="img/svgcroixrefus.svg" alt="croix de fermeture">
            </div>
        </div>
        <div class="infoajt">
            <?= $message ?>
        </div>
    </div>
    <!-- formulaire d'ajout de note  -->
    <div class="formulairetest">
        <form action="<?= $_SERVER['PHP_SELF'] . '?page=ajoutNote&jsruche=null' ?>" method="post">
            <div class="ajout_ruches">
                <div class="nom_ruche">
                    <input type="hidden" id="numeroruche" name="ruchelien" required>
                </div>
            </div>
            <div id="editor">

            </div>
            <div class="area_et_hidden">
                <input type="hidden" class="inclusion" name="contenu" required>
            </div>
            <div class="valider">
                <input type="submit" value="Enregistrer" class="formbouton" name="ok">
            </div>
        </form>
    </div>

    <div class='fixeddanslefixed'>
        <p>Voulez vous vraiment supprimer cette note ?</p>
        <div class='ledarondufixe'>
            <a>
                <div class='nonjesuppr'>Non</div>
            </a>
            <a href='#'>
                <div class='ouijesuppr'>Oui</div>
            </a>
        </div>
    </div>

    <!-- div globale qui entoure tout le titre -->
    <div class="haut_titre_soustitre">
        <!-- div pour centrer le titre -->
        <div class="centre_haut_titre">
            <h1>Mes ruches</h1>
            <p>Trouvez rapidement vos ruches</p>
        </div>
    </div>
    <div class="filtre_contour">
        <!-- filtre pour trouver sa ruche facilement -->
        <div class="filtre">
            <!-- div contenant les menus et leurs titre -->
            <div class="menus_deroulant">
                <p>Battement d'ailes</p>
                <!-- le menu déroulant -->
                <div class="menu_deroulant">
                    <div class="information" id="bpschoisi">
                        Pas de filtre.
                    </div>
                    <div class="fleche">
                        <img src="../img/icone_fleche_bas.svg" alt="fleche vers le bas">
                    </div>
                    <div class="absolute_deroulant" id="bps">
                        <div class="choix">Pas de filtre.</div>
                        <div class="choix">&gt; 140 bps</div>
                        <div class="choix">&lt; 140 bps</div>
                        <div class="choix">&lt; 160 bps</div>
                        <div class="choix">&lt; 180 bps</div>
                        <div class="choix">&lt; 200 bps</div>
                        <div class="choix">&lt; 220 bps</div>
                        <div class="choix">&lt; 240 bps</div>
                        <div class="choix">&lt; 260 bps</div>
                        <div class="choix">&lt; 280 bps</div>
                    </div>
                </div>
            </div>
            <!-- div contenant les menus et leurs titre -->
            <div class="menus_deroulant">
                <p>Température</p>
                <!-- le menu déroulant -->
                <div class="menu_deroulant">
                    <div class="information" id="tpschoisi">
                        Pas de filtre.
                    </div>
                    <div class="fleche">
                        <img src="../img/icone_fleche_bas.svg" alt="fleche vers le bas">
                    </div>
                    <div class="absolute_deroulant" id="temps">
                        <div class="choix">Pas de filtre.</div>
                        <div class="choix">10 - 14°</div>
                        <div class="choix">15 - 19 °</div>
                        <div class="choix">20 - 24 °</div>
                        <div class="choix">25 - 29 °</div>
                        <div class="choix">30 - 34 °</div>
                        <div class="choix">35 - 39 °</div>
                        <div class="choix">40 - 44 °</div>
                        <div class="choix">45 - 50 °</div>
                    </div>
                </div>
            </div>
            <!-- div contenant les menus et leurs titre -->
            <div class="menus_deroulant">
                <p>Poid du miel</p>
                <!-- le menu déroulant -->
                <div class="menu_deroulant">
                    <div class="information" id="pdschoisi">
                        Pas de filtre.
                    </div>
                    <div class="fleche">
                        <img src="../img/icone_fleche_bas.svg" alt="fleche vers le bas">
                    </div>
                    <div class="absolute_deroulant" id="poid">
                        <div class="choix">Pas de filtre.</div>
                        <div class="choix">> 5 kg</div>
                        <div class="choix">> 6 kg</div>
                        <div class="choix">> 7 kg</div>
                        <div class="choix">> 8 kg</div>
                        <div class="choix">> 9 kg</div>
                        <div class="choix">> 10 kg</div>
                        <div class="choix">> 11 kg</div>
                        <div class="choix">> 12 kg</div>
                        <div class="choix">> 13 kg</div>
                        <div class="choix">> 14 kg</div>
                        <div class="choix">> 15 kg</div>
                        <div class="choix">> 16 kg</div>
                        <div class="choix">> 17 kg</div>
                        <div class="choix">> 18 kg</div>
                        <div class="choix">> 19 kg</div>
                        <div class="choix">> 20 kg</div>
                    </div>
                </div>
            </div>
            <!-- div contenant les menus et leurs titre -->
            <div class="menus_deroulant">
                <p id="ruchesfiltre">Ruche</p>
                <!-- le menu déroulant -->
                <div class="menu_deroulant">
                    <div class="information" id="rchoisi">
                        Pas de filtre.
                    </div>
                    <div class="fleche">
                        <img src="../img/icone_fleche_bas.svg" alt="fleche vers le bas">
                    </div>
                    <div class="absolute_deroulant" id="ruche">
                        <div class="choix">Pas de filtre.</div>
                        <?= $choixruche ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="groupe">
        <?= $content ?>
    </div>
    <footer>
        <?= $footer ?>
    </footer>
    <script src="../js/script_commun_header.js"></script>
    <script src="../js/commun_confirm_pop_up.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <script src="../js/inforuches.js">
    </script>
    <script>
        // les graphiques chart js

        <?= $graphhumid ?>

        <?= $graphhtemp ?>

        document.querySelectorAll('.recup').forEach(e => {
            e.innerHTML = e.innerHTML.split('0')[0] + " " + e.innerHTML.split('0')[e.innerHTML.split('0').length - 1]
        })

        setInterval(actualiser, 1000);


        function actualiser() {
            let carote = document.querySelector('#editor>.ql-editor').innerHTML
            document.querySelector('.inclusion').value = carote
        }

        const quill = new Quill('#editor', {
            theme: 'snow',
            border: 'none',
        });

        // la carte

        <?= $mapcenter ?>

    </script>
    <script src="carte.js"></script>
    <script>
        <?= $markers ?>
        <?= $fonctionadmin ?>
        <?= $lenombre ?>
    </script>
</body>

</html>