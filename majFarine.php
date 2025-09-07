<?php
// Controleur (ne peut être utilisé que comme URL)
// Rôle: synchroniser les données de farines depuis l'API vers la base de données
// Paramètres: néant (appel direct du script sans paramètres GET/POST)

// Initialisations
include "library/init.php"; 

// URL de l'API du catalogue de farines
$urlCatalogue = "https://api.mywebecom.ovh/play/fep/catalogue.php";

// Récupération du contenu JSON à partir de l'URL
$json = file_get_contents($urlCatalogue);

// Décodage du JSON en tableau associatif
$catalogue = json_decode($json, true);

// Vérifie si les données ont été récupérées correctement
if (!$catalogue) {
    die("Impossible de récupérer les données depuis l'API catalogue.");
}

// Boucle sur chaque farine pour récupérer la desciption et les insérer dans la BDD
foreach ($catalogue as $reference => $libelle) {
    // URL pour les détails de la farine (description)
    $urlDetail = "https://api.mywebecom.ovh/play/fep/catalogue.php?ref=" . urlencode($reference);

    // Récupère les détails via l’API
    $jsonDetail = file_get_contents($urlDetail);
    $detail = json_decode($jsonDetail, true);

    // Récupération de la description, ou chaîne vide si non disponible
    $description = $detail['description'] ?? "";

    // Création d’un objet farine
    $f = new farine();
    $f->set("reference", $reference);
    $f->set("libelle", $libelle);
    $f->set("description", $description);

    // Enregistrement de la farine dans la base (insert ou update selon la logique de la méthode save)
    if ($f->save()) {
        echo "Sync OK : $reference - $libelle<br>";
    } else {
        echo "Erreur sync : $reference<br>";
    }
}

echo "<br>Synchronisation terminée.";