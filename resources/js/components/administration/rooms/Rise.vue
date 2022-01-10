<template>
    <NormalPopup :no-border="true" :dimmed="true" width="400px">
        <div slot="header" class="flexed justify-center align-center">
            <span class="pointer m-t-5 m-b-5">
                <i class="el-icon-close" @click="$emit('close')"></i>
            </span>
            <strong class="m-t-5 m-b-5">Add Room Rise</strong>
        </div>
        <div v-loading="loading" class="body">
            <div class="flexed-column">
                
            </div>
        
        </div>
        <div slot="bottom" class="bottom">
            <el-button @click="$emit('close')">Cancel</el-button>
            <el-button type="danger">Delete</el-button>
        </div>
    </NormalPopup>
</template>

<script>
import NormalPopup from '../../NormalPopup.vue'
    export default {
        name: 'Rise',
        components: {
            NormalPopup
        },
        data() {
            return {
                loading: false
            }
        },
    }
</script>

<style lang="scss" scoped>

</style>