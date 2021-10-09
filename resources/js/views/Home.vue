<template>
    <div class="container">
        test
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

</style>