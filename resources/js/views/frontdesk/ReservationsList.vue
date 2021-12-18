<template>
    <div class="form-max-width" v-if="$route.name === 'reservations-list'" v-loading="loading">
        <div class=" flexed justify-between">
            <h4>Bookings</h4>
            <div>
                <el-button size="big" style="background-color:#ff7b50; border-radius:15px;color:white" @click="createNewReservation()">New</el-button>
            </div>
        </div>
        <div class="one-column-list">
            <div class="flexed justify-between m-b-20">
                <div class="flexed jutify-between" style="gap: 10px">
                    <div class="flexed-column" style="gap:5px">
                        <span>Check In</span>
                        <el-date-picker
                            v-model="checkinDate"
                            type="date"
                            placeholder="Pick a date"
                            >
                        </el-date-picker>
                    </div>
            
                    <div class="flexed-column" style="gap:5px">
                        <span >Check Out</span>
                        <el-date-picker
                            v-model="checkoutDate"
                            type="date"
                            placeholder="Pick a date"
                            @change="getReservationsByDate()">
                        </el-date-picker>
                    </div>
                </div>
            </div> 
            <div class="mt-30" v-for="(reservation,index) in reservationsList" :key="index">
            
                <div class="card-items-container pointer flexed" @click="goToDetails(reservation)"> 
                    <!-- <el-avatar :size="size" src="https://cube.elemecdn.com/3/7c/3ea6beec64369c2642b92c6726f1epng.png"></el-avatar> -->
                    <strong class="flexed" ><span v-for="(room,index) in reservation.rooms" :key="index">{{room.code}},</span></strong>
                
                    <span class="info-name">{{reservation.date_in}}</span>
                    
                    <span style="info-item">{{reservation.date_out}}</span>
                    <span class="info-name">{{guestData}}</span>
                
                    <span class="info-item">{{reservation.active === 1 ? 'ACTIVE' : 'INACTIVE'}}</span>
                
                    
                </div>
                
            </div>
    
            <el-alert  v-if="!loading && reservationsList.length === 0"
                    type="info" 
                    :closable="false" 
                    class="mt-30"
                    title="No results found" 
                    show-icon
                />
        </div>
    </div>
    <div v-else>
        <router-view/>
    </div>
</template>

<script>
import ReservationServices from '../../services/reservation.services'
import RoomServices from '../../services/room.services'
import GuestService from '../../services/guest.services'
import dayjs from 'dayjs'
import chargeServices from '../../services/charge.services'
    export default {
        data() {
            return {
                loading: false,
                reservations: [],
                rooms: [],
                checkinDate: null,
                checkoutDate: null,
                sortField: "",
                reservationsList: [],
                guests: [],
                charges: []

            }
        },
        computed: {
            guestData(){
                let name;
                let surname;
                this.guests.forEach(guest => {
                    name = guest.first_name
                    surname = guest.last_name
                })

                return name + ' ' + surname
            }
        },
        methods:{
            createNewReservation(){
                this.$router.push({
                    name: 'availability'
                })
            },
            goToDetails(reservation){
                this.$router.push({
                    name: 'reservation-details',
                    params: {
                        reservation: reservation,
                        optionsData: {
                            guests: this.guests,
                            rooms: this.rooms,
                            charges: this.charges
                            
                        }
                    }
                })
            },
            getReservationsByDate(){
                this.checkinDate = this.dayjs(this.checkinDate).format('YYYY-MM-DD')
                this.checkoutDate = this.dayjs(this.checkoutDate).format('YYYY-MM-DD')
                let params = {
                    'DATE_FROM': this.checkinDate,
                    'DATE_TO': this.checkoutDate
                }
                this.loading = true
                ReservationServices.getReservationsByDate(params).then((res) => {
                    this.reservationsList = res.data
                    console.log('res', this.reservationsList)
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
            getOptionsData() {
                this.loading = true;
                
                Promise.all(
                    [
                        ReservationServices.getReservations(),
                        RoomServices.getRooms(),
                        GuestService.getGuests(),
                        chargeServices.getCharges()
                    ].map((p, index) =>
                        p.then(
                            (v) => ({
                                data: v.data,
                                status: "success",
                                type:
                                    index == 0 ? "reservations"
                                    : index == 1 ? "rooms" : 
                                    index == 2 ? "guests" :
                                    index == 3 ? "charges" :
                                    "unknown"
                            }),
                            (e) => ({ e, status: "error" })
                        )
                    )
                )
                .then((results) => {
                    if (results.length) {
                    results
                        .filter((r) => r.status == "success")
                        .forEach((res) => {
                            if (res.type == "reservations") {
                                this.reservations = res.data;
                                console.log('empl', this.reservations)
                            }
                            else if (res.type == "rooms") {
                                this.rooms = res.data
                                console.log('rooms', this.rooms)
                            }else if(res.type == "guests"){
                                this.guests = res.data
                            }else if(res.type == "charges"){
                                this.charges = res.data
                            }
                            
                        });
                    }
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
        },
        beforeMount(){
            console.log('here')
            this.getOptionsData() 
        }
        
    }
</script>

<style lang="scss" scoped>
.card-items-container {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr 1fr 1fr 1fr;
}
</style>