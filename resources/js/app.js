require('./bootstrap');

require('alpinejs');

window.Vue = require('vue');

Vue.component('theme-switcher', require('./components/ThemeSwitcher.vue').default);

const app = new Vue({
	el: '#app',
});