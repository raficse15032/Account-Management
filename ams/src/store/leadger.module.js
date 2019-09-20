import axios from "axios"
import { CURRENT_LEADGER,SEARCH_LEADGER} from "./action.type"
import { SET_CURRENT_LEADGER} from "./mutation.type"
const state = {
    leadgerdatas:[]
}

const getters = {
    leadgerdatas(state){
        return state.leadgerdatas
    }
}

const actions = {
    [CURRENT_LEADGER]({commit}) {
        return new Promise((resolve, reject) => {
            axios
            .get("api/current-leadger")
            .then(response => {
                
                commit(SET_CURRENT_LEADGER,response.data);
                
                resolve(response);
            })
            .catch(function(error) {
                reject(error);
            });
        });
    },
    [SEARCH_LEADGER]({commit},data) {
        return new Promise((resolve, reject) => {
            console.log(data)
            axios
            .post("api/search-leadger",data)
            .then(response => {
                // console.log(response)
                commit(SET_CURRENT_LEADGER,response.data);
                
                resolve(response);
            })
            .catch(function(error) {
                reject(error);
            });
        });
    },
    
}

const mutations = {
    [SET_CURRENT_LEADGER](state, data) 
    {
        console.log("ok")
        state.leadgerdatas = data;
    } 
}
export default {
    state,
    actions,
    mutations,
    getters
};