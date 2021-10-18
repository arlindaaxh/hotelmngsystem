import axios from "axios";

export default {
    getEmployees(){
        const url = `http://127.0.0.1:8000/api/employees`
        return axios.get(url)
    },
    postEmployee(payload){
        const url = `http://127.0.0.1:8000/api/add-employee`
        return axios.post(url, payload)
    },
    putEmployee(payload, id){
        const url = `http://127.0.0.1:8000/api/edit-employee/${id}`
        return axios.put(url, payload)
    }
}