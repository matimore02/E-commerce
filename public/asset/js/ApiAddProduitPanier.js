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

                let produitElement = document.createElement('p');
                //produitElement.setAttribute('id', produit.id_composer);
                produitElement.textContent = ` ${produit.nom_produit}`;
                panierContainer.appendChild(produitElement);

                let selectQuantite = document.createElement('select');
                selectQuantite.setAttribute('id', produit.id_composer);
                for (let i = 1; i <= 30; i++) {
                    let option = document.createElement('option');
                    option.value = i;
                    option.text = i;
                    selectQuantite.appendChild(option);
                }

                selectQuantite.value = produit.quantite;

                panierContainer.appendChild(selectQuantite);



                let buttonproduitElement = document.createElement('button');
                buttonproduitElement.textContent = "enlever Produit";

                buttonproduitElement.onclick = function() {
                    removeProduitComposerPanier(produit.id_composer); 
                };
                panierContainer.appendChild(buttonproduitElement);

                let prixProduit = document.createElement('p');
                prixProduit.textContent = produit.quantite * produit.prix_produit;
                let idPrixProduit = 'prix' + produit.id_composer;
                prixProduit.setAttribute('id', idPrixProduit);
                panierContainer.appendChild(prixProduit);
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
            if (data.success) {
                console.log('La quantité du produit a été mise à jour avec succès.');
            } else {
                console.error('Erreur lors de la mise à jour de la quantité du produit:', data.message);
            }
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
    let prixTotal = document.getElementById('totalPrix');
    prixTotal.innerHTML = total + "€";
}

function changerPrix(idProduit,selectQuantite,acienneQuantite){
    let idProduitPrix = document.getElementById("prix"+idProduit);

    idProduitPrix.innerHTML=(idProduitPrix.innerHTML / acienneQuantite ) * selectQuantite.value;
    calculPrixTotal()
}