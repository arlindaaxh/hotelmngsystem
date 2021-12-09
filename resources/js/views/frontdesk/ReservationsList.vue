<template>
    <div class="form-max-width" v-if="$route.name === 'reservations-list'" v-loading="loading">
        <div class=" flexed justify-between">
            <h4>Bookings</h4>
            <div>
                <el-button size="big" style="background-color:#ff7b50; border-radius:15px;color:white" @click="createNewReservation()">New</el-button>
            </div>
        </div>
        <div class="one-column-list">
        <div class="flexed justify-between m-b-20">
        
            <div class="flexed jutify-between" style="gap: 10px">
                <div class="flexed-column" style="gap:5px">
                    <span>Check In</span>
                    <el-date-picker
                        v-model="checkinDate"
                        type="date"
                        placeholder="Pick a date"
                        :default-value="currentDay"
                        @change="formatDate()"
                        >
                    </el-date-picker>
                </div>
           
                <div class="flexed-column" style="gap:5px">
                    <span >Check Out</span>
                    <el-date-picker
                        v-model="checkoutDate"
                        type="date"
                        placeholder="Pick a date"
                        :default-value="dayAfterToday"
                        @change="formatDate()">
                    </el-date-picker>
                </div>
            </div>
           
        </div>

            <div class="pl-15 mt-30 table-sort">
                <div class="flexed align-center " style="gap:10px">
                    <strong>First Name</strong>
                    <span class="sort-icon-asc-desc pointer flexed-column">
                        <i
                        class="el-icon-caret-top" style="height:10px"
                        @click="sortBy('name', 'asc')"
                        :class="sortField === 'name' && sortOrder === 'asc' ? 'sorted-field-ascending' : 'ascending'"
                        ></i>
                        <i
                        class="el-icon-caret-bottom" 
                        :class="sortField === 'name' && sortOrder === 'desc' ? 'sorted-field-descending' : 'descending'"
                        @click="sortBy('name', 'desc')"
                        ></i>
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                loading: false,
        
            }
        },
        methods:{
            createNewReservation(){
                this.$router.push({
                    name: 'availability'
                })
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>