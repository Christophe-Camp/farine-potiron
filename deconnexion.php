<?php
// Controleur (ne peut être utilisé que comme URL)
// Rôle: Mettre fin à la session de l'utilisateur (déconnexion) et afficher le formulaire de connexion
// Paramètres: néant (aucune donnée transmise via GET ou POST)

// Chargement des fichiers d'initialisation
include "library/init.php";

// Appel à la fonction de déconnexion (suppression des données de session)
deconnecter();

// Affiche à nouveau le formulaire de connexion après la déconnexion
include "templates/pages/formConnexion.php";