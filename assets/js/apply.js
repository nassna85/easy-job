//Display name of file in input file
$(function(){
    $('.custom-file-input').on('change', e => {
        const inputFile = e.currentTarget;
        $(inputFile).parent().find('.custom-file-label').html(inputFile.files[0].name);
    });
});