import {displayErrors} from "@/actives/functions";

$(document).ready(function () {
    $('#createActiveForm').submit(function (event) {
       event.preventDefault();

       $.ajax({
           url: $(this).attr('action'),
           method: $(this).attr('method'),
           data: $(this).serializeArray(),
           success: function () {
               window.location.reload();
           },
           error: function (data) {
               displayErrors(data.responseJSON.errors);
           },
       })
    });

    //when user change input value, it is removing the field errors;
    $('.form-group > input').change(function () {
       let error = $(this).next('.error');
       if (error) error.remove();

       $(this).removeClass('has__error');
    });
});
