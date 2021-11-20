<template>
    <div class="form-max-width" v-loading="loading">
        <div class="flexed justify-between  m-b-20">
            <span @click="goBack()" class="flexed align-center pointer">
                <arrow-left-icon size="1.2x" class="m-r-5" />
                <h4 v-if="insertEdit ==='edit'">Edit Room - {{room.code}} </h4>
                <h4 v-else>Add Room</h4>
            </span>
            <el-button size="big" style="background-color:#ff7b50; border-radius:15px;color:white" v-if="insertEdit === 'edit'" @click="editRoom()">Save</el-button>
            <el-button size="big" style="background-color:#ff7b50; border-radius:15px;color:white" v-else @click="save()">Save</el-button>
        </div>

        <div class="content mt-30">
            <el-form
                ref="add-edit-employees-form"
                :model="room"
                :rules="rules"
                size="medium"
                :hide-required-asterisk="true"
                class="form-data"
                label-position="top"

            >
                <el-form-item prop="type" label="Type">
                    <!-- <el-input  name="type" v-model="room.type" size="big"></el-input> -->
                    <el-select name="type" v-model="room.type"  placeholder="Select room type" style="width:100%" size="big" >
                        <el-option
                            v-for="item in roomTypes"
                            :key="item.value"
                            :label="item.label"
                            :value="item.label"
                        >
                        </el-option>
                    </el-select>
                </el-form-item>
                

                <el-form-item prop="code" label="Code">
                    <el-input  name="code" v-model="room.code" size="big"></el-input>
                </el-form-item>

                <el-form-item prop="number" label="Number">
                    <el-input  name="number" v-model="room.number" size="big"></el-input>
                </el-form-item>

                <el-form-item prop="status" label="Facilities">
                    <el-select v-model="facility_items" multiple placeholder="Select facility items" style="width:100%" size="big">
                        <el-option
                            v-for="item in localfacilities"
                            :key="item.value"
                            :label="item.label"
                            :value="item"
                            value-key
                            >
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item prop="status" label="Status">
                    <el-switch  name="status" v-model="room.status" size="big"></el-switch>
                    <span v-if="room.status">Available</span>
                    <span v-else>Booked</span>
                </el-form-item>

                <el-form-item prop="cleaning_status" label="Cleaning Status">
                    <el-select v-model="room.cleaning_status"  placeholder="Select room status" style="width:100%" size="big" >
                        <el-option
                            v-for="item in roomCleaningStatuses"
                            :key="item.value"
                            :label="item.label"
                            :value="item.label"
                        >
                        </el-option>
                    </el-select>
                </el-form-item>
               
            </el-form>
        </div>
    </div>
</template>

<script>
import {ArrowLeftIcon} from 'vue-feather-icons'
import RoomServices from '../../../services/room.services'
    export default {
        name: 'AddEditRoom',
        props: ['insertEdit','roomProp'],
        components: {
            ArrowLeftIcon
        },
        data() {
            return {
                loading: false,
                
                room: {
                    type: null,
                    code: null,
                    number: null,
                    status: true,
                    facilities: [],
                    cleaning_status: null,
                    id: null,
                },
                facility_items: [],
                roomTypes: [
                    {
                        value: '1',
                        label: 'Standard Double Room'
                    },
                    {
                        value: '2',
                        label: 'Standard Single Room'
                    },
                    {
                        value: '3',
                        label: 'Standard Family Room'
                    },
                    {
                        value: '4',
                        label: 'Standard Suite'
                    },
                    {
                        value: '5',
                        label: 'Kings Room'
                    },
                    {
                        value: '6',
                        label: 'Standard Triple Room'
                    },
                    {
                        value: '7',
                        label: 'Standard Quad Room'
                    }
                ],
                rules: {

                },
                localfacilities: [
                    {
                        label: 'Free toiletries',
                        value: '1'
                    },
                    {
                        label: 'Bathrobe',
                        value: '2'
                    },
                    {
                        label: 'conditioning',
                        value: '3'
                    },
                    {
                        label: 'Desk TV',
                        value: '4'
                    },
                    {
                        label: 'Heating',
                        value: '5'
                    },
                    {
                        label: 'Hairdryer ',
                        value: '6'
                    },
                    {
                        label: 'Dining table',
                        value: '7'
                    },
                    {
                        label: 'Sofa',
                        value: '8'
                    },
                    {
                        label: 'Bed',
                        value: '9'
                    },
                    {
                        label: 'tea/coffee maker',
                        value: '10'
                    }, 
                    {
                        label: 'Fireplace',
                        value: '11'
                    }, 
                    
                ],
                roomCleaningStatuses: [
                    {
                        label: 'Clean',
                        value: '1'
                    },
                    {
                        label: 'Dirty',
                        value: '2'
                    },
                    {
                        label: 'Ready',
                        value: '3'
                    },
                ],
               

            }
        },
        methods: {
            goBack(){
                this.$router.push({
                    name: 'rooms'
                })
            },
            // addFacility(){
            //     this.room.facilities.push(this.facility_item)
            //     console.log('facilities', this.room.facilities )
            // },
            save() {
                this.loading = true
                
                this.room.facilities = this.facility_items
                if(this.room.status === true){
                    this.room.status = 1
                }
                else if(this.room.status === false){
                    this.room.status = 0
                }
                RoomServices.postRoom(this.room).then((res) => {
                    this.$notify.success({
                        title: 'Success',
                        type: 'Success',
                        message: 'Room was added successfully'
                    })
                    this.goBack()
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
            editRoom(){
                this.loading = true
                if(this.room.status === true){
                    this.room.status = 1
                }
                else if(this.room.status === false){
                    this.room.status = 0
                }
           
                this.room.facilities = this.facility_items
        
                RoomServices.putRoom(this.room, this.room.id).then((res) => {
                   this.$notify.success({
                        title: 'Success',
                        type: 'Success',
                        message: 'Room was updated successfully'
                    })
                    this.goBack()
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
            }
        },
        beforeMount(){
            console.log('insertEdit', this.insertEdit)
            if(!this.insertEdit){
                this.goBack()
            }
            else {
                if(this.insertEdit === 'edit'){
                    this.room = {...this.roomProp}
                    console.log('rooom', this.room)
                    if(this.room.status === 1){
                        this.room.status = true
                    }
                    this.facility_items = this.room.facilities
                }
            }
        }
    }
</script>

<style lang="scss" scoped>
::v-deep .el-tag.el-tag--info {
    background-color: rgb(255, 123, 80);
    border-color: #e9e9eb;
    color: white;
    font-weight: 500; 

    .el-tag__close {
        color: black;
        background-color: white;
    }
}

// ::v-deep .el-switch.is-checked {
    
//     .el-switch__core {
//         border-color: #32ce6e;
//         background-color: #40ff70;
//     }

// }

// ::v-deep .el-switch__core {
//     border-color: #ce3232;
//     background-color: #ff4040;
// }


</style>