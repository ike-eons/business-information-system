import Api from '../../service/api.js'

const state = {
    stocks:[]
};

const getters = {
    GET_STOCKS : state => state.stocks
};


const mutations = {
    SET_STOCKS(state,stocks) {
        state.stocks = stocks
    },
    ADD_STOCK(state,stock){
        let stocks = state.stocks.push(stock);
        state.stocks = stocks;
    },
    EDIT_STOCK(state,stock){
        state.stocks.foreach( s => {
            if(s.id == stock.id){
                s = stock
            }
        })
    },
    DELETE_STOCK(state,stock){
        let stocks = state.stocks.filter(s => s.id != stock.id);
        state.stocks = stocks;
    }
    
};

const actions = {
    async fetch_stocks({commit}) {
        let response = await Api().get('/stocks');    
        console.log(response.data.stocks);         
        commit('SET_STOCKS',response.data.stocks)
    },
    async fetch_stock_form(){
        let response = await Api().get('/load_stock_form');
        console.log(response.data.form);
        this.$set(this.$data,'form',response.data.form);
    },
    async create_stock({commit},stock){
        let response = await Api().post('/stocks',stock);
        const saved_stock = response.data.stocks;
        commit('ADD_STOCK',saved_stock);
        // return savedStock;
    },
    async edit_stock({commit},stock){
        let response = await Api().
                    put(`/stocks/${stock.id}`,stock)
                    commit('EDIT_STOCK',stock);
    },
    async delete_stock({commit}, stock){
        //delete on server
        let response = await Api().delete(`/stocks/${stock.id}`)
         //delete on state
        commit('DELETE_STOCK',stock)
    }

};

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
}