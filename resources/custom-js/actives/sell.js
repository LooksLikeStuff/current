import {displayErrors} from "./functions.js";

$(document).ready(function () {

    const TOKEN = $(`meta[name="token"]`).attr('content');

    //when user change input value, it is removing the field errors;
    $('#sellActiveForm > input').change(function () {
        let error = $(this).next('.error');
        if (error) error.remove();

        $(this).removeClass('has__error');
    });

    $(`#sellActiveForm > input[name='ticker_id']`).change(function () {
        let value = $(this).val();
        let quantityLabel = $('#available_quantity');

        if (value != '') {
            $.ajax({
                url: `/api/actives/${value}/quantity`,
                method: 'post',
                data: {
                    '_token': TOKEN,
                },
                success: function (data) {
                    quantityLabel.text(`Количество (Максимум - ${data.quantity}):`);
                },
                error: function (data) {
                    console.log(data);
                },
            })
        } else {
            quantityLabel.text("Количество:");
        }
    });

    $('#sellActiveForm').submit(function (event) {
        event.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            data: $(this).serializeArray(),
            success: function () {
                window.location.reload();
            },
            error: function (data) {
                displayErrors(data.responseJSON.errors, 'sell_');
            },
        })
    });

});
