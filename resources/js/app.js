require('./bootstrap');
import VueRouter from "vue-router";
import router from "./routes";
import Index from "./Index";
import Vuex from 'vuex';
import storeDefinition from "./store";



window.Vue = require("vue");


Vue.use(VueRouter);
Vue.use(Vuex);

const store = new Vuex.Store(storeDefinition);

const app = new Vue({
    el: "#app",
    router,
    store,
    components: {
        "index":Index,
    }
});


