<template>
<form @submit.prevent="submitForm" role="form" action="" method="post">
    <div class="row">
        <show-error></show-error>
        <div class="col-sm-6">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="m-0">Return Product</h5>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Product <span class="text-danger">*</span> </label>
                        <Select2MultipleControl @change="selectProduct" v-model="form.product_id" :options="getProducts" :settings="{ placeholder: 'Select product'}"></Select2MultipleControl>
                    </div>
                    <div class="form-group">
                        <label>Date <span class="text-danger">*</span> </label>
                        <input type="date" class="form-control" v-model="form.date">
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-save"></i> Submit</button>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="m-0">Product Size</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr v-for="(item, index) in form.items" :key="index">
                            <td>{{ item.size }}</td>
                            <td>
                                <input class="for-control" v-model="item.quantity" placeholder="Quantity">
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</form>
</template>

<script>
    import Vue from 'vue'
    Vue.component('store', require('../../store').default);
    Vue.component('actions', require('../../store/action-types').default);

    import store from '../../store'
    import * as actions from '../../store/action-types'
    import { mapGetters } from 'vuex'
    import Select2 from 'v-select2-component'
    import Select2MultipleControl from 'v-select2-multiple-component'
    import ShowError from '../utils/ShowError.vue'
    
    export default {
        components: {Select2, Select2MultipleControl, ShowError},
        data(){
            return {
                form: {
                    date: '',
                    product_id: '',
                    items: [],
                }
            }
        },
        mounted() {
            // get products
            store.dispatch(actions.GET_PRODUCTS)
        },
        computed: {
            getProducts () {
                return store.getters.getProducts
            },
        },
        methods: {
            selectProduct (id) {
                this.form.items = []
                if (id != '') {
                    let product = this.getProducts.filter(product => product.id == id)
                    product[0].product_stocks.map(stock => {
                        console.log(stock.size.size);
                        let item = {
                            size : stock.size.size,
                            size_id : stock.size_id,
                            quantity : ''
                        }
                        this.form.items.push(item)
                    })
                }
            },
            // submit
            submitForm() {
                store.dispatch(actions.SUBMIT_RETURN_PRODUCT, this.form)
            }
        }

    }
</script>
    