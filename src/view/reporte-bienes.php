<?php

require './vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$spreadsheet->getProperties()
    ->setCreator("yp")
    ->setLastModifiedBy("yo")
    ->setTitle("yo")
    ->setDescription("yo");

$activeWorksheet = $spreadsheet->getActiveSheet();
$activeWorksheet->setTitle("hoja 1");

//for ($i = 1; $i <= 10; $i++) {
 //   $activeWorksheet->setCellValue('A' . $i, $i . '');
//}



for ($i = 1; $i <= 12; $i++) {
    $activeWorksheet->setCellValue('A' . $i, 1);
    $activeWorksheet->setCellValue('B' . $i, 'x');
    $activeWorksheet->setCellValue('C' . $i, $i);
    $activeWorksheet->setCellValue('D' . $i, '=');
    $activeWorksheet->setCellValue('E' . $i, 1 * $i);
}

// Escribir del 1 al 10 en A1, B1, ..., J1 (horizontal)
/*for ($i = 1; $i <= 30; $i++) {
    $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($i);
    $activeWorksheet->setCellValue($col . '1', $i . '');
}*/

// Estos headers fuerzan la descarga
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="hello world.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;



