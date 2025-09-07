<?php
// Controleur (ne peut être utilisé que comme URL)
// Rôle: afficher le formulaire de création de recette
// Paramètres: néant (l'utilisateur doit être connecté)

// Initialisations globales 
include "library/init.php";

// Vérifie que l'utilisateur est connecté ; sinon, redirige vers la page de connexion
$utilisateur = utilisateurConnecte();
if (!$utilisateur || !$utilisateur->get("id")) {
    header("Location: connexion.php");
    exit;
}

// Récupère toutes les farines depuis la base de données (pour les afficher dans le formulaire)
$farineModel = new farine(); // Instanciation du modèle (utile si besoin plus tard)
$listeFarines = bddGetRecords("SELECT reference, libelle, description FROM farine ORDER BY libelle ASC");

// Transforme la liste des farines en tableau associatif [référence => libellé]
// Cela permet de pré-remplir facilement une <select> dans le formulaire HTML
$farines = [];       // Pour le <select> (référence => libellé)
$farinesDesc = [];   // Pour le JS (référence => description)
foreach ($listeFarines as $f) {
    $farines[$f['reference']] = $f['libelle'];
    $farinesDesc[$f['reference']] = $f['description'];
}

// Définition de la variable utilisée pour mettre en surbrillance le menu actif
$pageActive = "recette";

// Inclusion du template HTML contenant le formulaire de création de recette
include "templates/pages/formCreaRecette.php";