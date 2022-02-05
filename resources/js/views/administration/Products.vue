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
                    <!-- <el-avatar :size="size" src="https://cube.elemecdn.com/3/7c/3ea6beec64369c2642b92c6726f1epng.png"></el-avatar> -->
                    <span class="info-name text">{{product.name}}</span>
                    <span class="info-name text">{{product.upc}}</span>
                    <span class="info-name text">{{product.vendor_id}}</span>
                    <span class="info-name">{{product.price}}$</span>
                    <span class="info-name text">{{product.initial_quantity}}</span>
                </div>
            </div>
        </div>
    
       <el-alert v-if="!loading && filteredProducts && filteredProducts.length === 0"  
            type="info" 
            :closable="false" 
            class="mt-30"
            title="No results found" 
            show-icon
            
        />
  
        <!-- <add-edit-addons v-if="showAddEditAddon" :addon="addon" @close="closeModal()"/> -->
    </div>
    <div v-else>
        <router-view />
    </div>
</template>

<script>
import AddEditAddons from '../../components/administration/addons/AddEditAddons.vue'
import AddonServices from '../../services/addon.services'
import productServices from '../../services/product.services'
    export default {
  components: { AddEditAddons },
        data() {
            return {
                loading: false,
                query: "",
                products: [],
                sortField: null,
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
                    }
                
                })
            },
            editProduct(product){
                this.$router.push({
                    name: 'edit-product',
                    params: {
                        productProp: product,
                        insertEdit: 'edit'
                    }
                })
            },
            getProducts(){
                this.loading = true
                productServices.getProducts().then((res) => {
                    this.products = res.data
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
        },
        beforeMount(){
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
</style>