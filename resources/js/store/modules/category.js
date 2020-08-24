import Api from '../../service/api.js'


const state = {
  categories:[]
};

const getters = {
   GET_CATEGORIES: state=>state.categories,
   // category_select_items: state => state.categories.map(c=>c)
   // category_items: state=>state.categories.map(c => (name:`${c.name}`))
};

const mutations = {
   SET_CATEGORIES(state,categories){
      state.categories = categories
   }
};

const actions = {
    async fetch_categories({commit}){
      let response = await Api().get(`/categories`)
      console.log(response.data.categories);
      commit('SET_CATEGORIES',response.data.categories);
    }
};

export default {
    namespaced:true,
    state,
    getters,
    mutations,
    actions,
    
}