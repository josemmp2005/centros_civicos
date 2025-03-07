/**
 *  Componente que restringe el acceso a ciertas páginas solo para usuarios autenticados.
 */

import { Navigate } from "react-router-dom";
import { useContext } from "react";
import { AuthContext } from "../context/AuthContext";

const PrivateRoute = ({ children }) => {
    const { user } = useContext(AuthContext);

    if (!user) {
        console.log("Usuario no autenticado. Redirigiendo a login.");
        return <Navigate to="/login" />;
    }

    return children;
};

export default PrivateRoute;
