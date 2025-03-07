import { useState, useContext } from "react";
import { useNavigate } from "react-router-dom";
import { AuthContext } from "../context/AuthContext";

const Login = () => {
    const [email, setEmail] = useState("");
    const [password, setPassword] = useState("");
    const navigate = useNavigate();
    const { login, fetchUser } = useContext(AuthContext);

    const handleLogin = async () => {
        try {
            await login({ email, password });
            await fetchUser();
            navigate("/");
        } catch (error) {
            console.error("Error en el login:", error.response?.data || error.message);
            alert("Error al iniciar sesión");
        }
    };

    return (
        <div className="login-container">
            <div className="login-card">
                <h2 className="login-title">Iniciar Sesión</h2>
                <input
                    type="email"
                    placeholder="Email"
                    value={email}
                    onChange={(e) => setEmail(e.target.value)}
                    className="login-input"
                />
                <input
                    type="password"
                    placeholder="Contraseña"
                    value={password}
                    onChange={(e) => setPassword(e.target.value)}
                    className="login-input"
                />
                <button onClick={handleLogin} className="login-button">
                    Iniciar Sesión
                </button>
            </div>
        </div>
    );
};

export default Login;
