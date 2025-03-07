<?php
    $centroCivico = $data['centroCivico'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Editar Centro Civico</h1>
    <form action="" method="post">
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" id="nombre" value="<?php echo $centroCivico["nombre"]; ?>">
        <br>
        <label for="direccion">Direccion</label>
        <input type="text" name="direccion" id="direccion" value="<?php echo $centroCivico["direccion"]; ?>">
        <br>
        <label for="telefono">Telefono</label>
        <input type="text" name="telefono" id="telefono" value="<?php echo $centroCivico["telefono"]; ?>">
        <br>
        <label for="horario">Horario</label>
        <input type="text" name="horario" id="horario" value="<?php echo $centroCivico["horario"]; ?>"> 
        <br>
        <label for="imagen">foto</label>
        <input type="text" name="foto" id="foto" value="<?php echo $centroCivico["foto"]; ?>">
        <br>
        <input type="submit" value="Editar" name="submit">
    </form>
</body>
</html>