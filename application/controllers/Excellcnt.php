<?php
defined('BASEPATH') or exit('No direct script access allowed');
// https://github.com/PHPOffice/PHPExcel/issues/1029
// https://www.htmlgoodies.com/beyond/exploring-phpspreadsheets-formatting-capabilities.html
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style;

use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Excellcnt extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('universal_model');
    }
    public function index()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Hello World !');
        $writer = new Xlsx($spreadsheet);
        $filename = 'name-of-the-generated-file.xlsx';
        $writer->save($filename);
    }
    public function testingground()
    {
        $colors = array(
            '2' => '00FF00',
            '3' => 'FFA500',
            '5' => '8B0000'
        );

        $webstats = array(
            array(
                "Domain" => "robgravelle.com",
                "Status" => "200 OK",
                "Speed" => 0.57,
                "Last Backup" => "2017-10-27",
                "SSL Certificate?" => "No"
            ),
            array(
                "Domain" => "buysci-fi.com",
                "Status" => "301 redirect detected",
                "Speed" => 1.08,
                "Last Backup" => "2017-10-27",
                "SSL Certificate?" => "Yes"
            ),
            array(
                "Domain" => "captains-blog.com",
                "Status" => "500 Server Error!",
                "Speed" => 0.52,
                "Last Backup" => "2017-09-27",
                "SSL Certificate?" => "Yes"
            )
        );

        // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();
        $activeSheet = $spreadsheet->getActiveSheet();
        $activeSheet->setTitle('Website Stats Page');
        // $activeSheet->getParent()->getDefaultStyle()->getFont()->setName('Times New Roman');
        $activeSheet->setCellValue('A1', 'Website Stats Page');
        $activeSheet->getStyle("A1")->getFont()->setSize(16);

        //output headers
        $activeSheet->fromArray(array_keys($webstats[0]), NULL, 'A3');
        $activeSheet->getStyle('A3:E3')->applyFromArray(
            array(
                'fill' => array(
                    'type' => Fill::FILL_SOLID,
                    'color' => array('rgb' => 'E5E4E2')
                ),
                'font'  => array(
                    'bold'  =>  true
                )
            )
        );
        foreach ($webstats as $key => $domain) {
            $row = (int) $key + 5;
            $activeSheet->setCellValue('B' . $row, $domain['Domain']);
            $activeSheet->getCell('B' . $row)
                ->getHyperlink()
                ->setUrl('http://www.' . $domain['Domain'])
                ->setTooltip('Click here to visit site');
            $activeSheet->setCellValue('B' . $row, $domain['Status']);
            $activeSheet->getStyle('B' . $row)->applyFromArray(
                array(
                    'fill' => array(
                        'type' => Fill::FILL_SOLID,
                        'color' => array('rgb' => $colors[$domain['Status'][0]])
                    ),
                    'font'  => array(
                        'color' =>   array('rgb' => 'FFFFFF')
                    )
                )
            );

            $activeSheet->setCellValue('C' . $row, $domain['Speed']);
            $activeSheet->setCellValue('D' . $row, $domain['Last Backup']);
            $activeSheet->setCellValue('E' . $row, $domain['SSL Certificate?']);
        }

        foreach (range('B', 'E') as $col) {
            $activeSheet->getColumnDimension($col)->setAutoSize(true);
        }

        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => Border::BORDER_MEDIUM,
                    'color' => array('argb' => '000000'),
                ),
            ),
        );
        $styleArrayn = array(
            'borders' => array(
                'outline' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    'color' => array('argb' => \PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK),
                ),
            ),
        );
        // $activeSheet->getStyle('A3:E' . $row)->applyFromArray($styleArray);
        $activeSheet->getStyle('A3:E3')->applyFromArray($styleArrayn);
        // Redirect output to a client's web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="webstats.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }
    public function loardcarddata_tm()
    {
        $_POST['branch_start'] = "5831903080005$ ABBY OTUNDO ODUORI@ADAM LUTTA MULAMA@AMON KIMELI BETT@BRIAN KIPRONO KETER@DONALD OCHIENG OWINO@ESTHER MWIKALI MUSYIMI@HELLEN KEMUMA MOGOI@JANET WAIRIMU KAMAU@JOSEPH OGUR OTIENO@LEONARD MBITHI MUTHINI@WILSON KIPKOECH NG'ETICH$33108322@31798870@27761669@33302767@32352369@21137089@34017122@22306310@32758106@11861582@22875924";
        $_POST['date_maxncardx'] = "2019-10-15";
        $_POST['date_mincardx'] = "2019-10-01";
        $_POST['employeenumbermaxx'] = "WILSON KIPKOECH NG'ETICH|22875924";
        $_POST['employeenumberminx'] = "ABBY OTUNDO ODUORI|33108322";
        $id_payrollcat =  $this->input->post('id_payrollcat');
        $branch_start = $this->input->post('branch_start');
        $date_maxncardx = $this->input->post('date_maxncardx');
        $date_mincardx = $this->input->post('date_mincardx');
        $employeenumberminx = $this->input->post('employeenumberminx');
        $employeenumbermaxx = $this->input->post('employeenumbermaxx');
        //
        $employeenumberminxarray = explode('|', $employeenumberminx);
        // //Process Two
        $employeenumbermaxxarray = explode('|', $employeenumbermaxx);
        $array_last_name = 0;
        if ($employeenumbermaxxarray[0] != '') {
            $array_last_name = $employeenumbermaxxarray[0][0];
        }
        // //Codes
        //START Summery Details
        $showsummeryid = $this->input->post('showsummeryid');
        if ($showsummeryid == null) {
            $summery_id = 1;
        } else {
            $summery_id = 0;
        }
        //END Summery Details
        $branchcode = explode('$', $branch_start);
        //New Modification
        $brancharray = $this->universal_model->selectz(array('branchname'), 'util_branch_reader', 'readerserial', $branchcode[0]);
        $branchname = array_shift($brancharray)['branchname'];
        //New Modifications
        $gettimetrans = $this->universal_model->attendence_cardnewtrans($branchname, $date_mincardx, $date_maxncardx, $employeenumberminxarray[0][0], $array_last_name, $employeenumberminxarray[1], $id_payrollcat);
        // print_array($gettimetrans);
        if (empty($gettimetrans)) {
            $json_return = array(
                'report' => "No Queries Found For These Users in Range " . $date_mincardx . ' to ' . $date_maxncardx,
                'status' => 0,
            );
            echo json_encode($json_return);
        } else {
            $output = array_reduce($gettimetrans, function (array $carry, array $item) {
                $city = $item['pin'];
                if (array_key_exists($city, $carry)) {
                    $carry[$city]['weekday'] .= '~' . $item['weekday'];
                    $carry[$city]['weekyear'] .= '~' . $item['weekyear'];
                    $carry[$city]['login'] .= '~' . $item['login'];
                    $carry[$city]['logout'] .= '~' . $item['logout'];
                    $carry[$city]['dateclock'] .= '~' . $item['dateclock'];
                    $carry[$city]['tothrs'] .= '~' . $item['tothrs'];
                    $carry[$city]['ot15'] .= '~' . $item['ot15'];
                    $carry[$city]['mot15'] .= '~' . $item['mot15'];
                    $carry[$city]['lostt'] .= '~' . $item['lostt'];
                    $carry[$city]['ot20'] .= '~' . $item['ot20'];
                    $carry[$city]['manual'] .= '~' . $item['manual'];
                    $carry[$city]['off'] .= '~' . $item['off'];
                    $carry[$city]['normaltime'] .= '~' . $item['normaltime'];
                    //                    $carry[$city]['id_shift_def'] .= '~' . $item['id_shift_def'];
                    $carry[$city]['leavestatus'] .= '~' . $item['leavestatus'];
                    // CreatedArrays Virtual
                } else {
                    // print_array($item);
                    $carry[$city] = $item;
                    // CreatedArrays Virtual
                }
                return $carry;
            }, array());
            $report_array = array_values($output);
            $lineheader = array(
                'Working. Dept : UNALLOCATED' => 'UNALLOCATED',
                'Shifts Def : ' . $report_array[0]['id_shift_def'] => $report_array[0]['id_shift_def'],
                'Branch Name : ' . $this->getbranchnamebyserial($report_array[0]['serialnumber'])['branchname'] => $this->getbranchnamebyserial($report_array[0]['serialnumber'])['branchname'],
                'Shift Range : ' . $this->getshiftdetails($report_array[0]['id_shift_def'])['shiftfrom'] . ' - ' . $this->getshiftdetails($report_array[0]['id_shift_def'])['shiftto'] => $this->getshiftdetails($report_array[0]['id_shift_def'])['shiftfrom'] . ' - ' . $this->getshiftdetails($report_array[0]['id_shift_def'])['shiftto']
            );
            $endleter = columnLetter(11);
            $startleter = columnLetter(1);
            $spreadsheet = new Spreadsheet();
            $activeSheet = $spreadsheet->getActiveSheet();
            $activeSheet->fromArray(array_keys($lineheader), NULL, 'A3');
            $endletercap = $endleter . '11';
            $activeSheet->getStyle('A1:' . $endletercap)->applyFromArray(
                array(
                    'fill' => array(
                        'type' => Fill::FILL_SOLID,
                        'color' => array('rgb' => 'E5E4E2')
                    ),
                    'font'  => array(
                        'bold'  =>  true
                    )
                )
            );

            foreach ($report_array as $key => $valuesen) {
                // $row = (int) $key + 3;
                // $colum_num = $key + 1;
                $weekday = explode('~', $valuesen['weekday']);
                $dateclock = explode('~', $valuesen['dateclock']);
                $weekyear = explode('~', $valuesen['weekyear']);
                $off = explode('~', $valuesen['off']);
                $login = explode('~', $valuesen['login']);
                $logout = explode('~', $valuesen['logout']);
                $tothrs = explode('~', $valuesen['tothrs']);
                $ot15 = explode('~', $valuesen['ot15']);
                $mot15 = explode('~', $valuesen['mot15']);
                $ot20 = explode('~', $valuesen['ot20']);
                $lostt = explode('~', $valuesen['lostt']);
                $manual = explode('~', $valuesen['manual']);
                $leave = explode('~', $valuesen['leavestatus']);
                $array_totaloffs = array();
                $array_totaldaysworked = array();
                $array_totaldaysabsent = array();
                $array_totalhrs = array();
                $array_totalstandhrs = array();
                $array_totmorninot = array();
                $array_tot20 = array();
                $arrayot15 = array();
                $arraylost = array();
                $normaltime = explode('~', $valuesen['normaltime']);
                $id_shift_def = $valuesen['id_shift_def'];
                foreach ($weekday as $key => $weekday_o) {
                    $absent_state = $login[$key];
                    $holidaycheck = converttodate($dateclock[$key], 'd-m');
                    $holidaystake = $this->universal_model->selectall_var('*', 'holidayconfig', 'date like "%' . $holidaycheck . '%"');
                    if ($off[$key] == 1 && $leave[$key] == 'XXX') {
                        array_push($array_totaloffs, 1);
                    }
                    // echo $login[$key];
                    if (decimalHours($login[$key]) > 0 && $leave[$key] == 'XXX') {
                        array_push($array_totaldaysworked, 1);
                    }
                    if ($mot15[$key] != '' && $mot15[$key] != null && $leave[$key] == 'XXX') {
                        array_push($array_totmorninot, $mot15[$key]);
                    }
                    if ($ot20[$key] != '' && $ot20[$key] != null && $leave[$key] == 'XXX') {
                        array_push($array_tot20, $ot20[$key]);
                    }
                    if ($ot15[$key] != '' && $ot15[$key] != null && $leave[$key] == 'XXX') {
                        array_push($arrayot15, $ot15[$key]);
                    }
                    if ($lostt[$key] != '' && $lostt[$key] != null && $leave[$key] == 'XXX') {
                        array_push($arraylost, $lostt[$key]);
                    }
                    if ($off[$key] != 'worked off' && $off[$key] != 1 && decimalHours($login[$key]) == '0.00' && $leave[$key] == 'XXX') {
                        array_push($array_totaldaysabsent, 1);
                        $absent_state = 'ABSENT';
                    }
                    if ($off[$key] != 1 && decimalHours($login[$key]) != '0.00' && $leave[$key] == 'XXX') {
                        array_push($array_totalhrs, $tothrs[$key]);
                    }
                    if (decimalHours($login[$key]) != '0.00' && ($logout[$key] == '' && $leave[$key] == 'XXX')) {
                        $logout[$key] = 'MISSING OUT';
                    }
                    if ($off[$key] == 1 && decimalHours($login[$key]) == '0.00' && $leave[$key] == 'XXX') {
                        $absent_state = 'WEEKLY OFF';
                    }
                    if ($absent_state != 'WEEKLY OFF' && $absent_state != 'ABSENT') {
                        $absent_state = date('H:i', strtotime($absent_state));
                    }
                    if ($logout[$key] != '') {
                        $logout[$key] = date('H:i', strtotime($logout[$key]));
                    }
                    // Some Changes
                    if ($leave[$key] != 'XXX') {
                        $off[$key] = neat_trim($this->getleavestate($leave[$key]), 6, '.');
                        $normaltime = '';
                        $id_shift_def = '';
                        $absent_state = '';
                        $logout[$key] = '';
                        $tothrs[$key] = '';
                        $mot15[$key] = '';
                        $ot15[$key] = '';
                        $ot20[$key] = '';
                        $lostt[$key] = '';
                        // $logout[$key], $normaltime, $tothrs[$key], $mot15[$key], $ot15[$key], $ot20[$key], $lostt[$key]
                    }
                    //Wired Logic
                    else if ($dateclock[$key] == date('Y-m-d', time()) && $lostt[$key] != "") {
                        $getmetheclock = $this->universal_model->selectzy(array('dateclocktime'), 'trans', 'pin', $_cardtestgrandour['pin'], 'dateclock', $dateclock[$key]);
                        $absent_state = array_shift($getmetheclock)['dateclocktime'];
                        $logout[$key] = '';
                        $lostt[$key] = '';
                        //                    print_array();
                    }
                    //Holidays
                    else if ($leave[$key] == 'XXX') {
                        $normaltime = $valuesen['normaltime'];
                        $id_shift_def = $valuesen['id_shift_def'];
                    }
                    $totalconvert = convertfromdectime($tothrs[$key], 2);
                    if ($totalconvert == "00:00" && $off[$key] != 1) {
                        $lostt[$key] = '08:00';
                    }
                    if (!empty($holidaystake)) {
                        $absent_state = limit_words($holidaystake[0]['holidayname'], 35);
                        $lostt[$key] = '';
                    }
                    $timeformat = convertfromdectime($tothrs[$key], 2);
                    // $this->table->add_row($weekday_o, $dateclock[$key], $this->getemployeename($_cardtestgrandour['pin'])['employee_code'], $names, $id_shift_def, $absent_state, $logout[$key], $normaltime, $timeformat, $lostt[$key], $manual[$key]);
                }
                // print_array($weekday);
            }
        }
    }
    public function getbranchnamebyserial($serialnumer)
    {
        // selectz($array_table_n, $table_n, $variable_1, $value_1)
        $whattoget = array(
            'branchname',
        );
        $branchnames = $this->universal_model->selectz($whattoget, 'util_branch_reader', 'readerserial', $serialnumer);
        return $branchnames[0];
    }
    public function getshiftdetails($shift_id)
    {
        // selectz($array_table_n, $table_n, $variable_1, $value_1)
        $whattoget = array(
            'shiftfrom',
            'shiftto',
            'shiftype',
        );
        $shiftdetails = $this->universal_model->selectz($whattoget, 'attendence_shiftdef', 'shiftmancode', $shift_id);
        if (empty($shiftdetails)) {
            $shiftdetails = array(
                'shiftfrom' => '08:00',
                'shiftto' => '17:00:00',
                'shiftype' => 'Normal Shift Defaulted',
            );
            return $shiftdetails;
        } else {
            return $shiftdetails[0];
        }
    }
    public function getemployeename($user_pin)
    {
        // selectz($array_table_n, $table_n, $variable_1, $value_1)
        $whattoget = array(
            'firstname',
            'lastname',
            'employee_code',
        );
        $usernames = $this->universal_model->selectz($whattoget, 'users', 'pin', $user_pin);
        return $usernames[0];
    }
    public function getleavestate($codeleave)
    {
        //        leaveconfig
        $leave = $this->universal_model->selectz('leavetype as shortdesc', 'leaveconfig', 'id', $codeleave)[0]['shortdesc'];
        //        $leave = $this->universal_model->selectz('shortdesc', 'att_timeatttimeoffs', 'type', $codeleave)[0]['shortdesc'];
        return $leave;
    }
}
