<template>
    <div v-if="$route.name === 'frontdesk-dashboard'" v-loading="loading" class="p-30">
        <div class="flexed" style="gap: 40px;">
            <div>
                <span>House</span>
                <div style="width:400px;">
                    <div class="form-data pointer">
                        <el-card shadow="never" class="card-box">
                            In House
                        </el-card>
                        <el-card shadow="never" class="card-box">
                            Departures
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
                <span>House</span>
                <div style="width:400px;">
                    <div class="form-data">
                        <el-card shadow="never" class="card-box">
                            In House
                        </el-card>
                        <el-card shadow="never" class="card-box">
                            Departures
                        </el-card>
                        <el-card shadow="never" class="card-box">
                            Dirty Rooms
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


        <new-booking-type-modal v-if="showNewBookingTypeModal" @click="showNewBookingTypeModal = false"/>
      
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
import NewBookingTypeModal from '../frontdesk/dashboard/NewBookingTypeModal.vue'
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
                    ].map((p, index) =>
                        p.then(
                            (v) => ({
                                data: v.data,
                                status: "success",
                                type:
                                    index == 0 ? "employees"
                                    : index == 1 ? "departments"
                                    : index == 2 ? "rooms"
                                    : index == 3 ? "schedules"  : "unknown"
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
                                console.log('empl', this.employees)
                            } else if (res.type == "departments") {
                                this.departments = res.data;
                                console.log('depts', this.departments)
                            } else if (res.type == "rooms") {
                                this.rooms = res.data
                                this.rooms.forEach(room => {
                                    this.$set(room, 'checked', false)
                                })
                                console.log('rooms', this.rooms)
                            }else if(res.type == "schedules"){
                                this.schedules = res.data
                                console.log('scj',this.schedules)
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
                console.log('routeName', routeName)
                this.$router.push({
                    name: routeName,
                    params: {
                        selectedFilter: selectedFilter 
                    }
                   
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