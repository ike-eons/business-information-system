import Api from '../../service/api.js'



const state = {
    products:[]
};

const getters = {
    GET_PRODUCTS: state => state.products
};

const mutations = {
    SET_PRODUCT(state,products) {
        state.products = products
    },
    ADD_PRODUCT(state,product){
        let products = state.products.push(product);
        state.products = products;
    },
    SEARCH_PRODUCT(state,product){
        state.products = products
    }
};

const actions = {
    async fetch_products({commit}) {
        // const response =await axios.get('/admin/products/loadproducts');
        let response = await Api().get(`/products`);    
        console.log(response);         
        commit('SET_PRODUCT',response.data.products)
    },
    async create_product({commit},product){
        let response = await Api().post(`/products`,product);
        const savedProduct = response.data.products;
        commit('ADD_PRODUCT',savedProduct);
        return savedProduct;
    },
    async search_product({commit}) {
        let response = await Api().get('/products/search');    
        console.log(response);         
        commit('SEARCH_PRODUCT',response.data.products)
    }
};

export default {
    namespaced:true,
    state,
    getters,
    mutations,
    actions
}