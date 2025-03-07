<?php
    $instalacion = $data['instalacion'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Editar Intalación</h1>
    <form action="" method="post">
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" id="nombre" value="<?php echo $instalacion["nombre"]; ?>">
        <br>
        <label for="descripcion">Descripcion</label>
        <input type="text" name="descripcion" id="descripcion" value="<?php echo $instalacion["descripcion"]; ?>">
        <br>
        <label for="capacidad_max">Capacidad Maxima</label>
        <input type="text" name="capacidad_max" id="capacidad_max" value="<?php echo $instalacion["capacidad_max"]; ?>">
        <br>
        <input type="hidden" name="centro_id" value="<?php echo $instalacion["centro_id"]; ?>">
        <input type="submit" value="Editar" name="submit">
    </form>
</body>
</html>