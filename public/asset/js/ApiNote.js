function  getNoteProduit(idProduit){
    let apiUrl = "http://localhost:8000/noter/api/getnotebyidproduit/" +idProduit;
    let noteProduit= document.getElementById("noteProduit")
    return fetch(apiUrl)
        .then(response => {
            if (!response.ok) {
                throw new Error(`Erreur HTTP! Statut: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {

            noteProduit.innerHTML = "";
            noteProduit.innerHTML = data.moyenne_note;

        })
        .catch(error => {
            console.error('Une erreur s\'est produite:', error.message);
            throw error;
        });
}



