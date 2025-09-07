<?php
// Controleur (ne peut être utilisé que comme URL)
// Rôle : Afficher le formulaire de modification d'une recette existante
// Paramètres : id (identifiant de la recette à modifier)

// Initialisations globales
include "library/init.php";

// Vérifie que l’utilisateur est connecté
$utilisateur = utilisateurConnecte();
if (!$utilisateur || !$utilisateur->get("id")) {
    header("Location: connexion.php"); // Redirection vers la connexion
    exit;
}

// Vérifie que l’ID de la recette est valide
$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    die("ID de recette invalide.");
}

// Charge la recette à modifier
$recette = new recette();
if (!$recette->load($id)) {
    die("Recette introuvable.");
}

// Vérifie que l’utilisateur connecté est bien l’auteur de la recette
if ($recette->get("auteur") != $utilisateur->get("id")) {
    die("Vous n’avez pas le droit de modifier cette recette.");
}

// Récupère toutes les farines via la classe Farine 
$farineModel = new Farine();
$listeFarines = $farineModel->getAll(); 

// Transforme en 2 tableaux : pour le <select> et pour afficher les descriptions
$farines = [];
$farinesDesc = [];
foreach ($listeFarines as $f) {
    $farines[$f['reference']] = $f['libelle'];       // pour l’affichage dans un <select>
    $farinesDesc[$f['reference']] = $f['description']; // pour afficher la description
}

// Récupère les ingrédients de la recette via la méthode dédiée
$ingredients = $recette->getIngredientsWithFarines();

// Définition de la page active
$pageActive = "accueil";

// Inclusion du template d’affichage
include "templates/pages/formModifierRecette.php";