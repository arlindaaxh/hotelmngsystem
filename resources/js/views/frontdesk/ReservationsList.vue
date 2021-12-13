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

            <div class="pl-15 mt-30 table-sort">
                <div class="flexed align-center " style="gap:10px">
                    <strong>First Name</strong>
                    <span class="sort-icon-asc-desc pointer flexed-column">
                        <i
                        class="el-icon-caret-top" style="height:10px"
                        @click="sortBy('name', 'asc')"
                        :class="sortField === 'name' && sortOrder === 'asc' ? 'sorted-field-ascending' : 'ascending'"
                        ></i>
                        <i
                        class="el-icon-caret-bottom" 
                        :class="sortField === 'name' && sortOrder === 'desc' ? 'sorted-field-descending' : 'descending'"
                        @click="sortBy('name', 'desc')"
                        ></i>
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ReservationServices from '../../services/reservation.services'
import RoomServices from '../../services/room.services'
import dayjs from 'dayjs'
    export default {
        data() {
            return {
                loading: false,
                reservations: [],
                rooms: [],
                checkinDate: null,
                checkoutDate: null,
                sortField: "",
                reservationsList: []

            }
        },
        methods:{
            createNewReservation(){
                this.$router.push({
                    name: 'availability'
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
                let params = {
                    'DATE_FROM': this.checkinDate,
                    'DATE_TO': this.checkoutDate
                }
                Promise.all(
                    [
                        ReservationServices.getReservations(),
                        RoomServices.getRooms(),
                        ReservationServices.getReservationsByDate(params)
                    ].map((p, index) =>
                        p.then(
                            (v) => ({
                                data: v.data,
                                status: "success",
                                type:
                                    index == 0 ? "reservations"
                                    : index == 1 ? "rooms" : 
                                    index == 2 ? "reservations-list" : "unknown"
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
                            }
                            else if(res.type == "reservations-list"){
                                this.reservationsList = res.data
                                console.log('res-Data', this.reservationsList)
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
            // this.getOptionsData() 
        }
        
    }
</script>

<style lang="scss" scoped>

</style>