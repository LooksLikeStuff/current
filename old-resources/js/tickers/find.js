import {debounce} from "@/helpers/functions";
import {getToken} from "@/helpers/vars";
import {createNotFoundErrorElement, createOptions} from "@/tickers/functions";

const FIND_URL = '/tickers/find';
$(document).ready(function () {
    $('#ticker_id').keyup(debounce((function () {
        let options = $('#ticker__options');
        if (options) options.remove();

        let name = $(this).val();

        $.ajax({
            url: FIND_URL,
            method: 'post',
            data: {
                '_token': getToken(),
                'name': name,
            },
            success: (data) => {
                $(this).parents('.form-group').append(createOptions(data.data));
            },
            error:(data) => {
                // $(this).parents('.form-group').append(createNotFoundErrorElement());
            },
        });

    }), 500));

    $('body').click(function (event) {
        let target = $(event.target);

        if (target.closest('div').parent().is('.ticker__option')) {
            target = $(target).closest('div').parent();

            $('#ticker_id').val(target.attr('data-text'));
            $('input[name="ticker_id"]').val(target.attr('data-value'));

            $('#ticker__options').remove();
        }

    })
});
