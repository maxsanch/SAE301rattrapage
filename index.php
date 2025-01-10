<?php

session_start();

//lien vers le controleur

require 'config/config.php';
require "controleur/controleur.php";

// appel de la fonction accueil dans le controlleur qui permet d'afficher les différentes pages

// vérifier si il n'y a pas d'erreurs

try {
    // verification de la connexion ou non de l'utilisateur
    if (isset($_SESSION['acces'])) {
        // regarder si le paramètre page est présent dans l'URL
        if (isset($_GET['page'])) {
            // regarder avec différents if else quels sont les paramètres transmis, en focntion du paramètre, afficher la bonne page

            if ($_GET['page'] == "Ruches") {
                // appel de la fonction ruches pour afficher la page des ruches
                $message = '';
                ruches($message);
            } else if ($_GET['page'] == 'Notes') {
                // affichage des notes
                notes();
            } else if ($_GET['page'] == 'Gestion') {
                // affichage de la page gestion des ruches avec les erreurs vides, les erreurs ici sont des messages a transmettre en fonction des actions réalisées par l'utilisateur
                $erreur1 = '';
                $erreur2 = '';
                $erreur3 = '';
                gestion_ruches($erreur1, $erreur2, $erreur3);
            } else if ($_GET['page'] == 'modif') {
                // regarder si ruche est défini ou pas afin de savoir vers quelle page renvoyer
                if (isset($_GET['ruche'])) {
                    // si il est défini, aller vers modification ruches
                    $erreur = '';
                    modification_ruches($erreur);
                } else {
                    // si il n'est pas défini, aller vers gestion ruches
                    $erreur1 = "";
                    $erreur2 = "";
                    $erreur3 = "";
                    gestion_ruches($erreur1, $erreur2, $erreur3);
                }
            } else if ($_GET['page'] == 'quitter') {
                // déconnexion de l'utilisateur
                quitter();
            } else if ($_GET['page'] == 'ajoutRuche') {
                // ajout d'une ruche dans la base de données
                ajout($_POST['nomruche'], $_POST['id_ruche']);
            } else if ($_GET['page'] == 'modifier') {
                // modification d'une ruche dans la base de données
                change($_POST['nomruche'], $_POST['id_ruche'], $_GET['ruche']);
            } else if ($_GET['page'] == 'suppression') {
                // suppression d'une ruche de la base de données
                supprimer($_GET['ruche']);
            } else if($_GET['page'] == 'Photo_ruche' && isset($_GET['idRuche'])){
                // vers la page d'ajout de photos pour les utilisateurs
                AjoutPhotoRuche();
            } else if($_GET['page'] == 'modifnote' && isset($_POST['ruchelien'])){
                // modification d'une note
                modifnote($_POST['ruchelien'], $_POST['contenu']);
            }
            else if($_GET['page'] == 'supprnote' && isset($_GET['idnote'])){
                // supppression d'une note
                supprimernote($_GET['idnote']);
            }
            else if($_GET['page'] == 'enregRuchePhoto'){
                // enregistrement de la photo mise choisie dans ajoutphotoruche
                EnregPhotoRuche($_GET['idRuche']);
            }
            else if($_GET['page'] == "changeprofilepicture"){
                // changer la pdp de l'utilisateur
                changepdp($_GET['idUser']);
            }
            else if($_GET['page'] == 'modifprofil'){
                // modifier son profil d'utilisateur
                editprofil($_GET['idUser'], $_POST['nomuser'], $_POST['prenomuser'], $_POST['NewPassword'], $_POST['ConfirmationNewPassword'], $_POST['ancienmdp']);
            }
            else if($_GET['page'] == 'ajoutNote'){
                // ajouter une note
                ajoutnote($_POST['ruchelien'], $_POST['contenu']);
            }
            else {
                $user = checkstatut();
                // vérifier si le statut est admin, pour avoir plus d'options
                if ($user[0]['Statut'] == 'admin') {
                    if($_GET['page'] == 'informationsUser' && !empty($_GET['idUser'])){
                        // informations pour chaques utilisateurs
                        infoUser($_GET['idUser']);
                    }
                    else if($_GET['page'] == "resetpassword" && !empty($_GET['iduser'])) {
                        // reset le mot de passe d'un utilisateur dans le cas d'un oubli
                        resetpdw($_GET['iduser'], $_POST['mdp'], $_POST['confirmation']);
                    }
                    else if($_GET['page'] == "deletaccount" && !empty($_GET['IDUser'])){
                        // supprimer le profil d'un utilisateur
                        deletaccount($_GET['IDUser']);
                    } else if ($_GET['page'] == 'Utilisateurs') {
                        // affichage de la page utilisateurs pour les admins
                        $message = '';
                        $usersingle = "";
                        utilisateurs($message, $usersingle);
                    }
                    else if ($_GET['page'] == 'Refuser') {
                        // refuser une demande d'ajotu de ruche
                        refuser($_GET['idDemande']);
                    } else if ($_GET['page'] == 'accepter') {
                        accepter($_GET['IdRuche'], $_GET['IdUtilisateur'], $_GET['NomRuche'], $_GET['idDemande']);
                    } 
                    else if($_GET['page'] == 'PhotoUser'){
                        // enregistrement en tant qu'administrateur d'une nouvelle photo dans le cas ou l'une d'elle est innapropriée
                        AjoutPhotoUser();
                    }
                    else if($_GET['page'] == 'enregUserPhoto') {
                        // enregistrer la photo d'un utilsiteur
                        EnregPhotoUser($_GET['idUser']);
                    }
                    else{
                        // accueil admin si rien eest bon ou qu'il n'y à par de pages définies
                        accueil_admin();
                    }

                } else {
                    // eccueil connecté si l'utilisateur n'est pas administrateur
                    accueil_connecté();
                }
            }
        } else {
            // si $_GET['page'] n'est pas définie, on vérifie si l'utilisateur est un administrateur ou non afin de savoir quelle page afficher
            $user = checkstatut();
            if ($user[0]['Statut'] == 'admin') {
                // affichage de la page administrateur
                accueil_admin();
            } else {
                // affichage de la page connectée non admin
                accueil_connecté();
            }
        }
    } else {
        // si la session n'est pas faite, mettre en place toute les pages accessibles
        if (isset($_GET['page'])) {
            if ($_GET['page'] == 'Connexion') {
                // accès à la page de connexion
                $erreur = '';
                connexion($erreur);
            } else if ($_GET['page'] == 'Inscription') {
                // accès à la page d'inscription
                $erreur = '';
                inscription($erreur);
            } else if ($_GET['page'] == 'login') {
                // connexion de l'utilisateur
                login($_POST['email'], $_POST['MDP']);
            } else if ($_GET['page'] == 'signin') {
                // enregistrement d'un nouveau compte
                signin($_POST['prenom'], $_POST['nom'], $_POST['email'], $_POST['MDP'], $_POST['MDP2']);
            } else {
                // accueil non connecté
                accueil();
            }
        } else {
            // accueil non connecté
            accueil();
        }
    }
} catch (Exception $e) {
    // erreur en cas d'echeque d'une action du try
    erreur($e->getMessage());
}