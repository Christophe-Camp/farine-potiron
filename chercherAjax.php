<?php
// Controleur (ne peut être utilisé que comme URL)
// Rôle : Recherche des recettes via AJAX
// Paramètres : 
//  - recherche (GET) : mot-clé à rechercher dans le titre ou la description des recettes
//  - farine (GET) : référence de la farine pour filtrer les recettes

include "library/init.php"; 
header("Content-Type: application/json"); // On renvoie du JSON

try {
    // Récupération des paramètres GET
    $recherche = $_GET['recherche'] ?? '';
    $farine = $_GET['farine'] ?? '';

    // Instanciation du modèle Recette
    $recetteModel = new recette();

    // Recherche via la méthode du modèle
    $recettes = $recetteModel->chercherRecettes($recherche, $farine);

    // Retour JSON
    echo json_encode([
        "success" => true,
        "recettes" => $recettes
    ]);
    
} catch (Exception $e) {
    // Gestion d'erreur JSON
    echo json_encode([
        "success" => false,
        "message" => "Erreur serveur : " . $e->getMessage()
    ]);
}