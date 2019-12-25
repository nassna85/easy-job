function handleClickBtnRegistrationUser()
{
    const firstName = document.querySelector('#user_registration_firstName');
    const divFirstName = document.querySelector('.error-firstName');
    const lastName = document.querySelector('#user_registration_lastName');
    const divLastName = document.querySelector('.error-lastName');
    const regFL = /^[a-zéèçàâäêëîï]+\-?[a-zéèçàâäêëîï]+$/i;
    const email = document.querySelector('#user_registration_email');
    const divEmail = document.querySelector('.error-email');
    const regEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    const userType = document.querySelector('#user_registration_type');
    const divUserType = document.querySelector('.error-type');
    const password = document.querySelector('#user_registration_password');
    const divPassword = document.querySelector('.error-password');
    const passwordConfirm = document.querySelector('#user_registration_passwordConfirm');
    const divPasswordConfirm = document.querySelector('.error-passwordConfirm');
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

    if(userType.value === '')
    {
        userType.style.borderColor = "#D62839";
        divUserType.innerHTML = "Veuillez séléctionnez un choix !";
        valid = false;
    }
    else
    {
        userType.style.borderColor = "green";
        divUserType.innerHTML = "";
    }

    if(password.value === '')
    {
        password.style.borderColor = "#D62839";
        divPassword.innerHTML = "Veuillez indiquer un mot de passe !";
        valid = false;
    }
    else if(password.value.length < 6 || password.value.length > 12)
    {
        password.style.borderColor = "#D62839";
        divPassword.innerHTML = "Votre mot de passe doit être compris entre 6 et 12 caractères !";
        valid = false;
    }
    else
    {
        password.style.borderColor = "green";
        divPassword.innerHTML = "";
    }

    if(passwordConfirm.value === '')
    {
        passwordConfirm.style.borderColor = "#D62839";
        divPasswordConfirm.innerHTML = "Veuillez indiquer un mot de passe de confirmation !";
        valid = false;
    }
    else if(passwordConfirm.value !== password.value)
    {
        passwordConfirm.style.borderColor = "#D62839";
        divPasswordConfirm.innerHTML = "Vos deux mots de passe ne correspondent pas !";
        valid = false;
    }
    else
    {
        passwordConfirm.style.borderColor = "green";
        divPasswordConfirm.innerHTML = "";
    }

    return valid;
}

const btnRegistrationUser = document.getElementById('js-btn-registration-user');

btnRegistrationUser.addEventListener('click', handleClickBtnRegistrationUser);