<?php
// Classe Note
// Rôle : gérer les votes (likes/dislikes) des utilisateurs pour les recettes
// Fonctionnement : contient des méthodes pour compter les votes, récupérer le vote d’un utilisateur, et récupérer le vote complet si besoin de modification/suppression.

class note extends _model {

    protected $table = "note";
    protected $champs = ["auteur", "recette", "aime"];
    protected $id;

    // Compte les likes et dislikes d'une recette
    // Retour : ['likes' => X, 'dislikes' => Y]
    public function getCountsByRecette(int $idRecette): array {
        $sql = "SELECT 
                    SUM(CASE WHEN aime = 1 THEN 1 ELSE 0 END) AS likes,
                    SUM(CASE WHEN aime = -1 THEN 1 ELSE 0 END) AS dislikes
                FROM note
                WHERE recette = :id";
        return bddGetRecord($sql, [":id" => $idRecette]) ?? ['likes'=>0,'dislikes'=>0];
    }

    // Récupère le vote d’un utilisateur pour une recette
    // Retour : 1 (like), -1 (dislike), 0 si aucun vote
    public function getUserVote(int $idRecette, int $idUser): int {
        $sql = "SELECT aime FROM note WHERE recette = :recette AND auteur = :auteur LIMIT 1";
        $row = bddGetRecord($sql, [":recette"=>$idRecette, ":auteur"=>$idUser]);
        return $row ? intval($row['aime']) : 0;
    }

    // Récupère le vote complet (id + valeur)
    // Utile pour modifier ou supprimer un vote existant
    public function getUserVoteRecord(int $idRecette, int $idUser): ?array {
        $sql = "SELECT id, aime FROM note WHERE recette = :recette AND auteur = :auteur LIMIT 1";
        $row = bddGetRecord($sql, [":recette"=>$idRecette, ":auteur"=>$idUser]);
        return $row ?: null;
    }
}