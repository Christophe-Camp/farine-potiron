<?php
// Controleur (ne peut être utilisé que comme URL)
// Rôle : Afficher toutes les recettes créées par l'utilisateur connecté
// Paramètres : néant

// Initialisations générales
include "library/init.php";

// Vérifier si l'utilisateur est connecté
$utilisateur = utilisateurConnecte();
if (!$utilisateur || !$utilisateur->get("id")) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: connexion.php");
    exit;
}

// Récupérer l'ID de l'utilisateur connecté
$idUtilisateur = $utilisateur->get("id");

// Récupérer toutes les recettes associées à cet utilisateur
$recettes = recette::recupereRecettesParUtilisateur($idUtilisateur);

// Définir la page active (utile pour la navigation ou les menus dans le template)
$pageActive = "recette"; 

// Inclure le template d'affichage des recettes utilisateur
include "templates/pages/listeRecetteUtilisateur.php";