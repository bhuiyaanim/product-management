import Vue from 'vue'
Vue.component('mutations', require('../../../mutation-types').default);

import * as mutations from '../../../mutation-types'

export default {
    [mutations.SET_ERRORS](state, payload) {
        state.is_errors = true
        state.errors = payload
    }
}