<template>
    <div>
        <div class="flexed  ml-20 p-20 pt-40" style="font-weight:bold; font-size:17px"><span class="el-icon-office-building"></span>My Hotel Logo</div>
        <!-- <el-radio-group v-model="isCollapse" style="margin-bottom: 20px;">
        <el-radio-button :label="false">expand</el-radio-button>
        <el-radio-button :label="true">collapse</el-radio-button>
        </el-radio-group> -->
        <el-menu 
            :default-active="$route.path" 
            class="el-menu-vertical-demo" 
            @open="handleOpen"
            @close="handleClose" 
            :collapse="!isCollapse" 
            :router="true"
            background-color="#f5f5f5"
           
            active-text-color="white"

        >
            <el-menu-item index="dashboard" :route="{name: 'dashboard'}" v-bind:class="[$route.name === 'dashboard' ? 'el-menu-item is-active' : 'el-menu-item']">
                <i class="el-icon-menu"></i>
                <span slot="title">Dashboard</span>
            </el-menu-item>
            <el-submenu index="1">
                <template slot="title">
                    <i class="el-icon-location"></i>
                    <span slot="title">Dashboard</span>
                </template>
                <el-menu-item-group>
                    <span slot="title">Group One</span>
                    <el-menu-item index="1-1">item one</el-menu-item>
                    <el-menu-item index="1-2">item two</el-menu-item>
                </el-menu-item-group>
                <el-menu-item-group title="Group Two">
                    <el-menu-item index="1-3">item three</el-menu-item>
                </el-menu-item-group>
                <el-submenu index="1-4">
                    <span slot="title">item four</span>
                    <el-menu-item index="1-4-1">item one</el-menu-item>
                </el-submenu>
            </el-submenu>
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
                <span slot="title">Navigator Four</span>
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
            console.log('rou',this.$route.path)
        }
    }
</script>

<style lang="scss" scoped>
 .el-menu-vertical-demo:not(.el-menu--collapse) {
    width: 250px;
    min-height: 400px;
    border-right: none;

    .el-menu-item {
        border-top-right-radius: 15px;
        border-bottom-right-radius: 15px;
        // background-color: orange !important;
  
    }

    .el-menu-item.is-active {
        background-color: #FFE5B4 !important;;
    }
    
    .el-submenu__title {
        border-top-right-radius: 15px;
        border-bottom-right-radius: 15px;
    }

  }
  
</style>