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
            <th>Nombre</th>
            <th>Direccion</th>
            <th>Telefono</th>
            <th>Horario</th>
        </tr>
        <?php
            // var_dump($data['centroCivico']["id"]);
            // var_dump($centro_civico);
            $centro_civico = $data['centroCivico'];
            echo "<tr>";
            echo "<td>".$centro_civico["nombre"]."</td>";
            echo "<td>".$centro_civico["direccion"]."</td>";
            echo "<td>".$centro_civico["telefono"]."</td>";
            echo "<td>".$centro_civico["horario"]."</td>";
            echo "</tr>";    
        ?>
    </table>
    
</body>
</html>