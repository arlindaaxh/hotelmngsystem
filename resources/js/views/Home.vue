<template>
    <div class="container align-center">
    
        <div class="cards container flexed justify-around">
            <el-card class="card flexed-column">
                <!-- <img :src="'../../public/images/administration-logo.jpg'" class="image"> -->
                <!-- <img src="../../css/images/administration-logo.jpg" class="image"> -->
                <img v-bind:src="'../../images/' + admImage.url"  class="image"/>
                 <!-- <img src="C:\xampp\htdocs\hotelmngsystem\resources\css\images\administration-logo.jpg" class="image"> -->
                <div class="flexed justify-center vertical-middle align-center mt-30" style="height:100px;">
                    <el-button  type="text" @click="goToAdministration()"><h3 class="pt-20">Administration</h3></el-button>
                </div>
            </el-card>
            <el-card class="card flexed-column">
                <!-- <img :src="'../../public/images/administration-logo.jpg'" class="image"> -->
                <img v-bind:src="'../../images/' + image.url"  class="image"/>
                 <!-- <img src="C:\xampp\htdocs\hotelmngsystem\resources\css\images\administration-logo.jpg" class="image"> -->
                <div class="flexed justify-center vertical-middle align-center mt-30" style="height:100px;">
                    <el-button  type="text" @click="goToFrontDesk()"><h3 class="pt-20">Frontdesk</h3></el-button>
                </div>
            </el-card>
         
        </div>

        <div>
            <el-button  type="text" @click="openRegisterModal()">
                <h3 class="pt-20">
                    qisishne
                </h3>
            </el-button>
        </div>

        <div>
            <el-button  type="text" @click="logOut()">
                <h3 class="pt-20">
                    lug aut
                </h3>
            </el-button>
        </div>

        <login-modal @refreshDashbordOnLogin="refreshHome"></login-modal>
        <register-modal @refreshDashbordOnRegister="refreshHome"></register-modal>
     
        
        <!-- 
        
        <div class="btn btn-primary">test</div>
        <el-button @click="got()">Test</el-button> -->
    </div>
</template>

<script>
import axios from 'axios'
import RegisterModal from '../components/RegisterModal.vue'
import LoginModal from '../components/LoginModal.vue'
    export default {
        components: {        
            RegisterModal,
            LoginModal
        },
        data(){
            return {
                image: {
                    url: 'frontdesk.png'
                },
                admImage: {
                    url: 'admin.png'
                }
            }
        },
        methods: {
            got() {
                this.$router.push({
                    name: 'About'
                })
            },

            goToAdministration(){
                this.$router.push({
                    name: 'administration'
                })
            },
            goToFrontDesk(){
                this.$router.push({
                    name: 'frontdesk'
                })
            },
            openRegisterModal(){
                this.$root.$emit('openLoginModal')
            }, 

            logOut(){        
                axios.post('/logout').then((response) => {
                this.$notify({
                    title: 'Info',
                    type: 'info',
                    message: 'Ju duhet të kyqeni përsëri për të pasur qasje në të dhëna!'
                })
                this.$emit("refreshDashbordOnLogin")
                })
            },   
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