<template>
    <NormalPopup :no-border="true" :dimmed="true" width="400px">
        <div slot="header" class="flexed justify-center align-center">
            <strong class="m-t-5 m-b-5">Delete Employee</strong>
        </div>
        <div v-loading="loading" class="body">
            <div class="flexed-column">
                <span>Are you sure you want to delete <strong>{{employeeProp.name}}</strong> employee ?</span>
            </div>
        
        </div>
        <div slot="bottom" class="bottom">
            <el-button @click="$emit('close')">Cancel</el-button>
            <el-button type="danger" @click="deleteEmp(employeeProp.id)">Delete</el-button>
        </div>
    </NormalPopup>
</template>

<script>
import NormalPopup from '../../NormalPopup.vue'
import EmployeeServices from '../../../services/employee.services'
    export default {
        name: 'DeleteEmployee',
        props: ['employeeProp'],
        components: {
            NormalPopup
        },
        data() {
            return {
                loading: false
            }
        },
        methods:{
            deleteEmp(employeeId){
                this.loading = true
                EmployeeServices.deleteEmployee(employeeId).then((res) => {
                    this.$notify.success({
                        title: 'Success',
                        message: 'Employee deleted successfully'
                    })
                    this.$emit('close')
                }).catch((error) => {
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
        }
    }
</script>

<style lang="scss" scoped>

</style>