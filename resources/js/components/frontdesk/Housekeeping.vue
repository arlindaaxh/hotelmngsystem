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

            <div class="flex-wrap gap-10 mt-30" style="gap:20px">
                <el-card v-for="(room,index) in rooms" :key="index" class="box-card" style="width:200px; height:250px; background-color: rgb(245,245,245)">
                    <div  class="text flexed-column align-center justify-center pointer" style="height:200px;" @click="openRoomModal(room)">
                        <div class="flexed-column align-center">
                            <strong>{{room.code}}</strong>
                            <span>{{room.number}}</span>
                    
                            
                        </div>
                        <span>{{room.status === 1 ? 'Available' : 'Booked'}}</span>
                        <span style="align-self:end; bottom:0">{{room.cleaning_status}}</span>
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
            }
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