<?php
// Controleur (ne peut être utilisé que comme URL)
// Rôle : Traiter les données du formulaire de connexion, vérifier les identifiants, connecter l’utilisateur
// Paramètres : $_POST['pseudo'] (ou email), $_POST['mot_de_passe']

// Initialisations globales
include "library/init.php";

// Vérifie que les champs pseudo/email et mot de passe ont bien été envoyés via le formulaire
if (empty($_POST['pseudo']) || empty($_POST['mot_de_passe'])) {
    // Si l’un des champs est vide → redirection vers le formulaire avec un message d'erreur
    header("Location: connexion.php?error=champs_vides");
    exit;
}

// Récupération des données envoyées par l’utilisateur
$identifiant = trim($_POST['pseudo']); // Peut être un pseudo ou un email
$motDePasse  = $_POST['mot_de_passe']; // Mot de passe en clair (sera vérifié via hash)

// Création d’un objet utilisateur (vide pour l’instant)
$utilisateur = new utilisateur();

// Recherche de l'utilisateur en base par pseudo OU par email
if ($utilisateur->loadByPseudoOrEmail($identifiant)) {

    // Vérifie que le mot de passe saisi correspond au hash stocké en base
    if (password_verify($motDePasse, $utilisateur->get("mot_de_passe"))) {
        
        // Si la vérification réussit → on connecte l'utilisateur
        connecter($utilisateur); // Fonction utilitaire qui enregistre l’utilisateur en session

        // Redirection vers la page d'accueil
        header("Location: index.php");
        exit;

    } else {
        // Si le mot de passe est incorrect → retour au formulaire avec erreur
        header("Location: connexion.php?error=mdp_incorrect");
        exit;
    }

} else {
    // Si aucun utilisateur ne correspond à l’identifiant → retour au formulaire avec erreur
    header("Location: connexion.php?error=not_found");
    exit;
}