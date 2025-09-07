<?php
// Classe Ingredient
// Rôle : gérer les ingrédients liés aux recettes
// Fonctionnement : contient des méthodes pour récupérer les ingrédients d'une recette, avec indication s’il s’agit de farine et sa référence.

class ingredient extends _model {

    protected $table = "ingredient";
    protected $champs = ["recette", "nom", "quantite", "reference_farine", "est_farine"];
    protected $id;

    // Récupère tous les ingrédients pour une recette donnée
    // Retour : tableau de lignes avec nom, quantité, est_farine et reference_farine
    public function getByRecette(int $idRecette): array {
        $sql = "SELECT nom, quantite, est_farine, reference_farine 
                FROM ingredient 
                WHERE recette = :id";
        return bddGetRecords($sql, [":id" => $idRecette]);
    }
}