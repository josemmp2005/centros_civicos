import { createContext, useState, useEffect } from "react";
import axios from "axios";
import { useNavigate, useLocation } from "react-router-dom";
import api from "../api/axiosClient"; // Asegúrate de la ruta correcta


export const AuthContext = createContext();

export const AuthProvider = ({ children }) => {
    const navigate = useNavigate();
    const location = useLocation();

    const [user, setUser] = useState(null);
    const [token, setToken] = useState(localStorage.getItem("token") || "");
    const [reservas, setReservas] = useState([]);
    const [inscripciones, setInscripciones] = useState([]);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        if (token) {
            fetchUser();
        } else {
            setLoading(false);
        }
    }, [token]);

    const guardarUltimaURL = () => {
        localStorage.setItem("ultimaURL", location.pathname);
    };

    const login = async ({ email, password }) => {
        try {
            const response = await axios.post("http://api.centros_civicos.local/api/login", { email, password });
            const { jwt } = response.data;

            if (!jwt) {
                console.error("No se recibió un token en la respuesta");
                return;
            }

            localStorage.setItem("token", jwt);
            setToken(jwt);
            await fetchUser();

            const ultimaURL = localStorage.getItem("ultimaURL") || "/";
            navigate(ultimaURL);
            localStorage.removeItem("ultimaURL");
        } catch (error) {
            console.error("Error en el login:", error.response?.data || error.message);
        }
    };

    const fetchUser = async () => {
        try {
            const token = localStorage.getItem("token");
            if (!token) return;

            const response = await axios.get("http://api.centros_civicos.local/api/user", {
                headers: { Authorization: `Bearer ${token}` }
            });

            setUser(response.data);
        } catch (error) {
            console.error("Error obteniendo usuario:", error.response?.data || error.message);
            logout();
        } finally {
            setLoading(false);
        }
    };

    const logout = () => {
        localStorage.removeItem("token");
        setToken("");
        setUser(null);
        guardarUltimaURL();
        navigate("/login");
    };

    const getReservas = async () => {
        if (!user) return;

        try {
            const response = await axios.get("http://api.centros_civicos.local/api/reservas", {
                headers: { Authorization: `Bearer ${token}` }
            });
            setReservas(response.data);
        } catch (error) {
            console.error("Error obteniendo reservas:", error.response?.data || error.message);
        }
    };

    const crearReserva = async (reservaData) => {
        if (!token) return;
    
        try {
            const response = await axios.post(
                "http://api.centros_civicos.local/api/reservas",
                reservaData,
                { headers: { Authorization: `Bearer ${token}` } }
            );
            window.location.reload(); // Recarga la página después de crear la reserva
            return response.data;
        } catch (error) {
            console.error("Error creando reserva:", error.response?.data || error.message);
        }
    };
    

    const cancelarReserva = async (id) => {
        try {
            await axios.delete(`http://api.centros_civicos.local/api/reservas/${id}`, {
                headers: { Authorization: `Bearer ${token}` }
            });
            window.location.reload(); // Recarga la página después de cancelar la reserva
        } catch (error) {
            console.error("Error cancelando reserva:", error.response?.data || error.message);
        }
    };
    

    const getInscripciones = async () => {
        if (!user) return;

        try {
            const response = await axios.get("http://api.centros_civicos.local/api/inscripciones", {
                headers: { Authorization: `Bearer ${token}` }
            });
            setInscripciones(response.data);
        } catch (error) {
            console.error("Error obteniendo inscripciones:", error.response?.data || error.message);
        }
    };

    const crearInscripcion = async (inscripcion) => {
        console.log(inscripcion)
        try {
            const response = await axios.post("http://api.centros_civicos.local/api/inscripciones", inscripcion, {
                headers: {
                    "Content-Type": "application/json",
                    Authorization: `Bearer ${token}` // Solo si la API lo requiere
                }
            });
            console.log("Respuesta del servidor:", response.data);
            getInscripciones(); // Recargar inscripciones tras la creación
        } catch (error) {
            console.error("Error al crear la inscripción:", error.response?.data || error.message);
        }
    };

    const getUserInfo = async () => {
        try {
            const token = localStorage.getItem("token"); // Asegúrate de que el token existe
            if (!token) {
                console.error("No hay token almacenado.");
                return;
            }
    
            const response = await axios.get("http://api.centros_civicos.local/api/user", {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            });
    
            console.log(response.data); // Verifica qué responde la API
        } catch (error) {
            console.error("Error obteniendo información del usuario:", error.response?.data || error.message);
        }
    };
    

    const cancelarInscripcion = async (id) => {
        try {
            await axios.delete(`http://api.centros_civicos.local/api/inscripciones/${id}`, {
                headers: { Authorization: `Bearer ${token}` }
            });
            setInscripciones(inscripciones.filter(inscripcion => inscripcion.id !== id));
        } catch (error) {
            console.error("Error cancelando inscripción:", error.response?.data || error.message);
        }
    };

    const actualizarUsuario = async (datosUsuario) => {
        try {
            const response = await axios.put("http://api.centros_civicos.local/api/user", datosUsuario, {
                headers: { Authorization: `Bearer ${token}` }
            });
            setUser(response.data);
            alert("Perfil actualizado correctamente");
        } catch (error) {
            console.error("Error actualizando usuario:", error.response?.data || error.message);
            alert("Error al actualizar perfil");
        }
    };

    return (
        <AuthContext.Provider value={{
            user, login, logout, fetchUser, actualizarUsuario, getUserInfo,
            getReservas, crearReserva, cancelarReserva, reservas,
            getInscripciones, crearInscripcion, cancelarInscripcion, inscripciones, loading
        }}>
            {!loading && children}
        </AuthContext.Provider>
    );
};
