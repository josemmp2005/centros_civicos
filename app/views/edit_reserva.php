<?php
    $reserva = $data['reserva'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Editar Reserva</h1>
    <form action="" method="post">
        <label for="solicitante">Solicitante</label>
        <input type="text" name="solicitante" id="solicitante" value="<?php echo $reserva["solicitante"]; ?>">
        <br>
        <label for="telefono">Telefono</label>
        <input type="text" name="telefono" id="telefono" value="<?php echo $reserva["telefono"]; ?>">
        <br>
        <label for="email">Email</label>
        <input type="text" name="email" id="email" value="<?php echo $reserva["email"]; ?>">
        <br>
        <label for="instalacion_id">Instalacion ID</label>
        <input type="text" name="instalacion_id" id="instalacion_id" value="<?php echo $reserva["instalacion_id"]; ?>">
        <br>
        <label for="fecha_inicio">Fecha Inicio</label>
        <input type="text" name="fecha_inicio" id="fecha_inicio" value="<?php echo $reserva["fecha_inicio"]; ?>">
        <br>
        <label for="fecha_final">Fecha Final</label>
        <input type="text" name="fecha_final" id="fecha_final" value="<?php echo $reserva["fecha_final"]; ?>">
        <br>
        <label for="estado">Estado</label>
        <select name="estado" id="estado">
            <option value="Confirmada">Confirmada</option>
            <option value="Pendiente">Pendiente</option>
        </select>
        <br>
        <input type="submit" value="Editar" name="submit">
    </form>
</body>
</html>