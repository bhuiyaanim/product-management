<template>
    <div class="col-sm-12" v-if="isErrors">
        <div class="alert alert-danger" role="alert">
            <ul>
                <li v-for="(item, index) in getErrors" :key="index">
                    {{ item }}
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    import Vue from 'vue'
    Vue.component('store', require('../../store').default);
    Vue.component('actions', require('../../store/action-types').default);

    import store from '../../store'
    import * as actions from '../../store/action-types'

    import { mapGetters } from 'vuex'

    export default {
        computed: {
            getErrors () {
                return store.getters.getErrors
            },
            isErrors () {
                return store.getters.isErrors
            },
            // ...mapGetters({
            //     isErrors: 'getIsErrors',
            //     errors: 'getErrors'
            // })
        },
    }
</script>