const handleBtnContact = () => {
    const firstName = document.querySelector('#contact_firstName');
    const divFirstName = document.querySelector('.error-firstName');
    const lastName = document.querySelector('#contact_lastName');
    const divLastName = document.querySelector('.error-lastName');
    const regFL = /^[a-zéèçàâäêëîï]+\-?[a-zéèçàâäêëîï]+$/i;
    const email = document.querySelector('#contact_email');
    const divEmail = document.querySelector('.error-email');
    const regEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    const message = document.querySelector('#contact_message');
    const divMessage = document.querySelector('.error-messageInput');
    const phoneNumber = document.querySelector('#contact_phoneNumber');
    const divPhoneNumber = document.querySelector('.error-phoneNumber');
    const regPhoneNumber = /^[0-9]{4}[\/][0-9]{2}[\/][0-9]{2}[\/][0-9]{2}/;
    let valid = true;

    if(firstName.value === '')
    {
        firstName.style.borderColor = "#D62839";
        divFirstName.innerHTML = "Veuillez indiquer un prénom !";
        valid = false;
    }
    else if(firstName.value.length < 2 || firstName.value.length > 30)
    {
        firstName.style.borderColor = "#D62839";
        divFirstName.innerHTML = "Votre prénom doit contenir un minimum de 2 caractères et un maximum de 30 caractères !";
        valid = false;
    }
    else if(!firstName.value.match(regFL))
    {
        firstName.style.borderColor = "#D62839";
        divFirstName.innerHTML = "Votre prénom ne doit contenir que des lettres !";
        valid = false;
    }
    else
    {
        firstName.style.borderColor = "green";
        divFirstName.innerHTML = "";
    }

    if(lastName.value === '')
    {
        lastName.style.borderColor = "#D62839";
        divLastName.innerHTML = "Veuillez indiquer un nom !";
        valid = false;
    }
    else if(lastName.value.length < 2 || lastName.value.length > 30)
    {
        lastName.style.borderColor = "#D62839";
        divLastName.innerHTML = "Votre nom doit contenir un minimum de 2 caractères et un maximum de 30 caractères !";
        valid = false;
    }
    else if(!lastName.value.match(regFL))
    {
        lastName.style.borderColor = "#D62839";
        divLastName.innerHTML = "Votre nom ne doit contenir que des lettres !";
        valid = false;
    }
    else
    {
        lastName.style.borderColor = "green";
        divLastName.innerHTML = "";
    }

    if(email.value === '')
    {
        email.style.borderColor = "#D62839";
        divEmail.innerHTML = "Veuillez indiquer un email !";
        valid = false;
    }
    else if(!email.value.match(regEmail))
    {
        email.style.borderColor = "#D62839";
        divEmail.innerHTML = "Le format d'email n'est pas correcte !";
        valid = false;
    }
    else
    {
        email.style.borderColor = "green";
        divEmail.innerHTML = "";
    }

    if(message.value === '')
    {
        message.style.borderColor = "#D62839";
        divMessage.innerHTML = "Veuillez indiquer un message !";
        valid = false;
    }
    else if(message.value.length < 20)
    {
        message.style.borderColor = "#D62839";
        divMessage.innerHTML = "Le message doit contenir au minimum 20 caractères !";
        valid = false;
    }
    else
    {
        message.style.borderColor = "green";
        divMessage.innerHTML = "";
    }

    if(phoneNumber.value !== '')
    {
        if(!phoneNumber.value.match(regPhoneNumber))
        {
            phoneNumber.style.borderColor = "#D62839";
            divPhoneNumber.innerHTML = "Veuillez respecter le format demandé !";
            valid = false;
        }
        else
        {
            phoneNumber.style.borderColor = "green";
            divPhoneNumber.innerHTML = "";
        }
    }
    else
    {
        phoneNumber.style.borderColor = "green";
        divPhoneNumber.innerHTML = "";
    }

    return valid;
};


const btnContact = document.getElementById('btnContact');
btnContact.addEventListener('click', handleBtnContact);