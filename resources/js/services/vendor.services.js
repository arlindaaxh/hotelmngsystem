import axios from "axios";

export default{
    postVendor(payload){
        const url = `http://127.0.0.1:8000/api/vendors`
        return axios.post(url, payload)
    },

    getVendors(){
        const url = `http://127.0.0.1:8000/api/vendors`
        return axios.get(url)
    },

    putVendor(payload, id){
        const url = `http://127.0.0.1:8000/api/vendors/${id}`
        return axios.put(url, payload)
    },
}