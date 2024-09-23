import {numberWithSpaces} from "../functions.js";

const SECTORS_URL = '/api/actives/sectors';
const TICKERS_URL = '/api/actives/tickers';

$(window).on('load', function () {
    fetchSectors().then(data => initSectorsPie(data.data));
    fetchTickers().then(data => initTickersPie(data.data));
});

function initSectorsPie(data) {
    let chartDom = document.getElementById('pie__categories');
    let myChart = echarts.init(chartDom);
    let option;

    option = {
        title: {
            text: 'Соотношение активов по секторам',
            left: 'center'
        },
        tooltip: {
            trigger: 'item'
        },
        legend: {
            orient: 'vertical',
            left: 'left'
        },
        series: [
            {
                name: 'Cтоимость сектора',
                type: 'pie',
                radius: '50%',
                data: data,
                emphasis: {
                    itemStyle: {
                        shadowBlur: 10,
                        shadowOffsetX: 0,
                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                    }
                }
            }
        ],
        valueFormatter: (value) => numberWithSpaces(value.toFixed(2)) + ' ₽',
    };

    option && myChart.setOption(option);

    $('#pie__categories').next('.preloading').remove();
}

function initTickersPie(data) {
    let chartDom = document.getElementById('pie__tickers');
    let myChart = echarts.init(chartDom);
    let option;

    option = {
        title: {
            text: 'Соотношение активов по тикерам',
            left: 'center'
        },
        tooltip: {
            trigger: 'item'
        },
        legend: {
            orient: 'vertical',
            left: 'left'
        },
        series: [
            {
                name: 'Cтоимость тикера',
                type: 'pie',
                radius: '50%',
                data: data,
                emphasis: {
                    itemStyle: {
                        shadowBlur: 10,
                        shadowOffsetX: 0,
                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                    }
                }
            }
        ],
        valueFormatter: (value) => numberWithSpaces(value.toFixed(2)) + ' ₽',
    };

    option && myChart.setOption(option);
    $('#pie__tickers').next('.preloading').remove();
}


function fetchSectors() {
    return fetch(SECTORS_URL).then((response) => {
        if (response.ok) {
            return response.json();
        }
        throw new Error('Something went wrong');
    })
        .catch((error) => {
            console.log(error)
        });
}

function fetchTickers() {
    return fetch(TICKERS_URL).then((response) => {
        if (response.ok) {
            return response.json();
        }
        throw new Error('Something went wrong');
    })
        .catch((error) => {
            console.log(error)
        });
}

