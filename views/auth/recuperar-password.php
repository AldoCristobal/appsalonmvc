<h1 class="nombre-pagina">Recuperar contraseña</h1>
<p class="descripcion-pagina">Ingresa la nueva contraseña</p>

<?php include_once __DIR__ . '/../templates/alertas.php' ?>

<?php if ($error) return ?>
<form class="formulario" method="POST">
   <div class="campo">
      <label for="password">Password</label>
      <input type="password" id="password" name="password" placeholder="***">
   </div>

   <input type="submit" class="boton" value="Guardar">
</form>

<div class="acciones">
   <a href="/crear-cuenta">¿Aun no tienes una cuenta? Crea una</a>
   <a href="/">Iniciar sesion</a>
</div>