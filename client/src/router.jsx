    import { Routes, Route } from "react-router-dom";
    import Layout from "./components/Layout";
    import Centros from "./pages/Centros";
    import Instalaciones from "./pages/Instalaciones";
    import Actividades from "./pages/Actividades";
    import Login from "./pages/Login";
    import Register from "./pages/Register";
    import Usuario from "./pages/Usuario";  // Ruta privada
    import Reservas from "./pages/Reservas";  // Ruta privada
    import Inscripciones from "./pages/Inscripciones";  // Ruta privada
    import NotFound from "./pages/NotFound";
    import PrivateRoute from "./routes/PrivateRoute"; // Importar el componente de rutas privadas

    const Router = () => {
        return (
            <Routes>
                <Route path="/" element={<Layout />}>
                    <Route index element={<Centros />} />
                    <Route path="instalaciones" element={<Instalaciones />} />
                    <Route path="actividades" element={<Actividades />} />
                    <Route path="login" element={<Login />} />
                    <Route path="register" element={<Register />} />

                    {/* Rutas privadas protegidas */}
                    <Route path="usuario" element={<PrivateRoute><Usuario /></PrivateRoute>} />
                    <Route path="reservas" element={<PrivateRoute><Reservas /></PrivateRoute>} />
                    <Route path="inscripciones" element={<PrivateRoute><Inscripciones /></PrivateRoute>} />

                    <Route path="*" element={<NotFound />} />
                </Route>
            </Routes>
        );
    };

    export default Router;
