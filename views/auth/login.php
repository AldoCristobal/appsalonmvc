<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Inicia sesion con tus datos</p>

<?php include_once __DIR__ . '/../templates/alertas.php' ?>

<form class="formulario" method="POST" action="/">
   <div class="campo">
      <label for="email">Email</label>
      <input type="email" id="email" name="email" placeholder="Correo@correo.com">
   </div>

   <div class="campo">
      <label for="password">Contraseña</label>
      <input type="password" id="password" name="password" placeholder="****">
   </div>

   <input type="submit" class="boton" value="Iniciar sesion">
</form>

<div class="acciones">
   <a href="/olvide">Olvide mi contraseña</a>
   <a href="/crear-cuenta">¿Aun no tienes una cuenta? Crear una</a>
</div>