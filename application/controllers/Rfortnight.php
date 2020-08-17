<?php

require_once (APPPATH . 'libraries/EditableGrid.php');

class Rfortnight extends CI_Controller {

    public function __construct() {
        parent::__construct();
//        http://htmlhelp.com/reference/html40/tables/thead.html
//        https://stackoverflow.com/questions/19646835/print-repeating-page-headers-in-chrome
        $this->load->model('universal_model');
    }

    public function index() {
        echo '... API Reporting ....';
    }

    function getcoinage($var) {
        $athousand = 1000;
        $fivehund = 500;
        $twohundred = 200;
        $hundred = 100;
        $fifty = 50;
        $twenty = 20;
        $ten = 10;
        $five = 5;
        $one = 1;
        $fiftycent = 0.5;
        $athousandv = floor($var / $athousand);
        $var = $var % $athousand;
        //Round Two
        $fivehundv = floor($var / $fivehund);
        $var = $var % $fivehund;
        //Round 3
        $twohundredv = floor($var / $twohundred);
        $var = $var % $twohundred;
        //Round 4
        $hundredv = floor($var / $hundred);
        $var = $var % $hundred;
        //Round 5
        $fiftyv = floor($var / $fifty);
        $var = $var % $fifty;
        //Round 6
        $twentyv = floor($var / $twenty);
        $var = $var % $twenty;
        //Round 7
        $tenv = floor($var / $ten);
        $var = $var % $ten;
        //Round 8
        $fivev = floor($var / $five);
        $var = $var % $five;
        //Round 9
        $onev = floor($var / $one);
        $var = $var % $one;
        //Round 10
        $fiftycentv = floor($var / $fiftycent);
        $var = $var % $one;
        //End Of Rounds
        $arraycoinage['athousand'] = $athousandv;
        $arraycoinage['fivehund'] = $fivehundv;
        $arraycoinage['twohundred'] = $twohundredv;
        $arraycoinage['hundred'] = $hundredv;
        $arraycoinage['fifty'] = $fiftyv;
        $arraycoinage['twenty'] = $twentyv;
        $arraycoinage['ten'] = $tenv;
        $arraycoinage['five'] = $fivev;
        $arraycoinage['one'] = $onev;
        $arraycoinage['fiftycent'] = $fiftycentv;
        $arraycoinage['plus'] = $var;
        return $arraycoinage;
//        print_array($arraycoinage);
    }

    function reportconstants($branch, $datamin, $datamax, $userpin) {
        $constants = $this->universal_model->selectz(array('dailyrate', 'nssfstate', 'nhifstate', 'loanstate', 'lunchstate', 'saccostate', 'advancestate', 'payestate', 'basicpay', 'lunchamount', 'saccoamount'), 'users', 'pin', $userpin);
        if (empty($constants)) {
            $constants[0]['dailyrate'] = 2.0;
            $constants[0]['nssfstate'] = 1;
            $constants[0]['nhifstate'] = 1;
            $constants[0]['loanstate'] = 1;
            $constants[0]['advancestate'] = 1;
            $constants[0]['payestate'] = 1;
            $constants[0]['lunchstate'] = 1;
            $constants[0]['saccostate'] = 1;
            $constants[0]['basicpay'] = 200;
            return $constants[0];
        } else {
            return $constants[0];
        }
    }

    function fortnightreport($branch, $datamin, $datamax, $userpin) {
        // $datamin, $datamax, $userpin, $branch
        // $datamin = '2019-02-01';
        // $datamax = '2019-02-15';
        // $userpin = '13675538';
        // $branch = 'AIOR181260318';{
        $constants = $this->reportconstants($branch, $datamin, $datamax, $userpin);
        $rate = $constants['dailyrate'];
        $standardpay = $constants['basicpay'];
        $newpinsdata = $this->universal_model->attendence_fortnight($branch, $datamin, $datamax, $userpin);
        $fortreport = array();
//        $rate = $rate;
        $sacco = $constants['saccoamount'];
        $lunch = $constants['lunchamount'];
        $calpay = 0;
        $grossmonthlypay = 0;
        $timearray = array();
        $allowance = 0;
        $cumulativelunch = 0;
        $days = 0;
        $advanceddectiontotal = 0;
        if (!empty($newpinsdata)) {
            $fortreport['nhifnumber'] = $newpinsdata[count($newpinsdata) - 1]['nhifnumber'];
            $fortreport['nssfnumber'] = $newpinsdata[count($newpinsdata) - 1]['nssfnumber'];
            $fortreport['employee_code'] = $newpinsdata[count($newpinsdata) - 1]['employee_code'];
        }
        foreach ($newpinsdata as $key => $value) {
            // print_array($value);
            $temp_lunch = 0;
            $fortreport['names'] = $value['firstname'] . ' ' . $value['lastname'];
            if (strpos($value['off'], 'worked') !== false) {
                $calpay = ($value['tothrs'] / $rate) * $standardpay;
                if ($calpay > $standardpay) {
                    $calpay = $standardpay;
                }
                $cumulativelunch += $lunch;
                $days += 1;
                // $fortreport[$key]['payincrement'] = $calpay;
            } else if ($value['tothrs'] == "" || $value['off'] == 1) {
                // If He was Absent or Off
                $calpay = 0;
                $temp_lunch = 0;
            } else if ($value['tothrs'] != "") {
                $calpay = ($value['tothrs'] / $rate) * $standardpay;
                if ($calpay > $standardpay) {
                    $calpay = $standardpay;
                }
                $temp_lunch = $lunch;
                $cumulativelunch += $lunch;
                $days += 1;
            }
            $timearray_sub = array(
                $value['dateclock'] => $calpay
            );
            array_push($timearray, $timearray_sub);
            $grossmonthlypay += $calpay;
            // $fortreport[$value['dateclock']] = $calpay;
            if ($value['otherallowance'] != "") {
                $allowance += $value['otherallowance'];
            }
            // For Advanced Deduction
            if ($value['advanceddeduction'] != "")
                $advanceddectiontotal += $value['advanceddeduction'];
        }
        $nssfvariable = 200;
        $relife = 1408;
        $dedectstatus = 1;
        $mindate = date('jS', strtotime($datamin));
        $maxdate = date('jS', strtotime($datamax));
        $previousgross = 0;
        $previousnhif = 0;
        if ($mindate != '1st' || $maxdate != '15th') {
            $dedectstatus = 0;
            $nssfvariable = 0;
            $firstdate = date('Y-m-01', strtotime($datamin));
            $fortnight = date('Y-m-d', strtotime($firstdate . ' + 14     days'));
            $datavalue = $this->universal_model->firstfortnightsingleuser(array(
                'a.gross',
                'a.nhif'
                    ), $branch, $firstdate, $fortnight, $userpin);
            if (!empty($datavalue)) {
                $previousgross = $datavalue[0]['gross'];
                $previousnhif = $datavalue[0]['nhif'];
            }
        }
        $gorssgross = $grossmonthlypay + $allowance;
        $gorssgrossx = $grossmonthlypay + $allowance + $previousgross;
        if ($gorssgross == 0) {
            $nssfvariable = 0;
        }
        //Swerling
        //ADVANCE DEDUCTION
        if ($constants['advancestate'] != 1) {
            $advanceddectiontotal = 0;
        }
        //LUNCH
        if ($constants['lunchstate'] != 1) {
            $cumulativelunch = 0;
        }
        //SACCO
        if ($constants['saccostate'] != 1) {
            $saccovalue = 0;
        } else {
            $saccovalue = $sacco / 2;
        }
        //NHIF
        if ($constants['nssfstate'] != 1) {
            $nssfvariable = 0;
        }
        //PAYE
        if ($constants['payestate'] == 1) {
            $paye = $this->forpaye($gorssgrossx, $nssfvariable, $relife, $dedectstatus);
        } else {
            $paye = 0.0;
        }
        //NHIF
        if ($constants['nhifstate'] == 1) {
            $nhif = $this->fornhif($gorssgrossx, $previousnhif);
        } else {
            $nhif = 0.0;
        }
        //Swerling End  
        $fortreport['time'] = json_encode($timearray);
        $fortreport['otherallow'] = $allowance;
        $fortreport['paye'] = $paye;
        $fortreport['nhif'] = $nhif;
        $fortreport['nssf'] = $nssfvariable;
        $fortreport['pinnumber'] = $userpin;
        $fortreport['branch'] = $branch;
        $fortreport['days'] = $days;
        $fortreport['sacco'] = $saccovalue;
        $fortreport['saccoamount'] = $constants['saccoamount'];
        $fortreport['lunchamount'] = $constants['lunchamount'];
        $fortreport['lunch'] = $cumulativelunch;
        $fortreport['mindate'] = $datamin;
        $fortreport['maxidate'] = $datamax;
        $fortreport['advanceddeduction'] = $advanceddectiontotal;
        $fortreport['employmenttype_id'] = 1;
        $checkloan = $this->universal_model->joinloanreduction($userpin, 1);
        // print_array($checkloan);
        $reducelone = 0;
        if ($mindate == '1st' || $mindate == '16th') {
            $reducelone = 1;
        }

        $fortreport['gross'] = $gorssgross;
        $loanamount = 0;
        if (!empty($checkloan) && $reducelone == 1 && $constants['loanstate'] == 1) {
            $kaye = array_keys($checkloan);
            $amountloan = $checkloan[$kaye[0]]['currnetbalance'];
            $ainterestrate = $checkloan[$kaye[0]]['ainterestrate'];
            $whattake = ($ainterestrate / 100) * $gorssgross;
            if ($amountloan < $whattake) {
                $newoneamount = 0;
                $loanamount = $amountloan;
                // $fortreport['loan'] = $amountloan;
                $this->universal_model->updatem('userpin', $userpin, 'loanstate', 1, 'appliedloans', array(
                    'currnetbalance' => 0,
                    'loanstate' => 0
                ));
                // updatecurrent to zero
            } else {
                $newoneamount = $amountloan - $whattake;
                $loanamount = $whattake;
                // $fortreport['loan'] = $whattake;
                $this->universal_model->updatem('userpin', $userpin, 'loanstate', 1, 'appliedloans', array(
                    'currnetbalance' => $newoneamount,
                    'loanstate' => 1
                ));
            }
        } else {
            $loanamount = 0;
        }
        $fortreport['loan'] = 0;
        $totaldecution = $loanamount + $cumulativelunch + $saccovalue + $advanceddectiontotal + $paye + $nhif + $nssfvariable;
        $fortreport['totalremoved'] = $totaldecution;
        $fortreport['totalremain'] = $gorssgross - $totaldecution;
//        print_array($fortreport);
        return $fortreport;
    }

    function forpaye($amount, $nssfvariable, $relife, $reductstate) {
        $paye_temp = $this->universal_model->selectall('*', 'paye_temp');
        $paycalculated = 0;
        if (empty($paye_temp)) {
            $paycalculated = 0.00;
        } elseif (!empty($paye_temp)) {
            $minimumcheck = $paye_temp[0]['monthpayto'];
            if ($amount <= $minimumcheck) {
                $paycalculated = 0.00;
            } else {
                foreach ($paye_temp as $key => $loopoptions) {
                    if ($amount >= $loopoptions['monthpayfr'] && $amount <= $loopoptions['monthpayto']) {
                        $tax1 = $paye_temp[$key - 1]['maxtaxable'];
                        if ($reductstate == 1) {
                            $taxableamount = $amount - $nssfvariable;
                        }
                        //TRUMP AMOUNTs
                        else {
                            $taxableamount = $amount;
                        }
                        $taxableamount_one = $taxableamount - $paye_temp[$key - 1]['monthpayto'];
                        $tax2 = $taxableamount_one * $paye_temp[$key]['taxrate'];
                        $grosstax = $tax1 + $tax2;
                        $paycalculated = $grosstax - $relife;
                        break;
                    }
                }
            }
        }
        return sprintf('%0.2f', round($paycalculated, PHP_ROUND_HALF_UP));
    }

    public function fornhif($grosspay, $previousnhif) {
        $paye_temp = $this->universal_model->selectall('*', 'nhif_temp');
        $paycalculated = 0;
        if (empty($paye_temp)) {
            $paycalculated = 0.00;
        } elseif (!empty($paye_temp)) {
            foreach ($paye_temp as $key => $loopoptions) {
                if ($grosspay >= $loopoptions['monthlypayfrom'] && $grosspay <= $loopoptions['monthlypayto']) {
                    $paycalculated = $loopoptions['taxrate'];
                    break;
                }
            }
        }
        return sprintf('%0.2f', ($paycalculated - $previousnhif));
    }

    public function coinagereportsum() {
        $branch_startpay = $this->input->post('branch_startpaysumcoinage');
        $date_maxncardxpay = $this->input->post('date_maxncardxpaysumcoinage');
        $date_mincardxpay = $this->input->post('date_mincardxpaysumcoinage');
        $employeenumbermaxxpay = $this->input->post('employeenumbermaxxpaysumcoinage');
        $employeenumberminxpay = $this->input->post('employeenumberminxpaysumcoinage');
        $employmenttype_id = $this->input->post('employmenttype_idsumcoinage');
        // PROCESS
        $employeenumberminxarray = explode('|', $employeenumberminxpay);
        $employeenumbermaxxarray = explode('|', $employeenumbermaxxpay);
        $array_last_name = 0;
        if ($employeenumbermaxxarray[0] != '') {
            $array_last_name = $employeenumbermaxxarray[0][0];
        }
        //Start Date Manipulation
        $datemonth = changedateformate($date_mincardxpay, 'Y-m');
        $startdate = $datemonth . '-' . '01';
        $enddate = $datemonth . '-' . '15';
        $enddate_ = getlastdayofdate($startdate, 'Y-m-d');
        //End Date Manipulation
        // START HASING AND DATE COPARING
        // START HASING AND DATE COPARING
        $branchcode = explode('$', $branch_startpay);
        $gettimetrans = $this->universal_model->getrangeforfortnight(array('pintwo'), $employeenumberminxarray[0][0], $array_last_name, $branchcode[0], $employmenttype_id);
        $reportarrayone = array();
        foreach ($gettimetrans as $gettimetransvalues) {
            $reportarraytemp = $this->fortnightreport($branchcode[0], $enddate, $enddate_, $gettimetransvalues['pintwo']);
            if (!empty(json_decode($reportarraytemp['time'], true))) {
                array_push($reportarrayone, $reportarraytemp);
            }
        }

        $reportarray = array();
        foreach ($gettimetrans as $gettimetransvalues) {
            $reportarraytemp = $this->universal_model->firstfortnightsingleuser('*', $branchcode[0], $startdate, $enddate, $gettimetransvalues['pintwo']);
            if (!empty($reportarraytemp)) {
                array_push($reportarray, $reportarraytemp[0]);
            }
        }
        $arraysupermerger = array_merge($reportarray, $reportarrayone);
        $output = array_reduce($arraysupermerger, function (array $carry, array $item) {
            $city = $item['pinnumber'];
            if (array_key_exists($city, $carry)) {
                $carry[$city]['nssf'] += $item['nssf'];
                $carry[$city]['nhif'] += $item['nhif'];
                $carry[$city]['paye'] += $item['paye'];
                $carry[$city]['maxidate'] = $item['maxidate'];
                $carry[$city]['gross'] += $item['gross'];
                $carry[$city]['days'] += $item['days'];
                $carry[$city]['otherallow'] += $item['otherallow'];
                $carry[$city]['sacco'] += $item['sacco'];
                $carry[$city]['advanceddeduction'] += $item['advanceddeduction'];
                $carry[$city]['lunch'] += $item['lunch'];
                $carry[$city]['loan'] += $item['loan'];
                $carry[$city]['totalremoved'] += $item['totalremoved'];
                $carry[$city]['totalremain'] += $item['totalremain'];
                $carry[$city]['time'] = $this->combinetime($carry [$city] ['time'], $item ['time']);
//                        // CreatedArrays Virtual
            } else {
                // print_array($item);
                $carry[$city] = $item;
                // CreatedArrays Virtual
            }
            return $carry;
        }, array());
        $arraam = array_values($output);
//        print_array($arraam);
        if (empty($arraam)) {
            $json_return = array(
                'report' => "No Data Found  in this Range " . $date_mincardxpay . ' to ' . $date_maxncardxpay,
                'status' => 0
            );
            echo json_encode($json_return);
        } else {
            $json_return = array(
                'report' => "Range " . 'between ' . $date_mincardxpay . ' to ' . $date_maxncardxpay . ' loaded',
                'status' => 1,
                'data' => $this->generatereportnssf($arraam, $date_mincardxpay, $branchcode[0], $employmenttype_id)
            );
            echo json_encode($json_return);
        }
    }

    public function saccoreportsum() {
        $branch_startpay = $this->input->post('branch_startpaysumsacco');
        $date_maxncardxpay = $this->input->post('date_maxncardxpaysumsacco');
        $date_mincardxpay = $this->input->post('date_mincardxpaysumsacco');
        $employeenumbermaxxpay = $this->input->post('employeenumbermaxxpaysumsacco');
        $employeenumberminxpay = $this->input->post('employeenumberminxpaysumsacco');
        $employmenttype_id = $this->input->post('employmenttype_idsumsacco');
        // PROCESS
        $employeenumberminxarray = explode('|', $employeenumberminxpay);
        $employeenumbermaxxarray = explode('|', $employeenumbermaxxpay);
        $array_last_name = 0;
        if ($employeenumbermaxxarray[0] != '') {
            $array_last_name = $employeenumbermaxxarray[0][0];
        }
        //Start Date Manipulation
        $datemonth = changedateformate($date_mincardxpay, 'Y-m');
        $startdate = $datemonth . '-' . '01';
        $enddate = $datemonth . '-' . '15';
        $enddate_ = getlastdayofdate($startdate, 'Y-m-d');
        //End Date Manipulation
        // START HASING AND DATE COPARING
        // START HASING AND DATE COPARING
        $branchcode = explode('$', $branch_startpay);
        $gettimetrans = $this->universal_model->getrangeforfortnight(array('pintwo'), $employeenumberminxarray[0][0], $array_last_name, $branchcode[0], $employmenttype_id);
        $reportarrayone = array();
        foreach ($gettimetrans as $gettimetransvalues) {
            $reportarraytemp = $this->fortnightreport($branchcode[0], $enddate, $enddate_, $gettimetransvalues['pintwo']);
            if (!empty(json_decode($reportarraytemp['time'], true))) {
                array_push($reportarrayone, $reportarraytemp);
            }
        }

        $reportarray = array();
        foreach ($gettimetrans as $gettimetransvalues) {
            $reportarraytemp = $this->universal_model->firstfortnightsingleuser('*', $branchcode[0], $startdate, $enddate, $gettimetransvalues['pintwo']);
            if (!empty($reportarraytemp)) {
                array_push($reportarray, $reportarraytemp[0]);
            }
        }
        $arraysupermerger = array_merge($reportarray, $reportarrayone);
        $output = array_reduce($arraysupermerger, function (array $carry, array $item) {
            $city = $item['pinnumber'];
            if (array_key_exists($city, $carry)) {
                $carry[$city]['nssf'] += $item['nssf'];
                $carry[$city]['nhif'] += $item['nhif'];
                $carry[$city]['paye'] += $item['paye'];
                $carry[$city]['maxidate'] = $item['maxidate'];
                $carry[$city]['gross'] += $item['gross'];
                $carry[$city]['days'] += $item['days'];
                $carry[$city]['otherallow'] += $item['otherallow'];
                $carry[$city]['sacco'] += $item['sacco'];
                $carry[$city]['advanceddeduction'] += $item['advanceddeduction'];
                $carry[$city]['lunch'] += $item['lunch'];
                $carry[$city]['loan'] += $item['loan'];
                $carry[$city]['totalremoved'] += $item['totalremoved'];
                $carry[$city]['totalremain'] += $item['totalremain'];
                $carry[$city]['time'] = $this->combinetime($carry [$city] ['time'], $item ['time']);
//                        // CreatedArrays Virtual
            } else {
                // print_array($item);
                $carry[$city] = $item;
                // CreatedArrays Virtual
            }
            return $carry;
        }, array());
        $arraam = array_values($output);
//        print_array($arraam);
        if (empty($arraam)) {
            $json_return = array(
                'report' => "No Data Found  in this Range " . $date_mincardxpay . ' to ' . $date_maxncardxpay,
                'status' => 0
            );
            echo json_encode($json_return);
        } else {
            $json_return = array(
                'report' => "Range " . 'between ' . $date_mincardxpay . ' to ' . $date_maxncardxpay . ' loaded',
                'status' => 1,
                'data' => $this->generatereportsacco($arraam, $date_mincardxpay, $branchcode[0], $employmenttype_id)
            );
            echo json_encode($json_return);
        }
    }

    public function lunchreportsum() {
        $branch_startpay = $this->input->post('branch_startpaysumlunch');
        $date_maxncardxpay = $this->input->post('date_maxncardxpaysumlunch');
        $date_mincardxpay = $this->input->post('date_mincardxpaysumlunch');
        $employeenumbermaxxpay = $this->input->post('employeenumbermaxxpaysumlunch');
        $employeenumberminxpay = $this->input->post('employeenumberminxpaysumlunch');
        $employmenttype_id = $this->input->post('employmenttype_idsumlunch');
        // PROCESS
        $employeenumberminxarray = explode('|', $employeenumberminxpay);
        $employeenumbermaxxarray = explode('|', $employeenumbermaxxpay);
        $array_last_name = 0;
        if ($employeenumbermaxxarray[0] != '') {
            $array_last_name = $employeenumbermaxxarray[0][0];
        }
        //Start Date Manipulation
        $datemonth = changedateformate($date_mincardxpay, 'Y-m');
        $startdate = $datemonth . '-' . '01';
        $enddate = $datemonth . '-' . '15';
        $enddate_ = getlastdayofdate($startdate, 'Y-m-d');
        //End Date Manipulation
        // START HASING AND DATE COPARING
        // START HASING AND DATE COPARING
        $branchcode = explode('$', $branch_startpay);
        $gettimetrans = $this->universal_model->getrangeforfortnight(array('pintwo'), $employeenumberminxarray[0][0], $array_last_name, $branchcode[0], $employmenttype_id);
        $reportarrayone = array();
        foreach ($gettimetrans as $gettimetransvalues) {
            $reportarraytemp = $this->fortnightreport($branchcode[0], $enddate, $enddate_, $gettimetransvalues['pintwo']);
            if (!empty(json_decode($reportarraytemp['time'], true))) {
                array_push($reportarrayone, $reportarraytemp);
            }
        }

        $reportarray = array();
        foreach ($gettimetrans as $gettimetransvalues) {
            $reportarraytemp = $this->universal_model->firstfortnightsingleuser('*', $branchcode[0], $startdate, $enddate, $gettimetransvalues['pintwo']);
            if (!empty($reportarraytemp)) {
                array_push($reportarray, $reportarraytemp[0]);
            }
        }
        $arraysupermerger = array_merge($reportarray, $reportarrayone);
        $output = array_reduce($arraysupermerger, function (array $carry, array $item) {
            $city = $item['pinnumber'];
            if (array_key_exists($city, $carry)) {
                $carry[$city]['nssf'] += $item['nssf'];
                $carry[$city]['nhif'] += $item['nhif'];
                $carry[$city]['paye'] += $item['paye'];
                $carry[$city]['maxidate'] = $item['maxidate'];
                $carry[$city]['gross'] += $item['gross'];
                $carry[$city]['days'] += $item['days'];
                $carry[$city]['otherallow'] += $item['otherallow'];
                $carry[$city]['sacco'] += $item['sacco'];
                $carry[$city]['advanceddeduction'] += $item['advanceddeduction'];
                $carry[$city]['lunch'] += $item['lunch'];
                $carry[$city]['loan'] += $item['loan'];
                $carry[$city]['totalremoved'] += $item['totalremoved'];
                $carry[$city]['totalremain'] += $item['totalremain'];
                $carry[$city]['time'] = $this->combinetime($carry [$city] ['time'], $item ['time']);
//                        // CreatedArrays Virtual
            } else {
                // print_array($item);
                $carry[$city] = $item;
                // CreatedArrays Virtual
            }
            return $carry;
        }, array());
        $arraam = array_values($output);
//        print_array($arraam);
        if (empty($arraam)) {
            $json_return = array(
                'report' => "No Data Found  in this Range " . $date_mincardxpay . ' to ' . $date_maxncardxpay,
                'status' => 0
            );
            echo json_encode($json_return);
        } else {
            $json_return = array(
                'report' => "Range " . 'between ' . $date_mincardxpay . ' to ' . $date_maxncardxpay . ' loaded',
                'status' => 1,
                'data' => $this->generatereportlunch($arraam, $date_mincardxpay, $branchcode[0], $employmenttype_id)
            );
            echo json_encode($json_return);
        }
    }

    public function nhifreportsum() {
//        $branch_startpay = "AIOR181260318$23317223@27896398@28149957@29032835@29084758@29758714@30009479@30577023@30752145@30757481@31363604@33998587@34077392@34755722@35550396@35776790@6270758@ALICE WANGARI@ALIMA ADEN MARE@ANDREW GITHAIGA KAMUNYA@ANTHONY KINYUA@ANTHONY MWAMBU@BENSON KIPCHIRCHIR@BETH MWENDWA@CATHERINE NUNGARI@CEPHAS MULILI KITETU@CHRISTINE NGATIA@CHRISTOPHER GITAHI@CLEOPHER MWANGI@COLLINS OMONDI@CONSOLATA NYAMBURA@CONSTANCE MUDONYI@DANIEL MAINGI@DAVID MUNIU@DENNIS MWASI@DENNIS NJOROGE@DOMINIC KITHOME@DOMINIC MUNZAA@EDITH MUMBI@EDWIN MUTAHI@ELIZABETH WANJIRU@EMMANUEL KIPNGENO@ERIC MUCHANGI@EUNICE MUCHOKI@EUNICE WANJIKU GAKUYA@EVANS MWANGI@EVANS WAMBWILE@FRED NJUGUNA@FRIDAH GAKII@GASPER GATHECHA@GEORGE KINYANJUI@GEORGE MWANGI@GIBSON THEURI@GRACE KILASARA@HEZRON BUNDI@IAN KIMANI@IRENE NDUNGE@ISAAC WARURU@JAMES MUTHOKA@JAMES NDEGWA@JANE KAROKI@JANE WANGUI KAROKI@JAPHETH MUSYOKI@JENNIFFER WAITHIRA@JOAN NJERI@JOHN MAINA@JOHN MUYESU@JOHN NJOROGE@JOHN NJUGUNA@JORAM MUHIA@JOSEPH KIGO@JOSEPH NJUGUNA@JULIUS MWANGI@KELVINS ASHION@KENNEDY MWANGI@KENNETH KIPKEMOI@LUCY NJERI@MARIA NJOKI MWAURA@MARTHA KAVATA@MARYGRACE WANJIRU@MARYLYN OMONDI@MAUREEN MILGO@MAUREEN NYAMBURA@METRINE NAFULA@MICHAEL KURIA@MICHAEL SILA@MONICAH WAKARIMA@MUTUA MUTEMI@NAHASHON KARIUKI@NELSON CHERUIYOT@NELSON MACHARIA@NIMROD KIHIU@PATRICK KABUTHA@PATRICK NDAMBUKI@PATRICK NJOGU MUIRURI@PAUL NDIRANGU@PETER MAKALI MUTUA@PETER MUTUA@PETERSON WANJAU@PYHLIS NYABELA@REUBEN MWANGI@ROSELINDA ALOO OCHANGO@RUTH WACU@SAMUEL KIMATHI@SAMUEL MURIITHI@SAMUEL NJUGUNA@SIFIRA NJERI WANJIRU@SIMON ODORO@STEPHEN MAINA@STEPHEN MWANGI@STEPHEN MWAURA@STEPHEN NGANGA@SUSAN WANJIRU@TABITHA WAENI@TERESIA GACHUMA@TERESIA MUKUI KIOKO@TITUS MUNYOKI@WALTER EVANSON NJUGUNA@WILSON KURIA@ZAVERIOUS DIEMA$23317223@27896398@28149957@29032835@29084758@29758714@30009479@30577023@30752145@30757481@31363604@33998587@34077392@34755722@35550396@35776790@6270758@30450344@14188913@22324308@23645812@24702590@30239108@29467545@24164182@31037402@35530993@23040770@32247700@37146133@31008131@22538550@25199564@23320167@25690395@32392973@28951887@27383652@29862170@30125451@26627407@29706656@31891878@33817015@31400981@30782345@28317223@34024916@25221951@20908006@32484430@32158530@24491108@27532859@28516302@34262196@28705280@29294941@33823429@36373026@32537352@2537352@27865598@34484338@33882523@33358128@33624352@28246181@33668930@33027920@34930579@28838626@21973782@24486453@31911854@36887539@29466252@27760720@32986080@23983137@32229621@32497185@33825300@32241489@33302358@23744898@34912384@25792831@27771420@32391045@33166688@24384079@28584260@36197022@22377284@31306191@14522654@27067791@28948866@22630830@24569753@21600415@27896388@32271291@33776401@34227112@34505869@30407307@9381282@30198692@23084332@27860653@31554378@31088682@26378936@22592526@22197141@13675538@28351268@24046435";
//        $date_maxncardxpay = "2019-02-28";
//        $date_mincardxpay = "2019-02-01";
//        $employeenumbermaxxpay = "ZAVERIOUS DIEMA|24046435";
//        $employeenumberminxpay = "ALICE WANGARI|30450344";
//        $employmenttype_id = 1;
        $branch_startpay = $this->input->post('branch_startpaysumnhif');
        $date_maxncardxpay = $this->input->post('date_maxncardxpaysumnhif');
        $date_mincardxpay = $this->input->post('date_mincardxpaysumnhif');
        $employeenumbermaxxpay = $this->input->post('employeenumbermaxxpaysumnhif');
        $employeenumberminxpay = $this->input->post('employeenumberminxpaysumnhif');
        $employmenttype_id = $this->input->post('employmenttype_idsumnhif');
        // PROCESS
        $employeenumberminxarray = explode('|', $employeenumberminxpay);
        $employeenumbermaxxarray = explode('|', $employeenumbermaxxpay);
        $array_last_name = 0;
        if ($employeenumbermaxxarray[0] != '') {
            $array_last_name = $employeenumbermaxxarray[0][0];
        }
        //Start Date Manipulation
        $datemonth = changedateformate($date_mincardxpay, 'Y-m');
        $startdate = $datemonth . '-' . '01';
        $enddate = $datemonth . '-' . '15';
        $enddate_ = getlastdayofdate($startdate, 'Y-m-d');
        //End Date Manipulation
        // START HASING AND DATE COPARING
        // START HASING AND DATE COPARING
        $branchcode = explode('$', $branch_startpay);
        $gettimetrans = $this->universal_model->getrangeforfortnight(array('pintwo'), $employeenumberminxarray[0][0], $array_last_name, $branchcode[0], $employmenttype_id);
        $reportarrayone = array();
        foreach ($gettimetrans as $gettimetransvalues) {
            $reportarraytemp = $this->fortnightreport($branchcode[0], $enddate, $enddate_, $gettimetransvalues['pintwo']);
            if (!empty(json_decode($reportarraytemp['time'], true))) {
                array_push($reportarrayone, $reportarraytemp);
            }
        }

        $reportarray = array();
        foreach ($gettimetrans as $gettimetransvalues) {
            $reportarraytemp = $this->universal_model->firstfortnightsingleuser('*', $branchcode[0], $startdate, $enddate, $gettimetransvalues['pintwo']);
            if (!empty($reportarraytemp)) {
                array_push($reportarray, $reportarraytemp[0]);
            }
        }
        $arraysupermerger = array_merge($reportarray, $reportarrayone);
        $output = array_reduce($arraysupermerger, function (array $carry, array $item) {
            $city = $item['pinnumber'];
            if (array_key_exists($city, $carry)) {
                $carry[$city]['nssf'] += $item['nssf'];
                $carry[$city]['nhif'] += $item['nhif'];
                $carry[$city]['paye'] += $item['paye'];
                $carry[$city]['maxidate'] = $item['maxidate'];
                $carry[$city]['gross'] += $item['gross'];
                $carry[$city]['days'] += $item['days'];
                $carry[$city]['otherallow'] += $item['otherallow'];
                $carry[$city]['sacco'] += $item['sacco'];
                $carry[$city]['advanceddeduction'] += $item['advanceddeduction'];
                $carry[$city]['lunch'] += $item['lunch'];
                $carry[$city]['loan'] += $item['loan'];
                $carry[$city]['totalremoved'] += $item['totalremoved'];
                $carry[$city]['totalremain'] += $item['totalremain'];
                $carry[$city]['time'] = $this->combinetime($carry [$city] ['time'], $item ['time']);
//                        // CreatedArrays Virtual
            } else {
                // print_array($item);
                $carry[$city] = $item;
                // CreatedArrays Virtual
            }
            return $carry;
        }, array());
        $arraam = array_values($output);
//        print_array($arraam);
        if (empty($arraam)) {
            $json_return = array(
                'report' => "No Data Found  in this Range " . $date_mincardxpay . ' to ' . $date_maxncardxpay,
                'status' => 0
            );
            echo json_encode($json_return);
        } else {
            $json_return = array(
                'report' => "Range " . 'between ' . $date_mincardxpay . ' to ' . $date_maxncardxpay . ' loaded',
                'status' => 1,
                'data' => $this->generatereportnhif($arraam, $date_mincardxpay, $branchcode[0], $employmenttype_id)
            );
            echo json_encode($json_return);
        }
    }

    public function coinagereport() {
        $branch_startpay = $this->input->post('branch_startpaycoinage');
        $date_maxncardxpay = $this->input->post('date_maxncardxpaycoinage');
        $date_mincardxpay = $this->input->post('date_mincardxpaycoinage');
        $employeenumbermaxxpay = $this->input->post('employeenumbermaxxpaycoinage');
        $employeenumberminxpay = $this->input->post('employeenumberminxpaycoinage');
        $employmenttype_id = $this->input->post('employmenttype_id');
        // PROCESS
        $employeenumberminxarray = explode('|', $employeenumberminxpay);
        $employeenumbermaxxarray = explode('|', $employeenumbermaxxpay);
        $array_last_name = 0;
        if ($employeenumbermaxxarray[0] != '') {
            $array_last_name = $employeenumbermaxxarray[0][0];
        }
        // START HASING AND DATE COPARING
        $mindate = date('jS', strtotime($date_mincardxpay));
        $maxdate = date('jS', strtotime($date_maxncardxpay));
        // START HASING AND DATE COPARING
        $branchcode = explode('$', $branch_startpay);
        $reportarray = array();
        $rage = getDatesFromRange($date_mincardxpay, $date_maxncardxpay);
        if (count($rage) > 16) {
            $reportarray = array();
            $state = 1;
        } else {
            $gettimetrans = $this->universal_model->getrangeforfortnight(array('pintwo'), $employeenumberminxarray[0][0], $array_last_name, $branchcode[0], $employmenttype_id);
            foreach ($gettimetrans as $gettimetransvalues) {
                $reportarraytemp = $this->fortnightreport($branchcode[0], $date_mincardxpay, $date_maxncardxpay, $gettimetransvalues['pintwo']);
                if (!empty(json_decode($reportarraytemp['time'], true))) {
                    if ($mindate == '1st' && $maxdate == '15th') {
//                    $this->db->empty_table('payfortnight');
                        $this->universal_model->updateOnDuplicate('payfortnight', $reportarraytemp);
                    }
                    array_push($reportarray, $reportarraytemp);
                }
            }
            $state = 2;
        }
        // print_array($reportarray);
        if (empty($reportarray)) {
            if ($state == 2) {
                $report = "No Data Found  in this Range " . $date_mincardxpay . ' to ' . $date_maxncardxpay;
            }
            if ($state == 1) {
                $report = "Fortnight Maximum Days Are 16";
            }
            $json_return = array(
                'report' => $report,
                'status' => 0
            );
            echo json_encode($json_return);
        } else {
            $json_return = array(
                'report' => "Range " . 'between ' . $date_mincardxpay . ' to ' . $date_maxncardxpay . ' loaded',
                'status' => 1,
                'data' => $this->generatereportcoinageablehtml($reportarray, $date_mincardxpay, $date_maxncardxpay, $branchcode[0], $employmenttype_id)
            );
            echo json_encode($json_return);
        }
    }

    public function loadpayslipsum() {
//        $branch_startpay = "AIOR181260318$23317223@27896398@28149957@29032835@29084758@29758714@30009479@30577023@30752145@30757481@31363604@33998587@34077392@34755722@35550396@35776790@6270758@ALICE WANGARI@ALIMA ADEN MARE@ANDREW GITHAIGA KAMUNYA@ANTHONY KINYUA@ANTHONY MWAMBU@BENSON KIPCHIRCHIR@BETH MWENDWA@CATHERINE NUNGARI@CEPHAS MULILI KITETU@CHRISTINE NGATIA@CHRISTOPHER GITAHI@CLEOPHER MWANGI@COLLINS OMONDI@CONSOLATA NYAMBURA@CONSTANCE MUDONYI@DANIEL MAINGI@DAVID MUNIU@DENNIS MWASI@DENNIS NJOROGE@DOMINIC KITHOME@DOMINIC MUNZAA@EDITH MUMBI@EDWIN MUTAHI@ELIZABETH WANJIRU@EMMANUEL KIPNGENO@ERIC MUCHANGI@EUNICE MUCHOKI@EUNICE WANJIKU GAKUYA@EVANS MWANGI@EVANS WAMBWILE@FRED NJUGUNA@FRIDAH GAKII@GASPER GATHECHA@GEORGE KINYANJUI@GEORGE MWANGI@GIBSON THEURI@GRACE KILASARA@HEZRON BUNDI@IAN KIMANI@IRENE NDUNGE@ISAAC WARURU@JAMES MUTHOKA@JAMES NDEGWA@JANE KAROKI@JANE WANGUI KAROKI@JAPHETH MUSYOKI@JENNIFFER WAITHIRA@JOAN NJERI@JOHN MAINA@JOHN MUYESU@JOHN NJOROGE@JOHN NJUGUNA@JORAM MUHIA@JOSEPH KIGO@JOSEPH NJUGUNA@JULIUS MWANGI@KELVINS ASHION@KENNEDY MWANGI@KENNETH KIPKEMOI@LUCY NJERI@MARIA NJOKI MWAURA@MARTHA KAVATA@MARYGRACE WANJIRU@MARYLYN OMONDI@MAUREEN MILGO@MAUREEN NYAMBURA@METRINE NAFULA@MICHAEL KURIA@MICHAEL SILA@MONICAH WAKARIMA@MUTUA MUTEMI@NAHASHON KARIUKI@NELSON CHERUIYOT@NELSON MACHARIA@NIMROD KIHIU@PATRICK KABUTHA@PATRICK NDAMBUKI@PATRICK NJOGU MUIRURI@PAUL NDIRANGU@PETER MAKALI MUTUA@PETER MUTUA@PETERSON WANJAU@PYHLIS NYABELA@REUBEN MWANGI@ROSELINDA ALOO OCHANGO@RUTH WACU@SAMUEL KIMATHI@SAMUEL MURIITHI@SAMUEL NJUGUNA@SIFIRA NJERI WANJIRU@SIMON ODORO@STEPHEN MAINA@STEPHEN MWANGI@STEPHEN MWAURA@STEPHEN NGANGA@SUSAN WANJIRU@TABITHA WAENI@TERESIA GACHUMA@TERESIA MUKUI KIOKO@TITUS MUNYOKI@WALTER EVANSON NJUGUNA@WILSON KURIA@ZAVERIOUS DIEMA$23317223@27896398@28149957@29032835@29084758@29758714@30009479@30577023@30752145@30757481@31363604@33998587@34077392@34755722@35550396@35776790@6270758@30450344@14188913@22324308@23645812@24702590@30239108@29467545@24164182@31037402@35530993@23040770@32247700@37146133@31008131@22538550@25199564@23320167@25690395@32392973@28951887@27383652@29862170@30125451@26627407@29706656@31891878@33817015@31400981@30782345@28317223@34024916@25221951@20908006@32484430@32158530@24491108@27532859@28516302@34262196@28705280@29294941@33823429@36373026@32537352@2537352@27865598@34484338@33882523@33358128@33624352@28246181@33668930@33027920@34930579@28838626@21973782@24486453@31911854@36887539@29466252@27760720@32986080@23983137@32229621@32497185@33825300@32241489@33302358@23744898@34912384@25792831@27771420@32391045@33166688@24384079@28584260@36197022@22377284@31306191@14522654@27067791@28948866@22630830@24569753@21600415@27896388@32271291@33776401@34227112@34505869@30407307@9381282@30198692@23084332@27860653@31554378@31088682@26378936@22592526@22197141@13675538@28351268@24046435";
//        $date_maxncardxpay = "2019-02-28";
//        $date_mincardxpay = "2019-02-01";
//        $employeenumbermaxxpay = "ZAVERIOUS DIEMA|24046435";
//        $employeenumberminxpay = "ALICE WANGARI|30450344";
//        $employmenttype_id = 1;
        //Variables
        $branch_startpay = $this->input->post('branch_startpaysum');
        $date_maxncardxpay = $this->input->post('date_maxncardxpaysum');
        $date_mincardxpay = $this->input->post('date_mincardxpaysum');
        $employeenumbermaxxpay = $this->input->post('employeenumbermaxxpaysum');
        $employeenumberminxpay = $this->input->post('employeenumberminxpaysum');
        $employmenttype_id = $this->input->post('employmenttype_idsum');
        // PROCESS
        $employeenumberminxarray = explode('|', $employeenumberminxpay);
        $employeenumbermaxxarray = explode('|', $employeenumbermaxxpay);
        $array_last_name = 0;
        if ($employeenumbermaxxarray[0] != '') {
            $array_last_name = $employeenumbermaxxarray[0][0];
        }
        //Start Date Manipulation
        $datemonth = changedateformate($date_mincardxpay, 'Y-m');
        $startdate = $datemonth . '-' . '01';
        $enddate = $datemonth . '-' . '15';
        $enddate_ = getlastdayofdate($startdate, 'Y-m-d');
        //End Date Manipulation
        // START HASING AND DATE COPARING
        // START HASING AND DATE COPARING
        $branchcode = explode('$', $branch_startpay);
        $gettimetrans = $this->universal_model->getrangeforfortnight(array('pintwo'), $employeenumberminxarray[0][0], $array_last_name, $branchcode[0], $employmenttype_id);
        $reportarrayone = array();
        foreach ($gettimetrans as $gettimetransvalues) {
            $reportarraytemp = $this->fortnightreport($branchcode[0], $enddate, $enddate_, $gettimetransvalues['pintwo']);
            if (!empty(json_decode($reportarraytemp['time'], true))) {
                array_push($reportarrayone, $reportarraytemp);
            }
        }

        $reportarray = array();
        foreach ($gettimetrans as $gettimetransvalues) {
            $reportarraytemp = $this->universal_model->firstfortnightsingleuser('*', $branchcode[0], $startdate, $enddate, $gettimetransvalues['pintwo']);
            if (!empty($reportarraytemp)) {
                array_push($reportarray, $reportarraytemp[0]);
            }
        }
        $arraysupermerger = array_merge($reportarray, $reportarrayone);
        $output = array_reduce($arraysupermerger, function (array $carry, array $item) {
            $city = $item['pinnumber'];
            if (array_key_exists($city, $carry)) {
                $carry[$city]['nssf'] += $item['nssf'];
                $carry[$city]['nhif'] += $item['nhif'];
                $carry[$city]['paye'] += $item['paye'];
                $carry[$city]['maxidate'] = $item['maxidate'];
                $carry[$city]['gross'] += $item['gross'];
                $carry[$city]['days'] += $item['days'];
                $carry[$city]['otherallow'] += $item['otherallow'];
                $carry[$city]['sacco'] += $item['sacco'];
                $carry[$city]['advanceddeduction'] += $item['advanceddeduction'];
                $carry[$city]['lunch'] += $item['lunch'];
                $carry[$city]['loan'] += $item['loan'];
                $carry[$city]['totalremoved'] += $item['totalremoved'];
                $carry[$city]['totalremain'] += $item['totalremain'];
                $carry[$city]['time'] = $this->combinetime($carry [$city] ['time'], $item ['time']);
//                        // CreatedArrays Virtual
            } else {
                // print_array($item);
                $carry[$city] = $item;
                // CreatedArrays Virtual
            }
            return $carry;
        }, array());
        $arraam = array_values($output);
//        print_array($arraam);
        if (empty($arraam)) {
            $json_return = array(
                'report' => "No Data Found  in this Range " . $date_mincardxpay . ' to ' . $date_maxncardxpay,
                'status' => 0
            );
            echo json_encode($json_return);
        } else {
            $json_return = array(
                'report' => "Range " . 'between ' . $date_mincardxpay . ' to ' . $date_maxncardxpay . ' loaded',
                'status' => 1,
                'data' => $this->generatereportsliptsum($arraam, $date_mincardxpay, $branchcode[0], $employmenttype_id)
            );
            echo json_encode($json_return);
        }
    }

    public function combinetime($arrattimeone, $arraytimetwo) {
        $mergeone = json_decode($arrattimeone, true);
        $mergetwo = json_decode($arraytimetwo, true);
        $mergeredarray = array_merge($mergeone, $mergetwo);
        return json_encode($mergeredarray);
    }

    public function loadpayslip_m() {
        $branch_startpay = "AIOR181260496$28338402 Update Update@33332876 Update Update@36890060 Update Update@8888 Update Update@ALEX MACHARIA KAMAU@ALEX MUCHUI MWILARIA@ALEX MWANGI MUNGA@ALFABIZ Update Update@ALFRED NJERU NJERU@ANTHONY MUNG'AA Update@ANTHONY NJERU NYAGA@BENJAMIN MAITHYA Update@BENSON GICOBI KINYUA@BENSON MACHARIA MWANGI@BONFACE MACHARIA CHOMBA@BONFACE MUTISYA MULI@BRIAN  LUKA MUSYOKI@BRIAN MURIITHI MWANIKI@CAROLINE KARIMI NDEGWA@CAROLINE WANJIKU NYAGA@CHARLES MACHARIA NJERU@CHRISTOPHER NJUE KIURA@DANIEL MUTHOKA MUTHAMA@DANIEL NJOROGE DANIEL @DAVID KAVITA MUTISYA@DEBORAH MUTHONI MWANIKI@DENNIS MARANGA DENNIS @DENNIS MURIUKI MUGENDI@DOROTHY NJOKI KINYUA@ECTOR  NYAMASYO MULIRO@ERIC KARIUKI Update@ERIC NJAGI KARIUKI@ESTHER WAMBUI MWANGI@ESTHER WANJIRU KARIUKI@FAITH WAIRIMU MUCHIRI@FELIX KELI WAMBUA@FRANK MAINA MWANIKI@HARUN WAFULA KILUYI@HELEN GATHONI NJERI@HELLEN NYAMBURA WANJUKI@JACKLINE GATWIRI NYAGA@JACKLYNE MUKAMI NYAGA@JACOB KABURU MWIRIGI@JACOB KATANA MURAMBA@JACOB MAINA JACOB @JAIRUS SIMIYU MUKHUWANA@JAMES MACHARIA NGANGA@JAMES MUTHOMI RUGENDO@JOHN  KAMAU KAMAU@JOHN KIGACA MWITI@JOHN MWANGI CHIURU@JOSEPH KIBE Update@JOSEPH KIMANZI MUTUA@JOSEPH MWANGI NJOROGE@JOSEPH SILA MUTHINI@KELLY MOLLY WANJIRU@KELVIN GICHERU KELVIN @KELVIN THADI MAINA@KENNEDY GATHUNGU Update@KENNEDY WACHIRA MWANIKI@KEVIN WANJALA SIMIYU@LUCY NDEGI NGONDI@LUCY WAIRIMU MUCHIRI@MARTHA WAIRIMU MUTHONI@MARY KANG'ETHE MUTHONI@MLEWA CHARO KENGA@MOSES FUNDI NTHIGA@NANCY NJOKI GACHOKI@NAOMI KAMAU NJERI@NICHODEMAS MUCHIRI MUCHIRI@NICHOLUS MURIITHI Update@PATRICK  MURIU NDIRANGU @PURITY MUNYI RUGURU@ROSALIA MWIKALI MUEMA@ROSE MAKENA MUTHURI@SAMUEL MUCHINA KARANJA@SHEDRACK KYUMA KYULA@STELLA RWAMBA MUGO@STEPHEN  MULEI MUSAU @STEPHEN MUHIA KIGOMO@SUSAN WANJIKU GITAHI@TEST TEST EMPLOYEE@TIMOTHY MUTUA MUNYI@TITUS MUYA MATIVO@VICTOR  MUTWIRI @VICTORIA KARIMI NTHIGA@VINCENT MWANGI WANJOHI@VIRGINIA MUMBI Update@WANGILA GLIFFITH Update@WILSON NYINGI MUIGA@WINFRED WANGECHI WINFRED $28338402@33332876@36890060@8888@32395961@31494080@26870033@21998393@22799059@31782840@28976259@35371213@33382197@29593774@35270408@29618502@30483645@34152464@37043398@26526119@30881577@30538685@12710146@31044476@28424937@36965588@36108821@30076962@25298516@34505323@31391811@32478609@30099022@34611665@34180765@28684579@33818963@31947068@29903503@29661710@31286700@29800188@31767405@24548016@30477738@26766486@22058864@32123574@33148163@31076286@27710883@28914190@30325701@30541122@34943446@35160880@35067162@30097798@31504823@35190571@34166159@11151913@34158127@34157117@29418871@23375217@30125465@35190472@27369208@36537119@33276729@28805957@32514914@31438799@33194288@33220814@33702770@34269022@31749493@36564916@24459604@9999999@36836487@30901922@35236923@26150838@26349502@35781314@27030310@29349807@36499439";
        $date_mincardxpay = "2019-06-01";
        $date_maxncardxpay = "2019-06-15";
        $employeenumberminxpay = "ALEX MACHARIA KAMAU|32395961";
        $employeenumbermaxxpay = "INFRED WANGECHI WINFRED |36499439";
        $employmenttype_id = 1;

        echo json_encode($_POST);
    }

    public function loadpayslip() {
        //DUMMY TWO START
//        $branch_startpay = "AIOR181260496$28338402 Update Update@33332876 Update Update@36890060 Update Update@8888 Update Update@ALEX MACHARIA KAMAU@ALEX MUCHUI MWILARIA@ALEX MWANGI MUNGA@ALFABIZ Update Update@ALFRED NJERU NJERU@ANTHONY MUNG'AA Update@ANTHONY NJERU NYAGA@BENJAMIN MAITHYA Update@BENSON GICOBI KINYUA@BENSON MACHARIA MWANGI@BONFACE MACHARIA CHOMBA@BONFACE MUTISYA MULI@BRIAN  LUKA MUSYOKI@BRIAN MURIITHI MWANIKI@CAROLINE KARIMI NDEGWA@CAROLINE WANJIKU NYAGA@CHARLES MACHARIA NJERU@CHRISTOPHER NJUE KIURA@DANIEL MUTHOKA MUTHAMA@DANIEL NJOROGE DANIEL @DAVID KAVITA MUTISYA@DEBORAH MUTHONI MWANIKI@DENNIS MARANGA DENNIS @DENNIS MURIUKI MUGENDI@DOROTHY NJOKI KINYUA@ECTOR  NYAMASYO MULIRO@ERIC KARIUKI Update@ERIC NJAGI KARIUKI@ESTHER WAMBUI MWANGI@ESTHER WANJIRU KARIUKI@FAITH WAIRIMU MUCHIRI@FELIX KELI WAMBUA@FRANK MAINA MWANIKI@HARUN WAFULA KILUYI@HELEN GATHONI NJERI@HELLEN NYAMBURA WANJUKI@JACKLINE GATWIRI NYAGA@JACKLYNE MUKAMI NYAGA@JACOB KABURU MWIRIGI@JACOB KATANA MURAMBA@JACOB MAINA JACOB @JAIRUS SIMIYU MUKHUWANA@JAMES MACHARIA NGANGA@JAMES MUTHOMI RUGENDO@JOHN  KAMAU KAMAU@JOHN KIGACA MWITI@JOHN MWANGI CHIURU@JOSEPH KIBE Update@JOSEPH KIMANZI MUTUA@JOSEPH MWANGI NJOROGE@JOSEPH SILA MUTHINI@KELLY MOLLY WANJIRU@KELVIN GICHERU KELVIN @KELVIN THADI MAINA@KENNEDY GATHUNGU Update@KENNEDY WACHIRA MWANIKI@KEVIN WANJALA SIMIYU@LUCY NDEGI NGONDI@LUCY WAIRIMU MUCHIRI@MARTHA WAIRIMU MUTHONI@MARY KANG'ETHE MUTHONI@MLEWA CHARO KENGA@MOSES FUNDI NTHIGA@NANCY NJOKI GACHOKI@NAOMI KAMAU NJERI@NICHODEMAS MUCHIRI MUCHIRI@NICHOLUS MURIITHI Update@PATRICK  MURIU NDIRANGU @PURITY MUNYI RUGURU@ROSALIA MWIKALI MUEMA@ROSE MAKENA MUTHURI@SAMUEL MUCHINA KARANJA@SHEDRACK KYUMA KYULA@STELLA RWAMBA MUGO@STEPHEN  MULEI MUSAU @STEPHEN MUHIA KIGOMO@SUSAN WANJIKU GITAHI@TEST TEST EMPLOYEE@TIMOTHY MUTUA MUNYI@TITUS MUYA MATIVO@VICTOR  MUTWIRI @VICTORIA KARIMI NTHIGA@VINCENT MWANGI WANJOHI@VIRGINIA MUMBI Update@WANGILA GLIFFITH Update@WILSON NYINGI MUIGA@WINFRED WANGECHI WINFRED $28338402@33332876@36890060@8888@32395961@31494080@26870033@21998393@22799059@31782840@28976259@35371213@33382197@29593774@35270408@29618502@30483645@34152464@37043398@26526119@30881577@30538685@12710146@31044476@28424937@36965588@36108821@30076962@25298516@34505323@31391811@32478609@30099022@34611665@34180765@28684579@33818963@31947068@29903503@29661710@31286700@29800188@31767405@24548016@30477738@26766486@22058864@32123574@33148163@31076286@27710883@28914190@30325701@30541122@34943446@35160880@35067162@30097798@31504823@35190571@34166159@11151913@34158127@34157117@29418871@23375217@30125465@35190472@27369208@36537119@33276729@28805957@32514914@31438799@33194288@33220814@33702770@34269022@31749493@36564916@24459604@9999999@36836487@30901922@35236923@26150838@26349502@35781314@27030310@29349807@36499439";
//        $date_mincardxpay = "2019-06-01";
//        $date_maxncardxpay = "2019-06-15";
//        $employeenumberminxpay = "ALEX MACHARIA KAMAU|32395961";
//        $employeenumbermaxxpay = "INFRED WANGECHI WINFRED |36499439";
//        $employmenttype_id = 1;
        //DUMMY TWO END
//        $branch_startpay = "AIOR181260318$23317223@27896398@28149957@29032835@29084758@29758714@30009479@30577023@30752145@30757481@31363604@33998587@34077392@34755722@35550396@35776790@6270758@ALICE WANGARI@ALIMA ADEN MARE@ANDREW GITHAIGA KAMUNYA@ANTHONY KINYUA@ANTHONY MWAMBU@BENSON KIPCHIRCHIR@BETH MWENDWA@CATHERINE NUNGARI@CEPHAS MULILI KITETU@CHRISTINE NGATIA@CHRISTOPHER GITAHI@CLEOPHER MWANGI@COLLINS OMONDI@CONSOLATA NYAMBURA@CONSTANCE MUDONYI@DANIEL MAINGI@DAVID MUNIU@DENNIS MWASI@DENNIS NJOROGE@DOMINIC KITHOME@DOMINIC MUNZAA@EDITH MUMBI@EDWIN MUTAHI@ELIZABETH WANJIRU@EMMANUEL KIPNGENO@ERIC MUCHANGI@EUNICE MUCHOKI@EUNICE WANJIKU GAKUYA@EVANS MWANGI@EVANS WAMBWILE@FRED NJUGUNA@FRIDAH GAKII@GASPER GATHECHA@GEORGE KINYANJUI@GEORGE MWANGI@GIBSON THEURI@GRACE KILASARA@HEZRON BUNDI@IAN KIMANI@IRENE NDUNGE@ISAAC WARURU@JAMES MUTHOKA@JAMES NDEGWA@JANE KAROKI@JANE WANGUI KAROKI@JAPHETH MUSYOKI@JENNIFFER WAITHIRA@JOAN NJERI@JOHN MAINA@JOHN MUYESU@JOHN NJOROGE@JOHN NJUGUNA@JORAM MUHIA@JOSEPH KIGO@JOSEPH NJUGUNA@JULIUS MWANGI@KELVINS ASHION@KENNEDY MWANGI@KENNETH KIPKEMOI@LUCY NJERI@MARIA NJOKI MWAURA@MARTHA KAVATA@MARYGRACE WANJIRU@MARYLYN OMONDI@MAUREEN MILGO@MAUREEN NYAMBURA@METRINE NAFULA@MICHAEL KURIA@MICHAEL SILA@MONICAH WAKARIMA@MUTUA MUTEMI@NAHASHON KARIUKI@NELSON CHERUIYOT@NELSON MACHARIA@NIMROD KIHIU@PATRICK KABUTHA@PATRICK NDAMBUKI@PATRICK NJOGU MUIRURI@PAUL NDIRANGU@PETER MAKALI MUTUA@PETER MUTUA@PETERSON WANJAU@PYHLIS NYABELA@REUBEN MWANGI@ROSELINDA ALOO OCHANGO@RUTH WACU@SAMUEL KIMATHI@SAMUEL MURIITHI@SAMUEL NJUGUNA@SIFIRA NJERI WANJIRU@SIMON ODORO@STEPHEN MAINA@STEPHEN MWANGI@STEPHEN MWAURA@STEPHEN NGANGA@SUSAN WANJIRU@TABITHA WAENI@TERESIA GACHUMA@TERESIA MUKUI KIOKO@TITUS MUNYOKI@WALTER EVANSON NJUGUNA@WILSON KURIA@ZAVERIOUS DIEMA$23317223@27896398@28149957@29032835@29084758@29758714@30009479@30577023@30752145@30757481@31363604@33998587@34077392@34755722@35550396@35776790@6270758@30450344@14188913@22324308@23645812@24702590@30239108@29467545@24164182@31037402@35530993@23040770@32247700@37146133@31008131@22538550@25199564@23320167@25690395@32392973@28951887@27383652@29862170@30125451@26627407@29706656@31891878@33817015@31400981@30782345@28317223@34024916@25221951@20908006@32484430@32158530@24491108@27532859@28516302@34262196@28705280@29294941@33823429@36373026@32537352@2537352@27865598@34484338@33882523@33358128@33624352@28246181@33668930@33027920@34930579@28838626@21973782@24486453@31911854@36887539@29466252@27760720@32986080@23983137@32229621@32497185@33825300@32241489@33302358@23744898@34912384@25792831@27771420@32391045@33166688@24384079@28584260@36197022@22377284@31306191@14522654@27067791@28948866@22630830@24569753@21600415@27896388@32271291@33776401@34227112@34505869@30407307@9381282@30198692@23084332@27860653@31554378@31088682@26378936@22592526@22197141@13675538@28351268@24046435";
//        $date_maxncardxpay = "2019-05-31";
//        $date_mincardxpay = "2019-05-16";
//        $employeenumbermaxxpay = "ZAVERIOUS DIEMA|24046435";
//        $employeenumberminxpay = "ALICE WANGARI|30450344";
//        $employmenttype_id = 1;
//        DUMMY ABOVE
        $branch_startpay = $this->input->post('branch_startpay');
        $date_maxncardxpay = $this->input->post('date_maxncardxpay');
        $date_mincardxpay = $this->input->post('date_mincardxpay');
        $employeenumbermaxxpay = $this->input->post('employeenumbermaxxpay');
        $employeenumberminxpay = $this->input->post('employeenumberminxpay');
        $employmenttype_id = $this->input->post('employmenttype_id');
        // PROCESS
        $employeenumberminxarray = explode('|', $employeenumberminxpay);
        $employeenumbermaxxarray = explode('|', $employeenumbermaxxpay);
        $array_last_name = 0;
        if ($employeenumbermaxxarray[0] != '') {
            $array_last_name = $employeenumbermaxxarray[0][0];
        }
        // START HASING AND DATE COPARING
        $mindate = date('jS', strtotime($date_mincardxpay));
        $maxdate = date('jS', strtotime($date_maxncardxpay));
        // START HASING AND DATE COPARING
        $branchcode = explode('$', $branch_startpay);
        $reportarray = array();
        $rage = getDatesFromRange($date_mincardxpay, $date_maxncardxpay);
        if (count($rage) > 16) {
            $reportarray = array();
            $state = 1;
        } else {
            $gettimetrans = $this->universal_model->getrangeforfortnight(array('pintwo'), $employeenumberminxarray[0][0], $array_last_name, $branchcode[0], $employmenttype_id);
            foreach ($gettimetrans as $gettimetransvalues) {
                $reportarraytemp = $this->fortnightreport($branchcode[0], $date_mincardxpay, $date_maxncardxpay, $gettimetransvalues['pintwo']);
                if (!empty(json_decode($reportarraytemp['time'], true))) {
                    if ($mindate == '1st' && $maxdate == '15th') {
//                    $this->db->empty_table('payfortnight');
                        $this->universal_model->updateOnDuplicate('payfortnight', $reportarraytemp);
                    }
                    array_push($reportarray, $reportarraytemp);
                }
            }
            $state = 2;
        }
        // print_array($reportarray);
        if (empty($reportarray)) {
            if ($state == 2) {
                $report = "No Data Found  in this Range " . $date_mincardxpay . ' to ' . $date_maxncardxpay;
            }
            if ($state == 1) {
                $report = "Fortnight Maximum Days Are 16";
            }
            $json_return = array(
                'report' => $report,
                'status' => 0
            );
            echo json_encode($json_return);
        } else {
//            $this->session->mark_as_temp(array(
//                'mindate' => $date_mincardxpay
//            ));
            $json_return = array(
                'report' => "Range " . 'between ' . $date_mincardxpay . ' to ' . $date_maxncardxpay . ' loaded',
                'status' => 1,
                'data' => $this->generatereportsliptablehtml($reportarray, $date_mincardxpay, $date_maxncardxpay, $branchcode[0], $employmenttype_id)
            );
            echo json_encode($json_return);
        }
    }

    public function getdaterangechosen($startcountdate, $datefromnow) {
        $daterange = getDatesFromRange($startcountdate, $datefromnow);
        $varone = $this->rowwidths($startcountdate, $datefromnow);
        $vartwo = $this->rowwidthstwo($startcountdate, $datefromnow);
        $main_array = array();
        $main_array['daterange'] = $daterange;
        $main_array['datename'] = $varone;
        $main_array['dateabv'] = $vartwo;
        return $main_array;
        // return json_encode($daterange) . '@' . json_encode($varone,true) . '@' . json_encode($vartwo);
    }

    public function rowwidthstwo($date_from_fot, $date_to_fot) {
        $my_dates = getDatesFromRange($date_from_fot, $date_to_fot);
        $clomun_headertwo = array();
        foreach ($my_dates as $date_value) {
            array_push($clomun_headertwo, date('jS', strtotime($date_value)));
        }
        return $clomun_headertwo;
    }

    function rowwidths($date_from_fot, $date_to_fot) {
        $my_dates = getDatesFromRange($date_from_fot, $date_to_fot);
        $clomun_headertwo = array();
        foreach ($my_dates as $date_value) {
            array_push($clomun_headertwo, date('D', strtotime($date_value)));
        }
        return $clomun_headertwo;
    }

    function generatereportslip($arraydata, $dateone, $datetwo) {
        // function loaddata() {
        // header('Access-Control-Allow-Origin: *');
        $_GET['db_tablename'] = 'payfortnight';
        $user_id = $this->session->userdata('logged_in')['user_id'];
        $grid = new EditableGrid();
        $grid->addColumn('pinnumber', 'EMPO NO', 'integer', NULL, false);
        $grid->addColumn('names', 'NAMES', 'string(50)');
        $days = $this->getdaterangechosen($dateone, $datetwo)['dateabv'];
        $daterange = $this->getdaterangechosen($dateone, $datetwo)['daterange'];
        foreach ($days as $key => $value) {
            // $dayname = 'datetime' . $key;
            $grid->addColumn($daterange[$key], $value, 'double(1)');
        }
        $grid->addColumn('gross', 'GROSS', 'double(h, 1)', NULL, false);
        $grid->addColumn('paye', 'PAYE', 'double(h, 1)', NULL, false);
        $grid->addColumn('nssf', 'NSSF', 'double(h, 1)', NULL, false);
        $grid->addColumn('nhif', 'NHIF', 'double(h, 1)', NULL, false);
        $grid->addColumn('action', 'Action', 'html', NULL, false, 'id');
        $result = $this->dataprocess($arraydata, $dateone, $datetwo);
        $grid->renderJSON($result, false, false, !isset($_GET['data_only']));
    }

    function dataprocess($arraydata, $dataone, $datetwo) {
        $daterange = $this->getdaterangechosen($dataone, $datetwo)['daterange'];
        $megaarray = array();
        foreach ($arraydata as $value) {

            $arrayx = array();
            $mytimes = $value['time'];
            $timing = json_decode($mytimes, true);
            foreach ($timing as $key => $valuemm) {
                $arrayx[$daterange[$key]] = $valuemm[$daterange[$key]];
            }
            $arrayx['pinnumber'] = $value['pinnumber'];
            $arrayx['names'] = $value['names'];
            $arrayx['gross'] = $value['gross'];
            $arrayx['paye'] = $value['paye'];
            $arrayx['nssf'] = $value['nssf'];
            $arrayx['nhif'] = $value['nhif'];
            array_push($megaarray, $arrayx);
        }
        // print_array($arrayx);
        return $megaarray;
    }

    // For Summerised
    function generatereportsacco($arraydata, $dateone, $branch, $employtype) {
//        http://htmlhelp.com/reference/html40/tables/thead.html
        $template = array(
            'table_open' => '<table class="table table-striped table-hover" id="payslipcardsacco">',
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
        $branchname = $this->universal_model->selectz(array('branchname'), 'util_branch_reader', 'readerserial', $branch)[0]['branchname'];
        $printernames = $this->universal_model->selectz(array('firstname', 'lastname'), 'users', 'user_id', $this->session->userdata('logged_in') ['user_id'])[0];
        $this->table->set_template($template);
        $theoneheader = '<THEAD>
    <TR>
      <TH SCOPE=colgroup COLSPAN="100%"><font size="5" color="green">ASL TRADING - ' . $this->universal_model->selectz(array('employementtype'), 'employementtypes', 'id', $employtype)[0]['employementtype'] . ' STAFF</font></TH>
    </TR>
    <TR>
      <TH SCOPE=colgroup COLSPAN="100%"><font size="4">SACCO REPORT ' . date_format(date_create($dateone), "F, Y") . '</font></TH>
    </TR>
    <TR>
      <TH SCOPE=colgroup COLSPAN="5%">Printed On: <b>' . date("d/m/Y") . '</b></TH>
      <TH SCOPE=colgroup COLSPAN="15%" style="text-align:right;">END OF MONTH REPORT BRANCH:<b>' . $branchname . '</b></TH>
    </TR>
    <TR>
      <TH SCOPE=colgroup COLSPAN="2%">Printed Time: <b>' . date("h:i:s") . '</b></TH>
      <TH SCOPE=colgroup COLSPAN="4%">PAYROLL LEDGER [Casuals]</TH>
      <TH SCOPE=colgroup COLSPAN="15%" style="text-align:right;">Printed By: <b>' . $printernames['firstname'] . ' ' . $printernames['lastname'] . '</b></TH>
    </TR>
    <TR>
      <TH SCOPE=col COLSPAN=2>EMPLOYEE NO</TH>
      <TH SCOPE=col COLSPAN=2>USER PIN</TH>
      <TH SCOPE=col COLSPAN=2>NAMES</TH>
      <TH SCOPE=col COLSPAN=2>AMOUNT</TH>
    </TR>
  </THEAD>';
//        $this->table->set_heading('<h1>ASL TRADING - CASUALS STAFF</h1>');
        $this->table->add_row($theoneheader);
        $cumlativesacco = 0;
        $employess = 0;
        foreach ($arraydata as $reportdata) {
            $employess += 1;
            if ($reportdata['employee_code'] == '') {
                $reportdata['employee_code'] = 'XXXX';
            }
            $employee_code = array(
                'data' => $reportdata['employee_code'],
                'colspan' => 2
            );
            $pin = array(
                'data' => $reportdata['pinnumber'],
                'colspan' => 2
            );
            $names = array(
                'data' => $reportdata['names'],
                'colspan' => 2
            );

            $sacco = array(
                'data' => $reportdata['sacco'],
                'colspan' => 2
            );
            $cumlativesacco += $reportdata['lunch'];
            $this->table->add_row($employee_code, $pin, $names, $sacco);
        }
        $cell2 = array(
            'data' => '<b>NO. OF EMPLOYEES ON SACCO :</b>',
            'class' => ' info',
            'colspan' => 2
        );
        $employesn = array(
            'data' => '<b>' . $employess . '</b>',
            'colspan' => 2
        );
        $totals = array(
            'data' => '<b>TOTALS</b>',
            'class' => ' info',
            'colspan' => 2
        );
        $cumlativesaccototal = array(
            'data' => $cumlativesacco,
            'colspan' => 2
        );
        $space = array(
            'data' => '',
            'colspan' => 2
        );
        $this->table->add_row($cell2, $employesn);
        $this->table->add_row($space, $space, $totals, $cumlativesaccototal);
        // $this->getdaterangechosen($startcountdate, $datefromnow);
        return $this->table->generate();
    }

    function generatereportlunch($arraydata, $dateone, $branch, $employtype) {
//        http://htmlhelp.com/reference/html40/tables/thead.html
        $template = array(
            'table_open' => '<table class="table table-striped table-hover" id="payslipcardlunch">',
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
        $branchname = $this->universal_model->selectz(array('branchname'), 'util_branch_reader', 'readerserial', $branch)[0]['branchname'];
        $printernames = $this->universal_model->selectz(array('firstname', 'lastname'), 'users', 'user_id', $this->session->userdata('logged_in') ['user_id'])[0];
        $this->table->set_template($template);
        $theoneheader = '<THEAD>
    <TR>
      <TH SCOPE=colgroup COLSPAN="100%"><font size="5" color="green">ASL TRADING - ' . $this->universal_model->selectz(array('employementtype'), 'employementtypes', 'id', $employtype)[0]['employementtype'] . ' STAFF</font></TH>
    </TR>
    <TR>
      <TH SCOPE=colgroup COLSPAN="100%"><font size="4">LUNCH REPORT ' . date_format(date_create($dateone), "F, Y") . '</font></TH>
    </TR>
    <TR>
      <TH SCOPE=colgroup COLSPAN="5%">Printed On: <b>' . date("d/m/Y") . '</b></TH>
      <TH SCOPE=colgroup COLSPAN="15%" style="text-align:right;">END OF MONTH REPORT BRANCH:<b>' . $branchname . '</b></TH>
    </TR>
    <TR>
      <TH SCOPE=colgroup COLSPAN="2%">Printed Time: <b>' . date("h:i:s") . '</b></TH>
      <TH SCOPE=colgroup COLSPAN="4%">PAYROLL LEDGER [Casuals]</TH>
      <TH SCOPE=colgroup COLSPAN="15%" style="text-align:right;">Printed By: <b>' . $printernames['firstname'] . ' ' . $printernames['lastname'] . '</b></TH>
    </TR>
    <TR>
      <TH SCOPE=col COLSPAN=2>EMPLOYEE NO</TH>
      <TH SCOPE=col COLSPAN=2>NAMES</TH>
      <TH SCOPE=col COLSPAN=2>DAYS</TH>
      <TH SCOPE=col COLSPAN=2>LUNCH RATE</TH>
      <TH SCOPE=col COLSPAN=2>LUNCH AMOUNT</TH>
    </TR>
  </THEAD>';
//        $this->table->set_heading('<h1>ASL TRADING - CASUALS STAFF</h1>');
        $this->table->add_row($theoneheader);
        $cumlativelunch = 0;
        $employess = 0;
        foreach ($arraydata as $reportdata) {
            $employess += 1;
            if ($reportdata['employee_code'] == '') {
                $reportdata['employee_code'] = 'XXXX';
            }
            if ($reportdata['nhifnumber'] == '') {
                $reportdata['nhifnumber'] = 'XXXX';
            }
            $employee_code = array(
                'data' => $reportdata['employee_code'],
                'colspan' => 2
            );
            $names = array(
                'data' => $reportdata['names'],
                'colspan' => 2
            );
            $days = array(
                'data' => $reportdata['days'],
                'colspan' => 2
            );
            $lunchamount = array(
                'data' => $reportdata['lunchamount'],
                'colspan' => 2
            );
            $cumlativelunch += $reportdata['lunch'];
            $lunch = array(
                'data' => $reportdata['lunch'],
                'colspan' => 2
            );

            $this->table->add_row($employee_code, $names, $days, $lunchamount, $lunch);
        }
        $cell2 = array(
            'data' => '<b>NO. OF EMPLOYEES ON LUNCH :</b>',
            'class' => ' info',
            'colspan' => 2
        );
        $employesn = array(
            'data' => '<b>' . $employess . '</b>',
            'colspan' => 2
        );
        $totals = array(
            'data' => '<b>TOTALS</b>',
            'class' => ' info',
            'colspan' => 2
        );
        $cumlativelunchtotal = array(
            'data' => $cumlativelunch,
            'colspan' => 2
        );
        $space = array(
            'data' => '',
            'colspan' => 2
        );
        $this->table->add_row($cell2, $employesn);
        $this->table->add_row($space, $space, $space, $totals, $cumlativelunchtotal);
        // $this->getdaterangechosen($startcountdate, $datefromnow);
        return $this->table->generate();
    }

    function generatereportnhif($arraydata, $dateone, $branch, $employtype) {
//        http://htmlhelp.com/reference/html40/tables/thead.html
        $template = array(
            'table_open' => '<table class="table table-striped table-hover" id="payslipcardnhif">',
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
        $branchname = $this->universal_model->selectz(array('branchname'), 'util_branch_reader', 'readerserial', $branch)[0]['branchname'];
        $printernames = $this->universal_model->selectz(array('firstname', 'lastname'), 'users', 'user_id', $this->session->userdata('logged_in') ['user_id'])[0];
        $this->table->set_template($template);
        $theoneheader = '<THEAD>
    <TR>
      <TH SCOPE=colgroup COLSPAN="100%"><font size="5" color="green">ASL TRADING - ' . $this->universal_model->selectz(array('employementtype'), 'employementtypes', 'id', $employtype)[0]['employementtype'] . ' STAFF</font></TH>
    </TR>
    <TR>
      <TH SCOPE=colgroup COLSPAN="100%"><font size="4">NHIF REPORT ' . date_format(date_create($dateone), "F, Y") . '</font></TH>
    </TR>
    <TR>
      <TH SCOPE=colgroup COLSPAN="5%">Printed On: <b>' . date("d/m/Y") . '</b></TH>
      <TH SCOPE=colgroup COLSPAN="15%" style="text-align:right;">END OF MONTH REPORT BRANCH:<b>' . $branchname . '</b></TH>
    </TR>
    <TR>
      <TH SCOPE=colgroup COLSPAN="2%">Printed Time: <b>' . date("h:i:s") . '</b></TH>
      <TH SCOPE=colgroup COLSPAN="4%">PAYROLL LEDGER [Casuals]</TH>
      <TH SCOPE=colgroup COLSPAN="15%" style="text-align:right;">Printed By: <b>' . $printernames['firstname'] . ' ' . $printernames['lastname'] . '</b></TH>
    </TR>
    <TR>
      <TH SCOPE=col COLSPAN=2>EMP NO</TH>
      <TH SCOPE=col COLSPAN=2>NAMES</TH>
       <TH SCOPE=col COLSPAN=2>NHIF NO</TH>
      <TH SCOPE=col COLSPAN=2>ID NO</TH>
      <TH SCOPE=col COLSPAN=2>BIRTH DATE\'S</TH>
      <TH SCOPE=col COLSPAN=2>TOTAL</TH>
    </TR>
  </THEAD>';
//        $this->table->set_heading('<h1>ASL TRADING - CASUALS STAFF</h1>');
        $this->table->add_row($theoneheader);
        $totnhifcumulative = 0;
        $employess = 0;
        foreach ($arraydata as $reportdata) {
            $employess += 1;
            $totnhifcumulative += $reportdata['nhif'];
            if ($reportdata['employee_code'] == '') {
                $reportdata['employee_code'] = 'XXXX';
            }
            if ($reportdata['nhifnumber'] == '') {
                $reportdata['nhifnumber'] = 'XXXX';
            }
            $employee_code = array(
                'data' => $reportdata['employee_code'],
                'colspan' => 2
            );
            $names = array(
                'data' => $reportdata['names'],
                'colspan' => 2
            );
            $nhifnumber = array(
                'data' => $reportdata['nhifnumber'],
                'colspan' => 2
            );
            $nhif = array(
                'data' => $reportdata['nhif'],
                'colspan' => 2
            );
            $id = array(
                'data' => $reportdata['pinnumber'],
                'colspan' => 2
            );
            $dobarray = $this->universal_model->selectz(array('dob'), 'users', 'pin', $reportdata['pinnumber']);
            if (empty($dobarray)) {
                $dob = 'Update';
            } else {
                $dob = $dobarray[count($dobarray) - 1]['dob'];
                if ($dob == '') {
                    $dob = 'Update';
                }
            }
            $databirth = array(
                'data' => $dob,
                'colspan' => 2
            );
            $this->table->add_row($employee_code, $names, $nhifnumber, $id, $databirth, $nhif);
        }
        $cell2 = array(
            'data' => '<b>NO. OF EMPLOYEES ON N.H.I.F:</b>',
            'class' => ' info',
            'colspan' => 2
        );
        $employesn = array(
            'data' => '<b>' . $employess . '</b>',
            'colspan' => 2
        );
        $totals = array(
            'data' => '<b>TOTALS</b>',
            'class' => ' info',
            'colspan' => 2
        );
        $totnssfcumulativev = array(
            'data' => $totnhifcumulative,
            'colspan' => 2
        );
        $space = array(
            'data' => '',
            'colspan' => 2
        );
        $this->table->add_row($cell2, $employesn);
        $this->table->add_row($space, $space, $space, $space, $totals, $totnssfcumulativev);
        // $this->getdaterangechosen($startcountdate, $datefromnow);
        return $this->table->generate();
    }

    function generatereportnssf($arraydata, $dateone, $branch, $employtype) {
//        http://htmlhelp.com/reference/html40/tables/thead.html
        $template = array(
            'table_open' => '<table class="table table-striped table-hover" id="payslipcardnssf">',
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
        $branchname = $this->universal_model->selectz(array('branchname'), 'util_branch_reader', 'readerserial', $branch)[0]['branchname'];
        $printernames = $this->universal_model->selectz(array('firstname', 'lastname'), 'users', 'user_id', $this->session->userdata('logged_in') ['user_id'])[0];
        $this->table->set_template($template);
        $theoneheader = '<THEAD>
    <TR>
      <TH SCOPE=colgroup COLSPAN="100%"><font size="5" color="green">ASL TRADING - ' . $this->universal_model->selectz(array('employementtype'), 'employementtypes', 'id', $employtype)[0]['employementtype'] . ' STAFF</font></TH>
    </TR>
    <TR>
      <TH SCOPE=colgroup COLSPAN="100%"><font size="4">NSSF REPORT ' . date_format(date_create($dateone), "F, Y") . '</font></TH>
    </TR>
    <TR>
      <TH SCOPE=colgroup COLSPAN="5%">Printed On: <b>' . date("d/m/Y") . '</b></TH>
      <TH SCOPE=colgroup COLSPAN="15%" style="text-align:right;">END OF MONTH REPORT BRANCH:<b>' . $branchname . '</b></TH>
    </TR>
    <TR>
      <TH SCOPE=colgroup COLSPAN="2%">Printed Time: <b>' . date("h:i:s") . '</b></TH>
      <TH SCOPE=colgroup COLSPAN="4%">PAYROLL LEDGER [Casuals]</TH>
      <TH SCOPE=colgroup COLSPAN="15%" style="text-align:right;">Printed By: <b>' . $printernames['firstname'] . ' ' . $printernames['lastname'] . '</b></TH>
    </TR>
    <TR>
      <TH SCOPE=col COLSPAN=2>EMP NO</TH>
      <TH SCOPE=col COLSPAN=2>NAMES</TH>
       <TH SCOPE=col COLSPAN=2>NSSF NO</TH>
      <TH SCOPE=col COLSPAN=2>EMPLOYEES</TH>
      <TH SCOPE=col COLSPAN=2>EMPLOYER\'S</TH>
      <TH SCOPE=col COLSPAN=2>TOTAL</TH>
    </TR>
  </THEAD>';
//        $this->table->set_heading('<h1>ASL TRADING - CASUALS STAFF</h1>');
        $this->table->add_row($theoneheader);
        $totnssf = 0;
        $totnssfcumulative = 0;
        $employess = 0;
        foreach ($arraydata as $reportdata) {
            $employess += 1;
            $totnssf = $reportdata['nssf'] * 2;
            $totnssfcumulative += $reportdata['nssf'];
            if ($reportdata['employee_code'] == '') {
                $reportdata['employee_code'] = 'XXXX';
            }
            if ($reportdata['nssfnumber'] == '') {
                $reportdata['nssfnumber'] = 'XXXX';
            }


            $employee_code = array(
                'data' => $reportdata['employee_code'],
                'colspan' => 2
            );
            $names = array(
                'data' => $reportdata['names'],
                'colspan' => 2
            );
            $nssfnumber = array(
                'data' => $reportdata['nssfnumber'],
                'colspan' => 2
            );
            $nssf = array(
                'data' => $reportdata['nssf'],
                'colspan' => 2
            );
            $totnssv = array(
                'data' => $totnssf,
                'colspan' => 2
            );
            $this->table->add_row($employee_code, $names, $nssfnumber, $nssf, $nssf, $totnssv);
        }
        $cell2 = array(
            'data' => '<b>NO. OF EMPLOYEES CONTRIBIUTING N.S.S.F:</b>',
            'class' => ' info',
            'colspan' => 2
        );
        $employesn = array(
            'data' => '<b>' . $employess . '</b>',
            'colspan' => 2
        );
        $totals = array(
            'data' => '<b>TOTALS</b>',
            'class' => ' info',
            'colspan' => 2
        );
        $totnssfcumulativev = array(
            'data' => $totnssfcumulative,
            'colspan' => 2
        );
        $totnssfbesic = array(
            'data' => $totnssfcumulative * 2,
            'colspan' => 2
        );
        $space = array(
            'data' => '',
            'colspan' => 2
        );
        $this->table->add_row($cell2, $employesn);
        $this->table->add_row($space, $space, $totals, $totnssfcumulativev, $totnssfcumulativev, $totnssfbesic);
        // $this->getdaterangechosen($startcountdate, $datefromnow);
        return $this->table->generate();
    }

    function generatereportsliptsum($arraydata, $dateone, $branch, $employtype) {
//        http://htmlhelp.com/reference/html40/tables/thead.html
        $template = array(
            'table_open' => '<table class="table table-striped table-hover" id="payslipcard_attendence_cardsum">',
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
        $branchname = $this->universal_model->selectz(array('branchname'), 'util_branch_reader', 'readerserial', $branch)[0]['branchname'];
        $printernames = $this->universal_model->selectz(array('firstname', 'lastname'), 'users', 'user_id', $this->session->userdata('logged_in') ['user_id'])[0];
        $this->table->set_template($template);
        $theoneheader = '<THEAD>
    <TR>
      <TH SCOPE=colgroup COLSPAN="100%"><font size="5" color="green">ASL TRADING - ' . $this->universal_model->selectz(array('employementtype'), 'employementtypes', 'id', $employtype)[0]['employementtype'] . ' STAFF</font></TH>
    </TR>
    <TR>
      <TH SCOPE=colgroup COLSPAN="100%"><font size="4">WAGE PAYEMENT REPORT FOR ' . date_format(date_create($dateone), "F, Y") . '</font></TH>
    </TR>
    <TR>
      <TH SCOPE=colgroup COLSPAN="5%">Printed On: <b>' . date("d/m/Y") . '</b></TH>
      <TH SCOPE=colgroup COLSPAN="15%" style="text-align:right;">END OF MONTH REPORT BRANCH:<b>' . $branchname . '</b></TH>
    </TR>
    <TR>
      <TH SCOPE=colgroup COLSPAN="2%">Printed Time: <b>' . date("h:i:s") . '</b></TH>
      <TH SCOPE=colgroup COLSPAN="4%">PAYROLL LEDGER [Casuals]</TH>
      <TH SCOPE=colgroup COLSPAN="15%" style="text-align:right;">Printed By: <b>' . $printernames['firstname'] . ' ' . $printernames['lastname'] . '</b></TH>
    </TR>
    <TR>
      <TH SCOPE=col>PIN NO</TH>
      <TH SCOPE=col>NAMES</TH>
      <TH SCOPE=col>RATE</TH>
      <TH SCOPE=col>OTA</TH>
      <TH SCOPE=col>GROSS</TH>
      <TH SCOPE=col>PAYE</TH>
      <TH SCOPE=col>NSSF</TH>
      <TH SCOPE=col>NHIF</TH>
      <TH SCOPE=col>DAYS</TH>
      <TH SCOPE=col>LUNCH</TH>
      <TH SCOPE=col>SACCO</TH>
      <TH SCOPE=col>AD</TH>
      <TH SCOPE=col>LOAN</TH>
      <TH SCOPE=col>TOTD</TH>
      <TH SCOPE=col>TOTAL</TH>
    </TR>
  </THEAD>';
//        $this->table->set_heading('<h1>ASL TRADING - CASUALS STAFF</h1>');
        $this->table->add_row($theoneheader);
        $totalbasic = 0;
        $toa = 0;
        $totloan = 0;
        $totsacco = 0;
        $totnhif = 0;
        $totnssf = 0;
        $totad = 0;
        $totlunch = 0;
        $totpaye = 0;
        $totremoved = 0;
        $totnet = 0;
        $employess = 0;
        foreach ($arraydata as $reportdata) {
            $employess += 1;
            $toa += $reportdata['otherallow'];
            $totalbasic += $reportdata['gross'];
            $totpaye += $reportdata['paye'];
            $totnssf += $reportdata['nssf'];
            $totnhif += $reportdata['nhif'];
            $totlunch += $reportdata['lunch'];
            $totsacco += $reportdata['sacco'];
            $totad += $reportdata['advanceddeduction'];
            $totloan += $reportdata['loan'];
            $totremoved += $reportdata['totalremoved'];
            $totnet += $reportdata['totalremain'];
            $totalcheck = $reportdata['totalremain'];
            if ($totalcheck < 0) {
                $totalcheck = 0;
                $reportdata['totalremain'] = 0;
            }
            $this->table->add_row($reportdata['pinnumber'], $reportdata['names'], 400, $reportdata['otherallow'], $reportdata['gross'], $reportdata['paye'], $reportdata['nssf'], $reportdata['nhif'], $reportdata['days'], $reportdata['lunch'], $reportdata['sacco'], $reportdata['advanceddeduction'], $reportdata['loan'], $reportdata['totalremoved'], $totalcheck);
        }
        $cell2 = array(
            'data' => '<b>NO. OF EMPLOYEES:</b>',
            'class' => ' info',
            'colspan' => 2
        );
        $this->table->add_row($cell2, '<b>' . $employess . '</b>');
        $this->table->add_row("", '<b>TOTALS</b>', "", '<b>' . $toa . '</b>', '<b>' . $totalbasic . '</b>', '<b>' . $totpaye . '</b>', '<b>' . $totnssf . '</b>', '<b>' . $totnhif . '</b>', "", '<b>' . $totlunch . '</b>', '<b>' . $totsacco . '</b>', '<b>' . $totad . '</b>', '<b>' . $totloan . '</b>', '<b>' . $totremoved . '</b>', '<b>' . $totnet . '</b>');
        // $this->getdaterangechosen($startcountdate, $datefromnow);
        return $this->table->generate();
    }

    function generatereportcoinageablehtml($arraydata, $dateone, $datetwo, $branch, $employtype) {
        $maxdate = date('jS', strtotime($datetwo));
        $template = array(
            'table_open' => '<table class="table table-striped table-hover" id="coinagefortnight_card">',
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
        $whichfortnight = "FIRST FOURTNIGHT";
        if ($maxdate != '15th') {
            $whichfortnight = "SECOND FOURTNIGHT BRANCH:";
        }
        $branchname = $this->universal_model->selectz(array('branchname'), 'util_branch_reader', 'readerserial', $branch)[0]['branchname'];
        $printernames = $this->universal_model->selectz(array('firstname', 'lastname'), 'users', 'user_id', $this->session->userdata('logged_in') ['user_id'])[0];
        $name = 'PRINTED BY:' . $printernames['firstname'] . "~" . $printernames['lastname'];
        $one = '<TR><TH SCOPE=colgroup COLSPAN="100%"><font size="5" color="green">ASL TRADING - ' . $this->universal_model->selectz(array('employementtype'), 'employementtypes', 'id', $employtype)[0]['employementtype'] . ' STAFF</font></TH></TR>';
        $oneone = '<TR><TH SCOPE=colgroup COLSPAN="100%"><font size="4" color="brown">COINAGE ANALYSIS REPORT : STORE ' . $this->universal_model->selectz(array('employementtype'), 'employementtypes', 'id', $employtype)[0]['employementtype'] . '</font></TH></TR>';
        $two = '<TR>
      <TH SCOPE=colgroup COLSPAN="7%">Printed On: <b>' . date("d/m/Y") . '</b></TH>
      <TH SCOPE=colgroup COLSPAN="40%"><b style="text-align:right;">' . date_format(date_create($dateone), "F, Y") . ' ' . $whichfortnight . ' BRANCH ' . $branchname . '</b></TH></TR>';
        $four = '<TR><TH COLSPAN="6">Printed Time: <b>' . date("h:i:s") . '</b></TH><TH COLSPAN="15">For Week Str On: <font size="4">' . $dateone . '</font> And End On: <font size="4">' . $datetwo . '</font></TH><TH>' . $name . '</TH></TR>';
        $coinagecountheader = '<TR><TH SCOPE=colgroup COLSPAN=2>PIN NO</TH><TH COLSPAN=2>NAMES</TH><TH COLSPAN=2>Nett</TH><TH COLSPAN=2>1000/=</TH><TH COLSPAN=2>500/=</TH><TH COLSPAN=2>200/=</TH><TH COLSPAN=2>100/=</TH><TH COLSPAN=2>50/=</TH><TH COLSPAN=2>20/=</TH><TH SCOPE=colgroup COLSPAN=2>10/=</TH><TH SCOPE=colgroup COLSPAN=2>5/=</TH><TH SCOPE=colgroup COLSPAN=2>1/=</TH><TH COLSPAN=2>/=50</TH></TR>';
        $headerheader = '<THEAD>' . $one . $oneone . $two . $coinagecountheader . '<THEAD>';
        $this->table->add_row($headerheader);
        $athousandt = 0;
        $fivehundt = 0;
        $twohundredt = 0;
        $hundredt = 0;
        $fiftyt = 0;
        $twentyt = 0;
        $tent = 0;
        $fivet = 0;
        $onet = 0;
        $fiftycentt = 0;
        $nettotal = 0;
        foreach ($arraydata as $reportdata) {
            //START SUMS
            if ($reportdata['totalremain'] < 0) {
                $reportdata['totalremain'] = 0;
            }
            $nettotal += $reportdata['totalremain'];
            $dataacoinage = $this->getcoinage($reportdata['totalremain']);
            $cellspacecellspan = array(
                'data' => $reportdata['pinnumber'],
                // 'class' => 'info'
                // 'style' => "font-size: 15px; color: black; background-color: burlywood;"
                'colspan' => 2
            );
            $cellspacecellspanone = array(
                'data' => $reportdata['names'],
                // 'class' => 'info'
                // 'style' => "font-size: 15px; color: black; background-color: burlywood;"
                'colspan' => 2
            );
            $cellspacecellspantwo = array(
                'data' => $reportdata['totalremain'],
                // 'class' => 'info'
                // 'style' => "font-size: 15px; color: black; background-color: burlywood;"
                'colspan' => 2
            );
            $athousandt += $dataacoinage['athousand'];
            $thousand = array(
                'data' => $dataacoinage['athousand'],
                // 'class' => 'info'
                // 'style' => "font-size: 15px; color: black; background-color: burlywood;"
                'colspan' => 2
            );
            $fivehundt += $dataacoinage['fivehund'];
            $fivehund = array(
                'data' => $dataacoinage['fivehund'],
                // 'class' => 'info'
                // 'style' => "font-size: 15px; color: black; background-color: burlywood;"
                'colspan' => 2
            );
            $twohundredt += $dataacoinage['twohundred'];
            $twohundred = array(
                'data' => $dataacoinage['twohundred'],
                // 'class' => 'info'
                // 'style' => "font-size: 15px; color: black; background-color: burlywood;"
                'colspan' => 2
            );
            $hundredt += $dataacoinage['hundred'];
            $hundred = array(
                'data' => $dataacoinage['hundred'],
                // 'class' => 'info'
                // 'style' => "font-size: 15px; color: black; background-color: burlywood;"
                'colspan' => 2
            );
            $fiftyt += $dataacoinage['fifty'];
            $fifty = array(
                'data' => $dataacoinage['fifty'],
                // 'class' => 'info'
                // 'style' => "font-size: 15px; color: black; background-color: burlywood;"
                'colspan' => 2
            );
            $twentyt += $dataacoinage['twenty'];
            $twenty = array(
                'data' => $dataacoinage['twenty'],
                // 'class' => 'info'
                // 'style' => "font-size: 15px; color: black; background-color: burlywood;"
                'colspan' => 2
            );
            $tent += $dataacoinage['ten'];
            $ten = array(
                'data' => $dataacoinage['ten'],
                // 'class' => 'info'
                // 'style' => "font-size: 15px; color: black; background-color: burlywood;"
                'colspan' => 2
            );
            $fivet += $dataacoinage['five'];
            $five = array(
                'data' => $dataacoinage['five'],
                // 'class' => 'info'
                // 'style' => "font-size: 15px; color: black; background-color: burlywood;"
                'colspan' => 2
            );
            $onet += $dataacoinage['one'];
            $one = array(
                'data' => $dataacoinage['one'],
                // 'class' => 'info'
                // 'style' => "font-size: 15px; color: black; background-color: burlywood;"
                'colspan' => 2
            );
            $fiftycentt += $dataacoinage['fiftycent'];
            $fiftycent = array(
                'data' => $dataacoinage['fiftycent'],
                // 'class' => 'info'
                // 'style' => "font-size: 15px; color: black; background-color: burlywood;"
                'colspan' => 2
            );
            $this->table->add_row($cellspacecellspan, $cellspacecellspanone, $cellspacecellspantwo, $thousand, $fivehund, $twohundred, $hundred, $fifty, $twenty, $ten, $five, $one, $fiftycent);
        }
        $space = array(
            'data' => '',
            // 'class' => 'info'
            // 'style' => "font-size: 15px; color: black; background-color: burlywood;"
            'colspan' => 2
        );
        $grandtotal = array(
            'data' => 'GRAND TOTAL',
            // 'class' => 'info'
            'style' => "font-size: 15px; color: black; background-color: burlywood;",
            'colspan' => 2
        );
        $nettotalv = array(
            'data' => $nettotal,
            // 'class' => 'info'
            'colspan' => 2
        );
        $athousandv = array(
            'data' => $athousandt,
            // 'class' => 'info'
            'colspan' => 2
        );
        $fivehundv = array(
            'data' => $fivehundt,
            // 'class' => 'info'
            'colspan' => 2
        );
        $twohundredv = array(
            'data' => $twohundredt,
            // 'class' => 'info'
            'colspan' => 2
        );
        $hundredv = array(
            'data' => $hundredt,
            // 'class' => 'info'
            'colspan' => 2
        );
        $fiftyv = array(
            'data' => $fiftyt,
            // 'class' => 'info'
            'colspan' => 2
        );
        $twentyv = array(
            'data' => $twentyt,
            // 'class' => 'info'
            'colspan' => 2
        );
        $tenv = array(
            'data' => $tent,
            // 'class' => 'info'
            'colspan' => 2
        );
        $fivev = array(
            'data' => $fivet,
            // 'class' => 'info'
            'colspan' => 2
        );
        $onev = array(
            'data' => $onet,
            // 'class' => 'info'
            'colspan' => 2
        );
        $fiftycentv = array(
            'data' => $fiftycentt,
            // 'class' => 'info'
            'colspan' => 2
        );
        $this->table->add_row($grandtotal, $space, $nettotalv, $athousandv, $fivehundv, $twohundredv, $hundredv, $fiftyv, $twentyv, $tenv, $fivev, $onev, $fiftycentv);
        $this->table->add_row('<b>NO OF EMPLOYEES PAID</b>', '<b>' . count($arraydata) . '</b>', $space, $space, $space, $space, $space, $space, $space, $space, $space, $space);
        // $this->getdaterangechosen($startcountdate, $datefromnow);
        return $this->table->generate();
    }

    function generatereportsliptablehtml($arraydata, $dateone, $datetwo, $branch, $employtype) {
        $maxdate = date('jS', strtotime($datetwo));
        $template = array(
            'table_open' => '<table class="table table-striped table-hover" id="payslipcard_attendence_card">',
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
        $whichfortnight = "FIRST FOURTNIGHT";
        if ($maxdate != '15th') {
            $whichfortnight = "SECOND FOURTNIGHT BRANCH:";
        }
        $daterange = getDatesFromRange($dateone, $datetwo);
        $branchname = $this->universal_model->selectz(array('branchname'), 'util_branch_reader', 'readerserial', $branch)[0]['branchname'];
        $printernames = $this->universal_model->selectz(array('firstname', 'lastname'), 'users', 'user_id', $this->session->userdata('logged_in') ['user_id'])[0];
        $name = 'PRINTED BY:' . $printernames['firstname'] . "~" . $printernames['lastname'];
        $timetableheaderspec = '';
//        $arrary_mand = array();
        foreach ($daterange as $key => $value) {
            $timetableheader = '<TH SCOPE=col>' . date('jS', strtotime($value)) . '</TH>';
//            array_push($arrary_mand, $timetableheader);
            $timetableheaderspec .= $timetableheader;
//            $timetableheaderspec .= htmlspecialchars($timetableheader);
//            $timetableheaderspec .= '<TH SCOPE=col>' . date('jS', strtotime($value)) . '</TH>';
//            $timetableheader .= '<td>' . '<font size="2" color="green">' . date('jS', strtotime($value)) . '</font>' . '</td>';
        }
        $pinnonamesone = '<TH SCOPE=col>PIN NO</TH><TH SCOPE=col>NAMES</TH><TH SCOPE=col></TH>';
        $rowone = $pinnonamesone . $timetableheaderspec;
        $pinnonamestwo = $rowone . '<TH SCOPE=col>OA</TH><TH SCOPE=col>GROSS</TH><TH SCOPE=col>PAYE</TH><TH SCOPE=col>NSSF</TH><TH SCOPE=col>NHIF</TH><TH SCOPE=col>LUNCH</TH><TH SCOPE=col>SACCO</TH><TH SCOPE=col>AD</TH><TH SCOPE=col>LOAN</TH><TH SCOPE=col>TOT DED</TH><TH SCOPE=col>DAYS</TH><TH SCOPE=col>NET</TH>';
        //HEY
        $one = '<TR><TH SCOPE=colgroup COLSPAN="100%"><font size="5" color="green">ASL TRADING - ' . $this->universal_model->selectz(array('employementtype'), 'employementtypes', 'id', $employtype)[0]['employementtype'] . ' STAFF</font></TH></TR>';
        $two = '<TR>
      <TH SCOPE=colgroup COLSPAN="7%">Printed On: <b>' . date("d/m/Y") . '</b></TH>
      <TH SCOPE=colgroup COLSPAN="40%"><b style="text-align:right;">' . date_format(date_create($dateone), "F, Y") . ' ' . $whichfortnight . ' BRANCH ' . $branchname . '</b></TH></TR>';
        $four = '<TR><TH SCOPE=colgroup COLSPAN="6%">Printed Time: <b>' . date("h:i:s") . '</b></TH><TH SCOPE=colgroup COLSPAN="15%">For Week Starting On: <font size="4">' . $dateone . '</font> And Ending On: <font size="4">' . $datetwo . '</font></TH><TH>' . $name . '</TH></TR>';
//        $five = '<TR><TH SCOPE=colgroup COLSPAN="100%">Printed By: <b>Hey</b></TH></TR>';
        $headerheader = '<THEAD>' . $one . $two . $four . $pinnonamestwo . '<THEAD>';
//        print_array($suparray);
//        $arr = array('Hello', 'World!', 'Beautiful', 'Day!');
//        echo join("#", $arr);
        $this->table->add_row($headerheader);
        // $this->table->set_heading($cell, $cell1, $cell2);
//        $this->table->add_row("PIN NO", "NAMES", $timetableheader, "OT ALL", "GROSS", "PAYE", "NSSF", "NHIF", "DAYS", "LUNCH", "SACCO", "AD", "LOAN", "TOT DED", "TOTAL");
        $otherallowsum = 0;
        $grosssum = 0;
        $payesum = 0;
        $nssfsum = 0;
        $nhifsum = 0;
        $lunchsum = 0;
        $saccosum = 0;
        $advanceddeductionsum = 0;
        $loansum = 0;
        $totalremovedsum = 0;
        $totaldays = 0;
        $totaltotalremain = 0;
        $darmarray = array();
        foreach ($arraydata as $reportdata) {
            //START SUMS
            $otherallowsum += $reportdata['otherallow'];
            $grosssum += $reportdata['gross'];
            $payesum += $reportdata['paye'];
            $nssfsum += $reportdata['nssf'];
            $nhifsum += $reportdata['nhif'];
            $lunchsum += $reportdata['lunch'];
            $saccosum += $reportdata['sacco'];
            $advanceddeductionsum += $reportdata['advanceddeduction'];
            $loansum += $reportdata['loan'];
            $totalremovedsum += $reportdata['totalremoved'];
            $totaldays += $reportdata['days'];
            $totaltotalremain += $reportdata['totalremain'];
            if ($reportdata['totalremain'] < 0) {
                $totaltotalremain = 0;
                $reportdata['totalremain'] = 0;
            }
            //End SUMS
            $timetemp = json_decode($reportdata['time'], true);
            $timetable = '';
            foreach ($daterange as $key => $valuetime) {
                if (key_exists(array_keys($timetemp[$key])[0], $darmarray)) {
                    $darmarray[array_keys($timetemp[$key])[0]] += array_values($timetemp[$key])[0];
                } else {
                    $darmarray[array_keys($timetemp[$key])[0]] = $timetemp[$key][$valuetime];
                }
                $timetable .= '<td>' . array_values($timetemp[$key])[0] . '</td>';
            }
            $this->table->add_row($reportdata['pinnumber'], $reportdata['names'], $timetable, $reportdata['otherallow'], '<b>' . $reportdata['gross'] . '</b>', $reportdata['paye'], $reportdata['nssf'], $reportdata['nhif'], $reportdata['lunch'], $reportdata['sacco'], $reportdata['advanceddeduction'], $reportdata['loan'], '<b>' . $reportdata['totalremoved'] . '</b>', $reportdata['days'], '<b>' . $reportdata['totalremain'] . '<b>');
        }
        $timetotalen = '';
        foreach ($darmarray as $value) {
            $timetotalen .= '<td>' . $value . '</td>';
        }
//        print_array($darmarray);
//        echo $timetable_sum;
        $this->table->add_row('<b>TOTALS</b>', "", '<b>' . $timetotalen . '</b>', '<b>' . $otherallowsum . '</b>', '<b>' . $grosssum . '</b>', '<b>' . $payesum . '</b>', '<b>' . $nssfsum . '</b>', '<b>' . $nhifsum . '</b>', '<b>' . $lunchsum . '</b>', '<b>' . $saccosum . '</b>', '<b>' . $advanceddeductionsum . '</b>', '<b>' . $loansum . '</b>', '<b>' . $totalremovedsum . '</b>', '<b>' . $totaldays . '</b>', '<b>' . $totaltotalremain . '</b>');
        // $this->getdaterangechosen($startcountdate, $datefromnow);
        return $this->table->generate();
    }

}
