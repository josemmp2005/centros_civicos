import { useState } from "react";
import axios from "axios";
import { useNavigate } from "react-router-dom";

function Register() {
    const [nombre, setNombre] = useState("");
    const [email, setEmail] = useState("");
    const [password, setPassword] = useState("");
    const [confirmPassword, setConfirmPassword] = useState("");
    const [error, setError] = useState("");
    const navigate = useNavigate();

    const handleRegister = (event) => {
        event.preventDefault();
        setError(""); // Limpiar errores previos

        // Validación de coincidencia de contraseñas
        if (password !== confirmPassword) {
            setError("Las contraseñas no coinciden.");
            return;
        }

        axios.post("http://api.centros_civicos.local/api/register", { nombre, email, password })
            .then(() => {
                alert("Registro exitoso. Ahora puedes iniciar sesión.");
                navigate("/login"); // Redirigir a login
            })
            .catch(() => {
                setError("Error al registrar. Revisa los datos e inténtalo de nuevo.");
            });
    };

    return (
        <div className="register-container">
            <div className="register-card">
                <h1 className="register-title">Registro</h1>
                {error && <p className="register-error">{error}</p>}
                <form onSubmit={handleRegister}>
                    <input type="text" placeholder="Nombre" value={nombre} onChange={(e) => setNombre(e.target.value)} required className="register-input" />
                    <input type="email" placeholder="Correo" value={email} onChange={(e) => setEmail(e.target.value)} required className="register-input" />
                    <input type="password" placeholder="Contraseña" value={password} onChange={(e) => setPassword(e.target.value)} required className="register-input" />
                    <input type="password" placeholder="Confirmar Contraseña" value={confirmPassword} onChange={(e) => setConfirmPassword(e.target.value)} required className="register-input" />
                    <button type="submit" className="register-button">Registrarse</button>
                </form>
            </div>
        </div>
    );
}

export default Register;
