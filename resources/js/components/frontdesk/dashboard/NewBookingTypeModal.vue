<template>
    <NormalPopup :no-border="true" :dimmed="true" width="400px">
        <div slot="header" class="flexed justify-between align-center">
            <span class="pointer m-t-5 m-b-5">
                <i class="el-icon-close" @click="$emit('close')"></i>
            </span>
            <span class="label-no-height m-t-5 m-b-5">Booking Type</span>
            <span></span>
        </div>  
        <div v-loading="loading" class="body">
            <div>
                <el-button @click="createNewBooking('Individual')">Individual Booking</el-button>
            </div>
        </div>

    </NormalPopup>
</template>

<script>
import NormalPopup from '../../NormalPopup.vue';
    export default {
        name:'NewBookingTypeModal',
        components: {
            NormalPopup
        },
        props: ['checkin', 'checkout','adults','children'],
        data() {
            return {
                loading: false,
                bookingData: null,
            }
        },
        methods: {
            createNewBooking(bookingType){
                this.$router.push({
                    name: 'new-booking',
                    params: {
                        bookingType: bookingType,
                        bookingData: this.bookingData
                    }
                })
            }
        },
        beforeMount(){
            this.bookingData = {
                checkin: this.checkin,
                checkout: this.checkout,
                adults: this.adults,
                children: this.children
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>