<?php

require_once "modèle/database.php"; // Inclusion du fichier "database.php" pour accéder à la base de données.

class notes extends database { // Déclaration de la classe "notes", qui étend la classe "database".
    
    // Méthode pour ajouter une note pour une ruche spécifique.
    public function addnote($ruche, $contenu) {

        $data = array("contenu" => $contenu, "blabla" => $ruche);
        $req = "INSERT INTO `note` (`ID_note`, `Contenu`, `ID_Ruches`, `Date`) VALUES (NULL, :contenu, :blabla, '".date('Y-m-d')."');";

        // Exécution de la requête SQL.
        $this->execReqPrep($req, $data);
    }

    // Méthode pour afficher les notes d'une ruche en particulier.
    public function afficher_note($id) {
        // Préparation des données pour la requête SQL (l'ID de la ruche).
        $data = array($id);

        // Requête SQL pour récupérer toutes les notes d'une ruche spécifique.
        $req = 'SELECT * FROM note WHERE ID_Ruches = ?';

        // Exécution de la requête préparée.
        $user = $this->execReqPrep($req, $data);

        // Retourne les résultats (notes) récupérés.
        return $user;
    }

    // Méthode pour supprimer une note spécifique en utilisant son ID.
    public function supprimer($id) {
        // Préparation des données pour la requête SQL (ID de la note à supprimer).
        $data = array($id);
        
        // Requête SQL pour supprimer la note dont l'ID est spécifié.
        $req = 'DELETE FROM note WHERE `note`.`ID_note` = ?';
        
        // Exécution de la requête préparée pour supprimer la note.
        $user = $this->execReqPrep($req, $data);
    }

    // Méthode pour récupérer les ID des notes associées à un utilisateur spécifique.
    public function getnote($id) {
        // Préparation des données pour la requête SQL (ID de l'utilisateur).
        $data = array($id);

        // Requête SQL pour récupérer les ID des notes associées à l'utilisateur, via les ruches et l'entité "gérer".
        $req = 'SELECT ID_note from note inner JOIN ruches on note.ID_Ruches = ruches.ID_Ruches INNER JOIN gérer ON gérer.ID_Ruches = ruches.ID_Ruches WHERE Id_utilisateur = ?';

        // Exécution de la requête préparée.
        $user = $this->execReqPrep($req, $data);

        // Retourne les résultats (ID des notes).
        return $user;
    }

    // Méthode pour modifier le contenu d'une note existante.
    public function modifier($id, $content) {

        $data = array($content, $id);

        // Requête SQL pour mettre à jour le contenu de la note spécifiée par son ID.
        $req = "UPDATE `note` SET `Contenu` = ? WHERE `note`.`ID_note` = ?;";
        
        // Exécution de la requête SQL.
        $this->execReqPrep($req, $data);
    }
}