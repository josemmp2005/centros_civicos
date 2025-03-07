<?php
    $usuario = $data['usuario'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Editar Usuario</h1>
    <form action="" method="post">
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" id="nombre" value="<?php echo $usuario["nombre"]; ?>">
        <br>
        <label for="email">Email</label>
        <input type="text" name="email" id="email" value="<?php echo $usuario["email"]; ?>">
        <br>
        <label for="password">Password</label>
        <input type="text" name="password" id="password" value="<?php echo $usuario["password"]; ?>">
        <br>
        <input type="submit" value="Editar" name="submit">
    </form>
</body>
</html>