<template>
    <div class="form-max-width" v-if="$route.name === 'products'" v-loading="loading">
        <div class="shortcuts-header flexed justify-between">
            <h4>Products</h4>
        </div>
        <div class="one-column-list">
            <div class="flexed justify-between m-b-20">
                <el-input class="search-input" size="big" placeholder="Search products by name" v-model="query" :style="'max-width:450px'">
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
                    <strong>Price</strong>
                    <span class="sort-icon-asc-desc flexed-column">
                        <i
                        class="el-icon-caret-top" style="height:10px"
                        @click="sortBy('code', 'asc')"
                        :class="sortField === 'code' && sortOrder === 'asc' ? 'sorted-field-ascending' : 'ascending'"
                        ></i>
                        <i
                        class="el-icon-caret-bottom" 
                        :class="sortField === 'code' && sortOrder === 'desc' ? 'sorted-field-descending' : 'descending'"
                        @click="sortBy('code', 'desc')"
                        ></i>
                    </span>
                </div>
            </div>
            <!-- <div class="mt-10" v-for="(addon,index) in filteredAddons" :key="index">
                <div class="card-items-container pointer flexed" @click="editAddon(addon)">  -->
                    <!-- <el-avatar :size="size" src="https://cube.elemecdn.com/3/7c/3ea6beec64369c2642b92c6726f1epng.png"></el-avatar> -->
                    <!-- <span class="info-name text">{{addon.name}}</span>
                    <span class="info-name">{{addon.price}}$</span>
                </div>
            </div> -->
        </div>
    
       <el-alert v-if="!loading"  
            type="info" 
            :closable="false" 
            class="mt-30"
            title="No results found" 
            show-icon
            
        />
  
        <!-- <add-edit-addons v-if="showAddEditAddon" :addon="addon" @close="closeModal()"/> -->
    </div>
</template>

<script>
import AddEditAddons from '../../components/administration/addons/AddEditAddons.vue'
import AddonServices from '../../services/addon.services'
    export default {
  components: { AddEditAddons },
        data() {
            return {
                loading: false,
                query: "",
                addons: [],
                showAddEditAddon: false,
                addon: null,
                sortField: null,
            }
        },
        computed: {
            filteredAddons(){
                return (
                    (this.addons && this.addons.filter(element => {
                        return (
                           element.name.toLowerCase().match(this.query.toLowerCase())

                        )
                        })
                    )    
                )
            }  
        },
        methods: {
            getAddons(){
                this.loading = true
                AddonServices.getAddons().then((res) => {
                    this.addons = res.data
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
            closeModal(){
                this.showAddEditAddon = false
                this.getAddons()
            },
            addEditAddon(event){
                if(event){
                    this.addon = event
                }
                this.showAddEditAddon = true
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
            this.getAddons()
        },
        beforeRouteUpdate(to, from, next){
            if(to.name === 'addons'){
                this.getAddons()
            
            }
            next()
        }
      
    }
</script>

<style lang="scss" scoped>

.card-items-container{
    display: grid;
    grid-template-columns: 1fr 1fr 1fr 1fr;

}

.table-sort {
    display: grid;
    padding-right:10px;
    display: grid;
    grid-template-columns: 1fr 1fr 1fr 1fr;
    align-items: center;
    font-size: 16px;
    justify-content: space-between;
    margin-bottom: 10px;
    padding-left: 15px;
    padding-right: 15px ;
    font-family: 'Mulish', sans-serif;
}
</style>