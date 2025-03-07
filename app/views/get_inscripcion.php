<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Inscripción</h1>
    <table border="1">
        <tr>
            <th>Solicitante</th>
            <th>Telefono</th>
            <th>Email</th>
            <th>Actividad_ID</th>
            <th>Fecha_Inscripción</th>
            <th>Estado</th>
        </tr>
        <?php
            $inscripcion = $data['inscripcion'];
            echo "<tr>";
            echo "<td>".$inscripcion["solicitante"]."</td>";
            echo "<td>".$inscripcion["telefono"]."</td>";
            echo "<td>".$inscripcion["email"]."</td>";
            echo "<td>".$inscripcion["actividad_id"]."</td>";
            echo "<td>".$inscripcion["fecha_inscripcion"]."</td>";
            echo "<td>".$inscripcion["estado"]."</td>";
            echo "</tr>";
        ?>
    </table>
</body>
</html>