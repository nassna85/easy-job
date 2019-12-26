function handleBtnNewJob()
{
    const title = document.querySelector('#job_new_title');
    const divTitle = document.querySelector('.error-title');
    const description = document.querySelector('#job_new_description');
    const divDescription = document.querySelector('.error-description');
    const enterprise = document.querySelector('#job_new_enterprise');
    const divEnterprise = document.querySelector('.error-enterprise');
    const place = document.querySelector('#job_new_place');
    const divPlace = document.querySelector('.error-place');
    const category = document.querySelector('#job_new_categories');
    const divCategory = document.querySelector('.error-categories');
    const experience = document.querySelector('#job_new_experience');
    const divExperience = document.querySelector('.error-experience');
    const contract = document.querySelector('#job_new_contract');
    const divContract = document.querySelector('.error-contract');
    const contactPerson = document.querySelector('#job_new_contactPerson');
    const divContactPerson = document.querySelector('.error-contactPerson');
    const emailContact = document.querySelector('#job_new_emailContact');
    const divEmailContact = document.querySelector('.error-emailContact');
    const regEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    let valid = true;

    if(title.value === '')
    {
        title.style.borderColor = "#D62839";
        divTitle.innerHTML = "Veuillez indiquer un titre à votre offre d'emploi !";
        valid = false;
    }
    else if(title.value.length < 5 || title.value.length > 50)
    {
        title.style.borderColor = "#D62839";
        divTitle.innerHTML = "Le titre de votre emploi doit contenir au minimum 5 caractères et au maximum 50 caractères !";
        valid = false;
    }
    else
    {
        title.style.borderColor = "green";
        divTitle.innerHTML = "";
    }

    if(description.value === '')
    {
        description.style.borderColor = "#D62839";
        divDescription.innerHTML = "Veuillez indiquer une description à votre offre d'emploi !";
        valid = false;
    }
    else if(description.value.length < 20)
    {
        description.style.borderColor = "#D62839";
        divDescription.innerHTML = "La description de votre emploi doit contenir au minimum 20 caractères !";
        valid = false;
    }
    else
    {
        description.style.borderColor = "green";
        divDescription.innerHTML = "";
    }

    if(enterprise.value === '')
    {
        enterprise.style.borderColor = "#D62839";
        divEnterprise.innerHTML = "Veuillez indiquer le nom de l'entreprise lié à votre offre d'emploi !";
        valid = false;
    }
    else if(enterprise.value.length < 5 || enterprise.value.length > 50)
    {
        enterprise.style.borderColor = "#D62839";
        divEnterprise.innerHTML = "Le nom de l'entreprise doit contenir au minimum 5 caractères et au maximum 50 caractères !";
        valid = false;
    }
    else
    {
        enterprise.style.borderColor = "green";
        divEnterprise.innerHTML = "";
    }

    if(place.value === '')
    {
        place.style.borderColor = "#D62839";
        divPlace.innerHTML = "Veuillez faire un choix !";
        valid = false;
    }
    else
    {
        place.style.borderColor = "green";
        divPlace.innerHTML = "";
    }

    if(category.value === '')
    {
        category.style.borderColor = "#D62839";
        divCategory.innerHTML = "Veuillez faire un choix !";
        valid = false;
    }
    else
    {
        category.style.borderColor = "green";
        divCategory.innerHTML = "";
    }

    if(experience.value === '')
    {
        experience.style.borderColor = "#D62839";
        divExperience.innerHTML = "Veuillez faire un choix !";
        valid = false;
    }
    else
    {
        experience.style.borderColor = "green";
        divExperience.innerHTML = "";
    }

    if(contract.value === '')
    {
        contract.style.borderColor = "#D62839";
        divContract.innerHTML = "Veuillez faire un choix !";
        valid = false;
    }
    else
    {
        contract.style.borderColor = "green";
        divContract.innerHTML = "";
    }

    if(contactPerson.value === '')
    {
        contactPerson.style.borderColor = "#D62839";
        divContactPerson.innerHTML = "Veuillez indiquer une personne de contact !";
        valid = false;
    }
    else if(contactPerson.value.length < 5 || contactPerson.value.length > 70)
    {
        contactPerson.style.borderColor = "#D62839";
        divContactPerson.innerHTML = "La personne de contact doit contenir au minimum 5 caractères et au maximum 70 caractères!";
        valid = false;
    }
    else
    {
        contactPerson.style.borderColor = "green";
        divContactPerson.innerHTML = "";
    }

    if(emailContact.value === '')
    {
        emailContact.style.borderColor = "#D62839";
        divEmailContact.innerHTML = "Veuillez indiquer un email de contact !";
        valid = false;
    }
    else if(!emailContact.value.match(regEmail))
    {
        emailContact.style.borderColor = "#D62839";
        divEmailContact.innerHTML = "Veuillez indiquer un format d'email correcte !";
        valid = false;
    }
    else
    {
        emailContact.style.borderColor = "green";
        divEmailContact.innerHTML = "";
    }

    return valid;
}

const btnNewJob = document.getElementById('js-btnNewJob');
btnNewJob.addEventListener('click', handleBtnNewJob);
