/**
 *  Configura una instancia de Axios para hacer peticiones a la API, incluyendo la base URL y 
 *  posibles interceptores para manejar autenticación o errores.
 */

import axios from "axios";

const api = axios.create({
    baseURL: "http://api.centros_civicos.local/api",
    headers: {
        "Content-Type": "application/json",
    },
});

export default api;
