$(document).ready(function (){
    let formId;

    $('body').click(function (event) {
        let target = $(event.target);

        if (target.closest('a').is('.destroy')) {
            event.preventDefault();
            formId = $(target.closest('a')).attr('data-form-id');
        }
        else if(target.closest('button').is('.destroy__confirm')) {
            $("#" + formId).submit();
        }
    });
});
