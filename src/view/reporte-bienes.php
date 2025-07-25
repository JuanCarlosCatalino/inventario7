<?php

require './vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => BASE_URL_SERVER . "src/control/Bien.php?tipo=ObtenerTodosBienes&sesion=" . $_SESSION['sesion_id'] . "&token=" . $_SESSION['sesion_token'],
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

    $bien = $respuesta->bienes;


$spreadsheet = new Spreadsheet();
$spreadsheet->getProperties()
    ->setCreator("yo")
    ->setLastModifiedBy("yo")
    ->setTitle("yo")
    ->setDescription("yo");

$activeWorksheet = $spreadsheet->getActiveSheet();
$activeWorksheet->setTitle("hoja 1");


    $cabezeras = [
       'ID', 'ID-INGRESO BIENES', 'AMBIENTE', 'COD-PATRIMONIAL', 'DENOMINACION', 'MARCA', 'MODELO', 'TIPO', 'COLOR',
        'SERIE', 'DIMENSIONES', 'VALOR', 'SITUACION', 'ESTADO CONSERVACION', 'OBSERVACIONES',
        'FECHA-REGISTRO', 'USUARIO-REGISTRADO', 'ESTADO'
        ];

           // Asignar cabeceras en la fila 1
            foreach ($cabezeras as $i => $cabezera) {
                $columna = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($i + 1);
                $activeWorksheet->setCellValue($columna . '1', $cabezera);
            }

           // Llenar los datos
            $fila = 2;
            foreach ($bien as $bienes) {
                $atributos = [
                    $bienes->id,
                    $bienes->id_ingreso_bienes,
                    $bienes->nombreAmbiente,
                    $bienes->cod_patrimonial,
                    $bienes->denominacion ,
                    $bienes->marca,
                    $bienes->modelo,
                    $bienes->tipo,
                    $bienes->color,
                    $bienes->serie,
                    $bienes->dimensiones,
                    $bienes->valor,
                    $bienes->situacion,
                    $bienes->estado_conservacion,
                    $bienes->observaciones,
                    $bienes->fecha_registro,
                    $bienes->nombreUsuario,
                    $bienes->estado
                ];

                foreach ($atributos as $i => $valor) {
                    $columna = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($i + 1);
                    $activeWorksheet->setCellValue($columna . $fila, $valor);
                }

                $fila++;
            }

// Estos headers fuerzan la descarga
ob_clean();
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Generar Reporte.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;

}


?>