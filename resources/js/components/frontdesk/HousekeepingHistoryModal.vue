<template>
       <NormalPopup :no-border="true" :dimmed="true" width="400px">
        <div slot="header" class="flexed justify-between align-center">
            <span class="pointer m-t-5 m-b-5">
                <i class="el-icon-close" @click="$emit('close')"></i>
            </span>
            <span class="label-no-height m-t-5 m-b-5">Room Housekeeping History</span>
            <el-button size="medium" type="primary" plain>CSV</el-button>
        </div>
        <div v-loading="loading"  class="body" style="height:400px;gap:20px; overflow-y:scroll;">
            <div class="flexed-column">
             
                    <table class="table">
                        <thead>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Date</th>
                        </thead>
                        <tbody>
                            <tr v-for="(item,index) in housekeepingHistoryList" :key="index">
                                <td>{{item.housekeeperName}}</td>
                                <td>{{item.housekeeperSurname}}</td>
                                <td>{{item.created_at.split('T')[0]}}</td>
                            </tr>
                        </tbody>
                    </table>
                  
   
            </div>
        </div>
    </NormalPopup>
</template>

<script>
import NormalPopup from '../NormalPopup.vue'
import EmployeeServices from '../../services/employee.services'
import DepartmentServices from '../../services/department.services'
import HousekeepingServices from '../../services/housekeeping.services'
    export default {
        name: 'HousekeepingHistoryModal',
        props: ['room', 'housekeepers', 'housekeepingHistorySchedules'],
        components: {
            NormalPopup
        },
        data() {
            return {
                loading: false,
                housekeepingHistoryList: []
            }
        },
        methods: {
            getName(sch){
                return  this.housekeepers.find(hk => hk.id === sch.employee_id).name
                // if(housekeeper){
                //     return housekeeper.name + ' ' + housekeeper.surname
                // }
            },
            getHousekeeperLastname(sch){
                return this.housekeepers.find(hk => hk.id === sch.employee_id).surname
                // if(housekeeper){
                //     return housekeeper.name + ' ' + housekeeper.surname
                // }
            }
        },
        beforeMount(){
            let housekeepingHistory = []
            housekeepingHistory = this.housekeepingHistorySchedules.filter(sch => sch.room_id === this.room.id)
            console.log('roomHis', housekeepingHistory)
        
            if(housekeepingHistory && housekeepingHistory.length > 0){
                housekeepingHistory.forEach(sch => {
                    sch.housekeeperName = this.getName(sch)
                    sch.housekeeperSurname = this.getHousekeeperLastname(sch)
                })

                          console.log('roomHi1', housekeepingHistory)
            }

            this.housekeepingHistoryList = housekeepingHistory
        }
    }
</script>

<style lang="scss" scoped>

</style>