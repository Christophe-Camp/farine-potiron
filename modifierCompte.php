<?php
// Controleur (ne peut être utilisé que comme URL)
// Rôle: Affiche le formulaire pour modifier le profil utilisateur
// Paramètres: pseudo, email, mot de passe

// Initialisations
include "library/init.php";

// Charger l'utilisateur actuellement connecté
$utilisateur = utilisateurConnecte();

// Si aucun utilisateur connecté → redirection vers la page de connexion
if (!$utilisateur->get('id')) {
    header("Location: formConnexion.php");
    exit;
}

// Définir le nom de la page active (utile pour l’affichage du menu)
$pageActive = "compte"; 

// Récupérer l'ID de l'utilisateur 
$id_utilisateur = $utilisateur->get("id");

// Inclure le template du formulaire de modification de profil
include "templates/pages/formCompte.php";