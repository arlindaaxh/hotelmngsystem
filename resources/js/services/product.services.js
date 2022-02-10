import axios from "axios";

export default{
    postProduct(payload){
        const url = `http://127.0.0.1:8000/api/products`
        return axios.post(url, payload)
    },

    getProducts(){
        const url = `http://127.0.0.1:8000/api/products`
        return axios.get(url)
    },

    putProduct(payload, id){
        const url = `http://127.0.0.1:8000/api/products/${id}`
        return axios.put(url, payload)
    },

    searchProd(query){
        const url = `http://127.0.0.1:8000/api/search-products`
        return axios.post(url, query)
    }
}