import Api from '../../service/api.js'



const state = {
    distributors:[]
};

const getters = {
    GET_DISTRIBUTORS: state => state.distributors
};

const mutations = {
    SET_DISTRIBUTORS(state,distributors) {
        state.distributors = distributors
    },
    ADD_DISTRIBUTOR(state,distributor){
        let distributors = state.distributors.push(distributor);
        state.distributors = distributors;
    },
    EDIT_DISTRIBUTOR(state,distributor){
        state.distributors.foreach( c => {
            if(d.id == distributor.id){
                d= distributor
            }
        })
    },
    DELETE_DISTRIBUTOR(state,distributor){
        let distributors = state.distributors.filter(d=> d.id != distributor.id);
        state.distributors = distributors;
    }
};

const actions = {
    async fetch_distributors({commit}) {

        let response = await Api().get('/distributors');
        console.log(response.data.distributors);         
        commit('SET_DISTRIBUTORS',response.data.distributors)
    },
    async create_distributor({commit},distributor){
        let response = await Api().post('/distributors',distributor);
        const saved_distributor = response.data.distributor;
        // console.log(saved_distributor);
        commit('ADD_DISTRIBUTOR',saved_distributor);
        // return saved_distributor;
    },
    async edit_distributor({commit},distributor){
        let response = await Api().put(`/distributors/${distributor.id}`,distributor);
        commit('EDIT_DISTRIBUTOR',distributor);

    },
    async delete_distributor({commit}, distributor){
        //delete on server
        let response = await Api().delete(`/distributors/${distributor.id}`)
         //delete on state
        commit('DELETE_DISTRIBUTOR',distributor)
    }
};

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
}