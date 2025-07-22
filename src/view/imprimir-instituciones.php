<?php
$ruta = explode("/", $_GET['views']);
if (!isset($ruta[1]) || $ruta[1]=="") {
    header("location:" . BASE_URL . "instituciones");
}

require_once('./vendor/tecnickcom/tcpdf/tcpdf.php');

class MYPDF extends TCPDF {
    public function Header() {
        $img1 = $_SERVER['DOCUMENT_ROOT'] . '/inventario7/src/view/pp/assets/images/drea.jpg';
        $img2 = $_SERVER['DOCUMENT_ROOT'] . '/inventario7/src/view/pp/assets/images/gobi.jpg';

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
        $this->Cell(0, 8, 'REPORTE INSTITUCIONES', 0, 1, 'C');
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
    CURLOPT_URL => BASE_URL_SERVER . "src/control/Institucion.php?tipo=listar&sesion=" . $_SESSION['sesion_id'] . "&token=" . $_SESSION['sesion_token'],
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
    $instituciones = $respuesta->contenido;

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
          <th>CODIGO MODULAR</th>
          <th>RUC</th>
          <th>NOMBRES</th>
        </tr>
      </thead>
      <tbody>';
        $i = 1;
        foreach ($instituciones as $institucion) {
            $contenido_pdf .= '<tr>';
            $contenido_pdf .= '<td>' . $i . '</td>';
            $contenido_pdf .= '<td>' . $institucion->id . '</td>';
            $contenido_pdf .= '<td>' . $institucion->codigoModular . '</td>';
            $contenido_pdf .= '<td>' . $institucion->ruc . '</td>';
            $contenido_pdf .= '<td>' . $institucion->nombre . '</td>';
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
    $pdf->SetTitle('instituciones');
    $pdf->SetMargins(PDF_MARGIN_LEFT, 55, PDF_MARGIN_RIGHT);
    $pdf->SetAutoPageBreak(true, 10);
    $pdf->SetFont('helvetica', '', 12);
    $pdf->AddPage();
    $pdf->writeHTML($contenido_pdf, true, false, true, false, '');
    $pdf->Output('reporte-Instituciones.pdf', 'I');
    exit;
}

}else{

    //para imprimir por filtro de busqueda o por fila especifica.
}