<?php
// Controleur (ne peut être utilisé que comme URL)
// Rôle: Affiche le formulaire de connexion ou redirige l'utilisateur connecté vers la page d'accueil
// Paramètres: néant (aucune donnée GET ou POST attendue ici)

// Initialisations globales 
include "library/init.php";

// Vérifie si un utilisateur est déjà connecté grâce à la session
$utilisateur = utilisateurConnecte();

if ($utilisateur->get('id')) {
    // Si l'utilisateur est déjà connecté, on le redirige vers la page d'accueil et on change le header
    header("Location: templates/pages/accueil.php");
    exit;
}

// Sinon, on affiche le formulaire de connexion
include "templates/pages/formConnexion.php";