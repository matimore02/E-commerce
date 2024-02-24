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
                produitElement.textContent = ` ${produit.nom_produit}, Quantité: ${produit.quantite}`;

                panierContainer.appendChild(produitElement);
            });

            return data;
        })
        .catch(error => {
            console.error('Une erreur s\'est produite:', error.message);
            throw error;
        });
}
window.addEventListener('load', function() {
    getPanierByUser()
});