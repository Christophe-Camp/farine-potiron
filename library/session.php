<?php
// librairie: fonction de gestion de la session utililsateur

    // Connecter un utilisateur: connecter
    // savoir si un utilisateur est connecté:
    // Recupére l'utilisateur connecté:
    // Deconnecter un utilisateur connecté: deconnecter
    // Vérifier les codes de connexion:
    
    function connecter($utilisateur) {
        $_SESSION['utilisateur'] = [
            'id' => $utilisateur->id(), // Méthode qui retourne l'id
            'activ' => true,
            'last_activity' => time()
        ];
    }
    
    function connexionActive($timeout = 3600) {
        if (!isset($_SESSION['utilisateur']) || !$_SESSION['utilisateur']['activ']) return false;
        if (time() - $_SESSION['utilisateur']['last_activity'] > $timeout) {
            deconnecter();
            return false;
        }
        // Mettre à jour le temps de la dernière activité
        $_SESSION['utilisateur']['last_activity'] = time();
        return true;
    }

    function utilisateurConnecte() {
        if (connexionActive()){
            return new utilisateur($_SESSION['utilisateur']['id']);
        }
        return new utilisateur();
        //return false; // ne retourne PAS un personnage vide !
    }

    function deconnecter() {
        unset($_SESSION['utilisateur']);
    }

    function verifierIdentifiants($pseudo, $mot_de_passe) {
        $utilisateur = new utilisateur();
        if (!$utilisateur->loadByPseudo($pseudo)) {
            return false;
        }

        // Vérification du mot de passe hashé 
        if (password_verify($mot_de_passe, $utilisateur->get("mot_de_passe"))) {
            return $utilisateur;
        }

        return false;
    }
    
    function mettreAJourUtilisateurEnSession($utilisateur) {
        if (!isset($_SESSION['utilisateur'])) {
            connecter($utilisateur);
            return;
        }

        $_SESSION['utilisateur'] = array_merge($_SESSION['utilisateur'], [
            'id' => $utilisateur->id(),
            // garder activ et last_activity existants
        ]);
    }