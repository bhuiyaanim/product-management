import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)


// Modules
import errors from './modules/utils/errors'
import categories from './modules/categories'
import brands from './modules/brands'
import sizes from './modules/sizes'
import products from './modules/products'
import stocks from './modules/stocks'

export default new Vuex.Store({
    modules: {
        errors,
        categories,
        brands,
        sizes,
        products,
        stocks,
    }
})
