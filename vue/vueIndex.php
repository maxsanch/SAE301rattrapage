<?php
$footer=Footer_déconnecté
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ruches connectées - Accueil</title>
    <link rel="stylesheet" href="styles/styles_index_non_connecte.css">
    <link rel="stylesheet" media="(max-width: 620px)" href="styles/styles_commun_mobile.css">
</head>

<body>
    <header>
        <div class="ConteneurHeader">
            <div class="TitreHeader"><span class="RucheHeader">R</span>uches connectées</div>
            <a href="index.php?page=Connexion" class="BoutonHeader">Se connecter</a>
        </div>
    </header>


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
                    <div class="SousTitre">Optimisez votre apiculture</div>
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
                        <a href="index.php?page=Connexion" class="Partie1Bouton2">Se connecter</a>
                    </div>
                </div>
                <div class="Partie1Image">
                    <img src="img/RucheEtAbeille.png" alt="Des abeille et du miel">
                </div>
            </div>
        </div>

        <div class="ParentPartie2">
            <div class="Partie2" id="Information">
                <div class="Partie2Image">
                    <img src="img/GEII.jpg" alt="Les GEII qui ont fait la ruches connectées">
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


    <script src="js/commun.js"></script>
    <script src="js/index.js"></script>
</body>

</html>