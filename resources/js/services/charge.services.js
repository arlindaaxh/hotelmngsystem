import axios from "axios";

export default {
    getCharges(){
        const url = `http://127.0.0.1:8000/api/charges`
        return axios.get(url)
    },
    postCharge(payload){
        const url = `http://127.0.0.1:8000/api/charges`
        return axios.post(url, payload)
    },
    putCharge(payload,id){
        const url = `http://127.0.0.1:8000/api/charges/${id}`
        return axios.put(url, payload)
    },
    deleteCharges(id){
        const url = `http://127.0.0.1:8000/api/charges/${id}`
        return axios.delete(url)
    }
}