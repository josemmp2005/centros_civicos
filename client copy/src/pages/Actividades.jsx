import { useEffect, useState } from "react";
import axiosClient from "../api/axiosClient";

export default function Actividades() {
    const [actividades, setActividades] = useState([]);
    const [searchId, setSearchId] = useState("");  
    const [filteredActividades, setFilteredActividades] = useState([]);

    useEffect(() => {
        axiosClient.get("/actividades")
            .then(response => {
                setActividades(response.data);
                setFilteredActividades(response.data);
            })
            .catch(error => {
                console.error("Error al obtener las actividades:", error);
            });
    }, []);

    // Manejar la búsqueda por ID
    const handleSearch = (event) => {
        const id = event.target.value;
        setSearchId(id);
        
        if (id === "") {
            setFilteredActividades(actividades);
        } else {
            const actividadFiltrada = actividades.filter(act => act.id.toString() === id);
            setFilteredActividades(actividadFiltrada);
        }
    };

    return (
        <div className="container">
            <h2 className="title">Actividades</h2>

            {/* 🔍 Input para buscar por ID */}
            <input 
                type="number" 
                placeholder="Buscar por ID..." 
                value={searchId} 
                onChange={handleSearch} 
                className="search-input"
            />

            <div className="centros-grid">
                {filteredActividades.length > 0 ? (
                    filteredActividades.map(act => (
                        <article key={act.id} className="actividad-card">
                            <h3 className="actividad-nombre">{act.nombre}</h3>
                            <p><strong>Centro:</strong> {act.centro_id}</p>
                            <p><strong>Descripción:</strong> {act.descripcion}</p>
                            <p><strong>Fecha de inicio:</strong> {act.fecha_inicio}</p>
                            <p><strong>Fecha de fin:</strong> {act.fecha_final}</p>
                            <p><strong>Horario:</strong> {act.horario}</p>
                            <p><strong>Plazas disponibles:</strong> {act.plazas}</p>
                        </article>
                    ))
                ) : (
                    <p className="no-results">No se encontró ninguna actividad con ese ID.</p>
                )}
            </div>
        </div>
    );
}
