<template>
   <div class="form-max-width" v-loading="loading">
        <div class="flexed justify-between  m-b-20">
            <span @click="goBack()" class="flexed align-center pointer">
                <arrow-left-icon size="1.2x" class="m-r-5" />
                <h4 v-if="insertEdit ==='edit'">Edit Product - {{product.name}} </h4>
                <h4 v-else>Add Product</h4>
            </span>
            <el-button size="big" style="background-color:#ff7b50; border-radius:15px;color:white" v-if="insertEdit === 'edit'" @click="editProduct()">Save</el-button>
            <el-button size="big" style="background-color:#ff7b50; border-radius:15px;color:white" v-else @click="save()">Save</el-button>
        </div>

        <div class="content mt-30">
            <el-form
                ref="add-edit-product-form"
                :model="product"
                :rules="rules"
                size="medium"
                :hide-required-asterisk="true"
                class="form-data"
                label-position="top"

            >
                <el-form-item prop="name" label="Name">
                    <el-input name="type" v-model="product.name"  placeholder="Enter product name" style="width:100%" size="big"></el-input>
                </el-form-item>
                

                <el-form-item prop="upc" label="Upc">
                    <el-input  name="upc" v-model="product.upc" size="big"></el-input>
                </el-form-item>

                <el-form-item prop="price" label="Price">
                    <el-input  name="price" v-model="product.price" size="big"></el-input>
                </el-form-item>

                <el-form-item prop="vendor_id" label="Vendor">
                    <el-select v-model="product.vendor_id"  placeholder="Select vendor for product" style="width:100%" size="big">
                        <el-option
                            v-for="vendor in vendors"
                            :key="vendor.value"
                            :label="vendor.label"
                            :value="vendor.id"
                            >
                        </el-option>
                    </el-select>
                </el-form-item>

                <el-form-item prop="initial_quantity" label="Initial Quantity">
                    <el-input  name="initial_quantity" v-model="product.initial_quantity" size="big"></el-input>
                </el-form-item>

            </el-form>
        </div>
   </div>
</template>

<script>
import {ArrowLeftIcon} from 'vue-feather-icons';
import productServices from '../../../services/product.services';
import ProductServices from '../../../services/product.services'
export default {
    name: 'AddEditProduct',
    components: {
        ArrowLeftIcon
    },
    props: ['productProp', 'insertEdit'],
    data(){
        return{
            loading: false, 
            product: {
                id: null,
                name: null,
                upc: null,
                price: null,
                initial_quantity: 1,
                vendor_id: null,
            },
            rules: {
                name: [
                    {
                        required: true,
                        message: "Field is required",
                        trigger: "change",
                    },
                    {
                        max: 255,
                        message: "Maximum characters allowed is 255",
                        trigger: "change",
                    },
                ],
            }
        }
    },
    methods: {
        goBack(){
            this.$router.push({
                name: 'products'
            })
        },
        save() {
            this.$refs['add-edit-product-form'].validate((valid) => {
                if(valid){
                    this.loading = true
                    this.product.vendor_id = 1;
                    ProductServices.postProduct(this.product).then((res) => {
                        this.$notify.success({
                            title: 'Success',
                            type: 'Success',
                            message: 'Product was added successfully'
                        })
                        this.goBack()
                    })  
                    .catch((error) => {
                        this.loading=false
                        let errorMessage = error?.data?.message ||
                        error?.message ||
                        error?.response?.message ||
                        error?.response?.data?.message
                        if(!errorMessage && error?.data){
                        errorMessage =  error.data
                        }
                        if(!errorMessage) errorMessage = 'Error_occurred'
                        this.$notify.error({
                            title: error?.status || error?.response?.status,
                            message: errorMessage,
                        });
                    })
                    .finally(() => {
                        this.loading = false
                    })
                }
            })
           

        },
        editProduct(){
            this.loading = true
          
            this.product.vendor_id = 1;
            productServices.putProduct(this.product, this.product.id).then((res) => {
                this.$notify.success({
                    title: 'Success',
                    type: 'Success',
                    message: 'Product was updated successfully'
                })
                this.goBack()
            })
            .catch((error) => {
                this.loading=false
                let errorMessage = error?.data?.message ||
                error?.message ||
                error?.response?.message ||
                error?.response?.data?.message
                if(!errorMessage && error?.data){
                errorMessage =  error.data
                }
                if(!errorMessage) errorMessage = 'Error_occurred'
                this.$notify.error({
                    title: error?.status || error?.response?.status,
                    message: errorMessage,
                });
            })
            .finally(() => {
                this.loading = false
            })
        },

    },
    beforeMount(){
        if(!this.insertEdit){
            this.goBack()
        }
        else {
            if(this.insertEdit === 'edit'){
                this.product = {...this.productProp}
            }
        }
    }
}
</script>

<style>

</style>