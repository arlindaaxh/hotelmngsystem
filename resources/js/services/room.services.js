import axios from "axios";

export default {

    getRooms(){
        const url = `http://127.0.0.1:8000/api/rooms`
        return axios.get(url)
    },
    postRoom(payload){
        const url = `http://127.0.0.1:8000/api/add-room`
        return axios.post(url, payload)
    },

    putRoom(payload, id){
        const url = `http://127.0.0.1:8000/api/edit-room/${id}`
        return axios.put(url, payload)
    },
    deleteRoom(id){
        const url = `http://127.0.0.1:8000/api/rooms/${id}`
        return axios.delete(url)
    }
  
}