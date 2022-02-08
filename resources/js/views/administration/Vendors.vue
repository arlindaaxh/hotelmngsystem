<template>
    <div class="form-max-width" v-if="$route.name === 'vendors'" v-loading="loading">
        <div class="shortcuts-header flexed justify-between">
            <h4>Vendors</h4>
        </div>
        <div class="one-column-list">
            <div class="flexed justify-between m-b-20">
                <el-input class="search-input" size="big" placeholder="Search vendors by name" v-model="query" :style="'max-width:450px'">
                    <i class="el-icon-search el-input__icon" slot="suffix"></i>
                </el-input>
                <div>
                    <el-button size="big" style="background-color:#ff7b50; border-radius:15px;color:white" @click="addEditVendor()">New</el-button>
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
            
            </div>
            <div class="mt-10" v-for="(vendor,index) in filteredVendors" :key="index">
                <div class="card-items-container pointer flexed" @click="addEditVendor(vendor)"> 
                    <span class="info-name text">{{vendor.name}}</span>
                </div>
            </div>
        </div>
    
       <el-alert v-if="!loading && filteredVendors && filteredVendors.length === 0"  
            type="info" 
            :closable="false" 
            class="mt-30"
            title="No results found" 
            show-icon
            
        />

        <add-edit-vendor v-if="showVendorModal" :vendorProp="vendor" @close="showVendorModal = false"/>
  

    </div>
</template>

<script>
import VendorServices from '../../services/vendor.services'
import AddEditVendor from '../../components/administration/vendors/AddEditVendor.vue'
export default {
    components:{
        AddEditVendor
    },
    data() {
        return {
            loading: false,
            query: "",
            vendors: [],
            sortField: null,
            showVendorModal: false,
            vendor: null,
        }
    },
    computed: {
        filteredVendors(){
            return (
                (this.vendors && this.vendors.filter(element => {
                    return (
                        element.name.toLowerCase().match(this.query.toLowerCase())

                    )
                    })
                )    
            )
        }  
    },
    methods: {
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
        addEditVendor(event){
            if(event){
                this.vendor = event
            }
            this.showVendorModal = true
        },
    },
    beforeMount(){
        this.getVendors()
    },
    beforeRouteUpdate(to, from, next){
        if(to.name === 'vendors'){
            this.getVendors()
        
        }
        next()
    }
      


}
</script>

<style>

</style>