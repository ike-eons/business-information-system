import Api from '../../service/api.js'


const state = {
    brands:[]
};

const getters = {
    GET_BRANDS: state => state.brands,
    brand_select_items: state => state.brands.map(c=>c.name)
};

const mutations = {
    SET_BRANDS(state,brands){
        state.brands = brands
    },
    ADD_BRAND(state,brand){
        let brands = state.brands.push(brand);
        state.brands = brands;
    },
    EDIT_BRAND(state,brand){
        state.brands.foreach(b => {
            if(b.id == brand.id){
                b = brand
            }
        })
    },
    DELETE_BRAND(state,brand){
        let brands = state.brands.filter(b => b.id != brand.id);
        state.brands = brands;
    }
};

const actions = {
    async fetch_brands({commit}){
        let response = await Api().get('/brands');
        console.log(response.data.brands);   
        commit('SET_BRANDS',response.data.brands);
    },

    async create_brand({commit},brand){
        let response = await Api().post(`/brands`,brand);
        commit('ADD_BRAND',response.data.brand)
    },
    async edit_brand({commit},brand){
        let response = await Api().put(`/brands/${brand.id}`,brand);
        commit('EDIT_BRAND',brand);
    },
    async delete_brand({commit},brand){
        let response = await Api().delete(`/brands/${brand.id}`);
        commit('DELETE_BRAND',brand);
    }
};

export default {
    namespaced:true,
    state,
    getters,
    mutations,
    actions,
    
}