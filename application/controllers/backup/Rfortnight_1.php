<?php

ini_set('max_execution_time', 300);
// require_once APPPATH . 'vendor/autoload.php';
require_once APPPATH . 'libraries/sync.php';

// use Brick\Db\Bulk\BulkDeleter;
class Aotone extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('universal_model');
    }

    public function index() {
        echo '<h1><b>' . 'Aot' . '</b></h1>';
    }

    public function reportlastupdate($serialnuber) {
        //PHASE ONE
        $reader_id = $this->universal_model->selectz('*', 'util_branch_reader', 'readerserial', $serialnuber)[0]['id'];
        $newpinsdata = $this->universal_model->selectzuniquei(array('id'), 'employeeprofile', 'branch_id', $reader_id);
        $alluserstypes = $this->universal_model->selectall(array('id', 'employementtype'), 'employementtypes');
        $statusemplo = array();
        foreach ($alluserstypes as $searchtype) {
            $checkemptypnumber = searcharray($searchtype['id'], 'employmenttype_id', $newpinsdata);
            $statusemplo[$searchtype['employementtype']] = count($checkemptypnumber);
        }
        //PHASE TWO
//        $newpinsdatatwo = $this->universal_model->selectzuniquei(array('pin'), 'attendencelog', 'serialnumber', $serialnuber);
        $lastupdatethisbrancharray = $this->universal_model->getlatestupdatebybranch($serialnuber);
        $datelastupdate = $lastupdatethisbrancharray[count($lastupdatethisbrancharray) - 1]['exactdate'];
        $statusemplo['lastupdate'] = date("F jS, Y", strtotime($datelastupdate));
        $statusemplo['numberofemply'] = count($newpinsdata);
        echo json_encode($statusemplo);
    }

    public function reportdailysum() {
        //PHASE ONE
        $serialnumber = $this->input->post('serialnumber');
        $date_daily = $this->input->post('datedaily');
        $stringrangeabse = 'dateclocktime LIKE "%00:00:00%"';
        $stringrangepre = 'dateclocktime NOT LIKE "%00:00:00%"';
        $selectbyclienttimeabse = $this->universal_model->selectzy_var('*', 'trans', 'dateclock', $date_daily, 'serialnumber', $serialnumber, $stringrangeabse);
        $selectbyclienttimepre = $this->universal_model->selectzy_var('*', 'trans', 'dateclock', $date_daily, 'serialnumber', $serialnumber, $stringrangepre);
        $statusemplo = array();
        $statusemplo['absenttotal'] = count($selectbyclienttimeabse);
        $statusemplo['presenttotal'] = count($selectbyclienttimepre);
        $statusemplo['messegeintor'] = "On this Date " . converttodate($date_daily, 'F jS, Y');
//        print_array($statusemplo);
        echo json_encode($statusemplo);
    }

    public function test() {

        //More On This Later
//        $newpinsdata = $this->universal_model->selectuniuquefortransupadteday('2018-12-12', 'AIOR181260318');
// 		$newpinsdata = $this->universal_model->selectuniuquefortransupadte ( '2018-11', '6583151600211' );
//        print_array($newpinsdata);
    }

    public function readmeerfolder() {
        try {
            $myzippedfiles = glob(APPPATH . 'meer/' . "*.zip");
            if (empty($myzippedfiles)) {
                $this->reporttome('nozippfiles', 'readmeerfolder@Aot', 1);
            } else {
                $successn = 0;
                $failed = 0;
                foreach ($myzippedfiles as $fileinprocess) {
                    copy($fileinprocess, APPPATH . 'tempbackup/' . print_var_name_array($fileinprocess));
                    $zip = new ZipArchive ();
                    $res = $zip->open($fileinprocess);
                    if ($res === TRUE) {
                        $zip->extractTo(APPPATH . 'meer/');
                        $zip->close();
                        // Delete Our Freind
                        unlink($fileinprocess);
                        $successn ++;
                        // $this->readmeerfolder();
                    } else {
                        $failed ++;
                    }
                }
                if ($failed != 0) {
                    $this->reporttome('failedToUnzipp number #' . $failed, 'readmeerfolder@Aot', 1);
                }
                if ($successn != 0) {
                    $this->reporttome('successfullyUnzipped number #' . $successn, 'readmeerfolder@Aot', 1);
                }
            }
            $mytxtfiles = glob(APPPATH . 'meer/' . "*.txt");
            $serialnumber = 0;
            if (empty($mytxtfiles)) {
                // $this->reporttome('notextfiles', 'readmeerfolder@Aot', 1);
            } else {
                foreach ($mytxtfiles as $textfile) {
                    // echo $textfile.'<br>';
                    if (strpos($textfile, 'alluserinfo')) {
                        $this->alluserreceiver($textfile);
                    }
                    if (strpos($textfile, 'attendencelog')) {
                        $attendencelog = include $textfile;
                        if (empty($attendencelog)) {
                            $serialnumber = 0;
                        } else {
                            $serialnumber = $attendencelog [0] ['compay_reader_id'];
                            // print_array ( $serialnumber );
                        }
                        $this->atlogreceiver($textfile);
                    }
                }
            }
        } catch (Exception $ex) {
            print_array($ex->getMessage());
        } finally {
            $datereeived = date('Y-m-d');
            if ($serialnumber !== 0) {
                // $newpinsdata = $this->universal_model->selectuniuquefortransupadteday ( $datereeived, $serialnumber );
                $this->manualload($datereeived, $serialnumber);
                // print_array ( $newpinsdata );
            } else {
                $this->reporttome('noreportgenerates', 'readmeerfolder@Aot', 1);
            }
            // echo $serialnumber.' '.$datereeived;
        }
    }

    public function atlogreceiver($attendencelog_data) {
        $attendencelog = include $attendencelog_data;
        if (empty($attendencelog)) {
            unlink($attendencelog_data);
            $this->reporttome('nonewuserlogs', 'atlogreceiver@Aot', 1);
        } else {
            $totalrecords = count($attendencelog);
            $this->db->trans_start();
            $totalrecords = 0;
            foreach ($attendencelog as $userlog) {
                $totalrecords ++;
                // Njovu
                $this->userdefaultdata($userlog ['pin']);
                $userlogarray = array(
                    'serialnumber' => $userlog ['compay_reader_id'],
                    'pin' => $userlog ['pin'],
                    'exactdate' => $userlog ['datetime_reader'],
                    'verified' => $userlog ['verified'],
                    'status' => $userlog ['status'],
                    'workcode' => $userlog ['workcode'],
                    'timeinserts' => $userlog ['timeinserts']
                );
//                if ($totalrecords == 500) {
////                    print_array($userlogarray);
//                    $totalrecords = 0;
//                    $this->universal_model->updateOnDuplicate('attendencelog', $userlogarray);
//                } else if ($totalrecords < 500) {
//                    $this->universal_model->updateOnDuplicate('attendencelog', $userlogarray);
//                }
                $this->universal_model->updateOnDuplicate('attendencelog', $userlogarray);
                // array_push($megasega, $userlogarray);
            }
            $this->db->trans_complete();
            unlink($attendencelog_data);
            $this->reporttome('totalrecords#' . $totalrecords . ' totalinsertedorupdated#', 'atlogreceiver@Aot', 1);
        }
    }

    public function alluserreceiver($alluserinfo_data) {
        $alluserinfo = include $alluserinfo_data;
        if (empty($alluserinfo)) {
            $this->reporttome('nonewuserinfo', 'alluserreceiver@Aot', 1);
            unlink($alluserinfo_data);
        } else {
            $totalrecords = count($alluserinfo);
            $totalinserted = 0;
            $this->db->trans_start();
            foreach ($alluserinfo as $oneuser) {
                $totalinserted++;
                $array_user = array(
                    'serialnumber' => $oneuser ['compay_reader_id'],
                    'pin' => $oneuser ['pin'],
                    'pintwo' => $oneuser ['pin2'],
                    'names' => $oneuser ['name'],
                    'previlage' => $oneuser ['privilageex'],
                );
//                print_array($array_user);
                $this->userdefaultdata($oneuser['pin2']);
                $this->universal_model->updateOnDuplicate('attendence_alluserinfo', $array_user);
            }
            $this->db->trans_complete();
            unlink($alluserinfo_data);
            $this->reporttome('totalrecords#' . $totalrecords . ' totalinserted#' . $totalinserted, 'alluserreceiver@Aot', 1);
        }
    }

    public function readerreceiver() {
        $reader_data = $this->input->post(NULL, TRUE);
        $number_data = count($reader_data);
        $actual_count = 0;
        if (empty($reader_data)) {
            $result = array(
                'id' => 0,
                'type' => 'Reader',
                'typecode' => 1,
                'datasize' => $number_data
            );
            echo json_encode($result);
        } else {
            foreach ($reader_data as $reader) {
                $devicearray = array(
                    'reader_serialnumber' => $reader ['reader_serialnumber'],
                    'device_ipaddress' => $reader ['device_ipaddress'],
                    'company_name' => $reader ['company_name'],
                    'device_name' => $reader ['device_name']
                );
                $checkreader = $this->universal_model->selectz('*', 'company_reader', 'device_ipaddress', $reader ['device_ipaddress']);
                if (empty($checkreader)) {
                    $vara = $this->universal_model->insertz('company_reader', $devicearray);
                    $actual_count ++;
                } else {
                    $vara = $this->universal_model->updatez('device_ipaddress', $reader ['device_ipaddress'], 'company_reader', $devicearray);
                }
            }
            $result = array(
                'id' => $vara,
                'type' => 'Reader',
                'typecode' => 1,
                'actual_size' => $actual_count,
                'datasize' => $number_data
            );
            echo json_encode($result);
        }
    }

    public function check_alllog() {
        $checkreader = $this->universal_model->getlastrow('attendencelog');
        echo json_encode($checkreader);
    }

    public function check_alluser() {
        $checkreader = $this->universal_model->getlastrow('attendence_alluserinfo');
        echo json_encode($checkreader);
    }

    function reporttome($message, $methodclass, $show = 0) {
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

    function hours_tomins($timetoo, $timefrom) {
        if (strtotime($timetoo) < strtotime($timefrom)) {
            $total = 0;
        } else if (strtotime($timetoo) > strtotime($timefrom)) {
            $total = strtotime($timetoo) - strtotime($timefrom);
        } else {
            $total = 0;
        }

        $hours = floor($total / 60 / 60);
        $minutes = round(($total - ($hours * 60 * 60)) / 60);
        $minutestwo = $hours * 60;
        $totalminutes = $minutes + $minutestwo;
        return $totalminutes;
    }

    // Time Trans
    public function getshiftidbyname() {
        $idget = $this->universal_model->select_like('shiftype', 'attendence_shiftdef', 'DAY SHIFT-NORMAL');
        return $idget [0] ['id'];
    }

    public function getdepartmentidbyname() {
        $idget = $this->universal_model->select_like('deptname', 'attendence_util_department', 'DEPARTMENT ONE');
        return $idget [0] ['id'];
    }

    // Used To Be Dm
    public function manualload($date, $serialnumber) {
        $start = microtime(true);
        $newpinsdata = $this->universal_model->selectuniuquefortransupadteday($date, $serialnumber);
        $this->db->trans_start();
        foreach ($newpinsdata as $datadate) {
            $getmearray1 = $this->fullfledgedreportrecord($datadate ['datelike'], $this->availablemonthlydata($datadate ['pin'], $datadate ['datelike'], $datadate ['serialnumber']));
            // $result = array();
            array_walk($getmearray1, function ($value, $key) use (&$result) {
                unset($value ['exactdate']);
                unset($value ['dateinsertserver']);
                unset($value ['names']);
                unset($value ['id_util_department']);
                unset($value ['shiftmancode']);
                unset($value ['shiftfrom']);
                unset($value ['shiftto']);
                unset($value ['shiftype']);
                unset($value ['lunchmin']);
                unset($value ['day']);
                $this->universal_model->updateOnDuplicate('trans', $value);
            });
        }
        $this->db->trans_complete();
        $time_elapsed_secs = microtime(true) - $start;
        print_array(date("H:i:s", $time_elapsed_secs));
    }

    public function manualload_monthly($date, $serialnumber) {
        $start = microtime(true);
        $newpinsdata = $this->universal_model->selectuniuquefortransupadtedayfullmonth($date, $serialnumber);
//        print_array($newpinsdata);
        $this->db->trans_start();
        foreach ($newpinsdata as $datadate) {
//            print_array($datadate ['datelike']);
            $firstpartarray = $this->availablemonthlydata($datadate ['pin'], $datadate ['datelike'], $datadate ['serialnumber']);
//            print_array($firstpartarray);
            $getmearray1 = $this->fullfledgedreportrecord($datadate ['datelike'], $firstpartarray);
            // $result = array();
//            print_array($firstpartarray);
            array_walk($getmearray1, function ($value, $key) use (&$result) {
                unset($value ['exactdate']);
                unset($value ['dateinsertserver']);
                unset($value ['names']);
                unset($value ['id_util_department']);
                unset($value ['shiftmancode']);
                unset($value ['shiftfrom']);
                unset($value ['shiftto']);
                unset($value ['shiftype']);
                unset($value ['lunchmin']);
                unset($value ['day']);
                print_array($value);
//                $this->universal_model->updateOnDuplicate('trans', $value);
            });
        }
        $this->db->trans_complete();
        $time_elapsed_secs = microtime(true) - $start;
        print_array(date("H:i:s", $time_elapsed_secs));
    }

    function fullfledgedreportrecord($date, $fullfill) {
        $yearmonthparts = explode('-', $date);
        $fulldata_montarray = array();
        $d = cal_days_in_month(CAL_GREGORIAN, $yearmonthparts [1], $yearmonthparts [0]);
        $number = range(1, $d);
        $array_borrow_values = array();
        foreach ($number as $valueseethis) {
            $datainquestion = $date . '-' . sprintf("%02d", $valueseethis);
//            print_array($datainquestion);
            if (array_key_exists($datainquestion, $fullfill)) {
                $array_borrow_values = $fullfill [$datainquestion];
                array_push($fulldata_montarray, $array_borrow_values);
            } else {
                if (empty($array_borrow_values)) {
                    $rand_keys = array_rand($fullfill, 1);
                    $array_borrow_values = $fullfill [$rand_keys];
                }
                $mergie_thefrog = array(
                    'pin' => $array_borrow_values ['pin'],
                    'exactdate' => $datainquestion . ' 00:00:00',
                    'dateclock' => $datainquestion,
                    'dateclocktime' => ' 00:00:00',
                    'login' => '',
                    'logout' => '',
                    'firstdayofweek' => getfirstday_of_week($datainquestion),
                    'serialnumber' => $array_borrow_values ['serialnumber'],
                    'timeinserts' => $array_borrow_values ['timeinserts'],
                    'dateinsertserver' => $array_borrow_values ['timeinserts'] . ' 00:00:00',
                    'names' => $array_borrow_values ['names'],
                    'user_id' => $array_borrow_values ['user_id'],
                    'id_util_department' => $array_borrow_values ['id_util_department'],
                    'id_shift_def' => $array_borrow_values ['id_shift_def'],
                    'shiftmancode' => $array_borrow_values ['shiftmancode'],
                    'shiftfrom' => $array_borrow_values ['shiftfrom'],
                    'shiftto' => $array_borrow_values ['shiftto'],
                    'shiftype' => $array_borrow_values ['shiftype'],
                    'lunchmin' => $array_borrow_values ['lunchmin'],
                    'deptcode' => $array_borrow_values ['deptcode'],
                    'tothrs' => '',
                    'normaltime' => $this->normaltime($array_borrow_values ['shiftfrom'], $array_borrow_values ['shiftto'], $array_borrow_values ['lunchmin'], $array_borrow_values['id_shift_def'], $datainquestion, $array_borrow_values ['pin']),
                    'normaltime' => $array_borrow_values ['normaltime'],
                    'mot15' => '',
                    'ot15' => '',
                    'leavestatus' => $this->getleavecodeifexistondate($datainquestion, $array_borrow_values ['pin']),
                    'lostt' => $this->getlosttimedeterm($datainquestion, $array_borrow_values ['normaltime']),
                    'weekday' => getDayWeekFromNumber(getWeekday($datainquestion)),
                    'weekyear' => getWeekYear($datainquestion),
                    'off' => $this->getlosttimedetern($datainquestion),
                    'ot20' => ''
                );
                array_push($fulldata_montarray, $mergie_thefrog);
            }
        }
        return $fulldata_montarray;
    }

    // public function more($userpin, $date_like, $serialnumber)
    public function availablemonthlydata($userpin, $date_like, $serialnumber) {
        // $newpinsdata = $this->universal_model->joinpinscard('13675538', '2018-11', 'AIOR181260318');
        $newpinsdata = $this->universal_model->joinpinscard_prev($userpin, $date_like, $serialnumber);
        $output = array_reduce($newpinsdata, function (array $carry, array $item) {
            $city = $item ['dateclock'];
            if (array_key_exists($city, $carry)) {
                $carry [$city] ['dateclocktime'] .= '@' . $item ['dateclocktime'];
//                print_array($item ['dateclock'] . ' ');
                // CreatedArrays Virtual
                $carry [$city] ['tothrs'] = $this->tothrs($carry [$city] ['dateclocktime'], $item ['lunchmin']);
                $carry [$city] ['login'] = $this->loginlogout($carry [$city] ['dateclocktime'], 1);
                $carry [$city] ['logout'] = $this->loginlogout($carry [$city] ['dateclocktime'], 0);
                $carry [$city] ['normaltime'] = $this->normaltimex($item ['shiftfrom'], $item ['shiftto'], $item ['lunchmin']);
                $carry [$city] ['mot15'] = $this->mot15($item ['shiftfrom'], $carry [$city] ['dateclocktime'], $item['id_shift_def'], $item['dateclock'], $item ['pin']);
                $carry [$city] ['ot15'] = $this->ot15($item ['shiftto'], $carry [$city] ['dateclocktime'], $item['id_shift_def'], $item['dateclock'], $item ['pin']);
                $carry [$city] ['lostt'] = $this->lostt($item ['shiftto'], $item ['shiftfrom'], $carry [$city] ['dateclocktime'], $item['dateclock'], $item ['pin']);
                $carry [$city] ['weekday'] = getDayWeekFromNumber(getWeekday($item ['dateclock']));
                $carry [$city] ['weekyear'] = getWeekYear($item ['dateclock']);
                $carry [$city] ['leavestatus'] = $this->getleavecodeifexistondate($item ['dateclock'], $item ['pin']);
                $carry [$city] ['off'] = $this->off_caluculus($item ['dateclock'], $this->tothrs($carry [$city] ['dateclocktime'], $item ['lunchmin']), $item ['pin']);
                $carry [$city] ['ot20'] = $this->ot20($item ['dateclock'], $this->tothrs($carry [$city] ['dateclocktime'], $item ['lunchmin']));
            } else {
                $carry [$city] = $item;
                $carry [$city] ['normaltime'] = $this->normaltimex($item ['shiftfrom'], $item ['shiftto'], $item ['lunchmin']);
//               
            }
            return $carry;
        }, array());
        return $output;
    }

    // Below Are Helper Functions
    public function userdefaultdata($pin) {
        $arraydata = $this->universal_model->selectz('*', 'users', 'pin', $pin);
//        print_array($arraydata);
        $getnames_array = $this->universal_model->selectz('names', 'attendence_alluserinfo', 'pintwo', $pin);
        if (empty($arraydata) && !empty($getnames_array)) {
            $getbigest = $this->universal_model->getlastrow('users');
            $getbigest = json_encode($getbigest);
            $getbigest = json_decode($getbigest, true);
            $getnames = $getnames_array[0]['names'];
            //
            $employeecoderaw = $getbigest ['employee_code'];
            $firstCharacter = substr($employeecoderaw, 0, 1);
//            print_array($firstCharacter);
            if ($firstCharacter == '') {
                $firstCharacter = '.';
            }
            $employeecoderawtwo = explode($firstCharacter, $employeecoderaw);
            $newcode = $employeecoderawtwo [1] + 1;
            $employee_code = 'U' . $newcode;
            $user_id = getToken(6) . '@AT';
            // $pin = $pin;
            $user_image_small = '50_iconuserdefault.png';
            $user_image_medium = '60_iconuserdefault.png';
            $user_image_big = '500_iconuserdefault.png';
            $emailaddress = $employee_code . '@mail.com';
            $password = '123456';
            $names = explode(' ', $getnames);
            //print_array($names);
            if (!empty($names)) {
                if (count($names) == 3) {
                    $firstname = $names [0];
                    $lastname = $names [1];
                    $middlename = $names [2];
                } else if (count($names) == 2) {
                    $firstname = $names [0];
                    $lastname = $names [1];
                    $middlename = 'Update';
                } else if (count($names) == 1) {
                    $firstname = $names [0];
                    $lastname = 'Update';
                    $middlename = 'Update';
                } else {
                    $firstname = 'Update';
                    $lastname = 'Update';
                    $middlename = 'Update';
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
                'middlename' => $middlename,
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
        }
        if (!empty($arraydata)) {
            if (is_numeric($arraydata[0]['firstname'])) {
                $getnames = $getnames_array[0]['names'];
                $names = explode(' ', $getnames);
                if (count($names) == 3) {
                    $firstname = $names [0];
                    $lastname = $names [1];
                    $middlename = $names [2];
                } else if (count($names) == 2) {
                    $firstname = $names [0];
                    $lastname = $names [1];
                    $middlename = 'Update';
                } else if (count($names) == 1) {
                    $firstname = $names [0];
                    $lastname = 'Update';
                    $middlename = 'Update';
                } else {
                    $firstname = 'Update';
                    $lastname = 'Update';
                    $middlename = 'Update';
                }
                $array_toupdate = array(
                    'id' => $arraydata[0]['id'],
                    'firstname' => $firstname,
                    'lastname' => $lastname,
                    'middlename' => $middlename
                );
                $this->universal_model->updateOnDuplicate('users', $array_toupdate);
            }
        }
    }

    function loginlogout($array_date, $whichone) {
        $logibnlogoutarray = explode('@', $array_date);
        $sizearray = count($logibnlogoutarray);
        // print_array($sizearray);
        switch ($sizearray) {
            case 1 :
                // print_array($sizearray);
                if ($whichone == 1) {
                    return $logibnlogoutarray [0];
                } else {
                    return $logibnlogoutarray [0];
                }
                // return $tothrs;
                break;
            case 2 :
                if ($whichone == 1) {
                    return $logibnlogoutarray [0];
                } else if ($whichone == 0) {
                    return $logibnlogoutarray [1];
                }
                break;
            default :
                if ($whichone == 1) {
                    return $logibnlogoutarray [0];
                } else if ($whichone == 0) {
                    return $logibnlogoutarray [$sizearray - 1];
                }
                // print_array($logibnlogoutarray);
                break;
        }
    }

    function getleavecodeifexistondate($date, $userpin) {
        $leave = $this->universal_model->selectzy('leavecode', 'attendence_leaves', 'leavedate', $date, 'userpin', $userpin);
        if (empty($leave)) {
            return 'XXX';
        } else {
            return $leave [0] ['leavecode'];
        }
    }

    function ot20($dateclock, $tothrs) {
        $publicholiday = $this->universal_model->selectztimholmt(changedateformate($dateclock));
        if (!empty($publicholiday) && $tothrs != '0') {
            return $tothrs;
        }
    }

    function off_caluculus($dateclock, $tothrs, $pin) {
        $weekday = date("D", strtotime($dateclock));
        if ($weekday == "Sun" && $tothrs > 0) {
            // Becarefull To Inspect This Insert
            $message_array = array(
                'pin' => $pin,
                'date' => $dateclock,
                'status' => 1
            );
            $this->universal_model->updateOnDuplicate('util_offworked', $message_array);
            return 'worked off';
        } else if ($weekday == "Sun") {
//            print_array($weekday);
            return 'off';
        } else {
            return '';
        }
    }

    function tothrscalc($fromtime, $totime, $lunchmins) {
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

    public function lostt($shiftto, $shiftfrom, $dateclocktime, $dateday, $pin) {
        $weekday = date("D", strtotime($dateday));
        $exemptstatus = $this->universal_model->selectz(array('exempt_ot', 'exempt_lost', 'exempt_clocking'), 'users', 'pin', $pin);
        $exempt_lost = array_shift($exemptstatus)['exempt_lost'];
        if ($weekday == "Sun") {
            return "";
        } else if ($exempt_lost == 1) {
            return "";
        } else {
            $logibnlogoutarray = explode('@', $dateclocktime);
            $count_login = count($logibnlogoutarray);
            $shiftto = date_create($shiftto);
            $logout = date_create($logibnlogoutarray [$count_login - 1]);
            // .......
            if ($logout < $shiftto) {
                $diff = date_diff($shiftto, $logout);
                $time = date('H:i:s', strtotime($diff->format("%h:%i:%s")));
                $totallosttime1 = $time;
            } else {
                $totallosttime1 = '0:00:0';
            }
            $shiftfrom = date_create($shiftfrom);
            $login = date_create($logibnlogoutarray [0]);
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
    }

    public function ot15($shiftto, $dateclocktime, $shiftid, $day, $pin) {
        $exemptstatus = $this->universal_model->selectz(array('exempt_ot', 'exempt_lost', 'exempt_clocking'), 'users', 'pin', $pin);
        $exempt_ot = array_shift($exemptstatus)['exempt_ot'];
//        print_array($exempt_ot);
        if ($exempt_ot == 0) {
            return "";
        } else {
            $weekday = date("D", strtotime($day));
            $shiftdeducs = $this->universal_model->selectzy(array('shiftstarts', 'shift_end'), 'shiftdefdetails', 'day_week', $weekday, 'id_attendence_shiftdef', $shiftid);
            if (empty($shiftdeducs)) {
                $logibnlogoutarray = explode('@', $dateclocktime);
                $count_login = count($logibnlogoutarray);
                $shiftto = date_create($shiftto);
                $logout = date_create($logibnlogoutarray [$count_login - 1]);
                // .......
                if ($logout > $shiftto) {
                    $diff = date_diff($logout, $shiftto);
                    $time = date('H:i:s', strtotime($diff->format("%h:%i:%s")));
                    return decimalHours($time);
                } else {
                    return '';
                }
            } else {
                $logibnlogoutarray = explode('@', $dateclocktime);
                $count_login = count($logibnlogoutarray);
                $end = $shiftdeducs[0]['shift_end'];
                $shiftto = date_create($end);
                $logout = date_create($logibnlogoutarray[$count_login - 1]);
                $emp = array('logout' => $logibnlogoutarray[$count_login - 1], 'shifto' => $end);
                // .......
                if ($logout > $shiftto) {
                    $diff = date_diff($logout, $shiftto);
                    $time = date('H:i:s', strtotime($diff->format("%h:%i:%s")));
                    return decimalHours($time);
//                    return 1;
                } else {
                    return '';
                }
            }
        }
    }

    public function mot15($shiftfrom, $dateclocktime, $shiftid, $day, $pin) {
        $exemptstatus = $this->universal_model->selectz(array('exempt_ot', 'exempt_lost', 'exempt_clocking'), 'users', 'pin', $pin);
        $exempt_ot = array_shift($exemptstatus)['exempt_ot'];
//        print_array($exemptstatus);
//        $exempt_ot = 1;
        if ($exempt_ot == 0) {
            return "";
        } else {
            $weekday = date("D", strtotime($day));
            $shiftdeducs = $this->universal_model->selectzy(array('shiftstarts', 'shift_end'), 'shiftdefdetails', 'day_week', $weekday, 'id_attendence_shiftdef', $shiftid);
            if (empty($shiftdeducs)) {
                $logibnlogoutarray = explode('@', $dateclocktime);
                $shiftfrom = date_create($shiftfrom);
                $login = date_create($logibnlogoutarray [0]);
                // .......
                if ($login < $shiftfrom) {
                    $diff = date_diff($shiftfrom, $login);
                    $time = date('H:i:s', strtotime($diff->format("%h:%i:%s")));
                    return decimalHours($time);
                } else {
                    return '';
                }
            } else {
                $logibnlogoutarray = explode('@', $dateclocktime);
                $start = $shiftdeducs[0]['shiftstarts'];
                $shiftfrom = date_create($start);
                $login = date_create($logibnlogoutarray [0]);
                // .......
                if ($login < $shiftfrom) {
                    $diff = date_diff($shiftfrom, $login);
                    $time = date('H:i:s', strtotime($diff->format("%h:%i:%s")));
//                    print_array(decimalHours($time));
                    return decimalHours($time);
                } else {
                    return '';
                }
            }
        }
    }

    public function normaltimex($shiftfrom, $shiftto, $lunchmin) {
        $start = date_create($shiftfrom);
        $end = date_create($shiftto);
        $minuteslunch = minutes($lunchmin);
        $stringtoreduce = '-' . ' ' . $minuteslunch . ' minutes';
        $diff = date_diff($end, $start);
        // print_array($diff);
        $time = date('H:i:s', strtotime($diff->format("%h:%i:%s") . $stringtoreduce));
        return decimalHours($time);
    }

    public function normaltime($shiftfrom, $shiftto, $lunchmin, $shiftid, $day) {
//        print_array($shiftfrom . ' | ' . $shiftto . ' | ' . $lunchmin . ' | ' . $shiftid . ' | ' . $day);
//        print_array($day);
        $weekday = date("D", strtotime($day));
        $shiftdeducs = $this->universal_model->selectzy(array('shiftstarts', 'shift_end'), 'shiftdefdetails', 'day_week', $weekday, 'id_attendence_shiftdef', $shiftid);
        if (empty($shiftdeducs)) {
            $start = date_create($shiftfrom);
            $end = date_create($shiftto);
            $minuteslunch = minutes($lunchmin);
            $stringtoreduce = '-' . ' ' . $minuteslunch . ' minutes';
            $diff = date_diff($end, $start);
            // print_array($diff);
            $time = date('H:i:s', strtotime($diff->format("%h:%i:%s") . $stringtoreduce));
            return decimalHours($time);
        } else {
            $startp = $shiftdeducs[0]['shiftstarts'];
            $endp = $shiftdeducs[0]['shift_end'];
            $minuteslunch = minutes($lunchmin);
            $startTime = new DateTime($startp);
            $endTime = new DateTime($endp);
            $duration = $startTime->diff($endTime);
            $stringtoreduce = '-' . ' ' . $minuteslunch . ' minutes';
            $time = date('H:i:s', strtotime($duration->format("%H:%I:%S") . $stringtoreduce));
            $en = decimalHours($time);
//            print_array($startp . ' | ' . $endp . ' | ' . $en);
            return $en;
        }
    }

// fun_tothrs
    public function tothrs($a, $lunchmins) {
        // $a = '';
        $logibnlogoutarray = explode('@', $a);
        $sizearray = count($logibnlogoutarray);
        // print_array($sizearray);
        switch ($sizearray) {
            case 1 :
                return '';
                break;
            case 2 :
                $tothrs = $this->tothrscalc($logibnlogoutarray [1], $logibnlogoutarray [0], $lunchmins);
                return $tothrs;
                break;
            default :
                $tothrs = $this->tothrscalc($logibnlogoutarray [$sizearray - 1], $logibnlogoutarray [0], $lunchmins);
                return $tothrs;
                break;
        }
    }

    function getlosttimedeter($dateinq, $dateoffday, $flag, $tohrs) {
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

    function getlosttimedeterm($dateinq, $tohrs) {
        $weekday = date("D", strtotime($dateinq));
        if ($weekday == "Sun") {
            return '';
        } else {
            return $tohrs;
        }
    }

    function getlosttimedetern($dateinq) {
        $weekday = date("D", strtotime($dateinq));
        if ($weekday == "Sun") {
            // Becarefull To Inspect This Insert
            return 1;
        } else {
            return '';
        }
    }

    // HELPERS
    // Called At Core Change
    public function manualcomit($login, $logout, $transid) {
        // $login = '06:57';
        // $logout = '20:31';
        $timerange = $login . '@' . $logout;
        $data = $this->universal_model->selectz('*', 'trans', 'id', $transid);
        $shift_def = $this->universal_model->selectz('lunchmin,shiftfrom,shiftto', 'attendence_shiftdef', 'shiftmancode', $data [0] ['id_shift_def']);
        // print_array($shift_def);
        $manualentry = array();
        $manualentry ['dateclocktime'] = $timerange;
        $manualentry ['login'] = $login;
        $manualentry ['logout'] = $logout;
        $manualentry ['normaltime'] = $data [0] ['normaltime'];
        $manualentry ['tothrs'] = $this->tothrs($timerange, $shift_def [0] ['lunchmin']);
        $manualentry ['mot15'] = $this->mot15($shift_def [0] ['shiftfrom'], $timerange);
        // print_array($manualentry);
        // DEFAULT FOR NOW
        $manualentry ['leavestatus'] = 'XXX';
        $manualentry ['ot15'] = $this->ot15($shift_def [0] ['shiftto'], $timerange);
        $manualentry ['lostt'] = $this->lostt($shift_def [0] ['shiftto'], $shift_def [0] ['shiftfrom'], $timerange);
        // $manualentry['weekday'] = $data[0]['weekday'];
        // $manualentry['weekyear'] = $data[0]['weekyear'];
        $manualentry ['off'] = $this->off_caluculus($data [0] ['dateclock'], $this->tothrs($timerange, $shift_def [0] ['lunchmin']), $data [0] ['pin']);
        // print_array($manualentry);
        $manualentry ['manual'] = 'm';
        $manualentry ['ot20'] = $this->ot20($data [0] ['dateclock'], $this->tothrs($timerange, $shift_def [0] ['lunchmin']));
        $this->universal_model->updatez('id', $transid, 'trans', $manualentry);
    }

    // Report Editing
    function savemanualentry() {
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
                    'user_id' => $this->session->userdata('logged_in') ['id'],
                    'trans_id' => $id_timeback,
                    'action' => 'addedmanualentry'
                );
                $this->universal_model->insertorignore('util_mantrack', $whatupdate);
                // Update Table
                $this->universal_model->selectz('pin', 'users', 'user_id');
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

    function do_uploadlogs() {
        if (!empty($_FILES["filezip"]["name"])) {
            $fileactualname = $this->input->post('namefile');
//        $fileName = $_FILES['filezip']['name'];
            $targetPath = APPPATH . 'meer/' . $fileactualname;
            $sourcePath = $_FILES['filezip']['tmp_name'];
            if (move_uploaded_file($sourcePath, $targetPath)) {
                $message = 'Log Updated';
            } else {
                $message = 'No Logs Sent';
            }
        } else {
            $message = 'directly Accessed Cant Work';
        }
        echo json_encode($message);
    }

}
