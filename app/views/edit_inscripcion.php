<?php
    $inscripcion = $data['inscripcion'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Editar Inscripcion</h1>
    <form action="" method="post">
        <label for="solitante">Solicitante</label>
        <input type="text" name="solicitante" id="solicitante" value="<?php echo $inscripcion["solicitante"]; ?>">
        <br>
        <label for="telefono">Telefono</label>
        <input type="text" name="telefono" id="telefono" value="<?php echo $inscripcion["telefono"]; ?>">
        <br>
        <label for="email">Email</label>
        <input type="text" name="email" id="email" value="<?php echo $inscripcion["email"]; ?>">
        <br>
        <label for="fecha-inscripcion">Fecha Inscripcion</label>
        <input type="text" name="fecha_inscripcion" id="fecha_inscripcion" value="<?php echo $inscripcion["fecha_inscripcion"]; ?>">
        <br>
        <label for="estado">Estado</label>
        <input type="text" name="estado" id="estado" value="<?php echo $inscripcion["estado"]; ?>">
        <br>
        <input type="hidden" name="actividad_id" value="<?php echo $inscripcion["actividad_id"]; ?>">
        <input type="submit" value="Editar" name="submit">        
    </form>
</body>
</html>