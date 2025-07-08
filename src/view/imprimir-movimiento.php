<?php
$ruta = explode("/", $_GET['views']);
if (!isset($ruta[1]) || $ruta[1]=="") {
    header ("location:". BASE_URL. "movimientos");

}

$curl = curl_init(); //inicia la sesión cURL
    curl_setopt_array($curl, array(
        CURLOPT_URL => BASE_URL_SERVER."src/control/Movimiento.php?tipo=buscar_movimiento_id&sesion=".$_SESSION['sesion_id']."&token=".$_SESSION['sesion_token']."&data=".$ruta[1], //url a la que se conecta
        CURLOPT_RETURNTRANSFER => true, //devuelve el resultado como una cadena del tipo curl_exec
        CURLOPT_FOLLOWLOCATION => true, //sigue el encabezado que le envíe el servidor
        CURLOPT_ENCODING => "", // permite decodificar la respuesta y puede ser"identity", "deflate", y "gzip", si está vacío recibe todos los disponibles.
        CURLOPT_MAXREDIRS => 10, // Si usamos CURLOPT_FOLLOWLOCATION le dice el máximo de encabezados a seguir
        CURLOPT_TIMEOUT => 30, // Tiempo máximo para ejecutar
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, // usa la versión declarada
        CURLOPT_CUSTOMREQUEST => "GET", // el tipo de petición, puede ser PUT, POST, GET o Delete dependiendo del servicio
        CURLOPT_HTTPHEADER => array(
            "x-rapidapi-host: ".BASE_URL_SERVER,
            "x-rapidapi-key: XXXX"
        ), //configura las cabeceras enviadas al servicio
    )); //curl_setopt_array configura las opciones para una transferencia cURL

    $response = curl_exec($curl); // respuesta generada
    $err = curl_error($curl); // muestra errores en caso de existir

    curl_close($curl); // termina la sesión 

    if ($err) {
        echo "cURL Error #:" . $err; // mostramos el error
    } else {
       $respuesta = json_decode($response);
       // print_r($respuesta);
        $contenido_pdf = '';
        $contenido_pdf .= '
        <!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Papeleta de Rotación de Bienes</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 40px;
    }
    h2 {
      text-align: center;
      font-weight: bold;
    }
    .datos {
      margin-bottom: 20px;
    }
    .datos p {
      margin: 5px 0;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 40px;
    }
    table, th, td {
      border: 1px solid black;
    }
    th, td {
      padding: 8px;
      text-align: center;
    }
    .firmas {
      display: flex;
      justify-content: space-between;
      margin-top: 50px;
    }
    .firma {
      text-align: center;
    }
  </style>
</head>
<body>

  <h2>PAPELETA DE ROTACION DE BIENES</h2>

  <div class="datos">
    <p><strong>ENTIDAD:</strong> DIRECCION REGIONAL DE EDUCACION - AYACUCHO</p>
    <p><strong>AREA:</strong> OFICINA DE ADMINISTRACIÓN</p>
    <p><strong>ORIGEN:</strong> ' . $respuesta->amb_origen->codigo . ' - ' . $respuesta->amb_origen->detalle . '</p>
    <p><strong>DESTINO:</strong> ' . $respuesta->amb_destino->codigo . ' - ' . $respuesta->amb_destino->detalle . '</p>
    <p><strong>MOTIVO (*):</strong> ' . (isset($respuesta->movimiento->descripcion) ? $respuesta->movimiento->descripcion : '______________________________________') . '</p>
  </div>

  <table>
    <thead>
      <tr>
        <th>ITEM</th>
        <th>CODIGO PATRIMONIAL</th>
        <th>NOMBRE DEL BIEN</th>
        <th>MARCA</th>
        <th>COLOR</th>
        <th>MODELO</th>
        <th>ESTADO</th>
      </tr>
    </thead>
    <tbody>'
       
      
      
      if (isset($respuesta->detalle) && count($respuesta->detalle)> 0){
        $i = 1;
        foreach ($respuesta->detalle as $bien) {
          $contenido_pdf.="<tr>";
          $contenido_pdf.= '<td>' . $i . '</td>';
          $contenido_pdf.= '<td>' . $bien->cod_patrimonial . '</td>';
          $contenido_pdf.= '<td>' . $bien->denominacion . '</td>';
          $contenido_pdf.= '<td>' . $bien->marca . '</td>';
          $contenido_pdf.= '<td>' . $bien->color . '</td>';
          $contenido_pdf.= '<td>' . $bien->modelo . '</td>';
          $contenido_pdf.= '<td>' . $bien->estado_conservacion . '</td>';
          $contenido_pdf.= '</tr>';
          $item++;
        }
      } else {  
        $contenido_pdf.= '<tr><td colspan="7">No hay bienes registrados en este movimiento.</td></tr>';
      }
     
      
    </tbody>
  </table>

  ';

  
    $meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
    $fecha = date('d') . ' de ' . $meses[date('n')-1] . ' del ' . date('Y');
  
  <p style="text-align: right;">Ayacucho, <?php $contenido_pdf.= $fecha; ?></p>
  
   $contenido_pdf.= '
  

  <div class="firmas">
    <div class="firma">
      <p>------------------------------</p>
      <p>ENTREGUE CONFORME</p>
    </div>
    <div class="firma">
      <p>------------------------------</p>
      <p>RECIBI CONFORME</p>
    </div>
  </div>

</body>
</html> 
';




       
    
        require_once('./vendor/tecnickcom/tcpdf/tcpdf.php');
        $pdf = new TCPDF();

        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Catalino');
        $pdf->SetTitle('Reporte de movimientos');

        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        $pdf->SetFont('helvetica', '', 12);

        $pdf->AddPage();

        // output the HTML content
       $pdf->writeHTML($contenido_pdf, true, false, true, false, '');
       //Close and output PDF document
       $pdf->Output('example_006.pdf', 'I');

    }
    