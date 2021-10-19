<template>
   <div class="form-max-width" v-loading="loading">
    <div class="flexed justify-between  m-b-20">
      <span @click="goBack()" class="flexed align-center pointer">
        <arrow-left-icon size="1.2x" class="m-r-5" />
        <h4 v-if="insertEdit ==='edit'">Edit Employee - {{employee.name}} {{employee.surname}}</h4>
        <h4 v-else>Add Employee</h4>
      </span>
        <el-button size="big" style="background-color:#ff7b50; border-radius:15px;color:white" v-if="insertEdit === 'edit'" @click="editEmployee()">Save</el-button>
        <el-button size="big" style="background-color:#ff7b50; border-radius:15px;color:white" v-else @click="save()">Save</el-button>
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

        <!-- <el-form-item>
            <el-input type="hidden" name="_method" value="PUT">
        </el-form-item> -->
      </el-form>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import {ArrowLeftIcon} from 'vue-feather-icons';
import EmployeeServices from '../../../services/employee.services'

    export default {
        name: 'AddEditEmployees',
        components: {
            ArrowLeftIcon
        },
        props: ['insertEdit', 'departments', 'employeeProp','id'],
        data(){
            return{
                loading: false,

                employee: {
                    name:null,
                    surname: null,
                    email: null,
                    job_title:null,
                    phone:null,
                    active: true,
                    department_id:null,
                    id: null,
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
            editEmployee(){
                this.loading = true
                let employee = {
                    'name': this.employee.name,
                    'surname': this.employee.surname,
                    'email': this.employee.email,
                    'job_title': this.employee.job_title,
                    'phone': this.employee.phone,
                    'active': this.employee.active,
                    'department_id': this.employee.department_id
                }

                // let url = `https://127.0.0.1:8000/api/edit-employee/${this.employee.id}`;
           
                EmployeeServices.putEmployee(employee, this.id).then((res) => {
                      this.$notify.success({
                        title: 'Success',
                        type: 'Success',
                        message: 'Employee was updated successfully'
                    })
                    console.log('employee', res.data)
                    this.goBack()
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
            if(!this.insertEdit){
                this.goBack()
            }
            else {
                if(this.insertEdit === 'edit'){
                    this.employee = {...this.employeeProp}
                    if(this.employee.active === 1){
                        this.employee.active = true
                    }

                }
            }
        }
       
    
    }
</script>

<style lang="scss" scoped>

</style>