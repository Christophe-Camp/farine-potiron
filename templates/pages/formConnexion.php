<?php
// Template de page: afficher le formulaire de connexion
// Rôle : Permet à un utilisateur d’entrer son pseudo ou son email et son mot de passe pour se connecter
// Paramètres: néant
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

    <!-- Header spécifique aux utilisateurs non connectés -->
    <?php include "templates/fragments/headerNonConnecter.php"; ?>

    <div class="container mt-5" style="max-width: 400px;">
        <div class="card shadow-sm">
            <div class="card-body">
                <h3 class="card-title text-center mb-4">Se connecter</h3>

                <!-- Zone d'affichage des erreurs si des paramètres GET sont passés -->
                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger text-center">
                        <?php
                            // Affiche un message d'erreur personnalisé selon le code d'erreur passé dans l'URL
                            switch ($_GET['error']) {
                                case 'champs_vides':
                                    echo "Veuillez remplir tous les champs.";
                                    break;
                                case 'mdp_incorrect':
                                    echo "Mot de passe incorrect.";
                                    break;
                                case 'not_found':
                                    echo "Aucun compte trouvé avec cet identifiant.";
                                    break;
                                default:
                                    echo "Une erreur est survenue. Veuillez réessayer.";
                            }
                        ?>
                    </div>
                <?php endif; ?>

                <!-- Formulaire de connexion -->
                <form method="post" action="validConnexion.php">
                    <div class="mb-3">
                        <label for="pseudo" class="form-label">Pseudo ou Email</label>
                        <input type="text" class="form-control" id="pseudo" name="pseudo" required>
                    </div>

                    <div class="mb-3">
                        <label for="mot_de_passe" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" id="mot_de_passe" name="mot_de_passe" placeholder="Votre mot de passe" required>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Se connecter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts JS Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>