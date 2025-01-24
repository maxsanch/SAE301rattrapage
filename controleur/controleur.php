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


// affichage de la page d'accueil

function accueil()
{
    require "vue/vueIndex.php";
}

// réinitialisation ou ajout d'un nombre dans la base de données en fonction de la connexion, le premier de l'an, la première connexion reinitialsie les connextion afin d'être en accord avec le graphique du tableau de bord de la page gestion utilisateurs
function testetresetannée()
{
    $connexion = new connexion(); // Création d'une instance de la classe "connexion".
    $currentyear = $connexion->getannee(); // Récupération de l'année actuelle depuis la base de données.

    // Vérifie si l'année actuelle en base est différente de l'année actuelle du système.
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

// Fonction pour afficher la page d'accueil après connexion.
function accueil_connecté()
{
    $getuser = new utilisateurs(); // Création d'une instance de la classe "utilisateurs".
    $utilisateur = $getuser->GetUser($_SESSION['acces']); // Récupère les informations de l'utilisateur connecté via la session.

    $ruche = new ruches(); // Création d'une instance de la classe "ruches".
    $getruche = $ruche->getruches($utilisateur[0]['Id_utilisateur']); // Récupère les ruches associées à l'utilisateur.

    $fichier = file_get_contents("js/data_ruche.json"); // Lecture du fichier JSON contenant les données des ruches.
    $ruches = json_decode($fichier); // Décodage du fichier JSON pour le rendre exploitable en PHP.

    require "vue/vueIndexConnecte.php"; // Inclut la vue pour afficher la page d'accueil connectée.
}

// fonction permettant l'affichage des demandes de ruches pour l'administrateur afin de faciliter sa mise en place dans toute les pages

function demandesruches()
{
    // alelr vers la classe utilisateurs quand on est connectés
    $getUser = new utilisateurs();
    $utilisateur = $getUser->GetUser($_SESSION['acces']); // Appel à la méthode pour récupérer les données de l'utilisateur via la session.

    // Vérification si l'utilisateur a le statut "admin".
    if ($utilisateur[0]['Statut'] == 'admin') {
        // Création d'une instance de la classe "ruches" pour récupérer les demandes de ruches.
        $ruche = new ruches();
        $demandes = $ruche->getdemandes(); // Appel à la méthode pour récupérer les demandes de validation des ruches.

        // Initialisation de la variable pour contenir le HTML des demandes.
        $demandes_ruches = "";

        // Script JavaScript pour gérer l'affichage des notifications et fenêtres pop-up.
        $fonctionadmin = "document.querySelector('.mail').addEventListener('click', notifopen)
                          document.querySelector('.mail2').addEventListener('click', notifopen)

        function notifopen() {
            document.querySelector('.cache_fond').classList.add('cache_plein')
            document.querySelector('.pop_up_admin_demande').classList.add('popupouverte')
        }

        document.querySelector('.cache_fond').addEventListener('click', fermerfenetre)
        document.querySelector('#croixboite').addEventListener('click', fermerfenetre)

        function fermerfenetre() {
            document.querySelector('.cache_fond').classList.remove('cache_plein')
            document.querySelector('.pop_up_admin_demande').classList.remove('popupouverte')
        }";

        // Si des demandes existent, on génère les blocs HTML correspondants.
        if (count($demandes)) {
            foreach ($demandes as $ligne) {
                $testruche = $ruche->getgerant($ligne['ID_Ruches']);
                $boucle = "";
                if(count($testruche)){
                    foreach($testruche as $lignes){
                        $boucle .= $lignes['prenom']." ";
                    }
                    $variableruche = "<div class='id_entre'>Cette ruche appartient déjà à : ".$boucle."</div>";
                }
                else{
                    $variableruche = '';
                }

                // Construction des éléments HTML pour chaque demande avec des liens d'acceptation et de refus.
                $demandes_ruches .= '<div class="demande">
                    <div class="nom_user">' . $ligne['prenom_utilisateur'] . ' a envoyé une demande de validation de ruche.</div>
                    <div class="id_entre">ID entré par ' . $ligne['prenom_utilisateur'] . ' : ' . $ligne['ID_Ruches'] . '</div>
                    '.$variableruche.'
                    <div class="boutons_Ajout_Ruche">
                        <a class="accept_ruche" href="index.php?page=accepter&IdRuche=' . $ligne['ID_Ruches'] . '&IdUtilisateur=' . $ligne['Id_utilisateur'] . '&NomRuche=' . $ligne['nom_ruche'] . '&idDemande=' . $ligne['ID_attente'] . '">Accepter</a>
                        <a class="refus_ruche" href="index.php?page=Refuser&idDemande=' . $ligne['ID_attente'] . '">Refuser</a>
                    </div>
                </div>';
            }
            // Script pour mettre à jour le nombre de demandes affichées dans l'interface.
            $lenombre = "document.querySelector('.letxt').innerHTML = '" . count($demandes) . "'";
        } else {
            // Si aucune demande n'existe, afficher un message et retirer l'élément indicateur.
            $demandes_ruches = "<div class='informationdemande'>Aucune demande n'a été transmise.</div>";
            $lenombre = "document.querySelector('.ptsrouge').remove();";
        }
    } else {
        // Si l'utilisateur n'est pas administrateur, afficher un message d'erreur.
        $demandes_ruches = "<div class='informationdemande'>Vous ne devriez pas avoir accès à ce type d'informations.</div>";
        $lenombre = ''; // Pas de mise à jour d'indicateur.
        $fonctionadmin = ''; // Pas de script JavaScript pour les actions d'administration.
    }

    // Retourne les parties nécessaires : HTML des demandes, script JavaScript pour le nombre et les actions.
    return [$demandes_ruches, $lenombre, $fonctionadmin];
}
// affichage de la page admin

function accueil_admin()
{
    // Création d'une instance de la classe "utilisateurs" pour interagir avec les données des utilisateurs.
    $getUser = new utilisateurs();

    // Récupération de la liste des utilisateurs administrateurs via la méthode "GetUserAdmin".
    $GetAllUser = $getUser->GetUserAdmin();

    // Récupération des informations de l'utilisateur actuellement connecté via la session.
    $utilisateur = $getUser->GetUser($_SESSION['acces']);

    // Création d'une instance de la classe "ruches" pour interagir avec les ruches.
    $ruche = new ruches();

    // Récupération des ruches associées à l'utilisateur connecté.
    $getruche = $ruche->getruches($utilisateur[0]['Id_utilisateur']);

    // Lecture d'un fichier JSON contenant des données supplémentaires sur les ruches.
    $fichier = file_get_contents("js/data_ruche.json"); // Lecture du contenu du fichier JSON.
    $ruches = json_decode($fichier); // Décodage du JSON en un objet PHP.

    // Appel de la fonction "demandesruches" pour gérer les demandes de ruches.
    $demandes_ruches = demandesruches()[0];
    $lenombre = demandesruches()[1];
    $fonctionadmin = demandesruches()[2];

    // Inclusion de la vue "vueIndexConnecteAdmin" pour afficher l'interface administrateur.
    require "vue/vueIndexConnecteAdmin.php";
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

// une fonction erreur pour traiter les erreur, pas trop utile pour le moment, A SUPPRIMER
function erreur($message)
{
    echo $message;
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

// fonction pour connecter un compte déjà existant 
function login($nom, $mdp)
{
    // Création d'une instance de la classe "utilisateurs" pour interagir avec les utilisateurs.
    $nom_user = new utilisateurs();

    // Récupération des informations de l'utilisateur à partir de son nom ou email.
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
                testetresetannée(); // Vérification ou réinitialisation de l'année.
                accueil_admin(); // Appel de la fonction pour afficher la page d'accueil administrateur.
            } else {
                // Si l'utilisateur n'est pas administrateur :
                testetresetannée(); // Vérification ou réinitialisation de l'année.
                accueil_connecté(); // Appel de la fonction pour afficher la page d'accueil utilisateur connecté.
            }
        } else {
            // Si le mot de passe est incorrect, afficher un message d'erreur.
            $erreur = '<b>mot de passe incorrecte.</b>';
            connexion($erreur); // Rediriger vers la page de connexion avec le message d'erreur.
        }
    } else {
        // Si aucun utilisateur ne correspond au nom ou email, afficher un message d'erreur.
        $erreur = '<b>Identifiant invalide</b>';
        connexion($erreur); // Rediriger vers la page de connexion avec le message d'erreur.
    }
}

// fonction poru enregistrer un comtpe dans la bdd puis le connecter

function signin($prenom, $nom, $email, $mdp, $mdp2)
{

    // Nouvelle instance de la classe "utilisateurs" pour effectuer l'inscription.
    $insc = new utilisateurs();

    // Vérification si un utilisateur avec le même email existe déjà dans la base de données.
    $user = $insc->GetUser($email);

    // Si aucun utilisateur avec cet email n'est trouvé, on peut continuer l'inscription.
    if (empty($user)) {
        // Vérification si tous les champs requis sont remplis.
        if (!empty($prenom) && !empty($nom) && !empty($email) && !empty($mdp) && !empty($mdp2)) {
            // Vérification si les deux mots de passe saisis sont identiques.
            if ($mdp == $mdp2) {
                // Hashage du mot de passe pour sécuriser son stockage en base de données.
                $mdpgood = password_hash($mdp, PASSWORD_DEFAULT);

                // Appel de la méthode "inscrire" pour insérer les informations dans la base de données.
                $insc->inscrire($prenom, $nom, $email, $mdpgood);

                // Récupération des informations de l'utilisateur nouvellement inscrit.
                $user = $insc->GetUser($email);

                // Enregistrement de l'email de l'utilisateur dans la session pour gérer son authentification.
                $_SESSION['acces'] = $user[0]['Mail'];

                // Appel de la fonction "testetresetannée" (vérification ou réinitialisation des données liées à l'année).
                testetresetannée();

                // Redirection vers la page d'accueil pour un utilisateur connecté.
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


// affichage de la page des ruches
function ruches($message)
{
    // Création d'une instance de la classe "utilisateurs" pour interagir avec les données des utilisateurs.
    $getuser = new utilisateurs();

    // Récupération des informations de l'utilisateur actuellement connecté via son email stocké dans la session.
    $utilisateur = $getuser->GetUser($_SESSION['acces']);

    // Création d'une instance de la classe "ruches" pour interagir avec les données des ruches.
    $ruche = new ruches();

    // Récupération des ruches associées à l'utilisateur connecté, identifiées par son ID.
    $getruche = $ruche->getruches($utilisateur[0]['Id_utilisateur']);

    // Chargement des données des ruches depuis le JSON.
    $fichier = file_get_contents("js/data_ruche.json");

    // Décodage des données JSON en tableau PHP pour pouvoir les manipuler.
    $ruches = json_decode($fichier);

    // Gestion des demandes de ruches pour un utilisateur administrateur.

    // Appel à la fonction `demandesruches` pour récupérer :
    // - Le contenu HTML des demandes.
    // - Le nombre de demandes.
    // - Le code JavaScript pour gérer les demandes en tant qu'administrateur.
    $demandes_ruches = demandesruches()[0];
    $lenombre = demandesruches()[1];
    $fonctionadmin = demandesruches()[2];

    // Inclusion du fichier de vue "vueInfoRuches.php" pour afficher les informations sur les ruches.
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


// fonction poru modifier les informations d'une ruche, un utilisateur ne peux pas modifier l'id d'une ruche pour des raisons de sécurité
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

// fonction pour ajouter une demande de ruche dans la file d'attente

function ajout($nom, $id)
{
    $checkuser = new utilisateurs();
    $addruche = new ruches();
    $user = $checkuser->GetUser($_SESSION['acces']);
    // verfication de la présente de données dans user
    if (!empty($user)) {
        if (!empty($nom) && !empty($id)) {
            // ajotu a la file d'attente
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
    } else {
        $erreur1 = 'inscription échouée';
        $erreur2 = '';
        $erreur3 = '';
        gestion_ruches($erreur1, $erreur2, $erreur3);
    }
}

// fonction pour changer des informatiosn sur la ruche (fonction liée à la bdd)
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

function EnregPhotoRuche($idRuche)
{
    $ruches = new ruches();
    // enregistrement de la photo
    $erreur1 = $ruches->updateRuchePhoto($idRuche);
    $erreur3 = '';
    $erreur2 = '';
    gestion_ruches($erreur1, $erreur2, $erreur3);
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

// supprimer un compte en tant qu'administrateur
function deletaccount($id)
{
    $user = new utilisateurs();
    // suppresion de l'utilisateur
    $user->deletuser($id);
    $message = "L'utilisateur à bien été supprimé";
    $usersingle = '';

    utilisateurs($message, $usersingle);
}

function deletmyaccount()
{
    $user = new utilisateurs();
    $utilisateur = $user->GetUser($_SESSION['acces']);

    $id = $utilisateur[0]['Id_utilisateur'];
    $user->deletuser($id);
    
    // suppression de la session et des cookies de ce dernier
    session_destroy();
    setcookie(session_name(), '', time() - 1, "/");
    accueil();

}