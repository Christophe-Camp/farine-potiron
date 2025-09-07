<?php
// Template de page: Créer un compte utilisateur
// Rôle : Affiche le formulaire d'inscription avec gestion des erreurs et intégration de reCAPTCHA v3
// Paramètres : $pseudo, $email
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
    <?php include "templates/fragments/headerNonConnecter.php"; ?>

    <div class="container mt-5" style="max-width: 500px;">
        <div class="card shadow-sm">
            <div class="card-body">
                <h3 class="card-title text-center mb-4">Créer un compte</h3>

                <!-- Affichage des erreurs s’il y en a -->
                <?php if (!empty($erreurs)): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach ($erreurs as $erreur): ?>
                                <li><?= htmlspecialchars($erreur) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- Formulaire d'inscription -->
                <form method="post" action="validInscription.php">
                    <!-- Champ Pseudo -->
                    <div class="mb-3">
                        <label for="pseudo" class="form-label">Pseudo *</label>
                        <input type="text" class="form-control" id="pseudo" name="pseudo" required
                               value="<?= htmlspecialchars($pseudo ?? '') ?>">
                    </div>

                    <!-- Champ Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email *</label>
                        <input type="email" class="form-control" id="email" name="email" required
                               value="<?= htmlspecialchars($email ?? '') ?>">
                    </div>

                    <!-- Champ Mot de passe -->
                    <div class="mb-3">
                        <label for="mot_de_passe" class="form-label">Mot de passe *</label>
                        <input type="password" class="form-control" id="mot_de_passe" name="mot_de_passe" required>
                    </div>

                    <!-- Champ Confirmation du mot de passe -->
                    <div class="mb-3">
                        <label for="confirm_mot_de_passe" class="form-label">Confirmer le mot de passe *</label>
                        <input type="password" class="form-control" id="confirm_mot_de_passe" name="confirm_mot_de_passe" required>
                    </div>

                    <!-- Champ caché pour le reCAPTCHA v3 -->
                    <input type="hidden" name="recaptcha_token" id="recaptcha_token">

                    <!-- Script Google reCAPTCHA v3 -->
                    <script src="https://www.google.com/recaptcha/api.js?render=6LePk7wrAAAAALcsIscEf7Em1NRItNuwwIM_jYUY"></script>
                    <script>
                        // Exécution du reCAPTCHA dès que la page est prête
                        grecaptcha.ready(function () {
                            grecaptcha.execute('6LePk7wrAAAAALcsIscEf7Em1NRItNuwwIM_jYUY', {action: 'inscription'})
                                .then(function (token) {
                                    document.getElementById('recaptcha_token').value = token;
                                });
                        });
                    </script>
                    <!-- Bouton de soumission -->
                    <div class="d-grid mt-3">
                        <button type="submit" class="btn btn-primary">Créer mon compte</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- JS Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>