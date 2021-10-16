import Vue from 'vue'

Vue.mixin({
    data() {
        return {

        }
    }, 
    methods: {
        catchMethod(error){
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
        }
    }
})