<?php
session_start();

require_once("Config/conexion.php");
require_once("Controllers/UsuarioC.php");
require_once("Controllers/SolicitudC.php");
require_once("Controllers/ProductoC.php");
require_once("Controllers/CategoriaC.php");
require_once("Models/ProductoM.php");

$accion = $_GET['accion'] ?? 'index';

$acciones_publicas = ['login', 'autenticar', 'register', 'guardarU', 'redireccion'];

if (!in_array($accion, $acciones_publicas)) {
  if (!isset($_SESSION['usuario'])) {
    header("Location: index.php?accion=login");
    exit;
  }
}

if (isset($_SESSION['mensaje'])) {
  echo '<link rel="stylesheet" href="Assets/css/popup.css">
     <div class="modal active">
       <div class="modal-header">
         <div class="title">Mensaje</div>
         <a href="index.php?accion='.$_GET['accion'].'" class="close-button">&times;</a>
       </div>
       <div class="modal-body">
         <p>' . $_SESSION['mensaje'] . '</p>
       </div>
     </div>
     <div id="overlay" class="active"></div>';
  unset($_SESSION['mensaje']);
}

const ROL_TECNICO = 1;
const ROL_CLIENTE = 2;
const ROL_ADMIN = 3;

switch ($accion) {
 
  
//acciones publicas
  case 'login':
    $controller = new UsuarioC();
    $controller->login();
  break;

  case 'autenticar':
    $controller = new UsuarioC();
    $controller->autenticar();
  break;

  case 'register':
    $controller = new UsuarioC();
    $controller->crear();
  break;

  case 'guardarU':
    $controller = new UsuarioC();
    $controller->guardarU();
  break;

  case 'redireccion':
    if (isset($_SESSION['usuario']) && isset($_SESSION['rol'])) {
      if ($_SESSION['rol'] == ROL_CLIENTE) {
        include("./Views/Usuario/Cliente/ClienteP.php");
      } elseif ($_SESSION['rol'] == ROL_TECNICO) {
        include("./Views/Usuario/Tecnico/TecnicoP.php");
      } elseif ($_SESSION['rol'] == ROL_ADMIN) {
        include("./Views/Usuario/Admin/AdminP.php");
      } else {
        echo "<h1>Error: Rol no reconocido.</h1>";
        echo "<p><a href='index.php?accion=logout'>Cerrar Sesión</a></p>";
      }
    } else {
      header("Location: index.php?accion=login");
      exit();
    }
  break;

//acciones para todos los roles
  case 'editarU':
    $controller = new UsuarioC();
    $controller->editarU();
  break;

  case 'actualizarU':
    $controller = new UsuarioC();
    $controller->actualizarU();
  break;

  case 'eliminarU':
    $controller = new UsuarioC();
    $controller->borrar();
  break;

  case 'logout':
    $controller = new UsuarioC();
    $controller->logout();
  break;

  case 'editarSF':
    $controller = new SolicitudC();
    $controller->editarSF();
  break;
//acciones para el rol cliente
    
  //acciones para producto
  
  case 'guardarP':
    $controller = new ProductoC();
    $controller->guardarP();
  break;

  case 'borrarP':
    $controller = new ProductoC();
    $controller->borrarP();
  break;

  case 'editarP':
    $controller = new ProductoC();
    $controller->editarP();
  break;

  case 'actualizarP':
   $controller = new ProductoC();
   $controller->actualizarP();
  break;

  case 'listarP':
    $controller = new ProductoC();
    $controller->listarP();
  break;
 
  case 'formularioP':
    $controller = new ProductoC();
    $controller->formularioP();
  break;

  //acciones para solicitudes

  case 'formularioS':
    $controller = new SolicitudC();
    $controller->formularioS();
  break;

  case 'guardarS':
    $controller = new SolicitudC();
    $controller->guardarS();
  break;

  case 'borrarS':
    $controller = new SolicitudC();
    $controller->borrarS();
  break;

  case 'listarSLU':
    $controller = new SolicitudC();
    $controller->listarSLU();
  break;
   
//acciones para el rol tecnico

  //acciones para solicitudes

  case 'asignarS':
    $controller = new SolicitudC();
    $controller->asignarS();
  break;
  
  case 'listarSA':
    $controller = new SolicitudC();
    $controller->ListarSA();
    require_once("Views/Solicitudes/listadoSA.php");
  break;

  case 'listarTL':
    $controller = new SolicitudC();
    $controller->ListarTL();
    require_once("Views/Solicitudes/Tecnico/listadoTL.php");
  break;

  case 'EditarSF':
    $controller = new SolicitudC();
    $controller->EditarSF();
  break;
//acciones para el rol admin

  //acciones historial

  case 'mostrarHistorial':
    $controller = new HistorialController();
    $controller->mostrarHistorial();
  break;

  // acciones categoria

  case 'FormularioC':
    $controller = new CategoriaC();
    $controller->FormularioC();
    require_once("./Views/Usuario/Admin/Categoria/agregarC.php");
  break;

  case 'guardarC':
    $controller = new CategoriaC();
    $controller->guardarC();
  break;

  case 'listarC':
    $controller = new CategoriaC();
    $controller->listarC();
  break;

  case 'editarC':
    $controller = new CategoriaC();
    $controller->editarC();
  break;

  case 'actualizarC':
    $controller = new CategoriaC();
    $controller->actualizarC();
  break;

  case 'borrarC':
    $controller = new CategoriaC();
    $controller->borrarC();
  break;

  case 'mostrarChat':
    require_once("Controllers/ChatC.php");
    $controller = new ChatC();
    $controller->mostrarChat();
    break;

  case 'enviarMensaje':
    require_once("Controllers/ChatC.php");
    $controller = new ChatC();
    $controller->enviar();
    break;

  case 'listarMensajes':
    require_once("Controllers/ChatC.php");
    $controller = new ChatC();
    $controller->listarMensajes();
    break;
   
//accion default

  default:
    if (!isset($_SESSION['usuario'])) {
      header("Location: index.php?accion=login");
    } else {
      http_response_code(404);
      header("Location: Error.php");
    }
  exit();
}
?>