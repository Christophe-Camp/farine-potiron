<?php
// Template de page: Accueil avec les dernières recettes
// Rôle : Affiche les dernières recettes sous forme de cards Bootstrap avec options de recherche et filtrage
// Paramètres : $estConnecte, $recettes, $farines 
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../css/styles.css">
    <title>Farine & Potiron</title>
</head>
<body>

    <!-- Header selon l'état de connexion -->
    <?php if ($estConnecte): ?>
        <?php include "templates/fragments/headerConnecter.php"; ?>
    <?php else: ?>
        <?php include "templates/fragments/headerNonConnecter.php"; ?>
    <?php endif; ?>

    <main class="container my-5">
        <!-- Titre principal -->
        <h2 class="mb-4">Recettes</h2>
        <!-- Barre de recherche + filtre farine -->
        <div class="row mb-4">
            <div class="col-md-8">
                <!-- Champ texte pour rechercher une recette -->
                <input type="text" id="champRecherche" class="form-control" placeholder="Rechercher une recette...">
            </div>
            <div class="col-md-3">
                <!-- Liste déroulante pour filtrer par type de farine -->
                <select id="filtreFarine" class="form-select">
                    <option value="">-- Toutes les farines --</option>
                    <?php foreach ($farines as $f): ?>
                        <option value="<?= htmlspecialchars($f['reference']) ?>">
                            <?= htmlspecialchars($f['libelle']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-1">
                <!-- Bouton de recherche -->
                <button id="boutonRecherche" class="btn btn-outline-secondary">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </div>

        <!-- Liste des recettes (affichées en cartes responsives Bootstrap) -->
        <div id="listeRecettes" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php foreach ($recettes as $recette): ?>
                <div class="col">
                    <!-- Chaque carte est un lien vers la page de détails de la recette -->
                    <a href="afficherRecette.php?id=<?= $recette['id'] ?>" class="text-decoration-none text-dark">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <!-- Titre de la recette -->
                                <h5 class="card-title"><?= htmlspecialchars($recette['titre']) ?></h5>
                                
                                <!-- Infos auteur, durée, difficulté, date -->
                                <p class="card-text mb-1"><i class="bi bi-person"></i> <?= htmlspecialchars($recette['pseudo']) ?></p>
                                <p class="card-text mb-1"><i class="bi bi-clock"></i> <?= $recette['duree_preparation'] ?> min</p>
                                <p class="card-text mb-1"><i class="bi bi-bar-chart"></i> Difficulté: 
                                    <?= (new recette())->convertirDifficulteEnTexte((int)$recette['difficulte']) ?>
                                </p>
                                <p class="card-text"><i class="bi bi-calendar-event"></i> <?= $recette['date_modification'] ?></p>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
    <!-- Scripts JS Bootstrap + script personnalisé -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/javascript/script.js"></script>
</body>
</html>