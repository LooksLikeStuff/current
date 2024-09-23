import {getToken} from "../helpers/vars";

export function displayErrors(errors, prefix = '')
{
    $('.error').remove();
    $('.form-group > input').removeClass('has__error')
    for (let field in errors) {
        //find input field by id
        let input = $(`#${prefix + field}`);

        input.addClass('has__error');
        if (input.is('div')) {
            input.html(`<div class="error">${errors[field][0]}</div>`);
        } else {
            input.parents('.form-group').append(`<div class="error">${errors[field][0]}</div>`);
        }

    }
}

export function createActivesContentComponent(actives, date)
{
    return `<div class="forms">${createActiveFormsComponent(actives)}</div>
            <table class="table actives__table table-vertical-center overflow-hidden table-hover">
                <thead>
                    <tr class="align-middle">
                        <th>Актив</th>
                        <th>Дата</th>
                        <th>Акций</th>
                        <th>Комиссия / Налог</th>
                        <th>Цена за шт.</th>
                        <th>Общая сумма</th>
                        <th>Цена за шт. за ${date}</th>
                        <th>Общая сумма за ${date}</th>
                        <th>% годовых</th>
                        <th>Прибыль</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>${createActivesBodyComponent(actives)}</tbody>
                <tfoot>${createFooterActivesComponent(actives)}</tfoot>
</table>
`;
}

function createActiveFormsComponent(actives) {
    let token = getToken();
    let component = '';

    $(actives).each((index, active) => {
       component += `<form id="form-destroy-${active.id}" action="/actives/destroy/${active.id}" method="post">
                        <input type="hidden" name="_token" value="${token}" autocomplete="off">
                        <input type="hidden" name="_method" value="DELETE">
                    </form>`
    });

    return component;
}

function createActivesBodyComponent(actives) {
    let component = '';

    $(actives).each((index, active) => {
        component +=  `<tr class="align-middle">
                        <td>${active.name} <div class="subname">${active.company}</div></td>
                        <td class="text-nowrap">${active.date}</td>
                        <td class="text-center">${active.quantity}</td>
                        <td class="text-end">${active.commission}</td>
                        <td class="text-end">${active.price}</td>
                        <td class="text-end">${active.start_price}</td>
                        <td class="text-end">>${active.closest_price}</td>
                        <td class="text-end">${active.closest_sum}</td>
                        <td class="text-center"> ${active.year_percent}%</td>
                        <td class="text-end fw-semibold ${$active.is_profit_positive ? 'text-success' : 'text-danger'}">
                            ${active.profit}
                        </td>
                        <td>
                            <a class="link link-danger destroy" data-form-id="form-destroy-${active.id}" data-bs-toggle="modal" data-bs-target="#destroyActiveModal">
                                <img src="/old-resources/images/icons/destroy.svg" alt="destroy">
                            </a>
                        </td>
                       </tr>`
    });

    return component;

}

function createFooterActivesComponent(actives)
{
    return `<tr>
                <th>Итого:</th>
                <th></th>

                <th class="text-center">{{$user->activesQuantity()}}</th>
                <th class="text-end">{{ currency($commission) }}</th>
                <th></th>

                <th class="text-end fw-bold {{ $fullPrice > 0 ? 'text-success' : 'text-danger' }}">
                    {{  currency($fullPrice) }}
                </th>

                <th></th>


                <th class="text-end fw-ibold {{ $fullPriceNow > 0 ? 'text-success' : 'text-danger' }}">
                    {{currency($fullPriceNow)}}</th>

                <th></th>

                <th class="text-end fw-bold {{ $fullProfit > 0 ? 'text-success' : 'text-danger' }}">
                    {{ currency($fullProfit) }}
                </th>
                <th></th>
            </tr>`

}
