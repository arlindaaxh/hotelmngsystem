<template>
    <div class="form-max-width" v-if="$route.name === 'employees'" v-loading="loading">
    <div class="shortcuts-header flexed justify-between">
      <h4>Employees</h4>
    </div>
    <div class="one-column-list">
      <div class="flexed justify-between m-b-20">
        <el-input class="search-input" size="big" placeholder="Search employees by name or code" v-model="query" :style="'max-width:450px'">
          <i class="el-icon-search el-input__icon" slot="suffix"></i>
        </el-input>
        <div>
          <el-button size="big" type="primary" @click="addNewShortcut()">New</el-button>
        </div>
      </div>
    
        <div class="form-data mt-30">
            <div class="item pointer flexed" @click="editShortcut(shortcut)">
                <div class="flexed align-center">
                    <el-avatar src="https://cube.elemecdn.com/0/88/03b0d39583f48206768a7534e55bcpng.png" size="large"></el-avatar>
                    <div class="info">
                        <strong class="info-name">Name</strong>
                        <span class="info-item">
                            Email:
                            <span style="color: #a9a7a7;">Name</span>
                        </span>
                    </div>
                </div>
               
                <div class="flexed" style="font-size:26px; gap:5px;">
                    <!-- <i class="el-icon-edit-outline" style="color:#66b1ff"></i> -->
                    <i class="el-icon-delete" style="font-size:25px; color:#f56565"></i>
                </div>
            </div>
            <div class="item pointer flexed" @click="editShortcut(shortcut)"> 
                <div class="flexed align-center">
                    <el-avatar :size="size" src="https://cube.elemecdn.com/3/7c/3ea6beec64369c2642b92c6726f1epng.png"></el-avatar>
                    <div class="info">
                        <strong class="info-name">Name</strong>
                        <span class="info-item">
                            Email:
                            <span style="color: #a9a7a7;">Name</span>
                        </span>
                    </div>
                </div>
               
                <div class="flexed" style="font-size:26px; gap:5px;">
                    <!-- <i class="el-icon-edit-outline" style="color:#66b1ff"></i> -->
                    <i class="el-icon-delete" style="font-size:25px; color:#f56565"></i>
                </div>
            </div>
            
        </div>
   
       <el-alert  type="info" :closable="false" class="m-t-20"
                title="No results found" show-icon
                />
    </div>
  </div>
  <div v-else>
    <router-view />
  </div>
</template>


<script>
import { EditIcon, Trash2Icon } from "vue-feather-icons";
export default {
    name: 'Employees',
    components: {
        EditIcon,
        Trash2Icon
    },
    data() {
        return {
            loading: false,
            query: "",
        }
    }
};
</script>


<style lang="scss" scoped>

</style>