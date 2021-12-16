import axios from "axios";

export default {
    postGuest(payload){
        const url = `http://127.0.0.1:8000/api/guests`
        return axios.post(url, payload)
    },
    getGuests(){
        const url = `http://127.0.0.1:8000/api/guests`
        return axios.get(url)
    }
}