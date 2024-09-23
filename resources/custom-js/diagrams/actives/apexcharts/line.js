import {getToken} from "../../../helpers/vars.js";
import {numberWithSpaces} from "../../functions.js";
import {decline} from "../../../helpers/functions.js";
import {DateTime} from "luxon";
import * as ru from "apexcharts/dist/locales/ru.json";

const MOBILE_SCREEN_WIDTH = 768;

const MILLION = 1000000;
const THOUSAND = 1000;

const PERIOD_URL = '/api/actives/period';
const MONTH_PERIOD_URL = '/api/actives/period/month';

const PERIODS = {
    'all': {
        value: 1,
        decline: ['все время', 'все время', 'все время'],
    },
    'day': {
        value: 1,
        decline: ['дней', 'день', 'дня'],
    },
    'week': {
        value: 7,
        decline: ['недель', 'неделю', 'недели'],
    },
    'month': {
        value: 31,
        decline: ['месяцев', 'месяц', 'месяца'],
    },
    'year': {
        value: 365,
        decline: ['лет', 'год', 'года'],
    },
};
const COLORS = getChartColorsArray("revenue-expenses-charts");

const DEFAULT_PERIOD = 'month';
const DEFAULT_PERIOD_AMOUNT = 1;

let line = null;
let diagrams = {};

$(document).ready(function () {
    getActivesForMonth().then(actives => {
        diagrams = {...diagrams, ...actives};
        setDefaultDiagram();

        getActivesForAllPeriods().then(all => diagrams = {...all});
    });


    $('.diagrams__switch-item').click(function (event) {
        event.preventDefault();

        if ($(this).hasClass('diagrams__switch-active')) return;

        let interval = setInterval(() => {
            let period = $(this).attr('data-period');
            let amount = $(this).attr('data-period-amount');

            if(diagrams[period] === undefined || diagrams[period][[amount]] === undefined) return;

            let diagram = diagrams[period][amount]['actives'];
            setTitle(period, amount);

            if ($('.btn-line__diagram-switch').hasClass('line__diagram-percent')) {
                createLineDiagram(diagram['dates'],diagram['percent'],  'Процентное соотношение', true);
            } else {
                createLineDiagram(diagram['dates'], diagram['values']);
            }

            $('.diagrams__switch-item').removeClass('diagrams__switch-active').removeClass('btn-soft-primary').addClass('btn-soft-secondary');
            $(this).addClass('diagrams__switch-active').removeClass('btn-soft-secondary').addClass('btn-soft-primary');


            //clear % btn
            //$('.btn-line__diagram-switch').removeClass('line__diagram-percent').text('Показать в %');
            clearInterval(interval);
        }, 300);

    })

    $('.btn-line__diagram-switch').click(function (event) {
        let period = $('.diagrams__switch-active').attr('data-period');
        let amount = $('.diagrams__switch-active').attr('data-period-amount');

        if(diagrams[period] === undefined || diagrams[period][[amount]] === undefined) return;

        let diagram = diagrams[period][amount]['actives'];
        setTitle(period, amount);

        $(this).toggleClass('line__diagram-percent');

        if ($(this).hasClass('line__diagram-percent')) {
            $(this).text('Показать в ₽');
            createLineDiagram(diagram['dates'], diagram['percent'],  'Процентное соотношение', true);
        } else {
            $(this).text('Показать в %');
            createLineDiagram(diagram['dates'], diagram['values']);
        }
    });
});


function setDefaultDiagram() {
    let interval = setInterval(() => {
        if(diagrams[DEFAULT_PERIOD] === undefined || diagrams[DEFAULT_PERIOD][[DEFAULT_PERIOD_AMOUNT]] === undefined) return;

        let diagram = diagrams[DEFAULT_PERIOD][DEFAULT_PERIOD_AMOUNT]['actives'];
        setTitle(DEFAULT_PERIOD, DEFAULT_PERIOD_AMOUNT);
        createLineDiagram(filterData(diagram['dates']), filterData(diagram['values']));

        clearInterval(interval);
    }, 100);


}


function setTitle(period, amount) {
    let title = 'Общая стоимость активов за ' ;
    if (amount > 1 && period !== 'day') {
        title += amount + ' ';
    }

    if (period === 'day') $('.line__diagram-title').html(title + 'текущий год');

    else $('.line__diagram-title').html(title + decline(amount, PERIODS[period].decline));
}

function createLineDiagram(dates, values, title = 'Сумма портфеля', percent = false) {
    let dateFormat = getDateFormatForDislplay(dates);
    let usedDates = [];
    dates = filterData(dates);
    values = filterData(values);

    let tooltip = {
        enabled: true,
        y: {
            formatter: function(value, { series, seriesIndex, dataPointIndex, w }) {
                return numberWithSpaces(value, 2) + ' ₽'
            }
        },
        x: {
            show: true,
            formatter: function(value, { series, seriesIndex, dataPointIndex, w }) {
                return DateTime.fromMillis(value).setLocale('ru').toFormat('dd MMM, yyyy');
            },
            format: 'dd MMM, yyyy',
        },
    };

    let yaxis = {
        opposite: true,
        labels: {
            offsetX: window.innerWidth > MOBILE_SCREEN_WIDTH ? -30 : 0,
            formatter: (value) => numberWithSpaces(value / getDelimiter(values)),
        },
        title: {
            text: createYaxisTitle(values),
            rotate: 0,
            offsetX: percent ? -33 : -25,
            offsetY: -210,
            style: {
                color: undefined,
                fontSize: '12px',
                fontFamily: 'Helvetica, Arial, sans-serif',
                fontWeight: 600,
                cssClass: 'apexcharts-yaxis-title',
            },
        },
        tooltip: {
            formatter: function(value, { series, seriesIndex, dataPointIndex, w }) {
                return numberWithSpaces(value, 2) + ' ₽'
            }
        },
    };

    if (percent) {
        tooltip['y'] =  {
            formatter: function(value, { series, seriesIndex, dataPointIndex, w }) {
                return value + '%';
            }
        };

        yaxis['labels'] = {};
        yaxis['title']['text'] = '%';
    }

    let options = {
            markers: setMarkerDiscrete(dates),
            series: [
                {
                name: title,
                data: values,
                },
            ],
            chart: {
                height: 450,
                // width: window.innerWidth > MOBILE_SCREEN_WIDTH ? '100%' : '115%',
                type: 'area',
                toolbar: 'true',
                locales: [ru],
                defaultLocale: 'ru',
                // events: {
                //     mounted: function (chartContext, config) {
                //       $('.apexcharts-marker').last().hover();
                //     }
                // }
            },
            dataLabels: {
                enabled: false,
            },
            stroke: {
                curve: 'smooth',
                width: 2,
            },
            tooltip: tooltip,
            xaxis: {
                type: 'numeric',
                categories: dates,

                labels: {
                    offsetX: window.innerWidth > MOBILE_SCREEN_WIDTH ? 5 : -2,
                    formatter: function (value, dateObj) {
                        return DateTime.fromMillis(value).setLocale('ru').toFormat(dateFormat);
                    },
                    showDuplicates: false,
                    datetimeUTC: false,
                    // datetimeFormatter: {
                    //     year: 'yyyy',
                    //     month: 'MMM \'yy',
                    //     day: 'dd MMM',
                    //     hour: 'HH:mm'
                    // },
                    rotate: -90,
                    maxHeight: 150,
                    hideOverlappingLabels: false,
                },
            },
            yaxis: yaxis,
            colors: COLORS,
            fill: {
                opacity: 0.06,
                colors: COLORS,
                type: 'solid'
            }
        };

        if (! (line instanceof ApexCharts)) {
            line = new ApexCharts(document.querySelector("#main__line"), options);
            line.render();
        } else {
            line.updateOptions(options);
        }

        $('#main__line').next('.preloading').remove();
}

function createYaxisTitle(values) {
    let max = Math.max.apply(null, values);

    if (max > MILLION) return 'Млн. ₽';
    if (max > THOUSAND) return 'Тыс. ₽';

    return '  ₽';
}

function getDelimiter(values) {
    let max = Math.max.apply(null, values);

    if (max > MILLION) return MILLION;
    if (max > THOUSAND) return THOUSAND;

    return 1;
}

function getActivesForAllPeriods() {
    let data = {'_token': getToken()};

    let periods = {};
    $('.diagrams__switch-item').each((index, elem) => {
        let period = $(elem).attr('data-period');
        let amount = $(elem).attr('data-period-amount');

        if (period === DEFAULT_PERIOD && amount === DEFAULT_PERIOD_AMOUNT) return;

        periods[index] = {period: period, amount: amount}
    });
    data['periods'] = JSON.stringify(periods);

    const promise = fetch(PERIOD_URL, {
        method: 'POST',
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify(data),
    });

    return promise.then((response) => {
        if(response.ok) return response.json();

        return response.text().then(text => console.log(text));
    })

        .catch((error) => {
            console.log(error)
        });
}
function getActivesForMonth() {
    let data = {'_token': getToken()};

    const promise = fetch(MONTH_PERIOD_URL, {
        method: 'POST',
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify(data),
    });

    return promise.then((response) => {
        if(response.ok) return response.json();

        return response.text().then(text => console.log(text));
    })

        .catch((error) => {
            console.log(error)
        });
}
function setMarkerDiscrete(dates) {
    let purchases = diagrams['purchases'];
    let marker = {
        discrete: [
            // {
            //     seriesIndex: 0,
            //     dataPointIndex: 0,
            //     fillColor: '#008FFBFF',
            //     strokeColor: '#fff',
            //     size: 7,
            //     shape: "circle" // "circle" | "square" | "rect"
            // },
            // {
            //     seriesIndex: 0,
            //     dataPointIndex: dates.length - 1,
            //     fillColor: '#008FFBFF',
            //     strokeColor: '#fff',
            //     size: 5,
            //     shape: "circle" // "circle" | "square" | "rect"
            // }
            ]
    }

    let minDate = Math.min(...dates);
    let filteredPurchases = purchases.filter((elem) => elem >= minDate);

    $(filteredPurchases).each((key, elem) => {
        let index = dates.findIndex((date) => date >= elem);

        if (index !== -1) {
            marker.discrete.push({
                seriesIndex: 0,
                dataPointIndex: index,
                fillColor: '#008FFBFF',
                strokeColor: '#fff',
                size: 5,
                shape: "circle" // "circle" | "square" | "rect"
            })
        }
    });

    console.log(marker);
    return marker;
}
function filterData(data) {
    let indexedData = data;

    let step = 1;
    if(window.innerWidth < MOBILE_SCREEN_WIDTH) step = Math.round(data.length / 20);
    else if (data.length >= 365) step = 30;
    else if(data.length >= 180) step = 4;
    else if(data.length >= 90) step = 2;

    let lastIndex = indexedData.length - 1;
    indexedData = indexedData.filter((value, index) => index === 0 || index === lastIndex || index % step === 0);

    return indexedData;
}

function getDateFormatForDislplay(dates)
{
    let length = dates.length;

   // if (length > 365) return 'yyyy';
   if (length > 90) return 'LLL yy';

   return 'dd MMM';

    //     year: 'yyyy',
    //     month: 'MMM \'yy',
    //     day: 'dd MMM',
    //     hour: 'HH:mm'
}
