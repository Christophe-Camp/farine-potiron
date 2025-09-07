<?php
// Template de page: Affichage des recettes de l'utilisateur
// Rôle : Lister les recettes que l'utilisateur a créées
// Paramètres : $recettes
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <title>Farine & Potiron</title>
</head>
<body>

<!-- Header pour utilisateurs non connectés -->
<?php include "templates/fragments/headerConnecter.php"; ?>

<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Mes recettes</h1>

        <!-- Bouton pour créer une nouvelle recette -->
        <a href="creerRecette.php" class="btn btn-success">
            <i class="bi bi-plus-circle me-1"></i> Créer une recette
        </a>
    </div>

    <!-- Message d'information s'il n'y a aucune recette -->
    <?php if (empty($recettes)): ?>
        <div class="alert alert-info">
            Vous n'avez créé aucune recette pour le moment.
        </div>
    <?php else: ?>
        <!-- Affichage des recettes sous forme de cards Bootstrap -->
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php foreach ($recettes as $recette): ?>
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <!-- Titre de la recette -->
                            <h5 class="card-title"><?= htmlspecialchars($recette['titre']) ?></h5>

                            <!-- Durée de préparation -->
                            <p class="card-text mb-1">
                                <i class="bi bi-clock"></i>
                                <strong>Durée :</strong> <?= $recette['duree_preparation'] ?> min
                            </p>

                            <!-- Difficulté -->
                            <p class="card-text mb-1">
                                <i class="bi bi-bar-chart"></i>
                                <strong>Difficulté :</strong> <?= $recette['difficulte'] ?>
                            </p>

                            <!-- Date de dernière modification -->
                            <p class="card-text">
                                <i class="bi bi-pencil"></i>
                                <strong>Modifiée le :</strong> <?= $recette['date_modification'] ?>
                            </p>
                        </div>

                        <!-- Bouton pour accéder à la page de la recette -->
                        <div class="card-footer bg-white text-end border-0">
                            <a href="afficherRecetteUtilisateur.php?id=<?= $recette['id'] ?>" class="btn btn-outline-primary btn-sm">
                                Voir la recette <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>