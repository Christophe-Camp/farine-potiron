/**
 * Script principal pour la gestion de la page recettes :
 * - Gestion dynamique des farines et ingrédients (ajout, suppression, affichage description)
 * - Gestion des commentaires (ajout, modification via AJAX)
 * - Gestion des votes (like/dislike) via AJAX
 * - Recherche de recettes en temps réel avec filtre par farine via AJAX
 */

document.addEventListener("DOMContentLoaded", () => {

    /** ============================
     * GESTION DES FARINES ET INGRÉDIENTS
     * ============================ */
    const containerFarines = document.getElementById("containerFarines");
    const containerIngredients = document.getElementById("containerIngredients");
    const ajouterFarineBtn = document.getElementById("ajouterFarine");
    const ajouterIngredientBtn = document.getElementById("ajouterIngredient");

    // Met à jour la description affichée de la farine sélectionnée
    function updateDescription(select) {
        const ligne = select.closest(".farineLigne");
        const descriptionDiv = ligne.nextElementSibling;
        const selectedOption = select.options[select.selectedIndex];
        if (descriptionDiv && descriptionDiv.classList.contains("farineDescription")) {
            descriptionDiv.textContent = selectedOption.dataset.description || "";
        }
    }

    // Ajouter un écouteur sur tous les selects existants
    document.querySelectorAll(".selectFarine").forEach(select => {
        select.addEventListener("change", function () { updateDescription(this); });
    });

    // Ajouter dynamiquement une nouvelle ligne de farine
    if (ajouterFarineBtn && containerFarines) {
        ajouterFarineBtn.addEventListener("click", () => {
            const template = containerFarines.querySelector(".farineLigne");
            const nouvelleLigne = template.cloneNode(true);

            // Réinitialiser les champs
            const select = nouvelleLigne.querySelector("select");
            select.selectedIndex = 0;
            nouvelleLigne.querySelector("input[name='quantite_farine[]']").value = "";

            select.addEventListener("change", function () { updateDescription(this); });
            containerFarines.insertBefore(nouvelleLigne, ajouterFarineBtn);

            // Créer une div pour la description
            const descDiv = document.createElement("div");
            descDiv.className = "mb-2 farineDescription";
            containerFarines.insertBefore(descDiv, ajouterFarineBtn);
        });
    }

    // Ajouter dynamiquement une nouvelle ligne d'ingrédient
    if (ajouterIngredientBtn && containerIngredients) {
        ajouterIngredientBtn.addEventListener("click", () => {
            const template = containerIngredients.querySelector(".ingredientLigne");
            const nouvelleLigne = template.cloneNode(true);
            nouvelleLigne.querySelector("input[name='ingredient_nom[]']").value = "";
            nouvelleLigne.querySelector("input[name='ingredient_quantite[]']").value = "";
            containerIngredients.insertBefore(nouvelleLigne, ajouterIngredientBtn);
        });
    }

    // Supprimer une farine ou un ingrédient
    document.body.addEventListener("click", e => {
        if (e.target.classList.contains("supprimerIngredient") || e.target.classList.contains("supprimerFarine")) {
            const ligne = e.target.closest(".input-group");
            if (ligne) ligne.remove();
        }
    });

    /** ============================
     * COMMENTAIRES
     * ============================ */
    const containerCommentaires = document.querySelector(".mb-5");
    const boutonAjouter = document.getElementById("envoyerCommentaire");

    if (boutonAjouter && containerCommentaires) {
        boutonAjouter.addEventListener("click", function () {
            const texteInput = document.getElementById("commentaireTexte");
            if (!texteInput) return;
            const texte = texteInput.value.trim();
            if (!texte) return;

            // Envoi du commentaire via AJAX
            fetch("/commentaireAjax.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ action: "ajouter", recette_id: RECETTE_ID, contenu: texte })
            })
            .then(res => res.json())
            .then(data => {
                if (!data.success) return alert(data.message);

                // Création de la div du nouveau commentaire
                const div = document.createElement("div");
                div.className = "list-group-item";
                div.dataset.id = data.id;
                div.innerHTML = `
                    <p class="mb-1"><strong>${data.pseudo}</strong>
                    <span class="text-muted small">(${data.date_crea})</span></p>
                    <p class="mb-0 commentaire-texte">${texte}</p>
                    <button class="btn btn-sm btn-outline-warning modifier-commentaire">✏️ Modifier</button>
                `;

                let liste = containerCommentaires.querySelector(".list-group");
                if (!liste) {
                    liste = document.createElement("div");
                    liste.className = "list-group";
                    containerCommentaires.appendChild(liste);
                }
                liste.prepend(div);
                texteInput.value = "";

                // Activer modification pour ce commentaire
                activerModificationCommentaire(div.querySelector(".modifier-commentaire"));
            });
        });

        // Fonction pour permettre la modification d'un commentaire existant
        function activerModificationCommentaire(btn) {
            btn.addEventListener("click", function () {
                const div = btn.closest(".list-group-item");
                const id = div.dataset.id;
                const texteP = div.querySelector(".commentaire-texte");
                const ancienTexte = texteP.innerText;

                const input = document.createElement("textarea");
                input.className = "form-control mb-2";
                input.value = ancienTexte;

                const saveBtn = document.createElement("button");
                saveBtn.className = "btn btn-success btn-sm";
                saveBtn.innerText = "Enregistrer";

                texteP.replaceWith(input);
                btn.replaceWith(saveBtn);

                saveBtn.addEventListener("click", function () {
                    const nouveauTexte = input.value.trim();
                    if (!nouveauTexte) return;

                    fetch("/commentaireAjax.php", {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({ action: "modifier", id: id, contenu: nouveauTexte })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (!data.success) return alert(data.message);
                        const p = document.createElement("p");
                        p.className = "mb-0 commentaire-texte";
                        p.innerText = nouveauTexte;
                        input.replaceWith(p);
                        saveBtn.replaceWith(btn);
                    });
                });
            });
        }

        document.querySelectorAll(".modifier-commentaire").forEach(activerModificationCommentaire);
    }

    /** ============================
     * VOTES (LIKE / DISLIKE)
     * ============================ */
    const likeBtn = document.getElementById("vote-like");
    const dislikeBtn = document.getElementById("vote-dislike");

    if (likeBtn && dislikeBtn) {
        let userVote = likeBtn.classList.contains("active-like") ? 1 :
                    dislikeBtn.classList.contains("active-dislike") ? -1 : 0;

        function updateVoteButtons(vote) {
            likeBtn.classList.remove("active-like");
            dislikeBtn.classList.remove("active-dislike");

            if (vote === 1) likeBtn.classList.add("active-like");
            else if (vote === -1) dislikeBtn.classList.add("active-dislike");

            userVote = vote;
        }

        function envoyerVote(valeur) {
            fetch("/voteAjax.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ recette_id: RECETTE_ID, valeur: valeur })
            })
            .then(res => res.json())
            .then(data => {
                if (!data.success) { alert(data.message); return; }

                document.getElementById("like-count").innerText = data.likes;
                document.getElementById("dislike-count").innerText = data.dislikes;
                updateVoteButtons(data.userVote);
            })
            .catch(err => console.error("Erreur AJAX vote :", err));
        }

        if (!likeBtn.disabled) {
            likeBtn.addEventListener("click", () => {
                let valeur = userVote === 1 ? 0 : 1;
                envoyerVote(valeur);
            });

            dislikeBtn.addEventListener("click", () => {
                let valeur = userVote === -1 ? 0 : -1;
                envoyerVote(valeur);
            });
        }
    }

    /**
     * === RECHERCHE DE RECETTES ===
     * Permet de filtrer les recettes par mot-clé et type de farine en temps réel.
     * Les résultats sont affichés sous forme de cartes Bootstrap.
     */
    const champRecherche = document.getElementById("champRecherche");
    const filtreFarine = document.getElementById("filtreFarine");
    const boutonRecherche = document.getElementById("boutonRecherche");
    const listeRecettes = document.getElementById("listeRecettes");

    // Fonction pour charger les recettes depuis le serveur via AJAX
    function chargerRecettes() {
        if (!champRecherche || !filtreFarine || !listeRecettes) return;

        const recherche = champRecherche.value.trim(); // récupérer le texte de recherche
        const farine = filtreFarine.value;            // récupérer la farine sélectionnée

        // Requête AJAX vers le serveur
        fetch(`chercherAjax.php?recherche=${encodeURIComponent(recherche)}&farine=${encodeURIComponent(farine)}`)
            .then(res => res.json())
            .then(data => {
                listeRecettes.innerHTML = ""; // vider les recettes actuelles

                // Si aucune recette trouvée
                if (!data.success || data.recettes.length === 0) {
                    listeRecettes.innerHTML = "<p>Aucune recette trouvée.</p>";
                    return;
                }

                // Boucle sur les recettes reçues et création des cartes
                data.recettes.forEach(r => {
                    const col = document.createElement("div");
                    col.className = "col"; // utiliser les classes Bootstrap pour la grille
                    col.innerHTML = `
                        <a href="afficherRecette.php?id=${r.id}" class="text-decoration-none text-dark">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title">${r.titre}</h5>
                                    <p class="card-text mb-1"><i class="bi bi-person"></i> ${r.pseudo}</p>
                                    <p class="card-text mb-1"><i class="bi bi-clock"></i> ${r.duree_preparation} min</p>
                                    <p class="card-text mb-1"><i class="bi bi-bar-chart"></i> Difficulté: ${r.difficulte}</p>
                                    <p class="card-text"><i class="bi bi-calendar-event"></i> ${r.date_modif ?? ''}</p>
                                </div>
                            </div>
                        </a>
                    `;
                    listeRecettes.appendChild(col); // ajouter la carte à la grille
                });
            });
    }

    // Ajouter les événements pour déclencher la recherche
    if (champRecherche && filtreFarine && listeRecettes) {
        champRecherche.addEventListener("input", chargerRecettes); // recherche en live
        filtreFarine.addEventListener("change", chargerRecettes);   // filtre par farine
        if (boutonRecherche) boutonRecherche.addEventListener("click", chargerRecettes); // bouton recherche

        // Chargement initial des recettes à l'ouverture de la page
        chargerRecettes();
    }
});