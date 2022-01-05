<template>
    <div class="form-max-width" v-loading="loading">
        <div class="flexed justify-between  m-b-20">
            <span @click="goBack()" class="flexed align-center pointer">
                <arrow-left-icon size="1.2x" class="m-r-5" />
                <h4>Reservation Details</h4>
            </span>
            <!-- <el-button size="big" style="background-color:#ff7b50; border-radius:15px;color:white"  @click="save()">Save</el-button> -->
        </div>
        <div class="content mt-30">
            <div class="flexed-column" style="gap:20px">
                <el-card
                >
                    <div slot="header" class="clearfix">
                        <span class="label-no-height">Stay</span>
                    </div>
                    <div class="form-data" v-for="(room,index) in  reservation.rooms" :key="index">
            
                        <div class="flexed justify-between">
                            <span>From: </span>
                            <span>{{reservation.date_in}}</span> 
                        </div>
                        <div class="flexed justify-between">
                            <span>To: </span>
                            <el-button type="default" @click="showCheckoutModal = true">{{reservation.date_out}}</el-button> 
                        </div>
                        <div class="flexed justify-between">
                            <span>Room Code: </span>
                            <span>{{room.code}}</span> 
                        </div>
                        <div class="flexed justify-between">
                            <span>Room Number: </span>
                            <span>{{room.number}}</span> 
                        </div>
                        <div class="flexed justify-between">
                            <span>Room Type: </span>
                            <span>{{room.type}}</span> 
                        </div>
                        <div class="flexed justify-between">
                            <span>Room Status: </span>
                            <span :class="room.cleaning_status === 1 ? 'text-green' : 'text-primary'">{{room.cleaning_status}}</span> 
                        </div>

                        <div class="flexed justify-between">
                            <span>Nights: </span>
                            <span>{{stayDays}}</span> 
                        </div>
                    </div>
                </el-card>
                <el-card
                >
                    <div slot="header" class="clearfix">
                        <span class="label-no-height">Guest Details</span>
                    </div>
                    <div class="form-data" style="width:100%">
                        <div class="flexed justify-between">
                            <span>First Name</span>
                            <strong>{{guest.first_name}}</strong>
                        </div>
                        <div class="flexed justify-between">
                            <span>Last Name</span>
                            <strong>{{guest.first_name}}</strong>
                        </div>
                        <div class="flexed justify-between">
                            <span>Date of Birth</span>
                            <strong>{{guest.birth_date}}</strong>
                        </div>
                        <div class="flexed justify-between">
                            <span>Sex</span>
                            <strong>{{guest.sex}}</strong>
                        </div>
                        <div class="flexed justify-between">
                            <span>Citizenship</span>
                            <strong>{{guest.citizenship}}</strong>
                        </div>
                    </div>
                </el-card>
                <el-card
                    v-if="charges"
                >
                    <div slot="header" class="clearfix">
                        <span class="label-no-height">Charges</span>
                    </div>
                    <div class="flexed justify-between">
                        <span>Room Price</span>
                        <strong>{{charges.room_price}}</strong>
                    </div>
                    <div v-for="(addon,index) in charges.addons" :key="index">
                        <div class="flexed justify-between">
                            <span>{{addon.name}}</span>
                            <span>{{addon.price}}</span>
                        </div>
                        
                    </div>
                
                </el-card>


                <div class="flexed justify-end">
                    <el-button size="big" type="primary" style="height:55px;width: 250px;" @click="open()">Check Out</el-button>
                </div>

            </div>
        </div>
        <checkout-modal v-if="showCheckoutModal" @close="showCheckoutModal = false" :reservation="reservation" :optionsData="optionsData"/>
        <checkout v-if="checkout" @close="checkout = false" :optionsData="optionsData"/>
    </div>
</template>

<script>
import {ArrowLeftIcon} from 'vue-feather-icons'
import CheckoutModal from './CheckoutModal.vue'
import Checkout from './Checkout.vue'
import dayjs from 'dayjs'
import reservationServices from '../../../services/reservation.services'
    export default {
        name: 'ReservationDetails',
        components: {ArrowLeftIcon, CheckoutModal, Checkout},
        props: ['reservation', 'optionsData'],
        data(){
            return{
                loading: false,
                guest: null,
                room: null,
                charges: null,
                showCheckoutModal: false,
                checkout: false
                
            }
        },
        computed: {
            stayDays(){
            
       
                let dateOut = dayjs(this.reservation.date_out).date()
                console.log('dateOut',dateOut)
                let dateIn = dayjs(this.reservation.date_in).date()
                console.log('dateIN',dateIn)
                
                return dateOut - dateIn

         
            }
        },
        methods: {
            goBack(){
                this.$router.push({
                    name: 'reservations-list',
                })
            },
            getGuest(){
                return this.optionsData.guests.find(g => g.id === this.reservation.guest_id)
            },
            getCharges(){
                console.log('ipt', this.optionsData)
                console.log('reser', this.reservation)
                return this.optionsData.charges.find(ch => ch.reservation_id === this.reservation.id)
            },
            open() {
                this.$confirm('Are you sure you want to complete the check out?', 'Warning', {
                confirmButtonText: 'Confirm',
                cancelButtonText: 'Cancel',
                type: 'warning',
                center: true
                }).then(() => {
                    this.confirmCheckout()
                this.$message({
                    type: 'success',
                    message: 'Check Out completed'
                });
                }).catch(() => {
                this.$message({
                    type: 'info',
                    message: 'Check out canceled'
                });
                });
            },
            confirmCheckout(){
                this.loading = true

                this.reservation.active = false
                reservationServices.putReservation(this.reservation, this.reservation.id).then(() => {
                    console.log('res')
                    this.$router.push({
                        name: 'in-house'
                    })
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
            this.guest = this.getGuest()
            this.charges = this.getCharges()
            console.log('charges', this.charges)
        
        }
        
    }
</script>

<style lang="scss" scoped>

</style>