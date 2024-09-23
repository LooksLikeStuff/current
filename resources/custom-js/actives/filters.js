$(document).ready(function () {

    $('body').change(function (event) {
       let target = $(event.target).closest('input');

       if (target.is('.filters__item')) {
           let form = $('#filters__form');
           fetchAndDisplayActives(form);
           $('.diagrams__item-pie').trigger('date:change');
       }
    });

    function fetchAndDisplayActives(form) {
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
