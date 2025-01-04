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
        $contenu .= "<div class='GrandeCase'><div class='PetiteCase'><a href='index.php?page=PhotoUser&idUser=" . $ligne['Id_utilisateur'] . "'><img class='photo' src='../" . $phototest . "' alt=''></a><b>" . $ligne['Prenom'] . "</b><div>Dernière connexion : " . $ligne['connexion'] . "</div><div>Nombre de ruches : " . count($lesruches) . "</div><div class='Information'>Information</div></div></div>";
    }
} else
    echo "<div class='reponse'>Aucun Utilisateur n'est enregistré</div>";


$demandes_ruches = "";

if (count($demandes)) {
    foreach ($demandes as $ligne) {
        $demandes_ruches .= '<div class="demande"><div class="nom_user">' . $ligne['prenom_utilisateur'] . ' a envoyé une demande de validation de ruche.</div><div class="id_entre">ID rentré par ' . $ligne['prenom_utilisateur'] . ' : ' . $ligne['ID_Ruches'] . '</div><a href="index.php?page=accepter&IdRuche=' . $ligne['ID_Ruches'] . '&IdUtilisateur=' . $ligne['Id_utilisateur'] . '&NomRuche=' . $ligne['nom_ruche'] . '&idDemande=' . $ligne['ID_attente'] . '">Accepter</a><a href="index.php?page=Refuser&idDemande=' . $ligne['ID_attente'] . '">Refuser</a></div>';
    }
} else {
    $demandes_ruches = "Aucune demande n'a été transmise.";
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des utilisateurs</title>
    <link rel="stylesheet" href="../styles/GestionUtilisateur.css">
    <link rel="stylesheet" href="../styles/styles_index_non_connecte.css">
</head>

<body>
    <header>
        <?= $header ?>
    </header>

    <main>
        <div class="pop_up_admin_demande">
            <?= $demandes_ruches ?>
            <?= $message ?>
        </div>
        <div class="pop_up_fixed_info_users">
            <div class="photo_left">

            </div>
            <div class="infos">
                <div class="user_name">
                    <h3>

                    </h3>
                </div>
                <div class="informations_and_icones">
                    <div class="info">
                        <div class="icone">

                        </div>
                        <div class="texte_info">
                            <p>Date d'inscription</p>
                            <p></p>
                        </div>
                    </div>
                    <div class="info">
                        <div class="icone">

                        </div>
                        <div class="texte_info">
                            <p>Nombre de notes</p>
                            <p></p>
                        </div>
                    </div>
                    <div class="info">
                        <div class="icone">

                        </div>
                        <div class="texte_info">
                            <p>Nombre de ruches</p>
                            <p></p>
                        </div>
                    </div>
                    <div class="info">
                        <div class="icone">

                        </div>
                        <div class="texte_info">
                            <p>Dernière connexion</p>
                            <p></p>
                        </div>
                    </div>
                </div>
                <div class="champs_perso">
                    <div class="NOM">

                    </div>
                    <div class="prenom">

                    </div>
                    <div class="mail">

                    </div>
                    <div class="mdp">

                    </div>
                </div>
                <div class="boutons">
                    <a class="reset_password" href="index.php?page=resetPassword&IDUser=<?= $idUser ?>">
                        Reinitialiser le mot de passe
                    </a>
                    <a class="delet_account" href="index.php?page=deletaccount&IDUser=<?= $idUser ?>">
                        Supprimer le compte
                    </a>
                </div>
            </div>
        </div>
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
            <!-- Ouais je rajoute le graph ici -->
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
    </script>
    <!-- <script src="../js/Utilisateurs.js"></script> -->
</body>

</html>