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
                    <div  class="text ">
                        {{'List item ' + index }}
                    </div>
                </el-card>
            </div>
        </div>
    </div>
</template>

<script>
import RoomServices from '../../services/room.services'
    export default {
        data() {
            return {
                loading: false,
                query: "",
                rooms: []
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

            }
        },
        beforeMount(){
            this.getRooms()
           
        },
    
    }
</script>

<style lang="scss" scoped>

</style>