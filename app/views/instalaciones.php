<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Instalaciones</h1>
    <table border="1">
        <tr>
            <th>Centro_ID</th>
            <th>Nombre</th>
            <th>Descripcion</th>
            <th>Capacidad_Max</th>
        </tr>
        <?php
            foreach ($data['instalaciones'] as $instalacion) {
                echo "<tr>";
                echo "<td>".$instalacion["centro_id"]."</td>";
                echo "<td>".$instalacion["nombre"]."</td>";
                echo "<td>".$instalacion["descripcion"]."</td>";
                echo "<td>".$instalacion["capacidad_max"]."</td>";
                echo "</tr>";
            }
        ?>
    </table>
</body>
</html>