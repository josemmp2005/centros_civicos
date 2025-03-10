/**
 * Barra de navegación con los enlaces a las distintas secciones de la app.
 * Muestra los enlaces a la página principal, actividades, instalaciones y las secciones de usuario si el usuario está autenticado.
 * Utiliza el componente Link para navegar entre las distintas rutas.
 */


import { Link } from "react-router-dom";
import { useContext } from "react";
import { AuthContext } from "../context/AuthContext";

export default function Navbar() {
    const { user } = useContext(AuthContext);

    return (
        <nav className="bg-gray-800 text-white p-4">
            <Link to="/" className="mr-4">Centros Cívicos</Link>
            <Link to="/actividades" className="mr-4">Actividades</Link>
            <Link to="/instalaciones" className="mr-4">Instalaciones</Link>

            {user && (
                <>
                    <Link to="/reservas" className="mr-4">Mis Reservas</Link>
                    <Link to="/inscripciones" className="mr-4">Mis Inscripciones</Link>
                    <Link to="/usuario" className="mr-4">Mi Perfil</Link>
                </>
            )}
        </nav>
    );
}
