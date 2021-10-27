<template>

    <NormalPopup :no-border="true" :dimmed="true" width="400px">
        <div slot="header" class="flexed justify-between align-center">
            <span class="pointer m-t-5 m-b-5">
                <i class="el-icon-close" @click="$emit('close')"></i>
            </span>
            <span class="label-no-height m-t-5 m-b-5">{{roomProp.code}}</span>
            <el-button size="small" type="primary" plain>Housekeeping history</el-button>
        </div>
        <div v-loading="loading" v-if="roomProp.cleaning_status === 'Dirty'" class="body">
            <el-button-group>
                <el-button @click="activeIndex = 1" :type="activeIndex === 1 ? 'primary' : 'default'">Schedule Details</el-button>
                <el-button @click="activeIndex = 2" :type="activeIndex === 2 ? 'primary' : 'default'">Reservation Details</el-button>
                <el-button @click="activeIndex = 3" :type="activeIndex === 3 ? 'primary' : 'default'">Service Options</el-button>
            </el-button-group>

            <div class="bordered mt-10 " style="border:1px solid lightgrey;">
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
                    <el-button type="primary" plain @click="assignHousekeeper()">Assign Housekeeper</el-button>
                </div>
                <div class="flexed justify-between  align-center p-10" style="border-bottom:1px solid lightgrey;">
                    <span>Facilities</span>
                    <i class="el-icon-arrow-right"></i>
                </div>
                <div class="flexed justify-between  align-center p-10 w-100">
                    <el-button type="primary" class="w-100" plain>Ready for guest</el-button>
                </div>
            </div>
        </div>
        <div v-loading="loading" v-else class="body" style="height: 400px;">
            <div class="flexed-column w-100" style="gap:20px;">
                <div>
                    <el-button type="primary" plain class="w-100">Mark Dirty</el-button>   
                </div>
             
                <div v-if="roomProp.cleaning_status === 'Ready'">
                    <el-button type="primary" plain class="w-100">Return to clean</el-button> 
                </div>
                <div v-if="roomProp.cleaning_status === 'Clean'">
                    <el-button type="primary" plain class="w-100">Mark Ready</el-button> 
                </div>


                <el-button type="primary" plain class="w-100" >Ready for guest</el-button>
            </div>
        </div>

        <housekeepers-modal :room="roomProp" v-if="showHousekeepersModal" @close="showHousekeepersModal = false"/>
    </NormalPopup>

</template>

<script>
import NormalPopup from '../NormalPopup.vue'
import HousekeepersModal from './HousekeepersModal.vue'
    export default {
        name: 'RoomModal',
        components: {
            NormalPopup,
                HousekeepersModal
        },
        props: ['roomProp'],
        data() {
            return {
                loading: false,
                activeIndex: 1,
                showHousekeepersModal: false,
            }
        },
        methods: {
            assignHousekeeper(){
                this.showHousekeepersModal = true
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>