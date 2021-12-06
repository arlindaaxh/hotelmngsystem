import axios from "axios";

export default {
    getAddons(){
        const url = `http://127.0.0.1:8000/api/addons`
        return axios.get(url)
    },
    postAddon(payload){
        const url = `http://127.0.0.1:8000/api/addons`
        return axios.post(url, payload)
    },
    putAddon(payload,id){
        const url = `http://127.0.0.1:8000/api/addons/${id}`
        return axios.put(url, payload)
    },
    deleteAddon(id){
        const url = `http://127.0.0.1:8000/api/addons/${id}`
        return axios.delete(url)
    }
}