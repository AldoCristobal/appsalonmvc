<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email{
   public $nombre;
   public $email;
   public $token;

   public function __construct($nombre, $email, $token) {
      $this->nombre = $nombre;
      $this->email = $email;
      $this->token = $token;
   }

   public function enviarConfirmacion() {
      $mail = new PHPMailer();

      $mail->isSMTP();
      $mail->Host = $_ENV['EMAIL_HOST'];
      $mail->SMTPAuth = true;
      $mail->Port = $_ENV['EMAIL_PORT'];
      $mail->Username = $_ENV['EMAIL_USER']; // password = ppch unwv emtk tlqf
      $mail->Password = $_ENV['EMAIL_PASS'];
      $mail->SMTPSecure = 'tls';

      $mail->setFrom('correo@appsalon.com');
      $mail->addAddress('crataldo@gmail.com', 'AppSalon.com');
      $mail->Subject = 'Confirma tu cuenta';

      $mail->isHTML(true);
      $mail->CharSet = 'UTF-8';

      $contenido = "<html>";
      $contenido .= "<p><strong>Hola " . $this->nombre . "</strong> Has creado tu cuenta en App Salon, confirma tu cuenta dando click en el siguiten enlace</p>";
      $contenido .= "<p>Presiona aqui: <a href='" . $_ENV['APP_URL'] . "/confirmar-cuenta?token=". $this->token ."'>Confirmar cuenta</a></p>";
      $contenido .= "<p>Si tu no creaste esta cuenta puedes ignorar el mensaje</p>";
      $contenido .= "</html>";
      $mail->Body = $contenido;

      $mail->send();
   }

   public function enviarInstrucciones() {
      $mail = new PHPMailer();

      $mail->isSMTP();
      $mail->Host = $_ENV['EMAIL_HOST'];
      $mail->SMTPAuth = true;
      $mail->Port = $_ENV['EMAIL_PORT'];
      $mail->Username = $_ENV['EMAIL_USER']; // password = ppch unwv emtk tlqf
      $mail->Password = $_ENV['EMAIL_PASS'];
      $mail->SMTPSecure = 'tls';

      $mail->setFrom('correo@appsalon.com');
      $mail->addAddress('crataldo@gmail.com', 'AppSalon.com');
      $mail->Subject = 'Reestablecer contraseña';

      $mail->isHTML(true);
      $mail->CharSet = 'UTF-8';

      $contenido = "<html>";
      $contenido .= "<p><strong>Hola " . $this->nombre . "</strong> Has solicitado reestablece tu contraseña, da click en el siguinete enlace para continuar</p>";
      $contenido .= "<p>Presiona aqui: <a href='" . $_ENV['APP_URL'] . "/recuperar?token=". $this->token ."'>Reestablecer contraseña</a></p>";
      $contenido .= "<p>Si tu no solicitaste esta accion ignora el mensaje</p>";
      $contenido .= "</html>";
      $mail->Body = $contenido;

      $mail->send();
   }
}