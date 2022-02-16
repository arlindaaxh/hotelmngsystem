<template>
   <div class="form-max-width" v-loading="loading">
        <div class="flexed justify-between  m-b-20">
            <span @click="goBack()" class="flexed align-center pointer">
                <arrow-left-icon size="1.2x" class="m-r-5" />
                <h4 v-if="insertEdit ==='edit'">Edit Order - {{order.name}} </h4>
                <h4 v-else>Add Order</h4>
            </span>
            <!-- <el-button size="big" style="background-color:#ff7b50; border-radius:15px;color:white" v-if="insertEdit === 'edit'" @click="save()" :disabled="activeIndex === 0 ? disabledNext : false">{{activeIndex === 1 ? 'Save' : 'Next'}}</el-button> -->
            <el-button size="big" style="background-color:#ff7b50; border-radius:15px;color:white" v-if="activeIndex === 0" @click="next()" :disabled="disabledNext ">Next</el-button>

            <div class="flexed" style="gap:5px" v-else>
                <el-button size="big" style="background-color:#ff7b50; border-radius:15px;color:white"  @click="previous()">Previous</el-button>
                <el-button size="big" style="background-color:#ff7b50; border-radius:15px;color:white"  @click="save()">Save</el-button>
            </div>


        </div>
        <div class="content mt-30"  v-if="activeIndex === 0">
            <div class="flexed align-center" style="gap:30px;">
                <div class="flexed-column " style="gap:10px;">
                    <span class="label-no-height">Select products</span>
                    <div class="flexed" style="gap:10px">
                        <el-select
                            v-model="selectedProduct"
                            filterable
                            clearable
                            remote
                            reserve-keyword
                            placeholder="Search Product"
                            :remote-method="data => searchProduct(data)"
                            :loading="loadingSearch"
                            value-key="id"
                            style="width:400px"
                            :no-data-text="'No data'"
                        >
                            <el-option
                                v-for="item in products"
                                :key="item.id"
                                :label="item.name.length > 30 ? item.name.substr(0,30) + '...' : item.name"
                                :value="item"  
                            >
                            </el-option>
                        </el-select>
                    </div>
                </div>
                <div class="flexed-column" style="gap:10px;">
                    <span class="label-no-height">Quantity</span>
                    <el-input type="number" v-model="quantity" style="width:160px;" placeholder="quantity"></el-input>
                </div>
                <el-button type="primary" style="min-width: 70px; margin-top:32px;"  :disabled="disableSave" @click="addProduct()">
                    <i class="el-icon-loading" v-if="loadingSearch"></i>
                    <span v-else>Add</span>
                </el-button> 
               
            </div>

            <div class="m-t-30" v-if="order.products.length">
                <el-table
                    :data="order.products"
                    stripe
                    style="width: 100%"
                    class="table mt-50"
                    :default-sort = "{prop: 'name', order: 'ascending'}"
                    header-cell-class-name="table-header"
                    show-summary
                    :summary-method="getSummaries"
  
                    >
                    <el-table-column
                        prop="name"
                        label="Name"
                       
                    >
                    </el-table-column>
                    <el-table-column
                        prop="upc"
                        label="UPC"
                    >
                    </el-table-column>
                    <el-table-column
                        prop="quantity"
                        label="Quantity"   
                    >
                        <template slot-scope="scope">
                            <el-input
                                v-model="scope.row.quantity"
                                placeholder="Qty"
                                style="width: 150px"
                                @input="calculateTotalPrice(scope.row)"
                            />
                        </template>
                    </el-table-column>
                    <el-table-column
                        prop="price"
                        label="Price"
                        :formatter="formatPrice"
                    >
                    </el-table-column>
                    <el-table-column
                        prop="total_amount_per_product"
                        label="Total"
                        :formatter="formatPrice"
                    >
                    </el-table-column>
                   

                </el-table>
            </div>
        </div>
        <div class="content mt-30"  v-if="activeIndex === 1">
            <el-form
                ref="add-edit-order-form"
                :model="order"
                :rules="rules"
                size="medium"
                :hide-required-asterisk="true"
                class="form-data flexed-column"
                label-position="top"

            >
              
                <el-form-item prop="guest" label="Guest">
                    <el-select v-model="order.guest_id"  
                    clearable
                    filterable
                    placeholder="Guest" 
                    style="width:100%"
                    size="big">
                        <el-option
                            v-for="(guest,index) in guests"
                            :key="index"
                            :label="guest.id"
                            :value="guest.id"
                            >
                        </el-option>
                    </el-select>
                </el-form-item>
                <div class="flexed-column total-amount-custom" style="align-items: start; grid-column-start: 1" >
                    <span class="label-no-height">Total Amount</span>
                    <span style="margin-bottom:22px">{{order.total_amount}}</span>
                </div>
            
                <el-form-item prop="payment_type" label="Payment type" style="grid-column-start: 1" >
                    <el-radio-group name="payment_type" v-model="order.payment_type" size="big">
                        <el-radio-button label="to_room">Add To Room</el-radio-button>
                        <el-radio-button  label="in_place" style="width:200px">Pay Now</el-radio-button>
                    </el-radio-group>
                </el-form-item>
               
            </el-form>
        </div>  
                

           
   </div>
</template>

<script>
import {ArrowLeftIcon} from 'vue-feather-icons';
import mixins from '../../../common/mixins';
import ReservationServices from '../../../services/reservation.services';
import ProductServices from '../../../services/product.services';
import {generateOrderNumber} from '../../../common/utilities.services';
import GuestServices from '../../../services/guest.services';
import chargeServices from '../../../services/charge.services';
import OrderServices from '../../../services/order.services';

export default {
    mixins: [mixins],
    name: 'AddEditOrder',
    components: {
        ArrowLeftIcon
    },
    props: ['insertEdit', 'orderProp'],
    data() {
        return {
            loading: false,
            selectedProduct: null,
            loadingSearch: false,
            products: [],
            quantity: 0,
            guests: [],
            charges: [],
            reservations: [],
            order: {
                serial_number: null,
                items: 0,
                products: [],
                total_amount: null,
                payment_type: 'in_place',
                guest_id: null,
                employee_id : null,
                status: 'REQUESTED',
                initial_qty: 0
            },
            activeIndex: 0,
            rules:{}

        }
    },
    beforeMount(){
        this.getOptionsData()
        console.log('orderi', this.orderProp)
        if(this.insertEdit === 'edit'){
            this.order = {...this.orderProp}
        }
    },

    computed: {
        disableSave(){
            return !this.quantity || this.quantity * 1 === 0 || !this.selectedProduct
        },
        disabledNext(){
            return !this.order.products.length
        }
    
    },
    methods: {
        getOptionsData() {
            this.loading = true;
            Promise.all([GuestServices.getGuests(),chargeServices.getCharges(),ReservationServices.getReservations()].map((p, index) =>
                    p.then(
                        (v) => ({
                            data: v.data,
                            status: "success",
                            type:
                                index == 0 ? "guests" : 
                                index == 1 ? "charges" :
                                index == 2 ? "reservations" :
                                "unknown"
                        }),
                        (e) => ({ e, status: "error" })
                    )
                )
            )
            .then((results) => {
                if (results.length) {
                    results.filter((r) => r.status == "success").forEach((res) => {
                        if(res.type == "guests") {
                            this.guests = res.data
                            this.guests.forEach(guest => {
                                let fn = guest.first_name + ' ' + guest.last_name
                                this.$set(guest, 'full_name', fn )
                            })
                        }else if(res.type == "charges"){
                            this.charges = res.data
                        }
                        else if(res.type == "reservations"){
                            this.reservations = res.data
                        }
                        
                    });
                }
            })
            .catch((error) => {
                this.catchMethod(error)
            })
            .finally(() => {
                this.loading = false
            })
        },


        goBack(){
            this.$router.push({
                name: 'orders'
            })
        },
        searchProduct(query){
            this.products = [];
            if (!query || query.length === 0) return;
            let obj = {
                keyword: query
            }
        
            this.loadingSearch = true;
            ProductServices.searchProd(obj)
            .then((res) => {
                console.log('here', res.data)
                this.products = res.data;
            })
            .catch((error) => {
                this.catchMethod(error);
            })
            .finally(() => {
                this.loadingSearch = false;
            });
        },
    
    
        addProduct(){
            this.$set(this.selectedProduct, 'quantity', this.quantity)
            let total = this.quantity * 1 * this.selectedProduct.price 
            this.$set(this.selectedProduct, 'total_amount_per_product', total)
            this.order.products.push(this.selectedProduct)
            this.resetFields()

        },
        resetFields(){
            this.selectedProduct = null
            this.quantity = null
            this.products = []
        },
        formatPrice(row, column){
            return `$ ${row[column.property].toFixed(2)}`; 
        },
        getSummaries(param){
             const { columns, data } = param;
            const sums = [];
        
            columns.forEach((column, index) => {
            if (index === 2  ) {
                sums[index] = 'Total Cost';
                return;
            }
            if(index === 1 || index === 0){
                sums[index] = '';
                return;
            }
            const values = data.map(item => Number(item[column.property]));
            if (!values.every(value => isNaN(value))) {
                sums[index] = '$ ' + values.reduce((prev, curr) => {
                const value = Number(curr);
                if (!isNaN(value)) {
                    return prev + curr;
                } else {
                    return prev;
                }
                
                }, 0);
            } else {
                sums[index] = 'N/A';
            }

        
            this.order.total_amount = sums[index]

         
            });

            return sums;
        },
        calculateTotalPrice(product){

            let total =  product.total_amount_per_product = product.quantity * 1 * product.price
            return total
        },
        next(){
            this.activeIndex = 1
        },
        previous(){
            this.activeIndex = 0
        },
        save(){
            console.log('order',this.order.total_amount)
            this.order.total_amount = this.order.total_amount.toString().slice(1)
         
            let payload = {
                serial_number: generateOrderNumber(),
                items: this.order.products.length,
                products: this.order.products.length,
                total_amount: this.order.total_amount,
                payment_type: this.order.payment_type,
                guest_id: this.order.guest_id,
                employee_id : 1,
                status: this.order.status,
                initial_qty: 0
            }

            OrderServices.postOrder(payload).then((res) => {
                this.$notify.success({
                    title: 'Success',
                    type: 'Success',
                    message: 'Order was made successfully' 
                })
                if(res.data){
                    console.log('res', res.data)
                    if(res.data.payment_type == 'to_room'){
                        let foundReservation = this.reservations.find(res => res.guest_id === payload.guest_id)
                        console.log('res', foundReservation)
                        let foundCharge = this.charges.find(charge => charge.reservation_id === foundReservation.id)
                        if(foundCharge){
                            foundCharge.total += payload.total_amount * 1
                            this.addChargeToRoom(foundCharge)
                        
                        }
                    }
                }
                this.goBack()
        
            })
            .catch((error) => {
                this.catchMethod(error)
            })
            .finally(() => {
                this.loading = false
            })
            

            
        },
        addChargeToRoom(foundCharge){
            console.log('foundCharge',foundCharge)
            chargeServices.putCharge(foundCharge, foundCharge.id).then((res) => {
                this.$notify.success({
                    title: 'Success',
                    type: 'Success',
                    message: 'Expenses were added to room'
                })
        
            })
            .catch((error) => {
                this.catchMethod(error)
            })
            
        }
    },

}
</script>

<style lang="scss" scoped>

::v-deep .el-radio-button__inner{
    width: 200px;
}

.total-amount-custom{
    .label-no-height{
    padding-bottom: 10px;
    margin-bottom: 10px;
    line-height: 36px;
    }
}

.form-data{
    align-items: start;
}

</style>