import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap/dist/js/bootstrap.min.js'
require('../css/app.css');

import jquery from 'jquery';
import Vue from 'vue/dist/vue.js';

const $ = jquery;

global.$ = global.jquery = $;



let vm = new Vue( {
    el: '#app',
    data: {
        message:"about",
    },
    delimiters:['%', '%']
} );
