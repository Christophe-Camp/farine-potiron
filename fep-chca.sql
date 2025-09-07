-- phpMyAdmin SQL Dump
-- version 5.2.1deb1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : dim. 07 sep. 2025 à 19:43
-- Version du serveur : 10.11.6-MariaDB-0+deb12u1
-- Version de PHP : 8.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `fep-chca`
--

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

CREATE TABLE `commentaire` (
  `id` int(11) NOT NULL,
  `recette` int(11) NOT NULL,
  `auteur` int(11) NOT NULL,
  `commentaire_recette` text NOT NULL,
  `date_crea` datetime NOT NULL,
  `date_modif` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `commentaire`
--

INSERT INTO `commentaire` (`id`, `recette`, `auteur`, `commentaire_recette`, `date_crea`, `date_modif`) VALUES
(1, 1, 2, 'Délicieux ! J’ai remplacé le sucre par du sirop d’érable.', '2025-09-07 18:28:38', '2025-09-07 18:28:38'),
(2, 2, 3, 'Très original, j’adore la touche coco.', '2025-09-07 18:39:31', '2025-09-07 18:39:31');

-- --------------------------------------------------------

--
-- Structure de la table `farine`
--

CREATE TABLE `farine` (
  `reference` varchar(255) NOT NULL,
  `libelle` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `farine`
--

INSERT INTO `farine` (`reference`, `libelle`, `description`) VALUES
('FEP-AMAN', 'Farine d’amande douce', 'Naturellement sans gluten et riche en bons lipides, cette farine donne un goût suave aux pâtisseries. Idéale pour macarons, financiers et cakes moelleux, elle permet aussi de remplacer partiellement la farine de blé dans les gâteaux classiques.'),
('FEP-CACT', 'Farine de cactus du désert', 'Obtenue à partir de cactus séchés et réduits en poudre, cette farine a une texture fine et un goût légèrement acidulé. Elle est riche en fibres et surprend agréablement dans les tortillas et les crackers. Un vrai voyage culinaire.'),
('FEP-CARA', 'Farine de caroube chocolatée', 'Substitut naturel au cacao, la caroube est sucrée et parfumée. Sa farine permet de réduire le sucre dans les gâteaux tout en gardant une saveur proche du chocolat. On l’utilise dans des biscuits, muffins ou boissons gourmandes.'),
('FEP-CHATA', 'Farine de châtaigne ardéchoise', 'Une farine rustique et parfumée, produite à partir de châtaignes séchées au feu de bois. Elle dégage des arômes boisés et sucrés qui subliment crêpes, gâteaux et pains spéciaux. Associée à de la farine de blé, elle donne une pâte douce et moelleuse.'),
('FEP-COCO', 'Farine de coco exotique', 'Obtenue à partir de chair de noix de coco séchée, elle est très riche en fibres. Son parfum intense apporte une touche tropicale aux desserts, smoothies et pains sucrés. À utiliser en mélange pour éviter une texture trop dense.'),
('FEP-COLR', 'Farine multicolore arc-en-ciel', 'Un mélange fantaisie de blé, maïs et betterave, qui offre des teintes surprenantes et un rendu visuel unique dans vos pains et pâtes. Parfaite pour surprendre vos invités et ajouter une touche ludique en cuisine.'),
('FEP-HAVR', 'Farine d’avoine du matin', 'Douce et légèrement sucrée, elle se prête très bien aux préparations de petit-déjeuner comme les pancakes, les muffins ou les barres énergétiques. Son goût délicat en fait aussi une base saine pour épaissir des soupes.'),
('FEP-LENT', 'Farine de lentilles corail', 'D’une belle couleur saumonée, cette farine riche en protéines végétales est parfaite pour des galettes salées, des crêpes originales ou encore pour enrichir les soupes. Elle surprend par sa saveur douce et légèrement sucrée.'),
('FEP-MAIZ', 'Farine de maïs ensoleillée', 'Jaune éclatant, elle rappelle immédiatement le soleil des champs d’été. Elle ne contient pas de gluten, ce qui en fait une alliée pour épaissir des sauces ou préparer des galettes. En pâtisserie, elle apporte une texture moelleuse et une couleur lumineuse.'),
('FEP-NOIR', 'Farine de sarrasin bretonne', 'Incontournable pour réaliser les galettes bretonnes, elle possède un goût franc et légèrement amer. Sans gluten, elle se marie parfaitement avec des préparations salées comme les crêpes garnies de fromage et de jambon.'),
('FEP-NUTL', 'Farine noisette câline', 'Douce et gourmande, cette farine apportera une note subtilement grillée à toutes vos pâtisseries. On l’adore dans les cookies, les muffins et les pâtes sablées. Elle peut être associée à d’autres farines pour un résultat encore plus moelleux.'),
('FEP-ORGE', 'Farine d’orge maltée', 'Légèrement sucrée et parfumée, elle est utilisée depuis des siècles dans la confection de pains et de bières. Elle donne une belle couleur dorée et une mie moelleuse aux pains spéciaux.'),
('FEP-POIS', 'Farine de pois chiche méditerranéenne', 'Utilisée dans de nombreuses cuisines traditionnelles (socca, panisses, falafels), elle apporte une saveur typée et une texture moelleuse. Riche en fibres et protéines, elle est idéale pour des recettes végétariennes et véganes.'),
('FEP-POTI', 'Farine de potiron magique', 'Une farine originale, riche en fibres et en bêta-carotène, qui colore vos préparations d’un orange éclatant. Son goût légèrement sucré en fait un ingrédient de choix pour les pains d’automne, les cakes et même les pâtes fraîches.'),
('FEP-QUIN', 'Farine de quinoa royal', 'Issue du quinoa des hauts plateaux andins, cette farine sans gluten est riche en protéines végétales et en minéraux. Sa saveur délicate et légèrement noisettée permet de varier l’alimentation, notamment dans les biscuits ou les pâtes à tarte.'),
('FEP-RIZB', 'Farine de riz blanc soyeux', 'Issue de riz poli finement, cette farine sans gluten est très digeste. Elle est parfaite pour épaissir des sauces, réaliser des gâteaux légers ou des tempuras croustillants. Sa texture soyeuse lui permet aussi d’alléger les pâtes à crêpes.'),
('FEP-RIZC', 'Farine de riz complet rustique', 'Plus riche en fibres et minéraux que la version blanche, elle apporte une note légèrement noisettée aux préparations. Elle se marie très bien avec des pains spéciaux et des biscuits diététiques.'),
('FEP-SORG', 'Farine de sorgho doré', 'Céréale sans gluten encore méconnue, le sorgho apporte une saveur douce et légèrement sucrée. Sa farine est idéale pour varier les préparations salées et sucrées, et s’associe parfaitement avec du maïs ou du riz.'),
('FEP-SPOK', 'Farine de l’espace (édition Spock)', 'Une farine verte enrichie en spiruline, pensée pour les explorateurs culinaires et les amateurs de science-fiction. Elle colore vos préparations d’une teinte inhabituelle et apporte une bonne dose de protéines et de minéraux. « Logique », comme dirait Monsieur Spock.');

-- --------------------------------------------------------

--
-- Structure de la table `ingredient`
--

CREATE TABLE `ingredient` (
  `id` int(11) NOT NULL,
  `recette` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `quantite` varchar(100) NOT NULL,
  `reference_farine` varchar(255) DEFAULT NULL,
  `est_farine` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `ingredient`
--

INSERT INTO `ingredient` (`id`, `recette`, `nom`, `quantite`, `reference_farine`, `est_farine`) VALUES
(1, 1, 'FEP-CHATA', '150 g', 'FEP-CHATA', 1),
(2, 1, 'Sucre roux', '100g', NULL, 0),
(3, 1, 'Beurre', '100g', NULL, 0),
(4, 1, 'œufs', '2', NULL, 0),
(8, 2, '', '100g', 'FEP-COCO', 1),
(9, 2, 'œufs', '2', NULL, 0),
(10, 2, 'sachet Sucre vanillé', '1', NULL, 0),
(11, 2, 'lait de coco', '250ml', NULL, 0),
(12, 3, 'FEP-QUIN', '100g', 'FEP-QUIN', 1),
(13, 3, 'FEP-RIZC', '150 g', 'FEP-RIZC', 1),
(14, 3, 'sachet Levure boulangère', '1', NULL, 0),
(15, 3, 'Eau tiède', '200ml', NULL, 0),
(16, 3, 'pincée Sel', '1', NULL, 0),
(17, 4, 'FEP-LENT', '120g', 'FEP-LENT', 1),
(18, 4, 'fécule de maïs (ou arrow-root)', '30g', NULL, 0),
(19, 4, 'sachet de levure chimique sans gluten', '1', NULL, 0),
(20, 4, 'c. à café de sel', '1', NULL, 0),
(21, 4, 'c. à café de curcuma (facultatif, pour la couleur et les bienfaits)', '1/2', NULL, 0),
(22, 4, 'c. à soupe de graines de cumin ou de tournesol (facultatif)', '1', NULL, 0),
(23, 4, 'c. à soupe d’huile d’olive', '2', NULL, 0),
(24, 4, 'lait végétal (ou eau)', '200ml', NULL, 0),
(25, 4, 'c. à soupe de vinaigre de cidre (pour aider à lever)', '1', NULL, 0),
(26, 4, 'Optionnel : petits dés de légumes (poivron, oignon, courgette), olives, herbes fraîches…', '', NULL, 0),
(27, 5, 'FEP-COCO', '40g', 'FEP-COCO', 1),
(28, 5, 'bananes bien mûres', '2', NULL, 0),
(29, 5, 'œufs', '2', NULL, 0),
(30, 5, 'cuillères à soupe de miel ou sirop d’érable', '2', NULL, 0),
(31, 5, 'cuillère à café de levure chimique', '1', NULL, 0),
(32, 5, 'pincée de sel', '1', NULL, 0),
(33, 5, 'cuillère à café d’extrait de vanille (facultatif)', '1', NULL, 0),
(34, 5, 'cuillère à soupe d’huile de coco fondue (ou beurre fondu)', '1', NULL, 0),
(35, 5, '(Optionnel) pépites de chocolat', '', NULL, 0),
(36, 5, 'noix de coco râpée ou noix pour garnir', '', NULL, 0),
(44, 6, '', '100g', 'FEP-CACT', 1),
(45, 6, '', '50g', 'FEP-RIZB', 1),
(46, 6, 'c. à café de sel', '1/2', NULL, 0),
(47, 6, 'c. à soupe d’huile d’olive', '1', NULL, 0),
(48, 6, 'd’eau tiède (à ajuster selon texture)', '120ml', NULL, 0);

-- --------------------------------------------------------

--
-- Structure de la table `note`
--

CREATE TABLE `note` (
  `id` int(11) NOT NULL,
  `auteur` int(11) NOT NULL,
  `recette` int(11) NOT NULL,
  `aime` tinyint(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `note`
--

INSERT INTO `note` (`id`, `auteur`, `recette`, `aime`) VALUES
(1, 2, 1, 1),
(2, 3, 2, 1),
(3, 3, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `recette`
--

CREATE TABLE `recette` (
  `id` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `description_detaillee` text NOT NULL,
  `duree_preparation` int(11) NOT NULL,
  `difficulte` int(11) NOT NULL,
  `auteur` int(11) NOT NULL,
  `date_crea` datetime NOT NULL,
  `date_modif` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `recette`
--

INSERT INTO `recette` (`id`, `titre`, `description_detaillee`, `duree_preparation`, `difficulte`, `auteur`, `date_crea`, `date_modif`) VALUES
(1, 'Cookies à la farine de châtaigne', 'Étape 1\r\nAllumer le four thermostat 6 (200°C)\r\n\r\nÉtape 2\r\nMettre le beurre à fondre à feu doux et ajouter la cassonade, la vanille en poudre puis, battre au mixer électrique une minute\r\n\r\nÉtape 3\r\nAjouter l\'œuf, battre puis, incorporer la farine et la levure, en tamisant.\r\n\r\nÉtape 4\r\nRemuer le pâte avec une spatule.\r\n\r\nÉtape 5\r\nATTENTION : si le mélange est trop épais, rajouter un peu de lait (env 10 cl) pour le rendre plus onctueux, rajouter les pépites, déposer avec une cuillère à soupe 10 boules sur deux plaques à pâtisserie, sur lesquelles on aura préalablement déposé du papier sulfurisé.\r\n\r\nÉtape 6\r\nLisser les boules pour en faire des disques, glisser les plaques au four et laisser cuire 12 minutes.\r\n\r\nÉtape 7\r\nATTENTION : les cookies ne doivent pas être durs dans le four, ils durcissent en refroidissant !\r\n\r\nÉtape 8\r\nDéguster les cookies à la châtaigne.', 30, 2, 1, '2025-09-07 17:17:08', '2025-09-07 17:17:08'),
(2, 'Crêpes exotiques à la farine de coco', 'Des crêpes parfumées idéales au petit déjeuner.', 20, 1, 2, '2025-09-07 18:26:11', '2025-09-07 18:27:00'),
(3, 'Pain sans gluten quinoa-riz', '1.Activer la levure\r\nDans un petit bol, verse la levure boulangère dans l’eau tiède (pas trop chaude, autour de 35–40°C).\r\nLaisse reposer pendant 10 minutes jusqu\'à ce que des bulles se forment en surface. Cela montre que la levure est activée.\r\n\r\n2.Mélanger les farines\r\nDans un grand saladier, mélange la farine de quinoa et la farine de riz complet.\r\nAjoute une pincée de sel et mélange bien.\r\n\r\n3.Incorporer la levure\r\nVerse doucement le mélange eau + levure dans les farines.\r\nMélange à la spatule ou avec les mains jusqu’à obtenir une pâte homogène.\r\nLa pâte sera plus collante qu’un pain classique (c’est normal avec les farines sans gluten).\r\n\r\n4.Repos et levée\r\nCouvre le saladier avec un torchon propre ou un film alimentaire.\r\nLaisse lever dans un endroit tiède pendant 1 heure.\r\nLa pâte doit légèrement gonfler, même si elle ne doublera pas forcément de volume (les pains sans gluten lèvent moins).\r\n\r\n5.Façonner le pain\r\nPréchauffe ton four à 200°C (chaleur tournante si possible).\r\nVerse ou façonne doucement la pâte dans un moule à cake huilé ou chemisé.\r\nTu peux lisser le dessus avec une spatule humide.\r\n\r\n6.Cuisson\r\nEnfourne pendant 35 à 45 minutes, jusqu’à ce que le pain soit doré et que la croûte soit ferme.\r\nTu peux vérifier la cuisson en plantant un couteau : il doit ressortir propre.\r\n\r\n7.Refroidissement\r\nDémoule le pain et laisse-le refroidir sur une grille pour éviter qu’il ne devienne humide dessous.\r\n\r\nConseils :\r\nPour plus de moelleux, tu peux ajouter 1 cuillère à soupe d’huile d’olive ou une cuillère de psyllium dans la pâte.\r\nTu peux aussi ajouter des graines (chia, tournesol, lin) pour enrichir le pain.', 90, 3, 3, '2025-09-07 18:35:03', '2025-09-07 18:35:03'),
(4, 'Mini-cakes salés à la farine de lentilles corail  Sans gluten – Riche en protéines végétales – Option vegan', '1.Préchauffe le four à 180°C (chaleur tournante si possible).\r\n\r\n2.Mélange les ingrédients secs\r\nDans un saladier, tamise la farine de lentilles, ajoute la fécule, la levure, le sel, le curcuma et les graines. Mélange bien.\r\n\r\n3.Ajoute les liquides\r\nVerse l’huile d’olive, le lait végétal et le vinaigre. Mélange jusqu’à obtenir une pâte homogène, un peu épaisse (comme une pâte à muffin).\r\n\r\n4.Ajoute les garnitures\r\nIncorpore les dés de légumes, olives ou herbes si tu en utilises. Mélange sans trop travailler la pâte.\r\n\r\n5.Verse dans des moules\r\nRemplis des moules à muffins ou un petit moule à cake huilé ou chemisé.\r\n\r\n6.Cuisson\r\nEnfourne pour 25 à 30 minutes (20 minutes si mini-formats). Le dessus doit être doré, l’intérieur bien cuit. Teste avec la pointe d’un couteau.\r\n\r\n7.Laisse tiédir avant de démouler.', 45, 2, 3, '2025-09-07 18:38:53', '2025-09-07 18:38:53'),
(5, 'Muffins Moelleux à la Farine de Coco et à la Banane', '1.Préchauffer le four\r\nÀ 180°C (th. 6). Préparer un moule à muffins avec des caissettes en papier ou le graisser légèrement.\r\n\r\n2.Écraser les bananes\r\nDans un bol, écraser les bananes à la fourchette jusqu’à obtenir une purée lisse.\r\n\r\n3.Mélanger les ingrédients humides\r\nAjouter les œufs, le miel (ou sirop), la vanille et l’huile de coco. Bien mélanger.\r\n\r\n4.Incorporer les ingrédients secs\r\nAjouter la farine de coco, la levure et le sel. Mélanger jusqu’à obtention d’une pâte homogène.\r\n(La farine de coco absorbe beaucoup, la pâte sera plus épaisse que pour des muffins classiques.)\r\n\r\n5.Remplir les moules et cuire\r\nVerser la pâte dans les moules à muffins, à 3/4 de hauteur.\r\n(Ajouter les toppings si souhaité.)\r\nEnfourner pour 20 à 25 minutes. Une lame de couteau doit ressortir sèche.\r\n\r\n6.Laisser refroidir\r\nLaisser tiédir avant de démouler. Déguster tiède ou froid.', 25, 1, 4, '2025-09-07 18:42:48', '2025-09-07 18:42:48'),
(6, 'Wraps maison à la farine de cactus du désert  Sans gluten – Riche en fibres – Saveur végétale et fraîche', 'Mélanger les farines\r\nDans un saladier, mélange la farine de cactus, la farine de riz et le sel.\r\n\r\nAjouter les liquides\r\nAjoute l’huile, puis verse progressivement l’eau tiède tout en mélangeant jusqu’à obtenir une pâte souple, non collante. Pétris légèrement à la main 2 à 3 minutes.\r\n\r\nRepos (facultatif)\r\nCouvre la pâte et laisse reposer 10 minutes pour détendre le gluten (ou plutôt son absence ).\r\n\r\nDiviser et étaler\r\nDivise en 4 boules égales. Étale chaque boule sur une surface farinée en cercle fin (2 mm max).\r\n\r\nCuisson à la poêle\r\nFais chauffer une poêle (sans matière grasse). Fais cuire chaque wrap 1 minute de chaque côté, jusqu’à voir des taches dorées.\r\n\r\nConserver la souplesse\r\nEmpile les wraps cuits dans un torchon propre pour qu’ils restent souples.', 35, 2, 4, '2025-09-07 18:43:31', '2025-09-07 19:20:12');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `pseudo`, `email`, `mot_de_passe`) VALUES
(1, 'chefTom', 'tom@email.fr', '$2y$10$5FM2L5wEODbRlKpEd6/bXO0/fPrnJ47ZzkTnqAUYfwx78HSDuRT6y'),
(2, 'gourmandeLily', 'lily@email.fr', '$2y$10$6.TWqfdPZzkrZkhcdn38TeI0qKEeQDKamer6CL2TZmNgLKzmH3vuG'),
(3, 'veganJoe', 'joe@email.fr', '$2y$10$CtVJ2XEf/A728smK0qnKIOZasuTrpDOSMBVcdXfxDGKQOE5lGaVBC'),
(4, 'julie', 'julie@email.fr', '$2y$10$G7KI1I7U2MYsuqQNd10a1eye5DNBHs.aNxvnfT959Z8uv/r1EMBHa');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `farine`
--
ALTER TABLE `farine`
  ADD PRIMARY KEY (`reference`);

--
-- Index pour la table `ingredient`
--
ALTER TABLE `ingredient`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `note`
--
ALTER TABLE `note`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `recette`
--
ALTER TABLE `recette`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `commentaire`
--
ALTER TABLE `commentaire`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `ingredient`
--
ALTER TABLE `ingredient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT pour la table `note`
--
ALTER TABLE `note`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `recette`
--
ALTER TABLE `recette`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
