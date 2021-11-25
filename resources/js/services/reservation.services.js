import axios from "axios";

export default {
    postReservation(payload){
        const url = `http://127.0.0.1:8000/api/reservations`
        return axios.post(url, payload)
    }
}