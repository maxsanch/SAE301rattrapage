<?php

// Définition du header pour les administrateurs
$header = HEADER_admin;

// Définition du footer pour les utilisateurs non connectés
$footer = Footer_connecté;

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajout de photo pour les utilisateurs</title>
    <link rel="stylesheet" href="../styles/ajoutphoto.css">
    <link rel="stylesheet" href="../styles/styles_index_non_connecte.css">
    <link rel="stylesheet" media="(max-width: 620px)" href="../styles/styles_commun_mobile.css">
</head>

<body>
    <header>
        <!-- Affiche le header pour l'administrateur -->
        <?= $header ?>
    </header>

    <div class="cache_fond">
        <!-- Section de fond caché, utilisée peut-être pour un effet visuel -->
    </div>

    <div class="pop_up_admin_demande">
        <div class="topinfo">
            <h2>Boite de récéption</h2>
            <!-- Image pour fermer la boîte de réception -->
            <img id="croixboite" src="../img/svgcroixrefus.svg" alt="croix fermeture">
        </div>
        <!-- Affiche les demandes relatives aux ruches -->
        <?= $demandes_ruches ?>
    </div>

    <main>
        <!-- Formulaire pour ajouter une photo d'utilisateur -->
        <form method="post" action="index.php?page=enregUserPhoto&idUser=<?= $_GET['idUser'] ?>"
            enctype="multipart/form-data">
            <div class="form_elt">
                <!-- Limite la taille maximale de fichier téléchargé (500Ko ici) -->
                <input type="hidden" name="MAX_FILE_SIZE" value="500000">
                <!-- Label pour l'input de téléchargement de photo -->
                <label>
                    <span class="orange">Ajoutez </span> <span> Une photo. (max 500ko)</span>
                    <!-- Champ pour sélectionner le fichier image (acceptant JPEG et PNG uniquement) -->
                    <input type="file" class="texte" name="photoUser" accept="image/jpeg, image/png" hidden>
                </label>
            </div>
            <!-- Bouton pour valider le formulaire -->
            <input class="boutbout" type="submit" class="valid" name="ok" value="Valider">
        </form>
    </main>

    <footer>
        <!-- Affiche le footer pour les utilisateurs non connectés -->
        <?= $footer ?>
    </footer>
    <script src="../js/script_commun_header.js"></script>
    <script>
        // Exécution de fonctions spécifiques à l'admin (et autres)
        <?= $fonctionadmin ?>
        <?= $lenombre ?>
    </script>
</body>

</html>