<?php
// Controleur (ne peut être utilisé que comme URL)
// Rôle : Gérer les votes (like/dislike) sur une recette et renvoyer le résultat en JSON
// Paramètres : JSON { recette_id: int, valeur: int } avec valeur = 1 (like), -1 (dislike), 0 (supprimer)

// Initialisations globales
include "library/init.php";
header("Content-Type: application/json");

try {
    // Vérifie si l’utilisateur est connecté
    $utilisateur = utilisateurConnecte();
    $estConnecte = $utilisateur !== null;

    // Récupération des données JSON envoyées par fetch/ajax
    $data = json_decode(file_get_contents("php://input"), true);
    $recetteId = intval($data["recette_id"] ?? 0);
    $valeur = intval($data["valeur"] ?? 0);

    // Vérification des paramètres
    if (!$recetteId || !in_array($valeur, [-1, 0, 1])) {
        throw new Exception("Paramètres invalides.");
    }

    $userVote = 0; 
    $noteModel = new note();

    if ($estConnecte) {
        // Vérifie si l’utilisateur avait déjà voté
        $existingVote = $noteModel->getUserVoteRecord($recetteId, $utilisateur->get("id"));

        if ($existingVote) {
            $note = new note($existingVote['id']); // charge l’objet note existant
            if ($valeur === 0) {
                $note->delete();
                $userVote = 0;
            } else {
                $note->set("aime", $valeur);
                $note->update();
                $userVote = $valeur;
            }
        } elseif ($valeur !== 0) {
            // Nouveau vote
            $note = new note();
            $note->set("auteur", $utilisateur->get("id"));
            $note->set("recette", $recetteId);
            $note->set("aime", $valeur);
            $note->update();
            $userVote = $valeur;
        }
    }

    // Recalcul des likes/dislikes via la classe note
    $votes = $noteModel->getCountsByRecette($recetteId);

    echo json_encode([
        "success"   => true,
        "likes"     => $votes['likes'],
        "dislikes"  => $votes['dislikes'],
        "userVote"  => $userVote
    ]);

} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => "Erreur serveur : " . $e->getMessage()
    ]);
}