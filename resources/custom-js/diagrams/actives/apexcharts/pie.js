import {numberWithSpaces} from "../../functions.js";
import {getToken} from "../../../helpers/vars.js";

const SECTORS_URL = '/api/actives/sectors';
const TICKERS_URL = '/api/actives/tickers';
const COLORS = getChartColorsArray("user_device_pie_charts");

let sectorsPie,tickersPie = null;

$(document).ready(function () {
    fetchSectors().then(data => createSectorsPie(data.data));
    fetchTickers().then(data => createTickersPie(data.data));


    //remove select from pie sector when click out
    $('body').click(function (event) {

        if (! $(event.target).closest('g').is('.apexcharts-series')) {
            let  allEls = document.getElementsByClassName('apexcharts-pie-area');
            Array.prototype.forEach.call(allEls, function (pieSlice) {
                pieSlice.setAttribute('data:pieClicked', 'false');
                let origPath = pieSlice.getAttribute('data:pathOrig');
                if (origPath) {
                    pieSlice.setAttribute('d', origPath);
                }

                pieSlice.removeAttribute('filter');
            });
        }

    });



    $('body').change(function (event) {
        let target = $(event.target).closest('input');

        if (target.is('.filters__item')) {
            let date = target.val();

            fetchSectors(date).then(data => createSectorsPie(data.data));
            fetchTickers(date).then(data => createTickersPie(data.data));
        }
    });

});

function fetchSectors(date = null) {

    return fetch(SECTORS_URL, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            date: date,
            '_token': getToken(),
        })
    })
        .then((response) => {
        if (response.ok) {
            return response.json();
        }
             return new Error('Something went wrong!');
            // return response.text().then(text => console.log(text));
    })
        .catch((error) => {
            console.log(error)
        });
}

function fetchTickers(date = null) {

    return fetch(TICKERS_URL, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            date: date,
            '_token': getToken(),
        })
    })
        .then((response) => {
        if (response.ok) {
            return response.json();
        }
            return new Error('Something went wrong!');
            // return response.text().then(text => console.log(text));
    })
        .catch((error) => {
            console.log(error)
        });
}


function createSectorsPie(data) {
        let options = {
            series: Array.from(data).map((el) => el.value),
            labels: Array.from(data).map((el) => el.name),
            chart: {
                type: "donut",
                height: 300,
                events: {
                    dataPointSelection: undefined,
                }
            },
            plotOptions: {
                pie: {
                    size: 100,
                    donut: {
                        size: "75%",
                    },
                },
            },
            dataLabels: {
                enabled: false,
            },
            legend: {
                show: true,
                position: 'bottom',
                horizontalAlign: 'center',
                offsetX: 0,
                offsetY: 0,
                markers: {
                    width: 20,
                    height: 6,
                    radius: 2,
                },
                itemMargin: {
                    horizontal: 12,
                    vertical: 0
                },
            },
            stroke: {
                width: 0
            },
            yaxis: {
                labels: {
                    formatter: (value) => numberWithSpaces(value.toFixed(2)) + ' ₽',
                },
                tickAmount: 4,
                min: 0
            },
            colors: COLORS,
        };

        if (! (sectorsPie instanceof ApexCharts)) {
            sectorsPie = new ApexCharts(document.getElementById('pie__categories'), options);
            sectorsPie.render();
            $('#pie__categories').next('.preloading').remove();
            return;
        }

        sectorsPie.updateOptions(options);
}

function createTickersPie(data) {
    let options = {
        series: Array.from(data).map((el) => el.value),
        labels: Array.from(data).map((el) => el.name),
        chart: {
            type: "donut",
            height: 300,
            events: {
                dataPointSelection: undefined,
            }
        },
        plotOptions: {
            pie: {
                size: 100,
                donut: {
                    size: "75%",
                },
            },
        },
        dataLabels: {
            enabled: false,
        },
        legend: {
            show: true,
            position: 'bottom',
            horizontalAlign: 'center',
            offsetX: 0,
            offsetY: 0,
            markers: {
                width: 20,
                height: 6,
                radius: 2,
            },
            itemMargin: {
                horizontal: 12,
                vertical: 0
            },
        },
        stroke: {
            width: 0
        },
        yaxis: {
            labels: {
                formatter: (value) => numberWithSpaces(value.toFixed(2)) + ' ₽',
            },
            tickAmount: 4,
            min: 0
        },
        colors: COLORS,
    };

    if (! (tickersPie instanceof ApexCharts)) {
        tickersPie =new ApexCharts(document.getElementById('pie__tickers'), options);
        tickersPie.render();
        $('#pie__tickers').next('.preloading').remove();
        return;
    }

    tickersPie.updateOptions(options);
}
