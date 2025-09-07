<?php
// Controleur (ne peut être utilisé que comme URL)
// Rôle: Enregistre une nouvelle recette postée par un utilisateur connecté
// Paramètres: Données du formulaire POST (titre, description, farines, ingrédients, difficulté, durée)


// Initialisations générales 
include "library/init.php";

// Définition de la variable utilisée pour mettre en surbrillance le menu actif
$pageActive = "recette";

// Vérifier que l'utilisateur est connecté
$utilisateur = utilisateurConnecte();
if (!$utilisateur || !$utilisateur->get("id")) {
    // Si non connecté, on bloque tout
    die("Utilisateur non connecté");
}

// Récupérer les données du formulaire avec vérification de sécurité 
$titre = trim($_POST['titre'] ?? '');
$description = trim($_POST['description_detaillee'] ?? '');
$duree = trim($_POST['duree_preparation'] ?? '');
$difficulteTexte = $_POST['difficulte'] ?? 'Facile';

$farines = $_POST['farine'] ?? []; // tableau de références de farines
$quantitesFarine = $_POST['quantite_farine'] ?? [];
$ingredientsNoms = $_POST['ingredient_nom'] ?? [];
$ingredientsQuantites = $_POST['ingredient_quantite'] ?? [];

// Vérification minimale des champs obligatoires
$erreurs = [];
if (empty($titre)) $erreurs[] = "Le titre est obligatoire.";
if (empty($description)) $erreurs[] = "La description est obligatoire.";
if (empty($duree)) $erreurs[] = "La durée est obligatoire.";

// Vérifie qu’au moins une farine valide est sélectionnée
$farinesValides = [];
foreach ($farines as $i => $f) {
    $ref = trim($f);
    $qte = trim($quantitesFarine[$i] ?? '');
    if ($ref !== '' && $qte !== '') {
        $farinesValides[] = ['ref' => $ref, 'quantite' => $qte];
    }
}
if (empty($farinesValides)) {
    $erreurs[] = "Au moins une farine avec une quantité doit être sélectionnée.";
}

// Si erreurs, on renvoie vers le formulaire de création
if (!empty($erreurs)) {
    include "templates/pages/formCreaRecette.php";
    exit;
}

// Convertir la difficulté (texte) en entier via la méthode d'instance de la classe recette
$recette = new recette(); // On crée une instance temporaire pour appeler la méthode
$difficulteInt = $recette->convertirDifficulteEnInt($difficulteTexte);

// Création effective de l'objet recette avec les données du formulaire
$recette = new recette(); // Nouvelle instance réelle de la recette à enregistrer
$recette->set('titre', $titre);
$recette->set('description_detaillee', $description);
$recette->set('duree_preparation', $duree);
$recette->set('difficulte', $difficulteInt);
$recette->set('auteur', $utilisateur->get('id')); // ID de l'utilisateur connecté
$recette->set('date_crea', date('Y-m-d H:i:s'));
$recette->set('date_modif', date('Y-m-d H:i:s'));
$recette->update(); // Insère ou met à jour la recette dans la base

// Boucle sur les farines sélectionnées pour les enregistrer comme ingrédients
foreach ($farines as $i => $f) {
    $qte = $quantitesFarine[$i] ?? '';
    if (!empty($f)) {
        // 1 = farine, on utilise la référence comme nom ET référence
        $recette->ajouterIngredient($f, $qte, 1, $f);
    }
}

// Boucle sur les autres ingrédients (non farines)
foreach ($ingredientsNoms as $i => $nom) {
    $nom = trim($nom);
    $qte = $ingredientsQuantites[$i] ?? '';
    if ($nom) {
        // 0 = ingrédient libre, sans référence catalogue
        $recette->ajouterIngredient($nom, $qte, 0);
    }
}

// Redirection vers la liste des recettes de l'utilisateur
header("Location: afficherListeRecetteUtilisateur.php");
exit;