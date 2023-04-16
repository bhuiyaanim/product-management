import Vue from 'vue'
Vue.component('actions', require('../../action-types').default);
Vue.component('mutations', require('../../mutation-types').default);
import * as actions from '../../action-types'
import * as mutations from '../../mutation-types'

import Axios from 'axios'

export default {
    [actions.GET_SIZES]({ commit }) {
        Axios.get('/api/sizes')
            .then(res=>{
                if (res.data.success == true) {
                    commit(mutations.SET_SIZES, res.data.data)
                }
            })
            .catch(err=>{
                console.log(err.response);
            })
    }
}
