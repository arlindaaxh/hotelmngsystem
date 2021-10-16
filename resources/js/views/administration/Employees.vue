<template>
    <div class="form-max-width" v-if="$route.name === 'employees'" v-loading="loading">
    <div class="shortcuts-header flexed justify-between">
      <h4>Employees</h4>
    </div>
    <div class="one-column-list">
      <div class="flexed justify-between m-b-20">
        <el-input class="search-input" size="big" placeholder="Search employees by name or code" v-model="query" :style="'max-width:450px'">
          <i class="el-icon-search el-input__icon" slot="suffix"></i>
        </el-input>
        <div>
          <el-button size="big" style="background-color:#ff7b50; border-radius:15px;color:white" @click="addNewEmployee()">New</el-button>
        </div>
      </div>
    
        <div class=" mt-30" v-for="(employee,index) in filteredEmployees" :key="index">
          
            <div class="card-items-container pointer flexed" @click="editShortcut(shortcut)"> 
                <!-- <el-avatar :size="size" src="https://cube.elemecdn.com/3/7c/3ea6beec64369c2642b92c6726f1epng.png"></el-avatar> -->
                <strong class="info-name">{{employee.name}}</strong>
                <strong class="info-name">{{employee.surname}}</strong>
                
                <span style="info-item">{{employee.email}}</span>
              
                <span style="info-item">{{employee.phone}}</span>
                <span class="info-item">{{employee.job_title}}</span>
                <span class="info-item" v-if="employee.department_id">{{getName(employee.department_id)}}</span>
            
                <div class="flexed justify-end" style="font-size:26px; gap:5px;">
                    <!-- <i class="el-icon-edit-outline" style="color:#66b1ff"></i> -->
                    <i class="el-icon-delete" style="font-size:20px; color:#f56565"></i>
                </div>
            </div>
            
        </div>
   
       <el-alert  v-if="!loading && filteredEmployees && filteredEmployees.length === 0"
            type="info" 
            :closable="false" 
            class="mt-30"
            title="No results found" 
            show-icon
        />
    </div>
  </div>
  <div v-else>
    <router-view />
  </div>
</template>


<script>
import EmployeeServices from '../../services/employee.services'
import DepartmentServices from '../../services/department.services'
import { EditIcon, Trash2Icon } from "vue-feather-icons";
export default {
    name: 'Employees',
    components: {
        EditIcon,
        Trash2Icon
    },
    data() {
        return {
            loading: false,
            query: "",
            employees: [],
            departments: [],
        }
    },
    computed:{
        filteredEmployees(){
            return (
                (this.employees && this.employees.filter(employee => {
                    return ( 
                        employee.name.toLowerCase().match(this.query.toLowerCase()) || employee.surname.toLowerCase().match(this.query.toLowerCase())
                )
                }))
            )

           
        }
    },
    methods: {
        addNewEmployee(){
            this.$router.push({
                name: 'add-employee',
                params: {
                    insertEdit: 'add',
                    departments: this.departments
                }
            
            })
        },
        getEmployees(){
            this.loading = true
            EmployeeServices.getEmployees().then((res) => {
                this.employees = res.data
                console.log('empl', this.employees)
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
        getDepartments(){
            this.loading = true
            DepartmentServices.getDepartments().then((res) => {
                this.departments = res.data
                console.log('d', this.departments)
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
        getName(departmentId){
            return this.departments.find(element => element.id === departmentId).name
        }
    },
    beforeMount() {
        this.getDepartments()
        this.getEmployees()

    }
    
};
</script>


<style lang="scss" scoped>

::v-deep .el-input__inner {
    border-radius: 15px;
}
</style>