<link rel="icon" type="image/png" href="Assets/imagenes/logonueva.png">
<!-- Logo de la app -->

<?php
session_start();

//Llamada a todos los controladores

require_once("Config/conexion.php");
require_once("Controllers/UsuarioC.php");
require_once("Controllers/SolicitudC.php");
require_once("Controllers/ProductoC.php");
require_once("Controllers/CategoriaC.php");
require_once("Controllers/ReviewC.php");
require_once("Models/ProductoM.php");
require_once("Controllers/ChatC.php");
require_once("Controllers/NotificacionC.php");

//define la variable accion con lo que llegue por el metodo GET

$accion = $_GET['accion'] ?? 'index';

//define el array de acciones publicas (acciones para los usuarios no logueados/registrados)
//si un usuario no logueado intenta hacer otras acciones no va a poder

$acciones_publicas = ['login', 'autenticar', 'register', 'guardarU', 'redireccion', 'espera'];

// si la accion que el usuario quiere hacer no esta en el array de acciones publicas entonces entra en el if
//si la accion esta en el array entonces no entra al if y entra al switch

if (!in_array($accion, $acciones_publicas)) {

  //si el usuario no esta logueado entonces entra en el if
  //si esta logueado sale del if y entra al switch

  if (!isset($_SESSION['usuario'])) {

    //redirige al index pero ahora con una accion en el array de acciones publicas

    header("Location: index.php?accion=login");
    exit;
  }
}


//el switch funciona en base a la variable accion que definimos en la linea 21
//dependiendo el valor de la variable es un case diferente

switch ($accion) {


  //acciones publicas

    // si la accion es login entra al case

    case 'login':

      // crea una nueva instancia del objeto UsuarioC (controlador usuario)

      $controller = new UsuarioC();

      // mas especificamente la funcion login      

      $controller->login();
    break;

    //si la accion es autenticar entra al case

    case 'autenticar':

      //crea una nueva instancia del objeto UsuarioC

      $controller = new UsuarioC();

      //mas especificamente la funcion autenticar

      $controller->autenticar();
    break;

    //si la accion es registro entra al case

    case 'registro':
    
      //crea una nueva instancia del objeto UsuarioC

      $controller = new UsuarioC();

      //mas especificamente la funcion crear

      $controller->crear();
    break;

    //si la accion es guardarU entra al case
    case 'guardarU':
        //crea una nueva instancia del objeto UsuarioC
        $controller = new UsuarioC();
        //ejecuta la funcion guardarU para registrar el usuario
        $controller->guardarU();
    break;

    //si la accion es redireccion entra al case
    case 'redireccion':
        //verifica si existe usuario y rol en la sesion
        if (isset($_SESSION['usuario']) && isset($_SESSION['rol'])) {
            //redirige segun el rol del usuario
            if ($_SESSION['rol'] == 1) {
                include("./Views/Usuario/Cliente/ClienteP.php");
            } elseif ($_SESSION['rol'] == 2) {
                include("./Views/Usuario/Tecnico/TecnicoP.php");
            } elseif ($_SESSION['rol'] == 3) {
                header("Location:index.php?accion=panelA");
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

  //si la accion es editarU entra al case
  case 'editarU':
    //crea una nueva instancia del objeto UsuarioC
    $controller = new UsuarioC();
    //ejecuta la funcion editarU para mostrar formulario de edicion
    $controller->editarU();
  break;

  //si la accion es actualizarU entra al case
  case 'actualizarU':
    //crea una nueva instancia del objeto UsuarioC
    $controller = new UsuarioC();
    //ejecuta la funcion actualizarU para guardar cambios
    $controller->actualizarU();
  break;

  case 'eliminarU':
    $controller = new UsuarioC();
    $controller->borrar();
  break;

  //si la accion es logout entra al case
  case 'logout':
    //crea una nueva instancia del objeto UsuarioC
    $controller = new UsuarioC();
    //ejecuta la funcion logout para cerrar sesion
    $controller->logout();
  break;

  //si la accion es espera entra al case
  case 'espera':
    //crea una nueva instancia del objeto UsuarioC
    $controller = new UsuarioC();
    //ejecuta la funcion espera para mostrar pantalla de espera
    $controller->espera();
  break;

  //si la accion es editarSF entra al case 
  case 'editarSF':
    //crea una nueva instancia del objeto SolicitudC
    $controller = new SolicitudC();
    //ejecuta la funcion editarSF para editar solicitud
    $controller->editarSF();
  break;

  //si la accion es actualizarSF entra al case
  case 'actualizarSF':
    //crea una nueva instancia del objeto SolicitudC 
    $controller = new SolicitudC();
    //ejecuta la funcion actualizarSF para guardar cambios
    $controller->actualizarSF();
  break;

  //si la accion es listarSA entra al case
  case 'listarSA':
    //crea una nueva instancia del objeto SolicitudC
    $controller = new SolicitudC();
    //ejecuta la funcion listarSA para mostrar solicitudes activas
    $controller->listarSA();
  break;

  //si la accion es cancelarS entra al case
  case 'cancelarS':
    //crea una nueva instancia del objeto SolicitudC
    $controller = new SolicitudC();
    //ejecuta la funcion cancelarS para cancelar solicitud
    $controller->cancelarS();
  break;

  //si la accion es listarST entra al case
  case 'listarST':
    //crea una nueva instancia del objeto SolicitudC
    $controller = new SolicitudC();
    //ejecuta la funcion listarST para mostrar solicitudes terminadas
    $controller->listarST();
  break;

  //acciones para productos

  //si la accion es guardarP entra al case
  case 'guardarP':
    //crea una nueva instancia del objeto ProductoC
    $controller = new ProductoC();
    //ejecuta la funcion guardarP para registrar producto
    $controller->guardarP();
  break;

  //si la accion es borrarP entra al case
  case 'borrarP':
    //crea una nueva instancia del objeto ProductoC
    $controller = new ProductoC();
    //ejecuta la funcion borrarP para eliminar producto
    $controller->borrarP();
  break;

  //si la accion es editarP entra al case
  case 'editarP':
    //crea una nueva instancia del objeto ProductoC
    $controller = new ProductoC();
    //ejecuta la funcion editarP para mostrar formulario de edicion
    $controller->editarP();
  break;

  //si la accion es actualizarP entra al case
  case 'actualizarP':
    //crea una nueva instancia del objeto ProductoC
    $controller = new ProductoC();
    //ejecuta la funcion actualizarP para guardar cambios
    $controller->actualizarP();
  break;

  //si la accion es listarP entra al case
  case 'listarP':
    //crea una nueva instancia del objeto ProductoC
    $controller = new ProductoC();
    //ejecuta la funcion listarP para mostrar productos
    $controller->listarP();
  break;

  //si la accion es formularioP entra al case
  case 'formularioP':
    //ejecuta la funcion formularioP para mostrar formulario
    $controller->formularioP();
  break;

  //acciones para solicitudes urgentes

  //si la accion es urgenteP entra al case
  case 'urgenteP':
    //ejecuta la funcion urgentePF para mostrar formulario urgente
    $controller->urgentePF();
  break;

  //si la accion es urgenteGP entra al case
  case 'urgenteGP':
    //ejecuta la funcion urgenteGP para guardar solicitud urgente
    $controller->urgenteGP();
  break;

  //acciones para solicitudes normales

  //si la accion es formularioS entra al case
  case 'formularioS':
    //ejecuta la funcion formularioS para mostrar formulario
    $controller->formularioS();
  break;

  //si la accion es guardarS entra al case
  case 'guardarS':
    //ejecuta la funcion guardarS para registrar solicitud
    $controller->guardarS();
  break;
  
  //si la accion es guardarSU entra al case
  case 'guardarSU':
    //ejecuta la funcion guardarSU para registrar solicitud urgente
    $controller->guardarSU();
  break;

  //si la accion es borrarS entra al case
  case 'borrarS':
    //ejecuta la funcion borrarS para eliminar solicitud
    $controller->borrarS();
  break;

  //si la accion es listarSLU entra al case
  case 'listarSLU':
    //ejecuta la funcion listarSLU para mostrar solicitudes de usuario
    $controller->listarSLU();
  break;

  //acciones para reviews

  //si la accion es FormularioReview entra al case
  case 'FormularioReview':
    //ejecuta la funcion FormularioR para mostrar formulario
    $controller->FormularioR();
  break;

  //si la accion es AddReview entra al case
  case 'AddReview':
    //ejecuta la funcion AddReview para agregar review
    $controller->AddReview();
  break;

  //acciones para el rol tecnico

  //acciones para solicitudes
  case 'asignarS':
    $controller = new SolicitudC();
    $controller->asignarS();
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

  case 'PerfilTecnico':
    $controller = new UsuarioC();
    $controller->PerfilTecnico();
  break;

  //acciones para el rol admin

  case 'solicitud_historia':
    $controller = new HistoriaC();
    $controller->mostrarHistoria();
  break;

  case 'panelA':
    $PreviewUsuarios = new UsuarioC();
    $PreviewHistorial = new HistorialController();
    $usuarios = $PreviewUsuarios->PreviewU();
    $historial = $PreviewHistorial->PreviewH();
    include("Views/Usuario/Admin/Adminp.php");
  break;

  case 'listarU':
    $controller = new UsuarioC();
    $controller->listarU();
  break;

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

  // case de Chat

  case 'mostrarChat':
    //ejecuta la funcion mostrarChat para mostrar interfaz
    $controller->mostrarChat();
  break;

  //si la accion es abrirChat entra al case
  case 'abrirChat':
    //ejecuta la funcion abrirChat para iniciar conversacion
    $controller->abrirChat();
  break;

  //si la accion es enviarMensaje entra al case
  case 'enviarMensaje':
    //ejecuta la funcion enviar para mandar mensaje
    $controller->enviar();
  break;

  case 'listarMensajes':
    $controller = new ChatC();
    $controller->listarMensajes();
  break;

  case 'mostrarConversacion':
    $controller = new ChatC();
    $controller->mostrarConversacion();
  break;

  case 'registroChats':
    $controller = new ChatC();
    $controller->registroChats();
  break;

  case 'listarConversaciones':
    $controller = new ChatC();
    $controller->listarConversaciones();
  break;
  //si la accion es cargarMensajes entra al case
  case 'cargarMensajes':
    //ejecuta la funcion cargarMensajes para mostrar historial
    $controller->cargarMensajes();
  break;

  //si la accion es borrarConversacion entra al case
  case 'borrarConversacion':
    //ejecuta la funcion borrar para eliminar chat
    $controller->borrar();
  break;

  //si la accion es marcarNotificacionesLeidas entra al case
  case 'marcarNotificacionesLeidas':
    //retorna respuesta json de exito
    echo json_encode(['success' => true]);
  break;


  //accion default

  case 'panelA':
    // Esta acción debe redirigir a la vista del panel de administración
    if ($_SESSION['rol'] == 3) {
        // Asumiendo que hay una vista principal para el admin
        include("./Views/Usuario/Admin/PanelA.php"); 
    } else {
        header("Location: index.php?accion=redireccion");
    }
    break;


  //si no coincide con ninguna accion entra al default
  default:
    //si el usuario no esta logueado redirige al login
    if (!isset($_SESSION['usuario'])) {
        header("Location: index.php?accion=login");
    } else {
        //si esta logueado muestra error 404
        http_response_code(404);
        header("Location: Error.php");
    }
    exit();
}