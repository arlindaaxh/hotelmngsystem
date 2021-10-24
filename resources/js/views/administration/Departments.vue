<template>
    <div class="form-max-width" v-if="$route.name === 'departments'" v-loading="loading">
    <div class="shortcuts-header flexed justify-between">
      <h4>Departments</h4>
    </div>
    <div class="one-column-list">
      <div class="flexed justify-between m-b-20">
        <el-input class="search-input" size="big" placeholder="Search departments by name or code" v-model="query" :style="'max-width:450px'">
          <i class="el-icon-search el-input__icon" slot="suffix"></i>
        </el-input>
        <div>
          <el-button size="big" style="background-color:#ff7b50; border-radius:15px;color:white" @click="addNewDepartment()">New</el-button>
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
                <strong>Code</strong>
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
             <div class="flexed align-center " style="gap:10px">
                <strong>Status</strong>
                <!-- <span class="sort-icon-asc-desc flexed-column">
                    <i
                    class="el-icon-caret-top" style="height:10px"
                    @click="sortBy('active', 'asc')"
                    :class="sortField === 'active' && sortOrder === 'asc' ? 'sorted-field-ascending' : 'ascending'"
                    ></i>
                    <i
                    class="el-icon-caret-bottom" 
                    :class="sortField === 'active' && sortOrder === 'desc' ? 'sorted-field-descending' : 'descending'"
                    @click="sortBy('active', 'desc')"
                    ></i>
                </span> -->
            </div>
       </div>
    
        <div class="mt-10" v-for="(department,index) in filteredDepartments" :key="index">
           
            <div class="card-items-container pointer flexed" @click="editDepartment(department)"> 
                <!-- <el-avatar :size="size" src="https://cube.elemecdn.com/3/7c/3ea6beec64369c2642b92c6726f1epng.png"></el-avatar> -->
                <span class="info-name text">{{department.name}}</span>
                <span class="info-name">{{department.code}}</span>
               
                <span class="info-item">{{department.active === 1 ? 'active' : 'inactive'}}</span>
            
                <div class="flexed justify-end" style="font-size:26px; gap:5px;">
                    <!-- <i class="el-icon-edit-outline" style="color:#66b1ff"></i> -->
                    <i class="el-icon-delete" style="font-size:20px; color:#f56565" @click="showDeleteModalMethod(department)"></i>
                </div>
            </div>
            
        </div>
   
       <el-alert v-if="!loading && filteredDepartments && filteredDepartments.length === 0"  
            type="info" 
            :closable="false" 
            class="mt-30"
            title="No results found" 
            show-icon
            
        />
    </div>
    <add-edit-departments v-if="showDepartmentModal" @close="showDepartmentModal = false" :departmentProp="depProp"/>
    <delete-modal v-if="showDeleteModal" @close="showHideDeleteModal()" :departmentProp="depProp"/>
  </div>

</template>

<script>
import DeleteModal from '../../components/administration/departments/DeleteModal.vue'
import AddEditDepartments from '../../components/administration/departments/AddEditDepartments.vue'
import departmentServices from '../../services/department.services'
    export default {
    components: { AddEditDepartments, DeleteModal },
        name: 'Departments',
        data() {
            return {
                loading: false,
                query: "", 
                showDepartmentModal: false,
                departments: [],
                sortField: "",
                sortOrder: 'asc',
                depProp: null,
                showDeleteModal: false
            }
        },
        computed: {
            filteredDepartments(){
                return (
                    (this.departments && this.departments.filter(element => {
                        return (
                           element.name.toLowerCase().match(this.query.toLowerCase())

                        )
                        })
                    )    
                )
            }  
        },
        methods: {
            addNewDepartment(){
                this.showDepartmentModal = true
            },
            editDepartment(department){
                this.showDepartmentModal = true  
                this.depProp = department
            },
            getDepartments(){
                this.loading = true
                departmentServices.getDepartments().then((res) => {
                    this.departments = res.data
                    
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
            showDeleteModalMethod(department){
                event.stopPropagation()
                this.showDeleteModal = true
                this.depProp = department
            },
             sortBy(field, order) {
                 console.log('field', field)
            
                this.sortField = field;
                this.sortOrder = order;
                if(this.sortOrder === 'asc'){
                    this.sortedObject(this.departments, this.sortField)
                }else {
                    this.sortedObjectDescending(this.departments, this.sortField)
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
            showHideDeleteModal(){
                this.showDeleteModal = false
                this.getDepartments()
            }
        },
        beforeMount(){
            this.getDepartments()
        },
        beforeRouteUpdate(to, from, next){
            if(to.name === 'departments'){
                this.getDepartments()
            
            }
            next()
        }
      
    }
</script>

<style lang="scss" scoped>

::v-deep .el-input__inner {
    border-radius: 15px;
}

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