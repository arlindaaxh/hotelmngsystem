<template>
    <div v-if="$route.name === 'frontdesk-dashboard'" v-loading="loading" class="p-30">
        <div class="flexed" style="gap: 40px;">
            <div>
                <span>House</span>
                <div style="width:400px;">
                    <div class="form-data pointer">
                        <el-card shadow="never" class="card-box" @click.native="goToView('in-house')">
                            <div class="flexed-column">
                                <strong>In House</strong>
                                <span class="pt-20" style="font-size:25px; font-weight:500">{{inHouse.length}}</span>
                            </div>
                        </el-card>
                        <el-card shadow="never" class="card-box" @click.native="goToView('departures')">
                            <div class="flexed-column">
                                <strong>Departures</strong>
                                <span class="pt-20" style="font-size:25px; font-weight:500">{{departures.length}}</span>
                            </div>
                        </el-card>
                        <el-card shadow="never" class="card-box" @click.native="goToView('housekeeping', 'Dirty')">
                            <div class="flexed-column">
                                <strong>Dirty Rooms</strong>
                                <span class="pt-20" style="font-size:25px; font-weight:500">{{dirtyRooms.length}}</span>
                            </div>
                        </el-card>
                        <el-card shadow="never" class="card-box" @click.native="goToView('housekeeping', 'Ready')">
                            <div class="flexed-column">
                                <strong>Ready Rooms</strong>
                                <span class="pt-20" style="font-size:25px; font-weight:500">{{readyRooms.length}}</span>
                            </div>
                        </el-card>
                    </div>
                </div>
            </div>

            <div>
                <span>Bookings</span>
                <div style="width:400px;">
                    <div class="form-data">
                        <el-card shadow="never" class="card-box">
                            Arrivals
                        </el-card>
                        <el-card shadow="never" class="card-box">
                            No Show
                        </el-card>
                        <el-card shadow="never" class="card-box">
                            Booked Today
                        </el-card>
                        <el-card shadow="never" class="card-box">
                            Groups
                        </el-card>
                    </div>
                </div>
            </div>

            <div>
                <span>Availability</span>
                <div style="width:400px;">
                    <div class="form-data pointer">
                        <el-card shadow="never" class="card-box" @click.native="goToView('housekeeping', 'All')">
                           <div class="flexed-column">
                                <strong>Total Rooms</strong>
                                <span class="pt-20" style="font-size:25px; font-weight:500">{{rooms.length}}</span>
                            </div>
                        </el-card>
                        <el-card shadow="never" class="card-box" @click.native="goToView('availability')">
                            <div class="flexed-column" >
                                <strong>Available</strong>
                                <span class="pt-20" style="font-size:25px; font-weight:500">{{ availableRooms.length}}</span>
                            </div>
                          
                        </el-card>
                         <el-card shadow="never" class="card-box" @click.native="goToView('reservations-list')">
                            <div class="flexed-column" >
                                <strong>Booked today</strong>
                                <span class="pt-20" style="font-size:25px; font-weight:500">{{ bookedToday.length}}</span>
                            </div>
                          
                        </el-card>
                        <el-card shadow="never" class="card-box">
                            Ready Rooms
                        </el-card>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <el-button @click="openBookingTypeModal()">New Booking</el-button>
        </div>


        <new-booking-type-modal v-if="showNewBookingTypeModal" @close="showNewBookingTypeModal = false"/>
      
    </div>
    <div v-else>
        <router-view/>
    </div>
</template>

<script>
import RoomServices from '../../services/room.services'
import HousekeepingServices from '../../services/housekeeping.services'
import DepartmentServices from '../../services/department.services'
import EmployeeServices from '../../services/employee.services'
import NewBookingTypeModal from '../../components/frontdesk/dashboard/NewBookingTypeModal.vue'
import reservationServices from '../../services/reservation.services'
import dayjs from 'dayjs'
    export default {
        components: {
            NewBookingTypeModal
        },
        data() {
            return {
                loading: false,
                employees: [],
                departments: [],
                rooms: [],
                schedules: [],
                showNewBookingTypeModal: false,
                reservations: []
            }
        },
        beforeMount(){
            this.getOptionsData()
        },
        computed: {
            filteredRooms(){
                let result = this.rooms
                if(this.rooms && this.rooms.length > 0){
    
                    result = this.rooms.filter((room) => 
                        room.cleaning_status === this.selectedFilter 
                    )
                    if(this.selectedFilter === 'All'){
                        result = this.rooms
                    }

                    if (this.query && this.query.length > 0) {
                        result = result.filter(
                            (r) =>
                                r.type?.toLowerCase().includes(this.query.toLowerCase()) ||
                                r.code?.toLowerCase().includes(this.query.toLowerCase())
                        );
                    }
              
                }
                  
                return result
              
            },
            availableRooms(){
                let availableRooms = []
                availableRooms = this.rooms.filter(room => this.reservations.some(b => b.rooms.find(r => room.id === r.id && b.active === 0)))
                let array = []

                this.rooms.forEach(room => {
                    this.reservations.forEach(booking => {
                        if(booking.rooms.some(item => item.id === room.id)){
                            array.push(room)
                        }
                    })
                })

                let nonReservedRooms = []
                nonReservedRooms = this.rooms.filter(room => !array.includes(room))
                return availableRooms.concat(nonReservedRooms)
            },

            housekeepers(){
                const housekeepers = []
                let allEmployees = this.employees.filter(employee => this.departments.some(dep => dep.id === employee.department_id))
                allEmployees.forEach(emp => {
                    let depName = this.getName(emp.department_id)
                    if(depName && depName === 'Housekeeping'){
                        let found = housekeepers.find(element => element.id === emp.id)
                        if(!found) {
                            housekeepers.push(emp) 
                        }
                    }
                })
                return housekeepers
            },
        
            
            dirtyRooms(){
                let dirtyRooms = []
                this.rooms.forEach(room => {
                    if(room.cleaning_status === 'Dirty'){
                        dirtyRooms.push(room)
                    }
                })
                return dirtyRooms
            },
            cleanRooms(){
                let rooms = []
                this.rooms.forEach(room => {
                    if(room.cleaning_status === 'Clean'){
                        rooms.push(room)
                    }
                })
                return rooms
            },
            readyRooms(){
                let rooms = []
                this.rooms.forEach(room => {
                    if(room.cleaning_status === 'Ready'){
                        rooms.push(room)
                    }
                })
                return rooms
            },
            inHouse(){
                return this.reservations.filter(reservation => reservation.is_completed === 1 && reservation.active === 1)
            },  
            departures(){
                return this.reservations.filter(reservation => reservation.is_completed === 1 && reservation.active === 0)
            },
            bookedToday(){
                let currentDate = this.dayjs().format('YYYY-MM-DD')
                console.log('current', currentDate)
                return this.reservations.filter(reservation => reservation.created_at === currentDate)
            }    
        },
        methods: {
            getOptionsData() {
                this.loading = true;
                Promise.all(
                    [
                        EmployeeServices.getEmployees(),
                        DepartmentServices.getDepartments(),
                        RoomServices.getRooms(),
                        HousekeepingServices.getHousekeepingSchedules(),
                        reservationServices.getReservations(),
                    ].map((p, index) =>
                        p.then(
                            (v) => ({
                                data: v.data,
                                status: "success",
                                type:
                                    index == 0 ? "employees"
                                    : index == 1 ? "departments"
                                    : index == 2 ? "rooms"
                                    : index == 3 ? "schedules" :
                                    index === 4 ? "reservations" : "unknown"
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
                            if (res.type == "employees") {
                                this.employees = res.data;
            
                            } else if (res.type == "departments") {
                                this.departments = res.data;
                              
                            } else if (res.type == "rooms") {
                                this.rooms = res.data
                                this.rooms.forEach(room => {
                                    this.$set(room, 'checked', false)
                                })
                               
                            }else if(res.type == "schedules"){
                                this.schedules = res.data
                              
                            }else if(res.type == "reservations"){
                                this.reservations = res.data
                                this.reservations.forEach(res => {
                                    res.created_at = res.created_at.split('T')
                                    console.log('res', res.created_at[0])
                                })
            
                            }
                        });
                    }
                })
                .catch((error) => {
                    this.loading = false;
                    throw error;
                })
                .finally(() => {
                    this.loading = false;
                });
            },
            goToView(routeName, selectedFilter){
                this.$router.push({
                    name: routeName,
                    // if(selectedFilter){
                        params: {
                            selectedFilter: selectedFilter 
                        }
                    // }
                   
                   
                })
            },
            openBookingTypeModal(){
                this.showNewBookingTypeModal = true
            }
       
        }
        
    }
</script>

<style lang="scss" scoped>
.form-data {
    gap: 0px;

    .card-box {
        height: 150px;
        text-align: center;
        
    }
}
</style>