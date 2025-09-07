<?php
// Controleur (ne peut être utilisé que comme URL)
// Rôle: Gérer la modification d'une recette existante par son auteur
// Paramètres: id (ID de la recette), titre, description_detaillee, duree_preparation, difficulte, farine[], quantite_farine[], ingredient_nom[], ingredient_quantite[]

// Initialisations globales 
include "library/init.php";

// Vérifie que l’utilisateur est connecté et que l'objet utilisateur est valide
$utilisateur = utilisateurConnecte();
if (!$utilisateur || !$utilisateur->get("id")) {
    die("Utilisateur non connecté");
}

// Récupération et validation de l'ID de la recette
$id = $_POST['id'] ?? null;
if (!$id || !is_numeric($id)) {
    die("ID recette invalide.");
}

// Charger la recette depuis la base de données
$recette = new recette();
if (!$recette->load($id)) {
    die("Recette introuvable.");
}

// Vérifie que l'utilisateur connecté est bien l'auteur de la recette
if ($recette->get("auteur") != $utilisateur->get("id")) {
    die("Vous ne pouvez pas modifier cette recette.");
}

// Récupération des données du formulaire et nettoyage
$titre = trim($_POST['titre'] ?? '');
$description = trim($_POST['description_detaillee'] ?? '');
$duree = trim($_POST['duree_preparation'] ?? '');
$difficulte = intval($_POST['difficulte'] ?? 1); // Valeur par défaut = 1

// Récupération des farines et leurs quantités
$farines = $_POST['farine'] ?? [];
$quantitesFarine = $_POST['quantite_farine'] ?? [];

// Récupération des autres ingrédients et leurs quantités
$nomsIngredients = $_POST['ingredient_nom'] ?? [];
$quantitesIngredients = $_POST['ingredient_quantite'] ?? [];

// Mise à jour des informations principales de la recette
$recette->set('titre', $titre);
$recette->set('description_detaillee', $description);
$recette->set('duree_preparation', $duree);
$recette->set('difficulte', $difficulte);
$recette->set('date_modif', date('Y-m-d H:i:s'));
$recette->update(); // Enregistrement en base

// Suppression des anciens ingrédients liés à cette recette pour les remplacer
$bdd->prepare("DELETE FROM ingredient WHERE recette = :id")->execute([":id" => $id]);

// Réinsertion des farines
foreach ($farines as $index => $f) {
    if (!empty($f)) {
        $ing = new ingredient();
        $ing->set("recette", $id);
        $ing->set("nom", ""); // le libellé sera récupéré après via la table farine
        $ing->set("reference_farine", $f); // stocke la référence réelle
        $ing->set("quantite", $quantitesFarine[$index] ?? "");
        $ing->set("est_farine", 1); // indique que c'est une farine
        $ing->update(); // insertion en base
    }
}

// Réinsertion des autres ingrédients
foreach ($nomsIngredients as $index => $nom) {
    if (!empty(trim($nom))) {
        $ing = new ingredient();
        $ing->set("recette", $id);
        $ing->set("nom", $nom); // nom de l'ingrédient
        $ing->set("quantite", $quantitesIngredients[$index] ?? "");
        $ing->set("est_farine", 0); // indique que ce n'est pas une farine
        $ing->update(); // insertion en base
    }
}

// Redirection vers la page de la recette modifiée
header("Location: afficherRecetteUtilisateur.php?id=" . $id);
exit;