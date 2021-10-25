<template>

    <NormalPopup :no-border="true" :dimmed="true" width="400px">
        <div slot="header" class="flexed justify-between align-center">
            <span class="pointer m-t-5 m-b-5">
                <i class="el-icon-close" @click="$emit('close')"></i>
            </span>
            <span class="label-no-height m-t-5 m-b-5">{{roomProp.code}}</span>
            <el-button  size="medium" style="background-color:#ff7b50; border-radius:15px;color:white" @click="save()">Save</el-button>
        </div>
        <div v-loading="loading" class="body">
            <el-button-group>
                <el-button @click="activeIndex = 1">Schedule Details</el-button>
                <el-button @click="activeIndex = 2">Reservation Details</el-button>
                <el-button @click="activeIndex = 3">Service Options</el-button>
            </el-button-group>

            <div class="bordered mt-10 p-10" style="height:400px; border:1px solid lightgrey;padding:10px;">
                <span style="border-bottom:1px solid lightgrey;">{{roomProp.type}}</span>
            </div>
        </div>
    </NormalPopup>

</template>

<script>
import NormalPopup from '../NormalPopup.vue'
    export default {
        name: 'RoomModal',
        components: {
            NormalPopup
        },
        props: ['roomProp'],
        data() {
            return {
                loading: false,
                activeIndex: 1
            }
        },
    }
</script>

<style lang="scss" scoped>

</style>