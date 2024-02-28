function addToPanier(idProduit) {
    const apiUrl = 'http://localhost:8000/panier/api/addproduitcomposer';

    let quantite = document.getElementById('quantite')

    let requestBody = {};
    requestBody.quantite = quantite.value;
    requestBody.produit = idProduit;

    //console.log(JSON.stringify(requestBody))
    return fetch(apiUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',  //
        },
        body: JSON.stringify(requestBody),
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Erreur HTTP! Statut: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            getPanierByUser()
        })
        .catch(error => {
            console.error('Une erreur s\'est produite lors de l\'ajout du produit:', error.message);
            throw error;
        });
}

function getPanierByUser() {
    const apiUrl = 'http://localhost:8000/panier/api/byuser';
    let panierContainer = document.getElementById('panierContainer');

    return fetch(apiUrl)
        .then(response => {
            if (!response.ok) {
                throw new Error(`Erreur HTTP! Statut: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {

            panierContainer.innerHTML = "";

            data.forEach(function (produit, index) {



                let cartItem =document.createElement('div');
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
                //produitElement.setAttribute('id', produit.id_composer);

                let produitElement = document.createElement('h3');
                produitElement.textContent = ` ${produit.nom_produit}`;
                itemDetails.appendChild(produitElement);


                let description_produit = document.createElement('p');
                description_produit.textContent = ` ${produit.description_produit}`;
                itemDetails.appendChild(description_produit);


                let prixProduit = document.createElement('span');
                prixProduit.innerHTML =produit.prix_produit + "€";
                prixProduit.setAttribute('id', produit.id_composer);
                prixProduit.setAttribute('value', produit.prix_produit);
                prixProduit.classList.add('price');
                itemDetails.appendChild(prixProduit);


                let selectQuantite = document.createElement('select');
                selectQuantite.setAttribute('id', produit.id_composer);
                selectQuantite.classList.add('selectNumberProduct');
                for (let i = 1; i <= 30; i++) {
                    let option = document.createElement('option');
                    option.value = i;
                    option.text = i;
                    selectQuantite.appendChild(option);
                }

                selectQuantite.value = produit.quantite;

                cartItem.appendChild(selectQuantite);



                let buttonproduitElement = document.createElement('button');
                buttonproduitElement.textContent = "Enlever Produit";
                buttonproduitElement.classList.add('remove-btn');
                buttonproduitElement.onclick = function() {
                    removeProduitComposerPanier(produit.id_composer); 
                };
                cartItem.appendChild(buttonproduitElement);


                let totalPriceByProduit = document.createElement('p');
                totalPriceByProduit.classList.add('sousTotal');
                totalPriceByProduit.textContent = produit.quantite * produit.prix_produit;
                let idPrixProduit = 'prix' + produit.id_composer;
                totalPriceByProduit.setAttribute('id', idPrixProduit);
                panierContainer.appendChild(totalPriceByProduit);


            });
            let totalPrix = document.createElement('p');
            totalPrix.setAttribute('id', 'totalPrix');
            panierContainer.appendChild(totalPrix);

            addSelectChangeEventListeners()

            calculPrixTotal()
            return data;
        })
        .catch(error => {
            console.error('Une erreur s\'est produite:', error.message);
            throw error;
        });
}


document.addEventListener('DOMContentLoaded', function() {
   
    getPanierByUser();
});


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


function removeProduitComposerPanier(idProduit) {
    const url = '/panier/api/removeproduitcomposer';

    const data = {
        id: idProduit
    };

    console.log(data)
    const options = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json' 
        },
        body: JSON.stringify(data) 
    };

    fetch(url, options)
        .then(response => {
            if (!response.ok) {
                throw new Error('Erreur lors de la suppression du produit du panier');
            }
            return response.json();
        })
        .then(data => {
            getPanierByUser()
        })
        .catch(error => {
            console.error('Erreur:', error.message);
        });
}


function changeQuantite(idProduit, nouvelleQuantite) {
    let data = {
        id: parseInt(idProduit),
        quantite: nouvelleQuantite
    };
    let options = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    };

    fetch('/panier/api/changequantiteproduit', options)
        .then(response => {
            if (!response.ok) {
                throw new Error('Erreur lors de la requête HTTP: ' + response.status);
            }
            return response.json();
        })
        .then(data => {

        })
        .catch(error => {
            console.error('Erreur lors de la requête fetch:', error.message);
        });


}

function addProduitFromLocalStorage(idPro,quantitePro){
    const apiUrl = 'http://localhost:8000/panier/api/addproduitcomposer';

    let requestBody = {};
    requestBody.quantite = quantitePro;
    requestBody.produit = idPro;
    console.log(requestBody)
    //console.log(JSON.stringify(requestBody))
    return fetch(apiUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',  //
        },
        body: JSON.stringify(requestBody),
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Erreur HTTP! Statut: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            getPanierByUser()
        })
        .catch(error => {
            console.error('Une erreur s\'est produite lors de l\'ajout du produit:', error.message);
            throw error;
        });
}

function calculPrixTotal(){
    let elementsPrix = document.querySelectorAll('[id^="prix"]');
    let total = 0;

    elementsPrix.forEach(element => {
        total += parseFloat(element.textContent.trim());
    });
    let prixTotal = document.getElementById('totalPrice');
    prixTotal.innerHTML = total + "€";
}

function changerPrix(idProduit,selectQuantite,acienneQuantite){
    let idProduitPrix = document.getElementById("prix"+idProduit);

    var spanId = document.querySelector('span[id="' + idProduit + '"]');

    idProduitPrix.innerHTML=spanId.getAttribute('value') * selectQuantite.value;
    calculPrixTotal()
}