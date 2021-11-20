<template>
    <div class="form-max-width">
        <div class="flexed justify-between align-center m-b-20" style="margin-bottom:30px;">
            <span @click="goBack()" class="flexed align-center pointer">
                <arrow-left-icon size="1.2x" class="m-r-5" />
                <h5>Create a New Booking</h5>
            </span>
            <div>
                <el-button style="margin-top: 12px;" @click="previous()">Previous</el-button>
                <el-button style="margin-top: 12px;" @click="next()">Next step</el-button>
            </div>
            
        </div>
        <div>
            <el-steps :active="activeStep" finish-status="success" simple style="margin-top: 20px">
                <el-step title="Guest Data" ></el-step>
                <el-step title="Booking Details" ></el-step>
                <el-step title="Charges and Payment" ></el-step>
            </el-steps>


            <div v-if="activeStep === 1" style="margin-top:30px">
                <el-form
                    ref="guest-details-form"
                    :model="guest"
                    :rules="rules"
                    size="medium"
                    :hide-required-asterisk="true"
                    class="form-data m-t-20"
                    label-position="top"
                >
                    <el-form-item prop="first_name" label="First Name">
                        <el-input name="first_name" v-model="guest.first_name" size="big"/>
                    </el-form-item>
                    <el-form-item prop="last_name" label="Last Name">
                        <el-input name="last_name" v-model="guest.last_name" size="big"/>
                    </el-form-item>
                    <el-form-item prop="email" label="Email">
                        <el-input name="email" v-model="guest.email" size="big"/>
                    </el-form-item>
                    <el-form-item prop="address" label="Address">
                        <el-input name="address" v-model="guest.address" size="big"/>
                    </el-form-item>
                    <el-form-item prop="birth_date" label="Birthdate">
                        <el-date-picker
                            v-model="guest.birth_date"
                            type="date"
                            placeholder="Select date of birth"
                        >
                        </el-date-picker>
                    </el-form-item>
                    
                    <el-form-item prop="sex" label="Sex">
                        <el-radio-group name="sex" v-model="guest.sex" size="big">
                            <el-radio label="F">Female</el-radio>
                            <el-radio label="M">Male</el-radio>
                            <el-radio label="Other">Other</el-radio>
                        </el-radio-group>
                    </el-form-item>
                    <el-form-item prop="citizenship" label="Citizenship">
                        <el-input name="citizenship" v-model="guest.citizenship" size="big"/>
                    </el-form-item>
                    <el-form-item prop="personal_number" label="Personal Number">
                        <el-input name="personal_number" v-model="guest.personal_number" size="big"/>
                    </el-form-item>

                </el-form>
            </div>
            <div v-if="activeStep === 2">
                <el-form
                    ref="guest-details-form"
                    :model="booking_details"
                    :rules="rules"
                    size="medium"
                    :hide-required-asterisk="true"
                    class="form-data m-t-20"
                    label-position="top"
                >
                    <el-form-item prop="booking_number" label="booking_number">
                        <el-input name="booking_number" v-model="booking_details.booking_number" size="big"/>
                    </el-form-item>
                </el-form>

            </div>
        </div>
    </div>
</template>

<script>
import {ArrowLeftIcon} from 'vue-feather-icons'
    export default {
        name: 'NewBooking',
        components: {
            ArrowLeftIcon
        },
        data() {
            return {
                activeStep: 1,
                guest: {
                    first_name: null,
                    last_name: null,
                    email: null,
                    address: null,
                    phone_number: null,
                    birth_date: null,
                    personal_number: null,
                    citizenship: null,
                    sex: null,
                },
                booking_details: {
                    booking_number: 0,
                },
                rules: {
                    first_name: [
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
                    last_name: [
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
                    address: [
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
                    birth_date: [
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
                    citizenship: [
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
            next(){
                if (this.activeStep++ > 2) this.activeStep = 1;
            },
            previous(){
                if(this.activeStep-- === 1) this.activeStep = 1
            },
            goBack(){
                this.$router.push({
                    name: 'frontdesk-dashboard'
                })
            } 
        }
    }
</script>

<style lang="scss" scoped>

</style>