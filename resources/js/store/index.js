import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)


// Modules
import errors from './modules/utils/errors'
import categories from './modules/categories'
import attributes from './modules/attributes'
import products from './modules/products'

export default new Vuex.Store({
    modules: {
        errors,
        categories,
        attributes,
        products
    }
})
