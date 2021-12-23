<template>
    <div class="form-max-width" v-loading="loading">
        <div class="flexed justify-between align-center m-b-20" style="margin-bottom:30px;">
            <span @click="goBack()" class="flexed align-center pointer">
                <arrow-left-icon size="1.2x" class="m-r-5" />
                <h5>Create a New Booking</h5>
            </span>
            <div>
                <el-button style="margin-top: 12px;" @click="previous()">Previous</el-button>
                <el-button style="margin-top: 12px;" @click="next()">{{activeStep === 3 ? 'Save' : 'Next Step'}}</el-button>
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
                            @change="dateChanged()"
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
                    :model="booking_details"
                    :rules="rules"
                    size="medium"
                    :hide-required-asterisk="true"
                    class=" m-t-20"
                    label-position="top"
                >
                    <div class="flexed-column w-100 mt-30 booking_data" style="gap:30px">
                        <div  class="bordered mt-10 w-100 form-data" style="border:1px solid lightgrey; border-radius:5px">
                            <div class="flexed justify-between p-10" style="border-bottom:1px solid lightgrey;  border-right:1px solid lightgrey">
                                <span>Check In</span>
                                <span>{{booking_details.date_in}}</span>
                            </div>
                            <div class="flexed justify-between p-10" style="border-bottom:1px solid lightgrey;">
                                <span>Check Out</span>
                                <span>{{booking_details.date_out}}</span>
                            </div>
                            <div class="flexed justify-between align-center p-10" style="border-bottom:1px solid lightgrey;  border-right:1px solid lightgrey">
                                <span>Guest</span>
                                <!-- <span>{{returnedGuest.name}}</span> -->
                            </div>
                            <div class="flexed justify-between align-center p-10" style="border-bottom:1px solid lightgrey;">
                                <span>Guest Info</span>
                                <div class="flexed" style="gap:10px;">
                                    <div class="flexed">
                                        <span>Adults <i class="el-icon-user-solid"></i></span>
                                        <span> {{adultsNo}}</span>
                                    </div>
                                    <div class="flexed">
                                        <span>Children <i class="el-icon-user-solid"></i></span>
                                        <span> {{childrenNo}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flexed justify-between  align-center p-10" style=" border-right:1px solid lightgrey">
                                <span>Room Type</span>
                            </div>
                            <div class="flexed justify-between  align-center p-10 w-100">
                                <span>Room No.</span>
                            </div>
                        </div>
                      
                        
                    </div>
                    
                   
                </el-form>

            </div>
            <div v-if="activeStep === 3" class="mt-30">
                <div style="align-content:start">
                    <span class="label-no-height" style="padding:10px">Add-Ons</span>
                    <div class="bordered mt-10 form-data w-100" style="border:1px solid lightgrey; border-radius:5px; align-content:start">
                        <div v-for="(addon,index) in addons" :key="index">
                            <div class="flexed justify-between p-10" style="margin-top:10px;">
                                <el-checkbox @change="checkAddon(addon)">{{addon.name}}</el-checkbox>
                                <span>{{addon.price}}$</span>  
                            </div>
                        
                        </div>
                        
                    </div> 
                   <div class="bordered flexed-column mt-30 w-100" style="border:1px solid lightgrey; border-radius:5px; align-content:start; padding: 10px;">
                        <span class="label-no-height mb-10"><i class="el-icon-discount"></i> How much discount to offer?</span>
                        <div class="flexed"  style="gap: 20px;">
                            <el-radio-group v-model="discount" @change="changeDiscountType()">
                                <el-radio-button label="10%"></el-radio-button>
                                <el-radio-button label="20%"></el-radio-button>
                                <el-radio-button label="50%"></el-radio-button>
                            </el-radio-group>
                            <div>
                               <el-button style="align-self:start" :type="discountType === 'custom' ? 'primary' : 'default'" @click="changeDiscountType($event)">Custom</el-button>
                                <el-input v-if="discountType === 'custom'" v-model="custom_discount" style="width:70%">
                                    <template slot="append">%</template>
                                </el-input> 
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {ArrowLeftIcon} from 'vue-feather-icons'
import GuestServices from '../../../services/guest.services'
import dayjs from 'dayjs'
import ReservationServices from '../../../services/reservation.services'
import AddonServices from '../../../services/addon.services'
import ChargeServices from '../../../services/charge.services'
    export default {
        name: 'NewBooking',
        components: {
            ArrowLeftIcon
        },
        props: ['checkin', 'checkout','selectedRooms'],
        data() {
            return {
                activeStep: 1,
                loading: false,
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
                returnedGuest: null,
                booking_details: {
                    date_in: null,
                    date_out: null,
                    rooms: []

                },
                childrenNo: null,
                adultsNo: null,
                reservationData: null,
                discount: null,
                buttonType: "default",
                custom_discount: null,
                discountType: "default",
                discount_value: null,
                charge: {
                    reservation_id: null,
                    room_price: 100,
                    addons: [],
                    total: 0
                },
                addons: [],
            
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
        beforeMount(){
            console.log('this', this.$route.params)
            if(this.$route.params.bookingData){
                this.booking_details.date_in = this.$route.params.bookingData.checkin
                this.booking_details.date_out  = this.$route.params.bookingData.checkout
                this.adultsNo = this.$route.params.bookingData.adults
                this.childrenNo = this.$route.params.bookingData.children
                this.booking_details.rooms = this.$route.params.selectedRooms
                let rooms = this.$route.params.selectedRooms
                rooms.forEach(room => {
                    this.booking_details.rooms.push(room.id)
                })
            }

            this.getAddons()
            this.addons.forEach(addon => {
                addon.setAttribute('checked', false)
            })
            
        },
        methods: {
            next(){
                // if (this.activeStep++ > 2) this.activeStep = 1;
                if(this.activeStep === 1){
                    this.saveGuest()
                
                }else if(this.activeStep === 2){
                    this.saveReservationData()
                }
                else if(this.activeStep === 3){
                    this.saveCharges()
                }
                else{
                    this.activeStep++
                }
                // this.activeStep++
            },
            previous(){
                if(this.activeStep-- === 1) this.activeStep = 1
            },
            goBack(){
                this.$router.push({
                    name: 'frontdesk-dashboard'
                })
            },
            dateChanged(){
                 console.log('bird1', this.guest.birth_date)
                    let date = this.dayjs(this.guest.birth_date).format('YYYY-MM-DD')
            
                    this.guest.birth_date = date
                                    console.log('bird', this.guest.birth_date)
            },
            saveGuest(){
                this.$refs['guest-details-form'].validate((valid) => {
                    if(valid){
                        this.loading = true
                        this.guest.birth_date = this.dayjs(this.guest.birth_date).format('YYYY-MM-DD')
                    
                        GuestServices.postGuest(this.guest).then((res) => {
                            this.returnedGuest = res.data
                            console.log('returnedGuest', this.returnedGuest)
                            this.$notify.success({
                                title: 'Success',
                                message: 'Guest data were saved successfully'
                            })
                            this.activeStep ++
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
                })
            },
            saveReservationData(){
                let payload = {
                    guest_id: this.returnedGuest.id,
                    made_by: 'Arlinda Xhemaili',
                    date_in: this.booking_details.date_in,
                    date_out: this.booking_details.date_out,
                    rooms: this.booking_details.rooms,
                    active: true, 
                    is_completed: 1
                }
                this.loading = true
                ReservationServices.postReservation(payload).then((res) => {
                    this.reservationData = res.data
                    console.log('reservationReturnes', this.reservationData)
                    this.$notify.success({
                        title: 'Success',
                        message: 'Guest data were saved successfully'
                    })
                    this.activeStep ++
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
            changeDiscountType(fromCustom){
                if(this.discountType === 'default' && fromCustom){
                    this.discountType = "custom"
                    this.discount_value = this.custom_discount

                    this.discount = null
                }
                else {
                    this.discountType = "default" 
                    this.discount_value = this.discount

                    this.custom_discount = null
                }
            },
            getAddons(){
                this.loading = true
                AddonServices.getAddons().then((res) => {
                    this.addons = res.data
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
            checkAddon(addon){
                let foundAddon = this.addons.find(a => a.id === addon.id)
                foundAddon.checked = !foundAddon.checked
            },
            getNights(){
                let dateOut = dayjs(this.reservationData.date_out).date()
                console.log('dateOut',dateOut)
                let dateIn = dayjs(this.reservationData.date_in).date()
                console.log('dateIN',dateIn)
                
                return dateOut - dateIn
            },
            saveCharges(){
                this.addons.forEach(addon => {
                    if(addon.checked){
                        this.charge.addons.push(addon)
                    }
                })

                this.charge.addons?.forEach(addon => {
                    this.charge.total += addon.price
                })

                let nights = this.getNights()
                console.log('nights', nights)
                this.charge.room_price = nights * this.reservationData.rooms[0].room_price_per_night
                this.charge.total += this.charge.room_price
                if(this.custom_discount || this.discount){
                    if(this.discount){
                        this.discount = this.discount.replace('%', '')
                        this.custom_discount = null
                    }
                    else if(this.custom_discount){
                        this.custom_discount = this.custom_discount.replace('%', '')
                        this.discount = null
                    }
                    this.charge.total = this.custom_discount ? this.charge.total - this.charge.total * (this.custom_discount / 100) : this.charge.total - this.charge.total * (this.discount / 100)
                    this.charge.reservation_id = this.reservationData.id
                }
                this.loading = true
                ChargeServices.postCharge(this.charge).then(() => {
                    this.$notify.success({
                        title: 'Success',
                        message: 'Charges were saved successfully'
                    })
                    this.goBack()// change to go to reservations
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

        }
    }
</script>

<style lang="scss" scoped>
.booking_data {
    .form-data{
        gap:0px;
    }
}

</style>