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
                <div class="flexed jutify-between" style="gap: 10px; align-items:end">
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

                    <i class="el-icon-refresh-right text-primary pointer" style="font-size:25px; margin-bottom: 10px" @click="refresh()"></i>
                
                </div>
            </div> 
            <div class="mt-30">
                <div  v-for="(reservation,index) in bookedToday" :key="index">
                    <div class="card-items-container pointer flexed" @click="goToDetails(reservation)"> 
                        <!-- <el-avatar :size="size" src="https://cube.elemecdn.com/3/7c/3ea6beec64369c2642b92c6726f1epng.png"></el-avatar> -->
                        <strong class="flexed" ><span v-for="(room,index) in reservation.rooms" :key="index">{{room.code}}</span></strong>
                    
                        <span class="info-name">{{reservation.date_in}}</span>
                        
                        <span style="info-item">{{reservation.date_out}}</span>
                        <span class="info-name">{{getGuestData(reservation)}}</span>
                    
                        <span class="info-item">{{reservation.active === 1 ? 'ACTIVE' : 'INACTIVE'}}</span>
                    
                        
                    </div>
                    
                </div> 
            </div>
        
    
            <el-alert  v-if="!loading && bookedToday.length === 0"
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
                charges: [],
                fromDashboard: false,

            }
        },
        computed: {
            // guestData(){
            //     let name;
            //     let surname;
            //     this.guests.forEach(guest => {
            //         name = guest.first_name
            //         surname = guest.last_name
            //     })

            //     return name + ' ' + surname
            // },
            
            bookedToday(){
                let currentDate =  this.dayjs().format('YYYY-MM-DD')
                return this.fromDashboard ? this.reservationsList.filter(res => res.created_at === currentDate) : this.reservationsList
            }
        },
        methods:{
            getGuestData(reservation){
                let guest = this.guests.find(guest => reservation.guest_id === guest.id)
                
                let name;
                let surname;
           
                name = guest.first_name
                surname = guest.last_name
   
                return name + ' ' + surname
            },
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
                            charges: this.charges,
                            reservations: this.reservationsList
                            
                        }
                    }
                })
            },
            refresh(){
                this.loading = true
                ReservationServices.getReservations().then((res) => {
                    this.fromDashboard = false
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
            sortedObjectDescending(array, key) {
                return array.sort((a, b) => {
                    let nameA = a[key].toUpperCase();
                    let nameB = b[key].toUpperCase();
                    if (nameA > nameB) {
                        return -1;
                    }
                    if (nameA < nameB) {
                        return 1;
                    }
                    return 0;
                });
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
                                this.reservationsList = res.data;
                                this.reservationsList = this.sortedObjectDescending( this.reservationsList, 'date_in') 
                                this.reservations.forEach(res => {
                                    res.created_at = res.created_at.split('T')
                                    res.created_at = res.created_at[0]
                                })
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
        },
        // beforeRouteEnter(to, from, next){
        //     console.log('hsjss', from.name)
        //     if(from.name === 'frontdesk-dashboard' || from.name === 'dashboard'){
        //         console.log('hsh')
               
        //         // this.reservationsList = this.reservationsList.filter(res => res.created_at ==)
        //     }

        // },
        beforeRouteEnter (to, from, next) {
            next(vm => {
                // access to component instance via `vm`
                if(from.name === 'frontdesk-dashboard' || from.name === 'dashboard'){
                    vm.fromDashboard = true
               
                // vm.reservationsList = vm.reservationsList.filter(res => res.created_at ==)
                }
            })
        }
        
    }
</script>

<style lang="scss" scoped>
.card-items-container {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr 1fr 1fr 1fr;
}
</style>