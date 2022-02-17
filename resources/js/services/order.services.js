import axios from "axios";

export default{
    
    postOrder(payload){
        const url = `http://127.0.0.1:8000/api/create-order`
        return axios.post(url, payload)
    },

    getOrders(){
        const url = `http://127.0.0.1:8000/api/orders`
        return axios.get(url)
    },

    putOrder(payload, id){
        const url = `http://127.0.0.1:8000/api/edit-order/${id}`
        return axios.put(url, payload)
    },


    updateOrderStatuses(payload){
        const url = `http://127.0.0.1:8000/api/edit-orders`
        return axios.put(url, payload)
    }
}