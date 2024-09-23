import {numberWithSpaces} from "../../functions.js";

const SECTORS_URL = '/api/actives/sectors';
const TICKERS_URL = '/api/actives/tickers';

let sectorsData, tickersData = null;

//fetch data from server
fetchSectors().then(data => sectorsData = data.data);
fetchTickers().then(data => tickersData = data.data);

$(window).on('load', function () {
    let sectorsInterval = setInterval(() => {
        if (sectorsData === null) return;

        initSectorsPie(sectorsData);
        clearInterval(sectorsInterval);
    }, 100);

    let tickersInterval = setInterval(() => {
        if (tickersData === null) return;

        initTickersPie(tickersData);
        clearInterval(tickersInterval);
    }, 100);
});

function initSectorsPie(data) {
    let chartDom = document.getElementById('pie__categories');
    let myChart = echarts.init(chartDom);
    let option;

    option = {
        // title: {
        //     text: 'Соотношение активов по секторам',
        //     left: 'center'
        // },
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
}

function initTickersPie(data) {
    let chartDom = document.getElementById('pie__tickers');
    let myChart = echarts.init(chartDom);
    let option;

    option = {
        // title: {
        //     text: 'Соотношение активов по тикерам',
        //     left: 'center'
        // },
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

