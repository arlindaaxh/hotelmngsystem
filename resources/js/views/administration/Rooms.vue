<template>
    <div class="form-max-width" v-if="$route.name === 'rooms'" v-loading="loading">
    <div class="shortcuts-header flexed justify-between">
      <h4>Rooms</h4>
    </div>
    <div class="one-column-list">
      <div class="flexed justify-between m-b-20">
        <el-input class="search-input" size="big" placeholder="Search departments by name or code" v-model="query" :style="'max-width:450px'">
          <i class="el-icon-search el-input__icon" slot="suffix"></i>
        </el-input>
        <div>
          <el-button size="big" style="background-color:#ff7b50; border-radius:15px;color:white" @click="addNewRoom()">New</el-button>
        </div>
      </div>
       <div class="pl-15 mt-50 table-sort">
            <div class="flexed align-center " style="gap:10px">
                <strong>Name</strong>
                <span class="sort-icon-asc-desc pointer flexed-column">
                    <i
                    class="el-icon-caret-top" style="height:10px"
                    @click="sortBy('upc_code', 'asc')"
                    :class="sortField === 'upc_code' && sortOrder === 'asc' ? 'sorted-field-ascending' : 'ascending'"
                    ></i>
                    <i
                    class="el-icon-caret-bottom" 
                    :class="sortField === 'upc_code' && sortOrder === 'desc' ? 'sorted-field-descending' : 'descending'"
                    @click="sortBy('upc_code', 'desc')"
                    ></i>
                </span>
            </div>
             <div class="flexed align-center " style="gap:10px">
                <strong>Code</strong>
                <span class="sort-icon-asc-desc flexed-column">
                    <i
                    class="el-icon-caret-top" style="height:10px"
                    @click="sortBy('upc_code', 'asc')"
                    :class="sortField === 'upc_code' && sortOrder === 'asc' ? 'sorted-field-ascending' : 'ascending'"
                    ></i>
                    <i
                    class="el-icon-caret-bottom" 
                    :class="sortField === 'upc_code' && sortOrder === 'desc' ? 'sorted-field-descending' : 'descending'"
                    @click="sortBy('upc_code', 'desc')"
                    ></i>
                </span>
            </div>
             <div class="flexed align-center " style="gap:10px">
                <strong>Status</strong>
                <span class="sort-icon-asc-desc flexed-column">
                    <i
                    class="el-icon-caret-top" style="height:10px"
                    @click="sortBy('upc_code', 'asc')"
                    :class="sortField === 'upc_code' && sortOrder === 'asc' ? 'sorted-field-ascending' : 'ascending'"
                    ></i>
                    <i
                    class="el-icon-caret-bottom" 
                    :class="sortField === 'upc_code' && sortOrder === 'desc' ? 'sorted-field-descending' : 'descending'"
                    @click="sortBy('upc_code', 'desc')"
                    ></i>
                </span>
            </div>
       </div>
    
        <div class="mt-10">
           
            <div class="card-items-container pointer flexed" @click="editRoom(room)"> 
                <!-- <el-avatar :size="size" src="https://cube.elemecdn.com/3/7c/3ea6beec64369c2642b92c6726f1epng.png"></el-avatar> -->
                <span class="info-name text">Number</span>
                <span class="info-name">Code</span>
               
                <!-- <span class="info-item">{{department.active === 1 ? 'active' : 'inactive'}}</span> -->
            
                <div class="flexed justify-end" style="font-size:26px; gap:5px;">
                    <!-- <i class="el-icon-edit-outline" style="color:#66b1ff"></i> -->
                    <i class="el-icon-delete" style="font-size:20px; color:#f56565"></i>
                </div>
            </div>
            
        </div>
   
       <el-alert
            type="info" 
            :closable="false" 
            class="mt-30"
            title="No results found" 
            show-icon
            
        />
    </div>
   
  </div>
    <div v-else>
        <router-view/>
    </div>

</template>

<script>
    export default {
        name: 'AddEditRoom',
        data(){
            
            return {
                loading: false,
                query: "", 
                sortField: "",
                sortOrder: 'asc',
            }
        
        },
        methods: {
            addNewRoom(){
                this.$router.push({
                    name: 'add-room',
                    insertEdit: 'add'
                })  
            },
            sortBy(field, order) {            
                this.sortField = field;
                this.sortOrder = order;
                if(this.sortOrder === 'asc'){
                    this.sortedObject(this.rooms, this.sortField)
                }else {
                    this.sortedObjectDescending(this.rooms, this.sortField)
                }
            },
            sortedObject(array, key) {
                return array.sort((a, b) => {
                    let nameA = a[key].toUpperCase();
                    let nameB = b[key].toUpperCase();
                    if (nameA < nameB) {
                        return -1;
                    }
                    if (nameA > nameB) {
                        return 1;
                    }
                    return 0;
                });
            },

            sortedObjectDescending(array, key) {
                return array.sort((a, b) => {
                    let nameA = a[key].toUpperCase();
                    let nameB = b[key].toUpperCase();
                    if (nameA > nameB) {
                        return -1;
                    }
                    if (nameA < nameB) {
                        return 1;
                    }
                    return 0;
                });
            },
        }
    }
</script>

<style lang="scss" scoped>
.card-items-container{
    display: grid;
    grid-template-columns: 1fr 1fr 1fr 1fr;

}

.table-sort {
    display: grid;
    padding-right:10px;
    display: grid;
    grid-template-columns: 1fr 1fr 1fr 1fr;
    align-items: center;
    font-size: 16px;
    justify-content: space-between;
    margin-bottom: 10px;
    padding-left: 15px;
    padding-right: 15px ;
    font-family: 'Mulish', sans-serif;
}
</style>