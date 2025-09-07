<?php
// Classe _model
// Rôle : classe de base pour tous les modèles (utilisateur, recette, farine, etc.)
// Fonctionnement : fournit les méthodes génériques pour charger, créer, mettre à jour, supprimer et manipuler les objets liés à une table de la base de données.

class _model {

    protected $table = "";        // Nom de la table associée
    protected $champs = [];       // Liste des champs de la table
    protected $liens = [];        // Champs considérés comme liens (ne seront pas passés en html)

    protected $valeurs = [];      // Valeurs de l'objet
    protected $id;                // ID de l'objet (clé primaire)

    // Constructeur : si un ID est fourni, charge automatiquement les données
    function __construct($id = null) {
        if ($id !== null) {
            $this->load($id);
        }
    }

    // Charge un objet à partir de son ID
    function load($id = null) {
        if ($id !== null) $this->id = $id;
        if (!$this->id) return false;

        $sql = "SELECT * FROM `$this->table` WHERE id = :id";
        $param = [":id" => $this->id];
        $ligne = bddGetRecord($sql, $param);

        if (!$ligne) return false;

        $this->loadFromTab($ligne);
        return true;
    }

    // Charge un objet depuis un champ spécifique
    function loadFromField($champ, $valeur) {
        $row = bddGetRecord("SELECT * FROM {$this->table} WHERE $champ = :val LIMIT 1", [":val" => $valeur]);
        if ($row) {
            foreach ($row as $key => $value) {
                if ($key === "id") $this->id = $value;
                else $this->valeurs[$key] = $value;
            }
            return true;
        }
        return false;
    }

    // Charge un objet depuis un tableau de valeurs
    function loadFromTab($tab) {
        $this->valeurs = [];
        foreach ($this->champs as $champ) {
            if (isset($tab[$champ])) $this->valeurs[$champ] = $tab[$champ];
        }
        if (isset($tab["id"])) $this->id = $tab["id"];
    }

    // Retourne une liste d'objets avec filtres et tri optionnels
    function list($champ = null, $valeur = null, $tri = "id", $ordre = "ASC") {
        $sql = "SELECT * FROM `$this->table`";
        $param = [];
        if ($champ !== null && $valeur !== null) {
            $sql .= " WHERE `$champ` = :val";
            $param = [":val" => $valeur];
        }
        $sql .= " ORDER BY `$tri` $ordre";
        return bddGetRecords($sql, $param);
    }

    // Met à jour plusieurs champs en une seule fois
    function setFields(array $tab) {
        foreach ($tab as $champ => $val) {
            $this->set($champ, $val);
        }
    }

    // Récupère la valeur d'un champ
    function get($champ) {
        if ($champ == 'id') return $this->id;
        if (in_array($champ, $this->champs)) return $this->valeurs[$champ] ?? null;
        return null;
    }

    // Modifie la valeur d'un champ
    function set($champ, $valeur) {
        if (in_array($champ, $this->champs)) {
            $this->valeurs[$champ] = $valeur;
        }
    }

    // Récupère la valeur d'un champ en format HTML (sécurisé)
    function html($champ) {
        if (in_array($champ, $this->liens)) return '';
        return nl2br(htmlentities($this->get($champ), ENT_QUOTES, 'UTF-8'));
    }

    // Supprime l'objet de la base
    function delete() {
        return bddDelete($this->table, $this->id);
    }

    // Met à jour ou insère l'objet dans la base
    function update() {
        if ($this->id) {
            return bddUpdate($this->table, $this->valeurs, $this->id);
        } else {
            $id = bddInsert($this->table, $this->valeurs);
            if ($id) {
                $this->id = $id;
                return true;
            }
            return false;
        }
    }

    // Retourne l'ID de l'objet
    function id() {
        return $this->id;
    }

    // Vérifie si l'objet est chargé
    function is() {
        return isset($this->id);
    }
}