<?php
// Controleur (ne peut être utilisé que comme URL)
// Rôle : Affiche une recette complète avec ingrédients, commentaires et votes
// Paramètres : id de la recette 

// Initialisations générales
include "library/init.php"; 

// Vérifier si l'utilisateur est connecté
$estConnecte = connexionActive(); // Renvoie true si l'utilisateur est connecté
$utilisateur = $estConnecte ? utilisateurConnecte() : null; // Objet utilisateur si connecté, sinon null

// Vérifie l'ID de la recette
$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    die("ID de recette invalide."); // Stoppe le script si l'ID n'est pas correct
}

// Charger la recette depuis la base de données
$recette = new Recette();
if (!$recette->load($id)) {
    die("Recette non trouvée."); // Stoppe si la recette n'existe pas
}

// Charger l’auteur de la recette
$auteur = new Utilisateur($recette->get("auteur")); // Récupère l'objet utilisateur correspondant à l'auteur

// Récupérer tous les ingrédients et gérer les farines
$ingredients = $recette->getIngredientsWithFarines(); 

// Récupérer les commentaires liés à la recette
$commentaires = $recette->getCommentaires();

// Récupérer le nombre de likes et dislikes
$votes = $recette->getVotes();
$likes = $votes['likes'] ?? 0;
$dislikes = $votes['dislikes'] ?? 0;

// Vérifier si l'utilisateur connecté a déjà voté
$userVote = 0; // 0 = pas de vote par défaut
if ($estConnecte && $utilisateur) {
    $userVote = $recette->getUserVote($utilisateur->get("id")); // 1 = like, -1 = dislike
}

// Définir la page active pour le menu ou le template
$pageActive = "accueil";

// Affichage de la page : inclut le template qui va utiliser toutes les variables ci-dessus
include "templates/pages/recette.php";