<?php

require_once "modèle/utilisateurs.php";

/******************************************/
/********CONNEXION ET INSCRIPTION**********/
/******************************************/

// fonction pour connecter un compte déjà existant
function login($nom, $mdp)
{
    // Accès à la classe utilisateurs.
    $nom_user = new utilisateurs();

    // Récupération des informations de l'utilisateur à partir de son mail.
    $user = $nom_user->GetUser($nom);

    // Vérification si un utilisateur correspondant existe.
    if (!empty($user)) {
        // Vérification du mot de passe entré par rapport au mot de passe hashé stocké.
        if (password_verify($mdp, $user[0]['MotDePasse'])) {
            // Si le mot de passe est correct, enregistrer l'email dans la session pour authentification.
            $_SESSION['acces'] = $user[0]['Mail'];

            // Mise à jour de la dernière connexion de l'utilisateur (fonction personnalisée).
            updateco($user[0]['Id_utilisateur']);

            // Vérification du statut de l'utilisateur pour rediriger vers la page appropriée.
            if ($user[0]['Statut'] == 'admin') {
                // Si l'utilisateur est administrateur :
                testetresetannée();
                accueil_admin(); // Appel de la fonction pour afficher la page d'accueil administrateur.
            } else {
                // Si l'utilisateur n'est pas administrateur :
                testetresetannée();
                accueil_connecté(); // Appel de la fonction pour afficher la page d'accueil utilisateur connecté.
            }
        } else {
            // Si le mot de passe est incorrect, afficher un message d'erreur.
            $erreur = '<b>mot de passe incorrecte.</b>';
            connexion($erreur);
        }
    } else {
        // Si aucun utilisateur ne correspond au mail, afficher un message d'erreur.
        $erreur = '<b>Identifiant invalide</b>';
        connexion($erreur);
    }
}

// affichage de la page de connexion
function connexion($erreur)
{
    require "vue/vueConnexion.php";
}

// affichage de la page d'inscription
function inscription($erreur)
{
    require "vue/vueInscription.php";
}

// fonction pour enregistrer un comtpe dans la bdd puis le connecter

function signin($prenom, $nom, $email, $mdp, $mdp2)
{

    // Appel à la classe utiliasteurs.
    $insc = new utilisateurs();

    // Vérification si un utilisateur avec le même email existe déjà dans la base de données.
    $user = $insc->GetUser($email);

    // Si aucun utilisateur avec cet email n'est trouvé, on peut continuer l'inscription.
    if (empty($user)) {
        if (!empty($prenom) && !empty($nom) && !empty($email) && !empty($mdp) && !empty($mdp2)) {
            // Vérification si les deux mots de passe saisis sont identiques.
            if ($mdp == $mdp2) {
                // Hashage du mot de passe.
                $mdpgood = password_hash($mdp, PASSWORD_DEFAULT);

                // Appel de la méthode inscrire.
                $insc->inscrire($prenom, $nom, $email, $mdpgood);

                // Récupération des informations de l'utilisateur nouvellement inscrit.
                $user = $insc->GetUser($email);

                // Enregistrement de l'email de l'utilisateur dans la session.
                $_SESSION['acces'] = $user[0]['Mail'];

                testetresetannée();
                accueil_connecté();

            } else {
                // Si les mots de passe ne correspondent pas, afficher un message d'erreur.
                $erreur = "<b>Les mots de passe ne correspondent pas.</b>";
                inscription($erreur); // Appel de la fonction "inscription" pour afficher la vue avec le message d'erreur.
            }
        } else {
            // Si des champs sont laissés vides, afficher un message d'erreur.
            $erreur = "<b>Veillez à remplir tout les champs</b>";
            inscription($erreur);
        }
    } else {
        // Si un compte avec le même email existe déjà, afficher un message d'erreur.
        $erreur = "<b>Un compte avec la même adresse e-mail existe déjà.</b>";
        inscription($erreur);
    }
}

// déconnexion de l'utilisateur
function quitter()
{
    // suppression de la session et des cookies de ce dernier
    session_destroy();
    setcookie(session_name(), '', time() - 1, "/");
    // retour à l'accueil
    accueil();
}