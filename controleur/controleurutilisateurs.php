<?php 

// récupération des différents modèles afin de faire fonctionner les fonctions

require_once "modèle/utilisateurs.php";

/******************************/
/***PROFILE DE L'UTILISATEUR***/
/******************************/

// ajouter une photo a un utilisateur : afichage de la page
function AjoutPhotoUser()
{
    $checkuser = new utilisateurs();
    $user = $checkuser->GetUser($_SESSION['acces']);
    // pour chercher les ruches
    $demandes_ruches = demandesruches()[0];
    $lenombre = demandesruches()[1];
    $fonctionadmin = demandesruches()[2];
    require "vue/vueAjoutUsers.php";
}
// enregistrement de la photo vers la bdd
function EnregPhotoUser($idUser)
{
    $ruches = new utilisateurs();
    $erreur = $ruches->updateUserPhoto($idUser);
    $usersingle = "";
    utilisateurs($erreur, $usersingle);
}

// changer la photo de profil vers la bdd en tant qu'utilisateur
function changepdp($idUser)
{
    $user = new utilisateurs();
    // enregistrement de la photo
    $user->updateUserPhoto($idUser);
    $erreur1 = '';
    $erreur2 = $user->updateUserPhoto($idUser);
    $erreur3 = '';

    gestion_ruches($erreur1, $erreur2, $erreur3);
}
// changer les informations du profil en tant qu'utilisateur
function editprofil($iduser, $nom, $prenom, $newpassword, $confirm, $ancienpdw)
{
    $nom_user = new utilisateurs();
    $user = $nom_user->GetUserbyID($iduser);

    if (!empty($user)) {
        // regarder si le password est juste pour changer les infos
        if (password_verify($ancienpdw, $user[0]['MotDePasse'])) {
            // regarder si le nom change ou le mot de passe ou les deux
            if (!empty($newpassword) && !empty($confirm)) {
                if ($newpassword == $confirm) {
                    if (!empty($nom) && !empty($prenom)) {
                        $mdpgood = password_hash($newpassword, PASSWORD_DEFAULT);
                        // changer le nom de l'utilisateur 
                        $nom_user->edituserwithpdw($nom, $prenom, $mdpgood, $iduser);
                        $erreur1 = '';
                        $erreur2 = '';
                        $erreur3 = "vos informations ont été mises à jour.";
                        gestion_ruches($erreur1, $erreur2, $erreur3);
                    } else {
                        // erreur
                        $erreur1 = '';
                        $erreur2 = '';
                        $erreur3 = 'veuillez remplir tout les champs pour modifier.';
                        gestion_ruches($erreur1, $erreur2, $erreur3);
                    }
                } else {
                    // erreur
                    $erreur1 = '';
                    $erreur2 = '';
                    $erreur3 = "les mots de passes ne correspondent pas.";
                    gestion_ruches($erreur1, $erreur2, $erreur3);
                }
            } else {

                if (!empty($nom) && !empty($prenom)) {
                    // changer le mot de passe
                    $mdpgood = password_hash($newpassword, PASSWORD_DEFAULT);
                    $nom_user->editusernopdw($nom, $prenom, $iduser);
                    $erreur1 = '';
                    $erreur2 = '';
                    $erreur3 = "vos informations ont été mises à jour.";
                    gestion_ruches($erreur1, $erreur2, $erreur3);
                } else {
                    $erreur1 = '';
                    $erreur2 = '';
                    $erreur3 = 'veuillez remplir tout les champs pour modifier.';
                    gestion_ruches($erreur1, $erreur2, $erreur3);
                }
            }
        } else {
            $erreur3 = 'mot de passe incorrecte';
            $erreur2 = '';
            $erreur1 = '';
            gestion_ruches($erreur1, $erreur2, $erreur3);
        }
    } else {
        $erreur1 = '';
        $erreur2 = '';
        $erreur3 = 'impossible de trouver cet utilisateur';
        gestion_ruches($erreur1, $erreur2, $erreur3);
    }
}
// récupérer les informations d'un utilisateur
function infoUser($id)
{
    $utilisateur = new utilisateurs();
    $usersingle = $utilisateur->GetUserbyID($id);
    $message = "";
    utilisateurs($message, $usersingle);
}
// changer le mot de passe
function resetpdw($id, $mdp1, $mdp2)
{
    $usersingle = "";

    $modifuser = new utilisateurs();

    if (!empty($mdp1) && !empty($mdp2)) {
        if ($mdp1 == $mdp2) {
            // nouveau mot de passe
            $mdphash = password_hash($mdp1, PASSWORD_DEFAULT);
            // edit password de l'utilisateur
            $modifuser->changepasswordadmin($id, $mdphash);
            $message = "Le mot de passe à bien été modifié";
        } else {
            // erreur si les deux mots de passe (les nouveaux) ne sont pas les mêmes
            $message = "Les mots de passes ne correspondent pas.";
        }

    } else {
        // erreur
        $message = "Le mot de passe entré est vide";
    }

    utilisateurs($message, $usersingle);
}

function deletmyaccount()
{
    $user = new utilisateurs();
    $utilisateur = $user->GetUser($_SESSION['acces']);

    $id = $utilisateur[0]['Id_utilisateur'];

    $user->deletuser($id);
    $user->deletbrother($id);

    // suppression de la session et des cookies de ce dernier
    session_destroy();
    setcookie(session_name(), '', time() - 1, "/");
    accueil();
}
