<template>
<NormalPopup :no-border="true" :dimmed="true" width="400px">
    <div slot="header" class="flexed justify-between align-center">
        <span class="pointer m-t-5 m-b-5">
            <i class="el-icon-close" @click="$emit('close')"></i>
        </span>
        <span class="label-no-height m-t-5 m-b-5" v-if="addon.id">Edit Addon</span>
        <span class="label-no-height m-t-5 m-b-5" v-else>Add Addon</span>
        <el-button v-if="addon.id" size="medium" style="background-color:#ff7b50; border-radius:15px;color:white" @click="edit()">Save</el-button>
        <el-button v-else size="medium" style="background-color:#ff7b50; border-radius:15px;color:white" @click="save()">Save</el-button>
    </div>
    <div v-loading="loading" class="body">

        <el-form
          ref="add-edit-employees-form"
          :model="addon"
          :rules="rules"
          size="medium"
          :hide-required-asterisk="true"
          label-position="top"

        >
            <el-form-item prop="name" label="Name">
            <el-input  name="name" v-model="addon.name" size="big"></el-input>
            </el-form-item>

            <el-form-item prop="price" label="Price">
            <el-input name="price" v-model="addon.price" size="big">
                <template slot="append">$</template>
            </el-input>
            </el-form-item>

        </el-form>
    </div>
</NormalPopup>

</template>

<script>
import NormalPopup from '../../NormalPopup.vue';
import AddonServices from '../../../services/addon.services'
export default{
    components: {
        NormalPopup
    },
    data() {
        return {
           loading: false,
            addon: {
               name: null,
               price: null,
            },
            rules:{
                name: [
                    {
                        required: true,
                        message: "Field is required",
                        trigger: "change",
                    },
                    {
                        max: 255,
                        message: "Maximum characters allowed is 255",
                        trigger: "change",
                    },
                ],
                price: [
                    {
                        required: true,
                        message: "Field is required",
                        trigger: "change",
                    }
                ],
            }
        }
    },
    methods:{
        save(){
            this.loading = true;
            AddonServices.postAddon(this.addon).then((res) => {
                this.$notify.success({
                    title:'Success',
                    type: 'success',
                    message: 'Addon was created successfully'
                })
                this.$emit('close')
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
    }
}
</script>
