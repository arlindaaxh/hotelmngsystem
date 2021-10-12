<template>
    <div class="container align-center">
    
        <div class="cards container flexed justify-around">
            <el-card class="card flexed-column">
                <!-- <img :src="'../../public/images/administration-logo.jpg'" class="image"> -->
                <img src="../../css/images/administration-logo.jpg" class="image">
                 <!-- <img src="C:\xampp\htdocs\hotelmngsystem\resources\css\images\administration-logo.jpg" class="image"> -->
                <div class="flexed justify-center vertical-middle align-center mt-30" style="height:100px;">
                    <el-button  type="text" @click="goToAdministration()"><h3 class="pt-20">Administration</h3></el-button>
                </div>
            </el-card>
            <el-card class="card flexed-column">
                <!-- <img :src="'../../public/images/administration-logo.jpg'" class="image"> -->
                <img src="../../css/images/frontdesk.png" class="image">
                 <!-- <img src="C:\xampp\htdocs\hotelmngsystem\resources\css\images\administration-logo.jpg" class="image"> -->
                <div class="flexed justify-center vertical-middle align-center mt-30" style="height:100px;">
                    <el-button  type="text" @click="goToAdministration()"><h3 class="pt-20">Frontdesk</h3></el-button>
                </div>
            </el-card>
            <el-card class="card flexed-column">
                <!-- <img :src="'../../public/images/administration-logo.jpg'" class="image"> -->
                <img src="../../css/images/frontdesk.png" class="image">
                 <!-- <img src="C:\xampp\htdocs\hotelmngsystem\resources\css\images\administration-logo.jpg" class="image"> -->
                <div class="flexed justify-center vertical-middle align-center mt-30" style="height:100px;">
                    <el-button  type="text" @click="goToAdministration()"><h3 class="pt-20">Housekeeping</h3></el-button>
                </div>
            </el-card>
        </div>
     
        
        <!-- 
        
        <div class="btn btn-primary">test</div>
        <el-button @click="got()">Test</el-button> -->
    </div>
</template>

<script>
    export default {
        data(){
            return {

            }
        },
        methods: {
            got() {
                this.$router.push({
                    name: 'About'
                })
            },

            goToAdministration(){
                console.log('u')
                this.$router.push({
                    name: 'administration'
                })
            }
            
        },
    }
</script>

<style lang="scss" scoped>
.cards {
    position: absolute;
    top: 50%;
    transform: translate(0, -50%);
    // border: 5px solid #FFFF00;
    padding: 10px;

    .card {
        width:300px;
        height:400px;
        // padding: 2px;

        .image {
            width: 100%;
            height: 200px;
            
        }
    }

}
</style>