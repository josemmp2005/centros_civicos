import { useState, useEffect } from "react";
import axiosClient from "../api/axiosClient";

export default function Centros() {
    const [centros, setCentros] = useState([]);
    const [searchId, setSearchId] = useState("");  // Estado para la búsqueda
    const [filteredCentros, setFilteredCentros] = useState([]);

    useEffect(() => {
        axiosClient.get("/centros")
            .then(response => {
                setCentros(response.data);
                setFilteredCentros(response.data);
            })
            .catch(error => {
                console.error("Error al obtener los centros:", error);
            });
    }, []);

    // Manejar la búsqueda por ID
    const handleSearch = (event) => {
        const id = event.target.value;
        setSearchId(id);
        
        if (id === "") {
            setFilteredCentros(centros);  // Si está vacío, mostrar todos
        } else {
            const centroFiltrado = centros.filter(centro => centro.id.toString() === id);
            setFilteredCentros(centroFiltrado);
        }
    };

    return (
        <div className="container">
            <h2 className="title">Centros Cívicos</h2>

            {/* 🔍 Input para buscar por ID */}
            <input 
                type="number" 
                placeholder="Buscar por ID..." 
                value={searchId} 
                onChange={handleSearch} 
                className="search-input"
            />

            <div className="centros-grid">
                {filteredCentros.length > 0 ? (
                    filteredCentros.map(centro => (
                        <article key={centro.id} className="centro-card">
                            <h3 className="centro-nombre">{centro.nombre}</h3>
                            <p><strong>Dirección:</strong> {centro.direccion}</p>
                            <p><strong>Teléfono:</strong> {centro.telefono}</p>
                            <p><strong>Horario:</strong> {centro.horario}</p>
                        </article>
                    ))
                ) : (
                    <p className="no-results">No se encontró ningún centro con ese ID.</p>
                )}
            </div>
        </div>
    );
}
