<?php
    $actividad = $data['actividad'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Editar Actividad</h1>
    <form action="" method="post">
        <input type="hidden" name="centro_id" id="centro_id" value="<?php echo $actividad["centro_id"]; ?>">
        <br>
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" id="nombre" value="<?php echo $actividad["nombre"]; ?>">
        <br>
        <label for="descripcion">Descripcion</label>
        <input type="text" name="descripcion" id="descripcion" value="<?php echo $actividad["descripcion"]; ?>">
        <br>
        <label for="fecha_inicio">Fecha Inicio</label>
        <input type="text" name="fecha_inicio" id="fecha_inicio" value="<?php echo $actividad["fecha_inicio"]; ?>">
        <br>
        <label for="fecha_final">Fecha Final</label>
        <input type="text" name="fecha_final" id="fecha_final" value="<?php echo $actividad["fecha_final"]; ?>">
        <br>
        <label for="horario">Horario</label>
        <input type="text" name="horario" id="horario" value="<?php echo $actividad["horario"]; ?>">
        <br>
        <label for="plazas">Plazas</label>
        <input type="text" name="plazas" id="plazas" value="<?php echo $actividad["plazas"]; ?>">
        <br>
        <input type="submit" value="Editar" name="submit">
    </form>
    
</body>
</html>