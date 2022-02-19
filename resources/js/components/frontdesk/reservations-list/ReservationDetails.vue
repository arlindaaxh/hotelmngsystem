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
                    <div class="form-data">
            
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
                            <span>{{reservation.rooms[0].code}}</span> 
                        </div>
                        <div class="flexed justify-between">
                            <span>Room Number: </span>
                            <span>{{reservation.rooms[0].number}}</span> 
                        </div>
                        <div class="flexed justify-between">
                            <span>Room Type: </span>
                            <span>{{reservation.rooms[0].type}}</span> 
                        </div>
                        <div class="flexed justify-between">
                            <span>Room Status: </span>
                            <span :class="reservation.rooms[0].cleaning_status === 1 ? 'text-green' : 'text-primary'">{{reservation.rooms[0].cleaning_status}}</span> 
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
                            <span>Gender</span>
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
                            <span>${{addon.price}}</span>
                        </div>
                        
                    </div>

                  
                    <div class="mt-30" v-if="orderDetails.length">
                        <span class="label-no-height">Orders</span>
                        <el-table
                            :data="orderDetails"
                            stripe
                            style="width: 100%"
                            class="table mt-20"
                            :default-sort = "{prop: 'name', order: 'ascending'}"
                            header-cell-class-name="table-header"
                            show-summary
                            :summary-method="getSummaries"
        
                            >
                            <el-table-column
                                prop="serial_number"
                                label="#Order Number"
                            >
                            </el-table-column>
                            <el-table-column
                                prop="created_at"
                                label="Order Date"
                                :formatter="formatDate" 
                            >
                            </el-table-column>
                            <el-table-column
                                prop="items"
                                label="Items"
                            ></el-table-column>
                            <el-table-column
                                prop="total_amount"
                                label="Total"
                                :formatter="formatPrice"
                            ></el-table-column>
                        

                        </el-table>


                        <div class="flexed justify-between">
                            <span class="label-no-height">Total:</span>
                            <span>${{charges.total}}</span>
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
import OrderServices from '../../../services/order.services'
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
                checkout: false,
                orders: [],
                reservations: [],
                guests: []
                
                
            }
        },
        computed: {
            stayDays(){
                let dateOut = dayjs(this.reservation.date_out).date()
                let dateIn = dayjs(this.reservation.date_in).date()
                return dateOut - dateIn
            },
            orderDetails(){
                let reservation  = this.reservations.find(res => res.active && res.guest_id === this.guest.id)
                console.log('res', reservation)
                let orders = this.orders.filter(order => order.guest_id === reservation.guest_id)
                console.log('orde', orders)
                return orders

            }
            
        },
        methods: {
            goBack(){
                this.$router.push({
                    name: 'reservations-list',
                })
            },
            formatDate(row,column){
                return `${row[column.property].split('T')[0]}`
            },
            getSummaries(param){
                const { columns, data } = param;
                const sums = [];
            
                columns.forEach((column, index) => {
                if (index === 2  ) {
                    sums[index] = 'Total Cost';
                    return;
                }
                if(index === 1 || index === 0 || index === 5){
                    sums[index] = '';
                    return;
                }
                const values = data.map(item => Number(item[column.property]));
                if (!values.every(value => isNaN(value))) {
                    sums[index] = '$ ' + values.reduce((prev, curr) => {
                    const value = Number(curr);
                    if (!isNaN(value)) {
                        return prev + curr;
                    } else {
                        return prev;
                    }
                    
                    }, 0);
                } else {
                    sums[index] = 'N/A';
                }


            
                });

                return sums;
            },
    
            formatPrice(row, column){
                return `$ ${row[column.property].toFixed(2)}`; 
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
            },
         
            getOrders(){
                this.loading = true
                OrderServices.getOrders().then((res) => {
                    this.orders = res.data
                })
                .catch((error) => {
                    this.catchMethod(error)
                })
                .finally(() => {
                    this.loading = false
                })
            },

         
          
        },
        beforeMount(){
            if(!this.optionsData){
                this.goBack()
            }
            else{
                this.guest = this.getGuest()
                this.charges = this.getCharges()
                this.reservations = this.optionsData.reservations
                this.guests = this.optionsData.guests
                this.getOrders()
            }
      

        
        
        }
        
    }
</script>

<style lang="scss" scoped>

::v-deep .el-button--primary {
    color: white;
    background-color: #ff7b50 !important;
    border-color: #ff7b50 !important;
}

::v-deep .el-button--primary:hover {
    color: white;
    background-color: #ff7b50 !important;
    border-color: #ff7b50 !important;
}
</style>