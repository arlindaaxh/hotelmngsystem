<template>
   <div class="form-max-width" v-loading="loading">
        <div class="flexed justify-between  m-b-20">
            <span @click="goBack()" class="flexed align-center pointer">
                <arrow-left-icon size="1.2x" class="m-r-5" />
                <h4 v-if="insertEdit ==='edit'">Edit Order - {{order.name}} </h4>
                <h4 v-else>Add Order</h4>
            </span>
            <el-button size="big" style="background-color:#ff7b50; border-radius:15px;color:white" v-if="insertEdit === 'edit'" @click="editProduct()">Save</el-button>
            <el-button size="big" style="background-color:#ff7b50; border-radius:15px;color:white" v-else @click="save()">Save</el-button>
        </div>
        <div class="content mt-30">
            <div class="flexed align-center justify-between">
                <span>Select products</span>
                <div class="flexed" style="gap:10px">
                    <el-select
                        v-model="value"
                        multiple
                        filterable
                        remote
                        reserve-keyword
                        placeholder="Please enter a keyword"
                        :remote-method="remoteMethod"
                        :loading="loading">
                        <el-option
                            v-for="item in options"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value">
                        </el-option>
                    </el-select>
                    <el-button type="primary">Add</el-button> 
                </div>
                

            </div>
        </div>
   </div>
</template>

<script>
import {ArrowLeftIcon} from 'vue-feather-icons';
export default {
    name: 'AddEditOrder',
    components: {
        ArrowLeftIcon
    },
    props: ['insertEdit'],
    data() {
        return {
            loading: false,
        }
    },
    methods: {
        goBack(){
            this.$router.push({
                name: 'orders'
            })
        }
    }
}
</script>

<style>

</style>