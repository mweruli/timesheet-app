<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Daily extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('universal_model');
    }

    public function index()
    {
        echo '<h1>DailyR Api ...</h1>';
    }

    public function loadabsentreport()
    {
        //        $_POST['branch_absent_daily'] = "5831903080005$ ABBY OTUNDO ODUORI@ADAM LUTTA MULAMA@AMON KIMELI BETT@BRIAN KIPRONO KETER@DONALD OCHIENG OWINO@ESTHER MWIKALI MUSYIMI@HELLEN KEMUMA MOGOI@JANET WAIRIMU KAMAU@JOSEPH OGUR OTIENO@LEONARD MBITHI MUTHINI@WILSON KIPKOECH NG'ETICH$33108322@31798870@27761669@33302767@32352369@21137089@34017122@22306310@32758106@11861582@22875924";
        //        $_POST['date_mincardx_absent'] = "2019-06-01";
        //        $_POST['date_maxncardx_absent'] = "2019-06-30";
        //        $_POST['id_showdetailed'] = "1";
        $id_payrollcat =  $this->input->post('id_payrollcat');
        $date_mincardx_absent = $this->input->post('date_mincardx_absent');
        $date_maxcardx_absent = $this->input->post('date_maxncardx_absent');
        $branch_absent_daily = $this->input->post('branch_absent_daily');
        $id_showdetailed = $this->input->post('id_showdetailed');
        $branchcode = explode('$', $branch_absent_daily);
        //plug start
        $brancharray = $this->universal_model->selectz(array('branchname'), 'util_branch_reader', 'readerserial', $branchcode[0]);
        $branchname = array_shift($brancharray)['branchname'];
        //plug end
        $absentdaily = $this->universal_model->daily_absent_call($branchname, $date_maxcardx_absent, $date_mincardx_absent, $id_payrollcat);

        if (empty($absentdaily)) {
            $json_return = array(
                'report' => "No Queries Found For These Users in Range " . $date_mincardx_absent,
                'status' => 0
            );
            echo json_encode($json_return);
        } else {
            $output = array_reduce($absentdaily, function (array $carry, array $item) {
                $city = $item['pin'];
                if (array_key_exists($city, $carry)) {
                    $holidaycheck = converttodate($item['dateclock'], 'd-m');
                    $holidaystake = $this->universal_model->selectall_var('*', 'holidayconfig', 'date like "%' . $holidaycheck . '%"');
                    if (empty($holidaystake)) {
                        $carry[$city]['lostt'] .= '~' . $item['lostt'];
                        $carry[$city]['weekday'] .= '~' . $item['weekday'];
                        $carry[$city]['weekyear'] .= '~' . $item['weekyear'];
                        $carry[$city]['dateclock'] .= '~' . $item['dateclock'];
                    }
                } else {
                    $carry[$city] = $item;
                }
                return $carry;
            }, array());
            if ($id_showdetailed == 1) {
                $data = $this->timetest_dailyabsent_detailed(array_values($output), $date_mincardx_absent, $date_maxcardx_absent);
            } else {
                $data = $this->timetest_dailyabsent(array_values($output), $date_mincardx_absent, $date_maxcardx_absent);
            }
            $json_return = array(
                'report' => "Range " . 'between ' . $date_mincardx_absent . ' ' . $date_maxcardx_absent,
                'status' => 1,
                'data' => $data
            );
            echo json_encode($json_return);
        }
    }

    public function loadlatereport()
    {
        //        $_POST['branch_lateness_daily'] = "AF4C174960145$11008933 Update Update@11386387 Upda…3611@25019038@11671016@30294611@23653968@20541643";
        //        $_POST['date_mincardx_lateness'] = "2019-06-01";
        //        $_POST['date_maxncardx_lateness'] = "2019-06-30";
        $date_mincardx_absent = $this->input->post('date_mincardx_lateness');
        $id_payrollcat =  $this->input->post('id_payrollcat');
        $date_maxcardx_absent = $this->input->post('date_maxncardx_lateness');
        $branch_absent_daily = $this->input->post('branch_lateness_daily');
        $id_showdetailed = $this->input->post('id_showdetailedlateness');
        $branchcode = explode('$', $branch_absent_daily);
        $brancharray = $this->universal_model->selectz(array('branchname'), 'util_branch_reader', 'readerserial', $branchcode[0]);
        $branchname = array_shift($brancharray)['branchname'];
        $gettimetrans = $this->universal_model->daily_late_call($branchname, $date_mincardx_absent, $date_maxcardx_absent, $id_payrollcat);
        if (empty($gettimetrans)) {
            $json_return = array(
                'report' => "No Queries Found For These Users in Range " . $date_mincardx_absent,
                'status' => 0
            );
            echo json_encode($json_return);
        } else {
            $output = array_reduce($gettimetrans, function (array $carry, array $item) {
                $city = $item['pin'];
                if (array_key_exists($city, $carry)) {
                    $carry[$city]['dateclock'] .= '~' . $item['dateclock'];
                    $carry[$city]['lostt'] .= '~' . $item['lostt'];
                    $carry[$city]['normaltime'] .= '~' . $item['normaltime'];
                    $carry[$city]['login'] .= '~' . $item['login'];
                    $carry[$city]['logout'] .= '~' . $item['logout'];
                    $carry[$city]['weekday'] .= '~' . $item['weekday'];
                    //                    $carry[$city]['id_shift_def'] .= '~' . $item['id_shift_def'];
                    $carry[$city]['tothrs'] .= '~' . $item['tothrs'];
                    $carry[$city]['ot15'] .= '~' . $item['ot15'];
                    $carry[$city]['mot15'] .= '~' . $item['mot15'];
                    $carry[$city]['ot20'] .= '~' . $item['ot20'];
                    // $carry[$city]['id_shift_def'] .= '~' . $item['id_shift_def'];
                    // CreatedArrays Virtual
                } else {
                    // print_array($item);
                    $carry[$city] = $item;
                    // CreatedArrays Virtual
                }
                return $carry;
            }, array());
            if ($id_showdetailed == 1) {
                $data = $this->timetest_latness_detailed(array_values($output), $date_mincardx_absent, $date_maxcardx_absent);
            } else {
                $data = $this->timetest_latenestabsent(array_values($output), $date_mincardx_absent, $date_maxcardx_absent);
            }
            $json_return = array(
                'report' => "Range " . 'between ' . $date_mincardx_absent . ' To ' . $date_maxcardx_absent,
                'status' => 1,
                'data' => $data
            );
            echo json_encode($json_return);
        }
    }


    public function loadovertimeport()
    {
        //        $_POST['branch_start_dailyott'] = "AF4C174960145$11008933 Update Update@11386387 Upda…3611@25019038@11671016@30294611@23653968@20541643";
        //        $_POST['date_mincardx_dott'] = "2019-06-01";
        //        $_POST['date_maxncardx_ot'] = "2019-06-30";
        $id_payrollcat =  $this->input->post('id_payrollcat');
        $date_mincardx_absent = $this->input->post('date_mincardx_dott');
        $date_maxcardx_absent = $this->input->post('date_maxncardx_ot');
        $branch_absent_daily = $this->input->post('branch_start_dailyott');
        $id_showdetailed = $this->input->post('id_showdetailedot');
        $branchcode = explode('$', $branch_absent_daily);
        $gettimetrans = $this->universal_model->daily_ot_call($branchcode[0], $date_mincardx_absent, $date_maxcardx_absent, $id_payrollcat);

        if (empty($gettimetrans)) {
            $json_return = array(
                'report' => "No Queries Found For These Users in Range " . $date_mincardx_absent,
                'status' => 0
            );
            echo json_encode($json_return);
        } else {
            $output = array_reduce($gettimetrans, function (array $carry, array $item) {
                $city = $item['pin'];
                if (array_key_exists($city, $carry)) {
                    $carry[$city]['dateclock'] .= '~' . $item['dateclock'];
                    $carry[$city]['lostt'] .= '~' . $item['lostt'];
                    $carry[$city]['normaltime'] .= '~' . $item['normaltime'];
                    $carry[$city]['login'] .= '~' . $item['login'];
                    $carry[$city]['logout'] .= '~' . $item['logout'];
                    $carry[$city]['weekday'] .= '~' . $item['weekday'];
                    //                    $carry[$city]['id_shift_def'] .= '~' . $item['id_shift_def'];
                    $carry[$city]['tothrs'] .= '~' . $item['tothrs'];
                    $carry[$city]['ot15'] .= '~' . $item['ot15'];
                    $carry[$city]['mot15'] .= '~' . $item['mot15'];
                    $carry[$city]['ot20'] .= '~' . $item['ot20'];
                    // $carry[$city]['id_shift_def'] .= '~' . $item['id_shift_def'];
                    // CreatedArrays Virtual
                } else {
                    // print_array($item);
                    $carry[$city] = $item;
                    // CreatedArrays Virtual
                }
                return $carry;
            }, array());
            if ($id_showdetailed == 1) {
                $data = $this->timetest_otreport_detailed(array_values($output), $date_mincardx_absent, $date_maxcardx_absent);
            } else {
                $data = $this->timetest_otreport(array_values($output), $date_mincardx_absent, $date_maxcardx_absent);
            }
            $json_return = array(
                'report' => "Range " . 'between ' . $date_mincardx_absent . ' and ' . $date_maxcardx_absent,
                'status' => 1,
                'data' => $data
            );
            echo json_encode($json_return);
        }
    }

    function timetest_latenestabsent($test_datacard, $from, $to)
    {
        //        print_array($test_datacard);
        $template = array(
            'table_open' => '<table class="table table-striped table-hover" id="employee_attendence_lateness">',
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
        $cell = array(
            'data' => '<b>Total Offs</b>',
            'class' => ' info'
            // 'colspan' => '100%'
        );
        // Main Colums End
        $printernames = $this->universal_model->selectz(array('firstname', 'lastname'), 'users', 'user_id', $this->session->userdata('logged_in')['user_id'])[0];
        $theoneheader = '<THEAD>
    <TR>
      <TH SCOPE=colgroup COLSPAN="100%"><font size="4">ASL TRADING ' . 'LATENESS REPORT SUMMERISED  FOR ' . converttodate($from, 'F jS, Y') . " TO " . converttodate($to, 'F jS, Y') . '</font></TH>
    </TR>
    <TR>
      <TH SCOPE=colgroup COLSPAN="5%">Printed On: <b>' . date("d/m/Y") . '</b></TH>
      <TH SCOPE=colgroup COLSPAN="15%" style="text-align:right;">SHIFT DEF:<b>' . $test_datacard[0]['id_shift_def'] . ' ' . $this->getshiftdetails($test_datacard[0]['id_shift_def'])['shiftfrom'] . ' - ' . $this->getshiftdetails($test_datacard[0]['id_shift_def'])['shiftto'] . '</b></TH>
    </TR>
    <TR>
      <TH SCOPE=colgroup COLSPAN="2%">Printed Time: <b>' . date("h:i:s") . '</b></TH>
      <TH SCOPE=colgroup COLSPAN="4%">' . 'BRANCH ' . $this->getbranchnamebyserial($test_datacard[0]['serialnumber'])['branchname'] . '</TH>
      <TH SCOPE=colgroup COLSPAN="1%" style="text-align:right;">Printed By: <b>' . $printernames['firstname'] . ' ' . $printernames['lastname'] . '</b></TH>
    </TR>
    <TR>
      <TH SCOPE=col COLSPAN=1>Emp No</TH>
      <TH SCOPE=col COLSPAN=1>PIN</TH>
      <TH SCOPE=col COLSPAN=1>NAMES</TH>
       <TH SCOPE=col COLSPAN=1></TH>
      <TH SCOPE=col COLSPAN=1>SHIFT</TH>
      <TH SCOPE=col COLSPAN=1></TH>
      <TH SCOPE=col COLSPAN=1>LATE HOURS</TH>
      <TH SCOPE=col COLSPAN=1>TOTAL LOST HOURS</TH>
    </TR>
  </THEAD>';
        $this->table->add_row($theoneheader);
        // Sift Is Attached To Department Later Ref
        // $this->table->add_row('Shifts Definitions : ', $test_datacard[0]['id_shift_def']);
        $totalhoourslost = 0;
        $cellspacecell = array(
            'data' => '',
            //            'class' => 'info'
        );
        foreach ($test_datacard as $_cardtestgrandour) {
            $cell = array(
                'data' => '',
                'class' => 'highlight success',
                'colspan' => '100%'
            );

            $names = $_cardtestgrandour['firstname'] . ' ' . $_cardtestgrandour['lastname'];
            $totalhoursarray = explode('~', $_cardtestgrandour['lostt']);
            $sumlost = array_sum($totalhoursarray);
            $totalhoourslost += $sumlost;
            $cell1 = array(
                'data' => $_cardtestgrandour['employee_code']
            );
            $cell3 = array(
                'data' => $_cardtestgrandour['id_shift_def']
            );
            $cell4 = array(
                'data' => $sumlost
            );
            $cell5 = array(
                'data' => $names
            );
            $cell6 = array(
                'data' => $_cardtestgrandour['pin']
            );
            $this->table->add_row($cell1, $cell6, $cell5, $cellspacecell, $cell3, $cellspacecell, $cell4, $cell4);
        }
        $cellspacecelln = array(
            'data' => 'TOTAL EMPLOYEES',
            'class' => 'info'
        );
        $cellspacecellm = array(
            'data' => 'TOTAL HOURS LOST',
            'class' => 'info'
        );
        $cellspacecellnp = array(
            'data' => count($test_datacard),
            //            'class' => 'info'
        );
        $this->table->add_row($cellspacecelln, $cellspacecellnp, $cellspacecell, $cellspacecell, $cellspacecell, $cellspacecellm, $totalhoourslost);
        return $this->table->generate();
    }

    function timetest_dailyabsent($test_datacard, $from, $to)
    {
        //        print_array($test_datacard);
        $template = array(
            'table_open' => '<table class="table table-striped table-hover" id="employee_absence_cardtest_d">',
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
        $cell = array(
            'data' => '<b>Total Offs</b>',
            'class' => ' info'
            // 'colspan' => '100%'
        );
        // Main Colums End
        $printernames = $this->universal_model->selectz(array('firstname', 'lastname'), 'users', 'user_id', $this->session->userdata('logged_in')['user_id'])[0];
        $theoneheader = '<THEAD>
    <TR>
      <TH SCOPE=colgroup COLSPAN="100%"><font size="4">ASL TRADING ' . 'ABSENT REPORT SUMMERISED  FOR ' . converttodate($from, 'F jS, Y') . " TO " . converttodate($to, 'F jS, Y') . '</font></TH>
    </TR>
    <TR>
      <TH SCOPE=colgroup COLSPAN="5%">Printed On: <b>' . date("d/m/Y") . '</b></TH>
      <TH SCOPE=colgroup COLSPAN="15%" style="text-align:right;">SHIFT DEF:<b>' . $test_datacard[0]['id_shift_def'] . ' ' . $this->getshiftdetails($test_datacard[0]['id_shift_def'])['shiftfrom'] . ' - ' . $this->getshiftdetails($test_datacard[0]['id_shift_def'])['shiftto'] . '</b></TH>
    </TR>
    <TR>
      <TH SCOPE=colgroup COLSPAN="2%">Printed Time: <b>' . date("h:i:s") . '</b></TH>
      <TH SCOPE=colgroup COLSPAN="4%">' . 'BRANCH ' . $this->getbranchnamebyserial($test_datacard[0]['serialnumber'])['branchname'] . '</TH>
      <TH SCOPE=colgroup COLSPAN="1%" style="text-align:right;">Printed By: <b>' . $printernames['firstname'] . ' ' . $printernames['lastname'] . '</b></TH>
    </TR>
    <TR>
      <TH SCOPE=col COLSPAN=1>Emp No</TH>
      <TH SCOPE=col COLSPAN=1>PIN</TH>
      <TH SCOPE=col COLSPAN=1>NAMES</TH>
       <TH SCOPE=col COLSPAN=1></TH>
      <TH SCOPE=col COLSPAN=1>SHIFT</TH>
      <TH SCOPE=col COLSPAN=1></TH>
      <TH SCOPE=col COLSPAN=1>ABSENT HOURS</TH>
      <TH SCOPE=col COLSPAN=1>TOTAL LOST HOURS</TH>
    </TR>
  </THEAD>';
        $this->table->add_row($theoneheader);
        // Sift Is Attached To Department Later Ref
        // $this->table->add_row('Shifts Definitions : ', $test_datacard[0]['id_shift_def']);
        $totalhoourslost = 0;
        $cellspacecell = array(
            'data' => '',
            //            'class' => 'info'
        );
        foreach ($test_datacard as $_cardtestgrandour) {
            $cell = array(
                'data' => '',
                'class' => 'highlight success',
                'colspan' => '100%'
            );

            $names = $_cardtestgrandour['firstname'] . ' ' . $_cardtestgrandour['lastname'];
            $totalhoursarray = explode('~', $_cardtestgrandour['lostt']);
            $sumlost = array_sum($totalhoursarray);
            $totalhoourslost += $sumlost;
            $cell1 = array(
                'data' => $_cardtestgrandour['employee_code']
            );
            $cell3 = array(
                'data' => $_cardtestgrandour['id_shift_def']
            );
            $cell4 = array(
                'data' => $sumlost
            );
            $cell5 = array(
                'data' => $names
            );
            $cell6 = array(
                'data' => $_cardtestgrandour['pin']
            );
            $this->table->add_row($cell1, $cell6, $cell5, $cellspacecell, $cell3, $cellspacecell, $cell4, $cell4);
        }
        $cellspacecelln = array(
            'data' => 'TOTAL EMPLOYEES',
            'class' => 'info'
        );
        $cellspacecellm = array(
            'data' => 'TOTAL HOURS LOST',
            'class' => 'info'
        );
        $cellspacecellnp = array(
            'data' => count($test_datacard),
            //            'class' => 'info'
        );
        $this->table->add_row($cellspacecelln, $cellspacecellnp, $cellspacecell, $cellspacecell, $cellspacecell, $cellspacecellm, $totalhoourslost);
        return $this->table->generate();
    }

    function timetest_otreport_detailed($test_datacard, $from, $to)
    {
        //        print_array($test_datacard);
        $template = array(
            'table_open' => '<table class="table table-striped table-hover" id="employee_absence_cardtest_d">',
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
        $cell = array(
            'data' => '<b>Total Offs</b>',
            'class' => ' info'
            // 'colspan' => '100%'
        );
        // Main Colums End
        $printernames = $this->universal_model->selectz(array('firstname', 'lastname'), 'users', 'user_id', $this->session->userdata('logged_in')['user_id'])[0];
        $theoneheader = '<THEAD>
    <TR>
      <TH SCOPE=colgroup COLSPAN="100%"><font size="4">ASL TRADING ' . 'OVERTIME REPORT DETAILED  FOR ' . converttodate($from, 'F jS, Y') . ' To ' . converttodate($to, 'F jS, Y') . '</font></TH>
    </TR>
    <TR>
      <TH SCOPE=colgroup COLSPAN="5%">Printed On: <b>' . date("d/m/Y") . '</b></TH>
      <TH SCOPE=colgroup COLSPAN="15%" style="text-align:right;">SHIFT DEF:<b>' . $test_datacard[0]['id_shift_def'] . ' ' . $this->getshiftdetails($test_datacard[0]['id_shift_def'])['shiftfrom'] . ' - ' . $this->getshiftdetails($test_datacard[0]['id_shift_def'])['shiftto'] . '</b></TH>
    </TR>
    <TR>
      <TH SCOPE=colgroup COLSPAN="2%">Printed Time: <b>' . date("h:i:s") . '</b></TH>
      <TH SCOPE=colgroup COLSPAN="4%">' . 'BRANCH ' . $this->getbranchnamebyserial($test_datacard[0]['serialnumber'])['branchname'] . '</TH>
      <TH SCOPE=colgroup COLSPAN="1%" style="text-align:right;">Printed By: <b>' . $printernames['firstname'] . ' ' . $printernames['lastname'] . '</b></TH>
    </TR>
  </THEAD>';
        $this->table->add_row($theoneheader);
        //        $this->table->add_row($celln, '<b>UNALLOCATED<b>', $celln1, '<font size="2" color="green">' . $this->getbranchnamebyserial($test_datacard[0]['serialnumber'])['branchname'] . '</font>', $cellshiftdef1, $cellshiftdef2, $cellshiftdef4);
        // Sift Is Attached To Department Later Ref
        // $this->table->add_row('Shifts Definitions : ', $test_datacard[0]['id_shift_def']);
        $cellspacecell = array(
            'data' => '',
            //            'class' => 'info'
        );
        foreach ($test_datacard as $_cardtestgrandour) {
            $cell = array(
                'data' => '',
                'class' => 'highlight success',
                'colspan' => '100%'
            );

            $names = $_cardtestgrandour['firstname'] . ' ' . $_cardtestgrandour['lastname'];
            $cell1 = array(
                'data' => $_cardtestgrandour['employee_code']
            );
            $cellpin = array(
                'data' => $_cardtestgrandour['pin']
            );
            $cell5 = array(
                'data' => $names
            );
            $this->table->add_row($cell);
            $this->table->add_row($cell1, $cellpin, $cell5);
            $this->table->add_row('<b>Week Day</b>', '<b>Day</b>', '<b>Shift</b>', '<b>Mot 15</b>', '<b>OT 1.5</b>', '<b>TOTAL OT</b>');
            $weekday = explode('~', $_cardtestgrandour['weekday']);
            $dateclock = explode('~', $_cardtestgrandour['dateclock']);
            $ot15 = explode('~', $_cardtestgrandour['ot15']);
            $mot15 = explode('~', $_cardtestgrandour['mot15']);
            $totalot = 0;
            $ot15_total = 0;
            $monr_total = 0;
            foreach ($weekday as $key => $weekday_o) {
                if ($mot15[$key] == "") {
                    $mot15[$key] = 0;
                }
                if ($ot15[$key] == "") {
                    $ot15[$key] = 0;
                }
                $ot15_total += $ot15[$key];
                $monr_total += $mot15[$key];
                $totalfornow = $ot15[$key] + $mot15[$key];
                $totalot += $totalfornow;
                $this->table->add_row($weekday_o, $dateclock[$key], $_cardtestgrandour['id_shift_def'], $mot15[$key], $ot15[$key], $totalfornow);
            }
            $cellspacecell = array(
                'data' => '',
                'class' => 'info'
            );
            $celloff = array(
                'data' => '<b>Total OT Hrs</b>',
                'class' => ' info'
                // 'colspan' => '100%'
            );
            $celloff15 = array(
                'data' => '<b>Total OT 1.5</b>',
                'class' => ' info'
                // 'colspan' => '100%'
            );
            $celloffmt = array(
                'data' => '<b>Total MOT 15</b>',
                'class' => ' info'
                // 'colspan' => '100%'
            );
            $this->table->add_row($cellspacecell, $celloffmt, $monr_total, $celloff15, $ot15_total, $celloff, $totalot);
        }
        return $this->table->generate();
    }

    function timetest_dailyabsent_detailed($test_datacard, $from, $to)
    {
        //        print_array($test_datacard);
        $template = array(
            'table_open' => '<table class="table table-striped table-hover" id="employee_absence_cardtest_d">',
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
        $cell = array(
            'data' => '<b>Total Offs</b>',
            'class' => ' info'
            // 'colspan' => '100%'
        );
        // Main Colums End
        $printernames = $this->universal_model->selectz(array('firstname', 'lastname'), 'users', 'user_id', $this->session->userdata('logged_in')['user_id'])[0];
        $theoneheader = '<THEAD>
    <TR>
      <TH SCOPE=colgroup COLSPAN="100%"><font size="4">ASL TRADING ' . 'ABSENT REPORT DETAILED  FOR ' . converttodate($from, 'F jS, Y') . ' To ' . converttodate($to, 'F jS, Y') . '</font></TH>
    </TR>
    <TR>
      <TH SCOPE=colgroup COLSPAN="5%">Printed On: <b>' . date("d/m/Y") . '</b></TH>
      <TH SCOPE=colgroup COLSPAN="15%" style="text-align:right;">SHIFT DEF:<b>' . $test_datacard[0]['id_shift_def'] . ' ' . $this->getshiftdetails($test_datacard[0]['id_shift_def'])['shiftfrom'] . ' - ' . $this->getshiftdetails($test_datacard[0]['id_shift_def'])['shiftto'] . '</b></TH>
    </TR>
    <TR>
      <TH SCOPE=colgroup COLSPAN="2%">Printed Time: <b>' . date("h:i:s") . '</b></TH>
      <TH SCOPE=colgroup COLSPAN="4%">' . 'BRANCH ' . $this->getbranchnamebyserial($test_datacard[0]['serialnumber'])['branchname'] . '</TH>
      <TH SCOPE=colgroup COLSPAN="1%" style="text-align:right;">Printed By: <b>' . $printernames['firstname'] . ' ' . $printernames['lastname'] . '</b></TH>
    </TR>
  </THEAD>';
        $this->table->add_row($theoneheader);
        //        $this->table->add_row($celln, '<b>UNALLOCATED<b>', $celln1, '<font size="2" color="green">' . $this->getbranchnamebyserial($test_datacard[0]['serialnumber'])['branchname'] . '</font>', $cellshiftdef1, $cellshiftdef2, $cellshiftdef4);
        // Sift Is Attached To Department Later Ref
        // $this->table->add_row('Shifts Definitions : ', $test_datacard[0]['id_shift_def']);
        $totalhoourslost = 0;
        $cellspacecell = array(
            'data' => '',
            //            'class' => 'info'
        );
        foreach ($test_datacard as $_cardtestgrandour) {
            $cell = array(
                'data' => '',
                'class' => 'highlight success',
                'colspan' => '100%'
            );

            $names = $_cardtestgrandour['firstname'] . ' ' . $_cardtestgrandour['lastname'];
            $totalhoursarray = explode('~', $_cardtestgrandour['lostt']);
            $sumlost = array_sum($totalhoursarray);
            $totalhoourslost += $sumlost;
            $cell1 = array(
                'data' => $_cardtestgrandour['employee_code']
            );
            $cellpin = array(
                'data' => $_cardtestgrandour['pin']
            );
            $cell5 = array(
                'data' => $names
            );
            $this->table->add_row($cell);
            $this->table->add_row($cell1, $cellpin, $cell5);
            $this->table->add_row('<b>Week Day</b>', '<b>Day</b>', '<b>Shift</b>', '<b>Lost Hours</b>');
            $weekday = explode('~', $_cardtestgrandour['weekday']);
            $dateclock = explode('~', $_cardtestgrandour['dateclock']);
            $lostt = explode('~', $_cardtestgrandour['lostt']);
            $totallost = 0;
            foreach ($weekday as $key => $weekday_o) {
                if ($lostt[$key] == '7.75') {
                    $lostt[$key] = '8.0';
                }
                $totallost += $lostt[$key];
                $timeformatlost = convertfromdectime($lostt[$key], 2);
                $this->table->add_row($weekday_o, $dateclock[$key], $_cardtestgrandour['id_shift_def'], $timeformatlost);
            }
            $cellspacecell = array(
                'data' => '',
                'class' => 'info'
            );
            $celloff = array(
                'data' => '<b>Total Lost Hrs</b>',
                'class' => ' info'
                // 'colspan' => '100%'
            );
            $this->table->add_row($cellspacecell, $cellspacecell, $celloff, $totallost);
        }
        return $this->table->generate();
    }

    function timetest_latness_detailed($test_datacard, $from, $to)
    {
        //        print_array($test_datacard);
        $template = array(
            'table_open' => '<table class="table table-striped table-hover" id="employee_attendence_lateness">',
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
        $cell = array(
            'data' => '<b>Total Offs</b>',
            'class' => ' info'
            // 'colspan' => '100%'
        );
        // Main Colums End
        $printernames = $this->universal_model->selectz(array('firstname', 'lastname'), 'users', 'user_id', $this->session->userdata('logged_in')['user_id'])[0];
        $theoneheader = '<THEAD>
    <TR>
      <TH SCOPE=colgroup COLSPAN="100%"><font size="4">ASL TRADING ' . 'LATENESS REPORT DETAILED  FOR ' . converttodate($from, 'F jS, Y') . ' To ' . converttodate($to, 'F jS, Y') . '</font></TH>
    </TR>
    <TR>
      <TH SCOPE=colgroup COLSPAN="5%">Printed On: <b>' . date("d/m/Y") . '</b></TH>
      <TH SCOPE=colgroup COLSPAN="15%" style="text-align:right;">SHIFT DEF:<b>' . $test_datacard[0]['id_shift_def'] . ' ' . $this->getshiftdetails($test_datacard[0]['id_shift_def'])['shiftfrom'] . ' - ' . $this->getshiftdetails($test_datacard[0]['id_shift_def'])['shiftto'] . '</b></TH>
    </TR>
    <TR>
      <TH SCOPE=colgroup COLSPAN="2%">Printed Time: <b>' . date("h:i:s") . '</b></TH>
      <TH SCOPE=colgroup COLSPAN="4%">' . 'BRANCH ' . $this->getbranchnamebyserial($test_datacard[0]['serialnumber'])['branchname'] . '</TH>
      <TH SCOPE=colgroup COLSPAN="1%" style="text-align:right;">Printed By: <b>' . $printernames['firstname'] . ' ' . $printernames['lastname'] . '</b></TH>
    </TR>
  </THEAD>';
        $this->table->add_row($theoneheader);
        $totalhoourslost = 0;
        $cellspacecell = array(
            'data' => '',
            //            'class' => 'info'
        );
        foreach ($test_datacard as $_cardtestgrandour) {
            $cell = array(
                'data' => '',
                'class' => 'highlight success',
                'colspan' => '100%'
            );

            $names = $_cardtestgrandour['firstname'] . ' ' . $_cardtestgrandour['lastname'];
            $totalhoursarray = explode('~', $_cardtestgrandour['lostt']);
            $sumlost = array_sum($totalhoursarray);
            $totalhoourslost += $sumlost;
            $cell1 = array(
                'data' => $_cardtestgrandour['employee_code']
            );
            $cellpin = array(
                'data' => $_cardtestgrandour['pin']
            );
            $cell5 = array(
                'data' => $names
            );
            $this->table->add_row($cell);
            $this->table->add_row($cell1, $cellpin, $cell5);
            $this->table->add_row('<b>Week Day</b>', '<b>Day</b>', '<b>Shift</b>', '<b>Login</b>', '<b>Logout</b>', '<b>Normal T</b>', '<b>Lost T</b>');
            $weekday = explode('~', $_cardtestgrandour['weekday']);
            $dateclock = explode('~', $_cardtestgrandour['dateclock']);
            $login = explode('~', $_cardtestgrandour['login']);
            $logout = explode('~', $_cardtestgrandour['logout']);
            $normaltime = explode('~', $_cardtestgrandour['normaltime']);
            $lostt = explode('~', $_cardtestgrandour['lostt']);
            $totallost = 0;
            foreach ($weekday as $key => $weekday_o) {
                $totallost += $lostt[$key];
                $timeformatlost = convertfromdectime($lostt[$key], 2);
                $this->table->add_row($weekday_o, $dateclock[$key], $_cardtestgrandour['id_shift_def'], $login[$key], $logout[$key], $normaltime[$key], $timeformatlost);
            }
            $cellspacecell = array(
                'data' => '',
                'class' => 'info'
            );
            $celloff = array(
                'data' => '<b>Total Lost Hrs</b>',
                'class' => ' info'
                // 'colspan' => '100%'
            );
            $this->table->add_row($cellspacecell, $cellspacecell, $celloff, $totallost);
        }
        return $this->table->generate();
    }

    function getemployeename($user_pin)
    {
        // selectz($array_table_n, $table_n, $variable_1, $value_1)
        $whattoget = array(
            'firstname',
            'lastname',
            'employee_code'
        );
        $usernames = $this->universal_model->selectz($whattoget, 'users', 'pin', $user_pin);
        return $usernames[0];
    }

    function getshiftdetails($shift_id)
    {
        // selectz($array_table_n, $table_n, $variable_1, $value_1)
        $whattoget = array(
            'shiftfrom',
            'shiftto',
            'shiftype'
        );
        $shiftdetails = $this->universal_model->selectz($whattoget, 'attendence_shiftdef', 'shiftmancode', $shift_id);
        if (empty($shiftdetails)) {
            $shiftdetails = array(
                'shiftfrom' => '08:00',
                'shiftto' => '17:00:00',
                'shiftype' => 'Normal Shift Defaulted'
            );
            return $shiftdetails;
        } else {
            return $shiftdetails[0];
        }
    }

    function getbranchnamebyserial($serialnumer)
    {
        // selectz($array_table_n, $table_n, $variable_1, $value_1)
        $whattoget = array(
            'branchname'
        );
        $branchnames = $this->universal_model->selectz($whattoget, 'util_branch_reader', 'readerserial', $serialnumer);
        return $branchnames[0];
    }

    function timetest_otreport($test_datacard, $from, $to)
    {
        //        print_array($test_datacard);
        $template = array(
            'table_open' => '<table class="table table-striped table-hover" id="employee_attendence_cardtestot">',
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
        $cell = array(
            'data' => '<b>Total Offs</b>',
            'class' => ' info'
            // 'colspan' => '100%'
        );
        // Main Colums End
        $printernames = $this->universal_model->selectz(array('firstname', 'lastname'), 'users', 'user_id', $this->session->userdata('logged_in')['user_id'])[0];
        $theoneheader = '<THEAD>
    <TR>
      <TH SCOPE=colgroup COLSPAN="100%"><font size="4">ASL TRADING ' . 'OVERTIME REPORT SUMMERISED  FOR ' . converttodate($from, 'F jS, Y') . " TO " . converttodate($to, 'F jS, Y') . '</font></TH>
    </TR>
    <TR>
      <TH SCOPE=colgroup COLSPAN="5%">Printed On: <b>' . date("d/m/Y") . '</b></TH>
      <TH SCOPE=colgroup COLSPAN="15%" style="text-align:right;">SHIFT DEF:<b>' . $test_datacard[0]['id_shift_def'] . ' ' . $this->getshiftdetails($test_datacard[0]['id_shift_def'])['shiftfrom'] . ' - ' . $this->getshiftdetails($test_datacard[0]['id_shift_def'])['shiftto'] . '</b></TH>
    </TR>
    <TR>
      <TH SCOPE=colgroup COLSPAN="2%">Printed Time: <b>' . date("h:i:s") . '</b></TH>
      <TH SCOPE=colgroup COLSPAN="4%">' . 'BRANCH ' . $this->getbranchnamebyserial($test_datacard[0]['serialnumber'])['branchname'] . '</TH>
      <TH SCOPE=colgroup COLSPAN="1%" style="text-align:right;">Printed By: <b>' . $printernames['firstname'] . ' ' . $printernames['lastname'] . '</b></TH>
    </TR>
    <TR>
      <TH SCOPE=col COLSPAN=1>Emp No</TH>
      <TH SCOPE=col COLSPAN=1>PIN</TH>
      <TH SCOPE=col COLSPAN=1>NAMES</TH>
      <TH SCOPE=col COLSPAN=1>SHIFT</TH>
      <TH SCOPE=col COLSPAN=1>TOTAL MOT15 </TH>
      <TH SCOPE=col COLSPAN=1>TOTAL OT 1.5</TH>
      <TH SCOPE=col COLSPAN=1>OT HOURS TOTAL</TH>
    </TR>
  </THEAD>';
        $this->table->add_row($theoneheader);
        // Sift Is Attached To Department Later Ref
        // $this->table->add_row('Shifts Definitions : ', $test_datacard[0]['id_shift_def']);
        $totalhooursot = 0;
        $cellspacecell = array(
            'data' => '',
            //            'class' => 'info'
        );
        foreach ($test_datacard as $_cardtestgrandour) {
            $cell = array(
                'data' => '',
                'class' => 'highlight success',
                'colspan' => '100%'
            );

            $names = $_cardtestgrandour['firstname'] . ' ' . $_cardtestgrandour['lastname'];
            $totalhoursarray = explode('~', $_cardtestgrandour['mot15']);
            $totalhoursarray2 = explode('~', $_cardtestgrandour['ot15']);
            $sumlost = array_sum($totalhoursarray);
            $sumlost2 = array_sum($totalhoursarray2);
            $totalsub = $sumlost + $sumlost2;
            $totalhooursot += $totalsub;
            $cell1 = array(
                'data' => $_cardtestgrandour['employee_code']
            );
            $cell3 = array(
                'data' => $_cardtestgrandour['id_shift_def']
            );
            $cell4 = array(
                'data' => $totalhooursot
            );
            $cell4one = array(
                'data' => $sumlost
            );
            $cell4two = array(
                'data' => $sumlost2
            );
            $cell5 = array(
                'data' => $names
            );
            $cell6 = array(
                'data' => $_cardtestgrandour['pin']
            );
            $this->table->add_row($cell1, $cell6, $cell5, $cell3, $cell4one, $cell4two, $cell4);
        }
        $cellspacecelln = array(
            'data' => 'TOTAL EMPLOYEES',
            'class' => 'info'
        );
        $cellspacecellm = array(
            'data' => 'TOTAL OT HOURS',
            'class' => 'info'
        );
        $cellspacecellnp = array(
            'data' => count($test_datacard),
            //            'class' => 'info'
        );
        $this->table->add_row($cellspacecelln, $cellspacecellnp, $cellspacecell, $cellspacecell, $cellspacecell, $cellspacecellm, $totalhooursot);
        return $this->table->generate();
    }
}
