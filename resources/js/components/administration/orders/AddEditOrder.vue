<template>
   <div class="form-max-width" v-loading="loading">
        <div class="flexed justify-between  m-b-20">
            <span @click="goBack()" class="flexed align-center pointer">
                <arrow-left-icon size="1.2x" class="m-r-5" />
                <h4 v-if="insertEdit ==='edit'">Edit Order - {{order.name}} </h4>
                <h4 v-else>Add Order</h4>
            </span>
            <el-button size="big" style="background-color:#ff7b50; border-radius:15px;color:white" v-if="insertEdit === 'edit'" @click="editProduct()" :disabled="disableSave">Save</el-button>
            <el-button size="big" style="background-color:#ff7b50; border-radius:15px;color:white" v-else @click="save()">Save</el-button>
        </div>
        <div class="content mt-30">
            <div class="flexed align-center" style="gap:30px;">
                <div class="flexed-column " style="gap:10px;">
                    <span class="label-no-height">Select products</span>
                    <div class="flexed" style="gap:10px">
                        <el-select
                            v-model="selectedProduct"
                            filterable
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
                    </div>
                </div>
                <div class="flexed-column" style="gap:10px;">
                    <span class="label-no-height">Quantity</span>
                    <el-input type="number" v-model="quantity" style="width:160px;" placeholder="quantity"></el-input>
                </div>
                <el-button type="primary" style="min-width: 70px; margin-top:32px;"  :disabled="disableSave" @click="addProduct()">
                    <i class="el-icon-loading" v-if="loadingSearch"></i>
                    <span v-else>Add</span>
                </el-button> 
               
            </div>

            <div class="m-t-30" v-if="order.products.length">
                <el-table
                    :data="order.products"
                    stripe
                    style="width: 100%"
                    class="table mt-50"
                    :default-sort = "{prop: 'name', order: 'ascending'}"
                    header-cell-class-name="table-header"
                    show-summary
                    :summary-method="getSummaries"
  
                    >
                    <el-table-column
                        prop="name"
                        label="Name"
                       
                    >
                    </el-table-column>
                    <el-table-column
                        prop="upc"
                        label="UPC"
                    >
                    </el-table-column>
                    <el-table-column
                        prop="quantity"
                        label="Quantity"   
                    >
                        <template slot-scope="scope">
                            <el-input
                                v-model="scope.row.quantity"
                                placeholder="Qty"
                                style="width: 150px"
                                @input="calculateTotalPrice(scope.row)"
                            />
                        </template>
                    </el-table-column>
                    <el-table-column
                        prop="price"
                        label="Price"
                        :formatter="formatPrice"
                    >
                    </el-table-column>
                    <el-table-column
                        prop="total_amount_per_product"
                        label="Total"
                        :formatter="formatPrice"
                    >
                    </el-table-column>
                   

                </el-table>
            </div>
        </div>
   </div>
</template>

<script>
import {ArrowLeftIcon} from 'vue-feather-icons';
import mixins from '../../../common/mixins';
import VendorServices from '../../../services/vendor.services';
import ProductServices from '../../../services/product.services';
import {generateOrderNumber} from '../../../common/utilities.services'
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
            selectedProduct: null,
            loadingSearch: false,
            products: [],
            vendors: [],
            quantity: 0,
            order: {
                serial_number: null,
                items: 0,
                products: [],
                total_amount: null,
                payment_type: 'in_place',
                guest_id: null,
                employee_id : null
            }

        }
    },
    computed: {
        disableSave(){
            return !this.quantity || this.quantity * 1 === 0 || !this.selectedProduct
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
        addProduct(){
            this.$set(this.selectedProduct, 'quantity', this.quantity)
            let total = this.quantity * 1 * this.selectedProduct.price 
            this.$set(this.selectedProduct, 'total_amount_per_product', total)
            this.order.products.push(this.selectedProduct)
            console.log('order', this.order.products)
            this.resetFields()
            let gid = generateOrderNumber()
            console.log('gid', gid)

        },
        resetFields(){
            this.selectedProduct = null
            this.quantity = null
            this.products = []
        },
        formatPrice(row, column){
            return `$${row[column.property].toFixed(2)}`; 
        },
        getSummaries(param){
             const { columns, data } = param;
            const sums = [];
        
            columns.forEach((column, index) => {
            if (index === 2  ) {
                sums[index] = 'Total Cost';
                return;
            }
            if(index === 1 || index === 0){
                sums[index] = '';
                return;
            }
            const values = data.map(item => Number(item[column.property]));
            if (!values.every(value => isNaN(value))) {
                sums[index] = '$ ' + values.reduce((prev, curr) => {
                const value = Number(curr);
                if (!isNaN(value)) {
                    return prev + curr;
                } else {
                    return prev;
                }
                
                }, 0);
            } else {
                sums[index] = 'N/A';
            }

            this.order.total_amount = (sums[index] * 1).toFixed(2)
        
            });

            return sums;
        },
        calculateTotalPrice(product){

            let total =  product.total_amount_per_product = product.quantity * 1 * product.price
        
            return total
        },
        save(){
            
        }

    }
}
</script>

<style>

</style>