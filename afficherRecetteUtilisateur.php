<?php
// Controleur (ne peut être utilisé que comme URL)
// Rôle : Affiche une recette complète avec ingrédients et informations utilisateur
// Paramètres : id de la recette 

// Initialisations générales
include "library/init.php";

// Vérifier que l'utilisateur est connecté 
$estConnecte = connexionActive();
$utilisateur = $estConnecte ? utilisateurConnecte() : null;
if (!$utilisateur) {
    die("Vous devez être connecté pour voir cette page.");
}

// Vérifie l'ID de la recette
$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    die("ID de recette invalide.");
}

// Charger la recette depuis la base
$recette = new Recette();
if (!$recette->load($id)) {
    die("Recette non trouvée.");
}

// Charger l’auteur de la recette
$auteur = new Utilisateur($recette->get("auteur"));

// Récupérer tous les ingrédients avec gestion des farines
$ingredients = $recette->getIngredientsWithFarines(); // retourne déjà le nom remplacé et description si farine

// Convertir la difficulté en texte
$difficulteTexte = $recette->convertirDifficulteEnTexte($recette->get("difficulte"));

// Utilisateur connecté (peut être null)
$utilisateur = utilisateurConnecte();

// Définir la page active pour le menu ou le template
$pageActive = "accueil";

// Inclusion du template
include "templates/pages/recetteUtilisateur.php";