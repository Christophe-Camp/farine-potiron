<?php
// Controleur (ne peut être utilisé que comme URL)
// Rôle : Traiter le formulaire d’inscription, valider les données, créer un utilisateur et le connecter automatiquement
// Paramètres : $_POST['pseudo'], $_POST['email'], $_POST['mot_de_passe'], $_POST['confirm_mot_de_passe'], $_POST['recaptcha_token']

// Initialisations globales
include "library/init.php";

// Tableau pour stocker les éventuelles erreurs
$erreurs = [];

// Récupération des données du formulaire 
$pseudo         = trim($_POST['pseudo'] ?? '');
$email          = trim($_POST['email'] ?? '');
$mot_de_passe   = $_POST['mot_de_passe'] ?? '';
$confirm        = $_POST['confirm_mot_de_passe'] ?? '';
$recaptchaToken = $_POST['recaptcha_token'] ?? '';

// Vérification du reCAPTCHA v3 (sécurité anti-robot) 
$cleSecrete = '6LePk7wrAAAAALYUzau17953ANa8nlnmTaVBtKUo';
if ($recaptchaToken) {
    $reponse = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$cleSecrete}&response={$recaptchaToken}");
    $resultat = json_decode($reponse, true);

    // Si Google indique que ce n’est pas un humain ou score trop bas → erreur
    if (!$resultat['success'] || $resultat['score'] < 0.5) {
        $erreurs[] = "Échec de la vérification anti-robot.";
    }
}

// Vérification des champs obligatoires 
if (!$pseudo || !$email || !$mot_de_passe || !$confirm) {
    $erreurs[] = "Tous les champs sont obligatoires.";
}

// Vérifie la validité de l’email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $erreurs[] = "Adresse email invalide.";
}

// Vérifie la confirmation du mot de passe
if ($mot_de_passe !== $confirm) {
    $erreurs[] = "Les mots de passe ne correspondent pas.";
}

// Vérifie si un utilisateur existe déjà avec cet email
$u = new utilisateur();
if ($u->utilisateurExiste($email)) {
    $erreurs[] = "Un utilisateur avec cet email existe déjà.";
}

// Si aucune erreur → création du compte
if (empty($erreurs)) {
    // Hash sécurisé du mot de passe
    $mot_de_passe_hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);

    // Création de l’utilisateur en base
    $u->creerUtilisateur($pseudo, $email, $mot_de_passe_hash);

    // Recharge l’objet utilisateur depuis la base pour récupérer l’id
    $u->loadFromField('email', $email);

    // Connexion automatique → enregistre l’utilisateur en session
    $_SESSION['utilisateur'] = [
        'id'            => $u->id(),
        'pseudo'        => $u->get('pseudo'),
        'email'         => $u->get('email'),
        'activ'         => true,              // marque l’utilisateur comme actif
        'last_activity' => time()             // permet de gérer l’expiration de session
    ];

    // Redirection vers la page d’accueil
    header("Location: index.php");
    exit;
}

// En cas d’erreurs
// On inclut à nouveau le template d’inscription qui affichera les messages d’erreurs
include "templates/pages/formInscription.php";