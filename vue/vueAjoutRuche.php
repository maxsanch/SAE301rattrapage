<?php

if($user[0]['Statut'] == 'admin'){
    $header = HEADER_admin;
}
else{
    $header = HEADER_connecté;
}


$footer = Footer_déconnecté;

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Information ruches</title>
    <link rel="stylesheet" media="(min-width: 620px)" href="../styles/styles_index_non_connecte.css">
</head>

<body>

    <header>
        <?= $header ?>
    </header>
    <form method="post" action="index.php?page=enregRuchePhoto&idRuche=<?= $_GET['idRuche'] ?>"
        enctype="multipart/form-data">
        <div class="form_elt">
            <input type="hidden" name="MAX_FILE_SIZE" value="20000000">
            <input type="file" class="texte" name="photoRuche" accept="image/jpeg, image/png">
        </div>
        <input type="submit" class="valid" name="ok" value="Valider">
    </form>
    <footer>
        <?= $footer ?>
    </footer>
</body>

</html>