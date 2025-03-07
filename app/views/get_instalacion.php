<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Instalación</h1>
    <table border="1">
        <tr>
            <th>Nombre</th>
            <th>Descripcion</th>
            <th>Capacidad Maxima</th>
        </tr>
        <?php
            $instalacion = $data['instalacion'];
            echo "<tr>";
            echo "<td>".$instalacion["nombre"]."</td>";
            echo "<td>".$instalacion["descripcion"]."</td>";
            echo "<td>".$instalacion["capacidad_max"]."</td>";
            echo "</tr>";
        ?>        
    </table>
    
</body>
</html>