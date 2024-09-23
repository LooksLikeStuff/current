$(document).ready(function () {
    let form = $('#filters__form');

    $('.filters__toggle').click(function (event) {
        $(this).next('.filters__body').toggleClass('d-none');
    });

    $('.filters__item').change(function () {
        fetchAndDisplayActives();
    });

    function fetchAndDisplayActives() {
       $.ajax({
           url: form.attr('action'),
           method: form.attr('method'),
           data: form.serializeArray(),
           success: function (data) {
              $('.actives__content').html(data);
           },
           error: function (data) {
               console.log(data);
           }
       })
    }
});
