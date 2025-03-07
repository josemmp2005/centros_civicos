/**
 *  Página del perfil de usuario, donde puede actualizar su información o eliminar su cuenta.
 */

import { useState, useEffect } from "react";
import axios from "axios";

const Usuario = () => {
    const [userData, setUserData] = useState({
        nombre: "",
        password: "",
        confirmPassword: "",
    });

    useEffect(() => {
        const fetchUser = async () => {
            try {
                const token = localStorage.getItem("token");
                const response = await axios.get("http://api.centros_civicos.local/api/user", {
                    headers: { Authorization: `Bearer ${token}` }
                });

                // Excluir el email de los datos que se almacenan en el estado
                const { email, ...userWithoutEmail } = response.data;
                setUserData({ ...userWithoutEmail, password: "", confirmPassword: "" });
            } catch (error) {
                console.error("Error obteniendo usuario:", error.response?.data || error.message);
            }
        };

        fetchUser();
    }, []);

    const handleUpdate = async (e) => {
        e.preventDefault();
        
        if (userData.password && userData.password !== userData.confirmPassword) {
            alert("Las contraseñas no coinciden.");
            return;
        }

        try {
            const token = localStorage.getItem("token");

            const updateData = { nombre: userData.nombre };
            if (userData.password) {
                updateData.password = userData.password;
            }

            const response = await axios.put("http://api.centros_civicos.local/api/user", updateData, {
                headers: { Authorization: `Bearer ${token}` }
            });

            console.log("Usuario actualizado con éxito:", response.data);
            alert("Usuario actualizado correctamente.");
            setUserData({ ...userData, password: "", confirmPassword: "" });
        } catch (error) {
            console.error("Error actualizando usuario:", error.response?.data || error.message);
            alert("Error al actualizar usuario.");
        }
    };

    return (
        <div className="usuario-container">
            <h2>Actualizar Usuario</h2>
            <form className="usuario-form" onSubmit={handleUpdate}>
                <label>Nombre:</label>
                <input
                    type="text"
                    value={userData.nombre}
                    onChange={(e) => setUserData({ ...userData, nombre: e.target.value })}
                    required
                />

                <label>Nueva Contraseña:</label>
                <input
                    type="password"
                    value={userData.password}
                    onChange={(e) => setUserData({ ...userData, password: e.target.value })}
                />

                <label>Confirmar Contraseña:</label>
                <input
                    type="password"
                    value={userData.confirmPassword}
                    onChange={(e) => setUserData({ ...userData, confirmPassword: e.target.value })}
                />

                <button type="submit">Actualizar</button>
            </form>
        </div>
    );
};

export default Usuario;
