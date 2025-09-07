<?php
    // Template de fragment : menu de navigation affiché lorsque l'utilisateur n'est pas connecté
    // Rôle : Affiche un en-tête avec le nom du jeu et des boutons pour naviguer vers l'accueil, la connexion ou l'inscription
    // parmètres : néant
?>
<header>
    <!-- Barre de navigation Bootstrap -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">

            <!-- Logo ou nom du site, renvoie à la page d'accueil -->
            <a class="navbar-brand fw-bold text-primary" href="index.php">
                Farine & Potiron
            </a>

            <!-- Bouton pour afficher/cacher le menu sur petits écrans (mobile/tablette) -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu"
                    aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <!-- Menu principal -->
            <div class="collapse navbar-collapse" id="navbarMenu">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-outline-secondary me-2" href="connexion.php">Se connecter</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-outline-primary" href="inscription.php">S'inscrire</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>