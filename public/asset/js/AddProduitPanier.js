function addToPanier(idProduit) {
    let apiUrl = "http://localhost:8000/panier/api/getprod/" + idProduit;

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
                prix_produit: data.prix_produit,
                image_produit: data.image_produit,
                description_produit:data.description_produit,
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

    // Récupérer les données du localStorage
    let data = JSON.parse(localStorage.getItem('panier')) || [];

    panierContainer.innerHTML = "";
    // Parcourir les données et les afficher dans le conteneur du panier
    data.forEach(function (produit, index) {
        console.log(produit);
        let cartItem = document.createElement('dev');
        cartItem.classList.add('cart-item');
        panierContainer.appendChild(cartItem);


        let linkProduit = document.createElement('a')
        linkProduit.setAttribute('href', '/produit/' + produit.id_produit);
        linkProduit.classList.add('linkProduit');
        cartItem.appendChild(linkProduit);

        var imageElement = document.createElement('img');
        imageElement.src = "/uploads/images/"+ produit.image_produit;
        linkProduit.appendChild(imageElement);

        var itemDetails = document.createElement("div");
        itemDetails.classList.add('item-details');
        cartItem.appendChild(itemDetails);


        let produitElement = document.createElement('h3');
        produitElement.textContent = ` ${produit.nom_produit}`;
        itemDetails.appendChild(produitElement);

        let description_produit = document.createElement('p');
        description_produit.textContent = ` ${produit.description_produit}`;
        itemDetails.appendChild(description_produit);


        let prixProduit = document.createElement('span');
        prixProduit.innerHTML =produit.prix_produit + "€";
        prixProduit.setAttribute('id', produit.id);
        prixProduit.setAttribute('value', produit.prix_produit);
        prixProduit.classList.add('price');
        itemDetails.appendChild(prixProduit);





        let selectQuantite = document.createElement('select');
        selectQuantite.setAttribute('id', produit.id);
        selectQuantite.classList.add('selectNumberProduct');
        for (let i = 1; i <= 30; i++) {
            let option = document.createElement('option');
            option.value = i;
            option.text = i;
            selectQuantite.appendChild(option);
        }
        selectQuantite.value = produit.quantite_produit;
        cartItem.appendChild(selectQuantite);

        let buttonproduitElement = document.createElement('button');
        buttonproduitElement.textContent = "Enlever Produit";
        buttonproduitElement.classList.add('remove-btn');

        buttonproduitElement.onclick = function() {
            removeProduitComposerPanier(produit.id); 
        };
        cartItem.appendChild(buttonproduitElement);

        let totalPriceByProduit = document.createElement('p');
        totalPriceByProduit.classList.add('sousTotal');
        totalPriceByProduit.textContent = produit.quantite_produit * produit.prix_produit;
        let idPrixProduit = 'prix' + produit.id;
        totalPriceByProduit.setAttribute('id', idPrixProduit);
        panierContainer.appendChild(totalPriceByProduit);


    });

    let totalPrix = document.createElement('p');
    totalPrix.setAttribute('id', 'totalPrix');
    panierContainer.appendChild(totalPrix);

    addSelectChangeEventListeners();

    calculPrixTotal()
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
        let acienneQuantite = selectQuantite.value
        selectQuantite.addEventListener('change', function(event) {
            let idProduit = selectQuantite.id;
          
            let nouvelleQuantite = parseInt(event.target.value);

            changerPrix(idProduit,selectQuantite,acienneQuantite)
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



function changeQuantite(idProduit, nouvelleQuantite) {
  
    let panierData = JSON.parse(localStorage.getItem('panier')) || [];

    let index = panierData.findIndex(produit => produit.id === idProduit);

    if (index !== -1) {
        panierData[index].quantite_produit = nouvelleQuantite;


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



function calculPrixTotal(){
    let elementsPrix = document.querySelectorAll('[id^="prix"]');
    let total = 0;

    elementsPrix.forEach(element => {
        total += parseFloat(element.textContent.trim());
    });
    let prixTotal = document.getElementById('totalPrix');
    prixTotal.innerHTML = total + "€";
}

function changerPrix(idProduit,selectQuantite,acienneQuantite){
    let idProduitPrix = document.getElementById("prix"+idProduit);
    var spanId = document.querySelector('span[id="' + idProduit + '"]');

    idProduitPrix.innerHTML=spanId.getAttribute('value') * selectQuantite.value;
    calculPrixTotal()

}
