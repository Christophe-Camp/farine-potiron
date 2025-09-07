<?php
// Template de page : Affichage détaillé d'une recette
// Rôle : Montrer les détails d'une recette, ses ingrédients, les étapes, les votes et les commentaires
// Paramètres : $recette, $auteur, $ingredients, $farinesDesc, $userVote ,$likes, $dislikes, $commentaires, $estConnecte, $utilisateur
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

<!-- Affichage du header selon état de connexion -->
<?php if ($estConnecte): ?>
    <?php include "templates/fragments/headerConnecter.php"; ?>
<?php else: ?>
    <?php include "templates/fragments/headerNonConnecter.php"; ?>
<?php endif; ?>

<main class="container my-5">

    <!-- Bouton retour vers l'accueil -->
    <div class="mb-3">
        <a href="index.php" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>

    <!-- Titre de la recette et auteur -->
    <div class="mb-4">
        <h1 class="display-5"><?= htmlspecialchars($recette->get("titre")) ?></h1>
        <p class="text-muted">Par <strong><?= htmlspecialchars($auteur->get("pseudo")) ?></strong></p>
    </div>

    <!-- Détails (durée, difficulté, date) -->
    <div class="row mb-4">
        <div class="col-md-6">
            <p><i class="bi bi-clock"></i> <strong>Durée :</strong> <?= htmlspecialchars($recette->get("duree_preparation")) ?> min</p>

            <?php 
            // Conversion numérique de la difficulté en texte lisible
            $difficulteTexte = $recette->convertirDifficulteEnTexte((int)$recette->get("difficulte"));
            ?>
            <p><i class="bi bi-bar-chart"></i> <strong>Difficulté :</strong> <?= $difficulteTexte ?></p>

            <p><i class="bi bi-calendar-event"></i> <strong>Dernière action :</strong> 
                <?= htmlspecialchars($recette->get("date_modif") ?: $recette->get("date_crea")) ?>
            </p>
        </div>
    </div>

    <!-- Liste des ingrédients -->
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
                    <!-- Description associée à la farine si présente -->
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

    <!-- Section votes -->
    <div class="mb-4">
        <h2 class="h4">Votes</h2>
        <p>
            <!-- Bouton like -->
            <button id="vote-like" 
                    class="me-3 btn btn-outline-success <?= $userVote === 1 ? 'active-like' : '' ?>" 
                    <?= $estConnecte ? '' : 'disabled' ?>>
                <i class="bi bi-hand-thumbs-up"></i> 
                <span id="like-count"><?= $likes ?></span>
            </button>

            <!-- Bouton dislike -->
            <button id="vote-dislike" 
                    class="btn btn-outline-danger <?= $userVote === -1 ? 'active-dislike' : '' ?>" 
                    <?= $estConnecte ? '' : 'disabled' ?>>
                <i class="bi bi-hand-thumbs-down"></i> 
                <span id="dislike-count"><?= $dislikes ?></span>
            </button>
        </p>
    </div>

    <!-- Section commentaires -->
    <div class="mb-5">
        <h2 class="h4">Commentaires</h2>
        <?php if (!empty($commentaires)): ?>
            <div class="list-group">
                <?php foreach ($commentaires as $com): ?>
                    <div class="list-group-item" data-id="<?= $com['id'] ?>">
                        <p class="mb-1">
                            <strong><?= htmlspecialchars($com['pseudo']) ?></strong>
                            <span class="text-muted small"> (<?= htmlspecialchars($com['date_crea']) ?>)</span>
                        </p>
                        <p class="mb-0 commentaire-texte"><?= nl2br(htmlspecialchars($com['commentaire_recette'])) ?></p>

                        <!-- Bouton modifier visible uniquement pour l'auteur connecté -->
                        <?php if ($estConnecte && $utilisateur && $utilisateur->get("id") == $com['auteur']): ?>
                            <button class="btn btn-sm btn-outline-warning modifier-commentaire">✏️ Modifier</button>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-muted">Aucun commentaire pour cette recette.</p>
        <?php endif; ?>
    </div>

    <!-- Formulaire pour ajouter un commentaire si connecté -->
    <?php if ($estConnecte): ?>
        <div class="card mt-3">
            <div class="card-body">
                <h5 class="card-title">Ajouter un commentaire</h5>
                <textarea id="commentaireTexte" class="form-control mb-2" rows="3" placeholder="Votre commentaire..."></textarea>
                <button id="envoyerCommentaire" class="btn btn-primary">Publier</button>
            </div>
        </div>
    <?php endif; ?>
</main>
<!-- Passage de l'ID recette au JS -->
<script>
    const RECETTE_ID = <?= $recette->id() ?>;
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/javascript/script.js"></script>
</body>
</html>