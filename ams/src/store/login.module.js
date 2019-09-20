import axios from "axios"
import { LOGIN_USER } from "./action.type"
import { SET_LOGIN_NOTIFIACTION } from "./mutation.type"
import Vue from 'vue'
import Auth from '../packages/Auth'
import router from '../router'
Vue.use(Auth)
let auth = new Vue()
const state = {
    loginNotification:'',
}

const getters = {
    loginNotification(state){
        return state.loginNotification
    }
}

const actions = {
    [LOGIN_USER]({commit},data) {
        return new Promise((resolve, reject) => {
            axios.post("api/login",data)
            .then(response => {
                auth.$auth.setToken(response.data.access_token, Date.parse(response.data.expires_at.date))
                axios.defaults.headers.common["Authorization"] = 'Bearer '+ response.data.access_token
                router.push("/dashboard")
                resolve(response)
            })
            .catch(error => {
                commit(SET_LOGIN_NOTIFIACTION,error.response.data)
                reject(error)
            });
        });
    },
    
}

const mutations = {
    [SET_LOGIN_NOTIFIACTION](state,payload){
        state.loginNotification = payload
    } 
}
export default {
    state,
    actions,
    mutations,
    getters
};