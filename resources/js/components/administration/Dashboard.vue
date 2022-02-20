<template>
    <div>
        <div id="chart" style="width:900px; height:600px">
                <VueApexCharts  size="200px" type="pie" :options="chartOptions" :series="series" :key="reRender"></VueApexCharts>
        </div>

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
                series: [25,43,23,45,13],
                

            }
        },
        computed: {
            // chartData(){
            //     let prods = []
            //     this.products.forEach(product => {
            //         this.orders.forEach(order => {
            //             let prod = order.products.find(p => p.id === product.id)
            //             if(prod){
            //                 prods.push(prod)
            //             }
            //         })
            //     })


                                
            //     const toFindDuplicates = prods => prods.filter((item, index) => prods.indexOf(item) !== index)
            //     const duplicateElements = toFindDuplicates(prods);
            //     console.log('dps',duplicateElements);
            //     return duplicateElements
            // }
        },
        methods: {
            getOptionsData() {
                this.loading = true;
                Promise.all(
                    [
                        ReservationServices.getReservations(),
                        RoomServices.getRooms(),
                        GuestService.getGuests(),
                        chargeServices.getCharges(),
                        vendorServices.getVendors(),
                        orderServices.getOrders(),
                        productServices.getProducts()
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
                                    "unknown"
                            }),
                            (e) => ({ e, status: "error" })
                        )
                    )
                )
                .then((results) => {
                    if (results.length) {
                        console.log('hereee')
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
                                console.log('here')
                                this.orders = res.data
                            }else if(res.type == "products"){
                                this.products = res.data
                                //   console.log('this.products',this.products)
                                // const occurrences = this.products.reduce(function (acc, curr) {
                                // return acc[curr] ? ++acc[curr] : acc[curr] = 1, acc
                                // }, {});

                                // console.log('this.products',occurrences)
                            } else if(res.type == "vendors"){
                                this.vendors = res.data
                                this.vendors.forEach(v => {
                                    this.chartOptions.labels.push(v.name)
                                    this.reRender++
                                })
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
            

        },
        beforeMount(){
            this.getOptionsData()

        }
    }
</script>

<style lang="scss" scoped>

</style>