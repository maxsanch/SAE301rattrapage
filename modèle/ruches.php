<?php

require_once "modèle/database.php"; // Inclusion du fichier de base de données pour hériter des fonctionnalités de connexion et d'exécution des requêtes SQL.

class ruches extends database
{ // Déclaration de la classe "ruches", qui étend la classe "database" pour gérer les interactions avec la base de données.

    /*******************************************************
    Vérifie si une ruche existe par son ID
    Entrée : $idruche : L'ID de la ruche à vérifier
    Retour : array : Tableau contenant les informations de la ruche
    *******************************************************/
    public function checkruche($idruche)
    {
        $data = array($idruche); // Prépare les données pour la requête SQL (l'ID de la ruche).
        $req = 'SELECT * from ruches WHERE ID_Ruches = ?'; // Requête SQL pour récupérer les informations d'une ruche en fonction de son ID.
        $user = $this->execReqPrep($req, $data); // Exécute la requête préparée et retourne les résultats.
        return $user; // Retourne les informations de la ruche.
    }

    /*******************************************************
    Vérifie si un utilisateur gère une ruche spécifique
    Entrée : $iduser : L'ID de l'utilisateur, $idruche : L'ID de la ruche
    Retour : array : Tableau des informations de gestion de la ruche
    *******************************************************/
    public function checkgerer($iduser, $idruche)
    {
        // Requête SQL pour vérifier si l'utilisateur gère la ruche donnée.
        $req = 'SELECT * FROM `gérer` WHERE Id_utilisateur = ' . $iduser . ' AND ID_Ruches = ' . $idruche . ';';
        $user = $this->execReq($req); // Exécute la requête et retourne le résultat.
        return $user; // Retourne les informations de gestion.
    }

    /*******************************************************
    Ajoute une nouvelle ruche
    Entrée : $nom : Le nom de la ruche, $id : L'ID de la ruche
    *******************************************************/
    public function ajouter($nom, $id)
    {
        $req = "INSERT INTO `ruches` (`ID_Ruches`, `nom`) VALUES ('" . $id . "', '" . $nom . "');"; // Requête SQL pour ajouter une ruche.
        $this->execReq($req); // Exécute la requête.
    }

    /*******************************************************
    Associe un utilisateur à une ruche (gestionnaire)
    Entrée : $gerant : ID de l'utilisateur, $ruche : ID de la ruche
    *******************************************************/
    public function gerant($gerant, $ruche)
    {
        $req = "INSERT INTO `gérer` (`Id_utilisateur`, `ID_Ruches`, `gérer`) VALUES ('" . $gerant . "', '" . $ruche . "', NULL);"; // Requête SQL pour associer un utilisateur à une ruche.
        $this->execReq($req); // Exécute la requête.
    }

    /*******************************************************
    Met à jour le nom d'une ruche et son ID
    Entrée : $nom : Le nouveau nom de la ruche, $newidruche : Le nouvel ID de la ruche, $ancienid : L'ancien ID de la ruche
    *******************************************************/
    public function update($nom, $ancienid)
    {
        $req = "UPDATE `ruches` SET `nom` = '" . $nom . "' WHERE `ruches`.`ID_Ruches` = " . $ancienid . ";"; // Requête SQL pour mettre à jour une ruche.
        $this->execReq($req); // Exécute la requête.
    }

    /*******************************************************
    Récupère toutes les ruches gérées par un utilisateur spécifique
    Entrée : $user : L'ID de l'utilisateur
    Retour : array : Tableau contenant les ruches gérées par l'utilisateur
    *******************************************************/
    public function getruches($user)
    {
        $data = array($user); // Prépare les données pour la requête SQL (ID de l'utilisateur).
        $req = 'SELECT * FROM ruches INNER JOIN gérer ON gérer.ID_Ruches=ruches.ID_Ruches WHERE Id_utilisateur = ?'; // Requête SQL pour récupérer toutes les ruches gérées par l'utilisateur.
        $user = $this->execReqPrep($req, $data); // Exécute la requête préparée et retourne les résultats.
        return $user; // Retourne les ruches gérées.
    }

    /*******************************************************
    Supprime une ruche par son ID
    Entrée : $id : L'ID de la ruche à supprimer
    *******************************************************/
    public function supprimer($id)
    {
        $data = array($id); // Prépare les données pour la requête SQL (ID de la ruche à supprimer).
        $req = 'DELETE FROM ruches WHERE `ruches`.`ID_Ruches` = ?'; // Requête SQL pour supprimer une ruche.
        $user = $this->execReqPrep($req, $data); // Exécute la requête préparée.
        return $user; // Retourne le résultat de la suppression (si nécessaire).
    }

    /*******************************************************
    Supprime un utilisateur d'une ruche spécifique
    Entrée : $id : L'ID de la ruche

    *******************************************************/
    public function deletuser($id)
    {
        $data = array($id); // Prépare les données pour la requête SQL (ID de la ruche).
        $req = 'DELETE FROM gérer WHERE `gérer`.`ID_Ruches` = ?'; // Requête SQL pour supprimer un utilisateur de la gestion d'une ruche.
        $user = $this->execReqPrep($req, $data); // Exécute la requête préparée.
        return $user; // Retourne le résultat de la suppression.
    }

    /*******************************************************
    Ajoute une demande d'attente pour gérer une ruche
    Entrée : $id_user : ID de l'utilisateur, $id_ruche : ID de la ruche, $nom_ruche : Nom de la ruche, $prenom_user : Prénom de l'utilisateur
    *******************************************************/
    public function fileattente($id_user, $id_ruche, $nom_ruche, $prenom_user)
    {
        $req = "INSERT INTO `attente` (`ID_attente`, `Id_utilisateur`, `ID_Ruches`, `nom_ruche`, `prenom_utilisateur`) VALUES (NULL, '" . $id_user . "', '" . $id_ruche . "', '" . $nom_ruche . "', '" . $prenom_user . "');"; // Requête SQL pour ajouter une demande d'attente.
        $this->execReq($req); // Exécute la requête.
    }

    /*******************************************************
    Récupère toutes les demandes d'attente
    Entrée : Aucun
    Retour : array : Tableau des demandes d'attente
    *******************************************************/
    public function getdemandes()
    {
        $req = "SELECT * FROM attente"; // Requête SQL pour récupérer toutes les demandes d'attente.
        $demande = $this->execReq($req); // Exécute la requête.
        return $demande; // Retourne les demandes d'attente.
    }

    // Fonction pour supprimer une tâche en fonction de son ID
    public function deletask($id)
    {
        // Création d'un tableau de données avec l'ID de la tâche
        $data = array($id);

        // Requête SQL pour supprimer une entrée de la table "attente" où l'ID correspond
        $req = 'DELETE FROM attente WHERE `attente`.`ID_attente` = ?';

        // Exécution de la requête préparée
        $user = $this->execReqPrep($req, $data);

        // Retourne le résultat de l'exécution de la requête
        return $user;
    }

    // Fonction pour mettre à jour la photo d'une ruche
    public function updateRuchePhoto($idArt)
    {
        // Vérification si un fichier photo a été envoyé
        if (isset($_FILES['photoRuche'])) {

            // Vérification si le fichier ne contient pas d'erreur
            if ($_FILES['photoRuche']["error"] == 0) {

                // Vérification si la taille du fichier est inférieure à 20 Mo
                if ($_FILES['photoRuche']["size"] <= 20000000) {

                    // Récupération de l'extension du fichier
                    $infosfichier = new SplFileInfo($_FILES['photoRuche']['name']);
                    $extension_upload = $infosfichier->getExtension();

                    // Liste des extensions autorisées
                    $extensions_autorisees = array('jpg', 'png');

                    // Vérification si l'extension du fichier est autorisée
                    if (in_array($extension_upload, $extensions_autorisees)) {

                        // Vérification si le dossier 'img/imported' existe
                        if (is_dir('img/imported')) {

                            // Déplacement du fichier vers le dossier "img/imported" avec un nom basé sur l'ID de l'article
                            move_uploaded_file(
                                $_FILES['photoRuche']['tmp_name'],
                                'img/imported/' . $idArt . "." . $extension_upload
                            );
                            $erreur = "Transfert du fichier <b> " . $_FILES['photoRuche']['name'] . " </b> effectué !";
                            return $erreur;

                        } else {
                            // Si le dossier n'existe pas, on le crée et on déplace le fichier
                            mkdir('img/imported');
                            move_uploaded_file(
                                $_FILES['photoRuche']['tmp_name'],
                                'img/imported/' . $_FILES['photoRuche']['name']
                            );
                            $erreur = "Transfert du fichier <b> " . $_FILES['photoRuche']['name'] . " </b> effectué !";
                            return $erreur;
                        }

                    } else {
                        // Si l'extension du fichier n'est pas autorisée
                        $erreur2 = "Fichier non autorisé";
                        $erreur3 = '';
                        $erreur1 = '';
                        gestion_ruches($erreur1, $erreur2, $erreur3);
                    }

                } else {
                    // Si le fichier est trop volumineux
                    $erreur2 = "Fichier trop volumineux";
                    $erreur3 = '';
                    $erreur1 = '';
                    gestion_ruches($erreur1, $erreur2, $erreur3);
                }
            } else {
                // Si le transfert a échoué avec un code d'erreur
                $erreur2 = "Echec du transfert avec le code d'erreur : " . $_FILES['photoRuche']['error'] . "";
                $erreur3 = '';
                $erreur1 = '';
                gestion_ruches($erreur1, $erreur2, $erreur3);
            }
        }
    }

    // Fonction pour récupérer tous les ID des ruches
    public function getAllruches()
    {
        // Requête SQL pour sélectionner tous les ID des ruches dans la table "ruches"
        $req = "SELECT ID_Ruches from ruches";

        // Exécution de la requête
        $rucheadmin = $this->execReq($req);

        // Retourne les résultats
        return $rucheadmin;
    }
}