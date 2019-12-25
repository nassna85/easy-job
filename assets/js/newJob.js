function handleBtnNewJob()
{
    const title = document.querySelector('#job_new_title');
    const divTitle = document.querySelector('.error-title');
    let valid = true;

    if(title.value === '')
    {
        title.style.borderColor = "#D62839";
        divTitle.innerHTML = "Veuillez indiquer un titre à votre offre d'emploi !";
        valid = false;
    }
}

const btnNewJob = document.getElementById('js-btnNewJob');
btnNewJob.addEventListener('click', handleBtnNewJob);
