<?php
// Classe Commentaire
// Rôle : gérer les commentaires des recettes
// Fonctionnement : permet de récupérer tous les commentaires d'une recette avec les infos de l'auteur.

class commentaire extends _model {

    protected $table = "commentaire";
    protected $champs = ["recette", "auteur", "commentaire_recette", "date_crea", "date_modif"];
    protected $id;

    // Récupère tous les commentaires d'une recette
    // Paramètre : $idRecette = ID de la recette
    // Retour : tableau de commentaires avec pseudo de l'auteur
    public function getByRecette(int $idRecette): array {
        $sql = "SELECT c.id, c.commentaire_recette, c.date_crea, c.auteur, u.pseudo
                FROM commentaire c
                JOIN utilisateur u ON c.auteur = u.id
                WHERE c.recette = :id
                ORDER BY c.date_crea DESC";
        return bddGetRecords($sql, [":id" => $idRecette]);
    }
}