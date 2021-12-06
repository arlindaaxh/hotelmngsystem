<template>
    <div>
        In House
        <create-product v-if="test" @close="test = false"/>
    </div>
    
</template>

<script>
import CreateProduct from '../../components/CreateProduct.vue'
    export default {
    components: { CreateProduct },
    data() {
        return {
            test: true
        }
    },
        
    }
</script>

<style lang="scss" scoped>

</style>