<template>
    <NormalPopup :no-border="true" :dimmed="true" width="400px">
        <div slot="header" class="flexed justify-between align-center">
            <span class="pointer m-t-5 m-b-5">
                <i class="el-icon-close" @click="$emit('close')"></i>
            </span>
            <span class="label-no-height m-t-5 m-b-5">Confirm Check Out</span>
            <el-button type="primary" @click="save()">Confirm</el-button>
        </div>  
        <div v-loading="loading" class="body">
            <div class="flexed-column">
                <span>By clicking confirm you confirm that the guests </span>

                <strong class="mt-20">NIGHTS</strong>
                <!-- <div class="flexed justify-between bordered p-20 mt-10 align-center" style="border-radius:4px">
                    <el-input-number :min="1" v-model="nights" @change="increaseCheckout()"></el-input-number> 
                    <div class="right-input">
                        <el-input v-model="nights" style="width:150px"></el-input>  
                    </div>
                
                </div> -->
            
            </div>
        </div>

    </NormalPopup>
</template>

<script>
import NormalPopup from '../../NormalPopup.vue';
import dayjs from 'dayjs'
import reservationServices from '../../../services/reservation.services';
import chargeServices from '../../../services/charge.services';
    export default {
        name:'Checkout',
        components: {
            NormalPopup
        },
        props:['reservation', 'optionsData'],
        data() {
            return {
                loading: false,
            }
        },
        methods:{
            open() {
                this.$confirm('This will permanently delete the file. Continue?', 'Warning', {
                confirmButtonText: 'OK',
                cancelButtonText: 'Cancel',
                type: 'warning',
                center: true
                }).then(() => {
                this.$message({
                    type: 'success',
                    message: 'Delete completed'
                });
                }).catch(() => {
                this.$message({
                    type: 'info',
                    message: 'Delete canceled'
                });
                });
            } 
        },
        beforeMount(){
          
        }
    }
</script>

<style lang="scss" scoped>

.right-input {
    ::v-deep .el-input__inner {
        text-align: right;
    }
}

</style>