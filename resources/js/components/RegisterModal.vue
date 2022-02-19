<template>
  <div>
      <b-modal v-model="openRegister" centered>
          <template #modal-title>
            Regjistrohu - <span style="color: #318C6F">Real Estate Agency</span>
          </template>

          <template #modal-footer>
            <div class="register-label">
                <small>Jeni i regjistruar? <span style="color:#318C6F; font-weight:550;cursor:pointer" @click="openLoginModal">Kyçu</span></small>

            </div>
          </template>
        
          <div class="text-center pt-3 pb-3">
              <div class="forma">
                  <div v-if="error" class="alert alert-danger error">{{ error }}</div>     
                  <el-input
                          placeholder="Emri i plotë"
                          class="mb-3 w-75"
                          v-model="formData.name"
                          clearable
                      >
                      </el-input>                
                      <el-input
                          placeholder="Emaili"
                          class="mb-3 w-75"
                          v-model="formData.email"
                          clearable
                      >
                      </el-input>

                      <el-input
                          placeholder="Fjalëkalimi"
                          class="mb-3 w-75"
                          v-model="formData.password"
                          clearable
                          show-password
                      >
                      </el-input>
                      <el-input
                          placeholder="Konfirmo Fjalëkalimin"
                          class="mb-3 w-75"
                          v-model="formData.password_confirmation"
                          clearable
                          show-password
                      >
                      </el-input>
                      
                      <div>
                          <el-button class="w-75" @click="submit()" type="primary" :loading="buttonLoading">Vazhdo</el-button>
                      </div>                 
              </div>
          </div>

          <div class="validation-icons pl-2 pt-2" v-if="passwordIsFocused">
            <div v-for="(item, index) in passwordResctrictions" :key="index" class="mb-2" style="display:flex;gap:5px; align-items:center;">
              <div :style="{color: item.checked ? '#67C23A' : '#F56C6C'}">
                <i class="el-icon-check"></i>
              </div>
              <div style="font-size:13px">
                <span>{{ item.name }}</span>
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
            openRegister: false,
            formData: {
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
            },
            error: null,
            buttonLoading: false,
            passwordResctrictions: [
              {id: 1, name: 'Fjalekalimi duhet te kete se paku 8 karaktere', checked: false},
              {id: 2, name: 'Fjalekalimi duhet te kete se paku 8 karaktere', checked: false},
              {id: 3, name: 'Fjalekalimi duhet te kete se paku 8 karaktere', checked: false},
              {id: 4, name: 'Fjalekalimi duhet te kete se paku 8 karaktere', checked: false},
            ]
        }
    },
    computed:{
      passwordIsFocused(){
        return false
      }
    },
    methods: {
      submit(){
          this.buttonLoading = true
          let url = `http://127.0.0.1:8000/register`;
          axios.post(url, this.formData).then((response) => {
              this.$notify({
                  title: 'Sukses',
                  type: 'success',
                  message: 'Regjistrimi u krye me sukses!'
              })
              this.buttonLoading = false
              this.openRegister = false
              this.$emit("refreshDashbordOnLogin")
          }).catch((errors) =>{   
              this.$notify({
                  title: 'Error',
                  type: 'error',
                  message: 'Diçka shkoi gabim, ju lutem provoni përsëri ose provoni më vonë!'
              });
              this.buttonLoading = false
          })
      },
      openLoginModal(){
        this.openRegister = false
        this.$root.$emit('openLoginModal')
      }
    },
    mounted(){
        this.$root.$on('openRegisterModal', () => {
            this.openRegister = true
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