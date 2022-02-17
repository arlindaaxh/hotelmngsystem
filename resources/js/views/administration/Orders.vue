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
                <el-button v-if="showUpdateBtn" size="big" style="background-color:#ff7b50; border-radius:15px;color:white" @click="updateOrderStatus()">Update</el-button>
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
                label="#Order Number"
            >
            </el-table-column>
            <el-table-column
                prop="created_at"
                label="Order Date"
                :formatter="formatDate" 
            >
            </el-table-column>
            <el-table-column
                prop="total_amount"
                label="Price"
                :formatter="formatPrice"    
                width="150px"    
            >
            </el-table-column>
            <!-- <el-table-column
                prop="status"
                label="Status">
            </el-table-column> -->
            <el-table-column  prop="status" label="Status" >
                <template slot-scope="scope">
                    <el-select v-model="scope.row.status"   size="big" @change="changeStatus(scope.row)"  :class="scope.row.typeChanged ? 'custom-input' : ''">
                        <el-option
                            v-for="statusi in statuses"
                            :key="statusi.value"
                            :label="statusi.name"
                            :value="statusi.name"
                        >
                        </el-option>
                    </el-select>
                </template>
            </el-table-column>
            <el-table-column
                prop="items"
                label="Items">
            </el-table-column>
        </el-table>

       <el-alert v-if="!loading && filteredOrders && filteredOrders.length === 0"  
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
import OrderServices from '../../services/order.services'
export default {
    data() {
        return {
            loading: false,
            query: "",
            orders: [],
            statuses: [{id: 1, name: 'REQUESTED'},{id:2, name: 'COMPLETED'}],
            selectIsFocused: false,
            showUpdateBtn: false,
            ordersToUpdate: [],

        }
    },
    computed: {
        filteredOrders(){
            return (
                (this.orders && this.orders.filter(element => {
                    return (
                        element.serial_number.match(this.query.toLowerCase())
                    )
                    })
                )    
            )
        },
        orderStatuses(){
            return this.order.map(o => o.status)
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
        getOrders(){
            this.loading = true
            OrderServices.getOrders().then((res) => {
                this.orders = res.data
                this.orders.forEach(order => {
                    this.$set(order, 'typeChanged', false)
                    this.$set(order, 'oldStatus', order.status)
                })
            })
            .catch((error) => {
                this.catchMethod(error)
            })
            .finally(() => {
                this.loading = false
            })
        },
        formatPrice(row, column){
            return `$ ${row[column.property].toFixed(2)}`; 
        },
        formatDate(row,column){
            return `${row[column.property].split('T')[0]}`
        },
        editOrder(row, column, event){
            console.log('o', row)
            this.$router.push({
                name: 'edit-order',
                params: {
                    insertEdit: 'edit',
                    orderProp: row
                }
            })
        },
        changeStatus(order){
            if(order.oldStatus !== order.status){
                order.typeChanged = true
                this.showUpdateBtn = true
                this.ordersToUpdate.push(order)
            }
            else{
                order.typeChanged = false
                this.ordersToUpdate = this.ordersToUpdate.filter(o => o.id !== order.id)
            }
        },
        updateOrderStatus(){
            let payload = {
                orders: this.ordersToUpdate
            }
            this.loading = true
            OrderServices.updateOrderStatuses(payload).then((res) => {
                this.$notify.success({
                    title: 'Success',
                    type: 'Success',
                    message: 'Order status was changed successfully' 
                })
                this.refreshData()
            })
            .catch((error) => {
                this.catchMethod(error)
            })
            .finally(() => {
                this.loading = false
            })
        },
        refreshData(){
            this.getOrders()
        }
        
        

    },
    beforeMount(){
        this.getOrders()
    },
    beforeRouteUpdate(to, from, next){
        if(to.name === 'orders'){
            this.getOrders()
        
        }
        next()
    },
    // watch:{
    //     orderStatuses: function (){
    //         this.checkOrderStatuses()
    //     }
    // }

}
</script>

<style lang="scss" scoped>
.custom-input{
    ::v-deep .el-input__inner{
        border-color: #ff7b50;
    } 
}

</style>