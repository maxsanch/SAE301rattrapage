<?php

require_once "modèle/database.php"; // Inclusion du fichier contenant la classe "database" pour permettre l'héritage.

class connexion extends database { // Définition de la classe "connexion" qui hérite de la classe "database".
    
    // Méthode pour récupérer l'année depuis la table "annee".
    public function getannee(){
        $req = "SELECT * from annee"; // Requête SQL pour sélectionner toutes les colonnes de la table "annee".
        $annee = $this->execReq($req); // Exécution de la requête via une méthode héritée de "database".

        return $annee[0]['annee']; // Retourne la première ligne de la colonne "annee".
    }

    // Méthode pour mettre à jour l'année dans la table "annee".
    public function maj($ajout){

        $data = array($ajout);

        // Requête SQL pour mettre à jour la colonne "annee" de la table "annee".
        $req = "UPDATE `annee` SET `annee` = ? WHERE `annee`.`1` = 1;";
        $this->execReqPrep($req, $data);
    }

    // Méthode pour réinitialiser le nombre de connexions dans la table "mois".
    public function resetmois(){
        // Requête SQL pour mettre à jour la colonne "nombreConnexion" de la table "mois" pour chaque mois.
        $req = "UPDATE `mois` SET `nombreConnexion` = '1' WHERE `mois`.`id_mois` = 1; 
                UPDATE `mois` SET `nombreConnexion` = '0' WHERE `mois`.`id_mois` = 2; 
                UPDATE `mois` SET `nombreConnexion` = '0' WHERE `mois`.`id_mois` = 3; 
                UPDATE `mois` SET `nombreConnexion` = '0' WHERE `mois`.`id_mois` = 4; 
                UPDATE `mois` SET `nombreConnexion` = '0' WHERE `mois`.`id_mois` = 5; 
                UPDATE `mois` SET `nombreConnexion` = '0' WHERE `mois`.`id_mois` = 6; 
                UPDATE `mois` SET `nombreConnexion` = '0' WHERE `mois`.`id_mois` = 7; 
                UPDATE `mois` SET `nombreConnexion` = '0' WHERE `mois`.`id_mois` = 8; 
                UPDATE `mois` SET `nombreConnexion` = '0' WHERE `mois`.`id_mois` = 9; 
                UPDATE `mois` SET `nombreConnexion` = '0' WHERE `mois`.`id_mois` = 10; 
                UPDATE `mois` SET `nombreConnexion` = '0' WHERE `mois`.`id_mois` = 11; 
                UPDATE `mois` SET `nombreConnexion` = '0' WHERE `mois`.`id_mois` = 12;";
        $this->execReq($req); // Exécution de la requête SQL via la méthode héritée.
    }

    // Méthode pour récupérer le nombre de connexions pour un mois donné.
    public function getcountmois($mois){
        $data = array($mois); // Préparation des données pour la requête paramétrée.

        $req = 'SELECT nombreConnexion from mois WHERE id_mois = ?'; // Requête SQL paramétrée.

        $user = $this->execReqPrep($req, $data); // Exécution de la requête préparée avec les données.

        return $user[0]['nombreConnexion']; // Retourne la première ligne de la colonne "nombreConnexion".
    }


    public function ajouter($nb, $mois){

        $data = array($nb, $mois);

        // Requête SQL pour mettre à jour le mois avec le bon nombre.".
        $req = "UPDATE `mois` SET `nombreConnexion` = ? WHERE `id_mois` = ?;";
        $this->execReqPrep($req, $data);
    }

    public function getallmois(){
        // récupérer tout les mois poru ensuite les afficher
        $req = "SELECT nombreConnexion from mois";
        $retour = $this->execReq($req);

        return $retour;
    }
}