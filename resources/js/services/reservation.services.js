import axios from "axios";

export default {
    postReservation(payload){
        const url = `http://127.0.0.1:8000/api/reservations`
        return axios.post(url, payload)
    },
    getReservations(){
        const url = `http://127.0.0.1:8000/api/reservations`
        return axios.get(url)
    },
    getReservationsByDate(params){
        const url = `http://127.0.0.1:8000/api/reservations-list?`
        return axios.get(url, {params})
        //DATE_FROM={}&DATE_TO={}
    },
    putReservation(payload, id){
        const url = `http://127.0.0.1:8000/api/edit-reservation/${id}`
        return axios.put(url, payload)
    },
 
}