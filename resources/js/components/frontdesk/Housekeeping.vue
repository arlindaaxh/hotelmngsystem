<template>
    <div class="form-max-width" v-if="$route.name === 'housekeeping'" v-loading="loading">
        <div class="shortcuts-header flexed justify-between">
            <h4>Housekeeping</h4>
        </div>

        <div class="flexed justify-between  mt-30" style="gap:40px;align-items:start !important">
            <div class="one-column-list">
                <div class="flexed justify-between m-b-20">
                    <el-input class="search-input" size="big" placeholder="Search rooms by number or code" v-model="query" :style="'max-width:450px'">
                    <i class="el-icon-search el-input__icon" slot="suffix"></i>
                    </el-input>
                
                </div>

                <div class="flexed mt-30 align-center" style=" height:100px;  border-radius:10px;">
                    <el-button :type="selectedFilter === 'All' ? 'primary' : ''" @click="selectedFilter = 'All'">ALL ({{rooms.length}})</el-button>
                    <el-button :type="selectedFilter === 'Dirty' ? 'primary' : ''" @click="selectedFilter = 'Dirty'">DIRTY ({{dirtyRooms.length}})</el-button>
                    <el-button :type="selectedFilter === 'Clean' ? 'primary' : ''" @click="selectedFilter = 'Clean'">CLEAN ({{cleanRooms.length}})</el-button>
                    <el-button :type="selectedFilter === 'Ready' ? 'primary' : ''" @click="selectedFilter = 'Ready'">READY ({{readyRooms.length}})</el-button>
                    <!-- <el-radio-group v-model="selectedFilter">
                        <el-radio label="ALL" border></el-radio>
                        <el-radio label="Dirty" border></el-radio>
                        <el-radio label="Clean" border></el-radio>
                        <el-radio  label="Ready" border></el-radio>
                    </el-radio-group> -->


                    <el-button :type="canSelect ? 'primary' : 'default'" @click="assignHousekeeperToRooms()" size="big">Select Rooms</el-button>
                </div>
                <h5 v-if="canSelect">Select Rooms ({{selectedRooms.length}}/{{rooms.length}})</h5>
                <div class="flex-wrap gap-10 mt-30" style="gap:20px">
                    <el-card v-for="(room,index) in filteredRooms" :key="index" class="box-card" :style="{border: room.checked && canSelect ? '1px solid  #ff7b50' : ''}">
                        <div  class="text flexed-column align-center justify-center pointer " style="height:200px; " @click="openRoomModalOrSelect(room)">
                            <div style="flex:2">
                            <div class="flexed-column align-center mb-20">
                                <span>{{room.code}}</span>
                                <strong>{{room.number}}</strong>
                                <!-- <span>{{room.status === 1 ? 'Available' : 'Booked'}}</span> -->
                                </div>
                                <span style="border:1px solid ;padding-top:3px; padding-bottom:3px; border-radius:20px;" 
                                    :class="room.cleaning_status === 'Dirty' ? 'pl-10 pr-10 text-danger border-danger' : 'text-primary border-primary pl-10 pr-10'"
                                >{{room.cleaning_status}}
                                </span>  
                            </div>
                        
                            <span>
                                    {{getScheduledHousekeepers(room)}} 
                            </span>
                    
                        </div>
                    </el-card>
                </div>

                <el-alert  v-if="!loading && filteredRooms && filteredRooms.length === 0"
                    type="info" 
                    :closable="false" 
                    class="mt-30"
                    title="No results found" 
                    show-icon
                />

                
            </div>
            <div>
                <h4>Housekeepers</h4>
                

                <el-button v-if="canSelect && selectedHousekeeper" @click="saveSchedules()" size="big">Assign housekeeper</el-button>
                <div class="flexed-column" style="gap:20px; overflow-y:scroll; width:400px; max-height:600px">
                
                    <el-radio-group v-model="selectedHousekeeper">
                        <el-card v-for="(housekeeper,index) in housekeepers" :key="index" class="mt-10">
                            <el-radio :label="housekeeper.id" style="padding-top:0.5rem">  
                                <strong>{{housekeeper.name}}</strong>
                                <strong>{{housekeeper.surname}}</strong>
                            </el-radio>
                        </el-card>
                    </el-radio-group>
                </div>
            </div>
           
        </div>
        
        <room-modal v-if="showRoomModal" @close="closeRoomModal()" :roomProp="roomProp" :housekeepers="housekeepers" :departments="departments" :schedules="schedules" @refreshData="refreshData()" />
    </div>
</template>

<script>
import RoomServices from '../../services/room.services'
import RoomModal from './RoomModal.vue'
import HousekeepingServices from '../../services/housekeeping.services'
import DepartmentServices from '../../services/department.services'
import EmployeeServices from '../../services/employee.services'
    export default {
        components: {
            RoomModal 
        },
        data() {
            return {
                loading: false,
                query: "",
                rooms: [],
                showRoomModal: false,
                roomProp: null,
                filterModel: {dirty: 'Dirty', clean:'Clean', ready: 'Ready'},
                schedules: [],
                employees:[],
                departments: [],
                selectedHousekeeper: null,
                canSelect: false,
                selectedRooms: [],
                selectedFilter: 'All'
            }
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
        
            openRoomModalOrSelect(room){
                if(this.canSelect && (room.cleaning_status === 'Clean' || room.cleaning_status === 'Ready')){
                    if(!room.checked){
                        this.selectedRooms.push(room.id)  
                        room.checked = true
                    }
                    else {
                        room.checked = false
                        let x = this.selectedRooms.find(r => r === room.id)
                        let index = this.selectedRooms.indexOf(x)
                        this.selectedRooms.splice(index,1)
            
                    }  
                }else if(this.canSelect && room.cleaning_status === 'Dirty'){
                    this.$notify.error({
                        title: 'Info',
                        type: 'Error',
                        message: 'This room already has a housekeeper assigned'
                    })
                }else {
                    room.checked = false
                    if(this.selectedRooms.length > 0){
                        this.selectedRooms = []
                    }
                    this.roomProp = room
                    this.showRoomModal = true
                }
                
            },
            closeRoomModal(){
                this.showRoomModal = false
                this.$nextTick(() => {
                   this.refreshData() 
                })
                
            },
            isSelected(room){
                let found = this.selectedRooms.find(r => r === room.id)
                if(found){
                    return true
                }
                return false
            },
        
            assignHousekeeperToRooms(){
                this.canSelect = !this.canSelect
            },
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
             getName(departmentId){
                let found = this.departments?.find(element => element.id === departmentId)
                if(found){
                    return found.name
                }
            },
                
            getScheduledHousekeepers(room){
                let scheduledRoom = this.schedules.find(sch => sch.room_id === room.id)
                if(scheduledRoom){
                    return this.getHousekeeper(scheduledRoom)
                }
                  //    let scheduledHousekeepers = this.housekeepers.filter(sch => this.schedules.some(hk => hk.employee_id === sch.id && this.rooms.some(room => room.id === hk.room_id)))
                //    console.log('scheduledHousekeepers',scheduledHousekeepers)
            },
            getHousekeeper(schedule){
                let housekeeper = this.housekeepers.find(hk => hk.id === schedule.employee_id)         
                return housekeeper.name + ' ' + housekeeper.surname 
            },

            saveSchedules(){
         
                this.selectedRooms.forEach(room => {
                    let payload = {
                        room_id: room,
                        employee_id: this.selectedHousekeeper
                    }
                    this.loading = true
                    HousekeepingServices.postHousekeepingSchedule(payload).then((res) => {
                        console.log('payload', payload)
                        this.refreshData()
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
                })
            
            },
            refreshData(){
                console.log('here')
                this.getOptionsData()
            }
            // selectHousekeeper
        },
        beforeMount(){
            // this.getRooms()
            // this.getHousekeepingSchedules()
            this.getOptionsData()
            if(this.$route.params.selectedFilter){
                console.log('this.$route.params.selectedFilter',this.$route.params.selectedFilter)
                this.selectedFilter = this.$route.params.selectedFilter
            }
           
        },
        beforeRouteUpdate(to, from, next){
            if(to.name === 'housekeeping') this.getOptionsData
            next()
        },
        
    
    }
</script>

<style lang="scss" scoped>
.form-max-width {
    max-width: 1500px;

    .box-card {
        width:200px; 
        height:250px; 
        background-color: rgb(245,245,245);
    }
}

</style>

