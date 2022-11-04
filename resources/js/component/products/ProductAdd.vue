<template>
<form @submit.prevent="submitForm" role="form" action="" method="post">
    <div class="row">
        <show-error></show-error>
        <div class="col-sm-6">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="m-0">Product Category</h5>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Name <span class="text-danger">*</span> </label>
                        <input type="text" v-model="form.name" name="name" class="form-control" placeholder="Enter product name">
                    </div>
                    <div class="form-group">
                        <label>Slug <span class="text-danger">*</span> </label>
                        <input type="text" v-model="form.slug" name="slug" class="form-control" placeholder="Enter product slug">
                    </div>
                    <div class="form-group">
                        <label>Category <span class="text-danger">*</span> </label>
                        <Select2MultipleControl v-model="form.category_id" :options="getCategories" :settings="{ placeholder: 'Select category'}"></Select2MultipleControl>
                    </div>
                    <div class="form-group">
                        <label>Price <span class="text-danger">*</span> </label>
                        <input type="text" v-model="form.price" name="price" class="form-control" placeholder="Enter product price">
                    </div>
                    <div class="form-group">
                        <label>Status <span class="text-danger">*</span> </label>
                        <select class="form-control" v-model="form.status">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Product Image <span class="text-danger">*</span> </label>
                        <input @change="selectProductImages" multiple type="file" class="form-control" placeholder="Upload product image">
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
                    <h5 class="m-0">Product Attributes</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-2" v-for="(item, index) in form.attribute_items" :key="index">
                        <div class="col-sm-4">
                            <select class="form-control" v-model="item.attribute_id">
                                <option value="">Select Attribute</option>
                                <option v-for="(attribute, index) in getAttributes" :key="index" :value="attribute.id">{{ attribute.name }}</option>
                            </select>
                        </div>
                        <div class="col-sm-7">
                            <input type="text" v-model="item.attribute_property" class="form-control" placeholder="Enter Attributes">
                        </div>
                        <div class="col-sm-1">
                            <button @click="deleteAttributeItem(index)" type="button" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                        </div>
                    </div>
                    <button @click="addAttributeItem" type="button" class="btn btn-sm btn-primary mt-3"><i class="fa fa-plus"></i> Add item</button>
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
                    name: '',
                    slug: '',
                    category_id: '',
                    price: '',
                    status: 1,
                    images: [],
                    attribute_items : [
                        {
                            attribute_id: '',
                            attribute_property: ''
                        }
                    ],
                }
            }
        },
        mounted() {
            // get categories
            store.dispatch(actions.GET_CATEGORIES)
            // get attributes
            store.dispatch(actions.GET_ATTRIBUTES)

        },
        computed: {
            getCategories () {
                return store.getters.getCategories
            },
            getAttributes () {
                return store.getters.getAttributes
            },
        },
        methods: {
            // image selector
            selectProductImages(e) {
                let selectedFiles = e.target.files;
                if (!selectedFiles.length) {
                    return false;
                }
                for (let i=0; i < selectedFiles.length; i++) {
                    this.form.images.push(selectedFiles[i])
                }
            },
            // attribute
            addAttributeItem() {
                let attribute_items = {
                        attribute_id: '',
                        attribute_property: ''
                }
                this.form.attribute_items.push(attribute_items)
            },
            deleteAttributeItem(index) {
                this.form.attribute_items.splice(index, 1)
            },
            // submit
            submitForm() {
                let data = new FormData();
                data.append('name', this.form.name)
                data.append('slug', this.form.slug)
                data.append('category_id', JSON.stringify(this.form.category_id))
                data.append('price', this.form.price)
                data.append('status', this.form.status)
                for (let i = 0; i < this.form.images.length; i++) {
                    data.append('product_images[]', this.form.images[i])
                }
                data.append('attribute_items', JSON.stringify(this.form.attribute_items))

                store.dispatch(actions.ADD_PRODUCT, data)
            }
        }

    }
</script>
