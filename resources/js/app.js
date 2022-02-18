/* eslint-disable no-unused-vars */
import Vue from 'vue';
import 'bootstrap';

const files = require.context('./components', true, /\.vue$/i);
files.keys().map((key) => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

// noinspection JSUnusedLocalSymbols
const app = new Vue({
    el: '#app',
});
