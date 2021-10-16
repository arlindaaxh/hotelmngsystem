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
    
        <div class=" mt-30" v-for="(department,index) in filteredDepartments" :key="index">
           
            <div class="card-items-container pointer flexed" @click="editShortcut(shortcut)"> 
                <!-- <el-avatar :size="size" src="https://cube.elemecdn.com/3/7c/3ea6beec64369c2642b92c6726f1epng.png"></el-avatar> -->
                <strong class="info-name">{{department.name}}</strong>
                <strong class="info-name">{{department.code}}</strong>
               
                <strong class="info-item">{{department.active === 1 ? 'active' : 'inactive'}}</strong>
            
                <div class="flexed justify-end" style="font-size:26px; gap:5px;">
                    <!-- <i class="el-icon-edit-outline" style="color:#66b1ff"></i> -->
                    <i class="el-icon-delete" style="font-size:20px; color:#f56565"></i>
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
    <add-edit-departments v-if="showDepartmentModal" @close="showDepartmentModal = false"/>
  </div>

</template>

<script>
import AddEditDepartments from '../../components/administration/departments/AddEditDepartments.vue'
import departmentServices from '../../services/department.services'
    export default {
    components: { AddEditDepartments },
        name: 'Departments',
        data() {
            return {
                loading: false,
                query: "", 
                showDepartmentModal: false,
                departments: []
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
            }
        },
        beforeMount(){
            this.getDepartments()
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

</style>