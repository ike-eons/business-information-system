import Api from '../../service/api.js'


const state = {
    user:{}
};

const getters = {
    GETUSER: state=> state.user
};

const mutations = {
    SETUSER(state,user){
        state.user = user
    }    
};

const actions = {
    async loginUser({commit},user){
        let response = await axios.post("api/user/login",{
                    email:user.email,
                    password:user.password
        })

        if(response.data.access_token){
            //save token
            localStorage.setItem(
                "access_token",response.data.access_token
            )
            window.location.replace('/app')
        }
        console.log(response.data)
    },
    logoutUser(){
        //remove token
        localStorage.removeItem(
            "access_token"
        )
        window.location.replace("/login")
    },
    async fetchUser({commit}){
        let response = await axios.get("api/user/currentUser");
        console.log(response.data);
        commit("SETUSER",response.data.user)
    }
};

export default {
    namespaced:true,
    state,
    getters,
    mutations,
    actions,
    
}