public function download()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Users');
        $mama = $this->universal_model->selectall('*', 'payroll_categroy');
        $styleArray = array(
            'borders' => array(
                'outline' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => array('argb' => \PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK),
                ),
            ),
        );
        foreach ($mama as  $i => $row) {
            $sheet->setCellValue('A' . $i, $row['dateadded']);
            $sheet->setCellValue('B' . $i, $row['name']);
        }
        $sheet->getStyle('A1:C1')->applyFromArray($styleArray);
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="users.xlsx"');
        header('Cache-Control: max-age=0');
        header('Expires: Fri, 11 Nov 2011 11:11:11 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');
        $writer->save('php://output');
    }