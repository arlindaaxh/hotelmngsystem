<template>
    <div class="form-max-width" v-if="$route.name === 'guests'" v-loading="loading">
        <div class="shortcuts-header flexed justify-between">
        <h4>Guests</h4>
        </div>
        <div class="one-column-list">
        <div class="flexed justify-between m-b-20">
            <el-input class="search-input" size="big" placeholder="Search guests by name or code" v-model="query" :style="'max-width:450px'">
            <i class="el-icon-search el-input__icon" slot="suffix"></i>
            </el-input>
            <!-- <div>
                <el-button size="big" style="background-color:#ff7b50; border-radius:15px;color:white">New</el-button>
            </div> -->
        </div>

        <div class="pl-15 mt-30 table-sort">
            <div class="flexed align-center " style="gap:10px">
                <strong>First Name</strong>
                <span class="sort-icon-asc-desc pointer flexed-column">
                    <i
                    class="el-icon-caret-top" style="height:10px"
                    @click="sortBy('first_name', 'asc')"
                    :class="sortField === 'name' && sortOrder === 'asc' ? 'sorted-field-ascending' : 'ascending'"
                    ></i>
                    <i
                    class="el-icon-caret-bottom" 
                    :class="sortField === 'first_name' && sortOrder === 'desc' ? 'sorted-field-descending' : 'descending'"
                    @click="sortBy('first_name', 'desc')"
                    ></i>
                </span>
            </div>
             <div class="flexed align-center " style="gap:10px">
                <strong>Last Name</strong>
                <span class="sort-icon-asc-desc flexed-column">
                    <i
                    class="el-icon-caret-top" style="height:10px"
                    @click="sortBy('last_name', 'asc')"
                    :class="sortField === 'last_name' && sortOrder === 'asc' ? 'sorted-field-ascending' : 'ascending'"
                    ></i>
                    <i
                    class="el-icon-caret-bottom" 
                    :class="sortField === 'last_name' && sortOrder === 'desc' ? 'sorted-field-descending' : 'descending'"
                    @click="sortBy('last_name', 'desc')"
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
                    @click="sortBy('phone_number', 'asc')"
                    :class="sortField === 'phone_number' && sortOrder === 'asc' ? 'sorted-field-ascending' : 'ascending'"
                    ></i>
                    <i
                    class="el-icon-caret-bottom" 
                    :class="sortField === 'phone_number' && sortOrder === 'desc' ? 'sorted-field-descending' : 'descending'"
                    @click="sortBy('phone_number', 'desc')"
                    ></i>
                </span>
            </div>
             <div class="flexed align-center " style="gap:10px">
                <strong>Gender</strong>
                <span class="sort-icon-asc-desc flexed-column">
                    <i
                    class="el-icon-caret-top" style="height:10px"
                    @click="sortBy('sex', 'asc')"
                    :class="sortField === 'sex' && sortOrder === 'asc' ? 'sorted-field-ascending' : 'ascending'"
                    ></i>
                    <i
                    class="el-icon-caret-bottom" 
                    :class="sortField === 'sex' && sortOrder === 'desc' ? 'sorted-field-descending' : 'descending'"
                    @click="sortBy('sex', 'desc')"
                    ></i>
                </span>
            </div>
            
      </div>
    
        <div class="mt-10" v-for="(guest,index) in filteredGuests" :key="index">
          
            <div class="card-items-container pointer flexed" > 
                <span class="info-name">{{guest.first_name}}</span>
                <span class="info-name">{{guest.last_name}}</span>
                
                <span style="info-item">{{guest.email}}</span>
              
                <span style="info-item">{{guest.phone_number}}</span>
                <span class="info-item">{{guest.sex}}</span>
            
            
                <div class="flexed justify-end" style="font-size:26px; gap:5px;">
                    <i class="el-icon-delete" style="font-size:20px; color:#f56565"></i>
                </div>
            </div>
            
        </div>
   
       <el-alert  v-if="!loading && filteredGuests && filteredGuests.length === 0"
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
import DeleteEmployee from '../../components/administration/employees/DeleteEmployee.vue';
import guestServices from '../../services/guest.services';
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
            guests: [],
            sortField: "",
            sortOrder: "asc",
            showDeleteEmployeeModal: false,
        }
    },
    computed:{
        filteredGuests(){
            return (
                (this.guests && this.guests.filter(guest => {
                    return ( 
                        guest.first_name.toLowerCase().match(this.query.toLowerCase()) || guest.last_name.toLowerCase().match(this.query.toLowerCase())
                )
                }))
            )
        }
    },
    methods: {
        // addNewEmployee(){
        //     this.$router.push({
        //         name: 'add-employee',
        //         params: {
        //             insertEdit: 'add',
        //             departments: this.departments
        //         }
            
        //     })
        // },
        // editEmployee(employee){
        //     this.$router.push({
        //         name: 'edit-employee',
        //         params: {
        //             insertEdit: 'edit',
        //             departments: this.departments,
        //             employeeProp: employee,
        //             id: employee.id
        //         }
            
        //     })
        // },
        getGuests(){
            this.loading = true
            guestServices.getGuests().then((res) => {
                this.guests = res.data
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
            this.sortField = field;
            this.sortOrder = order;
            if(this.sortOrder === 'asc'){
                this.sortedObject(this.guests, this.sortField)
            }else {
                this.sortedObjectDescending(this.guests, this.sortField)
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
        // deleteEmployee(employee,event){
        //     event.stopPropagation()
        //     this.showDeleteEmployeeModal = true
        //     this.employeeProp = employee
        // },
        // showHideDeleteEmployeeModal(){
        //     this.showDeleteEmployeeModal = false
        //     this.getDepartments()
        //     this.getEmployees()
          
        // }
    },
    beforeMount() {
        this.getGuests()
    },
     beforeRouteUpdate(to, from, next){
        if(to.name === 'guests'){
            this.getGuests()
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