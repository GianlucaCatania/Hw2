const token = document.head.querySelector('meta[name="csrf-token"]').content;

function noRefresh(event) {
    event.preventDefault(); 
}

const links = document.querySelectorAll("a");

for (let link of links) {
    if (link.id !== 'order-link' && 
        link.id !== 'login-label' && 
        link.id !== 'register-label' &&
        link.id !== 'account-label' &&
        link.id !== 'logout-label' &&
        link.id !== 'account-img' &&
        link.id !== 'logout-img') {
            
        link.addEventListener("click", noRefresh);
    }
}





function mostraNascondiSezione() {

  if (carica_altri_button.textContent === "Mostra meno") {
    carica_altri_section.classList.add("hidden");
    carica_altri_button.textContent = "Carica altri"; 
    
  } else {
    carica_altri_section.classList.remove("hidden");
    carica_altri_button.textContent = "Mostra meno";
  }
}

const carica_altri_button = document.querySelector("#carica-altri");
const carica_altri_section = document.querySelector("#sezione-extra");

carica_altri_button.addEventListener("click", mostraNascondiSezione);





function selezionaIcona(event) {

  const card = event.currentTarget;
  const iconaInfo = card.querySelector(".info-icon");
  iconaInfo.src = iconaInfo.dataset.selected;
}

function deselezionaIcona(event) {

  const card = event.currentTarget;
  const iconaInfo = card.querySelector(".info-icon");
  iconaInfo.src = iconaInfo.dataset.default;
}






function onJson(json) {

    console.log("Dati ricevuti dall'API:", json);

    const container = document.createElement('div');
    
    if (json !== null) {
      let nutrienti = json.ingredients[0].parsed[0].nutrients;
      let calorie = Math.floor(nutrienti.ENERC_KCAL.quantity);
      let proteine = Math.floor(nutrienti.PROCNT.quantity);
      let grassi = Math.floor(nutrienti.FAT.quantity);
      let carboidrati = Math.floor(nutrienti.CHOCDF.quantity);
      let fibre = Math.floor(nutrienti.FIBTG.quantity);
      let zuccheri = Math.floor(nutrienti.SUGAR.quantity);
      
      const titolo = document.createElement('h2');
      titolo.textContent = 'Valori Nutrizionali';
      container.appendChild(titolo);

      const pCal = document.createElement('p');
      pCal.textContent = 'Calorie: ' + calorie + ' kcal';
      container.appendChild(pCal);

      const pProt = document.createElement('p');
      pProt.textContent = 'Proteine: ' + proteine + ' g';
      container.appendChild(pProt);

      const pGrass = document.createElement('p');
      pGrass.textContent = 'Grassi: ' + grassi + ' g';
      container.appendChild(pGrass);

      const pCarb = document.createElement('p');
      pCarb.textContent = 'Carboidrati: ' + carboidrati + ' g';
      container.appendChild(pCarb);

      const pZucc = document.createElement('p');
      pZucc.textContent = 'Zuccheri: ' + zuccheri + ' g';
      container.appendChild(pZucc);

      const pFibre = document.createElement('p');
      pFibre.textContent = 'Fibre: ' + fibre + ' g';
      container.appendChild(pFibre);
    }

    else {
      const errore = document.createElement('h5');
      errore.textContent = "Errore nel JSON restituito dall'API";
      container.appendChild(errore);
    }

    modale.style.top = window.pageYOffset + 'px'; 
    document.body.classList.add('no-scroll'); 
    modale.classList.remove('hidden'); 

    modale.appendChild(container);
}

function onResponse(response) {
    if (response.ok) {
        return response.json(); 
    } else {
        return null;
    }
}

function elaboraClick(event) {
    const ingredienti = event.currentTarget.dataset.macro;
    const ingredientiCodificati = encodeURIComponent(ingredienti);

    const rest_url = macro_api_url + '?ingr=' + ingredientiCodificati;
    fetch(rest_url).then(onResponse).then(onJson);
}

function chiudiModale(event) {
    document.body.classList.remove('no-scroll');
    modale.classList.add('hidden');
    modale.innerHTML= '';
}

const modale = document.querySelector('#modale-risultati');
if (modale) {
    modale.addEventListener('click', chiudiModale);
}





function onCibiJson(json) {
    
    if (json === null || json.length === 0) {
        console.log("Nessun cibo trovato nel database.");
        return;
    }

    const listCategory = document.querySelectorAll('.menu-category');

    for (let cibo of json) { 

        const infoLink = document.createElement('a');
        infoLink.href = "#";
        infoLink.classList.add('info-link');
        infoLink.dataset.macro = cibo.macro;

        const infoLinkImg = document.createElement('img');
        infoLinkImg.classList.add('info-icon');
        infoLinkImg.src ='img/info-icon-default.png';
        infoLinkImg.dataset.default = 'img/info-icon-default.png';
        infoLinkImg.dataset.selected = 'img/info-icon-selected.png';
        infoLink.addEventListener('click', elaboraClick);
        infoLink.addEventListener('click', noRefresh);
        
        infoLink.appendChild(infoLinkImg);

        const imgCibo = document.createElement('img');
        imgCibo.src = cibo.image;

        const cardImg = document.createElement('div');
        cardImg.classList.add('card-img');

        cardImg.appendChild(infoLink);
        cardImg.appendChild(imgCibo);

        const foodTitle = document.createElement('h4');
        foodTitle.textContent = cibo.name;
        foodTitle.classList.add("product-name");

        const addOrderLabel = document.createElement('a');
        addOrderLabel.textContent = "Aggiungi all'ordine";
        addOrderLabel.href = "#";
        addOrderLabel.classList.add('add-to-order');
        addOrderLabel.dataset.id = cibo.id;
        addOrderLabel.dataset.name = cibo.name;
        addOrderLabel.addEventListener('click', addToCart);

        const productCard = document.createElement('div');
        productCard.classList.add('product-card');
        productCard.addEventListener("mouseenter", selezionaIcona);
        productCard.addEventListener("mouseleave", deselezionaIcona);

        productCard.appendChild(cardImg);
        productCard.appendChild(foodTitle);
        productCard.appendChild(addOrderLabel);
                
        let contenitoreTarget = null;
        for (let categoria of listCategory) {
            if (categoria.dataset.category === cibo.category) {
                contenitoreTarget = categoria;
                break;
            }
        }

        if (contenitoreTarget) {
            contenitoreTarget.appendChild(productCard);
        }
    }
}

fetch(load_database_url).then(onResponse).then(onCibiJson);





function addToCart(event) {

    event.preventDefault();

    const notify = document.createElement('div');
    notify.classList.add('banner-carrello'); 

    const body = document.querySelector('body');
    
    const labelAddToCart = event.currentTarget;
    const foodId = labelAddToCart.dataset.id;
    const foodName = labelAddToCart.dataset.name;
    const formData = new FormData();
    formData.append('id_cibo', foodId); 

    fetch(add_cart_url, {
        method: 'POST',
        body: formData,
        headers: {'X-CSRF-TOKEN': token}
    })
    .then(onResponse).then(function(data) {

        if (data !== null && data.ok === true) {
            notify.textContent = foodName + " è stata aggiunto al carrello!";
            body.appendChild(notify);
            
            setTimeout(function() {
                notify.remove();
            }, 2300); 
        } 
        else if (data !== null && data.ok === false) {
            notify.textContent = "Errore: " + data.errore;
            body.appendChild(notify);
            
            setTimeout(function() {
                notify.remove();
            }, 2300);
        }
    });
}