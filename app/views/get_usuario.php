<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Usuario</h1>
    <table border="1">
        <tr>
            <th>Nombre</th>
            <th>Email</th>
            <th>Password</th>
        </tr>
        <?php
            $usuario = $data['usuario'];
            echo "<tr>";
            echo "<td>".$usuario["nombre"]."</td>";
            echo "<td>".$usuario["email"]."</td>";
            echo "<td>".$usuario["password"]."</td>";
            echo "</tr>";
        ?>
    </table>
</body>
</html>