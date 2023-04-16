import Vue from 'vue'
Vue.component('actions', require('../../action-types').default);
Vue.component('mutations', require('../../mutation-types').default);
import * as actions from '../../action-types'
import * as mutations from '../../mutation-types'

import Axios from 'axios'

export default {
    [actions.GET_BRANDS]({ commit }) {
        Axios.get('/api/brands')
            .then(res=>{
                if (res.data.success == true) {
                    commit(mutations.SET_BRANDS, res.data.data)
                }
            })
            .catch(err=>{
                console.log(err.response);
            })
    }
}
