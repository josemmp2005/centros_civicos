import axios from "axios";

const api = axios.create({
    baseURL: "http://api.centros_civicos.local/api",
    headers: {
        "Content-Type": "application/json",
    },
});

export default api;
