<?php

// Librairie de fonctions d'accès à la base de données 
// Les donctions s'appuient sur $bdd, variable globale contenant un objet PDO initialisé sir la bonne base

function bddRequest($sql, $param = []) {            // Avec la syntaxe $param = []; si on appele la fonction avec un seule paramètre, $param sera rempli avec [])
    // Rôle : préparer et exécuter une requète, et de retourner false ou un objet "PDOstatement" (requête récupérée par $bdd->prepare())
    // Paramètres :
    //      $sql : texte de la commande SQL complète, avec des paramètres :xxx  exemple : 
    //      $param : tableau de valorisation des paramètres :xxx            (facultatif : valeur par défaut tableau vide)               
    // Retour : soit false, soit la requête préparée et exécutée
    
    // Préparer et exécuter (au sens PDO) la requête $sql qui à les paramètres dans $param
    // préparer ET exuter : préparer PUIS exuécuter

    // Préparer : méthode prepare
    // J'utilise a méthode prepare de $bdd (variable globale) (en lui assant la requête qui est dans $sql), et je récupère une requête PDO préparée (dans $req)
    global $bdd;
    $req = $bdd->prepare($sql);

    // Si $req est false : return false 
    if (empty($req))   {
        return false;
    }

    // Exécuter : methode execute
    // J'utilise la méthode execute de $req, en lui donant les paramètres qui sont dans $param
    $cr = $req->execute($param);
    // Si cela retourne true : je rerourne $req
    if ($cr) {
        return $req;
    } else {  // Sinon je retourne false 
        return false;
    }

}

function bddGetRecord($sql, $param = []) {
    // Rôle : Retourne un enregsitrement de la base de données (la première ligne récupérée par un SELECT) sous forme d'un tableau indexé
    // Paramètres :
    //      $sql : texte de la commande SQL complète, avec des paramètres :xxx
    //      $param : tableau de valorisation des paramètres :xxx
    // Retour : soit false (si on a aucune ligne), soit la première ligne récupérée (tableau indexé)
    
    // Préparer et exécuter la requête pour récupérer une requête exécutée
    $req = bddRequest($sql, $param);
    // Si $req vaut false : retourner false
    if ($req === false) {
        return false;
    }

    // Besoin récupérer la première ligne :
    // soit avec fetch -> première ligne ou false directement : on va choisir ce cas
    // soit avec fetchAll -> récupère un tableau avec toutes les lignes, extraire a première (la numéro 0 si elle existe)
    $ligne = $req->fetch(PDO::FETCH_ASSOC);
    // Ce tableau récupéré : il est de la forme nom du champ (dans le SELECT) en indx, valeur en valeur, donc ce que l'on veut retourner 
    // at-on récupéré false :
    if (empty($ligne)) {
        return false;
    } else {
        return $ligne;
    }

}

function bddGetRecords($sql, $param = []) {
    // Rôle : Retourne les lignes récupérées par un SELECT
    // Paramètres :
    //      $sql : texte de la commande SQL complète, avec des paramètres :xxx
    //      $param : tableau de valorisation des paramètres :xxx
    // Retour : un tableau comprenant des tableaux indexés par les noms des colonnes (ou un tableau vide)

    // Préparer et exécuter la requête pour récupérer une requête exécutée : on a une fonction que le fait
    $req = bddRequest($sql, $param);

    if ($req == false) {
        return [];
    }

    // On récupère toutes les lignes de la requêtes (avec sa méthode fetchAll) : cela donne directement ce que l'on veut
    return $req->fetchAll(PDO::FETCH_ASSOC);

}

function bddInsert($table, $valeurs) {
    // Rôle : Insert un enregistrement dans la base de données et retourne la clé primaire créée 
    // Paramètres :
    //      $table : nom de la table dasn la BDD
    //      $valeurs : tableau donnant les valeurs des champs (colonnes de la table) [ "nomChamp1" => valeurAdonner, ... ]
    // Retour : 0 en cas d'échec, la clé primaire créée sinon

    // Construire la requête SQL et le tableau de paramètres
    //  INSERT INTO nom de la table SET (pour chaque champ `nomChamp` = :nomChamp )
    //          et pour chaque champ mettre dans la tableau des paramètre l'entrée d'index :nomChamp avec la valeur à donner au champ
    $sql = "INSERT INTO `$table` ";
    // Préparer le tabeau de paramètres 
    $param = [];
    // on doit ajouter pour chque champ de valeurs le texte "`nomChamp` = :nomChamp", en les séparant par une vigule
    // Et ajouter dans le tablea des paramètres : :nomChamp => valeur
    // Pour la partie texte :
    /// On prépare un tabelau des textes "`nomChamp` = :nomChamp", puis on concataène les élémnts séparés par une virgule
    // Préparer le tableau des extarits SQL
    $tab = [];
    foreach($valeurs as $nomChamp => $valeurChamp) {
        $tab[] = "`$nomChamp` = :$nomChamp";
        $param[":$nomChamp"] = $valeurChamp;
    }
    // Concatener les éléments de $tab (dans $sql)
    $sql .= " SET " . implode(", ", $tab);

    // préparer / exécuter la requête : utiliser la fonction bddRequest
    $req = bddRequest($sql, $param);

    // si on récupère false : on retourne 0
    if ($req == false) {
        return 0;
    }
    // Sinon : on rerourne la valeur de la clé primaire céée, fournie par la méthode lastInsertId de $bdd (variable globale)
    global $bdd;
    return $bdd->lastInsertId();


}

function bddUpdate($table, $valeurs, $id) {
    // Rôle : Mettre à jour un enregistrement dans la base de données
    // Paramètres :
    //      $table : nom de la table dans la BDD
    //      $valeurs : tableau donnant les nouvelles valeurs des champs (colonnes de la table) [ "nomChamp1" => valeurAdonner, ... ]
    //      $id : valeur de la clé primaire (la clé primaire doit s'appeler id)
    // Retour : true si ok, false sinon

    // Construire la requête SQL et le tableau de paramètres
    //  UPDATE nom de la table SET (pour chaque champ `nomChamp` = :nomChamp ) WHERE id = :id
    //          et pour chaque champ mettre dans la tableau des paramètre l'entrée d'index :nomChamp avec la valeur à donner au champ, 
    $sql = "UPDATE `$table` ";
    // Préparer le tabeau de paramètres 
    $param = [];
    // on doit ajouter pour chque champ de valeurs le texte "`nomChamp` = :nomChamp", en les séparant par une vigule
    // Et ajouter dans le tablea des paramètres : :nomChamp => valeur
    // Pour la partie texte :
    /// On prépare un tabelau des textes "`nomChamp` = :nomChamp", puis on concataène les élémnts séparés par une virgule
    // Préparer le tableau des extarits SQL
    $tab = [];
    foreach($valeurs as $nomChamp => $valeurChamp) {
        $tab[] = "`$nomChamp` = :$nomChamp";
        $param[":$nomChamp"] = $valeurChamp;
    }
    // Concatener les éléments de $tab (dans $sql)
    $sql .= " SET " . implode(", ", $tab);

    // Ajouter la clasue WHERE et le parametre :id
    $sql .= " WHERE `id` = :id";
    $param[":id"] = $id;

    // préparer / exécuter la requête : utiliser la fonction bddRequest
    $req = bddRequest($sql, $param);

    // si on récupère false : on retourne false
    if ($req == false) {
        return false;
    } else { // Sinon retourner true
        return true;
    }

}

function bddDelete($table, $id) {
    // Rôle : Supprimer un enregistrement dans la base de données
    // Paramètres :
    //      $table : nom de la table dans la BDD
    //      $id : valeur de la clé primaire (la clé primaire doit s'appeler id)
    // Retour : true si ok, false sinon

    // Construire la requête SQL et le tableau de paramètres
    //  DELETE FROM nom de la table WHERE id = :id
    //          et pour chaque champ mettre dans la tableau des paramètre l'entrée d'index :nomChamp avec la valeur à donner au champ, 

    $sql = "DELETE FROM `$table`  WHERE `id` = :id";
    $param = [ ":id" => $id ];

    // préparer / exécuter la requête : utiliser la fonction bddRequest
    $req = bddRequest($sql, $param);

    // si on récupère false : on retourne false
    if ($req == false) {
        return false;
    } else { // Sinon retourner true
        return true;
    }
}




// Fonctions pour montrer comment générer une liste de texte avec un séparateur (donc le SET champ1 = valeur1, champ2 = valeur2, etc... d'un requête par exemple)
// à partir d'un tableau des champ => valeur
function makeSetMethodePremier($valeurs) {
    // Rôle : consturuire la partie SET champ1 = valeur1, champ2 = valeur2 d'une requête SQL
    // Méthode en détectant le premier élément pour metre le séparateur (la virgule) avant chaque élément à partir du deuxième
    // Paramètres:
    //      $valeurs : tableau donnant les valeurs des champs (colonnes de la table) [ "nomChamp1" => valeurAdonner, ... ]
    // Retour : le texte correspondant

    $sql = "SET ";
    $premier = true;
    foreach($valeurs as $nomChamp => $valeurChamp) {
        // Ajouter à $sql : `nomChamp` = :nomChamp
        // Si on est pas sur le premier : on sépare oar une virgule
        if ( ! $premier) {      // if ($premier === false)
            $sql .= ",";
        }
        // On met la partie du SET concernant ce champ
        $sql .= " `$nomChamp` = :$nomChamp";

        // On ne va plus être sur le premier
        $premier = false;
    }
    return $sql;

}

function makeSetMethodeRetraitVirgule($valeurs) {
    // Rôle : consturuire la partie SET champ1 = valeur1, champ2 = valeur2 d'une requête SQL
    //   methode utilisée : on met la virgule arès tous les champs, puis on rerire la dernière virgule
    // Paramètres:
    //      $valeurs : tableau donnant les valeurs des champs (colonnes de la table) [ "nomChamp1" => valeurAdonner, ... ]
    // Retour : le texte correspondant

    $sql = "SET ";
    // Pour chaque champ de $valeurs 
    $premier = true;
    foreach($valeurs as $nomChamp => $valeurChamp) {
        $sql .= " `$nomChamp` = :$nomChamp, ";
    }

    // Rerirer la virgule finale (le dernier caractère)
    $sql = substr($sql, 0, strlen($sql) -1);
                // substr : cela extrait une partie d'une chaine
                //  le premier paramètre est la cgaine d'origine
                //  le 2ème paramètre est le caractère de dépard (numérotés à partir de 0) 0 part donc du début
                //  le 3ème paramètre est le nombre de caractère à extraire : strlen($sql) est le nombre de caractère de $sql , donc on en prend un de moins
                // La fonction retourbe la sous-chaine
}

function makeSetMethodeImplode($valeurs) {
    // Rôle : consturuire la partie SET champ1 = valeur1, champ2 = valeur2 d'une requête SQL
    //   methode utilisée : implode d'un tableau
    // Paramètres:
    //      $valeurs : tableau donnant les valeurs des champs (colonnes de la table) [ "nomChamp1" => valeurAdonner, ... ]
    // Retour : le texte correspondant    


    // ON va construire un tableau avec pour chaque élément de $valeurs, une entrée dont texte est `nomChamp` = :nomChamp
    $tab = [];  // on a un tableau vide  pour démarrer
    foreach($valeurs as $nomChamp => $valeurChamp) {
        $tab[] = "`$nomChamp` = :$nomChamp";
    }

    // On va "imploder" ce tableau en mettant une virgule en séparateur
    return "SET " . implode(",", $tab);

}