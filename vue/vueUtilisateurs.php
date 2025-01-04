<?php

$header = HEADER_admin;
$footer = Footer_déconnecté;

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
        $contenu .= "<div class='GrandeCase'><div class='PetiteCase'><a href='index.php?page=PhotoUser&idUser=" . $ligne['Id_utilisateur'] . "'><img class='photo' src='../" . $phototest . "' alt=''></a><b>" . $ligne['Prenom'] . "</b><div>Dernière connexion : " . $ligne['connexion'] . "</div><div>Nombre de ruches : " . count($lesruches) . "</div><a class='Information' href='index.php?page=informationsUser&idUser=" . $ligne['Id_utilisateur'] . "'>Information</a></div></div>";
    }
} else
    echo "<div class='reponse'>Aucun Utilisateur n'est enregistré</div>";


$demandes_ruches = "";

if (count($demandes)) {
    foreach ($demandes as $ligne) {
        $demandes_ruches .= '<div class="demande"><div class="nom_user">' . $ligne['prenom_utilisateur'] . ' a envoyé une demande de validation de ruche.</div><div class="id_entre">ID entré par ' . $ligne['prenom_utilisateur'] . ' : ' . $ligne['ID_Ruches'] . '</div><div class="boutons_Ajout_Ruche"><a class="accept_ruche" href="index.php?page=accepter&IdRuche=' . $ligne['ID_Ruches'] . '&IdUtilisateur=' . $ligne['Id_utilisateur'] . '&NomRuche=' . $ligne['nom_ruche'] . '&idDemande=' . $ligne['ID_attente'] . '">Accepter</a><a class="refus_ruche" href="index.php?page=Refuser&idDemande=' . $ligne['ID_attente'] . '">Refuser</a></div></div>';
    }
} else {
    $demandes_ruches = "<div class='informationdemande'>Aucune demande n'a été transmise.</div>";
}

if (!empty($usersingle)) {
    $nom = $usersingle[0]['Nom'] . " " . $usersingle[0]['Prenom'];
    $statut = $usersingle[0]['Statut'];
    $mail = $usersingle[0]['Mail'];
    $mdp = $usersingle[0]['MotDePasse'];
    $date = $usersingle[0]['connexion'];
    $idUser = $usersingle[0]['Id_utilisateur'];
    $nbrruche = count($ruchesingleuser);
    $datebis = $usersingle[0]["inscription"];
    $nombrenote = count($count);
    $contentuser = "<div class='pop_up_fixed_info_users'><div class='photo_left'>
                    </div>
                    <div class='infos'>
                        <div class='user_name'><h3>" . $nom . "</h3>
                    </div>
                    <div class='informations_and_icones'>
                        <div class='info'>
                            <div class='icone'>

                        </div>
                        <div class='texte_info'>
                                <p>Date d'inscription</p>
                                <p>$date</p>
                            </div>
                    </div>
                    <div class='info'>
                        <div class='icone'>

                        </div>
                        <div class='texte_info'>
                            <p>Nombre de notes</p>
                            <p>$nombrenote</p>
                        </div>
                    </div>
                    <div class='info'>
                        <div class='icone'>

                        </div>
                        <div class='texte_info'>
                            <p>Nombre de ruches</p>
                            <p>$nbrruche</p>
                        </div>
                    </div>
                    <div class='info'>
                        <div class='icone'>

                        </div>
                        <div class='texte_info'>
                            <p>Dernière connexion</p>
                            <p>$date</p>
                        </div>
                    </div>
                </div>
                <div class='champs_perso'>
                    <div class='NOM'>
                        <p>Statut de l'utilisateur</p>
                        $statut
                    </div>  
                    <div class='mail'>
                        <p>Email de l'utilisateur</p>
                        <p>$mail</p>  
                    </div>
                    <div class='mdp'>
                        <p>Mot de passe de l'utilisateur</p>
                        <input type='password' disabled value='$mdp'> 
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

    $function = "document.querySelector('.reset_password').addEventListener('click', changer)";
    $letrucquifaittoubuguer = $usersingle[0]['Id_utilisateur'];
    $ledexiemetrucquifaittoubuguer = $usersingle[0]['Prenom'];
} else {
    $contentuser = '';
    $function = "";
    $letrucquifaittoubuguer = "";
    $ledexiemetrucquifaittoubuguer = "";
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des utilisateurs</title>
    <link rel="stylesheet" href="../styles/styles_index_non_connecte.css">
    <link rel="stylesheet" href="../styles/GestionUtilisateur.css">

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
            <img src="../img/svgcroixrefus.svg" alt="croix fermeture">
        </div>
        <?= $demandes_ruches ?>
    </div>
    <main>
        <?= $message ?>
        <?= $contentuser ?>
        <h2 class="Titre">Gestion des utilisateurs</h2>
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
                <div class="Element"><img class="SVG" src="../img/UtilisateursCo.svg" alt="">
                    <div>Utilisateurs actifs</div>
                    <div class="Chiffre">2</div>
                </div>
            </div>
            <!-- graphique ici -->
            <div class="LeGraph"><canvas id="myChart"></canvas></div>
        </div>
        <h3 class="SousTitre">Utilisateurs</h3>
        <div class="LesUtilisateurs">
            <?= $contenu ?>
        </div>
    </main>

    <footer>
        <?= $footer ?>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        console.log('allo')
        document.querySelector('.mail').addEventListener('click', notifopen)

        function notifopen() {
            document.querySelector('.cache_fond').classList.add('cache_plein')
            document.querySelector('.pop_up_admin_demande').classList.add('popupouverte')
        }

        document.querySelector('.cache_fond').addEventListener('click', fermerfenetre)
        document.querySelector('.topinfo>img').addEventListener('click', fermerfenetre)
        

        function fermerfenetre(){
            document.querySelector('.cache_fond').classList.remove('cache_plein')
            document.querySelector('.pop_up_admin_demande').classList.remove('popupouverte')
        }

        const ctx = document.getElementById('myChart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Decembre'],
                datasets: [{
                    label: '# of Votes',
                    data: [21, 30, 30, 15, 35, 34, 9, 37, 22, 31, 20, 12],
                    borderWidth: 1,
                    backgroundColor: [
                        'rgb(145, 70, 30)'
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

        <?= $function ?>

        function changer() {
            document.querySelector('.infos').innerHTML = "<form action=index.php?page=resetpassword&iduser=<?= $letrucquifaittoubuguer ?>' method='post'><h2>Modifier le mot de passe de : <?= $ledexiemetrucquifaittoubuguer ?></h2><div class='mdpreset'><div class='mdpnew'><input placeholder='Entrez le nouveau mot de passe' required type='password' name='mdp'></div><div><div>Confirmez le mot de passe</div><input required placeholder='Confirmer le mot de passe' type='password' name='confirmation'></div></div><button>Envoyer</button></form>"
        }
    </script>
    <!-- <script src="../js/Utilisateurs.js"></script> -->
</body>

</html>