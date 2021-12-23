<template>
    <NormalPopup :no-border="true" :dimmed="true" width="400px">
        <div slot="header" class="flexed justify-between align-center">
            <span class="pointer m-t-5 m-b-5">
                <i class="el-icon-close" @click="$emit('close')"></i>
            </span>
            <span class="label-no-height m-t-5 m-b-5">Change Check Out Date</span>
            <el-button type="primary" @click="save()">Save</el-button>
        </div>  
        <div v-loading="loading" class="body">
            <div class="flexed-column">
                <strong>Check Out</strong>
                <div class="flexed justify-between bordered p-20 mt-10" style="border-radius:4px">
                    <span style="font-weight:500">Check Out Date</span>
                    <span style="font-weight:500">{{checkout_date}}</span>
                </div>

                <strong class="mt-20">NIGHTS</strong>
                <div class="flexed justify-between bordered p-20 mt-10 align-center" style="border-radius:4px">
                    <el-input-number :min="1" v-model="nights" @change="increaseCheckout()"></el-input-number> 
                    <div class="right-input">
                        <el-input v-model="nights" style="width:150px"></el-input>  
                    </div>
                
                </div>
            
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
        name:'CheckoutModal',
        components: {
            NormalPopup
        },
        props:['reservation', 'optionsData'],
        data() {
            return {
                nights: 0,
                loading: false,
                checkout_date: null
            }
        },
        methods:{
            save(){
                this.reservation.date_out = this.checkout_date

                // this.charge = this.getCharges()
                // this.charge.room_price += this.nights * this.reservation.rooms[0].price_per_night
                this.loading = true
                reservationServices.putReservation(this.reservation, this.reservation.id).then((res) => {
                   this.$notify.success({
                        title: 'Success',
                        type: 'Success',
                        message: 'Check Out Date was updated successfully'
                    })
                    this.editChargesOfRoom()
                    this.$emit('close')
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
            editChargesOfRoom(){
                

                this.charge = this.getCharges()
                console.log('nu', this.nights)
                console.log('r[r', this.reservation.rooms)

                this.charge.room_price += (this.nights * this.reservation.rooms[0].room_price_per_night)
                this.charge.total += (this.nights * this.reservation.rooms[0].room_price_per_night)
                console.log('this.charge.room_price',this.charge.room_price)
                this.loading = true
                chargeServices.putCharge(this.charge, this.charge.id).then((res) => {
                   this.$notify.success({
                        title: 'Success',
                        type: 'Success',
                        message: 'Charge was updated successfully'
                    })
                
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
            increaseCheckout(){
                let currentDate = dayjs(this.checkout_date).date()
                this.checkout_date = dayjs().set('date', currentDate + 1).format('YYYY-MM-DD')
            },
            getCharges(){
                return this.optionsData.charges.find(ch => ch.reservation_id === this.reservation.id)
            },
           
        },
        beforeMount(){
            let chd = this.reservation.date_out
            let currentDate = dayjs(chd).date()
            this.checkout_date = dayjs().set('date', currentDate + 1).format('YYYY-MM-DD')
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