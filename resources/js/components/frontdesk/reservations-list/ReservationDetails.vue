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
                            <span>{{reservation.date_out}}</span> 
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
                            <span :class="cleaning_status === 1 ? 'text-green' : 'text-primary'">{{room.cleaning_status}}</span> 
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
                    </div>
                </el-card>

            </div>
            
        </div>
    </div>
</template>

<script>
import {ArrowLeftIcon} from 'vue-feather-icons'
    export default {
        name: 'ReservationDetails',
        components: {ArrowLeftIcon},
        props: ['reservation', 'optionsData'],
        data(){
            return{
                loading: false,
                guest: null,
                room: null,
                charges: null,
                
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
                return this.optionsData.charges.find(ch => ch.reservation_id === this.reservation.id)
            }
          
        },
        beforeMount(){
            this.guest = this.getGuest()
            this.charges = this.getCharges()
        
        }
        
    }
</script>

<style lang="scss" scoped>

</style>