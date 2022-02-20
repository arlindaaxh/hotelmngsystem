<template>
    <div class="form-max-width" v-if="$route.name === 'departures'" v-loading="loading">
        <div class=" flexed justify-between">
            <h4>Departures</h4>
        
        </div>
        <div class="one-column-list">
            <el-input class="search-input" size="big" placeholder="Search reservation by guest name or surname" v-model="query" :style="'max-width:450px'">
                <i class="el-icon-search el-input__icon" slot="suffix"></i>
            </el-input>
            <div class="mt-30">
                <div v-for="(reservation,index) in InHouseFilterByGuest" :key="index">
                    <div class="card-items-container pointer flexed" @click="goToDetails(reservation)"> 
                        <!-- <el-avatar :size="size" src="https://cube.elemecdn.com/3/7c/3ea6beec64369c2642b92c6726f1epng.png"></el-avatar> -->
                        <strong class="flexed" ><span v-for="(room,index) in reservation.rooms" :key="index">{{room.code}}</span></strong>
                    
                        <span class="info-name">{{reservation.date_in}}</span>
                        
                        <span style="info-item">{{reservation.date_out}}</span>
                        <span class="info-name">{{guestData}}</span>
                    
                        <span class="info-item">{{reservation.active === 1 ? 'ACTIVE' : 'INACTIVE'}}</span>    
                    </div>
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
                charges: [],
                query: ''

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
            },
            // inHouse(){
            //     let inHouse = this.reservationsList.filter(reservation => reservation.is_completed === 1 && reservation.active === 1)
            //     return inHouse
            // },
            InHouseFilterByGuest(){
                let inHouse = this.reservationsList.filter(reservation => reservation.is_completed === 1 && reservation.active === 0)
                
                return (
                (inHouse && inHouse.filter(res => {
                    return ( 
                        res.guest_name.toLowerCase().match(this.query.toLowerCase()) || res.guest_surname.toLowerCase().match(this.query.toLowerCase())
                        || res.date_out.toLowerCase().match(this.query.toLowerCase())
                )
                }))
            )
            },
            
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
                            }
                            else if (res.type == "rooms") {
                                this.rooms = res.data
                            }else if(res.type == "guests"){
                                this.guests = res.data
                                 this.reservationsList.forEach(res => {
                                    this.$set(res, 'guest_name', this.getGuestName(res))
                                    this.$set(res, 'guest_surname', this.getGuestSurname(res))
                                })
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
            getGuestName(res){
                return this.guests.find(g => g.id === res.guest_id).first_name

            },
            getGuestSurname(res){
                return this.guests.find(g => g.id === res.guest_id).last_name
            }
        },
        beforeMount(){
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