<template>
    <div>
        <div class="filters flexed align-center p-30 " style="gap:20px;">
            <div class="flexed-column" style="gap:5px">
                <span>Check In</span>
                <el-date-picker
                    v-model="checkinDate"
                    type="date"
                    placeholder="Pick a date"
                    :default-value="currentDay"
                    @change="formatDate()"
                    >
                </el-date-picker>
            </div>
           
            <div class="flexed-column" style="gap:5px">
                <span >Check Out</span>
                <el-date-picker
                    v-model="checkoutDate"
                    type="date"
                    placeholder="Pick a date"
                    :default-value="dayAfterToday"
                    @change="formatDate()">
                </el-date-picker>
            </div>

            <div class="flexed-column" style="gap:5px;">
                <span>Guests</span>
                <div class="flexed" style="gap:20px; margin-left:50px;">
                    <div>
                        <span>Adults <i class="el-icon-user-solid"></i></span>
                        <el-input-number v-model="num_of_adults" @change="handleChange" :min="1" :max="10"></el-input-number> 
                    </div>
                    <div>
                    <span>Children <i class="el-icon-user-solid"></i></span>
                        <el-input-number v-model="num_of_children" @change="handleChange" :min="0" :max="10"></el-input-number> 
                    </div>
                </div>
            </div>   
        </div>

        <div class="rooms-section p-30">
            <div class="flex-wrap" style="gap:30px">
                <el-card class="box-card" v-for="(room,index) in availableRooms" :key="index">
                    <div class="flexed justify-between" style="align-items:end">
                        <div class="flexed-column" style="gap:20px">
            
                            <span style="font-weight:550">
                                {{room.type}}
                            </span>
                            <span>{{room.code}} - {{room.number}}</span>
                            <span>
                                Price - $0.00
                            </span>
                        </div>
                        <el-button  style="color:#ff7b50" @click="openBookingTypeModal(room)">Book</el-button>
                    </div>
                </el-card>
            </div>
        </div>
        {{availableRooms.length}}
        <new-booking-type-modal v-if="showBookingTypeModal" 
            @close="showBookingTypeModal = false" 
            :checkin="checkinDate" 
            :checkout="checkoutDate" 
            :adults="num_of_adults" 
            :children="num_of_children"
            :selectedRooms="selectedRooms"
        />
    </div>
</template>

<script>
import NewBookingTypeModal from '../../components/frontdesk/dashboard/NewBookingTypeModal.vue'
import dayjs from 'dayjs'
import RoomServices from '../../services/room.services'
import ReservationServices from '../../services/reservation.services'
export default {
    components: { NewBookingTypeModal },
        data() {
            return {
                value1: null,
                showBookingTypeModal: false,
                checkinDate: null,
                checkoutDate: null,
                num_of_adults: 1,
                num_of_children: 0,
                selectedRooms:[],
                rooms:[],
                bookings: [],
               
            }
        },
        methods: {
            openBookingTypeModal(room){
                this.selectedRooms.push(room)
                console.log('selectedRooms', this.selectedRooms)
                this.showBookingTypeModal = true
            },
            handleChange(){
                console.log('handleChange')
            },
            formatDate(){
                this.checkinDate = this.dayjs(this.checkinDate).format('YYYY-MM-DD')
                this.checkoutDate = this.dayjs(this.checkoutDate).format('YYYY-MM-DD')
            },
              getRooms(){
                this.loading = true
                RoomServices.getRooms().then((res) => {
                    this.rooms = res.data
        
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
            getReservations(){
                this.loading = true
                ReservationServices.getReservations().then((res) => {
                    this.bookings = res.data
                    console.log('bookings', this.bookings)
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
        computed: {
            currentDay(){
                return this.dayjs().format('YYYY-MM-DD')
            },
            dayAfterToday(){
                let currentDate = dayjs(this.checkinDate).date()
                let tomorrow = dayjs().set('date', currentDate + 1).format('YYYY-MM-DD')
                return tomorrow
            },
            availableRooms(){
                let availableRooms = []
                availableRooms = this.rooms.filter(room => this.bookings.some(b => b.rooms.find(r => room.id === r.id && b.active === 0)))
                let array = []

                this.rooms.forEach(room => {
                    this.bookings.forEach(booking => {
                        if(booking.rooms.some(item => item.id === room.id)){
                            array.push(room)
                        }
                    })
                })

                let nonReservedRooms = []
                nonReservedRooms = this.rooms.filter(room => !array.includes(room))
                return availableRooms.concat(nonReservedRooms)
            }
        },
        beforeMount(){
            this.checkinDate = this.currentDay
            this.checkoutDate = this.dayAfterToday
            this.getRooms()
            this.getReservations()
        }
    }
</script>

<style lang="scss" scoped>
.box-card{
    width:300px;
}
</style>