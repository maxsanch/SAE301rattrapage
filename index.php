<?php

session_start();

//lien vers le controleur

require 'config/config.php';
require "controleur/controleur.php";

// appel de la fonction accueil dans le controlleur qui permet d'afficher (normalement) l'index

try {
    if (isset($_SESSION['acces'])) {
        if (isset($_GET['page'])) {
            if ($_GET['page'] == "Ruches") {
                $message = '';
                ruches($message);
            } else if ($_GET['page'] == 'Notes') {
                notes();
            } else if ($_GET['page'] == 'Gestion') {
                $erreur1 = '';
                $erreur2 = '';
                $erreur3 = '';
                gestion_ruches($erreur1, $erreur2, $erreur3);
            } else if ($_GET['page'] == 'modif') {
                if (isset($_GET['ruche'])) {
                    $erreur = '';
                    modification_ruches($erreur);
                } else {
                    $erreur1 = "";
                    $erreur2 = "";
                    $erreur3 = "";
                    gestion_ruches($erreur1, $erreur2, $erreur3);
                }
            } else if ($_GET['page'] == 'quitter') {
                quitter();
            } else if ($_GET['page'] == 'ajoutRuche') {
                ajout($_POST['nomruche'], $_POST['id_ruche']);
            } else if ($_GET['page'] == 'modifier') {

                change($_POST['nomruche'], $_POST['id_ruche'], $_GET['ruche']);

            } else if ($_GET['page'] == 'suppression') {
                supprimer($_GET['ruche']);
            } else if ($_GET['page'] == 'Utilisateurs') {
                $message = '';
                $usersingle = "";
                utilisateurs($message, $usersingle);
            } else if($_GET['page'] == 'Photo_ruche' && isset($_GET['idRuche'])){
                AjoutPhotoRuche();
            } else if($_GET['page'] == 'modifnote' && isset($_POST['ruchelien'])){
                modifnote($_POST['ruchelien'], $_POST['contenu']);
            }
            else if($_GET['page'] == 'supprnote' && isset($_GET['idnote'])){
                supprimernote($_GET['idnote']);
            }
            else if($_GET['page'] == 'enregRuchePhoto'){
                EnregPhotoRuche($_GET['idRuche']);
            }
            else if($_GET['page'] == "changeprofilepicture"){
                changepdp($_GET['idUser']);
            }
            else if($_GET['page'] == 'modifprofil'){
                editprofil($_GET['idUser'], $_POST['nomuser'], $_POST['prenomuser'], $_POST['NewPassword'], $_POST['ConfirmationNewPassword'], $_POST['ancienmdp']);
            }
            else if($_GET['page'] == 'PhotoUser'){
                AjoutPhotoUser();
            }

            else if($_GET['page'] == 'enregUserPhoto') {
                EnregPhotoUser($_GET['idUser']);
            }
            else if ($_GET['page'] == 'Refuser') {
                refuser($_GET['idDemande']);
            } else if ($_GET['page'] == 'accepter') {
                accepter($_GET['IdRuche'], $_GET['IdUtilisateur'], $_GET['NomRuche'], $_GET['idDemande']);
            } else if($_GET['page'] == 'ajoutNote'){
                ajoutnote($_POST['ruchelien'], $_POST['contenu']);
            }
            else {
                $user = checkstatut();
                if ($user[0]['Statut'] == 'admin') {
                    if($_GET['page'] == 'informationsUser' && !empty($_GET['idUser'])){
                        infoUser($_GET['idUser']);
                    }
                    else if($_GET['page'] == "resetpassword" && !empty($_GET['iduser'])) {
                        resetpdw($_GET['iduser'], $_POST['mdp'], $_POST['confirmation']);
                    }
                    else if($_GET['page'] == "deletaccount" && !empty($_GET['IDUser'])){
                        deletaccount($_GET['IDUser']);
                    }
                    else{
                        accueil_admin();
                    }

                } else {
                    accueil_connecté();
                }
            }
        } else {
            $user = checkstatut();
            if ($user[0]['Statut'] == 'admin') {
                accueil_admin();
            } else {
                accueil_connecté();
            }
        }
    } else {
        if (isset($_GET['page'])) {
            if ($_GET['page'] == 'Connexion') {
                $erreur = '';
                connexion($erreur);
            } else if ($_GET['page'] == 'Inscription') {
                $erreur = '';
                inscription($erreur);
            } else if ($_GET['page'] == 'login') {
                login($_POST['email'], $_POST['MDP']);
            } else if ($_GET['page'] == 'signin') {
                signin($_POST['prenom'], $_POST['nom'], $_POST['email'], $_POST['MDP'], $_POST['MDP2']);
            } else {
                accueil();
            }
        } else {
            accueil();
        }
    }
} catch (Exception $e) {
    erreur($e->getMessage());
}