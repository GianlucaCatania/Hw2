const token = document.head.querySelector('meta[name="csrf-token"]').content;

function onJson(json) {
    
    const container = document.querySelector('#risultato-pagamento');
    
    if (json !== null) {
        fetch(ORDER_URL).then(onResponse).then(ricaricaCarrello);
    }
    else {
        const messaggio = document.createElement('h3');
        messaggio.textContent = "Pagamento fallito!";
        messaggio.style.color = "red"; 
        container.appendChild(messaggio);
    }
}

function onResponse(response) {
    if(response.ok) {
        return response.json();
    } else {
        return null;
    }
}

function paga(event) {

    event.preventDefault(); 
    const datiPagamento = 'importo=' + totaleOrdine;

    fetch(PAY_URL, {
        method: 'post',
        body: datiPagamento,
        headers: {'X-CSRF-TOKEN': token}
    }).then(onResponse).then(onJson);
}

const form = document.querySelector('#form-pagamento');
form.addEventListener('submit', paga);





function noRefresh(event) {
    if(event.currentTarget.id !== "Accedi" && 
        event.currentTarget.id !== "Profilo" && 
        event.currentTarget.id !== "Prodotti" && 
        event.currentTarget.id !== "img-home" && 
        event.currentTarget.id !== "new" && 
        event.currentTarget.id != "logo") {
        event.preventDefault();
    }
}

let totaleOrdine = 0;
function onCarrelloJson(json) {

    totaleOrdine = 0;

    const listaProdotti = document.querySelector('.lista-prodotti');
    listaProdotti.innerHTML = '';
    const riepilogo = document.querySelector('.riepilogo-ordine');

    if (json.length === 0) {

        const messaggio = document.createElement('h3');
        messaggio.textContent = "Al momento non sono presenti prodotti nel carrello";
        messaggio.classList.add("carrello-vuoto");
        listaProdotti.appendChild(messaggio);
        riepilogo.classList.add('hidden');

    } else {

        riepilogo.classList.remove('hidden');

        for (let cibo of json) {
            
            totaleOrdine += cibo.price * cibo.quantita;

            const articleProdottoCarrello = document.createElement('article');
            articleProdottoCarrello.classList.add("prodotto-carrello");

            const divImmagineProdotto = document.createElement('div');
            divImmagineProdotto.classList.add('immagine-prodotto'); 
            const immagine = document.createElement('img');
            immagine.src = cibo.image;
            divImmagineProdotto.appendChild(immagine);

            const divInfoProdotto = document.createElement('div');
            divInfoProdotto.classList.add('info-prodotto');

            const nomeProdotto = document.createElement('h3');
            nomeProdotto.classList.add('nome-prodotto');
            nomeProdotto.textContent = cibo.name; 

            const divQuantita = document.createElement('div');
            divQuantita.classList.add('sezione-quantita'); 

            const testoQuantita = document.createElement('p');
            testoQuantita.classList.add('quantita-prodotto'); 
            testoQuantita.textContent = 'Quantità: ' + cibo.quantita; 

            const btnMeno = document.createElement('a');
            btnMeno.textContent = "-";
            btnMeno.href = "#";
            btnMeno.classList.add('btn-quantita'); 
            btnMeno.dataset.id = cibo.product_id;
            btnMeno.addEventListener('click', gestisciRimozione);
            btnMeno.addEventListener('click', noRefresh);

            const btnPiu = document.createElement('a');
            btnPiu.textContent = "+";
            btnPiu.href = "#";
            btnPiu.classList.add('btn-quantita'); 
            btnPiu.dataset.id = cibo.product_id;
            btnPiu.addEventListener('click', gestisciAggiunta);
            btnPiu.addEventListener('click', noRefresh);

            divQuantita.appendChild(testoQuantita);
            divQuantita.appendChild(btnMeno);
            divQuantita.appendChild(btnPiu);

            divInfoProdotto.appendChild(nomeProdotto);
            divInfoProdotto.appendChild(divQuantita);

            const divPrezzoProdotto = document.createElement('div');
            divPrezzoProdotto.classList.add('prezzo-prodotto'); 

            const prezzoProdotto = document.createElement('p');
            prezzoProdotto.textContent = cibo.price + '€'; 

            const btnRimuovi = document.createElement('a');
            btnRimuovi.href = "#"; 
            btnRimuovi.classList.add('btn-rimuovi'); 
            btnRimuovi.textContent = "Rimuovi"; 
            btnRimuovi.dataset.id = cibo.product_id; 
            btnRimuovi.addEventListener('click', gestisciEliminazione);
            btnRimuovi.addEventListener('click', noRefresh);

            divPrezzoProdotto.appendChild(prezzoProdotto);
            divPrezzoProdotto.appendChild(btnRimuovi);

            articleProdottoCarrello.appendChild(divImmagineProdotto);
            articleProdottoCarrello.appendChild(divInfoProdotto);
            articleProdottoCarrello.appendChild(divPrezzoProdotto);

            listaProdotti.appendChild(articleProdottoCarrello);
        }
        
        totaleOrdine = Math.floor(totaleOrdine * 100) / 100;
        document.querySelector('.cifra-totale').textContent = totaleOrdine + '€';
    }
}

fetch(LOAD_CART_URL).then(onResponse).then(onCarrelloJson);

function ricaricaCarrello() {
    fetch(LOAD_CART_URL).then(onResponse).then(onCarrelloJson)
}

function gestisciAggiunta(event) {
    const idCibo = event.currentTarget.dataset.id;

    const formData = new FormData();
    formData.append('id_cibo', idCibo);

    fetch(ADD_CART_URL, {
        method: 'POST',
        body: formData,
        headers: {'X-CSRF-TOKEN': token}
    }).then(onResponse).then(ricaricaCarrello);
}

function gestisciRimozione(event) {
    const idCibo = event.currentTarget.dataset.id;
    
    const formData = new FormData();
    formData.append('id_cibo', idCibo); 

    fetch(REMOVE_CART_URL, {
        method: 'POST',
        body: formData,
        headers: {'X-CSRF-TOKEN': token}
    }).then(onResponse).then(ricaricaCarrello);
}

function gestisciEliminazione(event) {
    const idCibo = event.currentTarget.dataset.id;
    const formData = new FormData();
    formData.append('id_cibo', idCibo); 

    fetch(DELETE_CART_URL, {
        method: 'POST',
        body: formData,
        headers: {'X-CSRF-TOKEN': token}
    }).then(onResponse).then(ricaricaCarrello);
}

const addToCartLabels = document.querySelectorAll('.add-to-order');