<?php

require_once APPPATH . 'vendor/autoload.php';

use Brick\Db\Bulk\BulkInserter;

//use Brick\Db\Bulk\BulkDeleter;

class Aot extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('universal_model');
    }

    function timetest($test_datacard, $from, $to) {
        $template = array(
            'table_open' => '<table class="table table-striped table-hover" id="employee_attendence_cardtest">',
            'thead_open' => '<thead>',
            'thead_close' => '</thead>',
            'heading_row_start' => '<tr>',
            'heading_row_end' => '</tr>',
            'heading_cell_start' => '<th>',
            'heading_cell_end' => '</th>',
            'tbody_open' => '<tbody>',
            'tbody_close' => '</tbody>',
            'row_start' => '<tr>',
            'row_end' => '</tr>',
            'cell_start' => '<td>',
            'cell_end' => '</td>',
            'row_alt_start' => '<tr>',
            'row_alt_end' => '</tr>',
            'cell_alt_start' => '<td>',
            'cell_alt_end' => '</td>',
            'table_close' => '</table>'
        );
        $this->table->set_template($template);
        // Main Colums
        $cellspacecellspan = array(
            'data' => '',
            // 'class' => 'info'
            // 'style' => "font-size: 15px; color: black; background-color: burlywood;"
            'colspan' => 2
        );

        $cellspacecell = array(
            'data' => '',
            'class' => 'info'
                // 'style' => "font-size: 15px; color: black; background-color: burlywood;"
                // 'colspan' => '100%'
        );
        $celloff = array(
            'data' => '<b>Total Offs</b>',
            'class' => ' info'
                // 'colspan' => '100%'
        );
        $cellsdaysworked = array(
            'data' => '<b>Days Worked</b>',
            'class' => ' info'
                // 'colspan' => '100%'
        );
        $celltotalhours = array(
            'data' => '<b>Total</b>',
            'class' => ' info'
                // 'colspan' => '100%'
        );
        $cellabsent = array(
            'data' => '<b>Days Absent</b>',
            'class' => ' info'
                // 'colspan' => '100%'
        );
        $celltotalworked = array(
            'data' => '<b>Tot Hrs</b>',
            'class' => ' info'
                // 'colspan' => '100%'
        );
        $cellmorningot = array(
            'data' => '<b>M 1.5</b>',
            'class' => ' info'
                // 'colspan' => '100%'
        );
        $cellot15 = array(
            'data' => '<b>OT 1.5</b>',
            'class' => ' info'
                // 'colspan' => '100%'
        );
        $cellot2o = array(
            'data' => '<b>OT 2.0</b>',
            'class' => ' info'
                // 'colspan' => '100%'
        );
        $cellshort = array(
            'data' => '<b>Short T</b>',
            'class' => ' info'
                // 'colspan' => '100%'
        );
        $cell = array(
            'data' => '<b>Total Offs</b>',
            'class' => ' info'
                // 'colspan' => '100%'
        );
        // Main Colums End
        $celln = array(
            'data' => '<strong>Working. Dept: <strong>',
            'colspan' => 2
        );
        $celln1 = array(
            'data' => '<strong>Branch Name:<strong>',
            'colspan' => 2
        );
        $cellshiftdef1 = array(
            'data' => '<b>Shifts Def</b>',
            'class' => 'highlight',
            'colspan' => 1
        );
        $cellshiftdef2 = array(
            'data' => '<b>' . $test_datacard[0]['id_shift_def'] . '</b>',
            'class' => 'highlight',
            'colspan' => 2
        );
        $cellshiftdef3 = array(
            'data' => $this->getshiftdetails($test_datacard[0]['id_shift_def'])['shiftype'],
            'class' => 'highlight',
            'colspan' => 1
        );
        $cellshiftdef4 = array(
            'data' => $this->getshiftdetails($test_datacard[0]['id_shift_def'])['shiftfrom'] . ' - ' . $this->getshiftdetails($test_datacard[0]['id_shift_def'])['shiftto'],
            'class' => 'highlight',
            'colspan' => 3
        );
        $this->table->add_row($celln, '<b>UNALLOCATED<b>', $celln1, '<font size="2" color="green">' . $this->getbranchnamebyserial($test_datacard[0]['serialnumber'])['branchname'] . '</font>', $cellshiftdef1, $cellshiftdef2, $cellshiftdef4);
        // $this->table->add_row('Run : ', date('Y-m-d'), 'At: ' . date('H:i:s'));
        // Sift Is Attached To Department Later Ref
        // $this->table->add_row($cellshiftdef1, $cellshiftdef2, $cellshiftdef3, $cellshiftdef4);
        // $this->table->add_row('Shifts Definitions : ', $test_datacard[0]['id_shift_def']);
        foreach ($test_datacard as $_cardtestgrandour) {
            $cell = array(
                'data' => '',
                'class' => 'highlight success',
                'colspan' => '100%'
            );
            // $cellemp = array(
            // 'data' => '<font size="3" color="red">Employee</font>',
            // // 'class' => 'highlight success',
            // 'colspan' => 2
            // );
            $cellempcode = array(
                'data' => 'PIN : ' . '<font size="3">' . $_cardtestgrandour['pin'] . '</font>',
                // 'class' => 'highlight success',
                'colspan' => 2
            );

            $cellempcodenuber = array(
                'data' => 'EMPCODE : ' . '<font size="3">' . $this->getemployeename($_cardtestgrandour['pin'])['employee_code'] . '</font>',
                // 'class' => 'highlight success',
                'colspan' => 3
            );
            $names = $this->getemployeename($_cardtestgrandour['pin'])['firstname'] . ' ' . $this->getemployeename($_cardtestgrandour['pin'])['lastname'];
            $cellempnames = array(
                'data' => '<font size="3">' . $names . '</font>',
                // 'class' => 'highlight success',
                'colspan' => 3
            );
            $this->table->add_row($cell);
            $this->table->add_row($cellempcodenuber, $cellempcode, $cellempnames);
            $this->table->add_row('<b>Day</b>', '<b>Date</b>', '<b>Week</b>', '<b>Off</b>', '<b>Shift</b>', '<b>Login</b>', '<b>Logout</b>', '<b>Normal T</b>', '<b>Tot Hrs</b>', '<b>mot15</b>', '<b>OT 1.5</b>', '<b>OT 2.0</b>', '<b>Lost T</b>', '<b>Mode</b>');
            $weekday = explode('~', $_cardtestgrandour['weekday']);
            $dateclock = explode('~', $_cardtestgrandour['dateclock']);
            $weekyear = explode('~', $_cardtestgrandour['weekyear']);
            $off = explode('~', $_cardtestgrandour['off']);
            $login = explode('~', $_cardtestgrandour['login']);
            $logout = explode('~', $_cardtestgrandour['logout']);
            $tothrs = explode('~', $_cardtestgrandour['tothrs']);
            $ot15 = explode('~', $_cardtestgrandour['ot15']);
            $mot15 = explode('~', $_cardtestgrandour['mot15']);
            $ot20 = explode('~', $_cardtestgrandour['ot20']);
            $lostt = explode('~', $_cardtestgrandour['lostt']);
            $manual = explode('~', $_cardtestgrandour['manual']);
            $leave = explode('~', $_cardtestgrandour['leavestatus']);
            $array_totaloffs = array();
            $array_totaldaysworked = array();
            $array_totaldaysabsent = array();
            $array_totalhrs = array();
            $array_totmorninot = array();
            $array_tot20 = array();
            $arrayot15 = array();
            $arraylost = array();
            $normaltime = explode('~', $_cardtestgrandour['normaltime']);
            $id_shift_def = $_cardtestgrandour['id_shift_def'];
//            print_array($login);
            foreach ($weekday as $key => $weekday_o) {
                // echo $manual[$key].'<br>';
                // Some Arithemetic
                $absent_state = $login[$key];
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
//                    $lostt[$key] = '';
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
                    $normaltimep = '';
                    $id_shift_def = '';
                    $absent_state = '';
                    $logout[$key] = '';
                    $tothrs[$key] = '';
                    $mot15[$key] = '';
                    $ot15[$key] = '';
                    $ot20[$key] = '';
                    $lostt[$key] = '';
                }
                //Wired Logic
                else if ($dateclock[$key] == date('Y-m-d', time()) && $lostt[$key] != "") {
                    $getmetheclock = $this->universal_model->selectzy(array('dateclocktime'), 'trans', 'pin', $_cardtestgrandour['pin'], 'dateclock', $dateclock[$key]);
                    $absent_state = array_shift($getmetheclock)['dateclocktime'];
                    $logout[$key] = '';
                    $lostt[$key] = '';
//                    print_array();
                } else if ($leave[$key] == 'XXX') {
                    $normaltime[$key] = '';
                    $id_shift_def = $_cardtestgrandour['id_shift_def'];
                }
//                $this->timeexpectedhrs($array_totalhrs, $_cardtestgrandour['normaltime'])
                $this->table->add_row($weekday_o, $dateclock[$key], $weekyear[$key], $off[$key], $id_shift_def, $absent_state, $logout[$key], $normaltime[$key], $tothrs[$key], $mot15[$key], $ot15[$key], $ot20[$key], $lostt[$key], $manual[$key]);
            }
            $this->table->add_row($cellspacecell, $cellspacecell, $cellspacecell, $celloff, $cellspacecell, $cellsdaysworked, $cellabsent, $celltotalhours, $celltotalworked, $cellmorningot, $cellot15, $cellot2o, $cellshort, $cellspacecell);
            $this->table->add_row('', '', '', count($array_totaloffs), '', count($array_totaldaysworked), count($array_totaldaysabsent), 1, $this->celltotalworked($array_totalhrs), $this->celltotalworked($array_totmorninot), $this->celltotalworked($arrayot15), $this->celltotalworked($array_tot20), $this->celltotalworked($arraylost));
        }
        return $this->table->generate();
    }

}
