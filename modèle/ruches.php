<?php 

require_once "modèle/database.php";


class ruches extends database {
    /*******************************************************
    Retourne la liste des articles
    Entrée :
    Retour :
    [array] : Tableau associatif contenant la liste des articles
    *******************************************************/
    public function checkruche($idruche)
    {
        
        $data = array($idruche);

        $req = 'SELECT * from ruches WHERE ID_Ruches = ?';

        $user = $this->execReqPrep($req, $data);

        return $user;
    }
    public function checkgerer($iduser, $idruche)
    {
        $req = 'SELECT * FROM `gérer` WHERE Id_utilisateur = '.$iduser.' AND ID_Ruches = '.$idruche.';';

        $user = $this->execReq($req);

        return $user;
    }
    public function ajouter($nom, $id){
        $req = "INSERT INTO `ruches` (`ID_Ruches`, `nom`) VALUES ('".$id."', '".$nom."');";
        $this->execReq($req);
    }

    public function gerant($gerant, $ruche){
        $req = "INSERT INTO `gérer` (`Id_utilisateur`, `ID_Ruches`, `gérer`) VALUES ('".$gerant."', '".$ruche."', NULL);";
        $this->execReq($req);
    }

    public function update($nom, $newidruche, $ancienid){
        $req = "UPDATE `ruches` SET `ID_Ruches` = '".$newidruche."', `nom` = '".$nom."' WHERE `ruches`.`ID_Ruches` = ".$ancienid.";";
        $this->execReq($req);
    }
    public function updategerant($idancien, $newid, $user){
        $req = "UPDATE `gérer` SET `ID_Ruches` = '".$newid."' WHERE `gérer`.`Id_utilisateur` = ".$user." AND `gérer`.`ID_Ruches` = ".$idancien.";";
        $this->execReq($req);
    }


    public function getruches($user){
        $data = array($user);

        $req = 'SELECT * FROM ruches INNER JOIN gérer ON gérer.ID_Ruches=ruches.ID_Ruches WHERE Id_utilisateur = ?';

        $user = $this->execReqPrep($req, $data);

        return $user;
    }

    public function supprimer($id){
        $data = array($id);

        $req = 'DELETE FROM ruches WHERE `ruches`.`ID_Ruches` = ?';

        $user = $this->execReqPrep($req, $data);

        return $user;
    }

    public function deletuser($id){
        $data = array($id);

        $req = 'DELETE FROM gérer WHERE `gérer`.`ID_Ruches` = ?';

        $user = $this->execReqPrep($req, $data);

        return $user;
    }

    public function fileattente($id_user, $id_ruche, $nom_ruche, $prenom_user){
        $req = "INSERT INTO `attente` (`ID_attente`, `Id_utilisateur`, `ID_Ruches`, `nom_ruche`, `prenom_utilisateur`) VALUES (NULL, '".$id_user."', '".$id_ruche."', '".$nom_ruche."', '".$prenom_user."');";
        $this->execReq($req);
    }

    public function getdemandes(){
        $req = "SELECT * FROM attente";
        $demande = $this->execReq($req);
        return $demande;
    }

    public function deletask($id){
        $data = array($id);
        $req = 'DELETE FROM attente WHERE `attente`.`ID_attente` = ?';
        $user = $this->execReqPrep($req, $data);
        return $user;
    }

    public function updateRuchePhoto($idArt)
    {
        
        if (isset($_FILES['photoRuche'])) {
            
            if ($_FILES['photoRuche']["error"] == 0) {
                
                if ($_FILES['photoRuche']["size"] <= 20000000) {
                    $infosfichier = new SplFileInfo($_FILES['photoRuche']['name']);
                    $extension_upload = $infosfichier->getExtension();
                    $extensions_autorisees = array('jpg', 'png');
                    if (in_array($extension_upload, $extensions_autorisees)) {
                        if (is_dir('img/imported')) {
                            // Stockage définitif du fichier photo dans le dossier "uploads"
                            move_uploaded_file(
                                $_FILES['photoRuche']['tmp_name'],
                                'img/imported/' . $idArt .".". $extension_upload
                            );
                            echo "Transfert du fichier <b>" . $_FILES['photoRuche']['name'] . "</b> effectué !";
                        } else {
                            mkdir('img/imported');
                            // Stockage définitif du fichier photo dans le dossier "uploads"
                            move_uploaded_file(
                                $_FILES['photoRuche']['tmp_name'],
                                'img/imported/' . $_FILES['photoRuche']['name']
                            );
                            echo "Transfert du fichier <b>" . $_FILES['photoRuche']['name'] . "</b> effectué !";
                        }

                    } else
                        throw new Exception("Fichier non autorisé.");
                } else {

                    throw new Exception("Echec du transfert : Fichier trop volumineux.");
                }
            } else {
                throw new Exception(" Echec du transfert avec le code d'erreur : " . $_FILES['photoRuche']['error']."");
            }
        }
    }

    public function getAllruches(){
        $req = "SELECT ID_Ruches from ruches";
        $rucheadmin = $this->execReq($req);
        return $rucheadmin;
    }
}