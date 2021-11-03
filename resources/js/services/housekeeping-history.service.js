import axios from "axios";

export default {
    getHousekeepingSchedules(){
        const url = `http://127.0.0.1:8000/api/housekeeping`
        return axios.get(url)
    },
    postHousekeepingHistorySchedule(payload){
        const url = `http://127.0.0.1:8000/api/housekeeping`
        return axios.post(url, payload)
    },
    // putHousekeepingSchedule(payload, id){
    //     const url = `http://127.0.0.1:8000/api/housekeeping/${id}`
    //     return axios.put(url, payload)
    // },
    // deleteHousekeepingSchedule(id){
    //     const url = `http://127.0.0.1:8000/api/housekeeping/${id}`
    //     return axios.delete(url)
    // }
}