<?php

ini_set('max_execution_time', 300);
date_default_timezone_set('GMT');

// UTC
/**
 * Description of DataManager
 *
 * @author joash
 */
class Dm extends CI_Controller
{

    public function index()
    {
        // ALTER TABLE tablename AUTO_INCREMENT = 1
        echo '<h1>. . .. Api Improved Database 2.0</h1>';
    }
    public function __construct()
    {
        parent::__construct();
        // 13675538 Walter Pin
        $this->load->model('universal_model');
    }

    //HELPER QUERY TO SYNC USERS WHOS BRANCHES ARE NOT REFLECTED
    public function assignbranchbatch()
    {
        //          function selectz($array_table_n, $table_n, $variable_1, $value_1) {
        $newpinsdata = $this->universal_model->selectz(array('id', 'pin'), 'users', 'branch_id', 0);
        foreach ($newpinsdata as $idpin) {
            $branch_creds = $this->universal_model->liasebranc($idpin['pin']);
            if (!empty($branch_creds)) {
                $updatebranch = array(
                    'id' => $idpin['id'],
                    'branch_id' => $branch_creds['branchid']
                );
                $this->universal_model->updateOnDuplicate('users', $updatebranch);
            } else {
                print_array($idpin);
                print_array('... unonimous user ...');
            }
        }
        print_array(' ... All users assigned Branches .. ');
    }

    public function pinlogsnotuserinfo($serialnumbers)
    {
        $newpinsdata = $this->universal_model->util_br($serialnumbers);
        echo 'User Credentials Syncronised ...';
        //        print_array($newpinsdata);
        //        
    }

    public function tyests()
    {
        // $newpinsdata = $this->universal_model->selectuniuquefortransupadte('2019-02', 'AIOR181260318');
        // print_array($newpinsdata);
        $array1 = array();
        $array_samplex = array(
            'userpin' => '23',
            'leavedate' => '2018-11-06',
            'leavecode' => '234',
            'addedby' => '111'
        );
        array_push($array1, $array_samplex);
        $array_sample2 = array(
            'userpin' => '11',
            'leavedate' => '2018-11-09',
            'leavecode' => '200',
            'addedby' => '121'
        );
        array_push($array1, $array_sample2);
        $array_sample1 = array(
            'userpin' => '121',
            'leavedate' => '2018-11-06',
            'leavecode' => '333',
            'addedby' => '22'
        );
        array_push($array1, $array_sample1);
        $array_sample = array(
            'userpin' => '12',
            'leavedate' => '2018-11-06',
            'leavecode' => '257',
            'addedby' => '114'
        );
        array_push($array1, $array_sample);
        foreach ($array1 as $datax) {
            $this->universal_model->updateOnDuplicate('testing', $datax);
        }
    }

    public function manualload()
    {
        $start = microtime(true);
        $newpinsdata = $this->universal_model->selectuniuquefortransupadte('2019-03', 'AIOR181260318');
        // print_array($newpinsdata);
        $this->db->trans_start();
        foreach ($newpinsdata as $datadate) {
            $getmearray1 = $this->fullfledgedreportrecord($datadate['datelike'], $this->availablemonthlydata($datadate['pin'], $datadate['datelike'], $datadate['serialnumber']));
            // $result = array();
            array_walk($getmearray1, function ($value, $key) use (&$result) {
                unset($value['exactdate']);
                unset($value['dateinsertserver']);
                unset($value['names']);
                unset($value['id_util_department']);
                unset($value['shiftmancode']);
                unset($value['shiftfrom']);
                unset($value['shiftto']);
                unset($value['shiftype']);
                unset($value['lunchmin']);
                unset($value['day']);
                $this->universal_model->updateOnDuplicate('trans', $value);
            });
        }
        $this->db->trans_complete();
        $time_elapsed_secs = microtime(true) - $start;
        print_array(date("H:i:s", $time_elapsed_secs));
    }

    function fullfledgedreportrecord($date, $fullfill)
    {
        $yearmonthparts = explode('-', $date);
        $fulldata_montarray = array();
        $d = cal_days_in_month(CAL_GREGORIAN, $yearmonthparts[1], $yearmonthparts[0]);
        $number = range(1, $d);
        $array_borrow_values = array();
        foreach ($number as $valueseethis) {
            $datainquestion = $date . '-' . sprintf("%02d", $valueseethis);
            if (array_key_exists($datainquestion, $fullfill)) {
                $array_borrow_values = $fullfill[$datainquestion];
                array_push($fulldata_montarray, $array_borrow_values);
            } else {
                if (empty($array_borrow_values)) {
                    $rand_keys = array_rand($fullfill, 1);
                    $array_borrow_values = $fullfill[$rand_keys];
                }
                $mergie_thefrog = array(
                    'pin' => $array_borrow_values['pin'],
                    'exactdate' => $datainquestion . ' 00:00:00',
                    'dateclock' => $datainquestion,
                    'dateclocktime' => ' 00:00:00',
                    //                    'login' => '',
                    //                    'logout' => '',
                    'firstdayofweek' => getfirstday_of_week($datainquestion),
                    'serialnumber' => $array_borrow_values['serialnumber'],
                    'timeinserts' => $array_borrow_values['timeinserts'],
                    'dateinsertserver' => $array_borrow_values['timeinserts'] . ' 00:00:00',
                    'names' => $array_borrow_values['names'],
                    'user_id' => $array_borrow_values['user_id'],
                    'id_util_department' => $array_borrow_values['id_util_department'],
                    'id_shift_def' => $array_borrow_values['id_shift_def'],
                    'shiftmancode' => $array_borrow_values['shiftmancode'],
                    'shiftfrom' => $array_borrow_values['shiftfrom'],
                    'shiftto' => $array_borrow_values['shiftto'],
                    'shiftype' => $array_borrow_values['shiftype'],
                    'lunchmin' => $array_borrow_values['lunchmin'],
                    'deptcode' => $array_borrow_values['deptcode'],
                    'tothrs' => '',
                    'normaltime' => $array_borrow_values['normaltime'],
                    'mot15' => '',
                    'ot15' => '',
                    'leavestatus' => $this->getleavecodeifexistondate($datainquestion, $array_borrow_values['pin']),
                    'lostt' => $this->getlosttimedeter(getfirstday_of_week($datainquestion), $datainquestion, 1, $array_borrow_values['normaltime']),
                    'weekday' => getDayWeekFromNumber(getWeekday($datainquestion)),
                    'weekyear' => getWeekYear($datainquestion),
                    'off' => $this->getlosttimedeter(getfirstday_of_week($datainquestion), $datainquestion, 0, $array_borrow_values['normaltime']),
                    'ot20' => ''
                );
                array_push($fulldata_montarray, $mergie_thefrog);
            }
        }
        return $fulldata_montarray;
    }

    // public function more($userpin, $date_like, $serialnumber)
    public function availablemonthlydata($userpin, $date_like, $serialnumber)
    {
        // $newpinsdata = $this->universal_model->joinpinscard('13675538', '2018-11', 'AIOR181260318');
        $newpinsdata = $this->universal_model->joinpinscard($userpin, $date_like, $serialnumber);
        $output = array_reduce($newpinsdata, function (array $carry, array $item) {
            $city = $item['dateclock'];
            if (array_key_exists($city, $carry)) {
                $carry[$city]['dateclocktime'] .= '@' . $item['dateclocktime'];
                // CreatedArrays Virtual
                $carry[$city]['tothrs'] = $this->tothrs($carry[$city]['dateclocktime'], $item['lunchmin']);
                $carry[$city]['login'] = $this->loginlogout($carry[$city]['dateclocktime'], 1);
                $carry[$city]['logout'] = $this->loginlogout($carry[$city]['dateclocktime'], 0);
                $carry[$city]['normaltime'] = $this->normaltime($item['shiftfrom'], $item['shiftto'], $item['lunchmin']);
                $carry[$city]['mot15'] = $this->mot15($item['shiftfrom'], $carry[$city]['dateclocktime']);
                $carry[$city]['ot15'] = $this->ot15($item['shiftto'], $carry[$city]['dateclocktime']);
                $carry[$city]['lostt'] = $this->lostt($item['shiftto'], $item['shiftfrom'], $carry[$city]['dateclocktime']);
                $carry[$city]['weekday'] = getDayWeekFromNumber(getWeekday($item['dateclock']));
                $carry[$city]['weekyear'] = getWeekYear($item['dateclock']);
                $carry[$city]['leavestatus'] = $this->getleavecodeifexistondate($item['dateclock'], $item['pin']);
                $carry[$city]['off'] = $this->off_caluculus(getfirstday_of_week($item['firstdayofweek']), $item['dateclock'], $this->tothrs($carry[$city]['dateclocktime'], $item['lunchmin']), $item['pin']);
                $carry[$city]['ot20'] = $this->ot20($item['dateclock'], $this->tothrs($carry[$city]['dateclocktime'], $item['lunchmin']));
            } else {
                $carry[$city] = $item;
                // CreatedArrays Virtual
                $carry[$city]['leavestatus'] = $this->getleavecodeifexistondate($item['dateclock'], $item['pin']);
                $carry[$city]['tothrs'] = $this->tothrs($carry[$city]['dateclocktime'], $item['lunchmin']);
                //                $carry[$city]['login'] = '';
                //                $carry[$city]['logout'] = '';
                $carry[$city]['normaltime'] = $this->normaltime($item['shiftfrom'], $item['shiftto'], $item['lunchmin']);
                $carry[$city]['mot15'] = $this->mot15($item['shiftfrom'], $carry[$city]['dateclocktime']);
                $carry[$city]['ot15'] = $this->ot15($item['shiftto'], $carry[$city]['dateclocktime']);
                $carry[$city]['lostt'] = $this->lostt($item['shiftto'], $item['shiftfrom'], $carry[$city]['dateclocktime']);
                $carry[$city]['weekday'] = getDayWeekFromNumber(getWeekday($item['dateclock']));
                $carry[$city]['weekyear'] = getWeekYear($item['dateclock']);
                $carry[$city]['off'] = $this->off_caluculus(getfirstday_of_week($item['firstdayofweek']), $item['dateclock'], $this->tothrs($carry[$city]['dateclocktime'], $item['lunchmin']), $item['pin']);
                $carry[$city]['ot20'] = $this->ot20($item['dateclock'], $this->tothrs($carry[$city]['dateclocktime'], $item['lunchmin']));
            }
            return $carry;
        }, array());
        // $outputvalues = array_values($output);
        // print_array($outputvalues);
        return $output;
    }

    // Below Are Helper Functions
    public function userdefaultdata($pin)
    {
        $arraydata = $this->universal_model->selectz('*', 'users', 'pin', $pin);
        if (empty($arraydata)) {
            ///Trick Please Dont Erase
            $getbigest = $this->universal_model->getlastrow('users');
            $getbigest = json_encode($getbigest);
            $getbigest = json_decode($getbigest, true);
            //End Of Trick
            $getnames = $this->universal_model->selectz('names', 'attendence_alluserinfo', 'pintwo', $pin)[0]['names'];
            $employeecoderaw = $getbigest['employee_code'];
            $firstCharacter = substr($employeecoderaw, 0, 1);
            $employeecoderawtwo = explode($firstCharacter, $employeecoderaw);
            $newcode = $employeecoderawtwo[1] + 1;
            $employee_code = 'U' . $newcode;
            $user_id = getToken(6) . '@AT';
            // $pin = $pin;
            $user_image_small = '50_iconuserdefault.png';
            $user_image_medium = '60_iconuserdefault.png';
            $user_image_big = '500_iconuserdefault.png';
            $emailaddress = $employee_code . '@mail.com';
            $password = '123456';
            $names = explode(' ', trim($getnames));
            print_array($names);
            if (!empty($names)) {
                $firstname = $names[0];
                if (count($names) > 1) {
                    $lastname = $names[1] . ' ' . $names[0];
                } else {
                    $lastname = $names[1];
                }
            }

            $cellphone = '0000000000';
            if (strlen($employee_code) == 3) {
                $employee_code = 'U' . '000' . $newcode;
            }
            if (strlen($employee_code) == 2) {
                $employee_code = 'U' . '0000' . $newcode;
            }
            if (strlen($employee_code) == 4) {
                $employee_code = 'U' . '00' . $newcode;
            }
            $datatoadd = array(
                'pin' => $pin,
                'employee_code' => $employee_code,
                'user_id' => $user_id,
                'user_image_small' => $user_image_small,
                'user_image_medium' => $user_image_medium,
                'user_image_big' => $user_image_big,
                'emailaddress' => $emailaddress,
                'password' => $password,
                'firstname' => $firstname,
                'lastname' => $lastname,
                'cellphone' => $cellphone
            );
            $this->db->replace('users', $datatoadd);
            $userid = $this->db->insert_id();
            $datawhate = array(
                'user_id' => $userid,
                'id_util_department' => $this->getdepartmentidbyname(),
                'id_shift_def' => $this->getshiftidbyname()
            );
            // print_array($datawhate);
            $this->universal_model->insertzwhere('attendence_util_user_shift', $datawhate);
        } else { }
        // echo $this->db->insert_id();
        // print_array($datatoadd);
        // echo $emailaddress;
    }

    function loginlogout($array_date, $whichone)
    {
        $logibnlogoutarray = explode('@', $array_date);
        $sizearray = count($logibnlogoutarray);
        // print_array($sizearray);
        switch ($sizearray) {
            case 1:
                // print_array($sizearray);
                if ($whichone == 1) {
                    return $logibnlogoutarray[0];
                } else {
                    return $logibnlogoutarray[0];
                }
                // return $tothrs;
                break;
            case 2:
                if ($whichone == 1) {
                    return $logibnlogoutarray[0];
                } else if ($whichone == 0) {
                    return $logibnlogoutarray[1];
                }
                break;
            default:
                if ($whichone == 1) {
                    return $logibnlogoutarray[0];
                } else if ($whichone == 0) {
                    return $logibnlogoutarray[$sizearray - 1];
                }
                // print_array($logibnlogoutarray);
                break;
        }
    }

    function getleavecodeifexistondate($date, $userpin)
    {
        $leave = $this->universal_model->selectzy('leavecode', 'attendence_leaves', 'leavedate', $date, 'userpin', $userpin);
        if (empty($leave)) {
            return 'XXX';
        } else {
            return $leave[0]['leavecode'];
        }
    }

    function ot20($dateclock, $tothrs)
    {
        $publicholiday = $this->universal_model->selectztimholmt(changedateformate($dateclock));
        if (!empty($publicholiday) && $tothrs != '0') {
            return $tothrs;
        }
    }

    function off_caluculus($firstdayofweek, $dateclock, $tothrs, $pin)
    {
        if ($firstdayofweek == $dateclock && $tothrs > 0) {
            // Becarefull To Inspect This Insert
            $message_array = array(
                'pin' => $pin,
                'date' => $dateclock,
                'status' => 1
            );
            // $this->universal_model->insertz('att_offworked', $message_array);
            $insert_query = $this->db->insert_string('util_offworked', $message_array);
            $insert_query = str_replace('INSERT INTO', 'INSERT IGNORE INTO', $insert_query);
            $this->db->query($insert_query);
            return 'worked off';
        } else if ($firstdayofweek == $dateclock) {
            return 'off';
        } else {
            return '';
        }
        // return $firstdayofweek . ' ' . $dateclock . ' ' . $tothrs;
    }

    function tothrscalc($fromtime, $totime, $lunchmins)
    {
        $start = date_create($totime);
        $end = date_create($fromtime);
        $minuteslunch = minutes($lunchmins);
        $stringtoreduce = '-' . ' ' . $minuteslunch . ' minutes';
        if ($start > $end) {
            return decimalHours('00:00');
        } else {
            $diff = date_diff($end, $start);
            // print_array($diff);
            $time = date('H:i:s', strtotime($diff->format("%h:%i:%s") . $stringtoreduce));
            return decimalHours($time);
            // $diff->format("%h:%i:%s");
        }
    }

    public function lostt($shiftto, $shiftfrom, $dateclocktime)
    {
        // $totallosttime1 = 0;
        // $totallosttime2 = 0;
        $logibnlogoutarray = explode('@', $dateclocktime);
        $count_login = count($logibnlogoutarray);
        $shiftto = date_create($shiftto);
        $logout = date_create($logibnlogoutarray[$count_login - 1]);
        // .......
        if ($logout < $shiftto) {
            $diff = date_diff($shiftto, $logout);
            $time = date('H:i:s', strtotime($diff->format("%h:%i:%s")));
            $totallosttime1 = $time;
        } else {
            $totallosttime1 = '0:00:0';
        }
        $shiftfrom = date_create($shiftfrom);
        $login = date_create($logibnlogoutarray[0]);
        // .......
        if ($login > $shiftfrom) {
            $diff = date_diff($login, $shiftfrom);
            $time = date('H:i:s', strtotime($diff->format("%h:%i:%s")));
            $totallosttime2 = $time;
            // return decimalHours($time);
        } else {
            $totallosttime2 = '0:00:0';
        }
        $finalsumlost = sum_the_time($totallosttime1, $totallosttime2);
        if ($finalsumlost == '00:00:00') {
            return '';
        } else {
            // Changed To Decimal Hours
            return decimalHours($finalsumlost);
        }
    }

    public function ot15($shiftto, $dateclocktime)
    {
        $logibnlogoutarray = explode('@', $dateclocktime);
        $count_login = count($logibnlogoutarray);
        $shiftto = date_create($shiftto);
        $logout = date_create($logibnlogoutarray[$count_login - 1]);
        // .......
        if ($logout > $shiftto) {
            $diff = date_diff($logout, $shiftto);
            $time = date('H:i:s', strtotime($diff->format("%h:%i:%s")));
            return decimalHours($time);
        } else {
            return '';
        }
    }

    public function mot15($shiftfrom, $dateclocktime)
    {
        $logibnlogoutarray = explode('@', $dateclocktime);
        $shiftfrom = date_create($shiftfrom);
        $login = date_create($logibnlogoutarray[0]);
        // .......
        if ($login < $shiftfrom) {
            $diff = date_diff($shiftfrom, $login);
            $time = date('H:i:s', strtotime($diff->format("%h:%i:%s")));
            return decimalHours($time);
        } else {
            return '';
        }
    }

    public function normaltime($shiftfrom, $shiftto, $lunchmin)
    {
        $start = date_create($shiftfrom);
        $end = date_create($shiftto);
        $minuteslunch = minutes($lunchmin);
        $stringtoreduce = '-' . ' ' . $minuteslunch . ' minutes';
        $diff = date_diff($end, $start);
        // print_array($diff);
        $time = date('H:i:s', strtotime($diff->format("%h:%i:%s") . $stringtoreduce));
        return decimalHours($time);
    }

    public function tothrs($a, $lunchmins)
    {
        // $a = '';
        $logibnlogoutarray = explode('@', $a);
        $sizearray = count($logibnlogoutarray);
        // print_array($sizearray);
        switch ($sizearray) {
            case 1:
                // print_array($sizearray);
                return '';
                // $tothrs = $this->tothrscalc($logibnlogoutarray[0], $logibnlogoutarray[0], $lunchmins);
                // return $tothrs;
                break;
            case 2:
                $tothrs = $this->tothrscalc($logibnlogoutarray[1], $logibnlogoutarray[0], $lunchmins);
                return $tothrs;
                break;
            default:
                $tothrs = $this->tothrscalc($logibnlogoutarray[$sizearray - 1], $logibnlogoutarray[0], $lunchmins);
                return $tothrs;
                // print_array($logibnlogoutarray);
                break;
        }
        // print_array($sizearray);
        // return $a;
    }

    function getlosttimedeter($dateinq, $dateoffday, $flag, $tohrs)
    {
        if ($dateinq == $dateoffday && $flag == 1) {
            return '';
        } elseif ($dateinq != $dateoffday && $flag == 1) {
            return $tohrs;
        } elseif ($dateinq == $dateoffday && $flag == 0) {
            return 1;
        } elseif ($dateinq != $dateoffday && $flag == 0) {
            return '';
        }
    }

    function reporttome($message, $methodclass, $show = 0)
    {
        try {
            // Message
            $message_array = array(
                'message' => $message,
                'methodclass' => $methodclass
            );
            $this->universal_model->insertz('util_monitor', $message_array);
            if ($show != 1) {
                print_array($message_array);
            }
        } catch (Exception $e) {
            $message_array = array(
                $e->getMessage(),
                $e->getTraceAsString()
            );
            if ($show != 1) {
                print_array($message_array);
            }
        }
    }

    // HELPERS
    public function getshiftidbyname()
    {
        $idget = $this->universal_model->select_like('shiftype', 'attendence_shiftdef', 'DAY SHIFT-NORMAL');
        return $idget[0]['id'];
    }

    public function getdepartmentidbyname()
    {
        $idget = $this->universal_model->select_like('deptname', 'attendence_util_department', 'DEPARTMENT ONE');
        return $idget[0]['id'];
    }

    // Called At Core Change
    public function manualcomit($login, $logout, $transid)
    {
        // $login = '06:57';
        // $logout = '20:31';
        $timerange = $login . '@' . $logout;
        $data = $this->universal_model->selectz('*', 'trans', 'id', $transid);
        $data_clean = array_shift($data);
        $shift_def = $this->universal_model->selectz('lunchmin,shiftfrom,shiftto', 'attendence_shiftdef', 'shiftmancode', $data_clean['id_shift_def']);
        $shift_def_id = array_shift($shift_def);
        // print_array($shift_def);
        $manualentry = array();
        $manualentry['dateclocktime'] = $timerange;
        $manualentry['login'] = $login;
        $manualentry['logout'] = $logout;
        $manualentry['normaltime'] = $data_clean['normaltime'];
        $manualentry['tothrs'] = $this->tothrs($timerange, $shift_def_id['lunchmin']);
        $manualentry['mot15'] = $this->mot15($shift_def_id['shiftfrom'], $timerange);
        // DEFAULT FOR NOW
        $manualentry['leavestatus'] = 'XXX';
        $manualentry['ot15'] = $this->ot15($shift_def_id['shiftto'], $timerange);
        $manualentry['lostt'] = $this->lostt($shift_def_id['shiftto'], $shift_def_id['shiftfrom'], $timerange);
        // $manualentry['weekday'] = $data[0]['weekday'];
        // $manualentry['weekyear'] = $data[0]['weekyear'];
        $manualentry['off'] = $this->off_caluculus(getfirstday_of_week($data_clean['firstdayofweek']), $data_clean['dateclock'], $this->tothrs($timerange, $shift_def_id['lunchmin']), $data_clean['pin']);
        // print_array($manualentry);
        $manualentry['manual'] = 'm';
        $manualentry['ot20'] = $this->ot20($data_clean['dateclock'], $this->tothrs($timerange, $shift_def_id['lunchmin']));
        $this->universal_model->updatez('id', $transid, 'trans', $manualentry);
    }

    // Report Editing
    function savemanualentry()
    {
        $id_timeback = $this->input->post('id');
        $time = $this->input->post('login');
        $logout = $this->input->post('logout');
        // $shift = $this->input->post('shift');
        $timev = preg_match('/^(([0-1][0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?)$/', $time);
        $timel = preg_match('/^(([0-1][0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?)$/', $logout);
        // $lunchminv = preg_match('/^(([0-1][0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?)$/', $lunchmin);
        if ($timev == true && $timel == true) {
            // Do Update
            $login24 = date('H:i', strtotime($time));
            $logout24 = date('H:i', strtotime($logout));
            if ($login24 != '00:00' && $logout24 != '00:00') {
                // Insert Editor
                $whatupdate = array(
                    'user_id' => $this->session->userdata('logged_in')['id'],
                    'trans_id' => $id_timeback,
                    'action' => 'addedmanualentry'
                );
                $this->universal_model->insertorignore('util_mantrack', $whatupdate);
                // Update Table
                $this->manualcomit($login24, $logout24, $id_timeback);
                $json_return = array(
                    'report' => 'Manual Entry Successfully Added',
                    'status' => 0
                );
            } else {
                $json_return = array(
                    'report' => "No Time Updates Given",
                    'status' => 1
                );
            }
            echo json_encode($json_return);
            // if($data[])
        } else {
            $json_return = array(
                'report' => "Enter Correct Formats Please!",
                'status' => 1
            );
            echo json_encode($json_return);
        }
    }
    //Manual Input Updates
    public function updatebranch()
    {
        $tablename = $this->input->post('tablename');
        $colname = $this->input->post('colname');
        $newvalue = $this->input->post('newvalue');
        $id = $this->input->post('id');
        $timev = $this->isValidDate($newvalue);
        $name = array();
        if ($timev == true) {
            $flag = 1;
            $this->session->set_flashdata($colname, $newvalue);
            $name['login'] = $this->session->flashdata('login');
            $name['logout'] = $this->session->flashdata('logout');
            if ($name['login'] != null && $name['logout'] != null) {
                $json_return = array(
                    'report' => 'Manual Entry Successfully Added',
                    'status' => 0
                );
                $whatupdate = array(
                    'user_id' => $this->session->userdata('logged_in')['id'],
                    'trans_id' => $id,
                    'action' => 'addedmanualentry'
                );
                $this->universal_model->insertorignore('util_mantrack', $whatupdate);
                // Update Table
                $this->manualcomit($name['login'], $name['logout'], $id);
                // $name['login'] = $login24;
                // $name['logout'] = $logout24;
                echo json_encode($json_return);
            } else {
                $json_return = array(
                    'report' => 'Enter Both Values',
                    'status' => 1
                );
                echo json_encode($json_return);
            }
        } else if ($timev == false) {
            $json_return = array(
                'report' => "Enter Correct Formats Please!",
                'status' => 2
            );
            echo json_encode($json_return);
        } else {
            $json_return = array(
                'report' => "Not Successfull Try Again Or Contact Admin",
                'status' => 3
            );
            echo json_encode($json_return);
        }
    }

    function isValidDate($timeStr)
    {
        $dateObj = DateTime::createFromFormat('d.m.Y H:i', "10.10.2010 " . $timeStr);
        if (
            $dateObj !== false && $dateObj && $dateObj->format('G') ==
            intval($timeStr)
        ) {
            return true;
            // echo 'valid  <br/>';
        } else {
            return false;
            // echo 'invalid <br/>';
        }
    }
}
