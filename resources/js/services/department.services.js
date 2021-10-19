import axios from "axios";

export default {
    getDepartments(){
        const url = `http://127.0.0.1:8000/api/departments`
        return axios.get(url)
    },
    postDepartment(payload){
        const url = `http://127.0.0.1:8000/api/departments`
        return axios.post(url, payload)
    },
    putDepartment(payload,id){
        const url = `http://127.0.0.1:8000/api/departments/${id}`
        return axios.put(url, payload)
    },
    deleteDepartment(id){
        const url = `http://127.0.0.1:8000/api/departments/${id}`
        return axios.delete(url)
    }
}