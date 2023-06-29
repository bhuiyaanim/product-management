import Vue from 'vue'
Vue.component('actions', require('../../action-types').default);
Vue.component('mutations', require('../../mutation-types').default);
import * as actions from '../../action-types'
import * as mutations from '../../mutation-types'

import Axios from 'axios'

export default {
    [actions.SUBMIT_RETURN_PRODUCT]({commit}, payload) {
        Axios.post('/return-products', payload)
        .then(res=>{
            if (res.data.success == true) {
                window.location.href = '/return-products'
            }
        })
        .catch(err=>{
            commit(mutations.SET_ERRORS, err.response.data.error)
        })
    },
}
