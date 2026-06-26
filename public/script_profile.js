console.log("ciao");

function mostraErrore(messaggio) {
    const errorBox = document.querySelector('.error-line');
    const errorSpan = errorBox.querySelector('span');
    
    errorSpan.textContent = messaggio;
    errorBox.classList.remove('hidden');
}

function nascondiErrore() {
    const errorBox = document.querySelector('.error-line');
    errorBox.classList.add('hidden');

}

function checkName() {
    const input = document.querySelector('.name input');
    formStatus.name = input.value.length > 0;
    if (formStatus.name) {
        nascondiErrore();
    }
    else {
        mostraErrore("JS: Il nome non può essere vuoto");
    }
}

function checkSurname() {
    const input = document.querySelector('.surname input');
    formStatus.surname = input.value.length > 0;
    if (formStatus.surname) { 
        nascondiErrore();
    }
    else {
        mostraErrore("JS: Il cognome non può essere vuoto");
    }
}

function jsonCheckUsername(json) {
    if (json.exists) {
        formStatus.username = false;
        mostraErrore("JS: Username già in uso");
    } else {
        formStatus.username = true;
        nascondiErrore();
    }
}

function jsonCheckEmail(json) {
    if (json.exists) {
        formStatus.email = false;
        mostraErrore("JS: Email già utilizzata");
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
        mostraErrore("JS: Lo username deve essere compreso tra 1 e 15 caratteri");
    } else {
        nascondiErrore();
        fetch(check_username_url + "?q="+encodeURIComponent(input.value)).then(fetchResponse).then(jsonCheckUsername);
    }    
}

function checkEmail() {
    const emailInput = document.querySelector('.email input');
    if(emailInput.value.length === 0) {
        mostraErrore("JS: Email non valida");
        formStatus.email = false;
    } else {
        nascondiErrore();
        fetch(check_email_url+ "?q="+encodeURIComponent(emailInput.value.toLowerCase())).then(fetchResponse).then(jsonCheckEmail);
    }
}

function checkPassword() {
    const input = document.querySelector('.password input');
    formStatus.password = input.value.length === 0 || input.value.length >= 8;
    if (formStatus.password) {
            nascondiErrore();
    } else {
        mostraErrore("JS: La password deve avere almeno 8 caratteri");
    }
}

function checkConfirmPassword() {
    const confirmInput = document.querySelector('.confirm_password input');
    const passwordInput = document.querySelector('.password input');
    formStatus.confirmPassword = confirmInput.value === passwordInput.value;
    if (formStatus.confirmPassword) {
        nascondiErrore();
    } else {
        mostraErrore("JS: Le password non coincidono");
    }
}

function checkOldPassword() {
    const oldPasswordInput = document.querySelector('.old-password input');
    const newPasswordInput = document.querySelector('.password input');
    
    if (newPasswordInput.value.length > 0 && oldPasswordInput.value.length === 0) {
        formStatus.oldPassword = false;
        mostraErrore("JS: Inserisci la vecchia password per confermare");
    } else {
        formStatus.oldPassword = true;
    }
}

const formStatus = {
    name: true,
    surname: true,
    username: true,
    email: true,
    password: true,
    confirmPassword: true,
    oldPassword: true
};

function checkProfile(event) {

    if (!formStatus.name || !formStatus.surname || !formStatus.username || !formStatus.email || !formStatus.oldPassword || !formStatus.password || !formStatus.confirmPassword) {
        event.preventDefault();
    }
}

document.querySelector('.name input').addEventListener('blur', checkName);
document.querySelector('.surname input').addEventListener('blur', checkSurname);
document.querySelector('.username input').addEventListener('blur', checkUsername);
document.querySelector('.email input').addEventListener('blur', checkEmail);
document.querySelector('.old-password input').addEventListener('blur', checkOldPassword);
document.querySelector('.password input').addEventListener('blur', checkPassword);
document.querySelector('.confirm_password input').addEventListener('blur', checkConfirmPassword);

document.querySelector('form').addEventListener('submit', checkProfile);