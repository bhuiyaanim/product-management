<template>
<form @submit.prevent="submitForm" role="form" action="" method="post">
    <div class="row">
        <show-error></show-error>
        <div class="col-sm-6">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="m-0">Edit Product</h5>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Name <span class="text-danger">*</span> </label>
                        <input type="text" v-model="form.name" name="name" class="form-control" placeholder="Enter product name">
                    </div>
                    <div class="form-group">
                        <label>Category <span class="text-danger">*</span> </label>
                        <Select2MultipleControl v-model="form.category_id" :options="getCategories" :settings="{ placeholder: 'Select category'}"></Select2MultipleControl>
                    </div>
                    <div class="form-group">
                        <label>Brand <span class="text-danger">*</span> </label>
                        <Select2MultipleControl v-model="form.brand_id" :options="getBrands" :settings="{ placeholder: 'Select brand'}"></Select2MultipleControl>
                    </div>
                    <div class="form-group">
                        <label>SKU <span class="text-danger">*</span> </label>
                        <input type="text" v-model="form.sku" name="sku" class="form-control" placeholder="Enter product sku">
                    </div>
                    <div class="form-group">
                        <label>Cost Price ($) <span class="text-danger">*</span> </label>
                        <input type="text" v-model="form.cost_price" name="cost_price" class="form-control" placeholder="Enter product cost price">
                    </div>
                    <div class="form-group">
                        <label>Retail Price ($) <span class="text-danger">*</span> </label>
                        <input type="text" v-model="form.retail_price" name="retail_price" class="form-control" placeholder="Enter product retail price">
                    </div>
                    <div class="form-group">
                        <label>Product Image <span class="text-danger">*</span> </label>
                        <img class="old-image" :src="this.product.product_image">
                        <input @change="selectImage" type="file" class="form-control" placeholder="Upload product image">
                    </div>
                    <div class="form-group">
                        <label>Year <span class="text-danger">*</span> </label>
                        <input type="text" v-model="form.year" name="year" class="form-control" placeholder="Enter product year [EX: 2023]">
                    </div>
                    <div class="form-group">
                        <label>Description <span class="text-danger">*</span> </label>
                        <input type="text" v-model="form.description" name="description" class="form-control" placeholder="Enter product description [Max: 200]">
                    </div>
                    <div class="form-group">
                        <label>Status <span class="text-danger">*</span> </label>
                        <select class="form-control" v-model="form.status">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
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
                    <div class="row mb-2" v-for="(item, index) in form.items" :key="index">
                        <div class="col-sm-4">
                            <select class="form-control" v-model="item.size_id">
                                <option value="">Select Size</option>
                                <option v-for="(size, index) in getSizes" :key="index" :value="size.id">{{ size.size }}</option>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <input type="text" v-model="item.location" class="form-control" placeholder="Enter Size">
                        </div>
                        <div class="col-sm-3">
                            <input type="text" v-model="item.quantity" class="form-control" placeholder="Enter Size">
                        </div>
                        <div class="col-sm-2">
                            <button @click="deleteItem(index)" type="button" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                        </div>
                    </div>
                    <button @click="addItem" type="button" class="btn btn-sm btn-primary mt-3"><i class="fa fa-plus"></i> Add item</button>
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
        props: ['product'],
        data(){
            return {
                form: {
                    name: '',
                    category_id: '',
                    brand_id: '',
                    sku: '',
                    image: '',
                    cost_price: 0,
                    retail_price: 0,
                    year: '',
                    description: '',
                    status: 1,
                    items: [{
                        size_id: '',
                        location: '',
                        quantity: 0,
                    }],
                }
            }
        },
        mounted() {
            // get categories
            store.dispatch(actions.GET_CATEGORIES)
            // get brands
            store.dispatch(actions.GET_BRANDS)
            // get sizes
            store.dispatch(actions.GET_SIZES)

            // set old data
            if(this.product) {
                this.form.name = this.product.name
                this.form.category_id = this.product.category_id
                this.form.brand_id = this.product.brand_id
                this.form.sku = this.product.sku
                this.form.cost_price = this.product.cost_price
                this.form.retail_price = this.product.retail_price
                this.form.year = this.product.year
                this.form.description = this.product.description
                this.form.status = this.product.status
                this.form.items = this.product.product_stocks
            }
        },
        computed: {
            getCategories () {
                return store.getters.getCategories
            },
            getBrands () {
                return store.getters.getBrands
            },
            getSizes () {
                return store.getters.getSizes
            },
        },
        methods: {
            // image selector
            selectImage(e) {
                this.form.image = e.target.files[0]
            },
            // size item
            addItem() {
                let item = {
                    size_id: '',
                    location: '',
                    quantity: 0,
                }
                this.form.items.push(item)
            },
            deleteItem(index) {
                this.form.items.splice(index, 1)
            },
            // submit
            submitForm() {
                let data = new FormData();
                data.append('_method', 'PUT')
                data.append('name', this.form.name)
                data.append('category_id', this.form.category_id)
                data.append('brand_id', this.form.brand_id)
                data.append('sku', this.form.sku)
                data.append('image', this.form.image)
                data.append('cost_price', this.form.cost_price)
                data.append('retail_price', this.form.retail_price)
                data.append('year', this.form.year)
                data.append('description', this.form.description)
                data.append('status', this.form.status)
                data.append('items', JSON.stringify(this.form.items))

                let payLoad = {
                    data: data,
                    id: this.product.id
                }

                store.dispatch(actions.EDIT_PRODUCT, payLoad)
            }
        }

    }
</script>

<style scoped>
    .old-image {
        width: 100px;
    }
</style>