<template>
    <div>
        <div class="flexed  ml-20 p-20 pt-40" style="font-weight:bold; font-size:17px"><span class="el-icon-office-building"></span>My Hotel Logo</div>
        <el-menu
            :default-active="$route.path"
            class="el-menu-vertical-demo"
            :router="true"
            background-color="#f5f5f5"

            active-text-color="#ffd04b"
        >
           
            <el-menu-item 
                index="dashboard" 
                :route="{name: 'dashboard'}" 
                v-bind:class="[$route.name === 'dashboard' ? 'el-menu-item is-active' : 'el-menu-item']"
                
            >
               <!-- <i class="el-icon-menu"></i> -->
                <!-- <img src="../../css/assets/dashboard_icn.svg" style="width:22px; margin:3px"/> -->
                <i class="el-icon-s-data"></i>
                <span :style="[$route.name === 'dashboard' ? {'color': 'white'} : {'color':'black'}]" >  Dashboard</span>
            </el-menu-item>
            
            <el-menu-item
                index="employees"
                :route="{ name: 'employees' }"
                v-bind:class="[$route.name === 'employees' || $route.name === 'add-employee' || $route.name === 'edit-employee'   ? 'el-menu-item is-active' : 'el-menu-item']"
            >
                <i class="el-icon-user"></i>
                <span :style="[$route.name === 'employees' || $route.name === 'add-employee' || $route.name === 'edit-employee'  ? {'color': 'white'} : {'color':'black'}]">Employees</span>
            </el-menu-item>
            <el-menu-item
                index="departments"
                :route="{ name: 'departments' }"
                v-bind:class="[$route.name === 'departments' || $route.name === 'add-department' || $route.name === 'edit-department'  ? 'el-menu-item is-active' : 'el-menu-item']"
            >
                <i class="el-icon-s-custom"></i>
                <span :style="[$route.name === 'departments'  || $route.name === 'add-department' || $route.name === 'edit-department' ? {'color': 'white'} : {'color':'black'}]">Departments</span>
            </el-menu-item>
            <el-menu-item
                index="rooms"
                :route="{ name: 'rooms' }"
                v-bind:class="[$route.name === 'rooms' || $route.name === 'add-room' || $route.name === 'edit-room' ? 'el-menu-item is-active' : 'el-menu-item']"
            >
         
                <b-icon icon="door-closed-fill" class="m-l-5" :style="[$route.name === 'rooms'  || $route.name === 'add-room' || $route.name === 'edit-room' ? {'color': 'white'} : {'color':'grey'}]"></b-icon>
                <span :style="[$route.name === 'rooms'  || $route.name === 'add-room' || $route.name === 'edit-room' ? {'color': 'white', 'marginRight': '10px'} : {'color':'black','marginRight': '10px'}]" class="m-l-5"> Rooms</span>
            </el-menu-item>
            
            <el-menu-item
                index="guests"
                :route="{ name: 'guests' }"
                v-bind:class="[$route.name === 'guests' || $route.name === 'add-guest' || $route.name === 'edit-guest'? 'el-menu-item is-active' : 'el-menu-item']"
            >
                <i  class="el-icon-user-solid"></i>
                <span :style="[$route.name === 'guests' || $route.name === 'add-guest' || $route.name === 'edit-guest' ? {'color': 'white'} : {'color':'black'}]" class="m-l-5">Guests</span>
            </el-menu-item>

            <el-menu-item
                index="products"
                :route="{ name: 'products' }"
                v-bind:class="[$route.name === 'products' || $route.name === 'add-product' || $route.name === 'edit-product' ? 'el-menu-item is-active' : 'el-menu-item']"
            >
                <i  class="el-icon-takeaway-box"></i>
                <span :style="[$route.name === 'products' || $route.name === 'add-product' || $route.name === 'edit-product' ? {'color': 'white'} : {'color':'black'}]" class="m-l-5">Products</span>
            </el-menu-item>

            
            <el-menu-item
                index="orders"
                :route="{ name: 'orders' }"
                v-bind:class="[$route.name === 'orders' || $route.name === 'add-order' || $route.name === 'edit-order' ? 'el-menu-item is-active' : 'el-menu-item']"
            >
                <i  class="el-icon-sell"></i>
                <span :style="[$route.name === 'orders' || $route.name === 'add-order' || $route.name === 'edit-order' ? {'color': 'white'} : {'color':'black'}]" class="m-l-5">Orders</span>
            </el-menu-item>

            <el-menu-item
                index="addons"
                :route="{ name: 'addons' }"
                v-bind:class="[$route.name === 'addons' || $route.name === 'add-addon' || $route.name === 'edit-addon' ? 'el-menu-item is-active' : 'el-menu-item']"
            >
                <i  class="el-icon-s-goods" :style="[$route.name === 'addons' || $route.name === 'add-addon' || $route.name === 'edit-addon' ? {'color': 'white'} : {'color':'grey'}]"></i>
                <span :style="[$route.name === 'addons' ? {'color': 'white'} : {'color':'black'}]" class="m-l-5">Addons</span>
            </el-menu-item>
          
            <el-menu-item
                index="vendors"
                :route="{ name: 'vendors' }"
                v-bind:class="[$route.name === 'vendors' || $route.name === 'add-vendor' || $route.name === 'edit-vendor' ? 'el-menu-item is-active' : 'el-menu-item']"
            >
                <i  class="el-icon-box" :style="[$route.name === 'vendors' || $route.name === 'add-vendor' || $route.name === 'edit-vendor' ? {'color': 'white'} : {'color':'grey'}]"></i>
                <span :style="[$route.name === 'vendors' ? {'color': 'white'} : {'color':'black'}]" class="m-l-5">Vendors</span>
            </el-menu-item>
          
        
        </el-menu>

    </div>
</template>

<script>
import {BIcon} from 'bootstrap-vue'
    export default {
        name: 'Sidebar',
        components: {
            BIcon
        },
        data(){
            return {
                isCollapse: true,
            }
        },
        computed: {
            currentRouteName(){
                return this.$router.name
            },
            currentRoutePath(){
                return this.$route.path
            }
        },
        methods: {
            handleOpen(key, keyPath) {
        
            },
            handleClose(key, keyPath) {
  
            },
            goToAbout(){
                this.$router.push({
                    name:'about'
                })
            },
            
        },

       
    }
</script>

<style lang="scss" scoped>
 .el-menu-vertical-demo:not(.el-menu--collapse) {
    width: 250px;
    min-height: 400px;
    border-right: none;
        font-weight: 600;
       
        font-style: 'Mr Eaves XL Modern Bold';
    .el-menu-item {
        border-top-right-radius: 15px;
        border-bottom-right-radius: 15px;
        // background-color: orange !important;
       font-size: 15px;
  
    }

    .el-menu-item.is-active {
        background-color: #ff7b50 !important;
        font-weight: 600;
        color:white;
  

    }

    // .el-menu-item:hover{
    //     // background-color: #ff6666f8 !important;
    // }
    
    // .el-submenu__title {
    //     border-top-right-radius: 15px;
    //     border-bottom-right-radius: 15px;
    // }

    // .el-submenu__title:hover {
    //     background-color: #ff666691 !important;
    // }

  }
  
</style>