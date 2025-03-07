/**
 * Página con la lista de instalaciones deportivas o culturales disponibles.
 */

import { useEffect, useState } from "react";
import axiosClient from "../api/axiosClient";

export default function Instalaciones() {
    const [instalaciones, setInstalaciones] = useState([]);
    const [searchId, setSearchId] = useState("");
    const [filteredInstalaciones, setFilteredInstalaciones] = useState([]);

    useEffect(() => {
        axiosClient.get("/instalaciones")
            .then(response => {
                setInstalaciones(response.data);
                setFilteredInstalaciones(response.data);
            })
            .catch(error => {
                console.error("Error al obtener las instalaciones:", error);
            });
    }, []);

    // Manejar búsqueda por ID
    const handleSearch = (event) => {
        const id = event.target.value;
        setSearchId(id);
        
        if (id === "") {
            setFilteredInstalaciones(instalaciones);
        } else {
            const instalacionFiltrada = instalaciones.filter(inst => inst.id.toString() === id);
            setFilteredInstalaciones(instalacionFiltrada);
        }
    };

    return (
        <div className="container">
            <h2 className="title">Instalaciones</h2>

            {/* 🔍 Input para buscar por ID */}
            <input 
                type="number" 
                placeholder="Buscar por ID..." 
                value={searchId} 
                onChange={handleSearch} 
                className="search-input"
            />

            <div className="centros-grid">
                {filteredInstalaciones.length > 0 ? (
                    filteredInstalaciones.map(inst => (
                        <article key={inst.id} className="instalacion-card">
                            <h3 className="instalacion-nombre">{inst.nombre}</h3>
                            <p><strong>Centro:</strong> {inst.centro_id}</p>
                            <p><strong>Descripción:</strong> {inst.descripcion}</p>
                            <p><strong>Capacidad:</strong> {inst.capacidad} personas</p>
                        </article>
                    ))
                ) : (
                    <p className="no-results">No se encontró ninguna instalación con ese ID.</p>
                )}
            </div>
        </div>
    );
}
