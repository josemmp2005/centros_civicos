<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Reserva</h1>
    <table border="1">
        <tr>
            <th>Solicitante</th>
            <th>Telefono</th>
            <th>Email</th>
            <th>Instalacion_ID</th>
            <th>Fecha_Inicio</th>
            <th>Fecha_Final</th>
            <th>Estado</th>
        </tr>
        <?php
            $reserva = $data['reserva'];
            echo "<tr>";
            echo "<td>".$reserva["solicitante"]."</td>";
            echo "<td>".$reserva["telefono"]."</td>";
            echo "<td>".$reserva["email"]."</td>";
            echo "<td>".$reserva["instalacion_id"]."</td>";
            echo "<td>".$reserva["fecha_inicio"]."</td>";
            echo "<td>".$reserva["fecha_final"]."</td>";
            echo "<td>".$reserva["estado"]."</td>";
            echo "</tr>";
        ?>
    </table>
</body>
</html>