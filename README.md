# 🥖 Gestion de Recettes de Boulangerie

Ce projet est une application PHP permettant de gérer des **recettes** avec :
- Ingrédients (farines + autres ingrédients)
- Commentaires
- Votes (like/dislike)
- Gestion des utilisateurs (inscription, connexion, déconnexion)

## 📂 Structure du projet

├── css/
│   └── styles.css              # Feuille de style principale
├── document/                   # Répertoire réservé aux documents 
├── javascript/
│   └── script.js               # Script JavaScript principal
├── library/
│   ├── bdd.php                 # Connexion à la base de données
│   ├── init.php                # Initialisation du projet
│   ├── session.php             # Gestion des sessions
│
│   └── modele/                 # Modèles de données (backend)
│       ├── _model.php
│       ├── commentaire.php
│       ├── farine.php
│       ├── ingredient.php
│       ├── note.php
│       ├── recette.php
│       └── utilisateur.php
│
├── fragments/                 # Composants réutilisables
│   ├── headerConnecter.php     # Header pour utilisateurs connectés
│   └── headerNonConnecter.php # Header pour utilisateurs non connectés
│
├── pages/                     # Pages principales de l'application
│   ├── accueil.php
│   ├── formCompte.php
│   ├── formConnexion.php
│   ├── formCreaRecette.php
│   ├── formInscription.php
│   ├── formModifierRecette.php
│   ├── listeRecetteUtilisateur.php
│   ├── recette.php
│   ├── recetteUtilisateur.php
│   ├── afficherListeRecetteUtilisateur.php
│   ├── afficherRecette.php
│   ├── afficherRecetteUtilisateur.php
│   ├── chercherAjax.php
│   ├── commentaireAjax.php
│   ├── connexion.php
│   ├── creerRecette.php
│   ├── deconnexion.php
│   ├── enregistreModification.php
│   ├── enregistreRecette.php
│   ├── index.php               # Page d'accueil par défaut
│   ├── inscription.php
│   ├── majFarine.php
│   ├── modifierCompte.php
│   ├── modifierRecette.php
│   ├── validConnexion.php
│   ├── validInscription.php
│   ├── validModifCompte.php
│   └── voteAjax.php
│
├── fep-chca.sql                # Script SQL de la base de données
├── README.md                   # Fichier de documentation (ce fichier)

## ⚙️ Installation

1. **Cloner le projet** :
git clone https://github.com/Christophe-Camp/farine-potiron.git
cd farine-potiron

2. Configurer la base de données
Crée une base de données MySQL.
Importe le fichier fep-chca.sql (présent dans le projet) pour générer les tables et les données.
Exemple avec MySQL en ligne de commande :
mysql -u root -p

Puis dans le terminal MySQL :
CREATE DATABASE recettes_boulangerie;
USE recettes_boulangerie;
SOURCE fep-chca.sql;

3. Configurer la connexion à la base de données
Ouvre le fichier library/init.php et modifie les paramètres de connexion si nécessaire :
$bdd = new PDO("mysql:host=localhost;dbname=recettes_boulangerie;charset=utf8", "root", "");
Adapte "root" et le mot de passe selon ta configuration locale.

4. Lancer un serveur local
Depuis le dossier du projet :
php -S localhost:8000

5. Accéder à l'application
Ouvre ton navigateur à l’adresse suivante :
👉 http://localhost:8000

👥 Gestion des utilisateurs
Inscription : formulaire (formInscription.php) avec pseudo, email, mot de passe, reCAPTCHA.
Connexion : vérification avec mot de passe hashé.
Déconnexion : suppression de la session.
Les utilisateurs doivent être connectés pour :
Ajouter / modifier une recette
Commenter une recette
Voter (like/dislike)

📑 Fonctionnalités principales
 Recettes
Ajout, modification, suppression par l’auteur
Association de farines et ingrédients
Affichage avec auteur, durée, difficulté

 Ingrédients
Gestion des farines (référencées en base)
Gestion d’ingrédients libres (nom + quantité)

 Commentaires
Ajout, modification, suppression par l’auteur
Affichage avec pseudo + date

 Votes
Like / dislike
Mise à jour dynamique via AJAX
Comptage total + vote de l’utilisateur

🛠️ Technologies utilisées
PHP 8+
MySQL
HTML / CSS (Bootstrap)
JavaScript (fetch API, AJAX)
PDO pour les requêtes SQL
Sessions pour l’authentification

📌 Organisation du code
Contrôleurs : fichiers dans public/, reçoivent les requêtes (ex: ajouterCommentaire.php, voteAjax.php)
Modèles (classes) : gèrent la base de données (recette.php, ingredient.php, farine.php, note.php, utilisateur.php, commentaire.php)
Templates : affichage HTML (ex: formModifierRecette.php)

🚀 Améliorations possibles
Système de pagination pour les recettes
Upload de photos pour les recettes
API REST pour mobile
Gestion des rôles (admin / utilisateur)