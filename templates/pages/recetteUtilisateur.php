<?php
// Template de page : Affichage détaillé d'une recette (version utilisateur connecté)
// Rôle : Montrer les détails complets de la recette, avec option modification si l'utilisateur est l'auteur
// Paramètres : $recette, $auteur, $difficulteTexte, $ingredients, $farinesDesc, $utilisateur
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/styles.css">
    <title>Farine & Potiron</title>
</head>
<body>

<!-- Header spécifique aux utilisateurs connectés -->
<?php include "templates/fragments/headerConnecter.php"; ?>

<main class="container my-5">

    <!-- Barre de boutons : Modifier (si auteur) et Retour -->
    <div class="mb-4 d-flex justify-content-between">
        <?php if ($utilisateur && $utilisateur->get("id") == $recette->get("auteur")): ?>
            <!-- Bouton modification visible uniquement pour l'auteur -->
            <a href="modifierRecette.php?id=<?= $recette->id() ?>" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Modifier
            </a>
        <?php else: ?>
            <!-- Div vide pour conserver l'espacement même sans bouton Modifier -->
            <div></div>
        <?php endif; ?>
        
        <!-- Bouton retour vers la liste des recettes de l'utilisateur -->
        <a href="afficherListeRecetteUtilisateur.php" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>

    <!-- Titre de la recette et auteur -->
    <div class="mb-3">
        <h1 class="display-5"><?= htmlspecialchars($recette->get("titre")) ?></h1>
        <p class="text-muted">Par <strong><?= htmlspecialchars($auteur->get("pseudo")) ?></strong></p>
    </div>

    <!-- Informations principales : durée, difficulté, date dernière mise à jour -->
    <div class="row mb-4">
        <div class="col-md-6">
            <p><i class="bi bi-clock"></i> <strong>Durée :</strong> <?= htmlspecialchars($recette->get("duree_preparation")) ?> min</p>
            <p><i class="bi bi-bar-chart"></i> <strong>Difficulté :</strong> <?= htmlspecialchars($difficulteTexte) ?></p>
            <p><i class="bi bi-calendar-plus"></i> <strong>Dernière mise à jour :</strong> 
                <?= htmlspecialchars(max($recette->get("date_crea"), $recette->get("date_modif"))) ?>
            </p>
        </div>
    </div>

    <!-- Liste des ingrédients avec quantités et descriptions -->
    <div class="mb-4">
        <h2 class="h4">Ingrédients</h2>
        <div class="ingredients-list">
            <?php foreach ($ingredients as $ing): ?>
                <div class="ingredient mb-2">
                    <p class="mb-0">
                        <?php if (!empty($ing['quantite'])): ?>
                            <strong><?= htmlspecialchars($ing['quantite']) ?></strong>
                        <?php endif; ?>
                        <?= htmlspecialchars($ing['nom']) ?>
                    </p>
                    <!-- Description farine si disponible -->
                    <?php if (!empty($ing['reference_farine'])): ?>
                        <p class="text-muted small mb-0">
                            <?= htmlspecialchars($farinesDesc[$ing['reference_farine']] ?? '') ?>
                        </p>
                    <?php endif; ?>
                    <?php if (!empty($ing['description_farine'])): ?>
                        <div class="text-muted small"><?= htmlspecialchars($ing['description_farine']) ?></div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Étapes de préparation -->
    <div class="mb-4">
        <h2 class="h4">Étapes de préparation</h2>
        <p><?= nl2br(htmlspecialchars($recette->get("description_detaillee"))) ?></p>
    </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>