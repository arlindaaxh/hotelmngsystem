<template>
    <div class="form-max-width">
        <div class="flexed justify-between align-center m-b-20" style="margin-bottom:30px;">
            <span @click="goBack()" class="flexed align-center pointer">
                <arrow-left-icon size="1.2x" class="m-r-5" />
                <h5>Create a New Booking</h5>
            </span>
    
        </div>
        <div>
            <el-steps :active="active" finish-status="success">
                <el-step title="Guest Data"></el-step>
                <el-step title="Charges"></el-step>
                <el-step title="Payment"></el-step>
            </el-steps>

            <el-button style="margin-top: 12px;" @click="next">Next step</el-button>


        </div>
    </div>

    
</template>

<script>
import {ArrowLeftIcon} from 'vue-feather-icons'
    export default {
        name: 'NewBooking',
        components: {
            ArrowLeftIcon
        },
        data() {
            return {
                active: 0
            }
          
        },
        methods: {
            next(){
                if (this.active++ > 2) this.active = 0;
            },
            goBack(){
                this.$router.push({
                    name: 'frontdesk-dashboard'
                })
            } 
        }
    }
</script>

<style lang="scss" scoped>

</style>