import { createContext, useState, useEffect } from "react";
import axios from "axios";
import { useNavigate, useLocation } from "react-router-dom";
import api from "../api/axiosClient"; 

// Creación del contexto de autenticación
export const AuthContext = createContext();

// Proveedor del contexto de autenticación
export const AuthProvider = ({ children }) => {
    const navigate = useNavigate(); // Hook para la navegación
    const location = useLocation(); // Hook para obtener la ruta actual

    // Estado para gestionar el usuario autenticado y sus datos
    const [user, setUser] = useState(null);
    const [token, setToken] = useState(localStorage.getItem("token") || "");
    const [reservas, setReservas] = useState([]);
    const [inscripciones, setInscripciones] = useState([]);
    const [instalaciones, setInstalaciones] = useState([]); 
    const [actividades, setActividades] = useState([]); 
    const [loading, setLoading] = useState(true); // Estado de carga inicial

    // Efecto que intenta recuperar los datos del usuario si hay un token almacenado
    useEffect(() => {
        if (token) {
            fetchUser();
        } else {
            setLoading(false);
        }
    }, [token]);

    // Guarda la última URL visitada antes de iniciar sesión
    const guardarUltimaURL = () => {
        localStorage.setItem("ultimaURL", location.pathname);
    };

    // Función para iniciar sesión
    const login = async ({ email, password }) => {
        try {
            // Petición POST al endpoint de login
            const response = await axios.post("http://api.centros_civicos.local/api/login", { email, password });
            // Obtiene el token de la respuesta
            const { jwt } = response.data;

            // Si no hay token, muestra un mensaje de error
            if (!jwt) {
                console.error("No se recibió un token en la respuesta");
                return;
            }
            // Almacena el token en el almacenamiento local
            localStorage.setItem("token", jwt);
            // Actualiza el estado del token
            setToken(jwt);
            // Obtiene los datos del usuario autenticado
            await fetchUser();

            // Redirige a la última URL visitada antes de iniciar sesión
            const ultimaURL = localStorage.getItem("ultimaURL") || "/";
            // Navega a la última URL visitada
            navigate(ultimaURL);
            // Elimina la última URL almacenada
            localStorage.removeItem("ultimaURL");
        } catch (error) {
            console.error("Error en el login:", error.response?.data || error.message);
        }
    };

    // Obtiene los datos del usuario autenticado
    const fetchUser = async () => {
        try {
            // Obtiene el token del almacenamiento local
            const token = localStorage.getItem("token");
            // Si no hay token, no hace nada
            if (!token) return;

            // Realiza una petición GET al endpoint de usuario
            const response = await axios.get("http://api.centros_civicos.local/api/user", {
                headers: { Authorization: `Bearer ${token}` }
            });

            // Almacena los datos del usuario en el estado
            setUser(response.data);
        } catch (error) {
            console.error("Error obteniendo usuario:", error.response?.data || error.message);
            logout();
        } finally {
            // Indica que la carga ha finalizado
            setLoading(false);
        }
    };

    // Cerrar sesión
    const logout = () => {
        // Elimina el token del almacenamiento local
        localStorage.removeItem("token");
        // Actualiza el estado del token y del usuario
        setToken("");
        // Limpia los datos del usuario
        setUser(null);
        // Redirige a la página de inicio de sesión
        guardarUltimaURL();
        // Navega a la página de inicio de sesión
        navigate("/login");
    };

    // Efecto para obtener los datos del usuario al iniciar la aplicación
    const getReservas = async () => {
        // Si no hay usuario autenticado, no hace nada
        if (!user) return;

        // Realiza una petición GET al endpoint de reservas
        try {
            // Petición GET al endpoint de reservas
            const response = await axios.get("http://api.centros_civicos.local/api/reservas", {
                headers: { Authorization: `Bearer ${token}` }
            });
            // Almacena las reservas en el estado
            setReservas(response.data);
        } catch (error) {
            console.error("Error obteniendo reservas:", error.response?.data || error.message);
        }
    };

    // Obtener las reservas del usuario
    const crearReserva = async (reservaData) => {
        // Si no hay token, no hace nada
        if (!token) return;
    
        try {
            // Petición POST al endpoint de reservas
            const response = await axios.post(
                "http://api.centros_civicos.local/api/reservas",
                reservaData,
                { headers: { Authorization: `Bearer ${token}` } }
            );
            // Recarga la página para mostrar la nueva reserva
            window.location.reload(); 
            // Devuelve los datos de la reserva creada
            return response.data;
        } catch (error) {
            console.error("Error creando reserva:", error.response?.data || error.message);
        }
    };
    
    // Cancelar una reserva por ID
    const cancelarReserva = async (id) => {
        try {
            // Petición DELETE al endpoint de reservas
            await axios.delete(`http://api.centros_civicos.local/api/reservas/${id}`, {
                headers: { Authorization: `Bearer ${token}` }
            });
            // Recarga la página para mostrar la reserva cancelada
            window.location.reload();
        } catch (error) {
            console.error("Error cancelando reserva:", error.response?.data || error.message);
        }
    };
    
    // Obtener inscripciones del usuario
    const getInscripciones = async () => {
        // Si no hay usuario autenticado, no hace nada
        if (!user) return;

        // Realiza una petición GET al endpoint de inscripciones
        try {
            // Petición GET al endpoint de inscripciones
            const response = await axios.get("http://api.centros_civicos.local/api/inscripciones", {
                headers: { Authorization: `Bearer ${token}` }
            });
            // Almacena las inscripciones en el estado
            setInscripciones(response.data);
        } catch (error) {
            console.error("Error obteniendo inscripciones:", error.response?.data || error.message);
        }
    };

    // Crear inscripción
    const crearInscripcion = async (inscripcion) => {
        // Si no hay token, no hace nada
        console.log(inscripcion)
        try {
            // Petición POST al endpoint de inscripciones
            const response = await axios.post("http://api.centros_civicos.local/api/inscripciones", inscripcion, {
                headers: {
                    "Content-Type": "application/json",
                    Authorization: `Bearer ${token}`
                }
            });
            // Recarga la página para mostrar la nueva inscripción
            console.log("Respuesta del servidor:", response.data);
            // Devuelve los datos de la inscripción creada
            getInscripciones();
        } catch (error) {
            console.error("Error al crear la inscripción:", error.response?.data || error.message);
        }
    };

    // Obtener información del usuario
    const getUserInfo = async () => {
        try {
            // Obtiene el token del almacenamiento local
            const token = localStorage.getItem("token");
            // Si no hay token, muestra un mensaje de error
            if (!token) {
                console.error("No hay token almacenado.");
                return;
            }
            
            // Realiza una petición GET al endpoint de usuario
            const response = await axios.get("http://api.centros_civicos.local/api/user", {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            });
    
            console.log(response.data); 
        } catch (error) {
            console.error("Error obteniendo información del usuario:", error.response?.data || error.message);
        }
    };
    
    // Cancelar inscripción
    const cancelarInscripcion = async (id) => {
        try {
            // Petición DELETE al endpoint de inscripciones
            await axios.delete(`http://api.centros_civicos.local/api/inscripciones/${id}`, {
                headers: { Authorization: `Bearer ${token}` }
            });
            // Actualiza el estado de las inscripciones
            setInscripciones(inscripciones.filter(inscripcion => inscripcion.id !== id));
        } catch (error) {
            console.error("Error cancelando inscripción:", error.response?.data || error.message);
        }
    };

    // Actualizar usuario
    const actualizarUsuario = async (datosUsuario) => {
        try {
            // Petición PUT al endpoint de usuario
            const response = await axios.put("http://api.centros_civicos.local/api/user", datosUsuario, {
                headers: { Authorization: `Bearer ${token}` }
            });
            // Actualiza los datos del usuario en el estado
            setUser(response.data);
            // Muestra un mensaje de éxito
            alert("Perfil actualizado correctamente");
        } catch (error) {
            console.error("Error actualizando usuario:", error.response?.data || error.message);
            alert("Error al actualizar perfil");
        }
    };

    // Obtener instalaciones
    const getInstalaciones = async () => {
        // Si no hay usuario autenticado, no hace nada
        if (!user) return;

        // Realiza una petición GET al endpoint de instalaciones
        try {
            const response = await axios.get("http://api.centros_civicos.local/api/instalaciones", {
                headers: { Authorization: `Bearer ${token}` }
            });
            // Almacena las instalaciones en el estado
            setInstalaciones(response.data);
        } catch (error) {
            console.error("Error obteniendo instalaciones:", error.response?.data || error.message);
        }
    };

    // Obtener actividades
    const getActividades = async () => {
        // Si no hay usuario autenticado, no hace nada
        if (!user) return;

        // Realiza una petición GET al endpoint de actividades
        try {
            const response = await axios.get("http://api.centros_civicos.local/api/actividades", {
                headers: { Authorization: `Bearer ${token}` }
            });
            // Almacena las actividades en el estado
            setActividades(response.data);
        } catch (error) {
            console.error("Error obteniendo actividades:", error.response?.data || error.message);
        }
    }
    
    // Devuelve el proveedor del contexto de autenticación
    return (
        <AuthContext.Provider value={{
            user, login, logout, fetchUser, actualizarUsuario, getUserInfo,
            getReservas, crearReserva, cancelarReserva, reservas,
            getInscripciones, crearInscripcion, cancelarInscripcion, inscripciones,
            getInstalaciones, instalaciones, getActividades, actividades, loading 
        }}>
            {!loading && children}
        </AuthContext.Provider>
    );
};