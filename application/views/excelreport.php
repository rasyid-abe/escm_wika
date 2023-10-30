<?php

$html = "\xEF\xBB\xBF". $data;
$html = chr(239) . chr(187) . chr(191) . $html;
$tmpfile = tempnam(sys_get_temp_dir(), 'html');
file_put_contents($tmpfile, $html);

$objPHPExcel     = new \PHPExcel();
$excelHTMLReader = \PHPExcel_IOFactory::createReader('HTML');
$excelHTMLReader->loadIntoExisting($tmpfile, $objPHPExcel);
//BUAT GAMBAR
$objDrawing = new \PHPExcel_Worksheet_Drawing();
$objDrawing->setPath(FCPATH."/assets/img/logopdf.png");
if (isset($img_header_position) AND !empty($img_header_position)) {
  $img_header_position = $img_header_position;
}else{
  $img_header_position = 'B1';
}
$objDrawing->setCoordinates($img_header_position);
$objDrawing->setResizeProportional(true);
$objDrawing->setWidthAndHeight(600,300);
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

$sheet = $objPHPExcel->getActiveSheet ( 0 );

$style = array(
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        )
    );

$sheet->getDefaultStyle()->applyFromArray($style);

//range cell yang akan diberi border
if (isset($bordered_cells) and !empty($bordered_cells)) {

  $styleArray = array(
      'borders' => array(
          'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
          )
      ),
      'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        )
  );
  $sheet->getStyle( $bordered_cells )->applyFromArray($styleArray); 


}

//auto size cell
// foreach(range('A','Z') as $columnID)
// {
//     $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
// }


    // $styleArray = array(
      // 'fill' => [
      //   'type' => \PHPExcel_Style_Fill::FILL_SOLID,
      //   'color' => array('rgb' => '000000')
      // ],
      // 'font'  => [
      //   'bold'  => true,
      //   'color' => array('rgb' => 'FFFFFF'),
      // ],
      //BUAT BORDER
    //   'borders' => [
    //      'allborders' => [
    //          'style' => \PHPExcel_Style_Border::BORDER_THIN
    //      ]
    //   ]
    // );
    // $objPHPExcel->getActiveSheet()->getStyle('A1:C10')->applyFromArray($styleArray);

    // $styleArray = array(
    //   'fill' => [
    //     'type' => \PHPExcel_Style_Fill::FILL_SOLID,
    //     'color' => array('rgb' => '7d0707')
    //   ],
    //   'font'  => [
    //     'bold'  => true,
    //     'color' => array('rgb' => 'FFFFFF'),
    //   ],
    // );
    // $objPHPExcel->getActiveSheet()->getStyle('A12:C12')->applyFromArray($styleArray);

$objPHPExcel->getActiveSheet()
    ->getStyle('A1:J100')
    ->getNumberFormat()
    ->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );

unlink($tmpfile);
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename='.$nameExcel);
header('Cache-Control: max-age=0');

// $objPHPExcel->getActiveSheet()->getDefaultColumnDimension()->setWidth(25);
foreach(range('A','Z') as $columnID) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
        ->setAutoSize(true);
}
$writer = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$writer->save('php://output');
exit;
        