<template>
    <div class="p-20 flexed" style="gap:10px">
        <div class="flexed-column">
            <span class="label-no-height" style="font-size:20px">Sales</span>
            <div id="chart" style="width:750px">
                    <VueApexCharts  size="200px" type="pie" :options="chartOptions" :series="filteredSeries" :key="reRender"></VueApexCharts>
            </div>

              <!-- <span class="pt-20 border-top "></span> -->

            <div class="mt-20">
                <span style="color:#ff7b50;font-size:18px" class="label-no-height">Invertory</span>
                <div style="width:400px;" class="mt-10">
                    <div class="form-data pointer">
                        <el-card shadow="never" class="card-box" @click.native="goToView('products')">
                           <div class="flexed-column">
                                <strong>Products</strong>
                                <span class="pt-20" style="font-size:25px; font-weight:500">{{products.length}}</span>
                            </div>
                        </el-card>
                        <el-card shadow="never" class="card-box" @click.native="goToView('vendors')">
                            <div class="flexed-column" >
                                <strong>Vendors</strong>
                                <span class="pt-20" style="font-size:25px; font-weight:500">{{vendors.length}}</span>
                            </div>
                          
                        </el-card>
                         <el-card shadow="never" class="card-box" @click.native="goToView('orders')">
                            <div class="flexed-column" >
                                <strong>Orders</strong>
                                <span class="pt-20" style="font-size:25px; font-weight:500">{{orders.length}}</span>
                            </div>
                          
                        </el-card>
                        <el-card shadow="never" class="card-box">
                             <div class="flexed-column" >
                                <strong></strong>
                                <strong class="pt-20" style="font-size:25px; font-weight:500">--</strong>
                            </div>
                        </el-card>
                    </div>
                </div>
            </div>
        </div>
      

        <div class="flexed-column" style="gap: 40px;">
            <div>
                <span style="color:#ff7b50;font-size:18px" class="label-no-height p-b-20">House</span>
                <div style="width:400px;" class="mt-10">
                    <div class="form-data pointer">
                        <el-card shadow="never" class="card-box" @click.native="goToView('rooms')">
                            <div class="flexed-column">
                                <strong>Rooms</strong>
                                <span class="pt-20" style="font-size:25px; font-weight:500">{{rooms.length}}</span>
                            </div>
                        </el-card>
                        <el-card shadow="never" class="card-box" @click.native="goToView('guests')">
                            <div class="flexed-column">
                                <strong>Guests</strong>
                                <span class="pt-20" style="font-size:25px; font-weight:500" v-if="filteredGuests">{{filteredGuests.length}}</span>
                            </div>
                        </el-card>
                        <el-card shadow="never" class="card-box" @click.native="goToView('employees')">
                            <div class="flexed-column">
                                <strong>Housekeepers</strong>
                                <span class="pt-20" style="font-size:25px; font-weight:500">{{housekeepers.length}}</span>
                            </div>
                        </el-card>
                        <el-card shadow="never" class="card-box">
                            <div class="flexed-column">
                                <strong>--</strong>
                                <span class="pt-20" style="font-size:25px; font-weight:500"></span>
                            </div>
                        </el-card>
                    </div>
                </div>
            </div>
          
        </div>
        <!-- <el-button @click="count()" type="primary" class="pointer">here</el-button>
        <span @click="count()">pls</span> -->
    </div>
</template>

<script>
import VueApexCharts from 'vue-apexcharts'
import GuestService from '../../services/guest.services';
import ReservationServices from '../../services/reservation.services';
import vendorServices from '../../services/vendor.services';
import RoomServices from '../../services/room.services';
import chargeServices from '../../services/charge.services';
import orderServices from '../../services/order.services';
import productServices from '../../services/product.services';
import DepartmentServices from '../../services/department.services'
import EmployeeServices from '../../services/employee.services'
import mixins from '../../common/mixins';
    export default {
        mixins: [mixins],
        name: 'Dashboard',
        components: {
            VueApexCharts
        },
        data() {
            return {
                loading: false,
                reRender:0,
                vendors: [],
                guests: [],
                charges: [],
                orders: [],
                rooms: [],
                products: [],
                employees: [],
                departments: [],
                chartOptions: {
                    chart: {
                        type: 'pie',
                        size: 200,
                        customScale: 0.8
                    },
                    labels: [],
                    stroke: {
                        show: true,
                        curve: 'smooth',
                        lineCap: 'butt',
                        colors: undefined,
                        width: 1,
                        dashArray: 0,
                    },
                    legend:{
                        width: 380
                    },
                
                },
                series: [],
                

            }
        },
        computed: {
            chartData(){
                let prods = []
                this.products.forEach(product => {
                    this.orders.forEach(order => {
                        console.log('order', order)
                        let prod = order.products.find(p => p.id === product.id)
                        if(prod){
                            prods.push(prod)
                        }
                    })
                })

               
                                
                const toFindDuplicates = prods => prods.filter((item, index) => prods.indexOf(item) !== index)
                const duplicateElements = toFindDuplicates(prods);
                console.log('dps',duplicateElements);
                return duplicateElements
            },
            filteredSeries(){
               return this.series
           },
            filteredGuests(){
                let guests = []
                this.reservations.forEach(r => {
                    if(r.active || r.active === 1){
                        this.guests.forEach(g => {
                            if(g.id === r.guest_id){
                                guests.push(g)
                            }
                        })
                    }
                })

                return guests
            },
            housekeepers(){
                const housekeepers = []
                let allEmployees = this.employees.filter(employee => this.departments.some(dep => dep.id === employee.department_id))
                allEmployees.forEach(emp => {
                    let depName = this.getName(emp.department_id)
                    if(depName && depName === 'Housekeeping'){
                        let found = housekeepers.find(element => element.id === emp.id)
                        if(!found) {
                            housekeepers.push(emp) 
                        }
                    }
                })
                return housekeepers
            },
        
        },
        methods: {
            goToView(routeName){
                this.$router.push({name: routeName})
            },
            getOptionsData() {
                this.loading = true;
                Promise.all(
                    [
                        ReservationServices.getReservations(),
                        RoomServices.getRooms(),
                        GuestService.getGuests(),
                        chargeServices.getCharges(),
                        orderServices.getOrders(),
                        productServices.getProducts(),
                        vendorServices.getVendors(),
                        EmployeeServices.getEmployees(),
                        DepartmentServices.getDepartments(),
                       
                    ].map((p, index) =>
                        p.then(
                            (v) => ({
                                data: v.data,
                                status: "success",
                                type:
                                    index == 0 ? "reservations" :
                                    index == 1 ? "rooms" : 
                                    index == 2 ? "guests" :
                                    index == 3 ? "charges" :

                                    index == 4 ? "orders" :
                                    index == 5 ? "products" :
                                          index == 6 ? "vendors" :
                                          index == 7 ? "employees"
                                    : index == 8? "departments" :
                                    "unknown"
                            }),
                            (e) => ({ e, status: "error" })
                        )
                    )
                )
                .then((results) => {
                    if (results.length) {
                    results
                        .filter((r) => r.status == "success")
                        .forEach((res) => {
                            if (res.type == "reservations") {
                                this.reservations = res.data;
                            }
                            else if (res.type == "rooms") {
                                this.rooms = res.data
                            }else if(res.type == "guests"){
                                this.guests = res.data
                            }else if(res.type == "charges"){
                                this.charges = res.data
                            }
                            else if(res.type == "orders"){
                                this.orders = res.data
                                console.log('orders', this.orders)
                            }else if(res.type == "products"){
                                this.products = res.data
                                //   console.log('this.products',this.products)
                                // const occurrences = this.products.reduce(function (acc, curr) {
                                // return acc[curr] ? ++acc[curr] : acc[curr] = 1, acc
                                // }, {});

                                // console.log('this.products',occurrences)
                            } else if(res.type == "vendors"){
                                this.vendors = res.data
                                // this.vendors.forEach(v => {
                                //     this.chartOptions.labels.push(v.name)
                                //     this.reRender++
                                // })
                            }else  if (res.type == "employees") {
                                this.employees = res.data;
                                console.log('empl', this.employees)
                            } else if (res.type == "departments") {
                                this.departments = res.data;
                                console.log('depts', this.departments)
                            } 
                            
                        });

                        this.count()
                    }
                })
                .catch((error) => {
                    this.catchMethod(error)
                })
                .finally(() => {
                    this.loading = false
                })
            },
            count() {
                console.log('here')
                let prods = []
                this.products.forEach(product => {
                    this.orders.forEach(order => {
                        let prod = order.products.find(p => p.id === product.id)
                        if(prod){
                            prods.push(prod)
                            let found = this.chartOptions.labels.find(l => l === prod.name)
                            if(!found){
                                this.chartOptions.labels.push(product.name)  
                            }
                          
                        }
                    })
                
                })

                prods.sort();

                var current = null;
                var cnt = 0;
                for (var i = 0; i < prods.length; i++) {
                    console.log('prod', prods[i])
                    if (prods[i].name != current) {
                        if (cnt > 0) {
                            console.log(current + ' comes --> ' + cnt + ' times<br>');
                            this.series.push(cnt)
                        }
                        current = prods[i].name;
                        // this.chartOptions.labels.push(current)
                        cnt = 1;
                    } else {
                        cnt++;
                    }
                }
                if (cnt > 0) {
                    console.log(current + ' comes --> ' + cnt + ' times');
                    this.series.push(cnt)
                    // this.chartOptions.labels.push(current)
                
                }

            },
            getName(departmentId){
                let found = this.departments?.find(element => element.id === departmentId)
                if(found){
                    return found.name
                }
            },
                

            
            

        },
        // mounted(){
        //  this.count()
        // },
        beforeMount(){
            this.getOptionsData()
           
        }
    }
</script>

<style lang="scss" scoped>
.form-data {
    gap: 0px;

    .card-box {
        height: 150px;
        text-align: center;
        
    }
}
</style>