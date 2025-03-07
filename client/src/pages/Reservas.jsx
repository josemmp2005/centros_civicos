/**
 * Página donde los usuarios pueden ver y gestionar sus reservas de instalaciones.
 */

import { useContext, useEffect, useState } from "react";
import { AuthContext } from "../context/AuthContext";

export default function Reservas() {
    const { getReservas, crearReserva, cancelarReserva, reservas, getInstalaciones, instalaciones } = useContext(AuthContext);

    const [solicitante, setSolicitante] = useState("");
    const [telefono, setTelefono] = useState("");
    const [email, setEmail] = useState("");
    const [instalacionId, setInstalacionId] = useState("");
    const [fechaInicio, setFechaInicio] = useState("");
    const [fechaFinal, setFechaFinal] = useState("");

    useEffect(() => {
        getReservas();
        getInstalaciones();
    }, []);

    const handleNuevaReserva = () => {
        if (!solicitante || !telefono || !email || !instalacionId || !fechaInicio || !fechaFinal) {
            alert("Debes completar todos los campos");
            return;
        }

        const reservaData = { 
            solicitante,
            telefono,
            email,
            instalacion_id: instalacionId, 
            fecha_inicio: fechaInicio.replace("T", " ") + ":00", 
            fecha_final: fechaFinal.replace("T", " ") + ":00",
            estado: "Pendiente"
        };

        crearReserva(reservaData);

        setSolicitante("");
        setTelefono("");
        setEmail("");
        setInstalacionId("");
        setFechaInicio("");
        setFechaFinal("");
    };

    const getInstalacionNombre = (id) => {
        const instalacion = instalaciones.find(inst => inst.id === id);
        return instalacion ? instalacion.nombre : `Instalación #${id}`;
    };

    return (
        <div className="reservas-container">
            <h2 className="reservas-title">Mis Reservas</h2>

            {reservas.length > 0 ? (
                <table className="reservas-table">
                    <thead>
                        <tr>
                            <th>Solicitante</th>
                            <th>Teléfono</th>
                            <th>Email</th>
                            <th>Instalación</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Final</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        {reservas.map(reserva => (
                            <tr key={reserva.id}>
                                <td>{reserva.solicitante}</td>
                                <td>{reserva.telefono}</td>
                                <td>{reserva.email}</td>
                                <td>{getInstalacionNombre(reserva.instalacion_id)}</td>
                                <td>{reserva.fecha_inicio}</td>
                                <td>{reserva.fecha_final}</td>
                                <td>{reserva.estado}</td>
                                <td>
                                    <button className="cancel-btn" onClick={() => cancelarReserva(reserva.id)}>Cancelar</button>
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            ) : (
                <p className="no-reservas">No tienes reservas.</p>
            )}

            <h3 className="reservas-subtitle">Hacer una nueva reserva</h3>
            <div className="reservas-form">
                <label>Solicitante:
                    <input type="text" value={solicitante} onChange={(e) => setSolicitante(e.target.value)} />
                </label>

                <label>Teléfono:
                    <input type="text" value={telefono} onChange={(e) => setTelefono(e.target.value)} />
                </label>

                <label>Email:
                    <input type="email" value={email} onChange={(e) => setEmail(e.target.value)} />
                </label>

                <label>Instalación:
                    <select value={instalacionId} onChange={(e) => setInstalacionId(e.target.value)}>
                        <option value="">Selecciona una instalación</option>
                        {instalaciones.map(instalacion => (
                            <option key={instalacion.id} value={instalacion.id}>
                                {instalacion.nombre}
                            </option>
                        ))}
                    </select>
                </label>

                <label>Fecha Inicio:
                    <input type="datetime-local" value={fechaInicio} onChange={(e) => setFechaInicio(e.target.value)} />
                </label>

                <label>Fecha Final:
                    <input type="datetime-local" value={fechaFinal} onChange={(e) => setFechaFinal(e.target.value)} />
                </label>

                <button className="reservar-btn" onClick={handleNuevaReserva}>Reservar</button>
            </div>
        </div>
    );
}