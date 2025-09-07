<?php
// Controleur (ne peut être utilisé que comme URL)
// Rôle: enregistre les modifications du profil utilisateur 
// Paramètres: POST (pseudo, email, mot_de_passe)

// Initialisations globales
include "library/init.php";

// Vérifie que l'utilisateur est connecté
$utilisateur = utilisateurConnecte();
if (!$utilisateur || !$utilisateur->get("id")) {
    die("Utilisateur non connecté");
}

// Récupération des données du formulaire
$pseudo        = trim($_POST["pseudo"] ?? "");
$email         = trim($_POST["email"] ?? "");
$mot_de_passe  = $_POST["mot_de_passe"] ?? "";

// Vérifie que l'email n'est pas déjà utilisé par un autre utilisateur
$uTest = new utilisateur();
if ($uTest->utilisateurExiste($email) && $email !== $utilisateur->get("email")) {
    die("Cet email est déjà utilisé par un autre compte.");
}

// Mise à jour des informations utilisateur
$utilisateur->set("pseudo", $pseudo);
$utilisateur->set("email", $email);

// Si un nouveau mot de passe est renseigné, le traiter
if (!empty($mot_de_passe)) {
    if (strlen($mot_de_passe) < 8) {
        // Redirection avec message d'erreur
        header("Location: modifierCompte.php?error=mdpCourt");
        exit;
    }
    $mot_de_passe_hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);
    $utilisateur->set("mot_de_passe", $mot_de_passe_hash);
}

// Sauvegarde en base de données
$utilisateur->update();

// Mise à jour propre de la session
mettreAJourUtilisateurEnSession($utilisateur);

// Redirection vers la page d’accueil avec un indicateur de succès
header("Location: index.php?modif=ok");
exit;