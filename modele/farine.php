<?php
// Classe Farine
// Rôle : gérer les types de farines disponibles
// Fonctionnement : permet de charger une farine, l'ajouter ou la mettre à jour, et récupérer toutes les farines.

class farine extends _model {

    protected $table = "farine";
    protected $champs = ["reference", "libelle", "description"];

    // Charge une farine à partir de sa référence
    // Retour : true si trouvé, false sinon
    function loadByReference($reference) {
        $row = bddGetRecord("SELECT * FROM farine WHERE reference = :ref", [":ref" => $reference]);
        if ($row) {
            $this->loadFromTab($row);
            return true;
        }
        return false;
    }

    // Sauvegarde la farine : insertion si nouvelle, mise à jour si existe déjà
    // Retour : true si succès, false sinon
    function save() {
        // Vérifier si elle existe déjà
        $row = bddGetRecord("SELECT reference FROM farine WHERE reference = :ref", [":ref" => $this->get("reference")]);
        if ($row) {
            // Mise à jour
            $sql = "UPDATE farine 
                    SET libelle = :libelle, description = :description 
                    WHERE reference = :ref";
            return bddRequest($sql, [
                ":libelle" => $this->get("libelle"),
                ":description" => $this->get("description"),
                ":ref" => $this->get("reference")
            ]) !== false;
        } else {
            // Insertion
            return bddInsert("farine", [
                "reference"   => $this->get("reference"),
                "libelle"     => $this->get("libelle"),
                "description" => $this->get("description")
            ]) != 0;
        }
    }

    // Récupère toutes les farines sous forme de tableau simple
    public function getAll(): array {
        return bddGetRecords("SELECT reference, libelle, description FROM farine ORDER BY libelle ASC");
    }
    
    // Récupère toutes les farines sous forme de mapping reference => [libelle, description]
    public function getAllAsMap(): array {
        $rows = bddGetRecords("SELECT reference, libelle, description FROM farine");
        $map = [];
        foreach ($rows as $f) {
            $map[$f['reference']] = [
                'libelle' => $f['libelle'], 
                'description' => $f['description']
            ];
        }
        return $map;
    }
}