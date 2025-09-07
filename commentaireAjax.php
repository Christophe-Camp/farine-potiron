<?php
// Controleur (ne peut être utilisé que comme URL)
// Rôle: Gérer l'ajout et la modification des commentaires via AJAX
// Paramètres: action (ajouter/modifier), contenu (texte du commentaire), recette_id ou id selon action

// Initialisations générales
include "library/init.php"; 
header("Content-Type: application/json");

// Vérifie que l'utilisateur est connecté
$utilisateur = utilisateurConnecte();
if (!$utilisateur) {
    // Si non connecté, renvoyer un JSON d'erreur
    echo json_encode(["success" => false, "message" => "Non connecté"]);
    exit;
}

// Récupérer les données JSON envoyées en POST
$data = json_decode(file_get_contents("php://input"), true);

// Vérifie que des données ont bien été reçues
if (!$data) {
    echo json_encode(["success" => false, "message" => "Aucune donnée reçue"]);
    exit;
}

// Récupère l'action à effectuer et le contenu du commentaire
$action = $data["action"] ?? "";
$contenu = trim($data["contenu"] ?? "");

// =======================
// === AJOUTER COMMENTAIRE ===
// =======================
if ($action === "ajouter") {
    $recetteId = intval($data["recette_id"] ?? 0);

    // Vérifie que l'ID de la recette est correct et que le contenu n'est pas vide
    if (!$recetteId || $contenu === "") {
        echo json_encode(["success" => false, "message" => "Données invalides"]);
        exit;
    }

    // Création d'un nouvel objet commentaire
    $com = new commentaire();
    $com->set("recette", $recetteId);
    $com->set("auteur", $utilisateur->get("id"));
    $com->set("commentaire_recette", $contenu);
    $com->set("date_crea", date("Y-m-d H:i:s"));
    $com->set("date_modif", date("Y-m-d H:i:s"));

    // Tentative d'insertion dans la base
    if ($com->update()) {
        echo json_encode([
            "success" => true,
            "id" => $com->id(),               // ID du commentaire créé
            "pseudo" => $utilisateur->get("pseudo"),
            "date_crea" => $com->get("date_crea")
        ]);
    } else {
        echo json_encode(["success" => false, "message" => "Erreur lors de l'insertion"]);
    }
    exit;
}

// =======================
// === MODIFIER COMMENTAIRE ===
// =======================
if ($action === "modifier") {
    $id = intval($data["id"] ?? 0);

    // Vérifie que l'ID du commentaire est correct et que le contenu n'est pas vide
    if (!$id || $contenu === "") {
        echo json_encode(["success" => false, "message" => "Données invalides"]);
        exit;
    }

    // Charger le commentaire existant
    $com = new commentaire($id);

    // Vérifie que l'utilisateur est bien l'auteur du commentaire
    if ($com->get("auteur") != $utilisateur->get("id")) {
        echo json_encode(["success" => false, "message" => "Non autorisé"]);
        exit;
    }

    // Mise à jour du contenu et de la date de modification
    $com->set("commentaire_recette", $contenu);
    $com->set("date_modif", date("Y-m-d H:i:s"));

    // Tentative de mise à jour en base
    if ($com->update()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Erreur lors de la modification"]);
    }
    exit;
}

// Si aucune action reconnue n'est reçue
echo json_encode(["success" => false, "message" => "Action inconnue"]);