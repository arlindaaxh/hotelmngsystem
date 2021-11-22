<template>
    <div>
        <div class="filters flexed align-center p-30 " style="gap:20px;">
            <div class="flexed-column" style="gap:5px">
                <span>Check In</span>
                <el-date-picker
                    v-model="value1"
                    type="date"
                    placeholder="Pick a date"
                    default-value="2010-10-01">
                </el-date-picker>
            </div>
           
            <div class="flexed-column" style="gap:5px">
                <span >Check Out</span>
                <el-date-picker
                    v-model="value1"
                    type="date"
                    placeholder="Pick a date"
                    default-value="2010-10-01">
                </el-date-picker>
            </div>

            <div class="flexed-column" style="gap:5px;">
                <span>Guests</span>
                <div class="flexed" style="gap:20px; margin-left:50px;">
                    <div>
                        <span>Adults <i class="el-icon-user-solid"></i></span>
                        <el-input-number v-model="num" @change="handleChange" :min="1" :max="10"></el-input-number> 
                    </div>
                    <div>
                    <span>Children <i class="el-icon-user-solid"></i></span>
                        <el-input-number v-model="num" @change="handleChange" :min="1" :max="10"></el-input-number> 
                    </div>
                </div>
            </div>
           
        </div>

        <div class="rooms-section p-30">
            <div>
                <el-card class="box-card">
                    <div class="flexed justify-between" style="align-items:end">
                        <div class="flexed-column" style="gap:20px">
                            <span style="font-weight:550">
                                Room Type
                            </span>
                            <span>
                                Price - $0.00
                            </span>
                        </div>
                 
                        <el-button  style="color:#ff7b50" @click="openBookingTypeModal()">Book</el-button>
                    </div>
                   
                </el-card>
            </div>
        </div>
        <new-booking-type-modal v-if="showBookingTypeModal" @close="showBookingTypeModal = false"/>
    </div>
</template>

<script>
import NewBookingTypeModal from '../../components/frontdesk/dashboard/NewBookingTypeModal.vue'
    export default {
  components: { NewBookingTypeModal },
        data() {
            return {
                value1: null,
                showBookingTypeModal: false,
            }
        },
        methods: {
            openBookingTypeModal(){
                this.showBookingTypeModal = true
            }
        }
    }
</script>

<style lang="scss" scoped>
.box-card{
    width:300px;
}
</style>