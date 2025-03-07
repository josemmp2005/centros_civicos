<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Centro Civico</h1>
    <table border="1">
        <tr>
            <th>Centro_ID</th>
            <th>Nombre</th>
            <th>Descripcion</th>
            <th>Fecha_Inicio</th>
            <th>Fecha_Final</th>
            <th>Horario</th>
            <th>Plazas</th>
        </tr>
        <?php
            $actividad = $data['actividad'];
            echo "<tr>";
            echo "<td>".$actividad["id"]."</td>";
            echo "<td>".$actividad["nombre"]."</td>";
            echo "<td>".$actividad["descripcion"]."</td>";
            echo "<td>".$actividad["fecha_inicio"]."</td>";
            echo "<td>".$actividad["fecha_final"]."</td>";
            echo "<td>".$actividad["horario"]."</td>";
            echo "<td>".$actividad["plazas"]."</td>";
            echo "</tr>";
        ?>
    </table>
    
</body>
</html>