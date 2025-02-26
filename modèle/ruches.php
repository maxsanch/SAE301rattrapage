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
        $data = array($iduser, $idruche);
        // Requête SQL pour vérifier si l'utilisateur gère la ruche donnée.
        $req = 'SELECT * FROM `gérer` WHERE Id_utilisateur = ? AND ID_Ruches = ?;';
        $user = $this->execReqPrep($req, $data); // Exécute la requête et retourne le résultat.
        return $user; // Retourne les informations de gestion.
    }

    /*******************************************************
    Ajoute une nouvelle ruche
    Entrée : $nom : Le nom de la ruche, $id : L'ID de la ruche
    *******************************************************/
    public function ajouter($nom, $id)
    {
        $data = array($id, $nom);

        $req = "INSERT INTO `ruches` (`ID_Ruches`, `nom`) VALUES (?, ?);"; // Requête SQL pour ajouter une ruche.

        $this->execReqPrep($req, $data); // Exécute la requête.
    }

    /*******************************************************
    Associe un utilisateur à une ruche (gestionnaire)
    Entrée : $gerant : ID de l'utilisateur, $ruche : ID de la ruche
    *******************************************************/

    public function gerant($gerant, $ruche)
    {
        $data = array($gerant, $ruche);

        $req = "INSERT INTO `gérer` (`Id_utilisateur`, `ID_Ruches`, `gérer`) VALUES (?, ?, NULL);"; // Requête SQL pour associer un utilisateur à une ruche.

        $this->execReqPrep($req, $data); // Exécute la requête.
    }

    /*******************************************************
    Met à jour le nom d'une ruche et son ID
    Entrée : $nom : Le nouveau nom de la ruche,, $ancienid : L'ancien ID de la ruche
    *******************************************************/
    public function update($nom, $ancienid)
    {
        $data = array($nom, $ancienid);
        $req = "UPDATE `ruches` SET `nom` = ? WHERE `ruches`.`ID_Ruches` = ?;"; // Requête SQL pour mettre à jour une ruche.
        $this->execReqPrep($req, $data); // Exécute la requête.
    }

    /*******************************************************
    Récupère toutes les ruches gérées par un utilisateur spécifique
    Entrée : $user : L'ID de l'utilisateur
    Retour : array : Tableau contenant les ruches gérées par l'utilisateur
    *******************************************************/
    public function getruches($user)
    {
        $data = array($user); 
        $req = 'SELECT * FROM ruches INNER JOIN gérer ON gérer.ID_Ruches=ruches.ID_Ruches WHERE Id_utilisateur = ?';
        $user = $this->execReqPrep($req, $data);
        return $user;
    }

    /*******************************************************
    Supprime une ruche par son ID
    Entrée : $id : L'ID de la ruche à supprimer
    *******************************************************/
    public function supprimer($id)
    {
        $data = array($id); 
        $req = 'DELETE FROM ruches WHERE `ruches`.`ID_Ruches` = ?'; 
        $user = $this->execReqPrep($req, $data);
        return $user;
    }

    /*******************************************************
    Supprime un utilisateur d'une ruche spécifique
    Entrée : $id : L'ID de la ruche

    *******************************************************/
    public function deletuser($id)
    {
        $data = array($id);
        $req = 'DELETE FROM gérer WHERE `gérer`.`ID_Ruches` = ?'; 
        $user = $this->execReqPrep($req, $data);
        return $user;
    }

    /*******************************************************
    Ajoute une demande d'attente pour gérer une ruche
    Entrée : $id_user : ID de l'utilisateur, $id_ruche : ID de la ruche, $nom_ruche : Nom de la ruche, $prenom_user : Prénom de l'utilisateur
    *******************************************************/
    public function fileattente($id_user, $id_ruche, $nom_ruche, $prenom_user)
    {
        $data = array($id_user, $id_ruche, $nom_ruche, $prenom_user);
        $req = "INSERT INTO `attente` (`ID_attente`, `Id_utilisateur`, `ID_Ruches`, `nom_ruche`, `prenom_utilisateur`) VALUES (NULL, ?, ?, ?, ?);";
        $this->execReqPrep($req, $data); 
    }

    /*******************************************************
    Récupère toutes les demandes d'attente
    Retour : array : Tableau des demandes d'attente
    *******************************************************/
    public function getdemandes()
    {
        $req = "SELECT * FROM attente";
        $demande = $this->execReq($req); 
        return $demande;
    }

    /*******************************************************
    Récupère La demande d'un utilisateur précis (vérification)
    Retour : array : Tableau des demandes d'attente
    *******************************************************/

    public function checkdemandes($id, $iduser){
        $data = array($iduser, $id);

        $req = "SELECT * FROM attente WHERE Id_utilisateur=? AND ID_Ruches =?; "; // Requête SQL pour associer un utilisateur à une ruche.

        $test = $this->execReqPrep($req, $data); // Exécute la requête.

        return $test;
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

                // Vérification si la taille du fichier est inférieure à 500 Ko
                if ($_FILES['photoRuche']["size"] <= 500000) {

                    // Récupération de l'extension du fichier
                    $infosfichier = new SplFileInfo($_FILES['photoRuche']['name']);
                    $extension_upload = $infosfichier->getExtension();

                    // Liste des extensions autorisées
                    $extensions_autorisees = array('jpg', 'png');

                    // Vérification si l'extension du fichier est autorisée
                    if (in_array($extension_upload, $extensions_autorisees)) {

                        foreach($extensions_autorisees as $test){
                            $exister = 'img/imported/'. $idArt. '.'.$test;

                            if(file_exists($exister)){

                                unlink($exister);
                            }
                        }

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
                if ($_FILES['photoRuche']["size"] <= 500000) {
                    // Si le transfert a échoué avec un code d'erreur
                    $erreur1 = "Fichier trop volumineux.";
                    $erreur3 = '';
                    $erreur2 = '';
                    gestion_ruches($erreur1, $erreur2, $erreur3);
                } else {
                    // Si le transfert a échoué avec un code d'erreur
                    $erreur1 = "Une erreur est survenue";
                    $erreur3 = '';
                    $erreur2 = '';
                    gestion_ruches($erreur1, $erreur2, $erreur3);
                }
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

    public function getgerant($id){
        // Création d'un tableau de données avec l'ID de la tâche
        $data = array($id);

        // Requête SQL pour supprimer une entrée de la table "attente" où l'ID correspond
        $req = 'SELECT prenom FROM utilisateurs INNER JOIN gérer ON gérer.Id_utilisateur = utilisateurs.Id_utilisateur WHERE ID_Ruches = ?';

        // Exécution de la requête préparée
        $user = $this->execReqPrep($req, $data);

        // Retourne le résultat de l'exécution de la requête
        return $user;
    }
}