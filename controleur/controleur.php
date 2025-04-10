<?php

// fonction utiles :
// json decode
// file_get_contents
// password_hash
// password verify

// récupération des différents modèles afin de faire fonctionner les fonctions

require_once "modèle/utilisateurs.php";
require_once "modèle/ruches.php";
require_once "modèle/notes.php";
require_once "modèle/connexions.php";

function erreur($message){
    require "vue/vueErreur.php";
}

/*************************************/
/***MISE A JOURS CONNEXION ET ANNEE***/
/*************************************/

// réinitialisation ou ajout d'un nombre dans la base de données en fonction de la connexion, le premier de l'an, la première connexion reinitialsie les connextion afin d'être en accord avec le graphique du tableau de bord de la page gestion utilisateurs
function testetresetannée()
{
    $connexion = new connexion(); // Accès à la classe "connexion".
    $currentyear = $connexion->getannee(); // Récupération de l'année actuelle depuis la base de données.

    // Vérifie si l'année actuelle en base est différente de l'année actuelle.
    if ($currentyear != date('Y')) {
        $ajouterun = $currentyear + 1; // Incrémente l'année.
        $connexion->maj($ajouterun); // Met à jour l'année dans la base de données.
        $connexion->resetmois(); // Réinitialise les données mensuelles.
    } else {
        $mois = date('m'); // Récupère le mois actuel.

        $currentnombre = $connexion->getcountmois($mois); // Récupère le nombre de connexions pour le mois actuel.
        $nb = (int) $currentnombre + 1; // Incrémente le nombre de connexions.
        $connexion->ajouter($nb, (int) $mois); // Met à jour le nombre de connexions pour le mois actuel.
    }
}

/**************************/
/*********ACCUEILS*********/
/**************************/


// affichage de la page d'accueil

function accueil()
{
    require "vue/vueIndex.php";
}

// Fonction pour afficher la page d'accueil après connexion.
function accueil_connecté()
{
    $getuser = new utilisateurs(); // Accès à la classe "utilisateurs".
    $utilisateur = $getuser->GetUser($_SESSION['acces']); // Récupère les informations de l'utilisateur connecté via la session.

    $ruche = new ruches(); // Accès à la classe "ruches".
    $getruche = $ruche->getruches($utilisateur[0]['Id_utilisateur']); // Récupère les ruches associées à l'utilisateur.

    $fichier = file_get_contents("js/data_ruche.json"); // Récupérer le fichier JSON contenant les données des ruches.
    $ruches = json_decode($fichier); // Décodage

    require "vue/vueIndexConnecte.php";
}

// affichage de la page admin
function accueil_admin()
{
    // Accès à la classe utilisateurs.
    $getUser = new utilisateurs();

    // Récupération de la liste des utilisateurs.
    $GetAllUser = $getUser->GetUserAdmin();

    // Récupération des informations de l'utilisateur connecté via la session.
    $utilisateur = $getUser->GetUser($_SESSION['acces']);

    // Accès à la classe "ruches".
    $ruche = new ruches();

    // Récupération des ruches associées à l'utilisateur connecté.
    $getruche = $ruche->getruches($utilisateur[0]['Id_utilisateur']);

    // Lecture d'un fichier JSON.
    $fichier = file_get_contents("js/data_ruche.json");
    $ruches = json_decode($fichier);

    // Appel de la fonction "demandesruches".
    $demandes_ruches = demandesruches()[0];
    $lenombre = demandesruches()[1];
    $fonctionadmin = demandesruches()[2];

    require "vue/vueIndexConnecteAdmin.php";
}

/**********************/
/***FONCTIONS ADMINS***/
/**********************/

// fonction pour récupérer uniquement le statut de l'utilisateur et optimiser les voyages avec la bdd

function checkstatut()
{
    $checkuser = new utilisateurs();

    $user = $checkuser->GetUser($_SESSION['acces']);

    return $user;
}

// affichage de la page d'ajout des utilisateurs

function utilisateurs($message, $usersingle)
{
    $getUser = new utilisateurs();
    $GetAllUser = $getUser->GetUserAdmin();
    $getalldemandes = new ruches();
    $ruches = $getalldemandes->getAllruches();

    $nombreconnex = new connexion();
    $nombreparmois = $nombreconnex->getallmois();
    $notescount = new notes();

    // pour chercher les demandes de ruches

    $demandes_ruches = demandesruches()[0];
    $lenombre = demandesruches()[1];
    $fonctionadmin = demandesruches()[2];

    // chercher le nombre de ruche d'un utilisateur : si cest vide, aucune info n'est transmise pour éviter les bugs

    if (!empty($usersingle)) {
        $ruchesingleuser = $getalldemandes->getruches($usersingle[0]['Id_utilisateur']);
        $count = $notescount->getnote($usersingle[0]['Id_utilisateur']);
    } else {
        $ruchesingleuser = "";
        $count = "";
    }
    require 'vue/vueUtilisateurs.php';
}

// affichage des ruches d'un utilisateur unique

function rucheSingleUser($id)
{
    $ruche = new ruches();
    // avoir toute les ruches d'un utilisateur
    $sesruches = $ruche->getruches($id);

    return $sesruches;
}
// update de la dernière fois ou l'utilisateur s'est connecté pour l'admin
function updateco($id)
{
    $user = new utilisateurs();
    $user->updatedate($id);
}

// refus de l'ajout d'une ruche
function refuser($id)
{
    $refus = new ruches();
    $refus->deletask($id);

    // message transmis

    $message = '<div class="opuped">La demande à bien été suprimée.</div>';
    $usersingle = "";

    // retour a la page des utilisateurs

    utilisateurs($message, $usersingle);
}

// accepter l'ajout d'un ruche

function accepter($idruche, $iduser, $nomruche, $idattente)
{
    $addruche = new ruches();
    $verif = $addruche->checkruche($idruche);

    // regerder sir l'id ruche existe pas déjà, sinon, mettre en administrateur la personen concernee
    if (!empty($verif)) {
        $verifuser = $addruche->checkgerer($iduser, $idruche);

        if (!empty($verifuser)) {
            // message transmis si ce dernier est déjà administrateur, et renvoie vers la page de gestion de utilisateurs 
            $message = '<div class="opuped">Cet utilisateur est déjà administrateur de la ruche n°' . $idruche . '.</div>';
            $addruche->deletask($idattente);
            $usersingle = '';
            utilisateurs($message, $usersingle);
        } else {
            // ajout de l'utilisateur en tant qu'administrateur de la ruche concernée
            $addruche->gerant($iduser, $idruche);
            $addruche->deletask($idattente);
            $message = "<div class='opuped'>L'utilisateur est maintenant administrateur de la ruche.</div>";

            $usersingle = '';
            utilisateurs($message, $usersingle);
        }
    } else {
        // ajout de l'utilisateur a la ruche concernée
        $addruche->deletask($idattente);
        $message = '<div class="opuped">La ruche a bien été assignée.</div>';
        $addruche->ajouter($nomruche, $idruche);
        $addruche->gerant($iduser, $idruche);
        $usersingle = '';
        utilisateurs($message, $usersingle);
    }
}
// supprimer un compte en tant qu'administrateur
function deletaccount($id)
{
    $user = new utilisateurs();
    // suppresion de l'utilisateur
    $user->deletuser($id);
    $user->deletbrother($id);
    $message = "L'utilisateur à bien été supprimé.";
    $usersingle = '';

    utilisateurs($message, $usersingle);
}
