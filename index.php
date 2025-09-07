<?php
// Controleur (ne peut être utilisé que comme URL)
// Rôle : Afficher la page d'accueil
// Paramètres: néant


// Initialisations
include "library/init.php";

// Si l'utilisateur est connecté, on récupère ses informations
$estConnecte = connexionActive();
$utilisateur = null;

// Si l'utilisateur est connecté
if ($estConnecte) {
    $utilisateur = utilisateurConnecte(); // contient toutes les données d'un utilisateur connecté
}


// Récupérer toutes les farines existantes dans la table farine
$sqlFarines = "SELECT reference, libelle FROM farine ORDER BY libelle";
$farines = bddGetRecords($sqlFarines);


// Récupération des recettes
$recettes = recette::recupereTouteLesRecette();

// Définir la page active 
$pageActive = "accueil";

// on affiche l'accueil
include "templates/pages/accueil.php";