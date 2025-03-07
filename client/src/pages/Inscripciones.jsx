/**
 * Página donde los usuarios pueden ver y gestionar sus inscripciones en actividades.
 */

import { useContext, useEffect, useState } from "react";
import { AuthContext } from "../context/AuthContext";

export default function Inscripciones() {
    const { getInscripciones, crearInscripcion, cancelarInscripcion, inscripciones, getActividades, actividades } = useContext(AuthContext);
    const [formData, setFormData] = useState({
        solicitante: "",
        telefono: "",
        email: "",
        actividad_id: "",
        fecha_inscripcion: "",
        estado: "Lista de espera"
    });

    useEffect(() => {
        getInscripciones();
        getActividades();
    }, []);

    const handleChange = (e) => {
        setFormData({ ...formData, [e.target.name]: e.target.value });
    };

    const handleNuevaInscripcion = () => {
        if (!formData.actividad_id.trim() || !formData.solicitante.trim() || !formData.telefono.trim() || !formData.email.trim() || !formData.fecha_inscripcion.trim()) {
            alert("Todos los campos son obligatorios.");
            return;
        }
        console.log("Enviando inscripción:", formData); // Verifica los valores antes de enviarlos

        crearInscripcion(formData);
        setFormData({
            solicitante: "",
            telefono: "",
            email: "",
            actividad_id: "",
            fecha_inscripcion: "",
            estado: "Lista de espera"
        });
    };

    const getActividadNombre = (id) => {
        const actividad = actividades.find(act => act.id === id);
        return actividad ? actividad.nombre : `Actividad #${id}`;
    };

    return (
        <div className="inscripciones-container">
            <h2 className="inscripciones-title">Mis Inscripciones</h2>

            {inscripciones.length > 0 ? (
                <table className="inscripciones-table">
                    <thead>
                        <tr>
                            <th>Solicitante</th>
                            <th>Teléfono</th>
                            <th>Email</th>
                            <th>Actividad</th>
                            <th>Estado</th>
                            <th>Fecha de Inscripción</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        {inscripciones.map((inscripcion, index) => (
                            <tr key={inscripcion.id || index}>
                                <td>{inscripcion.solicitante}</td>
                                <td>{inscripcion.telefono}</td>
                                <td>{inscripcion.email}</td>
                                <td>{getActividadNombre(inscripcion.actividad_id)}</td>
                                <td>{inscripcion.estado}</td>
                                <td>{inscripcion.fecha_inscripcion}</td>
                                <td>
                                    <button 
                                        className="cancel-btn"
                                        onClick={() => cancelarInscripcion(inscripcion.id)}
                                    >
                                        Cancelar
                                    </button>
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            ) : (
                <p className="no-inscripciones">No tienes inscripciones.</p>
            )}

            <h3 className="inscripciones-subtitle">Inscribirse en una Actividad</h3>
            <div className="inscripciones-form">
                <label>Nombre del Solicitante:</label>
                <input 
                    type="text" 
                    name="solicitante"
                    placeholder="Ej: Manolo Lama" 
                    value={formData.solicitante} 
                    onChange={handleChange} 
                    required 
                />
                <label>Teléfono:</label>
                <input 
                    type="text" 
                    name="telefono"
                    placeholder="Ej: 666666666" 
                    value={formData.telefono} 
                    onChange={handleChange} 
                    required 
                />
                <label>Email:</label>
                <input 
                    type="email" 
                    name="email"
                    placeholder="Ej: manolo@example.com" 
                    value={formData.email} 
                    onChange={handleChange} 
                    required 
                />
                <label>Actividad:</label>
                <select name="actividad_id" value={formData.actividad_id} onChange={handleChange} required>
                    <option value="">Selecciona una actividad</option>
                    {actividades.map(actividad => (
                        <option key={actividad.id} value={actividad.id}>
                            {actividad.nombre}
                        </option>
                    ))}
                </select>
                <label>Fecha de Inscripción:</label>
                <input 
                    type="date" 
                    name="fecha_inscripcion"
                    value={formData.fecha_inscripcion} 
                    onChange={handleChange} 
                    required 
                />
                <button className="inscribirse-btn" onClick={handleNuevaInscripcion}>
                    Inscribirse
                </button>
            </div>
        </div>
    );
}