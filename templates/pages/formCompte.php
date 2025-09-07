<?php
// Template de page: formulaire pour modifier son profil
// Rôle : Permet à l'utilisateur connecté de modifier ses informations (pseudo, email, mot de passe)
// Paramètres: $utilisateur (objet utilisateur connecté)
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" media="screen" href="css/styles.css" type="text/css">
    <title>Farine & Potiron</title>
</head>
<body>

    <!-- Header pour utilisateur connecté -->
    <?php include "templates/fragments/headerConnecter.php"; ?>

    <div class="container my-5">
        <h1 class="mb-4">Mon Profil</h1>
        
        <?php if (isset($_GET["error"]) && $_GET["error"] === "mdpCourt"): ?>
            <div class="alert alert-danger">
                Le mot de passe doit contenir au moins 8 caractères.
            </div>
        <?php endif; ?>

        <!-- Formulaire d'édition du compte utilisateur -->
        <form method="post" action="validModifCompte.php" enctype="multipart/form-data" class="card p-4 shadow">
            
            <!-- Champ pseudo pré-rempli avec la valeur actuelle -->
            <div class="mb-3">
                <label for="pseudo" class="form-label">Pseudo</label>
                <input type="text" name="pseudo" id="pseudo" class="form-control" required 
                       value="<?= htmlspecialchars($utilisateur->get('pseudo')) ?>">
            </div>

            <!-- Champ email pré-rempli avec la valeur actuelle -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" required 
                       value="<?= htmlspecialchars($utilisateur->get('email')) ?>">
            </div>

            <!-- Champ mot de passe (non requis si vide → le mot de passe actuel est conservé) -->
            <div class="mb-3">
                <label for="mot_de_passe" class="form-label">Mot de passe</label>
                <input type="password" name="mot_de_passe" id="mot_de_passe" class="form-control">
            </div>

            <!-- Bouton pour valider les modifications -->
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>