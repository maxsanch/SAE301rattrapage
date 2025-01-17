<?php

$header = HEADER_admin;
$footer = Footer_connecté;

$contenu = '';

if (count($GetAllUser)) {
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
        $contenu .= "<div class='GrandeCase'><div class='PetiteCase'><a href='index.php?page=PhotoUser&idUser=" . $ligne['Id_utilisateur'] . "'><img class='photo' src='../" . $phototest . "' alt='photo'></a><b>" . $ligne['Prenom'] . "</b><div>Dernière connexion : " . $ligne['connexion'] . "</div><div>Nombre de ruches : " . count($lesruches) . "</div><a class='Information' href='index.php?page=informationsUser&idUser=" . $ligne['Id_utilisateur'] . "'>Information</a></div></div>";
    }
} else
    echo "<div class='reponse'>Aucun Utilisateur n'est enregistré</div>";


if (!empty($usersingle)) {
    // informations mises en variables
    $nom = $usersingle[0]['Nom'] . " " . $usersingle[0]['Prenom'];
    $statut = $usersingle[0]['Statut'];
    $mail = $usersingle[0]['Mail'];
    $mdp = $usersingle[0]['MotDePasse'];
    $date = $usersingle[0]['connexion'];
    $idUser = $usersingle[0]['Id_utilisateur'];
    $nbrruche = count($ruchesingleuser);
    $datebis = $usersingle[0]["inscription"];
    $nombrenote = count($count);
    // informations de l'utilisateur
    $contentuser = "<div class='cachetjrla' id='celuiuser'></div>
                    <div class='pop_up_fixed_info_users'>
                        <div class='photo_left'>
                        </div>
                    <div class='infos'>
                        <div class='user_name'>
                        <h2>" . $nom . "</h2>
                        <img src='../img/svgcroixrefus.svg' id='croixuserchoose'>
                        </div>
                    <div class='informations_and_icones'>
                        <div class='info'>
                            <div class='icone'>
                            <img src='../img/inscriptionUser.svg'>
                        </div>
                        <div class='texte_info'>
                                <p>Date d'inscription</p>
                                <p>$datebis</p>
                            </div>
                    </div>
                    <div class='info'>
                        <div class='icone'>
                            <img src='../img/nombre_notes.svg'>
                        </div>
                        <div class='texte_info'>
                            <p>Nombre de notes</p>
                            <p>$nombrenote</p>
                        </div>
                    </div>
                    <div class='info'>
                        <div class='icone'>
                            <img src='../img/nombre_ruche.svg'>
                        </div>
                        <div class='texte_info'>
                            <p>Nombre de ruches</p>
                            <p>$nbrruche</p>
                        </div>
                    </div>
                    <div class='info'>
                        <div class='icone'>
                            <img src='../img/connexion.svg'>
                        </div>
                        <div class='texte_info'>
                            <p>Dernière connexion</p>
                            <p>$date</p>
                        </div>
                    </div>
                </div>
                <div class='champs_perso'>
                    <div class='NOM'>
                        <p class='grasuser'>Statut</p>
                        <p class='casejaune'>$statut</p>
                    </div>  
                    <div class='mailuserspecifique'>
                        <p class='grasuser'>E-mail</p>
                        <p class='casejaune'>$mail</p>  
                    </div>
                    <div class='mdp'>
                        <p class='grasuser'>Mot de passe</p>
                        <div class='casejaune'>
                            <input type='password' disabled value='$mdp'> 
                        </div>
                    </div>
                </div>
                <div class='boutons'>
                    <div class='reset_password'>
                        Reinitialiser le mot de passe
                    </div>
                    <a class='delet_account' href='index.php?page=deletaccount&IDUser=$idUser'>
                        Supprimer le compte
                    </a>
                </div>
            </div>
        </div>";
    // scripts javascripts liés au informations
    $function = "document.querySelector('.reset_password').addEventListener('click', changer)";
    $letrucquifaittoubuguer = $usersingle[0]['Id_utilisateur'];
    $ledexiemetrucquifaittoubuguer = $usersingle[0]['Prenom'];
} else {
    $contentuser = '';
    $function = "";
    $letrucquifaittoubuguer = "";
    $ledexiemetrucquifaittoubuguer = "";
}

if ($message != "") {
    // message si existant dans une pop up
    $infoaffiche = '<div class="informationerreur">
        <div class="topinfo">
            <b>Information</b>
            <img id="croixinfo" src="../img/svgcroixrefus.svg" alt="croix de refus">
        </div>
        <div class="messageuser">
            '.$message.'
        </div>
    </div>
    <div class="cachetjrla">

    </div>';
} else {
    // sinon il est pas la
    $infoaffiche = '<div class="informationerreur enlever">
        <div class="topinfo">
            <b>Information</b>
            <img id="croixinfo" src="../img/svgcroixrefus.svg" alt="croix de refus">
        </div>
        <div class="messageuser">
        </div>
    </div>
    <div class="cachetjrla enlever">

    </div>';
}
// tableau pour le graphique
$tableau = [];
foreach($nombreparmois as $cle){
    $tableau[] = $cle['nombreConnexion'].' ';
}
$final = join(',',$tableau);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des utilisateurs</title>
    <link rel="stylesheet" href="../styles/styles_index_non_connecte.css">
    <link rel="stylesheet" href="../styles/GestionUtilisateur.css">
    <link rel="stylesheet" media="(max-width: 620px)" href="../styles/GestionUtilisateursmobile.css">
    <link rel="stylesheet" media="(max-width: 620px)" href="../styles/styles_commun_mobile.css">
</head>

<body>
    <header>
        <?= $header ?>
    </header>

    <!-- cache et pop up des demandes de ruche pour l'admin -->
    <div class="cache_fond">

    </div>
    <div class="pop_up_admin_demande">
        <div class="topinfo">
            <h2>Boite de récéption</h2>
            <img id="croixboite" src="../img/svgcroixrefus.svg" alt="croix fermeture">
        </div>
        <?= $demandes_ruches ?>
    </div>
    <!-- pop up info -->
    <?= $infoaffiche ?>
    <main>
        <?= $contentuser ?>
        <h2 class="Titre">Gestion des utilisateurs</h2>
        <!-- tableau de brod avec graphique -->
        <h3 class="SousTitre">Tableau de bord</h3>
        <div class="Contour">
            <div class="LesElements">
                <div class="Element"><img class="SVG" src="../img/Inscrit.svg" alt="">
                    <div>Nombre d'inscriptions</div>
                    <div class="Chiffre"><?= count($GetAllUser); ?></div>
                </div>
                <div class="Element"><img class="SVG" src="../img/Ruche.svg" alt="">
                    <div>Nombre de ruches enregistrées</div>
                    <div class="Chiffre"><?= count($ruches); ?></div>
                </div>
            </div>
            <!-- graphique ici -->
            <div class="LeGraph"><canvas id="myChart"></canvas></div>
        </div>
        <h3 class="SousTitre">Utilisateurs</h3>
        <!-- tout les utilisateurs dans un flex -->
        <div class="LesUtilisateurs">
            <?= $contenu ?>
        </div>
    </main>

    <footer>
        <?= $footer ?>
    </footer>

    <script src="../js/script_commun_header.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // enlever les pop ups
        document.querySelector('#croixinfo').addEventListener('click', enlever)
        document.querySelector(".cachetjrla").addEventListener('click', enlever)

        function enlever(){
            document.querySelector(".cachetjrla").classList.add('enlever')
            document.querySelector('.informationerreur').classList.add('enlever')
        }

        if(document.querySelector('#celuiuser') && document.querySelector('#croixuserchoose')){
            document.querySelector('#celuiuser').addEventListener('click', enleveruser)
            document.querySelector('#croixuserchoose').addEventListener('click', enleveruser)

        }

        // enlever les infos de l'utilisateur

        function enleveruser(){
            document.querySelector('#celuiuser').classList.add('enlever')
            document.querySelector('.pop_up_fixed_info_users').classList.add('enlever')
        }


        // grapique chart js
        const ctx = document.getElementById('myChart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Decembre'],
                datasets: [{
                    label: 'nombre de connexions',
                    data: [<?= $final ?>],
                    borderWidth: 1,
                    backgroundColor: [
                        '#B95E06'
                    ]
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // fonctions pour les admins uniquement
        <?= $function ?>

        // changement du formulaire

        function changer() {
            document.querySelector('.infos').innerHTML = "<form action=index.php?page=resetpassword&iduser=<?= $letrucquifaittoubuguer ?>' method='post'><h2>Modifier le mot de passe de : <?= $ledexiemetrucquifaittoubuguer ?></h2><div class='mdpreset'><div class='casejaune'><input class='enleverstpp' placeholder='Entrez le nouveau mot de passe' required type='password' name='mdp'></div><div><div class='grasuser'>Confirmez le mot de passe</div><div class='casejaune'><input class='enleverstpp' required placeholder='Confirmer le mot de passe' type='password' name='confirmation'></div></div></div><button>Changer le mot de passe.</button></form>"
        }

        <?= $fonctionadmin ?>
        <?= $lenombre ?>
    </script>
</body>

</html>