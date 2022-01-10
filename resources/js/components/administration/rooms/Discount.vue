<template>
    <NormalPopup :no-border="true" :dimmed="true" width="400px">
        <div slot="header" class="flexed justify-between align-center">
            <span class="pointer m-t-5 m-b-5">
                <i class="el-icon-close" @click="$emit('close')"></i>
            </span>
            <strong class="m-t-5 m-b-5">Add Room Discount</strong>
            <el-button>Save</el-button>
        </div>
        <div v-loading="loading" class="body">
            <div class="flexed-column">
                <span class="text-grey">The discount will be added to {{selectedRooms.length}} {{selectedRooms.length === 1 ? 'room' : 'rooms'}}</span>
                <div class="flexed mt-20" style="gap:30px">
                    <el-button class="w-100">10%</el-button>
                    <el-button class="w-100">20%</el-button>
                    <el-button class="w-100">30%</el-button>
                    <el-button class="w-100">50%</el-button>        
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
import NormalPopup from '../../NormalPopup.vue'
    export default {
        name: 'Discount',
        components: {
            NormalPopup
        },
        props: ['selectedRooms'],
        data() {
            return {
                loading: false
            }
        },
    }
</script>

<style lang="scss" scoped>

</style>