import Api from '../../service/api.js'



const state = {
    invoices:[],
};

const getters = {
    GET_INVOICES: state => state.invoices,
};


const mutations = {
    SET_INVOICES(state,invoices) {
        state.invoices = invoices
    },
    
    ADD_INVOICE(state,invoice){
        let invoices = state.invoices.push(invoice);
        state.invoices = invoices;
    },
    EDIT_INVOICE(state,invoice){
        state.invoices.foreach( i => {
            if(i.id == invoice.id){
                i = invoice
            }
        })
    },
    DELETE_INVOICE(state,invoice){
        let invoices = state.invoices.filter(i => i.id != invoice.id);
        state.invoices = invoices;
    }
};

const actions = {
    async fetch_invoices({commit}) {
        let response = await Api().get('/invoices');    
        console.log(response.data.invoices);         
        commit('SET_INVOICES',response.data.invoices)
    },
    async fetch_invoice_form(){
        let response = await Api().get('/load_invoice_form');
        console.log(response.data.form);
        this.$set(this.$data,'form',response.data.form);
    },
    async create_invoice({commit},invoice){
        let response = await Api().post('/invoices',invoice);
        const saved_invoice = response.data.invoice;
        commit('ADD_INVOICE',saved_invoice);
        console.log(saved_invoice);
        return saved_invoice;
    },
    async edit_invoice({commit},invoice){
        let response = await Api().
                    put(`/invoices/${invoice.id}`,invoice)
                    commit('EDIT_INVOICE',invoice);
    },
    async delete_invoice({commit}, invoice){
        //delete on server
        let response = await Api().delete(`/invoices/${invoice.id}`)
         //delete on state
        commit('DELETE_INVOICE',invoice)
    }

};

export default {
    namespaced:true,
    state,
    getters,
    mutations,
    actions
}