import Vue from 'vue';
import Vuex from 'vuex';

import user from './modules/user.js';
import brand from './modules/brand.js';
import category from './modules/category.js';
import customer from './modules/customer.js';
import product from './modules/product.js';
import invoice from './modules/invoice.js';
import stock from './modules/stock.js';
import distributor from './modules/distributor.js'

Vue.use(Vuex);

export default new Vuex.Store({
    modules:{
        user,
        customer,
        brand,
        category,
        product,
        invoice,
        stock,
        distributor
    },
 
});