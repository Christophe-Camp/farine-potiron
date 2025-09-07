<?php
// Classe Utilisateur
// Rôle : gérer les utilisateurs (création, vérification, récupération)
// Champs principaux : pseudo, email, mot_de_passe

class utilisateur extends _model {

    protected $table = "utilisateur";              
    protected $champs = ["pseudo", "email", "mot_de_passe"]; 
    protected $id;

    // Charger un utilisateur par son pseudo
    // Retourne true si trouvé, false sinon
    function loadByPseudo($pseudo){
        $sql = "SELECT * FROM `$this->table` WHERE `pseudo` = :pseudo";
        $param = [":pseudo" => $pseudo];

        $ligne = bddGetRecord($sql, $param);

        if($ligne == false) {
            $this->valeurs = [];
            $this->id = null;
            return false;
        }

        $this->loadFromTab($ligne);
        $this->id = $ligne["id"];
        return true;
    }

    // Vérifie si un utilisateur existe via son email
    // Retourne true si existe, false sinon
    function utilisateurExiste($email) {
        global $bdd;
        $sql = "SELECT id FROM utilisateur WHERE email = ?";
        $req = $bdd->prepare($sql);
        $req->execute([$email]);
        return $req->fetch() !== false;
    }

    // Crée un nouvel utilisateur avec pseudo, email et mot de passe hashé
    function creerUtilisateur($pseudo, $email, $mot_de_passe_hash) {
        global $bdd;
        $sql = "INSERT INTO utilisateur (pseudo, email, mot_de_passe) VALUES (?, ?, ?)";
        $req = $bdd->prepare($sql);
        $req->execute([$pseudo, $email, $mot_de_passe_hash]);
    }

    // Récupère un utilisateur par son email
    // Retourne un tableau associatif ou null
    function utilisateurParEmail($email) {
        global $bdd;
        $sql = "SELECT * FROM utilisateur WHERE email = ?";
        $req = $bdd->prepare($sql);
        $req->execute([$email]);
        return $req->fetch(PDO::FETCH_ASSOC);
    }

    // Charger un utilisateur par pseudo ou email
    // Retourne true si trouvé, false sinon
    function loadByPseudoOrEmail($identifiant) {
        $sql = "SELECT * FROM `$this->table` WHERE `pseudo` = :identifiant OR `email` = :identifiant LIMIT 1";
        $param = [":identifiant" => $identifiant];

        $ligne = bddGetRecord($sql, $param);

        if ($ligne == false) {
            $this->valeurs = [];
            $this->id = null;
            return false;
        }

        $this->loadFromTab($ligne);
        $this->id = $ligne["id"];
        return true;
    }
}