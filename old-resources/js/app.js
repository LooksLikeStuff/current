//import eCharts
import * as echarts from 'echarts';
window.echarts = echarts;

// Import all of Bootstrap's JS
import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

//jquery
import $ from 'jquery'
window.jQuery = window.$ = $

//import helpers js
//import '@/helpers/main'


import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

//for images from resources
import.meta.glob([
    '../images/**',
]);


