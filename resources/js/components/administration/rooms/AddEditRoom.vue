<template>
    <div class="form-max-width" v-loading="loading">
        <div class="flexed justify-between  m-b-20">
            <span @click="goBack()" class="flexed align-center pointer">
                <arrow-left-icon size="1.2x" class="m-r-5" />
                <h4 v-if="insertEdit ==='edit'">Edit Room - </h4>
                <h4 v-else>Add Room</h4>
            </span>
            <el-button size="big" style="background-color:#ff7b50; border-radius:15px;color:white" v-if="insertEdit === 'edit'" @click="editEmployee()">Save</el-button>
            <el-button size="big" style="background-color:#ff7b50; border-radius:15px;color:white" v-else @click="save()">Save</el-button>
        </div>
    </div>

</template>

<script>
import {ArrowLeftIcon} from 'vue-feather-icons'
    export default {
        name: 'AddEditRoom',
        props: ['insertEdit'],
        components: {
            ArrowLeftIcon
        },
        data() {
            return {
                loading: false,

            }
        },
        methods: {
            goBack(){
                this.$router.push({
                    name: 'rooms'
                })
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>