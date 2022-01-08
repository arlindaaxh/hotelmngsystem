<template>
    <div class="form-max-width" v-if="$route.name === 'rooms'" v-loading="loading">
    <div class="shortcuts-header flexed justify-between">
      <h4>Rooms</h4>
    </div>
    <div class="one-column-list">
        <div class="flexed justify-between m-b-20">
            <div class="flexed" style="flex:2;gap:20px;">
                <el-input class="search-input" size="big" placeholder="Search departments by name or code" v-model="query" :style="'max-width:450px'">
                    <i class="el-icon-search el-input__icon" slot="suffix"></i>
                </el-input>
                <el-button @click="selectAction()">
                    <span v-if="!selectButton">
                        Select
                    </span>
                    <span v-else>Cancel</span>
                </el-button>
            </div>
        
            <div>
            <el-button size="big" style="background-color:#ff7b50; border-radius:15px;color:white" @click="addNewRoom()">New</el-button>
            </div>
        </div>
        
        <div :class="!selectButton ? 'pl-15 mt-50 table-sort' : 'pl-45 mt-50 table-sort'">
            <div class="flexed align-center " style="gap:10px">
                <strong>Type</strong>
                <span class="sort-icon-asc-desc pointer flexed-column">
                    <i
                    class="el-icon-caret-top" style="height:10px"
                    @click="sortBy('type', 'asc')"
                    :class="sortField === 'type' && sortOrder === 'asc' ? 'sorted-field-ascending' : 'ascending'"
                    ></i>
                    <i
                    class="el-icon-caret-bottom" 
                    :class="sortField === 'type' && sortOrder === 'desc' ? 'sorted-field-descending' : 'descending'"
                    @click="sortBy('type', 'desc')"
                    ></i>
                </span>
            </div>
             <div class="flexed align-center " style="gap:10px">
                <strong>Code</strong>
                <span class="sort-icon-asc-desc flexed-column">
                    <i
                    class="el-icon-caret-top" style="height:10px"
                    @click="sortBy('code', 'asc')"
                    :class="sortField === 'code' && sortOrder === 'asc' ? 'sorted-field-ascending' : 'ascending'"
                    ></i>
                    <i
                    class="el-icon-caret-bottom" 
                    :class="sortField === 'code' && sortOrder === 'desc' ? 'sorted-field-descending' : 'descending'"
                    @click="sortBy('code', 'desc')"
                    ></i>
                </span>
            </div>
             <div class="flexed align-center " style="gap:10px">
                <strong>Status</strong>
                <span class="sort-icon-asc-desc flexed-column">
                    <i
                    class="el-icon-caret-top" style="height:10px"
                    @click="sortBy('status', 'asc')"
                    :class="sortField === '1' && sortOrder === 'asc' ? 'sorted-field-ascending' : 'ascending'"
                    ></i>
                    <i
                    class="el-icon-caret-bottom" 
                    :class="sortField === '1' && sortOrder === 'desc' ? 'sorted-field-descending' : 'descending'"
                    @click="sortBy('status', 'desc')"
                    ></i>
                </span>
            </div>
       </div>
    
        <div class="mt-10 flexed align-center" style="gap:20px; margin-bottom:10px"  v-for="(room,index) in filteredRooms" :key="index">
            <el-checkbox v-if="selectButton" v-model="room.checked" style="flex:0"></el-checkbox>
            <div class="card-items-container pointer flexed"  @click="editRoom(room)" style="flex:4; margin-bottom:0px"> 
                <!-- <el-avatar :size="size" src="https://cube.elemecdn.com/3/7c/3ea6beec64369c2642b92c6726f1epng.png"></el-avatar> -->
                <span class="info-name text">{{room.type}}</span>
                <span class="info-name">{{room.code}}</span>
                <span class="info-name" :class="room.status === 1 ? 'text-success' : 'text-danger'">{{room.status === 1 ? 'AVAILABLE' : 'BOOKED'}}</span>
               
                <!-- <span class="info-item">{{department.active === 1 ? 'active' : 'inactive'}}</span> -->
            
                <div class="flexed justify-end" style="font-size:26px; gap:5px;">
                    <!-- <i class="el-icon-edit-outline" style="color:#66b1ff"></i> -->
                    <i class="el-icon-delete" style="font-size:20px; color:#f56565" @click="deleteRoom(room, $event)"></i>
                </div>
            </div>
            
        </div>
   
       <el-alert v-if="!loading && filteredRooms && filteredRooms.length === 0"
            type="info" 
            :closable="false" 
            class="mt-30"
            title="No results found" 
            show-icon
            
        />

        <delete-room-modal v-if="showDeleteRoomModal" :roomProp="roomProp" @close="showHideDeleteRoomModal()"/>
    </div>
   
  </div>
    <div v-else>
        <router-view/>
    </div>

</template>

<script>
import DeleteRoomModal from '../../components/administration/rooms/DeleteRoomModal.vue'
import RoomServices from '../../services/room.services'
    export default {
  components: { DeleteRoomModal },
        name: 'AddEditRoom',
        data(){
            
            return {
                loading: false,
                query: "", 
                sortField: "",
                sortOrder: 'asc',
                rooms: [],
                showDeleteRoomModal: false,
                roomProp: null,
                selectButton: false
            }
        
        },
        computed: {
            filteredRooms(){
                 return (
                    (this.rooms && this.rooms.filter(element => {
                        return (
                           element.type.toLowerCase().match(this.query.toLowerCase()) || element.code.toLowerCase().match(this.query.toLowerCase())

                        )
                        })
                    )    
                )
            }
        },
        methods: {
            addNewRoom(){
                this.$router.push({
                    name: 'add-room',
                    params: {
                        insertEdit: 'add'
                    }
                    
                })  
            },
            editRoom(room){
               this.$router.push({
                    name: 'edit-room',
                    params: {
                       insertEdit: 'edit',
                        roomProp: room 
                    }
                    
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
            getRooms(){
                this.loading = true
                RoomServices.getRooms().then((res) => {
                    this.rooms = res.data
                    this.rooms.forEach(element => {
                        this.$set(element,'checked', false)
                    });
                     console.log('rooms', this.rooms)
                })
                .catch((error) => {
                    this.loading=false
                    let errorMessage = error?.data?.message ||
                    error?.message ||
                    error?.response?.message ||
                    error?.response?.data?.message
                    if(!errorMessage && error?.data){
                    errorMessage =  error.data
                    }
                    if(!errorMessage) errorMessage = 'Error_occurred'
                    this.$notify.error({
                        title: error?.status || error?.response?.status,
                        message: errorMessage,
                    });
                })
                .finally(() => {
                    this.loading = false
                })

            },
            deleteRoom(room, event){
                event.stopPropagation()
                this.showDeleteRoomModal = true
                this.roomProp = room
            },
            showHideDeleteRoomModal(){
                this.showDeleteRoomModal = false
                this.getRooms()
            },
            selectAction(){
                this.selectButton = !this.selectButton
            }
            
        },
        beforeMount(){
            this.getRooms()
           
        },
        beforeRouteUpdate(to, from, next){
            if(to.name === 'rooms'){
                this.getRooms()
            }
            next();
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

.pl-45 {
    padding-left: 45px;
}
</style>