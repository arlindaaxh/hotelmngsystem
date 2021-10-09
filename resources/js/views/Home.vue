<template>
    <div class="container align-items-center">
        <div class="flexed-column align-center vertical-middle">
            <el-card>Test1</el-card>
            <el-card>Test1</el-card>
        </div>

        <div class="row h-100">
   <div class="col-sm-12 my-auto">
     <div class="card card-block w-25">Card</div>
   </div>
</div>
        <div class="btn btn-primary">test</div>
        <el-button @click="got()">Test</el-button>
    </div>
</template>

<script>
    export default {
        methods: {
            got() {
                this.$router.push({
                    name: 'About'
                })
            }
        },
    }
</script>

<style lang="scss" scoped>
.container{
    margin-top: auto;
margin-bottom: auto;
}

</style>