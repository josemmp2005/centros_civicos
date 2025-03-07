/**
 * Componente envoltorio para definir la estructura de la página, maneja el diseño general y la navegación.
 * Muestra el encabezado y la barra de navegación.
 * Utiliza el componente Outlet para mostrar el contenido de la ruta actual.
 */

import { Outlet } from "react-router-dom";
import Header from "./Header";
import Navbar from "./Navbar";

export default function Layout() {
    return (
        <div className="min-h-screen flex flex-col">
            <Header />
            <Navbar />
            <main className="flex-grow p-4">
                <Outlet />
            </main>
        </div>
    );
}
