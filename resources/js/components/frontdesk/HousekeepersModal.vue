<template>
    <NormalPopup :no-border="true" :dimmed="true" width="400px">
        <div slot="header" class="flexed justify-between align-center">
            <span class="pointer m-t-5 m-b-5">
                <i class="el-icon-close" @click="$emit('close')"></i>
            </span>
            <span class="label-no-height m-t-5 m-b-5">Assign Housekeeper</span>
            <el-button size="medium" type="primary" plain @click=assignHousekeeper()>Save</el-button>
        </div>
        <div v-loading="loading"  class="body" style="height:360px;">
            <div class="flexed-column" style="gap:20px; overflow-y:scroll;">
                <el-radio-group v-model="selectedHousekeeper" @change="test()">
                    <el-card v-for="(housekeeper,index) in housekeepers" :key="index" class="mt-10">
                        <el-radio :label="housekeeper.id" style="padding-top:0.5rem">  
                            <strong>{{housekeeper.name}}</strong>
                            <strong>{{housekeeper.surname}}</strong>
                        </el-radio>
                    </el-card>
                </el-radio-group>
            </div>
        </div>
    </NormalPopup>
</template>

<script>
import NormalPopup from '../NormalPopup.vue'
import EmployeeServices from '../../services/employee.services'
import DepartmentServices from '../../services/department.services'
import HousekeepingServices from '../../services/housekeeping.services'
    export default {
        name: 'HousekeepersModal',
        components: {
            NormalPopup
        },
        props: ['room', 'housekeeper'],
        data() {
            return {
                loading: false,
                employees: [],
                departments:[],
                selectedHousekeeper: null,
            }
        },
        computed: {
            housekeepers(){
                const housekeepers = []
                let allEmployees = this.employees.filter(employee => this.departments.some(dep => dep.id === employee.department_id))
                allEmployees.forEach(emp => {
                    let depName = this.getName(emp.department_id)
                    if(depName && depName === 'Housekeeping'){
                        let found = housekeepers.find(element => element.id === emp.id)
                        if(!found) {
                            housekeepers.push(emp) 
                        }
                    }
                })
                return housekeepers
            }
        },
        methods: {
            test(){
                console.log('sele', this.selectedHousekeeper)
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
            assignHousekeeper(){
                this.loading=true
                let payload = {
                    room_id: this.room.id,
                    employee_id: this.selectedHousekeeper
                }
                HousekeepingServices.postHousekeepingSchedule(payload).then((res) => {
                    this.$notify.success({
                        title: 'Success',
                        type: 'Success',
                        message: 'Housekeeper was assigned successfully'
                    })
                    // this.$emit('close')
                    this.$emit('housekeeperAssigned')
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
            this.getEmployees()
            console.log('hou', this.housekeeper)
            this.selectedHousekeeper = this.housekeeper.id
        }
    }
</script>

<style lang="scss" scoped>
.label {
    margin: 0px!important;
    padding: 0px !important;
}

*::-webkit-scrollbar {
  width: 10px;
}

/* Track */
*::-webkit-scrollbar-track {
  background: #f1f1f1; 
}
 
/* Handle */
*::-webkit-scrollbar-thumb {
  background: #888; 
}

/* Handle on hover */
*::-webkit-scrollbar-thumb:hover {
  background: #555; 
}
::v-deep {
    .el-radio__inner {
        border-color: #409EFF;
        background: white !important; 
    }
}
</style>