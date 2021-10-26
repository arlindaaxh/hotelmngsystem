<template>
    <div class="form-max-width" v-if="$route.name === 'housekeeping'" v-loading="loading">
        <div class="shortcuts-header flexed justify-between">
            <h4>Housekeeping</h4>
        </div>
        <div class="one-column-list">
            <div class="flexed justify-between m-b-20">
                <el-input class="search-input" size="big" placeholder="Search rooms by number or code" v-model="query" :style="'max-width:450px'">
                <i class="el-icon-search el-input__icon" slot="suffix"></i>
                </el-input>
              
            </div>

            <div class="flexed mt-30" style="background-color: rgb(245,245,245); height:100px; padding:10px; border-radius:10px;">
                <!-- <el-button>DIRTY ({{dirtyRooms.length}})</el-button>
                <el-button>CLEAN ({{cleanRooms.length}})</el-button>
                <el-button>READY ({{readyRooms.length}})</el-button> -->

                <el-checkbox v-model="filterModel.dirty" label="DIRTY" border></el-checkbox>
                <el-checkbox v-model="filterModel.clean" label="CLEAN" border></el-checkbox>
                <el-checkbox v-model="filterModel.ready" label="READY" border></el-checkbox>
            </div>

            <div class="flex-wrap gap-10 mt-30" style="gap:20px">
                <el-card v-for="(room,index) in filteredRoomsA" :key="index" class="box-card" style="width:200px; height:250px; background-color: rgb(245,245,245)">
                    <div  class="text flexed-column align-center justify-center pointer" style="height:200px;" @click="openRoomModal(room)">
                        <div class="flexed-column align-center mb-20">
                            <span>{{room.code}}</span>
                            <strong>{{room.number}}</strong>
                        
                             <!-- <span>{{room.status === 1 ? 'Available' : 'Booked'}}</span> -->
                     
                        </div>
                        <span style="border:1px solid ;padding-top:3px; padding-bottom:3px; border-radius:20px;" 
                            :class="room.cleaning_status === 'Dirty' ? 'pl-10 pr-10 text-danger border-danger' : 'text-primary border-primary pl-10 pr-10'"
                        >{{room.cleaning_status}}</span>
                   
                    </div>
                </el-card>
            </div>
        </div>
        <room-modal v-if="showRoomModal" @close="showRoomModal = false" :roomProp="roomProp" />
    </div>
</template>

<script>
import RoomServices from '../../services/room.services'
import RoomModal from './RoomModal.vue'
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
                filterModel: {dirty: 'Dirty', clean:'Clean', ready: 'Ready'}
            }
        },
        computed: {
            filteredRoomsA() {
                let result = this.rooms
                if(this.rooms && this.rooms.length > 0){
                    result = this.rooms.filter((room) =>
                        room.cleaning_status === this.filterModel.dirty ||
                        (!this.filterModel.dirty && !this.filterModel.clean && !this.filterModel.ready) ||
                        (this.filterModel.dirty && this.filterModel.clean && this.filterModel.ready) ||
                        room.cleaning_status === this.filterModel.clean || 
                        room.cleaning_status === this.filterModel.ready 
                    );
                    if (this.query && this.query.length > 0) {
                        result = result.filter(
                            (r) =>
                                r.type?.toLowerCase().includes(this.query.toLowerCase()) ||
                                r.code?.toLowerCase().includes(this.query.toLowerCase())
                        );
                    }
                }
                console.log('res',)
                return result;
                
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
            getRooms(){
                this.loading = true
                RoomServices.getRooms().then((res) => {
                    this.rooms = res.data
                    console.log('rooms', this.rooms)
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
            openRoomModal(room){
                this.roomProp = room
                this.showRoomModal = true
            }
        },
        beforeMount(){
            this.getRooms()
           
        },
    
    }
</script>

<style lang="scss" scoped>

</style>