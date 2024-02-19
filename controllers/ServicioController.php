<?php

namespace Controllers;

use Model\Servicio;
use MVC\Router;

class ServicioController
{
   public static function index(Router $router)
   {
      if (!isset($_SESSION)) {
         session_start();
      }

      isAdmin();

      $servicios = Servicio::all();
      
      $router->render("/servicios/index", [
         'nombre' => $_SESSION['nombre'],
         'servicios' => $servicios
         
      ]);
   }

   public static function crear(Router $router)
   {
      if (!isset($_SESSION)) {
         session_start();
      }

      isAdmin();

      $servico = new Servicio();
      $alertas = [];

      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         $servico->sincronizar($_POST);
         $alertas = $servico->validar();

         if (empty($alertas)) {
            $servico->guardar();
            header('Location: /servicios');
         }
      }

      $router->render("/servicios/crear", [
         'nombre' => $_SESSION['nombre'],
         'servicio' => $servico,
         'alertas' => $alertas
      ]);
   }

   public static function actualizar(Router $router)
   {
      if (!isset($_SESSION)) {
         session_start();
      }

      isAdmin();

      if (!is_numeric($_GET['id'])) return;
      $servico = Servicio::find($_GET['id']);
      $alertas = [];
      
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         $servico->sincronizar($_POST);
         $alertas = $servico->validar();

         if (empty($alertas)) {
            $servico->guardar();
            header('Location: /servicios');
         }
      }

      $router->render("/servicios/actualizar", [
         'nombre' => $_SESSION['nombre'],
         'servicio' => $servico,
         'alertas' => $alertas
      ]);
   }

   public static function eliminar()
   {
      if (!isset($_SESSION)) {
         session_start();
      }

      isAdmin();
      
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         $id = $_POST['id'];
         $servico = Servicio::find($id);
         $servico->eliminar();
         
         header('Location: /servicios');
      }
   }
}
