<?php

// Définition du footer pour un utilisateur connecté
$header = HEADER_connecté;
$footer = Footer_connecté;

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERREUR</title>
    <link rel="stylesheet" href="../styles/styles_index_non_connecte.css">
    <link rel="stylesheet" media="(max-width: 1200px" href="../styles/Tablette.css">
    <link rel="stylesheet" media="(max-width: 620px)" href="../styles/styles_commun_mobile.css">
</head>
<body>
    <div>
        <div>Une Erreur est survenue</div>
        <?= $message ?>
    </div>
</body>
</html>