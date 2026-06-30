console.log("ciao");

function mostraErrore(messaggio) {
    const errorBox = document.querySelector('.error-line');
    const errorSpan = errorBox.querySelector('span');
    
    errorSpan.textContent = "JS: " + messaggio;
    errorBox.classList.remove('hidden');
}

function nascondiErrore() {
    const errorBox = document.querySelector('.error-line');
    errorBox.classList.add('hidden');
}

function checkName(event) {
    const input = event.currentTarget;
    formStatus.name = input.value.length > 0;
    if (formStatus.name) {
        nascondiErrore();
    } else {
        mostraErrore("Il nome non può essere vuoto");
    }
}

function checkSurname(event) {
    const input = event.currentTarget;
    formStatus.surname = input.value.length > 0;
    if (formStatus.surname) {
        nascondiErrore();
    } else {
        mostraErrore("Il cognome non può essere vuoto");
    }
}

function jsonCheckUsername(json) {
    if (!json.exists) {
        formStatus.username = true;
        nascondiErrore();
        
    } else {
        formStatus.username = false;
        mostraErrore("Username già in uso");
    }
}

function jsonCheckEmail(json) {
    if (json.exists) {
        formStatus.email = false;
        mostraErrore("Email già utilizzata");
    } else {
        formStatus.email = true;
        nascondiErrore();
    }
}

function fetchResponse(response) {
    if (!response.ok) return null;
    return response.json();
}

function checkUsername() {
    const input = document.querySelector('.username input');

    if(input.value.length === 0 || input.value.length > 15) {
        formStatus.username = false;
        mostraErrore("Lo username deve essere compreso tra 1 e 15 caratteri");

    } else {
        nascondiErrore();
        fetch(check_username_url + "?q=" + encodeURIComponent(input.value)).then(fetchResponse).then(jsonCheckUsername);
    }    
}

function checkEmail() {
    const emailInput = document.querySelector('.email input');

    if(emailInput.value.length === 0) {
        mostraErrore("Email non valida");
        formStatus.email = false;
    } else {
        nascondiErrore();
        fetch(check_email_url + "?q=" + encodeURIComponent(String(emailInput.value).toLowerCase())).then(fetchResponse).then(jsonCheckEmail);
    }
}

function checkPassword(event) {
    const passwordInput = event.currentTarget;
    formStatus.password = passwordInput.value.length >= 8;

    if (formStatus.password) {
        nascondiErrore();
    } else {
        mostraErrore("La password deve essere di almeno 8 caratteri");
    }
}
function checkConfirmPassword(event) {
    const confirmPasswordInput = event.currentTarget;
    const password = document.querySelector('.password input').value;
    formStatus.confirmPassword = confirmPasswordInput.value === password;

    if (formStatus.confirmPassword) {
        nascondiErrore();
    } else {
        mostraErrore("Le password non coincidono");
    }
}

function checkSignup(event) {
    const checkbox = document.querySelector('.allow input');
    formStatus.allow = checkbox.checked;

    if (!formStatus.name || !formStatus.surname || !formStatus.username || !formStatus.email || !formStatus.password || !formStatus.confirmPassword || !formStatus.allow) {
        event.preventDefault();
        mostraErrore("Riempi tutti i campi");
    }
}

const formStatus = {
    name: false,
    surname: false,
    username: false,
    email: false,
    password: false,
    confirmPassword: false,
    allow: false
};

document.querySelector('.name input').addEventListener('blur', checkName);
document.querySelector('.surname input').addEventListener('blur', checkSurname);
document.querySelector('.username input').addEventListener('blur', checkUsername);
document.querySelector('.email input').addEventListener('blur', checkEmail);
document.querySelector('.password input').addEventListener('blur', checkPassword);
document.querySelector('.confirm_password input').addEventListener('blur', checkConfirmPassword);

document.querySelector('form').addEventListener('submit', checkSignup);
