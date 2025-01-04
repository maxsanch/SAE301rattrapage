<?php

// json decode
// file_get_contents
// password_hash
// password verify

require_once "modèle/utilisateurs.php";
require_once "modèle/ruches.php";
require_once "modèle/notes.php";

function accueil()
{
    require "vue/vueIndex.php";
}

function accueil_connecté()
{
    $getuser = new utilisateurs();
    $utilisateur = $getuser->GetUser($_SESSION['acces']);
    $ruche = new ruches();
    $getruche = $ruche->getruches($utilisateur[0]['Id_utilisateur']);
    $fichier = file_get_contents("js/data_ruche.json");
    $ruches = json_decode($fichier);

    require "vue/vueIndexConnecte.php";
}
function accueil_admin()
{
    $getUser = new utilisateurs();
    $GetAllUser = $getUser->GetUserAdmin();
    $utilisateur = $getUser->GetUser($_SESSION['acces']);
    $ruche = new ruches();
    $getruche = $ruche->getruches($utilisateur[0]['Id_utilisateur']);
    $fichier = file_get_contents("js/data_ruche.json");
    $ruches = json_decode($fichier);

    require "vue/vueIndexConnecteAdmin.php";
}

function connexion($erreur)
{
    require "vue/vueConnexion.php";
}

function inscription($erreur)
{
    require "vue/vueInscription.php";
}

function erreur($message)
{
    echo $message;
}


function quitter()
{
    session_destroy();
    setcookie(session_name(), '', time() - 1, "/");
    accueil();
}
function login($nom, $mdp)
{
    $nom_user = new utilisateurs();
    $user = $nom_user->GetUser($nom);
    if (!empty($user)) {
        if (password_verify($mdp, $user[0]['MotDePasse'])) {
            $_SESSION['acces'] = $user[0]['Mail'];
            updateco($user[0]['Id_utilisateur']);
            if ($user[0]['Statut'] == 'admin') {
                accueil_admin();
            } else {
                accueil_connecté();
            }
        } else {
            $erreur = '<b>mot de passe incorrecte.</b>';
            connexion($erreur);
        }
    } else {
        $erreur = '<b>Identifiant invalide</b>';
        connexion($erreur);
    }
}
function signin($prenom, $nom, $email, $mdp, $mdp2)
{
    $nom_user = new utilisateurs();
    $user = $nom_user->GetUser($email);
    $insc = new utilisateurs();
    if(empty($user)){
        if (!empty($prenom) && !empty($nom) && !empty($email) && !empty($mdp) && !empty($mdp2)) {
            if ($mdp == $mdp2) {
                $mdpgood = password_hash($mdp, PASSWORD_DEFAULT);
                $insc->inscrire($prenom, $nom, $email, $mdpgood);
                $user = $insc->GetUser($email);
                $_SESSION['acces'] = $user[0]['Mail'];
                accueil_connecté();
    
            } else {
                $erreur = "<b>Les mots de passe ne correspondent pas.</b>";
                inscription($erreur);
            }
        } else {
            $erreur = "<b>Veillez à remplir tout les champs</b>";
            inscription($erreur);
        }
    }
    else{
        $erreur = "<b>Un compte avec la même adresse e-mail existe déjà.</b>";
            inscription($erreur);
    }

}

function ruches($message)
{
    $getuser = new utilisateurs();
    $utilisateur = $getuser->GetUser($_SESSION['acces']);
    $ruche = new ruches();
    $getruche = $ruche->getruches($utilisateur[0]['Id_utilisateur']);

    $fichier = file_get_contents("js/data_ruche.json");
    $ruches = json_decode($fichier);

    //$i="000001";

    require "vue/vueInfoRuches.php";
}

function gestion_ruches($erreur1, $erreur2, $erreur3)
{
    $checkuser = new utilisateurs();
    $user = $checkuser->GetUser($_SESSION['acces']);
    $ruches = new ruches();
    $mesruches = $ruches->getruches($user[0]['Id_utilisateur']);

    require "vue/vueGestionRuches.php";
}

function modification_ruches($erreur)
{
    $ruches = new ruches();
    $checkuser = new utilisateurs();
    $user = $checkuser->GetUser($_SESSION['acces']);
    $mesruches = $ruches->getruches($user[0]['Id_utilisateur']);
    require "vue/modificationRuche.php";
}


function notes()
{
    require "vue/vueNotes.php";
}

function ajout($nom, $id)
{
    $checkuser = new utilisateurs();
    $addruche = new ruches();
    $user = $checkuser->GetUser($_SESSION['acces']);
    if (!empty($user)) {


        if (!empty($nom) && !empty($id)) {
            $addruche->fileattente($user[0]['Id_utilisateur'], $id, $nom, $user[0]['Prenom']);
            $erreur2 ='';
            $erreur3 ='';
            $erreur1 = 'Votre demande à bien été envoyée';
            gestion_ruches($erreur1, $erreur2, $erreur3);

        } else {
            $erreur1 = 'veuillez remplir les champs obligatoires';
            $erreur2 ='';
            $erreur3 ='';
            gestion_ruches($erreur1, $erreur2, $erreur3);
        }
    } else {
        $erreur1 = 'inscription échouée';
        $erreur2 ='';
        $erreur3 ='';
        gestion_ruches($erreur1, $erreur2, $erreur3);
    }
}

function change($nom, $id, $idancien)
{

    $checkuser = new utilisateurs();
    $addruche = new ruches();
    $user = $checkuser->GetUser($_SESSION['acces']);


    if (!empty($user)) {
        if ($id == $idancien) {

            if (!empty($nom) && !empty($id)) {
                $addruche->update($nom, $id, $idancien);
                $addruche->updategerant($idancien, $id, $user[0]['Id_utilisateur']);
                $erreur = 'La ruche à bien été modifiée.';
                modification_ruches($erreur);
            } else {
                $erreur = 'veuillez remplir les champs obligatoires';
                modification_ruches($erreur);
            }
        } else {
            $verif = $addruche->checkruche($id);
            if (!empty($verif)) {
                $erreur = 'Cet ID est déjà utilisé pour une autre ruche.';
                modification_ruches($erreur);
            } else {
                if (!empty($nom) && !empty($id)) {
                    $addruche->update($nom, $id, $idancien);
                    $addruche->updategerant($idancien, $id, $user[0]['Id_utilisateur']);
                    $erreur = 'La ruche à bien été modifiée.';
                    modification_ruches($erreur);
                } else {
                    $erreur = 'veuillez remplir les champs obligatoires';
                    modification_ruches($erreur);
                }
            }
        }

    } else {
        $erreur = 'modification échouée';
        modification_ruches($erreur);
    }
}

function supprimer($id)
{

    $spr = new ruches();
    $spr->supprimer($id);
    $spr->deletuser($id);
    $erreur1 = "La ruche à bien été supprimée.";
    $erreur2 ='';
    $erreur3 ='';
    gestion_ruches($erreur1, $erreur2, $erreur3);
}

function checkstatut(){
    $checkuser = new utilisateurs();

    $user = $checkuser->GetUser($_SESSION['acces']);

    return $user;
}

function utilisateurs($message, $usersingle){
    $getUser = new utilisateurs();
    $GetAllUser = $getUser->GetUserAdmin();
    $getalldemandes = new ruches();
    $demandes = $getalldemandes->getdemandes();
    $ruches = $getalldemandes->getAllruches();
    $notescount = new notes();


    if(!empty($usersingle)){
        $ruchesingleuser = $getalldemandes->getruches($usersingle[0]['Id_utilisateur']);
        $count = $notescount->getnote($usersingle[0]['Id_utilisateur']);
    }
    else{
        $ruchesingleuser = "";
        $count = "";
    }
    require 'vue/vueUtilisateurs.php';
}

function rucheSingleUser($id){
    $ruche = new ruches();

    $sesruches = $ruche->getruches($id);

    return $sesruches;
}

function updateco($id){
    $user = new utilisateurs();
    $user->updatedate($id);
}

function refuser($id){
    $refus = new ruches();
    $refus->deletask($id);

    $message = 'La demande à bien été suprimée.';
    $usersingle = "";

    utilisateurs($message, $usersingle);
}

function accepter($idruche, $iduser, $nomruche, $idattente){
            $addruche = new ruches();
            $verif = $addruche->checkruche($idruche);

            if (!empty($verif)) {
                $verifuser = $addruche->checkgerer($iduser, $idruche);

                if (!empty($verifuser)) {
                    $message = 'Cet utilisateur est déjà administrateur de la ruche n°'.$idruche.'.';
                    $usersingle = '';
                    utilisateurs($message, $usersingle);
                } else {

                    $addruche->gerant($iduser, $idruche);
                    $addruche->deletask($idattente);
                    $message = "L'utilisateur est maintenant administrateur de la ruche.";
                    $usersingle = '';
                    utilisateurs($message, $usersingle);
                }
            } else {
                $addruche->deletask($idattente);
                $message = 'La ruche a bien été assignée.';
                $addruche->ajouter($nomruche, $idruche);
                $addruche->gerant($iduser, $idruche);
                $usersingle = '';
                utilisateurs($message, $usersingle);
            }

}

function ajoutnote($ruches, $notecontent){
    if (isset($_POST['ok'])) {
        if(!empty($ruches)){
            $contenu = htmlspecialchars($notecontent);

            $ruche = new notes();
    
            $ruche->addnote($ruches, $contenu);

            $message = 'La note à bien été enregistrée';

            ruches($message);
        }
        else{
            $message = 'Une erreur est survenue';
            ruches($message);
        }


    } else {
        $message = 'Une erreur est survenue';
        ruches($message);
    };
}

function afficher_notes($id){

    $pourruche = new notes();

    $lesnotes = $pourruche->afficher_note($id);
    return $lesnotes;
}


function AjoutPhotoRuche(){
    $checkuser = new utilisateurs();
    $user = $checkuser->GetUser($_SESSION['acces']);
    require "vue/vueAjoutRuche.php";
}


function AjoutPhotoUser(){
    $checkuser = new utilisateurs();
    $user = $checkuser->GetUser($_SESSION['acces']);
    require "vue/vueAjoutUsers.php";
}

function EnregPhotoRuche($idRuche){
    $ruches = new ruches();
    $ruches->updateRuchePhoto($idRuche);
    $erreur2 = "Photo importée avec succès";
    $erreur3 ='';
    $erreur1 ='';
    gestion_ruches($erreur1, $erreur2, $erreur3);
}

function EnregPhotoUser($idUser){
    $ruches = new utilisateurs();
    $ruches->updateUserPhoto($idUser);
    $erreur = '';
    $usersingle = "";
    utilisateurs($erreur, $usersingle);
}

function changepdp($idUser){
    $user = new utilisateurs();
    $user->updateUserPhoto($idUser);
    $erreur1 ='';
    $erreur2 ='';
    $erreur3 = '';
    gestion_ruches($erreur1, $erreur2, $erreur3);
}

function editprofil($iduser, $nom, $prenom, $newpassword, $confirm, $ancienpdw){
    $nom_user = new utilisateurs();
    $user = $nom_user->GetUserbyID($iduser);
    
    if (!empty($user)) {
        if (password_verify($ancienpdw, $user[0]['MotDePasse'])) {
            
            if(!empty($newpassword) && !empty($confirm)){
                if($newpassword == $confirm){
                    if(!empty($nom) && !empty($prenom)){
                        $mdpgood = password_hash($newpassword, PASSWORD_DEFAULT);
                        
                        $nom_user->edituserwithpdw($nom, $prenom, $mdpgood, $iduser);
                        $erreur1 ='';
                        $erreur2 ='';
                        $erreur3 = "vos informations ont été mises à jour.";
                        gestion_ruches($erreur1, $erreur2, $erreur3);
                    }
                    else{
                        $erreur1 ='';
                        $erreur2 ='';
                        $erreur3 ='veuillez remplir tout les champs pour modifier.';
                        gestion_ruches($erreur1, $erreur2, $erreur3);
                    }
                }
                else{
                    $erreur1 ='';
                    $erreur2 ='';
                    $erreur3 = "les mots de passes ne correspondent pas.";
                    gestion_ruches($erreur1, $erreur2, $erreur3);
                }
            }
            else{

                if(!empty($nom) && !empty($prenom)){
                    $mdpgood = password_hash($newpassword, PASSWORD_DEFAULT);
                    $nom_user->editusernopdw($nom, $prenom, $iduser);
                    $erreur1 ='';
                    $erreur2 ='';
                    $erreur3 = "vos informations ont été mises à jour.";
                    gestion_ruches($erreur1, $erreur2, $erreur3);
                }
                else{
                    $erreur1 ='';
                    $erreur2 ='';
                    $erreur3 ='veuillez remplir tout les champs pour modifier.';
                    gestion_ruches($erreur1, $erreur2, $erreur3);
                }
            }
        }
        else{
            $erreur3 = 'mot de passe incorrecte';
            $erreur2 = '';
            $erreur1 = '';
            gestion_ruches($erreur1, $erreur2, $erreur3);
        }
    }
    else{
        $erreur1 = '';
        $erreur2 = '';
        $erreur3 = 'impossible de trouver cet utilisateur';
        gestion_ruches($erreur1, $erreur2, $erreur3);
    }
}

function infoUser($id){
    $utilisateur = new utilisateurs();
    $usersingle = $utilisateur->GetUserbyID($id);
    $message = "";
    utilisateurs($message, $usersingle);
}

function resetpdw($id, $mdp1, $mdp2){
    $usersingle = "";
    
    $modifuser = new utilisateurs();

    if(!empty($mdp1) && !empty($mdp2)){
        if($mdp1 == $mdp2){
            $mdphash = password_hash($mdp1, PASSWORD_DEFAULT);
            $modifuser->changepasswordadmin($id, $mdphash);
            $message = "Le mot de passe à bien été modifié";
        }
        else{
            $message = "Les mots de passes ne correspondent pas.";
        }

    }
    else{
        $message = "Le mot de passe entré est vide";
    }

    utilisateurs($message, $usersingle);
}


function supprimernote($id){
    $message = "la note à bien été supprimée.";

    $note = new notes();
    $note->supprimer($id);
    ruches($message);
}

function modifnote($id, $content){
    $message = "la note à bien été modifiée.";
    $note = new notes();
    $note->modifier($id, $content);
    ruches($message);
}

function deletaccount($id){
    $user = new utilisateurs();

    $user->deletuser($id);
    $message = "L'utilisateur à bien été supprimé";
    $usersingle = '';

    utilisateurs($message, $usersingle);
}