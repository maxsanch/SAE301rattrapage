<?php

require_once "modèle/database.php";


class notes extends database {
    public function addnote($ruche, $contenu){
        $req = "INSERT INTO `note` (`ID_note`, `Contenu`, `ID_Ruches`, `Date`) VALUES (NULL, '".$contenu."', '".$ruche."', '".date('Y-m-d')."');";
        $this->execReq($req);
    }

    public function afficher_note($id){
        $data = array($id);

        $req = 'SELECT * FROM note WHERE ID_Ruches = ?';

        $user = $this->execReqPrep($req, $data);

        return $user;
    }

    public function supprimer($id){
        $data = array($id);
        $req = 'DELETE FROM note WHERE `note`.`ID_note` = ?';
        $user = $this->execReqPrep($req, $data);
    }

    public function getnote($id){
        $data = array($id);

        $req = 'SELECT ID_note from note inner JOIN ruches on note.ID_Ruches = ruches.ID_Ruches INNER JOIN gérer ON gérer.ID_Ruches = ruches.ID_Ruches WHERE Id_utilisateur = ?';

        $user = $this->execReqPrep($req, $data);

        return $user;
    }

    public function modifier($id, $content){
        $req = "UPDATE `note` SET `Contenu` = '$content' WHERE `note`.`ID_note` = $id;";
        $this->execReq($req);
    }
}