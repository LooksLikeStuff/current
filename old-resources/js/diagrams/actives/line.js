import {numberWithSpaces} from "../functions.js";
import {getToken} from "../../helpers/vars.js";

const PERIOD_URL = '/api/actives/period';
const PERIODS = {
    'all': 'все время',
    'week': 'неделю',
    'month': 'месяц',
    'year': 'год',
};

$(document).ready(function () {
   $('.diagrams__switch-item').click(function (event) {
       event.preventDefault();

       //see if user clicked on active switcher
       if ($(this).hasClass('diagrams__switch-active')) return;

       $('.diagrams__switch-item').removeClass('diagrams__switch-active');
       $(this).addClass('diagrams__switch-active');

       let period = $(this).attr('data-period');
       getActivesByPeriod(period).then(data => {
           initMainLine(data.dates, data.values, period)
       });
   })
});

$(window).on('load', function () {
    let period = $('.diagrams__switch-active').attr('data-period');
    getActivesByPeriod(period).then(data => {
        initMainLine(data.dates, data.values, period);
    });

});

function initMainLine(dates, values, period) {
    let chartDom = document.getElementById('main__line');
    let myChart = echarts.init(chartDom);
    let option;

    option = {
        title: {
            text: `Общая стоимость активов за ${PERIODS[period]}`,
        },
        xAxis: {
            type: 'category',
            data: dates,
        },
        yAxis: {
            type: 'value'
        },
        series: [
            {
                data: values,
                type: 'line',
                triggerLineEvent: true,
            }
        ],

        tooltip: {
            trigger: 'axis',
            formatter: function (params) {
                params = params[0];

                return (
                    params.axisValue +
                    "\n" + ' - ' +
                    numberWithSpaces(params.data.toFixed(2)) + ' ₽'
                );
            },
            axisPointer: {
                animation: false
            }
        }
        // tooltip: {
        //     type: 'income',
        // },
        // // valueFormatter: (value) => numberWithSpaces(value.toFixed(2)) + ' ₽',
        // //     trigger: 'axis',
        //     formatter: function (params) {
        //         return numberWithSpaces(params.data.toFixed(2)) + ' ₽';
        //     },
    };

    option && myChart.setOption(option);
}

function getActivesByPeriod(period = 'year')
{
    const promise = fetch(PERIOD_URL, {
        method: 'POST',
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            period: period,
            '_token': getToken(),
        }),
    });

    return promise.then((response) => {
        if(response.ok) return response.json();

        return response.text().then(text => console.log(text));
    })

        .catch((error) => {
            console.log(error)
        });
}


// function getActivesByPeriod(period = 'week') {
//     $.ajax({
//        url: PERIOD_URL,
//        method: 'POST',
//        data: {
//            period: period,
//            '_token': getToken(),
//        },
//        success: function (data) {
//            console.log(data);
//        },
//         error: function (data) {
//            console.log(data);
//         }
//     });
// }
