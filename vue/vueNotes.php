<?php


// affichage du bon header
if ($utilisateur[0]['Statut'] == 'admin') {
    $header = HEADER_admin;
} else {
    $header = HEADER_connecté;
}

$footer = Footer_connecté;
$content = "";
$choixruche = "";


// regarder si on a des ruches
if (count($getruche)) {
    foreach ($getruche as $r) {
        $i = $r["ID_Ruches"];

        $notesingle = afficher_notes($i);
        $compter_note = 0;
        // afficher les notes si il y en a plus que 0
        if (count($notesingle) > 0) {
            $noteexist = '';
            foreach ($notesingle as $test) {
                $compter_note = $compter_note + 1;
                $noteexist .= '<div class="contournote">
                        <div class="top">
                            <h3>Note n°' . $compter_note . '</h3>
                        </div>
                        <div class="content" id="contenu' . $test['ID_note'] . '">
                            ' . html_entity_decode($test['Contenu']) . '
                        </div>
                        <div class="continuer">
                            <p>...</p>
                        </div>
                        <div class="boutons">
                            <div class="voirnote" id="modifier' . $test['ID_note'] . '">
                                Voir la note
                            </div>
                            <a href="index.php?page=supprnote&jsruche=null&prevpage=note&idnote=' . $test['ID_note'] . '" class="supprimernote">
                                Supprimer
                            </a>
                        </div>
                    </div>';
            }
        } else {
            $noteexist = "<div class='reponse'>Aucune note pour cette ruche</div>";
        }

        if (isset($ruches->$i)) {
            // affichages des ruches et des rubriques pour chaques ruches
            $choixruche .= "<div class='choix' id='choixruche'>Ruche N°" . $i . "</div>";

            $content .= '<div class="ruche_all_notes" id="ruche' . $i . '">
            <div class="center">
                <div class="titre">
                    <h2 class="selected">Ruche N°' . $r["ID_Ruches"] . '</h2>
                    <button id=' . $r["ID_Ruches"] . ' class="boutonajout">
                        Ajouter
                    </button>
                </div>
                <div class="gridnotesall">
                    ' . $noteexist . '
                </div>

            </div>
        </div>';

        } else {
            $content .= "Nous avons sans le vouloir accepté une ruche qui n'existe pas, nous nous en excusons, pouvez vous supprimer cette dernière ou contacter un administrateur ?";
        }
    }
} else {
    $content .= "Vous n'avez aucune ruche.";
}


?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../styles/styles_index_non_connecte.css">
    <link rel="stylesheet" href="../styles/Note.css">
    <link rel="stylesheet" media="(max-width: 620px)" href="../styles/MesNotesMobile.css">
    <link rel="stylesheet" media="(max-width: 620px)" href="../styles/styles_commun_mobile.css">
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.bubble.css" rel="stylesheet" />
</head>

<body>
    <!-- header du site -->
    <header>
        <?= $header ?>
    </header>

    <div class="cache_fond">

    </div>
    <!-- formulaire pour l'ajout de notes ou la modification de notes -->
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
                <div class="exit"><img src="../img/svgcroixrefus.svg" alt="croix de refus svg"></div>
                <div class="stuck">
                    <input type="submit" value="Enregistrer" class="formbouton" name="ok">
                </div>
            </div>
        </form>
    </div>

    <!-- pour l'admin quand il doit répondre au demandes de ruches : ne pas enlever -->
    <div class="pop_up_admin_demande">
        <div class="topinfo">
            <h2>Boite de récéption</h2>
            <img id="croixboite" src="../img/svgcroixrefus.svg" alt="croix fermeture">
        </div>
        <?= $demandes_ruches ?>
    </div>
    <!-- décorations -->
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

        <div class="center">
            <h1>Mes notes</h1>
        </div>
        <div class="center">
            <!-- choix de la ruche -->
            <div class="choixruche">
                <p>Choisissez une ruche</p>
                <div class="deroulantruche">
                    <p id="rchoisi">Ruche N° 1</p>
                    <div class="iconefleche">
                        <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4.75 7.125L9.5 11.875L14.25 7.125" stroke="white" stroke-width="1.6"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <div class="absolute_deroulant" id="temps">
                        <div class="choix">Pas de filtre.</div>
                        <?= $choixruche ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- toute les ruches et leurs notes -->
        <?= $content ?>
    </main>

    <footer>
        <?= $footer ?>
    </footer>

    <script src="../js/script_commun_header.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <script>
        <?= $fonctionadmin ?>
        <?= $lenombre ?>
        
        // modification du chemin du formulaire a l'ajout
        document.querySelectorAll('.boutonajout').forEach(e => {

            e.addEventListener('click', ouvrir)

            function ouvrir() {
                console.log('test')
                document.querySelector('.formulairetest>form').action = "index.php?page=ajoutNote&prevpage=ajouternote&jsruche=null"
                document.querySelector('.formulairetest').classList.add('ouvert2')
                document.querySelector('.cache_fond').classList.add('ouvert2')
                document.querySelector('#numeroruche').value = e.id
            }
        })
        // sortir des pop ups
        document.querySelector('.cache_fond').addEventListener('click', enleverform)
        document.querySelector('.exit').addEventListener('click', enleverform)


        function enleverform(){
            document.querySelector('.cache_fond').classList.remove('ouvert2')
            document.querySelector('.formulairetest').classList.remove('ouvert2')
        }

        setInterval(actualiser, 1000);


        // changer le formulaire pour la modification de notes
        document.querySelectorAll('.voirnote').forEach(e => {
            e.addEventListener('click', changer)

            function changer() {
                let splited = e.id.split('r')[1]
                document.querySelector('.formulairetest').classList.add('ouvert2')
                document.querySelector('.cache_fond').classList.add('ouvert2')
                document.querySelector('.formulairetest>form').action = "index.php?page=modifnote&prevpage=modif&jsruche=null";
                document.querySelector('#numeroruche').value = splited
                document.querySelector('#editor>.ql-editor').innerHTML = document.querySelector('#contenu' + splited).innerHTML
            }
        })
        // actualiser pour avoir les notes en permanence dans le input hidden
        function actualiser() {
            let carote = document.querySelector('#editor>.ql-editor').innerHTML
            document.querySelector('.inclusion').value = carote

            console.log(document.querySelector('.inclusion').value)
        }

        const quill = new Quill('#editor', {
            theme: 'snow',
            border: 'none',
        });

        document.querySelector('.deroulantruche').addEventListener('click', openmenu)

        function openmenu() {
            document.querySelector('.absolute_deroulant').classList.toggle('ouvert')
        }

        // choix de laruche qui enlève les autres

        document.querySelectorAll('.choix').forEach(e => {
            e.addEventListener('click', filtrer)

            function filtrer() {
                document.querySelector('#rchoisi').innerHTML = e.innerHTML
                document.querySelectorAll('.selected').forEach(element => {
                    element.parentElement.parentElement.parentElement.classList.remove('disparu4')
                    if (element.innerHTML == e.innerHTML) {
                        console.log('good')
                    }
                    else {
                        if (e.innerHTML == 'Pas de filtre.') {
                            document.querySelectorAll('.ruche_all_notes').forEach(reset =>{
                                reset.classList.remove('disparu4')
                            })
                        }
                        else {
                            element.parentElement.parentElement.parentElement.classList.add('disparu4')
                        }
                    }
                });
            }
        });
    </script>
</body>

</html>