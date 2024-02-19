<h1 class="nombre-pagina">Crear cuenta</h1>
<p class="descripcion-pagina">Completa el siguiente formulario para crear una cuenta</p>

<?php include_once __DIR__ . '/../templates/alertas.php' ?>

<form method="POST" class="formulario" action="/crear-cuenta">
   <div class="campo">
      <label for="nombre">Nombre</label>
      <input type="text" id="nombre" name="nombre" placeholder="Nombre"  value="<?php echo s($usuario->nombre) ?>">
   </div>

   <div class="campo">
      <label for="apellido">Apellido</label>
      <input type="text" id="apellido" name="apellido" placeholder="Apellido" value="<?php echo s($usuario->apellido) ?>">
   </div>

   <div class="campo">
      <label for="telefono">Telefono</label>
      <input type="tel" id="telefono" name="telefono" placeholder="Telefono" value="<?php echo s($usuario->telefono) ?>">
   </div>

   <div class="campo">
      <label for="email">Email</label>
      <input type="email" id="email" name="email" placeholder="Email" value="<?php echo s($usuario->email) ?>">
   </div>

   <div class="campo">
      <label for="password">Password</label>
      <input type="password" id="password" name="password" placeholder="***">
   </div>

   <input type="submit" class="boton" value="Crear cuenta">
</form>

<div class="acciones">
   <a href="/">Iniciar sesion</a>
   <a href="/olvide">Olvide mi contraseña</a>
</div>