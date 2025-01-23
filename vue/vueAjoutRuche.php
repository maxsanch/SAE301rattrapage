<?php

// Vérifie si l'utilisateur a un statut d'administrateur
if ($user[0]['Statut'] == 'admin') {
    $header = HEADER_admin;  // Si admin, affiche le header pour admin
} else {
    $header = HEADER_connecté;  // Sinon, affiche le header pour utilisateur connecté
}

// Déclare le footer pour les utilisateurs non connectés
$footer = Footer_connecté;

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Information ruches</title>
    <link rel="stylesheet" href="../styles/ajoutphoto.css">
    <link rel="stylesheet" href="../styles/styles_index_non_connecte.css">
    <link rel="stylesheet" media="(max-width: 1200px)" href="../styles/Tablette.css">
    <link rel="stylesheet" media="(max-width: 620px)" href="../styles/styles_commun_mobile.css">
</head>

<body>

    <header>
        <!-- Affiche le header en fonction du statut de l'utilisateur -->
        <?= $header ?>
    </header>

    <div class="cache_fond">
        <!-- Section de fond caché, probablement pour un effet visuel -->
    </div>
    <div class="pop_up_admin_demande">
        <div class="topinfo">
            <h2>Boite de récéption</h2>
            <!-- Image permettant de fermer la boîte de réception -->
            <img id="croixboite" src="../img/svgcroixrefus.svg" alt="croix fermeture">
        </div>
        <!-- Affiche les demandes de ruches (données dynamiques) -->
        <?= $demandes_ruches ?>
    </div>
    <main>
        <!-- Formulaire d'ajout de photo pour une ruche spécifique -->
        <form method="post" action="index.php?page=enregRuchePhoto&idRuche=<?= $_GET['idRuche'] ?>"
            enctype="multipart/form-data">
            <div class="form_elt">
                <!-- Limite la taille maximale de fichier téléchargé -->
                <input type="hidden" name="MAX_FILE_SIZE" value="500000">
                <!-- Label pour l'input du fichier -->
                <label>
                    <span class="orange">Ajoutez </span> <span> Une photo. (max 500ko)</span>
                    <!-- Champ de téléchargement de photo -->
                    <input type="file" class="texte" name="photoRuche" accept="image/jpeg, image/png" hidden>
                </label>
            </div>
            <!-- Bouton de soumission du formulaire -->
            <input class="boutbout" type="submit" class="valid" name="ok" value="Valider">
        </form>
    </main>

    <footer>
        <!-- Affiche le footer en fonction du statut de l'utilisateur -->
        <?= $footer ?>
    </footer>
    <script src="../js/script_commun_header.js"></script>
    <script>
        // Scripts spécifiques pour les admins
        <?= $fonctionadmin ?>
        <?= $lenombre ?>
    </script>
</body>

</html>