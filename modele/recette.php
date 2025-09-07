<?php
// Classe Recette
// Rôle : gérer les recettes (création, récupération, modification, recherche)
// Fonctionnement : contient les méthodes pour ajouter des ingrédients, chercher des recettes, récupérer les commentaires et votes, et convertir la difficulté.

class recette extends _model {

    protected $table = "recette";
    protected $champs = ["titre", "description_detaillee", "duree_preparation", "difficulte", "auteur", "date_crea", "date_modif"];
    protected $id;

    // Ajouter un ingrédient à la recette
    // $nom : nom de l'ingrédient
    // $quantite : quantité
    // $estFarine : 1 si c'est une farine
    // $referenceFarine : référence si c'est une farine
    public function ajouterIngredient($nom, $quantite = '', $estFarine = 0, $referenceFarine = null) {
        $ing = new ingredient();
        $ing->set("recette", $this->id());
        $ing->set("nom", $nom);
        $ing->set("quantite", $quantite);
        $ing->set("est_farine", $estFarine);
        if ($referenceFarine !== null) {
            $ing->set("reference_farine", $referenceFarine);
        }
        return $ing->update();
    }

    // Récupérer toutes les recettes avec info auteur
    public static function recupereTouteLesRecette() {
        global $bdd;
        $sql = "SELECT r.id, r.titre, r.duree_preparation, r.difficulte, r.date_modif AS date_modification, u.pseudo
                FROM recette r
                JOIN utilisateur u ON r.auteur = u.id
                ORDER BY r.date_modif DESC";
        $requete = $bdd->prepare($sql);
        $requete->execute();
        return $requete->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer les recettes d'un utilisateur spécifique
    public static function recupereRecettesParUtilisateur($idUtilisateur) {
        global $bdd;
        $sql = "SELECT r.id, r.titre, r.duree_preparation, r.difficulte, r.date_modif AS date_modification
                FROM recette r
                WHERE r.auteur = :id
                ORDER BY r.date_modif DESC";
        $requete = $bdd->prepare($sql);
        $requete->execute([":id" => $idUtilisateur]);
        return $requete->fetchAll(PDO::FETCH_ASSOC);
    }

    // Convertir un texte de difficulté en valeur numérique
    public function convertirDifficulteEnInt(string $texte): int {
        $map = ['tresFacile' => 1, 'facile' => 2, 'difficile' => 3];
        return $map[$texte] ?? 1; // 1 par défaut
    }

    // Convertir une difficulté numérique en texte
    public function convertirDifficulteEnTexte(int $valeur): string {
        $map = [1 => 'Très facile', 2 => 'Facile', 3 => 'Difficile'];
        return $map[$valeur] ?? 'Très facile';
    }

    // Chercher des recettes par mot-clé et option farine
    public function chercherRecettes(string $q = '', $farine = ''): array {
        global $bdd;
        $where = [];
        $params = [];

        if (!empty($q)) {
            $where[] = "(r.titre LIKE :q OR r.description_detaillee LIKE :q)";
            $params[":q"] = "%$q%";
        }

        if (!empty($farine)) {
            $where[] = "r.id IN (SELECT recette FROM ingredient WHERE est_farine = 1 AND reference_farine = :farine)";
            $params[":farine"] = $farine;
        }

        $sql = "SELECT r.id, r.titre, r.duree_preparation, r.difficulte, r.date_modif, u.pseudo
                FROM recette r
                JOIN utilisateur u ON r.auteur = u.id";

        if ($where) {
            $sql .= " WHERE " . implode(" AND ", $where);
        }

        $sql .= " ORDER BY r.date_crea DESC";
        $recettes = bddGetRecords($sql, $params);

        // Convertir la difficulté en texte
        foreach ($recettes as &$r) {
            $r['difficulte'] = $this->convertirDifficulteEnTexte((int)$r['difficulte']);
        }

        return $recettes;
    }

    // Récupérer tous les ingrédients de la recette avec infos farine
    public function getIngredientsWithFarines(): array {
        $ingredientModel = new Ingredient();
        $ingredients = $ingredientModel->getByRecette($this->id());

        $farineModel = new Farine();
        $farinesMap = $farineModel->getAllAsMap();

        foreach ($ingredients as &$ing) {
            if (!empty($ing['est_farine']) && !empty($ing['reference_farine']) && isset($farinesMap[$ing['reference_farine']])) {
                $ing['nom'] = $farinesMap[$ing['reference_farine']]['libelle'];
                $ing['description_farine'] = $farinesMap[$ing['reference_farine']]['description'];
            } else {
                $ing['description_farine'] = '';
            }
        }
        unset($ing);
        return $ingredients;
    }

    // Récupérer les commentaires d'une recette
    public function getCommentaires(): array {
        $commentaireModel = new Commentaire();
        return $commentaireModel->getByRecette($this->id());
    }

    // Récupérer le nombre de likes et dislikes
    public function getVotes(): array {
        $noteModel = new Note();
        return $noteModel->getCountsByRecette($this->id());
    }

    // Vérifier le vote d'un utilisateur pour la recette
    public function getUserVote($idUser): int {
        $noteModel = new Note();
        return $noteModel->getUserVote($this->id(), $idUser);
    }
}