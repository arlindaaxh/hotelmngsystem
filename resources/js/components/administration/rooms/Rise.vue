<template>
    <NormalPopup :no-border="true" :dimmed="true" width="500px">
        <div slot="header" class="flexed justify-between align-center">
            <span class="pointer m-t-5 m-b-5">
                <i class="el-icon-close" @click="$emit('close')"></i>
            </span>
            <strong class="m-t-5 m-b-5">Add Room Rise</strong>
            <el-button @click="save">Save</el-button>
        </div>
        <div v-loading="loading" class="body">
            <div class="flexed-column">
                <span class="text-grey">The rise will be added to {{selectedRooms.length}} {{selectedRooms.length === 1 ? 'room' : 'rooms'}}</span>
                <!-- <div class="flexed mt-20" style="gap:30px">
                    <el-button class="w-100">10%</el-button>
                    <el-button class="w-100">20%</el-button>
                    <el-button class="w-100">30%</el-button>
                    <el-button class="w-100">50%</el-button>        
                </div> -->

                <div style="max-height:500px; padding-top: 20px">
                    <el-table
                        :data="selectedRooms"
                        style="width: 100%"
                        row-key="id"
                    >
                        <el-table-column
                            prop="type"
                            label="Type"
                            width="180">
                        </el-table-column>
                        <el-table-column
                            prop="code"
                            label="Code"
                            width="85">
                        </el-table-column>
                        <el-table-column
                            prop="room_price_per_night"
                            label="Room Price"
                            width="100"
                            align="right"
                        ></el-table-column>
                        <el-table-column
                            prop="rise"
                            label="Rise"
                            width="125"
                        >
                            <template slot-scope="scope" >
                                <el-input v-model="scope.row.rise" type="small" style="width:100px" @input="calculateFinalPrice(scope.row)">
                                    <template slot="append">
                                        <span v-if="scope.row.discountType === 'percent'" @click="changeRiseType(scope.row)"  class="pointer" >%</span>
                                        <span v-else @click="changeRiseType(scope.row)"  class="pointer">USD</span>
                                    </template>
                                </el-input>
                            </template>
                        </el-table-column>
                        <el-table-column
                            prop="newRoomPrice"
                            label="Final Price"
                            width="125"
                        >
                            <template slot-scope="scope">
                                <el-input v-model="scope.row.newRoomPrice" type="small" style="width:100px">
                                </el-input>
                            </template>
                        </el-table-column>
                    </el-table>
                </div>
            </div>
        </div>
        <!-- <div slot="bottom" class="bottom">
            <el-button @click="$emit('close')">Cancel</el-button>
            <el-button type="danger">Delete</el-button>
        </div> -->
    </NormalPopup>
</template>

<script>
import roomServices from '../../../services/room.services'
import NormalPopup from '../../NormalPopup.vue'
    export default {
        name: 'Rise',
        components: {
            NormalPopup
        },
        props: ['selectedRooms'],
        data() {
            return {
                loading: false,
                discountType: 'percent'
            }
        },
        methods: {
            changeRiseType(room){
                if(room.discountType === 'percent'){
                    room.discountType = 'amount'
                    room.newRoomPrice = isFinite(room.room_price_per_night + room.rise * 1 ) ? (room.room_price_per_night + room.rise * 1 * 1)?.toFixed(2) : 0
                }else {
                    room.discountType = 'percent'
                    room.newRoomPrice = isFinite(room.room_price_per_night + (room.room_price_per_night * (room.rise * 1 / 100))) ? 
                    (room.room_price_per_night + (room.room_price_per_night * (room.rise * 1 / 100)))?.toFixed(2) : 0
                }
            },
            calculateFinalPrice(room){
                if(room.discountType === 'percent'){
                    room.newRoomPrice = isFinite(room.room_price_per_night + (room.room_price_per_night * (room.rise * 1 / 100))) ? 
                    (room.room_price_per_night + (room.room_price_per_night * (room.rise * 1 / 100)))?.toFixed(2) : 0
                }else {
                    room.newRoomPrice = isFinite(room.room_price_per_night + room.rise * 1) ? (room.room_price_per_night + room.rise * 1 )?.toFixed(2) : 0
                }
            },
            save(){
               

                this.selectedRooms.forEach(room => {
                    room.room_price_per_night = room.newRoomPrice
                })

                let obj = {
                    rooms: this.selectedRooms
                }

                 console.log('rooms', this.selectedRooms)
           
                this.loading = true
                
                roomServices.updateRooms(obj).then(() => {
                      this.$notify.success({
                        title:'Success',
                        type: 'success',
                        message: 'Room were updated successfully'
                    })
                    this.$emit('close', true)
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
            this.selectedRooms.forEach(element => {
                this.$set(element, 'rise',  0)
                this.$set(element, 'newRoomPrice',  element.room_price_per_night?.toFixed(2))
                this.$set(element, 'discountType',  'percent')
            });
        }
    }
</script>

<style lang="scss" scoped>

::v-deep .el-input-group__append{
    padding-left: 12px;
    padding-right: 12px;
}

</style>