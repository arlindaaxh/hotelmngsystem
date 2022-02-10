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
                        v-model="product_ids"
                        filterable
                        multiple
                        clearable
                        remote
                        reserve-keyword
                        placeholder="Search Product"
                        :remote-method="data => searchProduct(data)"
                        :loading="loadingSearch"
                        value-key="id"
                    >
                        <el-option
                            v-for="item in products"
                            :key="item.id"
                            :label="item.name.length > 30 ? item.name.substr(0,30) + '...' : item.name"
                            :value="item"  
                        >
                        </el-option>
                    </el-select>
                <!--           :label="item.name.length > 30 ? item.name.substr(0,30) + '...' : item.name"-->

            


                    <el-button type="primary">Add</el-button> 
                </div>
                

            </div>
        </div>
   </div>
</template>

<script>
import {ArrowLeftIcon} from 'vue-feather-icons';
import mixins from '../../../common/mixins'
export default {
    mixins: [mixins],
    name: 'AddEditOrder',
    components: {
        ArrowLeftIcon
    },
    props: ['insertEdit'],
    data() {
        return {
            loading: false,
            product_ids: [],
            loadingSearch: false,
            products: [],
        }
    },
    methods: {
        goBack(){
            this.$router.push({
                name: 'orders'
            })
        },
        searchProduct(query){
            this.testMetoda(query)
            this.products = [];
            if (!query || query.length === 0) return;
            // let payload = {
            //     active: true,
            //     limit: 50,
            //     order_by : 'name',
            //     "track_inventory": true,
            //     text_filters: [
            //         {
            //             condition: "CONTAINS",
            //             value: query,
            //             field_name: "name",
            //         }
            //     ]
            // }
            // this.loadingSearch = true;
            // POApprovalRulesServices.searchProduct(payload)
            //     .then((res) => {
            //         this.products= res.data.records;
            //     })
            //     .catch((error) => {
            //         this.catchMethod(error);
            //     })
            //     .finally(() => {
            //         this.loadingSearch = false;
            //     });
        },
    
    }
}
</script>

<style>

</style>