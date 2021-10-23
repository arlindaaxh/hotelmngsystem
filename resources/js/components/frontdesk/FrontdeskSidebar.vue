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
                index="frontdesk-dashboard" 
                :route="{name: 'frontdesk-dashboard'}" 
                v-bind:class="[$route.name === 'frontdesk-dashboard' ? 'el-menu-item is-active' : 'el-menu-item']"
                
            >
               <!-- <i class="el-icon-menu"></i> -->
                <!-- <img src="../../css/assets/dashboard_icn.svg" style="width:22px; margin:3px"/> -->
                <i class="el-icon-s-data"></i>
                <span :style="[$route.name === 'frontdesk-dashboard' ? {'color': 'white'} : {'color':'black'}]" >Dashboard</span>
            </el-menu-item>
            <el-menu-item 
                index="housekeeping" 
                :route="{name: 'housekeeping'}" 
                v-bind:class="[$route.name === 'housekeeping' ? 'el-menu-item is-active' : 'el-menu-item']"
                
            >
                <i class="el-icon-s-open"></i>
                <span :style="[$route.name === 'housekeeping' ? {'color': 'white'} : {'color':'black'}]" >Housekeeping</span>
            </el-menu-item>
            
       
        
        </el-menu>

    </div>
</template>

<script>
import {BIcon} from 'bootstrap-vue'
    export default {
        name: 'FrontdeskSidebar',
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
            
        }
        ,beforeMount() {
            console.log('route',this.$route.path)
        }
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