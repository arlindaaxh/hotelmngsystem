<template>
    <div class="container align-center" style="width:100%;">
        <div class="container box">
            <el-card class="card" style="width:450px;margin:0 auto;" >
                <div slot="header" class="clearfix text-center">
                    <span class="label-no-height">My Hotel's Management System</span>
                </div>
                <div class="flexed-column align-center text-center ">
                  
                   <img v-bind:src="'../../images/' + image.url"  style="width:150px;height:150px; border-radius:50%; margin-bottom:20px"/> 
                    <!-- <i class="el-icon-office-building" style="font-size:40px; margin-bottom: 40px; margin-top:40px"></i> -->
                    <el-form
                        :model="formData"
                        :rules="rules"
                    >
                         
                        <div class="forma align-center" style="margin-bottom:18px">
                            <div v-if="error" class="alert alert-danger error">{{ error }}</div>     
                            <el-form-item prop="email" >
                                <el-input
                                    placeholder="Email"
                                    v-model="formData.email"
                                    clearable
                                    size="big"
                                    style="margin-bottom:18px"
                                    type="email"
                                    name="email"
                                >
                                </el-input>       
                            </el-form-item>               
                            <el-form-item prop="password" >                
                                <el-input
                                    placeholder="Password"
                           
                                    v-model="formData.password"
                                    clearable
                                    show-password
                                    size="big"
                                    style="margin-bottom:18px"
                                    name="password"
                                >
                                </el-input>   
                            </el-form-item>           
                        </div>
                            <div>
                                <el-button size="big" style="width:312px;margin-bottom:20px" @click="submit()" type="primary" :loading="buttonLoading">Login</el-button>
                            </div>
                    </el-form>
                   
                  
                </div>
<!--                 
                <div class="register-label" style="padding-top:18px;border-top: 1px solid #EBEEF5;box-sizing: border-box;">
                    <small>Nuk jeni i regjistruar? <span style="color:#ff7b50; font-weight:550;cursor:pointer" @click="openRegisterModal">Regjistrohu</span></small>
                </div>
        -->
            </el-card>
        </div>
      
    </div>
</template>

<script>
import axios from 'axios'
export default {
    data() {
        return {
            loading: false,
            openLogin: false,
            formData:{
                email: '',
                password: ''
            },
            error: null,
            buttonLoading: false,
            image: {
                url: 'frontdesk.png'
            },
            rules: {
                email: [
                    {
                        required: true,
                        message: "Field is required!",
                        trigger: "change",
                    },
                ],
                password: [
                    {
                        required: true,
                        message: "Field is required!",
                        trigger: "change",
                    },
                ],
            }
        }
    },
    methods:{
        submit(){
            this.buttonLoading = true
            let url = `http://127.0.0.1:8000/login`;
            axios.post(url, this.formData).then((response) => {
                this.$notify({
                    title: 'Sukses',
                    type: 'success',
                    message: 'Logimi u krye me sukses!'
                })
                this.buttonLoading = false
                this.$router.push({
                    name: 'home'
                })
                // this.openLogin = false
                // this.$emit("refreshDashbordOnLogin")
            }).catch((errors) =>{   
                this.$notify({
                    title: 'Error',
                    type: 'error',
                    message: 'Incorrect email or password'
                });
                this.buttonLoading = false
            })
        }
    }
}   
</script>

<style lang="scss" scoped>

.validation-icons{
  border: 1px solid #ff7b50;
  width: 300px;
  margin: 0 auto;
}


::v-deep{
  footer#__BVID__8___BV_modal_footer_ {
      justify-content: center !important;  
  }

  .modal-footer {   
    justify-content: center;
   }

  .el-button--primary {
    background: #ff7b50;
    border-color: #ff7b50;
    color: #FFF;
  }

  .el-button--primary:hover {
    background: #ff7b50;
    border-color: #ff7b50;
    color: #FFF;
  }

  .el-input.is-active .el-input__inner, .el-input__inner:focus {
    border-color: #ff7b50; 
    outline: 0;
  }
}

.box {
    position: absolute;
    top: 50%;
    transform: translate(0, -50%);
    // border: 5px solid #FFFF00;
    padding: 10px;

    .card {
        // width:300px;
        // height:400px;
        // padding: 2px;

        .image {
            width: 100%;
            height: 200px;
            
        }
    }

}

</style>