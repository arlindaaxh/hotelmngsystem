<template>
  <div>
      <b-modal v-model="openLogin" centered>
          <template #modal-title>
            Kyçu - <span style="color: #318C6F">Real Estate Agency</span>
          </template>

          <template #modal-footer>
            <div class="register-label">
                <small>Nuk jeni i regjistruar? <span style="color:#318C6F; font-weight:550;cursor:pointer" @click="openRegisterModal">Regjistrohu</span></small>
            </div>
          </template>
        
          <div class="text-center pt-3 pb-3">
              <div class="forma">
                  <div v-if="error" class="alert alert-danger error">{{ error }}</div>                    
                      <el-input
                          placeholder="Emaili"
                          class=" w-75"
                          v-model="formData.email"
                          clearable
                      >
                      </el-input>                      
                      <el-input
                          placeholder="Fjalëkalimi"
                          class="my-3 w-75"
                          v-model="formData.password"
                          clearable
                          show-password
                      >
                      </el-input>
                      <div>
                          <el-button class="w-75" @click="submit()" type="primary" :loading="buttonLoading">Vazhdo</el-button>
                      </div>                 
              </div>
          </div>
        
      </b-modal>
  </div>
</template>

<script>
import axios from 'axios'
  export default {
    data() {
        return {
            openLogin: false,
            formData:{
                email: '',
                password: ''
            },
            error: null,
            buttonLoading: false,
        }
    },
    computed:{
     
    },
    methods: {
      submit(){
        console.log('here')
          this.buttonLoading = true
          let url = `http://127.0.0.1:8000/login`;
          axios.post(url, this.formData).then((response) => {
              this.$notify({
                  title: 'Sukses',
                  type: 'success',
                  message: 'Logimi u krye me sukses!'
              })
              this.buttonLoading = false
              this.openLogin = false
              this.$emit("refreshDashbordOnLogin")
          }).catch((errors) =>{   
              this.$notify({
                  title: 'Error',
                  type: 'error',
                  message: 'Të dhënat e shënuara nuk janë të sakta, ju lutem provoni përsëri ose provoni më vonë!'
              });
              this.buttonLoading = false
          })
          // .catch(error => {
          //   console.log("ERRRR:: ",error.response.data);
          // });
      },
      openRegisterModal(){
        this.openLogin = false
        this.$root.$emit('openRegisterModal')
      }
    },
    mounted(){
        this.$root.$on('openLoginModal', () => {
            this.openLogin = true
        })
    },
  }
</script>

<style scoped lang="scss">
.validation-icons{
  border: 1px solid #318C6F;
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
    background: #318C6F;
    border-color: #318C6F;
    color: #FFF;
  }

  .el-button--primary:hover {
    background: #39ad88;
    border-color: #39ad88;
    color: #FFF;
  }

  .el-input.is-active .el-input__inner, .el-input__inner:focus {
    border-color: #318C6F; 
    outline: 0;
  }
}

</style>