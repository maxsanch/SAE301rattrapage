<?php

$header = HEADER_admin;

$footer = Footer_déconnecté;

?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajout de photo pour les utilisateurs</title>
    <link rel="stylesheet" href="../styles/ajoutphoto.css">
    <link rel="stylesheet" media="(min-width: 620px)" href="../styles/styles_index_non_connecte.css">
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
            <img id="croixboite" src="../img/svgcroixrefus.svg" alt="croix fermeture">
        </div>
        <?= $demandes_ruches ?>
    </div>

    <main>

        <form method="post" action="index.php?page=enregUserPhoto&idUser=<?= $_GET['idUser'] ?>"
            enctype="multipart/form-data">
            <div class="form_elt">
                <input type="hidden" name="MAX_FILE_SIZE" value="500000">
                <label>
                    <span class="orange">Ajoutez </span> <span> Une photo.</span>
                    <input type="file" class="texte" name="photoUser" accept="image/jpeg, image/png" hidden>
                </label>
            </div>
            <input class="boutbout" type="submit" class="valid" name="ok" value="Valider">
        </form>
    </main>


    <footer>
        <?= $footer ?>
    </footer>

    <script>
        <?= $fonctionadmin ?>
        <?= $lenombre ?>
    </script>
</body>



</html>