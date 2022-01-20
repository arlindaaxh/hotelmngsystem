<template>

    <NormalPopup :no-border="true" :dimmed="true" width="400px">
        <div slot="header" class="flexed justify-between align-center">
            <span class="pointer m-t-5 m-b-5" style="flex:1">
                <i class="el-icon-close"  @click="$emit('close')"></i>
            </span>
            <span class="label-no-height m-t-5 m-b-5" style="flex:1;text-align:center">{{roomProp.code}}</span>
            <div style="display:flex;flex:1; justify-content:end">
                <el-button size="small" style="width:150px;" type="primary" plain @click="showHistoryModal()">Housekeeping history</el-button>  
            </div>
          
        </div>
        <div v-loading="loading" v-if="roomProp.cleaning_status === 'Dirty'" class="body">
            <el-button-group>
                <el-button @click="activeIndex = 1" :type="activeIndex === 1 ? 'primary' : 'default'">Schedule Details</el-button>
                <el-button @click="activeIndex = 2" :type="activeIndex === 2 ? 'primary' : 'default'">Reservation Details</el-button>
                <!-- <el-button @click="activeIndex = 3" :type="activeIndex === 3 ? 'primary' : 'default'">Service Options</el-button> -->
            </el-button-group>

            <div v-if="activeIndex === 1" class="bordered mt-10 " style="border:1px solid lightgrey;">
                <div class="flexed justify-between p-10" style="border-bottom:1px solid lightgrey;">
                    <span>Room Type</span>
                    <span>{{roomProp.type}}</span>
                </div>
                <div class="flexed justify-between p-10" style="border-bottom:1px solid lightgrey;">
                    <span>Occupancy Status</span>
                    <span>{{roomProp.status === 1 ? 'AVAILABLE' : 'OCCUPIED'}}</span>
                </div>
                <div class="flexed justify-between align-center p-10" style="border-bottom:1px solid lightgrey;">
                    <span>Room Status</span>
                    <span style="border:1px solid ;padding-top:3px; padding-bottom:3px; border-radius:20px;" 
                        :class="roomProp.cleaning_status === 'Dirty' ? 'pl-10 pr-10 text-danger border-danger' : 'text-primary border-primary pl-10 pr-10'"
                    >{{roomProp.cleaning_status}}</span>
                </div>
                <div class="flexed justify-between align-center p-10" style="border-bottom:1px solid lightgrey;">
                    <span>Housekeeper</span>
                    <el-button plain @click="assignHousekeeper(true)" v-if="hk" :key="reRenderKey">{{getScheduledHousekeepers(roomProp)}}</el-button>
                    <el-button v-if="!getScheduledHousekeepers(roomProp)" type="primary" plain @click="assignHousekeeper()">Assign Housekeeper</el-button>
                </div>
                <div class="flexed justify-between  align-center p-10" style="border-bottom:1px solid lightgrey;">
                    <span>Facilities</span>
                    <i class="el-icon-arrow-right"></i>
                </div>
                <div class="flexed justify-between  align-center p-10 w-100">
                    <el-button type="primary" class="w-100" @click="changeStatus(roomProp, {mark: 'Clean'})" plain>Ready for guest</el-button>
                </div>
            </div>
            <div v-if="activeIndex === 2" class="bordered mt-10 " style="border:1px solid lightgrey; min-height:300px;">
                <div class="flexed justify-between p-10" style="border-bottom:1px solid lightgrey;">
                    <span>Last Name</span>
                    <span>{{guest.last_name}}</span>
                </div>
                <div class="flexed justify-between p-10" style="border-bottom:1px solid lightgrey;">
                    <span>First Name</span>
                    <span>{{guest.first_name}}</span>
                </div>
                <div class="flexed justify-between p-10" style="border-bottom:1px solid lightgrey;">
                    <span>Adults</span>
                    <span>{{reservationDetails.num_of_adults}} 1</span>
                </div>
                <div class="flexed justify-between p-10" style="border-bottom:1px solid lightgrey;">
                    <span>Children</span>
                    <span>{{reservationDetails.num_of_children}} 0</span>
                </div>
                     <div class="flexed justify-between p-10" style="border-bottom:1px solid lightgrey;">
                    <span>Pets</span>
                    <span>N/A</span>
                </div>

            </div>
        </div>
        <div v-loading="loading" v-else class="body" style="height: 400px;">
            <div class="flexed-column w-100" style="gap:20px;">
                <div>
                    <el-button type="primary" plain class="w-100" @click="changeStatus(roomProp, {mark: 'Dirty'})">Mark Dirty</el-button>   
                </div>
             
                <div v-if="roomProp.cleaning_status === 'Ready'">
                    <el-button type="primary" plain class="w-100" @click="changeStatus(roomProp, {mark: 'Clean'})">Return to clean</el-button> 
                </div>
                <div v-if="roomProp.cleaning_status === 'Clean'">
                    <el-button type="primary" plain class="w-100"  @click="changeStatus(roomProp, {mark: 'Ready'})">Mark Ready</el-button> 
                </div>

                <div>
                    <el-button type="primary" plain class="w-100" @click="changeStatus(roomProp, {mark: 'Clean'})">Ready for guest</el-button>
                </div>
       
            </div>
        </div>


        <housekeepers-modal :room="roomProp" v-if="showHousekeepersModal" @close="closeHousekeepersModal()" @housekeeperAssigned="housekeeperAssigned()" :housekeeper="scheduledHousekeeper"/>
        <housekeeping-history-modal :room="roomProp" :housekeepers="housekeepers" :housekeepingHistorySchedules="housekeepingHistory" v-if="showHousekeepingHistoryModal" @close="showHousekeepingHistoryModal = false"/>
    </NormalPopup>

</template>

<script>
import NormalPopup from '../NormalPopup.vue'
import HousekeepersModal from './HousekeepersModal.vue'
import RoomServices from '../../services/room.services'
import HousekeepingHistoryServices from '../../services/housekeeping-history.service'
import HousekeepingServices from '../../services/housekeeping.services'
import HousekeepingHistoryModal from './HousekeepingHistoryModal.vue'
import reservationServices from '../../services/reservation.services'

    export default {
        name: 'RoomModal',
        components: {
            NormalPopup,
                HousekeepersModal,
                HousekeepingHistoryModal
        },
        props: ['roomProp', 'housekeepers', 'departments','schedules','guestsProp'],
        data() {
            return {
                loading: false,
                activeIndex: 1,
                showHousekeepersModal: false,
                scheduledHousekeeper: null,
                hk: false,
                reRenderKey: 1,
                showHousekeepingHistoryModal: false,
                housekeepingHistory: [],
                reservations: []
            }
        },
        computed:{
            reservationDetails(){
                let res;
                this.reservations.forEach(reservation => {
                    reservation.rooms.forEach(room => {
                        if(this.roomProp.id === room.id){
                            res = reservation
                            console.log('here')
                        }
                      
                    });
                })

                return res;
              
            },
            guest(){
                return this.guestsProp.find(guest => guest.id === this.reservationDetails.guest_id )
            }
        },
        methods: {
            assignHousekeeper(event){
                if(event){
                }
                this.showHousekeepersModal = true
            },
            getSchedule(room){
               return this.schedules.find(sch => sch.room_id === room.id)
               
            },

            getScheduledHousekeepers(room){
                let scheduledRoom = this.schedules.find(sch => sch.room_id === room.id)
                if(scheduledRoom){
                    this.housekeeperAssigned = true
                    return this.getHousekeeper(scheduledRoom)
                }
            },
            getHousekeeper(schedule){
                let housekeeper = this.housekeepers.find(hk => hk.id === schedule.employee_id)     
                this.scheduledHousekeeper = housekeeper      
                return housekeeper.name + ' ' + housekeeper.surname 
            },
            changeStatus(room, mark){
                if(mark.mark === 'Dirty'){
                    room.cleaning_status = "Dirty" 
                }
                else if(mark.mark === 'Clean'){
                    room.cleaning_status = "Clean" 
                    let schedule = this.getSchedule(this.roomProp)
                    this.removeHousekeeper(schedule)
                }
                else if(mark.mark === 'Ready'){
                    room.cleaning_status = "Ready" 
                }
               
                this.loading = true
                if(room.status === true){
                    room.status = 1
                }
                else if(room.status === false){
                    room.status = 0
                }
                
                RoomServices.putRoom(room, room.id).then((res) => {
                    this.$emit('close')
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
            housekeeperAssigned(){
                this.showHousekeepersModal = false
                this.getScheduledHousekeepers(this.roomProp)
            },
            removeHousekeeper(schedule){
                this.loading = true
                HousekeepingHistoryServices.postHousekeepingHistorySchedule(schedule).then((res) => {
                    this.deleteHousekeepingSchedule(schedule)
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
            deleteHousekeepingSchedule(schedule){
                HousekeepingServices.deleteHousekeepingSchedule(schedule.id).then((res) => {
                    this.$notify.success({
                        title: 'Success',
                        type: 'Success',
                        message: 'Room returned to clean'
                    })
                    // this.$emit('refreshData')
                    
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
            closeHousekeepersModal(){
                this.showHousekeepersModal = false
                this.reRenderKey++
            },
            showHistoryModal(){
                this.showHousekeepingHistoryModal = true
            },
            getHousekeepingHistory(){
                this.loading = true
                HousekeepingHistoryServices.getHousekeepingHistorySchedules().then((res) => {
                    this.housekeepingHistory = res.data
                }).catch((error) => {
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
                reservationServices.getReservations().then((res) => {
                    this.reservations = res.data
                    console.log('this.reservations',this.reservations)
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
            let hk = this.getScheduledHousekeepers(this.roomProp)
            if(hk){
                this.hk = true
            }

            this.getHousekeepingHistory()
            this.getReservations()
        }
    }
</script>

<style lang="scss" scoped>
::v-deep  {
    button.el-button.el-button--primary.el-button--small.is-plain {
        width: 200px;
    }
}
</style>