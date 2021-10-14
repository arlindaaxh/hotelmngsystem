<template>
    <div>
        <div class="flexed  ml-20 p-20 pt-40" style="font-weight:bold; font-size:17px"><span class="el-icon-office-building"></span>My Hotel Logo</div>
        <!-- <el-radio-group v-model="isCollapse" style="margin-bottom: 20px;">
        <el-radio-button :label="false">expand</el-radio-button>
        <el-radio-button :label="true">collapse</el-radio-button>
        </el-radio-group> -->
        <!-- <el-menu 
            :default-active="$route.path" 
            class="el-menu-vertical-demo" 
            @open="handleOpen"
            @close="handleClose" 
            :collapse="!isCollapse" 
            :router="true"
            background-color="#f5f5f5"
            :active-text-color="'#fff'"

        >
            <el-menu-item index="dashboard" :route="{name: 'dashboard'}" v-bind:class="[$route.name === 'dashboard' ? 'el-menu-item is-active' : 'el-menu-item']">
                <i class="el-icon-menu"></i>
                <span slot="title">Dashboard</span>
            </el-menu-item>
        
            <el-menu-item index="2">
                <i class="el-icon-menu"></i>
                <span slot="title">Navigator Two</span>
            </el-menu-item>
            <el-menu-item index="3" disabled>
                <i class="el-icon-document"></i>
                <span slot="title">Navigator Three</span>
            </el-menu-item>
            <el-menu-item index="4">
                <i class="el-icon-setting"></i>
                <span slot="title">Configuration</span>
            </el-menu-item>

            <el-submenu  index="products" class="sub-extra-none">

                <template slot="title">
                   <span class="p-5"> <img src="@/assets/new-product-icon.svg" style="
                    width: 22px; margin:3px"/></span>
        
                    <span slot="title">Configuration</span>
                </template>
                <el-menu-item-group>
                    <el-menu-item
                        index="employees"
                        v-bind:class="[ currentRouteName === 'employees' ? 'el-menu-item is-active' : 'el-menu-item']"
                        :route="{ name: 'employees' }"
                        >Employees
                    </el-menu-item>
                </el-menu-item-group>
            </el-submenu>
        </el-menu> -->

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
                <img src="../../css/assets/dashboard_icn.svg" style="width:22px; margin:3px"/>
                <span :style="[$route.name === 'dashboard' ? {'color': 'white'} : {'color':'black'}]" >  Dashboard</span>
            </el-menu-item>
            <el-menu-item
                index="employees"
                :route="{ name: 'employees' }"
                v-bind:class="[$route.name === 'employees' ? 'el-menu-item is-active' : 'el-menu-item']"
            >
                <i class="el-icon-s-custom"></i>
                <span :style="[$route.name === 'employees' ? {'color': 'white'} : {'color':'black'}]">Employees</span>
            </el-menu-item>
          
        
        </el-menu>

    </div>
</template>

<script>
    export default {
        name: 'Sidebar',
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
        background-color: #ff9677 !important;
        font-weight: 600;
        color:white;
  

    }

    .el-menu-item:hover{
        background-color: #ff666688 !important;
    }
    
    // .el-submenu__title {
    //     border-top-right-radius: 15px;
    //     border-bottom-right-radius: 15px;
    // }

    // .el-submenu__title:hover {
    //     background-color: #ff666691 !important;
    // }

  }
  
</style>