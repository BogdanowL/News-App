require('./bootstrap');
window.Vue = require('vue');

import App from './components/App'
import News from './components/News'
import Validate from './components/Validate'
import Search from './components/Search'

Vue.component('news', News);
Vue.component('validate', Validate);
Vue.component('search', Search);


const app = new Vue({
    el: '#app',
    render: h => h(App)
});
