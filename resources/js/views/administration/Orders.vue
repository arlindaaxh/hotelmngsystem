<template>
  <div class="form-max-width" v-if="$route.name === 'orders'" v-loading="loading">
    <div class="shortcuts-header flexed justify-between">
        <h4>Orders</h4>
    </div>
    <div class="one-column-list">
        <div class="flexed justify-between m-b-20">
            <el-input class="search-input" size="big" placeholder="Search orders by order number" v-model="query" :style="'max-width:450px'">
                <i class="el-icon-search el-input__icon" slot="suffix"></i>
            </el-input>
            <div>
                <el-button size="big" style="background-color:#ff7b50; border-radius:15px;color:white" @click="addOrder()">New</el-button>
            </div>
        </div>

        <el-table
            :data="filteredOrders"
            stripe
            style="width: 100%"
            class="table mt-50 pointer"
            :default-sort = "{prop: 'name', order: 'ascending'}"
            header-cell-class-name="table-header"
            :header-cell-style="tableCellStyle"
            @row-click="editOrder"
        >
            <el-table-column
                prop="serial_number"
                label="Order Number"
            >
            </el-table-column>
            <el-table-column
                prop="date"
                label="Date"
            >
            </el-table-column>
            <el-table-column
                prop="vendor_id"
                label="Vendor">
            </el-table-column>
            <el-table-column
                prop="price"
                label="Price">
            </el-table-column>
            <el-table-column
                prop="items"
                label="Items">
            </el-table-column>
        </el-table>

       <el-alert v-if="!loading && filteredProducts && filteredProducts.length === 0"  
            type="info" 
            :closable="false" 
            class="mt-30"
            title="No results found" 
            show-icon
            
        />
    </div>
  </div>
    <div v-else>
        <router-view />
    </div>
  
</template>

<script>
export default {
    data() {
        return {
            loading: false,
            query: "",

        }
    },
    methods: {
        tableCellStyle({row, column, rowIndex, columnIndex}) {
            return {'color':'#2c3e50'}
        },
        addOrder(){
            this.$router.push({
                name: 'add-order',
                params: {
                    insertEdit: 'add'
                }
            })
        },

    },

}
</script>

<style>

</style>