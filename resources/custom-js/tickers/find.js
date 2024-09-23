import {getToken} from "../helpers/vars.js";
import {createOptions, createOptionsForSell} from "./functions.js";
import {debounce} from "../helpers/functions.js";


const FIND_URL = '/tickers/find';
const SELL_FIND_URL = '/tickers/find/sell';
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
                console.log(data);
                // $(this).parents('.form-group').append(createNotFoundErrorElement());
            },
        });

    }), 500));

    $('#sell_ticker_id').keyup(debounce((function () {
        let options = $('#sell_ticker__options');
        if (options) options.remove();

        let name = $(this).val();

        $.ajax({
            url: SELL_FIND_URL,
            method: 'post',
            data: {
                '_token': getToken(),
                'name': name,
            },
            success: (data) => {
                $(this).parents('.form-group').append(createOptionsForSell(data.data));
            },
            error:(data) => {
                console.log(data);
                // $(this).parents('.form-group').append(createNotFoundErrorElement());
            },
        });

    }), 500));

    $('body').click(function (event) {
        let target = $(event.target);

        if (target.closest('div').parent().is('.ticker__option')) {
            target = $(target).closest('div').parent();

            let form = target.parents('form')[0];

            $(form).find('.ticker_id').val(target.attr('data-text'));
            $(form).find('input[name="ticker_id"]').val(target.attr('data-value')).trigger('change');
            // $('#ticker_id').val(target.attr('data-text'));
            // $('input[name="ticker_id"]').val(target.attr('data-value')).trigger('change');
            //$('#ticker__options').remove();
            $(form).find('.list').remove();
        }

    })
});
