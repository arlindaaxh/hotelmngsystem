<template>
   <div class="form-max-width" v-loading="loading">
    <div class="flexed justify-between  m-b-20">
      <span @click="goBack()" class="flexed align-center pointer">
        <arrow-left-icon size="1.2x" class="m-r-5" />
        <h4 v-if="insertEdit ==='edit'">Edit Employee - </h4>
        <h4 v-else>Add Employee</h4>
      </span>
      <el-button type="primary" size="medium" @click="save()">Save</el-button>
    </div>

    <div class="content mt-30">
      <el-form
          ref="add-edit-employees-form"
          :model="employee"
          :rules="rules"
          size="medium"
          :hide-required-asterisk="true"
          class="form-data"
          label-position="top"

      >
        <el-form-item prop="name" label="First Name">
          <el-input  name="name" v-model="employee.name" size="big"></el-input>
        </el-form-item>

        <el-form-item prop="surname" label="Last Name">
          <el-input  name="surname" v-model="employee.surname" size="big"></el-input>
        </el-form-item>

        <el-form-item prop="job_title" label="Job Title">
          <el-input  name="job_title" v-model="employee.job_title" size="big"></el-input>
        </el-form-item>

        <el-form-item prop="email" label="Email">
          <el-input  name="email" v-model="employee.email" size="big"></el-input>
        </el-form-item>

        <el-form-item prop="phone" label="Phone">
          <el-input  name="phone" v-model="employee.phone" size="big"></el-input>
        </el-form-item>

        <el-form-item prop="phone" label="Department">
            <el-select v-model="employee.department_id" placeholder="Select" size="big" class="w-100">
                <el-option
                    v-for="item in departments"
                    :key="item.id"
                    :label="item.name"
                    :value="item.id">
                </el-option>
            </el-select>
        </el-form-item>

        <el-form-item prop="active">
          <div class="flexed justify-between align-center w-100">
            <span class="label-no-height">Active</span>
            <el-switch v-model="employee.active" ></el-switch>
          </div>
        </el-form-item>
      </el-form>
    </div>
  </div>
</template>

<script>
import {ArrowLeftIcon} from 'vue-feather-icons';
import EmployeeServices from '../../../services/employee.services'

    export default {
        name: 'AddEditEmployees',
        components: {
            ArrowLeftIcon
        },
        props: ['insertEdit', 'departments'],
        data(){
            return{
                loading: false,
                departments: [],
                employee: {
                    name:null,
                    surname: null,
                    email: null,
                    job_title:null,
                    phone:null,
                    active: true,
                    department_id:null
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
                    surname: [
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
                    email: [
                        // {
                        //   required: true,
                        //   message: 'Please input email address',
                        //   trigger: 'blur'
                        // },
                        {
                            type: 'email',
                            message: 'Please input correct email address',
                            trigger: ['blur', 'change']
                        }
                    ]
                }
            }
        },
        methods: {
            goBack(){
                this.$router.push({
                    name: 'employees'
                })
            },
            save(){
                this.loading = true
                EmployeeServices.postEmployee(this.employee).then((res) => {
                    this.$notify.success({
                        title: 'Success',
                        type: 'Success',
                        message: 'Employee was saved successfully'
                    })
                    this.goBack()
                })  
                .catch((error) => {
                    this.catchMethod(error)
                })
                .finally(() => {
                    this.loading = false
                })

            },
           
        },
       
    
    }
</script>

<style lang="scss" scoped>

</style>