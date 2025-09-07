<?php
// Template de fragment : menu de navigation affiché pour les utilisateurs connectés
// Rôle : Affiche le nom du site et les liens principaux
// Paramètres : $pageActive (ex : "accueil", "compte", "recettes")
?>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold text-primary" href="index.php">Farine & Potiron</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu"
                    aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMenu">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">

                    <?php
                    // Liens dynamiques selon la page active
                    $menuLinks = [];

                    // Accueil : jamais afficher lien vers la page actuelle
                    if ($pageActive !== "accueil") {
                        $menuLinks[] = ["label" => "Accueil", "href" => "index.php"];
                    }

                    // Mon compte : si on n'est pas sur le compte
                    if ($pageActive !== "compte") {
                        $menuLinks[] = ["label" => "Mon compte", "href" => "modifierCompte.php"];
                    }

                    // Mes recettes : si on n'est pas sur la liste des recettes
                    if ($pageActive !== "recette") {
                        $menuLinks[] = ["label" => "Mes recettes", "href" => "afficherListeRecetteUtilisateur.php"];
                    }

                    // Générer le menu
                    foreach ($menuLinks as $link) {
                        echo '<li class="nav-item">';
                        echo '<a class="nav-link" href="' . $link['href'] . '">' . $link['label'] . '</a>';
                        echo '</li>';
                    }
                    ?>

                    <li class="nav-item">
                        <a class="btn btn-outline-danger" href="deconnexion.php">Déconnexion</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>