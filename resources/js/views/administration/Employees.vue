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

        <div class="pl-15 mt-30 table-sort">
            <div class="flexed align-center " style="gap:10px">
                <strong>First Name</strong>
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
                <strong>Last Name</strong>
                <span class="sort-icon-asc-desc flexed-column">
                    <i
                    class="el-icon-caret-top" style="height:10px"
                    @click="sortBy('surname', 'asc')"
                    :class="sortField === 'surname' && sortOrder === 'asc' ? 'sorted-field-ascending' : 'ascending'"
                    ></i>
                    <i
                    class="el-icon-caret-bottom" 
                    :class="sortField === 'surname' && sortOrder === 'desc' ? 'sorted-field-descending' : 'descending'"
                    @click="sortBy('surname', 'desc')"
                    ></i>
                </span>
            </div>
             <div class="flexed align-center " style="gap:10px">
                <strong>Email</strong>
                <span class="sort-icon-asc-desc flexed-column">
                    <i
                    class="el-icon-caret-top" style="height:10px"
                    @click="sortBy('email', 'asc')"
                    :class="sortField === 'email' && sortOrder === 'asc' ? 'sorted-field-ascending' : 'ascending'"
                    ></i>
                    <i
                    class="el-icon-caret-bottom" 
                    :class="sortField === 'email' && sortOrder === 'desc' ? 'sorted-field-descending' : 'descending'"
                    @click="sortBy('email', 'desc')"
                    ></i>
                </span>
            </div>
             <div class="flexed align-center " style="gap:10px">
                <strong>Phone</strong>
                <span class="sort-icon-asc-desc flexed-column">
                    <i
                    class="el-icon-caret-top" style="height:10px"
                    @click="sortBy('phone', 'asc')"
                    :class="sortField === 'phone' && sortOrder === 'asc' ? 'sorted-field-ascending' : 'ascending'"
                    ></i>
                    <i
                    class="el-icon-caret-bottom" 
                    :class="sortField === 'phone' && sortOrder === 'desc' ? 'sorted-field-descending' : 'descending'"
                    @click="sortBy('phone', 'desc')"
                    ></i>
                </span>
            </div>
             <div class="flexed align-center " style="gap:10px">
                <strong>Job title</strong>
                <span class="sort-icon-asc-desc flexed-column">
                    <i
                    class="el-icon-caret-top" style="height:10px"
                    @click="sortBy('job_title', 'asc')"
                    :class="sortField === 'job_title' && sortOrder === 'asc' ? 'sorted-field-ascending' : 'ascending'"
                    ></i>
                    <i
                    class="el-icon-caret-bottom" 
                    :class="sortField === 'job_title' && sortOrder === 'desc' ? 'sorted-field-descending' : 'descending'"
                    @click="sortBy('job_title', 'desc')"
                    ></i>
                </span>
            </div>
             <div class="flexed align-center " style="gap:10px">
                <strong>Department</strong>
                <!-- <span class="sort-icon-asc-desc flexed-column">
                    <i
                    class="el-icon-caret-top" style="height:10px"
                    @click="sortBy('department', 'asc')"
                    :class="sortField === 'department' && sortOrder === 'asc' ? 'sorted-field-ascending' : 'ascending'"
                    ></i>
                    <i
                    class="el-icon-caret-bottom" 
                    :class="sortField === 'department' && sortOrder === 'desc' ? 'sorted-field-descending' : 'descending'"
                    @click="sortBy('department', 'desc')"
                    ></i>
                </span> -->
            </div>
      </div>
    
        <div class="mt-10" v-for="(employee,index) in filteredEmployees" :key="index">
          
            <div class="card-items-container pointer flexed" @click="editEmployee(employee)"> 
                <!-- <el-avatar :size="size" src="https://cube.elemecdn.com/3/7c/3ea6beec64369c2642b92c6726f1epng.png"></el-avatar> -->
                <span class="info-name">{{employee.name}}</span>
                <span class="info-name">{{employee.surname}}</span>
                
                <span style="info-item">{{employee.email}}</span>
              
                <span style="info-item">{{employee.phone}}</span>
                <span class="info-item">{{employee.job_title}}</span>
                <span class="info-item" v-if="employee.department_id">{{getName(employee.department_id)}}</span>
            
                <div class="flexed justify-end" style="font-size:26px; gap:5px;">
                    <!-- <i class="el-icon-edit-outline" style="color:#66b1ff"></i> -->
                    <i class="el-icon-delete" style="font-size:20px; color:#f56565" @click="deleteEmployee(employee,$event)"></i>
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
        <delete-employee v-if="showDeleteEmployeeModal" @close='showHideDeleteEmployeeModal()' :employeeProp='employeeProp'/>
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
import DeleteEmployee from '../../components/administration/employees/DeleteEmployee.vue';
export default {
    name: 'Employees',
    components: {
        EditIcon,
        Trash2Icon,
        DeleteEmployee
    },
    data() {
        return {
            loading: false,
            query: "",
            employees: [],
            departments: [],
            sortField: "",
            sortOrder: "asc",
            employeeProp: null,
            showDeleteEmployeeModal: false,
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
        editEmployee(employee){
            this.$router.push({
                name: 'edit-employee',
                params: {
                    insertEdit: 'edit',
                    departments: this.departments,
                    employeeProp: employee,
                    id: employee.id
                }
            
            })
        },
        getEmployees(){
            this.loading = true
            EmployeeServices.getEmployees().then((res) => {
                this.employees = res.data
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
            let found = this.departments?.find(element => element.id === departmentId)
            if(found){
                return found.name
            }
        },
        sortBy(field, order) {
            this.sortField = field;
            this.sortOrder = order;
            if(this.sortOrder === 'asc'){
                this.sortedObject(this.employees, this.sortField)
            }else {
                this.sortedObjectDescending(this.employees, this.sortField)
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
        deleteEmployee(employee,event){
            event.stopPropagation()
            this.showDeleteEmployeeModal = true
            this.employeeProp = employee
        },
        showHideDeleteEmployeeModal(){
            this.showDeleteEmployeeModal = false
            this.getDepartments()
            this.getEmployees()
          
        }
    },
    beforeMount() {
        this.getDepartments()
        this.getEmployees()
    },
     beforeRouteUpdate(to, from, next){
        if(to.name === 'employees'){
            this.getEmployees()
            this.getDepartments()
        }
        next()

    }
    
};
</script>


<style lang="scss" scoped>

::v-deep .el-input__inner {
    border-radius: 15px;
}

.table-sort {
    display: grid;
    // gap:15px;
    grid-template-columns: 220px 220px 220px 120px 120px 140px 50px;
    padding-right:10px;
    display: grid;
    grid-template-columns: 220px 220px 220px 120px 120px 140px 50px;
    align-items: center;
    font-size: 16px;
    justify-content: space-between;
    margin-bottom: 10px;
    padding-left: 15px;
    padding-right: 15px ;
    font-family: 'Mulish', sans-serif;
}
</style>