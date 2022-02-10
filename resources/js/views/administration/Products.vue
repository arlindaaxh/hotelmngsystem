<template>
    <div class="form-max-width" v-if="$route.name === 'products'" v-loading="loading">
        <div class="shortcuts-header flexed justify-between">
            <h4>Products</h4>
        </div>
        <div class="one-column-list">
            <div class="flexed justify-between m-b-20">
                <el-input class="search-input" size="big" placeholder="Search products by name or upc" v-model="query" :style="'max-width:450px'">
                    <i class="el-icon-search el-input__icon" slot="suffix"></i>
                </el-input>
                <div>
                    <el-button size="big" style="background-color:#ff7b50; border-radius:15px;color:white" @click="addEditProduct()">New</el-button>
                </div>
            </div>
     
<!-- 
            <div class="pl-15 mt-50 table-sort">
                <div class="flexed align-center " style="gap:10px">
                    <strong>Name</strong>
                    <span class="sort-icon-asc-desc pointer flexed-column">
                        <i
                        class="el-icon-caret-top" style="height:10px"
                        @click="sortBy('name', 'asc')"
                        :class="sortField === 'name' && sortOrder === 'asc' ? 'sorted-field-ascending' : 'ascending'"
                        ></i>
                        <i
                        class="el-icon-caret-bottom" 
                        :class="sortField === 'name' && sortOrder === 'desc' ? 'sorted-field-descending' : 'descending'"
                        @click="sortBy('name', 'desc')"
                        ></i>
                    </span>
                </div>
              
                 <div class="flexed align-center " style="gap:10px">
                    <strong>UPC</strong>
                    <span class="sort-icon-asc-desc flexed-column">
                        <i
                        class="el-icon-caret-top" style="height:10px"
                        @click="sortBy('upc', 'asc')"
                        :class="sortField === 'upc' && sortOrder === 'asc' ? 'sorted-field-ascending' : 'ascending'"
                        ></i>
                        <i
                        class="el-icon-caret-bottom" 
                        :class="sortField === 'upc' && sortOrder === 'desc' ? 'sorted-field-descending' : 'descending'"
                        @click="sortBy('upc', 'desc')"
                        ></i>
                    </span>
                </div>
                <div class="flexed align-center " style="gap:10px">
                    <strong>Vendor</strong>
                    <span class="sort-icon-asc-desc flexed-column">
                        <i
                        class="el-icon-caret-top" style="height:10px"
                        @click="sortBy('vendor', 'asc')"
                        :class="sortField === 'vendor' && sortOrder === 'asc' ? 'sorted-field-ascending' : 'ascending'"
                        ></i>
                        <i
                        class="el-icon-caret-bottom" 
                        :class="sortField === 'vendor' && sortOrder === 'desc' ? 'sorted-field-descending' : 'descending'"
                        @click="sortBy('vendor', 'desc')"
                        ></i>
                    </span>
                </div>
                <div class="flexed align-center " style="gap:10px">
                    <strong>Price</strong>
                
                </div>
                 <div class="flexed align-center " style="gap:10px">
                    <strong>Initial Quantity</strong>
                
                </div>
            </div>
            <div class="mt-10" v-for="(product,index) in filteredProducts" :key="index">
                <div class="card-items-container pointer flexed" @click="editProduct(product)"> 
                  
                    <span class="info-name text">{{product.name}}</span>
                    <span class="info-name text">{{product.upc}}</span>
                    <span class="info-name text">{{product.vendor_id}}</span>
                    <span class="info-name">{{product.price}}$</span>
                    <span class="info-name text">{{product.initial_quantity}}</span>
                </div>
            </div>-->
        </div> 

        <el-table
            :data="filteredProducts"
            stripe
            style="width: 100%"
            class="table mt-50 pointer"
            :default-sort = "{prop: 'name', order: 'ascending'}"
            header-cell-class-name="table-header"
            :header-cell-style="tableCellStyle"
            @row-click="editProduct"
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
                prop="vendor_name"
                label="Vendor">
            </el-table-column>
            <el-table-column
                prop="price"
                label="Price">
            </el-table-column>
            <el-table-column
                prop="initial_quantity"
                label="Initial Quantity">
            </el-table-column>
        </el-table>
    
       <el-alert v-if="!loading && filteredProducts && filteredProducts.length === 0"  
            type="info" 
            :closable="false" 
            class="mt-30"
            title="No results found" 
            show-icon
            
        />

    </div>
    <div v-else>
        <router-view />
    </div>
</template>

<script>
import AddEditAddons from '../../components/administration/addons/AddEditAddons.vue'
import AddonServices from '../../services/addon.services'
import productServices from '../../services/product.services';
import VendorServices from '../../services/vendor.services';

    export default {
  components: { AddEditAddons },
        data() {
            return {
                loading: false,
                query: "",
                products: [],
                sortField: null,
                vendors: []
            }
        },
        computed: {
            filteredProducts(){
                return (
                    (this.products && this.products.filter(element => {
                        return (
                           element.name.toLowerCase().match(this.query.toLowerCase()) || element.upc.match(this.query)
                        )
                        })
                    )    
                )
            }  
        },
        methods: {
            addEditProduct(){
                this.$router.push({
                    name: 'add-product',
                    params: {
                        insertEdit: 'add',
                        vendors: this.vendors
                    }
                
                })
            },
            editProduct(row, column, event){
                this.$router.push({
                    name: 'edit-product',
                    params: {
                        productProp: row,
                        insertEdit: 'edit',
                        vendors: this.vendors
                        
                    }
                })
            },
            getProducts(){
                this.loading = true
                productServices.getProducts().then((res) => {
                    this.products = res.data
                    let found = null
                    this.products.forEach(product => {
                        found =  this.vendors.find(v => v.id == product.vendor_id)
                        if(found){
                            this.$set(product,'vendor_name', found.name )
                        }
                      
                    })
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
        
            tableCellStyle({row, column, rowIndex, columnIndex}) {
                return {'color':'#2c3e50'}
            },
            sortBy(field, order) {
                 console.log('field', field)
            
                this.sortField = field;
                this.sortOrder = order;
                if(this.sortOrder === 'asc'){
                    this.sortedObject(this.addons, this.sortField)
                }else {
                    this.sortedObjectDescending(this.addons, this.sortField)
                }
            },
            sortedObject(array, key) {
                return array.sort((a, b) => {
                    let nameA = a[key].toUpperCase();
                    let nameB = b[key].toUpperCase();
                    if (nameA < nameB) {
                        return -1;
                    }
                    if (nameA > nameB) {
                        return 1;
                    }
                    return 0;
                });
            },

            sortedObjectDescending(array, key) {
                return array.sort((a, b) => {
                    let nameA = a[key].toUpperCase();
                    let nameB = b[key].toUpperCase();
                    if (nameA > nameB) {
                        return -1;
                    }
                    if (nameA < nameB) {
                        return 1;
                    }
                    return 0;
                });
            },
            getVendors(){
                this.loading = true
                VendorServices.getVendors().then((res) => {
                    this.vendors = res.data
                  
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
            this.getVendors()
            this.getProducts()

     
        },
        beforeRouteUpdate(to, from, next){
            if(to.name === 'products'){
                this.getProducts()
            
            }
            next()
        }
      
    }
</script>

<style lang="scss" scoped>

.card-items-container{
    display: grid;
    grid-template-columns: 1fr 1fr 1fr 1fr 1fr;

}

.table-sort {
    display: grid;
    padding-right:10px;
    display: grid;
    grid-template-columns: 1fr 1fr 1fr 1fr 1fr;
    align-items: center;
    font-size: 16px;
    justify-content: space-between;
    margin-bottom: 10px;
    padding-left: 15px;
    padding-right: 15px ;
    font-family: 'Mulish', sans-serif;
}

.table{
//   max-height: 600px;
//   overflow:scroll;
  color: #2c3e50 !important;
  font-family: BlinkMacSystemFont, -apple-system, Segoe UI, Roboto, Helvetica, Arial, sans-serif;
  font-size: 14px;
}

.table-header{
    color: black;
}
</style>