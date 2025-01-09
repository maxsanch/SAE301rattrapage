<?php

require_once "modèle/database.php";


class connexion extends database {
    public function getannee(){
        $req = "SELECT * from annee";
        $annee = $this->execReq($req);

        return $annee[0]['annee'];
    }

    public function maj($ajout){
        $req = "UPDATE `annee` SET `annee` = '$ajout' WHERE `annee`.`1` = 1;";
        $this->execReq($req);
    }

    public function resetmois(){
        $req = "UPDATE `mois` SET `nombreConnexion` = '1' WHERE `mois`.`id_mois` = 1; UPDATE `mois` SET `nombreConnexion` = '0' WHERE `mois`.`id_mois` = 2; UPDATE `mois` SET `nombreConnexion` = '0' WHERE `mois`.`id_mois` = 3; UPDATE `mois` SET `nombreConnexion` = '0' WHERE `mois`.`id_mois` = 4; UPDATE `mois` SET `nombreConnexion` = '0' WHERE `mois`.`id_mois` = 5; UPDATE `mois` SET `nombreConnexion` = '0' WHERE `mois`.`id_mois` = 6; UPDATE `mois` SET `nombreConnexion` = '0' WHERE `mois`.`id_mois` = 7; UPDATE `mois` SET `nombreConnexion` = '0' WHERE `mois`.`id_mois` = 8; UPDATE `mois` SET `nombreConnexion` = '0' WHERE `mois`.`id_mois` = 9; UPDATE `mois` SET `nombreConnexion` = '0' WHERE `mois`.`id_mois` = 10; UPDATE `mois` SET `nombreConnexion` = '0' WHERE `mois`.`id_mois` = 11; UPDATE `mois` SET `nombreConnexion` = '0' WHERE `mois`.`id_mois` = 12;";
        $this->execReq($req);
    }

    public function getcountmois($mois){
        $data = array($mois);

        $req = 'SELECT nombreConnexion from mois WHERE id_mois = ?';

        $user = $this->execReqPrep($req, $data);

        return $user[0];
    }
}