<?php
session_start();
require_once('../model/admin-sesionModel.php');
require_once('../model/admin-movimientoModel.php');
require_once('../model/admin-ambienteModel.php');
require_once('../model/admin-bienModel.php');
require_once('../model/admin-institucionModel.php');
require_once('../model/admin-usuarioModel.php');
require_once('../model/adminModel.php');
$tipo = $_GET['tipo'];

//instanciar la clase categoria model
$objSesion = new SessionModel();
$objMovimiento = new MovimientoModel();
$objAmbiente = new AmbienteModel();
$objBien = new BienModel();
$objAdmin = new AdminModel();
$objInstitucion = new InstitucionModel();
$objUsuario = new UsuarioModel();

//variables de sesion
$id_sesion = $_REQUEST['sesion'];
$token = $_REQUEST['token'];

if ($tipo == "listar") {
    $arr_Respuesta = array('status' => false, 'msg' => 'Error_Sesion');
    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
        $id_ies = $_POST['ies'];
        //print_r($_POST);
        //repuesta
        $arr_Respuesta = array('status' => false, 'contenido' => '');
        $arr_Ambiente = $objAmbiente->buscarAmbienteByInstitucion($id_ies);
        $arr_contenido = [];
        if (!empty($arr_Ambiente)) {
            // recorremos el array para agregar las opciones de las categorias
            for ($i = 0; $i < count($arr_Ambiente); $i++) {
                // definimos el elemento como objeto
                $arr_contenido[$i] = (object) [];
                // agregamos solo la informacion que se desea enviar a la vista
                $arr_contenido[$i]->id = $arr_Ambiente[$i]->id;
                $arr_contenido[$i]->detalle = $arr_Ambiente[$i]->detalle;
            }
            $arr_Respuesta['status'] = true;
            $arr_Respuesta['contenido'] = $arr_contenido;
        }
    }
    echo json_encode($arr_Respuesta);
}
if ($tipo == "listar_movimientos_ordenados_tabla") {
    $arr_Respuesta = array('status' => false, 'msg' => 'Error_Sesion');
    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
        //print_r($_POST);
        $ies = $_POST['ies'];
        $pagina = $_POST['pagina'];
        $cantidad_mostrar = $_POST['cantidad_mostrar'];
        $busqueda_tabla_amb_origen = $_POST['busqueda_tabla_amb_origen'];
        $busqueda_tabla_amb_destino = $_POST['busqueda_tabla_amb_destino'];
        $busqueda_fecha_desde = $_POST['busqueda_fecha_desde'];
        $busqueda_fecha_hasta = $_POST['busqueda_fecha_hasta'];
        //repuesta
        $arr_Respuesta = array('status' => false, 'contenido' => '');
        $busqueda_filtro = $objMovimiento->buscarMovimiento_tabla_filtro($busqueda_tabla_amb_origen, $busqueda_tabla_amb_destino, $busqueda_fecha_desde, $busqueda_fecha_hasta, $ies);
        $arr_Ambiente = $objMovimiento->buscarMovimiento_tabla($pagina, $cantidad_mostrar, $busqueda_tabla_amb_origen, $busqueda_tabla_amb_destino, $busqueda_fecha_desde, $busqueda_fecha_hasta, $ies);
        $arr_Ambientes = $objAmbiente->buscarAmbienteByInstitucion($ies);
        $arr_Respuesta['ambientes'] = $arr_Ambientes;
        $arr_contenido = [];
        if (!empty($arr_Ambiente)) {
            // recorremos el array para agregar las opciones de las categorias
            for ($i = 0; $i < count($arr_Ambiente); $i++) {
                // definimos el elemento como objeto
                $arr_contenido[$i] = (object) [];
                $arr_Usuario = $objUsuario->buscarUsuarioById($arr_Ambiente[$i]->id_usuario_registro);
                $arr_Detalle_movimiento = $objMovimiento->buscarDetalle_MovimientoByMovimiento($arr_Ambiente[$i]->id);
                $arr_contenido_detalle_movimiento = [];
                if (!empty($arr_Detalle_movimiento)) {
                    for ($j = 0; $j < count($arr_Detalle_movimiento); $j++) {
                        $arr_bien = $objBien->buscarBienById($arr_Detalle_movimiento[$j]->id_bien);
                        $arr_contenido_detalle_movimiento[$j] = (object) [];
                        $arr_contenido_detalle_movimiento[$j]->cod_patrimonial = $arr_bien->cod_patrimonial;
                        $arr_contenido_detalle_movimiento[$j]->denominacion = $arr_bien->denominacion;
                    }
                }
                $arr_contenido[$i]->detalle_bienes = $arr_contenido_detalle_movimiento;
                // agregamos solo la informacion que se desea enviar a la vista
                $arr_contenido[$i]->id = $arr_Ambiente[$i]->id;
                $arr_contenido[$i]->ambiente_origen = $arr_Ambiente[$i]->id_ambiente_origen;
                $arr_contenido[$i]->ambiente_destino = $arr_Ambiente[$i]->id_ambiente_destino;
                $arr_contenido[$i]->usuario_registro = $arr_Usuario->nombres_apellidos;
                $arr_contenido[$i]->fecha_registro = $arr_Ambiente[$i]->fecha_registro;
                $arr_contenido[$i]->descripcion = $arr_Ambiente[$i]->descripcion;
                $opciones = '<button type="button" title="Ver" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target=".modal_ver' . $arr_Ambiente[$i]->id . '"><i class="fa fa-eye"></i></button>
                <a href="'.BASE_URL.'imprimir-movimiento/'.$arr_Ambiente[$i]->id.'"class="btn-info"><i class="fa fa-print"></i></a>';
                $arr_contenido[$i]->options = $opciones;
            }
            $arr_Respuesta['total'] = count($busqueda_filtro);
            $arr_Respuesta['status'] = true;
            $arr_Respuesta['contenido'] = $arr_contenido;
        }
    }
    echo json_encode($arr_Respuesta);
}
if ($tipo == "registrar") {
    $arr_Respuesta = array('status' => false, 'msg' => 'Error_Sesion');
    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
        //print_r($_POST);
        //repuesta
        if ($_POST) {
            $ambiente_origen = $_POST['ambiente_origen'];
            $ambiente_destino = $_POST['ambiente_destino'];
            $descripcion = $_POST['descripcion'];
            $institucion = $_POST['ies'];
            $bienes = json_decode($_POST['bienes']);

            if ($ambiente_origen != $ambiente_destino) {
                if ($ambiente_origen == "" || $ambiente_destino == "" || $descripcion == "" || $institucion == "" || count($bienes) < 1) {
                    //repuesta
                    $arr_Respuesta = array('status' => false, 'mensaje' => 'Error, campos vacíos');
                } else {
                    $arr_usuario = $objSesion->buscarSesionLoginById($id_sesion);
                    $id_usuario = $arr_usuario->id_usuario;

                    $id_movimiento = $objMovimiento->registrarMovimiento($ambiente_origen, $ambiente_destino, $id_usuario, $descripcion, $institucion);
                    if ($id_movimiento > 0) {
                        $contar_errores = 0;
                        foreach ($bienes as $key => $bien) {
                            // aqui registrar bienes
                            $id_bien = $bien->id;
                            $id_detalle_movimiento = $objMovimiento->registrarDetalleMovimiento($id_movimiento, $id_bien);
                            if ($id_detalle_movimiento > 0) {
                                // actulizar ambiente del bien
                                $respuesta_bien = $objBien->actualizarBien_Ambiente($id_bien, $ambiente_destino);
                                if (!$respuesta_bien) {
                                    $contar_errores++;
                                }
                            } else {
                                $contar_errores++;
                            }
                        }
                        if ($contar_errores > 0) {
                            $arr_Respuesta = array('status' => false, 'mensaje' => 'Error al registrar y/o actualizar bienes en el detalle de bienes');
                        } else {
                            $arr_Respuesta = array('status' => true, 'mensaje' => 'Registro Exitoso');
                        }
                    } else {
                        $arr_Respuesta = array('status' => false, 'mensaje' => 'Error al registrar movimiento');
                    }
                }
            } else {
                $arr_Respuesta = array('status' => false, 'mensaje' => 'Error, el ambiente de destino no puede ser el mismo al de origen');
            }
        }
    }
    echo json_encode($arr_Respuesta);
}
if ($tipo == "actualizar") {
    $arr_Respuesta = array('status' => false, 'msg' => 'Error_Sesion');
    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
        //print_r($_POST);
        //repuesta
        if ($_POST) {
            $id = $_POST['data'];
            $id_ies = $_POST['id_ies'];
            $codigo = $_POST['codigo'];
            $detalle = $_POST['detalle'];
            $otros_detalle = $_POST['otros_detalle'];

            if ($id == "" || $id_ies == "" || $codigo == "" || $detalle == "" || $otros_detalle == "") {
                //repuesta
                $arr_Respuesta = array('status' => false, 'mensaje' => 'Error, campos vacíos');
            } else {
                $arr_Ambiente = $objAmbiente->buscarAmbienteByCpdigoInstitucion($codigo, $id_ies);
                if ($arr_Ambiente) {
                    if ($arr_Ambiente->id == $id) {
                        $consulta = $objAmbiente->actualizarAmbiente($id, $id_ies, $id_ies, $codigo, $detalle, $otros_detalle);
                        if ($consulta) {
                            $arr_Respuesta = array('status' => true, 'mensaje' => 'Actualizado Correctamente');
                        } else {
                            $arr_Respuesta = array('status' => false, 'mensaje' => 'Error al actualizar registro');
                        }
                    } else {
                        $arr_Respuesta = array('status' => false, 'mensaje' => 'dni ya esta registrado');
                    }
                } else {
                    $consulta = $objAmbiente->actualizarAmbiente($id, $id_ies, $id_ies, $codigo, $detalle, $otros_detalle);
                    if ($consulta) {
                        $arr_Respuesta = array('status' => true, 'mensaje' => 'Actualizado Correctamente');
                    } else {
                        $arr_Respuesta = array('status' => false, 'mensaje' => 'Error al actualizar registro');
                    }
                }
            }
        }
    }
    echo json_encode($arr_Respuesta);
}
if ($tipo == "datos_registro") {
    $arr_Respuesta = array('status' => false, 'msg' => 'Error_Sesion');
    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
        //repuesta
        $arr_Instirucion = $objInstitucion->buscarInstitucionOrdenado();
        $arr_Respuesta['instituciones'] = $arr_Instirucion;
        $arr_Respuesta['status'] = true;
        $arr_Respuesta['msg'] = "Datos encontrados";
    }
    echo json_encode($arr_Respuesta);
}
if ($tipo== "buscar_movimiento_id") {
    $arr_Respuesta = array('status' => false, 'msg' => 'Error_Sesion');
   if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
    $id_movimiento = $_REQUEST['data'];
        $arrMovimiento = $objMovimiento->buscarMovimientoById($id_movimiento);
        $arrAmbOrigen = $objAmbiente->buscarAmbienteById($arrMovimiento->id_ambiente_origen);
        $arrAmbDestino = $objAmbiente->buscarAmbienteById($arrMovimiento->id_ambiente_destino);
        $arrUsuario = $objUsuario->buscarUsuarioById($arrMovimiento->id_usuario_registro);
        $arrIes= $objInstitucion->buscarInstitucionById($arrMovimiento->id_ies);

        $arrDetalle = $objMovimiento->buscarDetalle_MovimientoByMovimiento($id_movimiento);
        $arr_Respuesta['movimiento'] = $arrMovimiento;
        $array_bienes = array();
        foreach ($arrDetalle as $bien ){
            $id_bien = $bien->id_bien;
            $res_bien =$objBien->buscarBienById($id_bien);// biense segun la bd
            if ($res_bien) {
                array_push($array_bienes, $res_bien); // Uso de array_push para agregar el bien
            }
        }

        $arr_Respuesta['amb_origen'] = $arrAmbOrigen;
        $arr_Respuesta['amb_destino'] = $arrAmbDestino;
        $arr_Respuesta['datos_usuario'] = $arrUsuario;
        $arr_Respuesta['datos_ies'] = $arrIes;

        $arr_Respuesta['detalle'] = $arrDetalle;
        $arr_Respuesta['bienes'] = $array_bienes;

        $arr_Respuesta['status'] = true;
        $arr_Respuesta['msg'] = 'correcto';

    //echo $id_movimiento;
   }
   
   echo json_encode($arr_Respuesta);
}
if ($tipo == "listarMovimientos") {
    $arr_Respuesta = array('status' => false, 'msg' => 'Error_Sesion');
      if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {

        $arrMovimientos = $objMovimiento->ObtenerMovimientos();

        foreach ($arrMovimientos as &$movimiento) {
            // Obtener los objetos relacionados por ID
            $ambienteOrigen = $objAmbiente->buscarAmbienteById($movimiento->id_ambiente_origen);
            $ambienteDestino = $objAmbiente->buscarAmbienteById($movimiento->id_ambiente_destino);
            $usuario = $objUsuario->buscarUsuarioById($movimiento->id_usuario_registro);
            $institucion = $objInstitucion->buscarInstitucionById($movimiento->id_ies);

            // Asignar atributos "nombre" directamente al objeto del movimiento
            $movimiento->ambiente_origen_nombre = $ambienteOrigen->detalle;
            $movimiento->ambiente_destino_nombre = $ambienteDestino->detalle;
            $movimiento->usuario_nombre = $usuario->nombres_apellidos;
            $movimiento->institucion_nombre = $institucion->nombre;
        }

        // Preparar respuesta
        $arr_Respuesta['movimientos'] = $arrMovimientos;
        $arr_Respuesta['status'] = true;
        $arr_Respuesta['msg'] = 'Movimientos listados correctamente';

      }
    echo json_encode($arr_Respuesta);
}
