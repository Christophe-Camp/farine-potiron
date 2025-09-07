<?php
// Template de page : formulaire de modification d'une recette
// Rôle : Afficher un formulaire permettant à l'utilisateur de modifier une recette existante
// Paramètres : $recette, $farines, $ingredients, $farinesDesc
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Farine & Potiron</title>
</head>
<body>
    <!-- Header pour utilisateurs non connectés -->
    <?php include "templates/fragments/headerConnecter.php"; ?>

    <div class="container my-5">
        <h1 class="mb-4">Modifier la recette</h1>

        <a href="afficherListeRecetteUtilisateur.php" class="btn btn-outline-secondary mb-3">
            Retour
        </a>

        <form method="post" action="enregistreModification.php" class="card p-4 shadow" id="formRecette">
            <input type="hidden" name="id" value="<?= $recette->id() ?>">

            <!-- Titre -->
            <div class="mb-3">
                <label for="titre" class="form-label">Titre</label>
                <input type="text" name="titre" id="titre" class="form-control"
                       value="<?= htmlspecialchars($recette->get("titre")) ?>" required>
            </div>

            <!-- Durée -->
            <div class="mb-3">
                <label for="duree_preparation" class="form-label">Temps de préparation (minutes)</label>
                <input type="number" name="duree_preparation" id="duree_preparation" class="form-control"
                       value="<?= htmlspecialchars($recette->get("duree_preparation")) ?>" required>
            </div>

            <!-- Difficulté -->
            <div class="mb-3">
                <label for="difficulte" class="form-label">Difficulté</label>
                <select name="difficulte" id="difficulte" class="form-select" required>
                    <?php for ($val = 1; $val <= 3; $val++): ?>
                        <option value="<?= $val ?>" <?= $recette->get("difficulte") == $val ? "selected" : "" ?>>
                            <?= $recette->convertirDifficulteEnTexte($val) ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </div>

            <!-- Farines -->
            <div class="mb-3" id="containerFarines">
                <label class="form-label">Farine(s) utilisée(s)</label>

                <?php foreach ($ingredients as $ing): ?>
                    <?php if ($ing["est_farine"]): ?>
                        <div class="input-group mb-2 farineLigne">
                            <select name="farine[]" class="form-select selectFarine" required>
                                <option value="">Choisir une farine</option>
                                <?php foreach ($farines as $ref => $libelle): ?>
                                    <option value="<?= htmlspecialchars($ref) ?>"
                                            data-description="<?= htmlspecialchars($farinesDesc[$ref]) ?>"
                                            <?= $ref === $ing["reference_farine"] ? "selected" : "" ?>>
                                        <?= htmlspecialchars($libelle) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <input type="text" name="quantite_farine[]" class="form-control"
                                   placeholder="Quantité (ex: 200g)"
                                   value="<?= htmlspecialchars($ing["quantite"]) ?>" required>
                            <button type="button" class="btn btn-outline-danger btn-sm supprimerFarine">&times;</button>
                        </div>
                        <div class="mb-2 farineDescription">
                            <?= htmlspecialchars($farinesDesc[$ing["nom"]] ?? "") ?>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>

                <!-- Bouton ajouter -->
                <button type="button" class="btn btn-sm btn-outline-secondary" id="ajouterFarine">
                    Ajouter une autre farine
                </button>
            </div>

            <!-- Ingrédients -->
            <div class="mb-3" id="containerIngredients">
                <label class="form-label">Liste des ingrédients</label>
                <!-- Ligne d'en-tête -->
                <div class="input-group mb-1">
                    <span class="form-control bg-light fw-bold border-end-0" style="pointer-events: none;">Quantité</span>
                    <span class="form-control bg-light fw-bold border-start-0" style="pointer-events: none;">Ingrédient</span>
                    <span class="btn btn-sm invisible"></span> <!-- Pour aligner avec le bouton suppression -->
                </div>
                <?php foreach ($ingredients as $ing): ?>
                    <?php if (!$ing["est_farine"]): ?>
                        <div class="input-group mb-2 ingredientLigne">
                            <input type="text" name="ingredient_quantite[]" class="form-control"
                                   placeholder="Quantité (ex: 100g)"
                                   value="<?= htmlspecialchars($ing["quantite"]) ?>">
                            <input type="text" name="ingredient_nom[]" class="form-control"
                                   placeholder="Nom de l'ingrédient"
                                   value="<?= htmlspecialchars($ing["nom"]) ?>" required>
                            <button type="button" class="btn btn-outline-danger btn-sm supprimerIngredient">&times;</button>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>

                <button type="button" class="btn btn-sm btn-outline-secondary" id="ajouterIngredient">
                    Ajouter un ingrédient
                </button>
            </div>

            <!-- Description -->
            <div class="mb-3">
                <label for="description_detaillee" class="form-label">Préparation</label>
                <textarea name="description_detaillee" id="description_detaillee"
                          class="form-control" rows="6" required><?= htmlspecialchars($recette->get("description_detaillee")) ?></textarea>
            </div>

            <!-- Bouton submit -->
            <div class="d-grid">
                <button type="submit" class="btn btn-success">Enregistrer les modifications</button>
            </div>
        </form>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="javascript/script.js"></script>
</body>
</html>