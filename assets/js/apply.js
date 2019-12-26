$(function(){
    //Display name of file in input file

    $('.custom-file-input').on('change', e => {
        const inputFile = e.currentTarget;
        $(inputFile).parent().find('.custom-file-label').html(inputFile.files[0].name);
    });

    //validation

    $("#js-btnApplyJob").on('click', function(){
        const phoneNumber = $("#apply_phoneNumber");
        const divPhoneNumber = $(".error-phoneNumber");
        const cv = $("#apply_cvResume");
        const divCv = $(".error-cvResume");
        const coverLetter = $("#apply_coverLetter");
        const divCoverLetter = $(".error-coverLetter");
        let valid = true;

        if(phoneNumber.val() === '')
        {
            $(phoneNumber).css('borderColor', "#D62839");
            $(divPhoneNumber).text("Veuillez indiquer votre numéro de téléphone !");
            valid = false;
        }
        else if(!phoneNumber.val().match(/^[0-9]{4}[\/][0-9]{2}[\/][0-9]{2}[\/][0-9]{2}/))
        {
            $(phoneNumber).css('borderColor', "#D62839");
            $(divPhoneNumber).text("Veuillez respecter le format demandé !");
            valid = false;
        }
        else
        {
            $(phoneNumber).css('borderColor', "green");
            $(divPhoneNumber).text("");
        }

        if(cv.val() === '')
        {
            $(cv).css('borderColor', "#D62839");
            $(divCv).text("Veuillez insérer votre CV !");
            valid = false;
        }
        else
        {
            $(cv).css('borderColor', "green");
            $(divCv).text("");
        }

        if(coverLetter.val() === '')
        {
            $(coverLetter).css('borderColor', "#D62839");
            $(divCoverLetter).text("Veuillez insérer votre lettre de motivation !");
            valid = false;
        }
        else
        {
            $(coverLetter).css('borderColor', "green");
            $(divCoverLetter).text("");
        }
        return valid;
    });
});