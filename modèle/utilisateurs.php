<?php

require_once "modèle/database.php";


class utilisateurs extends database
{
    // Fonction pour obtenir un utilisateur en fonction de son email
    public function GetUser($iduser)
    {
        // Création d'un tableau de données avec l'ID de l'utilisateur
        $data = array($iduser);

        // Requête SQL pour sélectionner tous les champs de l'utilisateur avec un email spécifique
        $req = 'SELECT * from utilisateurs WHERE mail = ?';

        // Exécution de la requête préparée
        $user = $this->execReqPrep($req, $data);

        // Retourne l'utilisateur trouvé
        return $user;
    }

    // Fonction pour obtenir un utilisateur par son ID
    public function GetUserbyID($iduser)
    {
        // Création d'un tableau de données avec l'ID de l'utilisateur
        $data = array($iduser);

        // Requête SQL pour récupérer certaines informations sur l'utilisateur en fonction de son ID
        $req = 'SELECT Nom, Prenom, Mail, MotDePasse, Statut, Id_utilisateur, DATE_FORMAT(connexion, "%d / %m / %Y") as connexion, DATE_FORMAT(inscription, "%d / %m / %Y") as inscription from utilisateurs WHERE Id_utilisateur = ?';

        // Exécution de la requête préparée
        $user = $this->execReqPrep($req, $data);

        // Retourne l'utilisateur trouvé
        return $user;
    }

    // Fonction pour inscrire un nouvel utilisateur
    public function inscrire($prenom, $nom, $email, $mdpgood)
    {

        $data = array($nom, $prenom, $mdpgood, $email);
        // Requête SQL pour insérer un nouvel utilisateur dans la base de données
        $req = "INSERT INTO `utilisateurs` (`Id_utilisateur`, `Nom`, `Prenom`, `MotDePasse`, `Mail`, `Statut`, `connexion`, `inscription`) VALUES (NULL, ?, ?, ?, ?, 'utilisateur', '" . date('Y-m-d') . "', '" . date('Y-m-d') . "');)";

        // Exécution de la requête
        $this->execReqPrep($req, $data);
    }

    // Fonction pour récupérer tous les utilisateurs
    public function check()
    {
        // Requête SQL pour sélectionner tous les utilisateurs de la table "utilisateurs"
        $req = "SELECT * from utilisateurs";

        // Exécution de la requête
        $all = $this->execReq($req);

        // Retourne tous les utilisateurs
        return $all;
    }

    // Fonction pour obtenir tous les utilisateurs administrateurs
    public function GetUserAdmin()
    {
        // Requête SQL pour récupérer certaines informations sur tous les utilisateurs
        $req = "SELECT Prenom, Id_utilisateur, DATE_FORMAT(connexion, '%d / %m / %Y') as connexion from utilisateurs";

        // Exécution de la requête
        $users = $this->execReq($req);

        // Retourne les utilisateurs trouvés
        return $users;
    }

    // Fonction pour mettre à jour la date de dernière connexion d'un utilisateur
    public function updatedate($id)
    {
        // Requête SQL pour mettre à jour la date de connexion de l'utilisateur avec l'ID spécifié
        $req = "UPDATE `utilisateurs` SET `connexion` = '" . date('Y-m-d') . "' WHERE `utilisateurs`.`Id_utilisateur` = " . $id . ";";

        // Exécution de la requête
        $this->execReq($req);
    }

    // Fonction pour mettre à jour la photo de l'utilisateur
    public function updateUserPhoto($idArt)
    {
        // Vérification si un fichier photo a été envoyé
        if (isset($_FILES['photoUser'])) {
            // Vérification si le fichier n'a pas d'erreur
            if ($_FILES['photoUser']["error"] == 0) {
                // Vérification si la taille du fichier est inférieure à 20 Mo
                if ($_FILES['photoUser']["size"] <= 20000000) {
                    // Récupération de l'extension du fichier
                    $infosfichier = new SplFileInfo($_FILES['photoUser']['name']);
                    $extension_upload = $infosfichier->getExtension();

                    // Liste des extensions autorisées
                    $extensions_autorisees = array('jpg', 'png');

                    // Vérification si l'extension du fichier est autorisée
                    if (in_array($extension_upload, $extensions_autorisees)) {
                        // Vérification si le dossier 'img/imported' existe
                        if (is_dir('img/imported')) {
                            // Déplacement du fichier vers le dossier "img/imported" avec un nom basé sur l'ID de l'article
                            move_uploaded_file(
                                $_FILES['photoUser']['tmp_name'],
                                'img/imported/' . $idArt . "." . $extension_upload
                            );
                            $erreur = "Transfert du fichier <b> " . $_FILES['photoUser']['name'] . " </b> effectué !";
                            return $erreur;
                        } else {
                            // Si le dossier n'existe pas, le créer et déplacer le fichier
                            mkdir('img/imported');
                            move_uploaded_file(
                                $_FILES['photoUser']['tmp_name'],
                                'img/imported/' . $idArt . "." . $extension_upload
                            );
                            $erreur = "Transfert du fichier <b> " . $_FILES['photoUser']['name'] . " </b> effectué !";
                            return $erreur;
                        }
                    } else {
                        // Si l'extension du fichier n'est pas autorisée
                        $erreur = "extension incompatible";
                        utilisateurs($erreur, "");
                    }
                } else {
                    // Si le fichier est trop volumineux
                    $erreur = "fichier trop volumineux";
                    utilisateurs($erreur, "");
                }
            } else {
                // Si une erreur est survenue lors du transfert
                $erreur = "Une erreur est survenue";
                utilisateurs($erreur, "");
            }
        }
    }

    // Fonction pour modifier les informations d'un utilisateur avec changement de mot de passe
    public function edituserwithpdw($nom, $prenom, $mdpgood, $iduser)
    {
        $data = array($prenom, $nom, $mdpgood, $iduser);
        // Requête SQL pour mettre à jour les informations d'un utilisateur
        $req = "UPDATE `utilisateurs` SET `Prenom` = ?, `Nom` = ?, `MotDePasse` = ? WHERE `utilisateurs`.`Id_utilisateur` = ?;";

        // Exécution de la requête
        $this->execReqPrep($req, $data);
    }

    // Fonction pour modifier les informations d'un utilisateur sans changer le mot de passe
    public function editusernopdw($nom, $prenom, $iduser)
    {
        
        $data = array($prenom, $nom, $iduser);
        // Requête SQL pour mettre à jour les informations d'un utilisateur
        $req = "UPDATE `utilisateurs` SET `Prenom` = ?, `Nom` = ? WHERE `utilisateurs`.`Id_utilisateur` = ?;";

        // Exécution de la requête
        $this->execReqPrep($req, $data);
    }

    // Fonction pour changer le mot de passe d'un utilisateur administrateur
    public function changepasswordadmin($id, $mdp1)
    {

        $data = array($mdp1, $id);
        // Requête SQL pour mettre à jour le mot de passe d'un utilisateur
        $req = "UPDATE `utilisateurs` SET `MotDePasse` = ? WHERE `utilisateurs`.`Id_utilisateur` = ?;";

        // Exécution de la requête
        $this->execReqPrep($req, $data);
    }

    // Fonction pour supprimer un utilisateur de la base de données
    public function deletuser($id)
    {
        // Création d'un tableau de données avec l'ID de l'utilisateur
        $data = array($id);

        // Requête SQL pour supprimer l'utilisateur spécifié
        $req = 'DELETE FROM utilisateurs WHERE `utilisateurs`.`Id_utilisateur` = ?';

        // Exécution de la requête préparée
        $user = $this->execReqPrep($req, $data);

        // Retourne le résultat de la suppression
        return $user;
    }
}