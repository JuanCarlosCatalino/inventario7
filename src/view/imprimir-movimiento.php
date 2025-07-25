<?php
$ruta = explode("/", $_GET['views']);
if (!isset($ruta[1]) || $ruta[1]=="") {
    header("location:" . BASE_URL . "movimientos");
}


require_once('./vendor/tecnickcom/tcpdf/tcpdf.php');

class MYPDF extends TCPDF {
    public function Header() {
        $img1 = $_SERVER['DOCUMENT_ROOT'] . './inventario7/src/view/pp/assets/images/drea.jpeg';
        $img2 = $_SERVER['DOCUMENT_ROOT'] . './inventario7/src/view/pp/assets/images/gobi.jpeg';
       // $imgIzquierda = _DIR_ . '/../../img/drea.jpg';
      //$imgDerecha   = _DIR_ . '/../../img/gobi.png';

        $this->Image($img1, 15, 8, 25, '', 'jpg');
        $this->Image($img2, 170, 8, 25, '', 'jpg');

        $this->SetY(10);
        $this->SetFont('helvetica', 'B', 10);
       $this->SetFont('helvetica', '', 10);
$this->Cell(0, 5, 'GOBIERNO REGIONAL DE AYACUCHO', 0, 1, 'C');

$this->SetFont('helvetica', 'B', 10);
$this->Cell(0, 5, 'DIRECCIÓN REGIONAL DE EDUCACIÓN DE AYACUCHO', 0, 1, 'C');

$this->SetFont('helvetica', '', 10);
$this->Cell(0, 5, 'DIRECCIÓN DE ADMINISTRACIÓN', 0, 1, 'C');


        $this->Ln(2);
        $this->Cell(0, 0, '', 'T', 1, 'C');

        $this->SetFont('helvetica', '', 9);
        $this->Cell(0, 5, 'ANEXO – 4 –', 0, 1, 'C');

        $this->SetFont('helvetica', 'B', 12);
        $this->Cell(0, 8, 'PAPELETA DE ROTACIÓN DE BIENES', 0, 1, 'C');
    }

    public function Footer() {
    // Dirección y teléfonos: debajo de "RECIBÍ CONFORME"
    $this->SetY(-40); // Aproximadamente debajo de firmas
    $this->SetFont('helvetica', '', 7);
    $this->SetTextColor(0, 0, 0);
    
    // Coloca el cursor en la parte derecha (no extremo)
    $this->SetX(120);
    $this->MultiCell(70, 4, "Jr. 28 de Julio N°38 - Huamanga\n(066) 31-2364 | (066) 31-3945 Anexo 50501", 0, 'L', false, 1);

    // URL centrada
    $this->SetY(-15); // Parte baja del PDF
    $this->SetX(0);
    $this->SetTextColor(0, 0, 255); // Azul
    $this->SetFont('helvetica', '', 7);
    $this->Cell(0, 5, 'www.dreaya.gob.pe', 0, 0, 'C', false, 'http://www.dreaya.gob.pe');
}

}


//imprimir toda los movimientos
if ($ruta[1] == "imprimirTodo") {

  $curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => BASE_URL_SERVER . "src/control/Movimiento.php?tipo=listarMovimientos&sesion=" . $_SESSION['sesion_id'] . "&token=" . $_SESSION['sesion_token'],
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
        "x-rapidapi-host: " . BASE_URL_SERVER,
        "x-rapidapi-key: XXXX"
    ),
));
$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);
if ($err) {
    echo "cURL Error #:" . $err;
} else {
    $respuesta = json_decode($response);

    $movimiento = $respuesta->movimientos;

    $contenido_pdf = '';

    $contenido_pdf .= '
    <style>
    body { font-family: Arial, sans-serif; margin: 40px; }
    .datos { margin-top: 20px; margin-bottom: 20px; }
    .datos p { margin: 5px 0; }
    table { width: 100%; border-collapse: collapse; margin-bottom: 40px; }
    .cuerpo th, .cuerpo td { padding: 8px; text-align: center; border:1px solid black;font-size:8px }
    </style>

    <div class="datos">
      <p><strong>ENTIDAD:</strong> DIRECCIÓN REGIONAL DE EDUCACIÓN - AYACUCHO</p>
      <p><strong>ÁREA:</strong> OFICINA DE ADMINISTRACIÓN</p>
      <p><strong>ORIGEN:</strong>Todos</p>
      <p><strong>DESTINO:</strong>Todos</p>
      <p><strong>MOTIVO (*):</strong> ______________________________________ </p>
    </div>

    <table class="cuerpo">
      <thead>
        <tr>
          <th>ITEM</th>
          <th>ID</th>
          <th>AMBIENTE ORIGEN</th>
          <th>AMBIENTE DESTINO</th>
          <th>USUARIO</th>
          <th>FECHA REGISTRO</th>
          <th>DESCRIPCION</th>
          <th>INSTITUCION</th>
        </tr>
      </thead>
      <tbody>';
        $i = 1;
        foreach ($movimiento as $movimientos) {
            $contenido_pdf .= '<tr>';
            $contenido_pdf .= '<td>' . $i . '</td>';
            $contenido_pdf .= '<td>' . $movimientos->id . '</td>';
            $contenido_pdf .= '<td>' . $movimientos->ambiente_origen_nombre . '</td>';
            $contenido_pdf .= '<td>' . $movimientos->ambiente_destino_nombre . '</td>';
            $contenido_pdf .= '<td>' . $movimientos->usuario_nombre . '</td>';
            $contenido_pdf .= '<td>' . $movimientos->fecha_registro . '</td>';
            $contenido_pdf .= '<td>' . $movimientos->descripcion . '</td>';
            $contenido_pdf .= '<td>' . $movimientos->institucion_nombre . '</td>';
            $contenido_pdf .= '</tr>';
            $i++;
        }


    $contenido_pdf .= '</tbody></table>';

    $meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
    $fecha = date('d') . ' de ' . $meses[date('n') - 1] . ' del ' . date('Y');

    $contenido_pdf .= '<p style="text-align: right;">Ayacucho, ' . $fecha . '</p>';

    $contenido_pdf .= '
    <table style="width:100%;border:none;">
      <tr>
        <td style="width: 50%; text-align: center;">
          ------------------------------<br>
          ENTREGUÉ CONFORME
        </td>
        <td style="width: 50%; text-align: center;">
          ------------------------------<br>
          RECIBÍ CONFORME
        </td>
      </tr>
    </table>
    ';


    // GENERA PDF
    $pdf = new MYPDF();
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Catalino');
    $pdf->SetTitle('Movimientos');
    $pdf->SetMargins(PDF_MARGIN_LEFT, 55, PDF_MARGIN_RIGHT);
    $pdf->SetAutoPageBreak(true, 10);
    $pdf->SetFont('helvetica', '', 12);
    $pdf->AddPage();
    $pdf->writeHTML($contenido_pdf, true, false, true, false, '');
    $pdf->Output('Movimientos.pdf', 'I');
    exit;
}

}else{

$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => BASE_URL_SERVER . "src/control/Movimiento.php?tipo=buscar_movimiento_id&sesion=" . $_SESSION['sesion_id'] . "&token=" . $_SESSION['sesion_token'] . "&data=" . $ruta[1],
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
        "x-rapidapi-host: " . BASE_URL_SERVER,
        "x-rapidapi-key: XXXX"
    ),
));
$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);
if ($err) {
    echo "cURL Error #:" . $err;
} else {
    $respuesta = json_decode($response);
    $contenido_pdf = '';

    $contenido_pdf .= '
    <style>
    body { font-family: Arial, sans-serif; margin: 40px; }
    .datos { margin-top: 20px; margin-bottom: 20px; }
    .datos p { margin: 5px 0; }
    table { width: 100%; border-collapse: collapse; margin-bottom: 40px; }
    table, th, td { border: 1px solid black; }
    th, td { padding: 8px; text-align: center; }
    </style>

    <div class="datos">
      <p><strong>ENTIDAD:</strong> DIRECCIÓN REGIONAL DE EDUCACIÓN - AYACUCHO</p>
      <p><strong>ÁREA:</strong> OFICINA DE ADMINISTRACIÓN</p>
      <p><strong>ORIGEN:</strong> ' . $respuesta->amb_origen->codigo . ' - ' . $respuesta->amb_origen->detalle . '</p>
      <p><strong>DESTINO:</strong> ' . $respuesta->amb_destino->codigo . ' - ' . $respuesta->amb_destino->detalle . '</p>
      <p><strong>MOTIVO (*):</strong> ' . (isset($respuesta->movimiento->descripcion) ? $respuesta->movimiento->descripcion : '______________________________________') . '</p>
    </div>

    <table>
      <thead>
        <tr>
          <th>ITEM</th>
          <th>CÓDIGO PATRIMONIAL</th>
          <th>NOMBRE DEL BIEN</th>
          <th>MARCA</th>
          <th>COLOR</th>
          <th>MODELO</th>
          <th>ESTADO</th>
        </tr>
      </thead>
      <tbody>';

    if (isset($respuesta->detalle) && count($respuesta->detalle) > 0) {
        $i = 1;
        foreach ($respuesta->bienes as $bien) {
            $contenido_pdf .= '<tr>';
            $contenido_pdf .= '<td>' . $i . '</td>';
            $contenido_pdf .= '<td>' . $bien->cod_patrimonial . '</td>';
            $contenido_pdf .= '<td>' . $bien->denominacion . '</td>';
            $contenido_pdf .= '<td>' . $bien->marca . '</td>';
            $contenido_pdf .= '<td>' . $bien->color . '</td>';
            $contenido_pdf .= '<td>' . $bien->modelo . '</td>';
            $contenido_pdf .= '<td>' . $bien->estado_conservacion . '</td>';
            $contenido_pdf .= '</tr>';
            $i++;
        }
    } else {
        $contenido_pdf .= '<tr><td colspan="7">No hay bienes registrados en este movimiento.</td></tr>';
    }

    $contenido_pdf .= '</tbody></table>';

    $meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
    $fecha = date('d') . ' de ' . $meses[date('n') - 1] . ' del ' . date('Y');

    $contenido_pdf .= '<p style="text-align: right;">Ayacucho, ' . $fecha . '</p>';

    // GENERA PDF
    $pdf = new MYPDF();
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Catalino');
    $pdf->SetTitle('Reporte de movimientos');
    $pdf->SetMargins(PDF_MARGIN_LEFT, 55, PDF_MARGIN_RIGHT);
    $pdf->SetAutoPageBreak(TRUE, 40);
    $pdf->SetFont('helvetica', '', 12);
    $pdf->AddPage();
    $pdf->writeHTML($contenido_pdf, true, false, true, false, '');

    // UBICA LAS FIRMAS AL FINAL
    $pdf->SetY(-90); // Ajusta esta línea para mover más arriba o más abajo

    $html_firmas = '
    <table style="width:100%;">
      <tr>
        <td style="width: 50%; text-align: center;">
          ------------------------------<br>
          ENTREGUÉ CONFORME
        </td>
        <td style="width: 50%; text-align: center;">
          ------------------------------<br>
          RECIBÍ CONFORME
        </td>
      </tr>
    </table>
    ';

    $pdf->writeHTML($html_firmas, true, false, true, false, '');

    $pdf->Output('papeleta_rotacion.pdf', 'I');
    exit;
}

}
    