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
                <div>
                    <span>Guest Details</span>
                    <div class="form-data" style="width:100%;margin-top:20px;">
                        <div class="flexed justify-between">
                            <span>First Name</span>
                            <strong>{{guest.first_name}}</strong>
                        </div>
                        <div class="flexed justify-between">
                            <span>Last Name</span>
                            <strong>{{guest.first_name}}</strong>
                        </div>
                    </div>
                </div>
                <div>
                    <span>Charges</span>
                </div>
                <div>
                    <span>Room</span>
                </div>
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
            }
        },
        beforeMount(){
            this.guest = this.getGuest()
            console.log('g', this.guest)
        }
        
    }
</script>

<style lang="scss" scoped>

</style>