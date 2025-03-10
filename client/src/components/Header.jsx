/**
 * Componente que muestra el encabezado de la aplicación.
 * Muestra un botón para cerrar sesión si el usuario está autenticado.
 * Muestra los enlaces para iniciar sesión y registrarse si el usuario no está autenticado.
 * Muestra el título de la aplicación.
 */

import { useContext } from "react";
import { AuthContext } from "../context/AuthContext";
import { Link } from "react-router-dom";

export default function Header() {
    const { user, logout } = useContext(AuthContext);

    return (
        <header className="bg-blue-600 text-white p-4 flex justify-between">
            <div>
                
                {user ? (
                    <button onClick={logout} className="ml-4">Cerrar Sesión</button>
                ) : (
                    <>
                        <Link to="/login" className="mr-4">Login</Link>
                        <Link to="/register">Registro</Link>
                    </>
                )}
            </div>
                <h1 className="text-xl font-bold">Centros Cívicos</h1>
        </header>
    );
}
