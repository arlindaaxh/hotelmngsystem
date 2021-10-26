<template>
<NormalPopup :no-border="true" :dimmed="true" width="400px">
    <div slot="header" class="flexed justify-between align-center">
        <span class="pointer m-t-5 m-b-5">
            <i class="el-icon-close" @click="$emit('close')"></i>
        </span>
        <span class="label-no-height m-t-5 m-b-5" v-if="department.id">Edit Department</span>
        <span class="label-no-height m-t-5 m-b-5" v-else>Add Department</span>
        <el-button v-if="department.id" size="medium" style="background-color:#ff7b50; border-radius:15px;color:white" @click="edit()">Save</el-button>
        <el-button v-else size="medium" style="background-color:#ff7b50; border-radius:15px;color:white" @click="save()">Save</el-button>
    </div>
    <div v-loading="loading" class="body">

        <el-form
          ref="add-edit-employees-form"
          :model="department"
          :rules="rules"
          size="medium"
          :hide-required-asterisk="true"
          label-position="top"

        >
            <el-form-item prop="name" label="Name">
            <el-input  name="name" v-model="department.name" size="big"></el-input>
            </el-form-item>

            <el-form-item prop="code" label="Code">
            <el-input  name="code" v-model="department.code" size="big"></el-input>
            </el-form-item>

    
            <el-form-item prop="active">
            <div class="flexed justify-between align-center w-100">
                <span class="label-no-height">Active</span>
                <el-switch v-model="department.active" ></el-switch>
            </div>
            </el-form-item>
        </el-form>
    </div>
</NormalPopup>

</template>

<script>
import NormalPopup from '../../NormalPopup.vue'
import DepartmentServices from '../../../services/department.services'
    export default {
        name:'AddEditDepartments',
        components: {
            NormalPopup
        },
        props: ['departmentProp'],
        data() {
            return{
                loading: false,
                department: {
                    name: null,
                    code: null,
                    active: true,
                    id:null,
                },
                rules: {
                    name: [
                        {
                            required: true,
                            message: "Field is required",
                            trigger: "change",
                        },
                        {
                            max: 255,
                            message: "Maximum characters allowed is 255",
                            trigger: "change",
                        },
                    ],
                    code: [
                        {
                            required: true,
                            message: "Field is required",
                            trigger: "change",
                        },
                        {
                            max: 255,
                            message: "Maximum characters allowed is 255",
                            trigger: "change",
                        },
                    ],
                }
            }
        },
        methods: {
            save(){
                this.loading = true;
                DepartmentServices.postDepartment(this.department).then((res) => {
                    this.$notify.success({
                        title:'Success',
                        type: 'success',
                        message: 'Department was created successfully'
                    })
                    this.$emit('close')
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
            edit(){
                this.loading = true;
                DepartmentServices.putDepartment(this.department, this.department.id).then((res) => {
                    this.$notify.success({
                        title:'Success',
                        type: 'success',
                        message: 'Department was updated successfully'
                    })
                    this.$emit('close')
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
            if(this.departmentProp && this.departmentProp.id){
                this.department = {...this.departmentProp}
                if(this.department.active === 1){
                    this.department.active = true
                }
            }
        }
    }
</script>

<style lang="scss" scoped>
::v-deep .el-form-item__error {
    color: #F56C6C;
    font-size: 12px;
    line-height: 1;
    padding-top: 4px;
    padding-left: 10px;
    position: absolute;
    top: 100%;
    left: 0;
}
</style>