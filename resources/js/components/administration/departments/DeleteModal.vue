<template>
    <NormalPopup :no-border="true" :dimmed="true" width="400px">
        <div slot="header" class="flexed justify-center align-center">
            <strong class="m-t-5 m-b-5">Delete Department</strong>
        </div>
        <div v-loading="loading" class="body">
            <div class="flexed-column">
                <span>Are you sure you want to delete <strong>{{departmentProp.name}}</strong> department ?</span>
            </div>
        
        </div>
        <div slot="bottom" class="bottom">
            <el-button @click="$emit('close')">Cancel</el-button>
            <el-button type="danger" @click="deleteDep(departmentProp.id)">Delete</el-button>
        </div>
    </NormalPopup>
</template>

<script>
import NormalPopup from '../../NormalPopup.vue'
import DepartmentServices from '../../../services/department.services'
    export default {
        name: 'DeleteModal',
        props: ['departmentProp'],
        components: {
            NormalPopup
        },
        data() {
            return {
                loading: false
            }
        },
        methods:{
            deleteDep(depId){
                this.loading = true
                DepartmentServices.deleteDepartment(depId).then((res) => {
                    this.$notify.success({
                        title: 'Success',
                        message: 'Department deleted successfully'
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