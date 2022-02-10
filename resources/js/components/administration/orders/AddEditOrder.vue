<template>
   <div class="form-max-width" v-loading="loading">
        <div class="flexed justify-between  m-b-20">
            <span @click="goBack()" class="flexed align-center pointer">
                <arrow-left-icon size="1.2x" class="m-r-5" />
                <h4 v-if="insertEdit ==='edit'">Edit Order - {{order.name}} </h4>
                <h4 v-else>Add Order</h4>
            </span>
            <el-button size="big" style="background-color:#ff7b50; border-radius:15px;color:white" v-if="insertEdit === 'edit'" @click="editProduct()" :disabled="disableSave">Save</el-button>
            <el-button size="big" style="background-color:#ff7b50; border-radius:15px;color:white" v-else @click="save()" :disabled="disableSave">Save</el-button>
        </div>
        <div class="content mt-30">
            <div class="flexed align-center" style="gap:30px;">
                <div class="flexed-column " style="gap:10px;">
                    <span class="label-no-height">Select products</span>
                    <div class="flexed" style="gap:10px">
                        <el-select
                            v-model="product_ids"
                            filterable
                            multiple
                            clearable
                            remote
                            reserve-keyword
                            placeholder="Search Product"
                            :remote-method="data => searchProduct(data)"
                            :loading="loadingSearch"
                            value-key="id"
                            style="width:400px"
                            :no-data-text="'No data'"
                        >
                            <el-option
                                v-for="item in products"
                                :key="item.id"
                                :label="item.name.length > 30 ? item.name.substr(0,30) + '...' : item.name"
                                :value="item"  
                            >
                            </el-option>
                        </el-select>
                    <!--           :label="item.name.length > 30 ? item.name.substr(0,30) + '...' : item.name"-->


                        <el-button type="primary" style="min-width: 70px;">
                            <i class="el-icon-loading" v-if="loadingSearch"></i>
                            <span v-else>Add</span>
                        </el-button> 
                    </div>
                </div>
                <div class="flexed-column" style="gap:10px;">
                    <span class="label-no-height">Quantity</span>
                    <el-input v-model="quantity" style="width:160px;" placeholder="quantity"></el-input>
                </div>
               
                

            </div>
        </div>
   </div>
</template>

<script>
import {ArrowLeftIcon} from 'vue-feather-icons';
import mixins from '../../../common/mixins';
import VendorServices from '../../../services/vendor.services';
import ProductServices from '../../../services/product.services';
export default {
    mixins: [mixins],
    name: 'AddEditOrder',
    components: {
        ArrowLeftIcon
    },
    props: ['insertEdit'],
    data() {
        return {
            loading: false,
            product_ids: [],
            loadingSearch: false,
            products: [],
            vendors: [],
            quantity: 0,

        }
    },
    computed: {
        disableSave(){
            return !this.quantity || this.quantity * 1 === 0
        }

    },
    methods: {
        goBack(){
            this.$router.push({
                name: 'orders'
            })
        },
        searchProduct(query){
            this.products = [];
            if (!query || query.length === 0) return;
            let obj = {
                keyword: query
            }
        
            this.loadingSearch = true;
            ProductServices.searchProd(obj)
            .then((res) => {
                console.log('here', res.data)
                this.products = res.data;
            })
            .catch((error) => {
                this.catchMethod(error);
            })
            .finally(() => {
                this.loadingSearch = false;
            });
        },
        getVendors(){
            this.loading = true
            VendorServices.getVendors().then((res) => {
                this.vendors = res.data
                
            })
            .catch((error) => {
                this.loading=false;            
                this.catchMethod(error);
            })
            .finally(() => {
                this.loading = false
            })
        },
    
    }
}
</script>

<style>

</style>