<template>
  <normal-popup>
    <div slot="header" class="flexed justify-between align-center">
        <span class="pointer m-t-5 m-b-5">
            <i class="el-icon-close" @click="$emit('close')"></i>
        </span>
        <span class="label-no-height m-t-5 m-b-5">Artikujt (Malli,lënda e parë dhe asetet-investimet)</span>
        <el-button size="medium" type="primary" @click="save()">Ruaj</el-button>
    </div>
    <div v-loading="loading" class="body">
        <el-form
            ref='create-product-form'
            :model="product"
            :rules="rules"
            size="medium"
            :hide-required-asterisk="true"  
        >
            <el-form-item prop="bar_code">
                <div class="flexed justify-between align-center">
                    <span class="label-no-height w-50">Bar Kodi</span>
                    <el-input name="bar_code" v-model="product.bar_code"></el-input>
                </div>
            </el-form-item>
            <el-form-item prop="product_name">
                <div class="flexed justify-between align-center">
                    <span class="label-no-height w-50">Emri i Mallit</span>
                    <el-input name="product_name" v-model="product.product_name" class="w-100" size="medium"></el-input>
                </div>
            </el-form-item>
            <el-form-item prop="njm">
                <div class="flexed justify-between align-center">
                    <span class="label-no-height w-50">NjM</span>
                    <el-input name="njm" v-model="product.njm" class="w-100" size="medium"></el-input>
                </div>
            </el-form-item>
            <el-form-item prop="product_number">
                <div class="flexed justify-between align-center">
                    <span class="label-no-height w-50">Shifra e Mallit</span>
                    <el-input name="product_number" v-model="product.product_number" class="w-100" size="medium"></el-input>
                </div>
            </el-form-item>
            <el-form-item prop="wholesale_price">
                <div class="flexed justify-between align-center">
                    <span class="label-no-height w-50">Çmimi me shumicë</span>
                    <el-input-number name="wholesale_price" v-model="product.wholesale_price" size="medium" style="width:150px;" :min="0"></el-input-number>
                </div>
            </el-form-item>

            <el-form-item prop="retail_price">
                <div class="flexed justify-between align-center">
                    <span class="label-no-height w-50">Çmimi me pakicë</span>
                    <el-input-number name="retail_price" v-model="product.retail_price" size="medium" style="width:150px;" :min="0"></el-input-number>
                </div>
            </el-form-item>

            <el-form-item prop="total_amount">
                <div class="flexed justify-between align-center">
                    <span class="label-no-height w-50">Sasia në komplet</span>
                    <el-input-number name="total_amount" v-model="product.total_amount" size="medium" style="width:150px;" :min="0"></el-input-number>
                </div>
            </el-form-item>
        </el-form>
    </div>
  </normal-popup>
</template>

<script>
import NormalPopup from './NormalPopup.vue'
export default {
    components: { NormalPopup },
    data() {
        return {
            loading: false,
            product: {
                bar_code: null,
                name: null,
                njm: null,
                product_number: null,
                wholesale_price: null,
                retail_price: null,
                total_amount: null,
            },
            rules: {
                bar_code: [
                    {
                        required: true,
                        message: "Kjo fushë nuk duhet të jetë e zbrazët",
                        trigger: "change",
                    },
                    {
                        max: 255,
                        message: "Maksimumi i karaktereve të lejuara është 255",
                        trigger: "change",
                    },
                ],
                product_name: [
                    {
                        required: true,
                        message: "Kjo fushë nuk duhet të jetë e zbrazët",
                        trigger: "change",
                    },
                    {
                        max: 255,
                        message: "Maksimumi i karaktereve të lejuara është 255",
                        trigger: "change",
                    },
                ],
                njm: [
                    {
                        required: true,
                        message: "Kjo fushë nuk duhet të jetë e zbrazët",
                        trigger: "change",
                    },
                    {
                        max: 255,
                        message: "Maksimumi i karaktereve të lejuara është 255",
                        trigger: "change",
                    },
                ],
                product_number: [
                    {
                        required: true,
                        message: "Kjo fushë nuk duhet të jetë e zbrazët",
                        trigger: "change",
                    },
                    {
                        max: 255,
                        message: "Maksimumi i karaktereve të lejuara është 255",
                        trigger: "change",
                    },
                ],
            }
            
        }
    },
    methods: {
        save(){
            this.$refs['create-product-form'].validate((valid) => {
                if(valid){
                    // here kodi per me save
                    console.log('validation check passed')
                }
            })

        }
    }
}
</script>

<style lang="scss" scoped>
::v-deep .el-form-item__error{
    color: #F56C6C;
    font-size: 12px;
    line-height: 1;
    padding-top: 4px;
    position: absolute;
    top: 100%;
    right: 0 !important;
    /* left: 0; */
    text-align: right;
}

.pointer{
    cursor: pointer;
}

.label-no-height{
    font-size: 14px;
    color: #606266;
    font-weight: bold;
}

.flexed{
    display: flex;
}

.justify-between{
    justify-content: space-between;
}

.align-center{
    align-items: center;
}

.w-50{
    width: 50%;
}

.w-100{
    width: 100%;
}

.m-t-5{
    margin-top: 5px;
} 

.m-b-5{
    margin-bottom: 5px;
}
</style>