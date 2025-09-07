<?php

// Initialisations communes a tous les controleurs

// Mettre en place les messages d'erreurs 
    ini_set('display_errors',1);
    error_reporting(E_ALL);

// Initialiser / récupere les infos de la session 
session_start();

// Charger les librairies
include "library/bdd.php";
include "library/session.php";
//majDerniereActivite();

// Charger les différentes classes de modèle de données
include "modele/_model.php";
include "modele/commentaire.php";
include "modele/ingredient.php";
include "modele/note.php";
include "modele/recette.php";
include "modele/utilisateur.php";
include "modele/farine.php";

// Ouvrir la BDD dans une variable globale $bdd
global $bdd;
    $bdd = new PDO("mysql:host=172.18.0.1;dbname=fep-chca;charset=UTF8","fep-chca","Y!55iwlxq");

    // Pour la mise au point, on peut ajouter un affichage des erreurs MySQL
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);