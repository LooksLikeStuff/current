$(document).ready(function () {
    const FIND_URL = '/tickers/price';

    $('#date').change(fetchPrice);
    $('input[name="ticker_id"]').change(fetchPrice);

    function fetchPrice() {
        let date = $('#date').val();
        let tickerId = $('input[name="ticker_id"]').val();

        if (date && tickerId) {
            $.ajax({
                url: FIND_URL,
                method: 'get',
                data: {
                    'date': date,
                    'ticker_id': tickerId,
                },
                success: function (price) {
                    $('#price').val(price.close ?? price.open).trigger('change');

                },
                error: function (data) {
                    console.log(data);
                },
            });
        }

    }
});
