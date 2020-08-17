<?php

require_once (APPPATH . 'libraries/EditableGrid.php');

class Rfortnight extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('universal_model');
    }

    public function index() {
        echo '... API Reporting ....';
    }

    function test() {
//        $datamin = '2019-02-16';
//        $datamax = '2019-02-28';
        $date = date("d/m/Y");
//        $firstdate = date('Y-m-01', strtotime($datamin));
//        $fortnight = date('Y-m-d', strtotime($firstdate . ' + 14     days'));
        echo $fortnight;
        // $main_array ['daterange'] = $daterange;
        // $main_array ['datename'] = $varone;
        // $main_array ['dateabv'] = $vartwo;
    }

    function fortnightreport($branch, $datamin, $datamax, $userpin) {
        // $datamin, $datamax, $userpin, $branch
        // $datamin = '2019-02-01';
        // $datamax = '2019-02-15';
        // $userpin = '13675538';
        // $branch = 'AIOR181260318';
        $newpinsdata = $this->universal_model->attendence_fortnight($branch, $datamin, $datamax, $userpin);
        $fortreport = array();
        $rate = 8.0;
        $sacco = 1200;
        $lunch = 50;
        $standardpay = 400;
        $calpay = 0;
        $grossmonthlypay = 0;
        $timearray = array();
        $allowance = 0;
        $cumulativelunch = 0;
        $days = 0;
        $advanceddectiontotal = 0;
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
        $paye = $this->forpaye($gorssgrossx, $nssfvariable, $relife, $dedectstatus);
        $nhif = $this->fornhif($gorssgrossx, $previousnhif);
        $fortreport['time'] = json_encode($timearray);
        $fortreport['otherallow'] = $allowance;

        $fortreport['paye'] = $paye;
        $fortreport['nhif'] = $nhif;
        $fortreport['nssf'] = $nssfvariable;
        $fortreport['pinnumber'] = $userpin;
        $fortreport['branch'] = $branch;
        $fortreport['days'] = $days;
        $fortreport['sacco'] = ($sacco / 2);
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
        if (!empty($checkloan) && $reducelone = 1) {
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
        $totaldecution = $loanamount + $cumulativelunch + ($sacco / 2) + $advanceddectiontotal + $paye + $nhif + $nssfvariable;
        $fortreport['totalremoved'] = $totaldecution;
        $fortreport['totalremain'] = $gorssgross - $totaldecution;
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

    public function loadpayslipsum() {
        $branch_startpay = "AIOR181260318$23317223@27896398@28149957@29032835@29084758@29758714@30009479@30577023@30752145@30757481@31363604@33998587@34077392@34755722@35550396@35776790@6270758@ALICE WANGARI@ALIMA ADEN MARE@ANDREW GITHAIGA KAMUNYA@ANTHONY KINYUA@ANTHONY MWAMBU@BENSON KIPCHIRCHIR@BETH MWENDWA@CATHERINE NUNGARI@CEPHAS MULILI KITETU@CHRISTINE NGATIA@CHRISTOPHER GITAHI@CLEOPHER MWANGI@COLLINS OMONDI@CONSOLATA NYAMBURA@CONSTANCE MUDONYI@DANIEL MAINGI@DAVID MUNIU@DENNIS MWASI@DENNIS NJOROGE@DOMINIC KITHOME@DOMINIC MUNZAA@EDITH MUMBI@EDWIN MUTAHI@ELIZABETH WANJIRU@EMMANUEL KIPNGENO@ERIC MUCHANGI@EUNICE MUCHOKI@EUNICE WANJIKU GAKUYA@EVANS MWANGI@EVANS WAMBWILE@FRED NJUGUNA@FRIDAH GAKII@GASPER GATHECHA@GEORGE KINYANJUI@GEORGE MWANGI@GIBSON THEURI@GRACE KILASARA@HEZRON BUNDI@IAN KIMANI@IRENE NDUNGE@ISAAC WARURU@JAMES MUTHOKA@JAMES NDEGWA@JANE KAROKI@JANE WANGUI KAROKI@JAPHETH MUSYOKI@JENNIFFER WAITHIRA@JOAN NJERI@JOHN MAINA@JOHN MUYESU@JOHN NJOROGE@JOHN NJUGUNA@JORAM MUHIA@JOSEPH KIGO@JOSEPH NJUGUNA@JULIUS MWANGI@KELVINS ASHION@KENNEDY MWANGI@KENNETH KIPKEMOI@LUCY NJERI@MARIA NJOKI MWAURA@MARTHA KAVATA@MARYGRACE WANJIRU@MARYLYN OMONDI@MAUREEN MILGO@MAUREEN NYAMBURA@METRINE NAFULA@MICHAEL KURIA@MICHAEL SILA@MONICAH WAKARIMA@MUTUA MUTEMI@NAHASHON KARIUKI@NELSON CHERUIYOT@NELSON MACHARIA@NIMROD KIHIU@PATRICK KABUTHA@PATRICK NDAMBUKI@PATRICK NJOGU MUIRURI@PAUL NDIRANGU@PETER MAKALI MUTUA@PETER MUTUA@PETERSON WANJAU@PYHLIS NYABELA@REUBEN MWANGI@ROSELINDA ALOO OCHANGO@RUTH WACU@SAMUEL KIMATHI@SAMUEL MURIITHI@SAMUEL NJUGUNA@SIFIRA NJERI WANJIRU@SIMON ODORO@STEPHEN MAINA@STEPHEN MWANGI@STEPHEN MWAURA@STEPHEN NGANGA@SUSAN WANJIRU@TABITHA WAENI@TERESIA GACHUMA@TERESIA MUKUI KIOKO@TITUS MUNYOKI@WALTER EVANSON NJUGUNA@WILSON KURIA@ZAVERIOUS DIEMA$23317223@27896398@28149957@29032835@29084758@29758714@30009479@30577023@30752145@30757481@31363604@33998587@34077392@34755722@35550396@35776790@6270758@30450344@14188913@22324308@23645812@24702590@30239108@29467545@24164182@31037402@35530993@23040770@32247700@37146133@31008131@22538550@25199564@23320167@25690395@32392973@28951887@27383652@29862170@30125451@26627407@29706656@31891878@33817015@31400981@30782345@28317223@34024916@25221951@20908006@32484430@32158530@24491108@27532859@28516302@34262196@28705280@29294941@33823429@36373026@32537352@2537352@27865598@34484338@33882523@33358128@33624352@28246181@33668930@33027920@34930579@28838626@21973782@24486453@31911854@36887539@29466252@27760720@32986080@23983137@32229621@32497185@33825300@32241489@33302358@23744898@34912384@25792831@27771420@32391045@33166688@24384079@28584260@36197022@22377284@31306191@14522654@27067791@28948866@22630830@24569753@21600415@27896388@32271291@33776401@34227112@34505869@30407307@9381282@30198692@23084332@27860653@31554378@31088682@26378936@22592526@22197141@13675538@28351268@24046435";
        $date_maxncardxpay = "2019-02-15";
        $date_mincardxpay = "2019-02-01";
        $employeenumbermaxxpay = "ZAVERIOUS DIEMA|24046435";
        $employeenumberminxpay = "ALICE WANGARI|30450344";
        // $branch_startpay = $this->input->post('branch_startpay');
        // $date_maxncardxpay = $this->input->post('date_maxncardxpay');
        // $date_mincardxpay = $this->input->post('date_mincardxpay');
        // $employeenumbermaxxpay = $this->input->post('employeenumbermaxxpay');
        // $employeenumberminxpay = $this->input->post('employeenumberminxpay');
        // PROCESS
        $employeenumberminxarray = explode('|', $employeenumberminxpay);
        $employeenumbermaxxarray = explode('|', $employeenumbermaxxpay);
        $array_last_name = 0;
        if ($employeenumbermaxxarray[0] != '') {
            $array_last_name = $employeenumbermaxxarray[0][0];
        }
        // START HASING AND DATE COPARING
        // START HASING AND DATE COPARING
        $branchcode = explode('$', $branch_startpay);
        $reportarray = array();
        $gettimetrans = $this->universal_model->getrangeforfortnight($employeenumberminxarray[0][0], $array_last_name, $branchcode[0]);
        foreach ($gettimetrans as $gettimetransvalues) {
            $reportarraytemp = $this->universal_model->firstfortnightsingleuser('*', $branchcode[0], $date_mincardxpay, $date_maxncardxpay, $gettimetransvalues['pintwo']);
            if (!empty($reportarraytemp)) {
                array_push($reportarray, $reportarraytemp[0]);
            }

            // if (! empty(json_decode($reportarraytemp['time'], true))) {
            // array_push($reportarray, $reportarraytemp);
            // }
        }
        if (empty($reportarray)) {
            $json_return = array(
                'report' => "No Data Found  in this Range " . $date_mincardxpay . ' to ' . $date_maxncardxpay,
                'status' => 0
            );
            echo json_encode($json_return);
        } else {
            $json_return = array(
                'report' => "Range " . 'between ' . $date_mincardxpay . ' to ' . $date_maxncardxpay . ' loaded',
                'status' => 1,
                'data' => $this->generatereportsliptsum($reportarray, $date_mincardxpay, $date_maxncardxpay)
            );
            echo json_encode($json_return);
        }
    }

    public function loadpayslip() {
        $branch_startpay = "AIOR181260318$23317223@27896398@28149957@29032835@29084758@29758714@30009479@30577023@30752145@30757481@31363604@33998587@34077392@34755722@35550396@35776790@6270758@ALICE WANGARI@ALIMA ADEN MARE@ANDREW GITHAIGA KAMUNYA@ANTHONY KINYUA@ANTHONY MWAMBU@BENSON KIPCHIRCHIR@BETH MWENDWA@CATHERINE NUNGARI@CEPHAS MULILI KITETU@CHRISTINE NGATIA@CHRISTOPHER GITAHI@CLEOPHER MWANGI@COLLINS OMONDI@CONSOLATA NYAMBURA@CONSTANCE MUDONYI@DANIEL MAINGI@DAVID MUNIU@DENNIS MWASI@DENNIS NJOROGE@DOMINIC KITHOME@DOMINIC MUNZAA@EDITH MUMBI@EDWIN MUTAHI@ELIZABETH WANJIRU@EMMANUEL KIPNGENO@ERIC MUCHANGI@EUNICE MUCHOKI@EUNICE WANJIKU GAKUYA@EVANS MWANGI@EVANS WAMBWILE@FRED NJUGUNA@FRIDAH GAKII@GASPER GATHECHA@GEORGE KINYANJUI@GEORGE MWANGI@GIBSON THEURI@GRACE KILASARA@HEZRON BUNDI@IAN KIMANI@IRENE NDUNGE@ISAAC WARURU@JAMES MUTHOKA@JAMES NDEGWA@JANE KAROKI@JANE WANGUI KAROKI@JAPHETH MUSYOKI@JENNIFFER WAITHIRA@JOAN NJERI@JOHN MAINA@JOHN MUYESU@JOHN NJOROGE@JOHN NJUGUNA@JORAM MUHIA@JOSEPH KIGO@JOSEPH NJUGUNA@JULIUS MWANGI@KELVINS ASHION@KENNEDY MWANGI@KENNETH KIPKEMOI@LUCY NJERI@MARIA NJOKI MWAURA@MARTHA KAVATA@MARYGRACE WANJIRU@MARYLYN OMONDI@MAUREEN MILGO@MAUREEN NYAMBURA@METRINE NAFULA@MICHAEL KURIA@MICHAEL SILA@MONICAH WAKARIMA@MUTUA MUTEMI@NAHASHON KARIUKI@NELSON CHERUIYOT@NELSON MACHARIA@NIMROD KIHIU@PATRICK KABUTHA@PATRICK NDAMBUKI@PATRICK NJOGU MUIRURI@PAUL NDIRANGU@PETER MAKALI MUTUA@PETER MUTUA@PETERSON WANJAU@PYHLIS NYABELA@REUBEN MWANGI@ROSELINDA ALOO OCHANGO@RUTH WACU@SAMUEL KIMATHI@SAMUEL MURIITHI@SAMUEL NJUGUNA@SIFIRA NJERI WANJIRU@SIMON ODORO@STEPHEN MAINA@STEPHEN MWANGI@STEPHEN MWAURA@STEPHEN NGANGA@SUSAN WANJIRU@TABITHA WAENI@TERESIA GACHUMA@TERESIA MUKUI KIOKO@TITUS MUNYOKI@WALTER EVANSON NJUGUNA@WILSON KURIA@ZAVERIOUS DIEMA$23317223@27896398@28149957@29032835@29084758@29758714@30009479@30577023@30752145@30757481@31363604@33998587@34077392@34755722@35550396@35776790@6270758@30450344@14188913@22324308@23645812@24702590@30239108@29467545@24164182@31037402@35530993@23040770@32247700@37146133@31008131@22538550@25199564@23320167@25690395@32392973@28951887@27383652@29862170@30125451@26627407@29706656@31891878@33817015@31400981@30782345@28317223@34024916@25221951@20908006@32484430@32158530@24491108@27532859@28516302@34262196@28705280@29294941@33823429@36373026@32537352@2537352@27865598@34484338@33882523@33358128@33624352@28246181@33668930@33027920@34930579@28838626@21973782@24486453@31911854@36887539@29466252@27760720@32986080@23983137@32229621@32497185@33825300@32241489@33302358@23744898@34912384@25792831@27771420@32391045@33166688@24384079@28584260@36197022@22377284@31306191@14522654@27067791@28948866@22630830@24569753@21600415@27896388@32271291@33776401@34227112@34505869@30407307@9381282@30198692@23084332@27860653@31554378@31088682@26378936@22592526@22197141@13675538@28351268@24046435";
        $date_maxncardxpay = "2019-02-15";
        $date_mincardxpay = "2019-02-01";
        $employeenumbermaxxpay = "ZAVERIOUS DIEMA|24046435";
        $employeenumberminxpay = "ALICE WANGARI|30450344";
        // $branch_startpay = $this->input->post('branch_startpay');
        // $date_maxncardxpay = $this->input->post('date_maxncardxpay');
        // $date_mincardxpay = $this->input->post('date_mincardxpay');
        // $employeenumbermaxxpay = $this->input->post('employeenumbermaxxpay');
        // $employeenumberminxpay = $this->input->post('employeenumberminxpay');
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
        $gettimetrans = $this->universal_model->getrangeforfortnight($employeenumberminxarray[0][0], $array_last_name, $branchcode[0]);
        foreach ($gettimetrans as $gettimetransvalues) {
            $reportarraytemp = $this->fortnightreport($branchcode[0], $date_mincardxpay, $date_maxncardxpay, $gettimetransvalues['pintwo']);
            if (!empty(json_decode($reportarraytemp['time'], true))) {
                // if ($mindate == '1st' || $maxdate == '15th') {
                $this->universal_model->updateOnDuplicate('payfortnight', $reportarraytemp);
                // }
                array_push($reportarray, $reportarraytemp);
            }
        }
        // print_array($reportarray);
        if (empty($reportarray)) {
            $json_return = array(
                'report' => "No Data Found  in this Range " . $date_mincardxpay . ' to ' . $date_maxncardxpay,
                'status' => 0
            );
            echo json_encode($json_return);
        } else {
            $json_return = array(
                'report' => "Range " . 'between ' . $date_mincardxpay . ' to ' . $date_maxncardxpay . ' loaded',
                'status' => 1,
                'data' => $this->generatereportsliptablehtml($reportarray, $date_mincardxpay, $date_maxncardxpay)
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
    function generatereportsliptsum($arraydata, $dateone, $datetwo) {
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
        $today = date('F j, Y');
        $header = '<THEAD>
    <TR>
      <TH SCOPE=col ROWSPAN=2>Character</TH>
      <TH SCOPE=col ROWSPAN=2>Entity</TH>
      <TH SCOPE=col ROWSPAN=2>Decimal</TH>
      <TH SCOPE=col ROWSPAN=2>Hex</TH>
      <TH SCOPE=colgroup COLSPAN=3>Rendering in Your Browser</TH>
    </TR>
    <TR>
      <TH SCOPE=col>Entity</TH>
      <TH SCOPE=col>Decimal</TH>
      <TH SCOPE=col>Hex</TH>
    </TR>
  </THEAD>';
        $cell = array(
            'data' => '<h1><b>WAGE PAYMENT REPORT FOR</b></h1>' . ' ' . $today,
            'class' => ' info',
            'colspan' => 4
        );
        $cell1 = array(
            'data' => 'For Week Starting <b>' . $dateone . '</b>',
            'class' => ' info',
            'colspan' => 2
        );
        $cell2 = array(
            'data' => 'And Ending <b>' . $datetwo . '</b>',
            'class' => ' info',
            'colspan' => 2
        );
        $this->table->set_template($template);
        // $this->table->set_heading($cell, $cell1, $cell2);
        $this->table->add_row($header);
        $this->table->add_row($cell);
        $this->table->add_row("PIN NO", "NAMES", "OT ALL", "GROSS", "PAYE", "NSSF", "NHIF", "DAYS", "LUNCH", "SACCO", "AD", "LOAN", "TOT DED", "TOTAL");
        foreach ($arraydata as $reportdata) {
            $this->table->add_row($reportdata['pinnumber'], $reportdata['names'], $reportdata['otherallow'], $reportdata['gross'], $reportdata['paye'], $reportdata['nssf'], $reportdata['nhif'], $reportdata['days'], $reportdata['lunch'], $reportdata['sacco'], $reportdata['advanceddeduction'], $reportdata['loan'], $reportdata['totalremoved'], $reportdata['totalremain']);
        }
        // $this->getdaterangechosen($startcountdate, $datefromnow);
        return $this->table->generate();
    }

    function generatereportsliptablehtml($arraydata, $dateone, $datetwo) {
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
        $cell = array(
            'data' => '<b>PAYMENT SHEET</b>',
            'class' => ' info',
            'colspan' => 2
        );
        $cell1 = array(
            'data' => 'For Week Starting <b>' . $dateone . '</b>',
            'class' => ' info',
            'colspan' => 2
        );
        $cell2 = array(
            'data' => 'And Ending <b>' . $datetwo . '</b>',
            'class' => ' info',
            'colspan' => 2
        );
        $this->table->set_template($template);
        // $this->table->set_heading($cell, $cell1, $cell2);
        $daterange = getDatesFromRange($dateone, $datetwo);
        $timetableheader = '';
        foreach ($daterange as $value) {
            $timetableheader .= '<td>' . '<font size="2" color="green">' . date('jS', strtotime($value)) . '</font>' . '</td>';
        }
        $this->table->add_row("PIN NO", "NAMES", $timetableheader, "OT ALL", "GROSS", "PAYE", "NSSF", "NHIF", "DAYS", "LUNCH", "SACCO", "AD", "LOAN", "TOT DED", "TOTAL");
        foreach ($arraydata as $reportdata) {
            $timetemp = json_decode($reportdata['time'], true);
            $timetable = '';
            foreach ($daterange as $key => $valuetime) {
                $timetable .= '<td>' . $timetemp[$key][$valuetime] . '</td>';
            }
            $this->table->add_row($reportdata['pinnumber'], $reportdata['names'], $timetable, $reportdata['otherallow'], $reportdata['gross'], $reportdata['paye'], $reportdata['nssf'], $reportdata['nhif'], $reportdata['days'], $reportdata['lunch'], $reportdata['sacco'], $reportdata['advanceddeduction'], $reportdata['loan'], $reportdata['totalremoved'], $reportdata['totalremain']);
        }
        // $this->getdaterangechosen($startcountdate, $datefromnow);
        return $this->table->generate();
    }

}
