<h1 class="nombre-pagina">Recuperar contraseña</h1>
<p class="descripcion-pagina">Reestablece tu contraseña ingresando tu correo</p>

<?php include_once __DIR__ . '/../templates/alertas.php' ?>

<form class="formulario" action="/olvide" method="POST">
   <div class="campo">
      <label for="email">Email</label>
      <input type="email" id="email" name="email">
   </div>

   <input type="submit" class="boton" value="Enviar">
</form>

<div class="acciones">
   <a href="/crear-cuenta">¿Aun no tienes una cuenta? Crea una</a>
   <a href="/">Iniciar sesion</a>
</div>