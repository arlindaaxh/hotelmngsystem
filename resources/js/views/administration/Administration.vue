<template>
    <div>

        <header></header>
        <header/>
     
        <div class="sidebar">
              
            <sidebar/> 
        </div>
        <!-- <header><header/> -->
        Administration
        <div class="content">
            <router-view></router-view>
        </div>

   
    </div>
</template>

<script>
import Header from '../../components/Header.vue'
import Sidebar from '../../components/Sidebar.vue'
    export default {
    components: { Sidebar, Header },
        name: 'Administration',
        data(){
            return {
        
            }
        },
     
        
    }
</script>

<style lang="scss" scoped>
.header {
  background: white;
  display: flex;
  align-items: center;
  border-bottom: 1px solid #e6e6e6;
  height: 70px;
}
</style>
