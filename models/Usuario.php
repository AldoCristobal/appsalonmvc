<?php

namespace Model;

class Usuario extends ActiveRecord
{
   protected static $tabla = 'usuarios';
   protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'password', 'telefono', 'admin', 'confirmado', 'token'];

   public $id;
   public $nombre;
   public $apellido;
   public $email;
   public $password;
   public $telefono;
   public $admin;
   public $confirmado;
   public $token;

   public function __construct($args = [])
   {
      $this->id = $args['id'] ?? null;
      $this->nombre = $args['nombre'] ?? '';
      $this->apellido = $args['apellido'] ?? '';
      $this->email = $args['email'] ?? '';
      $this->password = $args['password'] ?? '';
      $this->telefono = $args['telefono'] ?? '';
      $this->admin = $args['admin'] ?? '0';
      $this->confirmado = $args['confirmado'] ?? '0';
      $this->token = $args['token'] ?? '';
   }

   public function validarNuevaCuenta()
   {
      if (!$this->nombre) {
         self::$alertas['error'][] = 'Nombre obligatorio';
      }

      if (!$this->apellido) {
         self::$alertas['error'][] = 'Apellido obligatorio';
      }

      if (!$this->email) {
         self::$alertas['error'][] = 'Email obligatorio';
      }

      if (!$this->telefono) {
         self::$alertas['error'][] = 'Telefono obligatorio';
      }

      if (!$this->password) {
         self::$alertas['error'][] = 'Password obligatorio';
      }

      if (strlen($this->password) < 6) {
         self::$alertas['error'][] = 'El password debe contener al menos 6 caracteres';
      }

      return self::$alertas;
   }

   public function validarLogin()
   {
      if (!$this->email) {
         self::$alertas['error'][] = 'Email obligatorio';
      }

      if (!$this->password) {
         self::$alertas['error'][] = 'Password obligatorio';
      }

      return self::$alertas;
   }

   public function validarEmail()
   {
      if (!$this->email) {
         self::$alertas['error'][] = 'Email obligatorio';
      }

      return self::$alertas;
   }

   public function validarPassword()
   {
      if (!$this->password) {
         self::$alertas['error'][] = 'Password obligatorio';
      }

      if (strlen($this->password) < 6) {
         self::$alertas['error'][] = 'El password debe contener al menos 6 caracteres';
      }

      return self::$alertas;
   }

   public function existeUsuario()
   {
      $query = "SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";

      $resultado = self::$db->query($query);

      if ($resultado->num_rows) {
         self::$alertas['error'][] = 'El correo ya fue registrado';
      }

      return $resultado;
   }

   public function hashPassword()
   {
      $this->password = password_hash($this->password, PASSWORD_BCRYPT);
   }

   public function crearToken()
   {
      $this->token = uniqid();
   }

   public function comprobarPasswordAndVerificado($password)
   {
      $resultado = password_verify($password, $this->password);

      if (!$resultado || !$this->confirmado) {
         self::$alertas['error'][] = 'Contraseña incorrecta o tu cuenta no ha sido confirmada';
      }else{
         return true;
      }
   }
}
