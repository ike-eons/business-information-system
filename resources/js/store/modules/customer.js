import Api from '../../service/api.js'



const state = {
    customers:[]
};

const getters = {
    GET_CUSTOMERS: state => state.customers
};

const mutations = {
    SET_CUSTOMERS(state,customers) {
        state.customers = customers
    },
    ADD_CUSTOMER(state,customer){
        let customers = state.customers.push(customer);
        state.customers = customers;
    },
    EDIT_CUSTOMER(state,customer){
        state.customers.foreach( c => {
            if(c.id == customer.id){
                c= customer
            }
        })
    },
    DELETE_CUSTOMER(state,customer){
        let customers = state.customers.filter(c=> c.id != customer.id);
        state.customers = customers;
    }
};

const actions = {
    async fetch_customers({commit}) {
         let response = await Api().get('/customers'); 
        console.log(response.data.customers);         
        commit('SET_CUSTOMERS',response.data.customers)
    },
    async create_customer({commit},customer){
        let response = await Api().post('/customers',customer);
        const saved_customer = response.data.customer;
        console.log(saved_customer);
        commit('ADD_CUSTOMER',saved_customer);
        return saved_customer;
    },
    async edit_customer({commit},customer){
        let response = await Api().put(`/customers/${customer.id}`,customer);
        commit('EDIT_CUSTOMER',customer);

    },
    async delete_customer({commit}, customer){
        //delete on server
        let response = await Api().delete(`/customers/${customer.id}`)
         //delete on state
        commit('DELETE_CUSTOMER',customer)
    }
};

export default {
    state,
    getters,
    mutations,
    actions
}