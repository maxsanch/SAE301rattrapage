<?php

// récupération des différents modèles afin de faire fonctionner les fonctions

require_once "modèle/utilisateurs.php";
require_once "modèle/ruches.php";
require_once "modèle/notes.php";
require_once "modèle/connexions.php";

/****************************************/
/***INFORMATIONS CONCERNANT LES RUCHES***/
/****************************************/

// affichage de la page des ruches
function ruches($message)
{
    // Accès à la classe utilisateurs.
    $getuser = new utilisateurs();

    // Récupération des informations de l'utilisateur via la session.
    $utilisateur = $getuser->GetUser($_SESSION['acces']);

    // Accès à la classe ruches.
    $ruche = new ruches();

    // Récupération des ruches associées à l'utilisateur connecté, identifiées par son ID.
    $getruche = $ruche->getruches($utilisateur[0]['Id_utilisateur']);

    // Chargement des données des ruches depuis le JSON.
    $fichier = file_get_contents("js/data_ruche.json");

    // Décodage des données JSON en tableau PHP pour pouvoir les manipuler.
    $ruches = json_decode($fichier);

    // Gestion des demandes de ruches pour un utilisateur administrateur.

    $demandes_ruches = demandesruches()[0];
    $lenombre = demandesruches()[1];
    $fonctionadmin = demandesruches()[2];

    require "vue/vueInfoRuches.php";
}

// affichage de la page de gestion des ruches

function gestion_ruches($erreur1, $erreur2, $erreur3)
{
    $checkuser = new utilisateurs();
    $user = $checkuser->GetUser($_SESSION['acces']);
    $ruches = new ruches();
    $mesruches = $ruches->getruches($user[0]['Id_utilisateur']);

    // pour chercher les ruches

    $demandes_ruches = demandesruches()[0];
    $lenombre = demandesruches()[1];
    $fonctionadmin = demandesruches()[2];

    require "vue/vueGestionRuches.php";
}


// fonction pour modifier les informations d'une ruche, un utilisateur ne peux pas modifier l'id d'une ruche pour des raisons de sécurité
function modification_ruches($erreur)
{
    $ruches = new ruches();
    $checkuser = new utilisateurs();
    $user = $checkuser->GetUser($_SESSION['acces']);
    $mesruches = $ruches->getruches($user[0]['Id_utilisateur']);

    // pour chercher les ruches

    $demandes_ruches = demandesruches()[0];
    $lenombre = demandesruches()[1];
    $fonctionadmin = demandesruches()[2];

    require "vue/modificationRuche.php";
}

// fonction pour changer des informations sur la ruche (fonction liée à la bdd)
function change($nom, $idancien)
{

    $checkuser = new utilisateurs();
    $addruche = new ruches();
    $user = $checkuser->GetUser($_SESSION['acces']);


    if (!empty($user)) {
        // si tout est défini, changement des informations de la ruche
        if (!empty($nom)) {
            $addruche->update($nom, $idancien);
            $erreur = 'La ruche à bien été modifiée.';
            modification_ruches($erreur);
        } else {
            // erreur
            $erreur = 'veuillez remplir les champs obligatoires';
            modification_ruches($erreur);
        }
    } else {
        // erreur globale
        $erreur = 'modification échouée';
        modification_ruches($erreur);
    }
}

// fonction pour supprimer une ruche

function supprimer($id)
{
    // suppression d'une ruche
    $spr = new ruches();
    $spr->deletuser($id);
    $erreur1 = "La ruche à bien été supprimée.";
    $erreur2 = '';
    $erreur3 = '';
    // retour a la gestion des ruches après la suppression
    gestion_ruches($erreur1, $erreur2, $erreur3);
}

// ajouter une photo pour les ruches : affichage de la page
function AjoutPhotoRuche()
{
    $checkuser = new utilisateurs();
    $user = $checkuser->GetUser($_SESSION['acces']);

    // pour chercher les ruches

    $demandes_ruches = demandesruches()[0];
    $lenombre = demandesruches()[1];
    $fonctionadmin = demandesruches()[2];
    require "vue/vueAjoutRuche.php";
}

// enregistrement de la photo vers la bdd

function EnregPhotoRuche($idRuche)
{
    $ruches = new ruches();
    // enregistrement de la photo
    $erreur1 = $ruches->updateRuchePhoto($idRuche);
    $erreur3 = '';
    $erreur2 = '';
    gestion_ruches($erreur1, $erreur2, $erreur3);
}


/******************************************/
/***INFORMATIONS CONCERNANT LES DEMANDES***/
/******************************************/

// fonction permettant l'affichage des demandes de ruches pour l'administrateur afin de faciliter sa mise en place dans toute les pages

function demandesruches()
{
    // aller vers la classe utilisateurs quand on est connectés
    $getUser = new utilisateurs();
    $utilisateur = $getUser->GetUser($_SESSION['acces']);

    // Vérification si l'utilisateur a le statut "admin".
    if ($utilisateur[0]['Statut'] == 'admin') {
        // Accès à la classe "ruches" pour récupérer les demandes de ruches.
        $ruche = new ruches();
        $demandes = $ruche->getdemandes();

        // Initialisation de la variable pour contenir le HTML des demandes.
        $demandes_ruches = "";

        // Script JavaScript pour gérer l'affichage des notifications et fenêtres pop-up.
        $fonctionadmin = "document.querySelector('.mail').addEventListener('click', notifopen)
                          document.querySelector('.mail2').addEventListener('click', notifopen)

        function notifopen() {
            document.querySelector('.cache_fond').classList.add('cache_plein')
            document.querySelector('.pop_up_admin_demande').classList.add('popupouverte')
        }

        document.querySelector('.cache_fond').addEventListener('click', fermerfenetre);
        document.querySelector('#croixboite').addEventListener('click', fermerfenetre);

        function fermerfenetre() {
            document.querySelector('.cache_fond').classList.remove('cache_plein')
            document.querySelector('.pop_up_admin_demande').classList.remove('popupouverte')
        }";

        // Si des demandes existent, on génère le HTML correspondant.
        if (count($demandes)) {
            foreach ($demandes as $ligne) {
                $testruche = $ruche->getgerant($ligne['ID_Ruches']);
                $boucle = "";
                if (count($testruche)) {
                    foreach ($testruche as $lignes) {
                        $boucle .= $lignes['prenom'] . " ";
                    }
                    $variableruche = "<div class='id_entre'>Cette ruche appartient déjà à : " . $boucle . "</div>";
                } else {
                    $variableruche = '';
                }

                // Construction des éléments HTML pour chaque demande.
                $demandes_ruches .= '<div class="demande">
                    <div class="nom_user">' . $ligne['prenom_utilisateur'] . ' a envoyé une demande de validation de ruche.</div>
                    <div class="id_entre">ID entré par ' . $ligne['prenom_utilisateur'] . ' : ' . $ligne['ID_Ruches'] . '</div>
                    ' . $variableruche . '
                    <div class="boutons_Ajout_Ruche">
                        <a class="accept_ruche" href="index.php?page=accepter&IdRuche=' . $ligne['ID_Ruches'] . '&IdUtilisateur=' . $ligne['Id_utilisateur'] . '&NomRuche=' . $ligne['nom_ruche'] . '&idDemande=' . $ligne['ID_attente'] . '">Accepter</a>
                        <a class="refus_ruche" href="index.php?page=Refuser&idDemande=' . $ligne['ID_attente'] . '">Refuser</a>
                    </div>
                </div>';
            }
            // Script pour mettre à jour le nombre de demandes.
            $lenombre = "document.querySelector('.letxt').innerHTML = '" . count($demandes) . "';";
        } else {
            // Si aucune demande n'existe, afficher un message et retirer le point rouge.
            $demandes_ruches = "<div class='informationdemande'>Aucune demande n'a été transmise.</div>";
            $lenombre = "document.querySelector('.ptsrouge').remove();";
        }
    } else {
        // Si l'utilisateur n'est pas administrateur, afficher un message d'erreur.
        $demandes_ruches = "<div class='informationdemande'>Vous ne devriez pas avoir accès à ce type d'informations.</div>";
        $lenombre = '';
        $fonctionadmin = '';
    }

    // Retourne les parties nécessaires : HTML des demandes, script JavaScript pour le nombre et les actions.
    return [$demandes_ruches, $lenombre, $fonctionadmin];
}


// fonction pour ajouter une demande de ruche dans la file d'attente

function ajout($nom, $id)
{
    $checkuser = new utilisateurs();
    $addruche = new ruches();
    $user = $checkuser->GetUser($_SESSION['acces']);

    // verfication de la présente de données dans user
    if (!empty($user)) {
        $checkdemandes = $addruche->checkdemandes($id, $user[0]['Id_utilisateur']);
        if (!empty($checkdemandes)) {
            $erreur2 = '';
            $erreur3 = '';
            $erreur1 = 'Une ruche à déjà été demandée avec ce compte.';
            gestion_ruches($erreur1, $erreur2, $erreur3);
        } else {
            if (!empty($nom) && !empty($id)) {
                // ajout à la file d'attente
                $addruche->fileattente($user[0]['Id_utilisateur'], $id, $nom, $user[0]['Prenom']);
                $erreur2 = '';
                $erreur3 = '';
                $erreur1 = 'Votre demande à bien été envoyée';
                gestion_ruches($erreur1, $erreur2, $erreur3);

            } else {
                // echec
                $erreur1 = 'veuillez remplir les champs obligatoires';
                $erreur2 = '';
                $erreur3 = '';
                gestion_ruches($erreur1, $erreur2, $erreur3);
            }
        }
    } else {
        $erreur1 = 'inscription échouée';
        $erreur2 = '';
        $erreur3 = '';
        gestion_ruches($erreur1, $erreur2, $erreur3);
    }
}
