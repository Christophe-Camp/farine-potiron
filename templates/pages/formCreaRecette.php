<?php
// Template de page: formulaire de création d'une recette
// Rôle : afficher un formulaire permettant à l'utilisateur de créer une recette
// Paramètres: $listeFarines (tableau des farines disponibles)
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Farine & Potiron</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
    <?php include "templates/fragments/headerConnecter.php"; // Barre de navigation du site ?>

    <div class="container my-5">
        <h1 class="mb-4">Créer une nouvelle recette</h1>

        <!-- Bouton de retour à la liste de ses recettes -->
        <a href="afficherListeRecetteUtilisateur.php" class="btn btn-outline-secondary">
            Retour
        </a>

        <!-- Formulaire principal de création de recette -->
        <form method="post" action="enregistreRecette.php" class="card p-4 shadow" id="formRecette">

            <!-- Titre de la recette -->
            <div class="mb-3">
                <label for="titre" class="form-label">Titre</label>
                <input type="text" name="titre" id="titre" class="form-control" required>
            </div>

            <!-- Durée estimée de préparation -->
            <div class="mb-3">
                <label for="duree_preparation" class="form-label">Temps de préparation (minutes)</label>
                <input type="number" name="duree_preparation" id="duree_preparation" class="form-control" required>
            </div>

            <!-- Difficulté choisie par l'utilisateur -->
            <div class="mb-3">
                <label for="difficulte" class="form-label">Difficulté</label>
                <select name="difficulte" id="difficulte" class="form-select" required>
                    <option value="tresFacile">Très facile</option>
                    <option value="facile">Facile</option>
                    <option value="difficile">Difficile</option>
                </select>
            </div>

            <!-- Section pour sélectionner une ou plusieurs farines avec leur quantité -->
            <div class="mb-3" id="containerFarines">
                <label class="form-label">Farine utilisée</label>

                <div class="input-group mb-2 farineLigne">
                    <select name="farine[]" class="form-select selectFarine" required>
                        <option value="">Choisir une farine</option>
                        <?php foreach ($listeFarines as $f): ?>
                            <option value="<?= htmlspecialchars($f['reference']) ?>"
                                    data-description="<?= htmlspecialchars($f['description']) ?>">
                                <?= htmlspecialchars($f['libelle']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <input type="text" name="quantite_farine[]" class="form-control" placeholder="Quantité (ex: 200g)" required>
                    <button type="button" class="btn btn-outline-danger btn-sm supprimerFarine">&times;</button>
                </div>

                <!-- Affichage dynamique de la description de la farine sélectionnée -->
                <div class="mb-2 farineDescription"></div>

                <!-- Bouton pour ajouter une autre farine -->
                <button type="button" class="btn btn-sm btn-outline-secondary" id="ajouterFarine">Ajouter une autre farine</button>
            </div>
            

            <!-- Ingrédients supplémentaires (autres que les farines) -->
            <div class="mb-3" id="containerIngredients">
                <label class="form-label">Listes des ingrédients</label>
                <!-- Ligne d'en-tête -->
                <div class="input-group mb-1">
                    <span class="form-control bg-light fw-bold border-end-0" style="pointer-events: none;">Quantité</span>
                    <span class="form-control bg-light fw-bold border-start-0" style="pointer-events: none;">Ingrédient</span>
                    <span class="btn btn-sm invisible"></span> <!-- Pour aligner avec le bouton suppression -->
                </div>
                <div class="input-group mb-2 ingredientLigne">
                    <input type="text" name="ingredient_quantite[]" class="form-control" placeholder="Quantité (ex: 100g)">
                    <input type="text" name="ingredient_nom[]" class="form-control" placeholder="Nom de l'ingrédient" required>
                    <button type="button" class="btn btn-outline-danger btn-sm supprimerIngredient">&times;</button>
                </div>
                <button type="button" class="btn btn-sm btn-outline-secondary" id="ajouterIngredient">Ajouter un ingrédient</button>
            </div>

            <!-- Description complète de la recette -->
            <div class="mb-3">
                <label for="description_detaillee" class="form-label">Préparation</label>
                <textarea name="description_detaillee" id="description_detaillee" class="form-control" rows="6" required></textarea>
            </div>

            <!-- Bouton d'envoi -->
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Créer la recette</button>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS et script personnalisé -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="javascript/script.js"></script>
    </body>
</html>