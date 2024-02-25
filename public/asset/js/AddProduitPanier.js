function addToPanier(idProduit) {
    let apiUrl = "http://localhost:8000/panier/api/getproduit/" + idProduit;

    fetch(apiUrl)
        .then(response => {
            if (!response.ok) {
                throw new Error(`Erreur HTTP! Statut: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            
            let quantite = document.getElementById("quantite").value;
            console.log(quantite)
            // Créer un nouvel objet représentant le produit à ajouter au panier
            let uniqueId = uuidv4();
            let newItem = {
                id: uniqueId,
                id_produit: idProduit,
                nom_produit: data.nom_produit,
                quantite_produit: quantite,
            };

            // Récupérer les données actuelles du localStorage
            let currentData = JSON.parse(localStorage.getItem('panier')) || [];

            // Ajouter le nouvel élément aux données actuelles
            currentData.push(newItem);

            // Enregistrer les nouvelles données dans le localStorage
            localStorage.setItem('panier', JSON.stringify(currentData));

            // Vérifier le contenu de localStorage
            getPanierByUser();
            console.log(localStorage);
        })
        .catch(error => {
            console.error('Une erreur s\'est produite:', error.message);
            throw error;
        });
}

function getPanierByUser() {
    let panierContainer = document.getElementById('panierContainer');
    panierContainer.innerHTML = "";
    // Récupérer les données du localStorage
    let data = JSON.parse(localStorage.getItem('panier')) || [];

    // Parcourir les données et les afficher dans le conteneur du panier
    data.forEach(function (produit, index) {

        let produitElement = document.createElement('p');
        produitElement.textContent = ` ${produit.nom_produit}`;
        panierContainer.appendChild(produitElement);

        let selectQuantite = document.createElement('select');
        selectQuantite.setAttribute('id', produit.id);
        for (let i = 1; i <= 30; i++) {
            let option = document.createElement('option');
            option.value = i;
            option.text = i;
            selectQuantite.appendChild(option);
        }
        selectQuantite.value = produit.quantite_produit;
        panierContainer.appendChild(selectQuantite);

        let buttonproduitElement = document.createElement('button');
        buttonproduitElement.textContent = "enlever Produit";

        buttonproduitElement.onclick = function() {
            removeProduitComposerPanier(produit.id); 
        };
        panierContainer.appendChild(buttonproduitElement);
    });

    addSelectChangeEventListeners(); // Ajouter les écouteurs d'événements aux sélecteurs de quantité
}
document.addEventListener('DOMContentLoaded', function() {
   
    getPanierByUser();
});

function removeProduitComposerPanier(id) {
    // Récupérer les données actuelles du panier depuis le localStorage
    let panierData = JSON.parse(localStorage.getItem('panier')) || [];

    // Filtrer les données pour supprimer le produit avec l'ID du compositeur donné
    let nouveauPanierData = panierData.filter(produit => produit.id !== id);

    // Enregistrer les nouvelles données dans le localStorage
    localStorage.setItem('panier', JSON.stringify(nouveauPanierData));

    // Mettre à jour l'affichage du panier
    getPanierByUser();
}

function addSelectChangeEventListeners() {
    
    let selectsQuantite = document.querySelectorAll('select');

    selectsQuantite.forEach(function(selectQuantite) {
        selectQuantite.addEventListener('change', function(event) {
            let idProduit = selectQuantite.id;
          
            let nouvelleQuantite = parseInt(event.target.value); 
            console.log(idProduit,nouvelleQuantite)
            changeQuantite(idProduit, nouvelleQuantite);
        });
    });
}

function uuidv4() {
    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
        var r = Math.random() * 16 | 0,
            v = c == 'x' ? r : (r & 0x3 | 0x8);
        return v.toString(16);
    });
}


console.log(localStorage)
function changeQuantite(idProduit, nouvelleQuantite) {
  
    let panierData = JSON.parse(localStorage.getItem('panier')) || [];

    let index = panierData.findIndex(produit => produit.id === idProduit);

    if (index !== -1) {
        panierData[index].quantite = nouvelleQuantite;


        localStorage.setItem('panier', JSON.stringify(panierData));

        console.log(localStorage);
    } else {
        console.error('Le produit spécifié n\'existe pas dans le panier.');
    }
}

function initSelecteursAvecDonneesDuPanier() {
    let panierData = JSON.parse(localStorage.getItem('panier')) || [];

    // Parcourir chaque produit dans le panier
    panierData.forEach(produit => {
        let selecteur = document.getElementById(produit.id);
        if (selecteur) {
            selecteur.value = produit.quantite;
        }
    });
}

window.addEventListener('load', function() {
    initSelecteursAvecDonneesDuPanier();
});