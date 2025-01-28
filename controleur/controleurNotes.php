<?php

// récupération des différents modèles afin de faire fonctionner les fonctions

require_once "modèle/utilisateurs.php";
require_once "modèle/ruches.php";
require_once "modèle/notes.php";

/*******************/
/***NOTES DU SITE***/
/*******************/

// affichage de la page notes

function notes()
{
    // recherche des notes de l'utilisateur en question
    $getuser = new utilisateurs();
    $utilisateur = $getuser->GetUser($_SESSION['acces']);
    // obtenir les ruches d'un utilisateur précis pour les afficher toutes
    $ruche = new ruches();
    $getruche = $ruche->getruches($utilisateur[0]['Id_utilisateur']);

    $fichier = file_get_contents("js/data_ruche.json");
    $ruches = json_decode($fichier);

    // pour chercher les ruches

    $demandes_ruches = demandesruches()[0];
    $lenombre = demandesruches()[1];
    $fonctionadmin = demandesruches()[2];

    require "vue/vueNotes.php";
}

// ajouter une note vers la bdd
function ajoutnote($ruches, $notecontent)
{
    // verification de l'envoie du formulaire
    if (isset($_POST['ok'])) {
        if (!empty($ruches)) {

            // transformation des caractères en caractère transmissibles dans une bdd
            $contenu = htmlspecialchars($notecontent);

            $ruche = new notes();

            // ajout de la note

            $ruche->addnote($ruches, $contenu);

            $message = 'La note à bien été enregistrée';

            // en fonction de la page ou la noet a été enregistrée, renvoi vers la bonne page

            if (isset($_GET['prevpage'])) {
                if ($_GET['prevpage'] == 'ajouternote') {
                    header('Location: index.php?page=Notes');
                } else {
                    ruches($message);
                }
            } else {
                ruches($message);
            }
        } else {
            // erreur
            $message = 'Une erreur est survenue';
            if (isset($_GET['prevpage'])) {
                if ($_GET['prevpage'] == 'ajouternote') {
                    notes();
                } else {
                    ruches($message);
                }
            } else {
                ruches($message);
            }
        }
    } else {
        // erreur globale
        $message = 'Une erreur est survenue';
        if (isset($_GET['prevpage'])) {
            if ($_GET['prevpage'] == 'ajouternote') {
                notes();
            } else {
                ruches($message);
            }
        } else {
            ruches($message);
        }
    }
    ;
}

// récupérer les notes pour les afficher

function afficher_notes($id)
{

    $pourruche = new notes();

    $lesnotes = $pourruche->afficher_note($id);
    return $lesnotes;
}


// supprimer une note
function supprimernote($id)
{


    $note = new notes();
    $note->supprimer($id);
    $message = "la note à bien été supprimée.";

    // verification de la page d'ou provient la requete

    if (isset($_GET['prevpage'])) {
        if ($_GET['prevpage'] == 'note') {
            notes();
        } else {
            ruches($message);
        }
    } else {
        ruches($message);
    }
}


// modifier le contenu d'une note

function modifnote($id, $content)
{
    $message = "la note à bien été modifiée.";
    $note = new notes();

    // changement de la note
    $content = htmlspecialchars($content);
    $note->modifier($id, $content);

    // verification de la page d'ou provient la requete
    if (isset($_GET['prevpage'])) {
        if ($_GET['prevpage'] == 'modif') {
            notes();
        } else {
            ruches($message);
        }
    } else {
        ruches($message);
    }
}