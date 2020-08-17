<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
include_once(dirname(__FILE__) . "/Aot.php");
require_once APPPATH . 'libraries/EditableGrid.php';
class Posts extends Aot
{

    // The person's date of birth.
    public function __construct()
    {
        parent::__construct();
        $this->load->model('universal_model');
    }

    public function index()
    {
        echo '<h1>POSTS Api ...</h1>';
    }

    public function oppo()
    {
        $nemo = $this->getshiftdetails(9)['shiftype'];
        if (empty($nemo)) { }
        // $nemo= $this->getshiftdetails(1);
        print_array($nemo);
    }

    public function get_lefttallocated($shift_id, $department_id)
    {
        $selectwhat = array(
            'id',
            'user_id',
            'firstname',
            'lastname',
        );
        $shifts = $this->universal_model->attendence_joinshift($shift_id, $department_id, 0);
        if (empty($shifts)) {
            // Select All UnAlocated Employees
            $shifts = $this->universal_model->selectz($selectwhat, 'users', 'status_alocated', 0);
            // $removeshift = $this->universal_model->deletezm('attendence_util_user_shift', 'status_alocated', 0);
            echo json_encode($shifts);
        } else {
            echo json_encode($shifts);
        }
        // $shifts = $this->universal_model->selectz($selectwhat, 'users', 'status_alocated', 0);
        // echo json_encode($shifts);
    }

    public function get_rightallocated($shift_id, $department_id)
    {
        $shifts = $this->universal_model->attendence_joinshift($shift_id, $department_id, 1);
        echo json_encode($shifts);
    }

    public function addsingleuser($shift_id, $department_id)
    {
        $userid = $this->input->post('id');
        $whatupdate = array(
            'status_alocated' => 1,
        );
        $whatupdatemoretable = array(
            'user_id' => $userid,
            'id_util_department' => $department_id,
            'id_shift_def' => $shift_id,
        );
        $this->universal_model->updatez('id', $userid, 'users', $whatupdate);
        $this->universal_model->insertz('attendence_util_user_shift', $whatupdatemoretable);
        echo json_encode($_POST['id']);
    }

    public function addall($shift_id, $department_id)
    {
        $whatupdate = array(
            'status_alocated' => 1,
        );
        $selectwhat = array(
            'id',
            'user_id',
            'firstname',
            'lastname',
        );
        // Select All UnAlocated Employees
        $toupdateuser = $this->universal_model->selectz($selectwhat, 'users', 'status_alocated', 0);
        // $toupdateuser = $this->universal_model->attendence_joinshift($shift_id, $department_id, 0);
        foreach ($toupdateuser as $value) {
            $whatupdatemoretable = array(
                'user_id' => $value['id'],
                'id_util_department' => $department_id,
                'id_shift_def' => $shift_id,
            );
            $this->universal_model->updatez('id', $value['id'], 'users', $whatupdate);
            $this->universal_model->insertz('attendence_util_user_shift', $whatupdatemoretable);
        }
        echo json_encode('updateall ---');
    }

    public function removesingleuser($shift_id, $department_id)
    {
        $userid = $this->input->post('id');
        $whatupdate = array(
            'status_alocated' => 0,
        );
        $whatupdatemoretable = array(
            'user_id' => $userid,
            'id_util_department' => $department_id,
            'id_shift_def' => $shift_id,
        );
        $this->universal_model->updatez('id', $userid, 'users', $whatupdate);
        $this->universal_model->deletezmarray('attendence_util_user_shift', $whatupdatemoretable);
        echo json_encode($_POST['id']);
    }

    public function removeall($shift_id, $department_id)
    {
        $whatupdate = array(
            'status_alocated' => 0,
        );
        $toupdateuser = $this->universal_model->attendence_joinshift($shift_id, $department_id, 1);
        foreach ($toupdateuser as $value) {
            $whatupdatemoretable = array(
                'user_id' => $value['id'],
                'id_util_department' => $department_id,
                'id_shift_def' => $shift_id,
            );
            $this->universal_model->updatez('id', $value['id'], 'users', $whatupdate);
            $this->universal_model->deletezmarray('attendence_util_user_shift', $whatupdatemoretable);
        }
        echo json_encode('updateall ---');
    }

    public function shiftsettings($shift_id)
    {
        // $this->session->set_flashdata('shiftid', $shift_id);
        $this->session->set_userdata('shiftid', $shift_id);
        $arraymagaxx = array();
        $bbbb = $this->universal_model->selectz('*', 'shiftdefdetails', 'id_attendence_shiftdef', $shift_id);
        if (empty($bbbb)) {
            for ($index = 0; $index <= 6; $index++) {
                $jsjs = array(
                    'id_attendence_shiftdef' => $shift_id,
                    'day_week' => getDayWeekFromNumber($index),
                    'tol_beforestart' => '00:00',
                    'shiftstarts' => '00:00',
                    'tolerence_afterstart' => '00:00',
                    'tolerence_beforeend' => '00:00',
                    'shift_end' => '00:00',
                    'tolerence_afterend' => '00:00',
                    'normal_hours' => '00:00',
                    'min_hrs' => '00:00',
                    'maxmin_in' => '00:00',
                    'maxmin_out' => '00:00',
                );
                array_push($arraymagaxx, $jsjs);
            }
            echo json_encode($arraymagaxx);
        } else {
            $arraymaga = array();
            for ($index = 0; $index <= 6; $index++) {
                $nnnn = $this->universal_model->selectzy('*', 'shiftdefdetails', 'id_attendence_shiftdef', $shift_id, 'day_week', getDayWeekFromNumber($index));
                if (empty($nnnn)) {
                    $jsjs = array(
                        'id_attendence_shiftdef' => $shift_id,
                        'day_week' => getDayWeekFromNumber($index),
                        'tol_beforestart' => '00:00',
                        'shiftstarts' => '00:00',
                        'tolerence_afterstart' => '00:00',
                        'tolerence_beforeend' => '00:00',
                        'shift_end' => '00:00',
                        'tolerence_afterend' => '00:00',
                        'normal_hours' => '00:00',
                        'min_hrs' => '00:00',
                        'maxmin_in' => '00:00',
                        'maxmin_out' => '00:00',
                    );
                    array_push($arraymaga, $jsjs);
                } else {
                    array_push($arraymaga, $nnnn[0]);
                }
            }
            echo json_encode($arraymaga);
        }
    }

    // public function after_changeshift() {}
    public function after_changeshift()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $input = filter_input_array(INPUT_POST);
        } else {
            $input = filter_input_array(INPUT_GET);
        }
        if ($input['action'] === 'edit') {
            $daywalah = $this->input->post('day_week');
            $tol_beforestart = $this->input->post('tol_beforestart');
            $shiftstarts = $this->input->post('shiftstarts');
            $tolerence_afterstart = $this->input->post('tolerence_afterstart');
            $tolerence_beforeend = $this->input->post('tolerence_beforeend');
            $shift_end = $this->input->post('shift_end');
            $tolerence_afterend = $this->input->post('tolerence_afterend');
            $normal_hours = $this->input->post('normal_hours');
            $min_hrs = $this->input->post('min_hrs');
            $maxmin_in = $this->input->post('maxmin_in');
            $maxmin_out = $this->input->post('maxmin_out');
            // echo $tol_beforestart;
            $one = preg_match('/^(([0-1][0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?)$/', $tol_beforestart);
            $two = preg_match('/^(([0-1][0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?)$/', $shiftstarts);
            $three = preg_match('/^(([0-1][0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?)$/', $tolerence_afterstart);
            $four = preg_match('/^(([0-1][0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?)$/', $tolerence_beforeend);
            $five = preg_match('/^(([0-1][0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?)$/', $shift_end);
            $six = preg_match('/^(([0-1][0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?)$/', $tolerence_afterend);
            $seven = preg_match('/^(([0-1][0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?)$/', $normal_hours);
            $eight = preg_match('/^(([0-1][0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?)$/', $min_hrs);
            $nine = preg_match('/^(([0-1][0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?)$/', $maxmin_in);
            $ten = preg_match('/^(([0-1][0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?)$/', $maxmin_out);
            if ($one && $two && $three && $four && $five && $six && $seven && $eight && $nine && $ten) {
                $whatupdatemoretable = array(
                    'id_attendence_shiftdef' => $this->session->userdata('shiftid'),
                    'day_week' => $daywalah,
                    'tol_beforestart' => $tol_beforestart,
                    'shiftstarts' => $shiftstarts,
                    'tolerence_afterstart' => $tolerence_afterstart,
                    'tolerence_beforeend' => $tolerence_beforeend,
                    'shift_end' => $shift_end,
                    'tolerence_afterend' => $tolerence_afterend,
                    'normal_hours' => $normal_hours,
                    'min_hrs' => $min_hrs,
                    'maxmin_in' => $maxmin_in,
                    'maxmin_out' => $maxmin_out,
                );
                $checinsertup = $this->universal_model->selectzy('*', 'shiftdefdetails', 'id_attendence_shiftdef', $this->session->userdata('shiftid'), 'day_week', $daywalah);
                if (empty($checinsertup)) {
                    $this->universal_model->insertz('shiftdefdetails', $whatupdatemoretable);
                } else {
                    $this->universal_model->updatem('id_attendence_shiftdef', $this->session->userdata('shiftid'), 'day_week', $daywalah, 'shiftdefdetails', $whatupdatemoretable);
                }
                // $this->universal_model->insertz('shiftdefdetails', $whatupdatemoretable);
                $json_return = array(
                    'report' => "Updated Successfully",
                    'status' => 0,
                );
                echo json_encode($json_return);
            } else {
                $json_return = array(
                    'report' => "Invalid Input",
                    'status' => 1,
                );
                echo json_encode($json_return);
            }
            // echo json_encode($tolerence_afterend);
        } else if ($input['action'] === 'delete') {
            // echo json_encode('mama');
        } else if ($input['action'] === 'restore') {
            // echo json_encode('xxxx');
        }
        // echo json_encode($input);
        // echo json_encode($_POST);
    }

    public function editshifts()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $input = filter_input_array(INPUT_POST);
        } else {
            $input = filter_input_array(INPUT_GET);
        }
        if ($input['action'] === 'edit') {
            $shiftone = $this->input->post('shiftfrom');
            $shifttwo = $this->input->post('shiftto');
            $shifthree = $this->input->post('shiftype');
            $remarks = $this->input->post('remarks');
            $lunchmin = $this->input->post('lunchmin');
            $one = preg_match('/^(([0-1][0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?)$/', $shiftone);
            $two = preg_match('/^(([0-1][0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?)$/', $shifttwo);
            $three = preg_match('/^(([0-1][0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?)$/', $lunchmin);
            if ($one && $two && $three && $shifthree != '' && $shifthree != ' ') {
                $data = array(
                    'id' => $this->input->post('id'),
                    'shiftfrom' => $shiftone,
                    'shiftto' => $shifttwo,
                    'shiftype' => $shifthree,
                    'remarks' => $remarks,
                    'lunchmin' => $lunchmin,
                );
                $this->db->replace('attendence_shiftdef', $data);
                $json_return = array(
                    'report' => "Updated Successfully",
                    'status' => 0,
                );
                echo json_encode($json_return);
            } else {
                $json_return = array(
                    'report' => "Invalid Input",
                    'status' => 1,
                );
                echo json_encode($json_return);
            }
        } else if ($input['action'] === 'delete') {
            $json_return = array(
                'report' => "Deleted Successfully",
                'status' => 0,
            );
            $id = $this->input->post('id');
            $this->universal_model->deletez('attendence_shiftdef', 'id', $id);
            $this->universal_model->deletez('shiftdefdetails', 'id_attendence_shiftdef', $id);
            echo json_encode($json_return);
        }
        // echo json_encode($input);
    }

    public function addshift()
    {
        $inser = array(
            'shiftfrom' => $this->input->post('time_from'),
            'shiftto' => $this->input->post('time_to'),
            'shiftype' => $this->input->post('nameofshift'),
            'remarks' => $this->input->post('remarks_timeshift'),
            'lunchmin' => $this->input->post('lunch_mins'),
        );
        $this->universal_model->insertz('attendence_shiftdef', $inser);
        $json_return = array(
            'report' => "Added Successfully",
            'status' => 0,
        );
        echo json_encode($json_return);
    }

    public function loadleavedata()
    {
        $dropdownemployeetoinput = $this->input->post('from_employee_leave');
        $employpin = explode('|', $dropdownemployeetoinput)[1];
        $enddate = $this->input->post('enddatex');
        $startdate = $this->input->post('startdatex');
        $leavecode = $this->input->post('leavecode');
        $rageme = $this->universal_model->selectrangedatesperpin($employpin, $startdate, $enddate);
        $leavedaterange = getDatesFromRange($startdate, $enddate);
        foreach ($leavedaterange as $dateleave) {
            //Update Time Trans
            $this->universal_model->updatem('pin', $employpin, 'dateclock', $dateleave, 'trans', array(
                'leavestatus' => $leavecode,
            ));
        }
        // if (!empty($rageme)) {
        //     foreach ($leavedaterange as $dateleave) {
        //         //Update Time Trans
        //         $this->universal_model->updatem('pin', $employpin, 'dateclock', $dateleave, 'trans', array(
        //             'leavestatus' => $leavecode,
        //         ));
        //     }
        // }
        $serial_id = $this->get_branchid($employpin);
        foreach ($leavedaterange as $dateleave) {
            $array_instance_date = array(
                'addedby' => $this->session->userdata('logged_in')['id'],
                'leavecode' => $leavecode,
                'leavedate' => $dateleave,
                'userpin' => $employpin,
            );
            $this->universal_model->updateOnDuplicate('attendence_leaves', $array_instance_date);
            $this->manualload($dateleave, $serial_id, $employpin);
        }
        $useridarray = $this->universal_model->selectz(array('id'), 'users', 'pin', $employpin);
        $user_id = array_shift($useridarray)['id'];
        $array_time = array(
            'comment_subject' => 'LEAVE AWARDED BY ADMIN',
            'to_id' => $user_id,
            'comment_text' => ' from ' . $startdate . ' to ' . $enddate,
            'comment_status' => 1,
        );
        //        $token_extract = $this->universal_model->selectz('*', 'util_tokens', 'user_id', $user_id);
        //        if (!empty($token_extract)) {
        //            $this->sendnotifications(array_shift($token_extract)['token'], 'LEAVE AWARDED BY ADMIN', ' From ' . $startdate . ' to ' . $enddate);
        //        }
        $this->universal_model->updateOnDuplicate('util_comments', $array_time);
        $array_response = array(
            'state' => 0,
            'message' => 'Successfully Added',
        );
        echo json_encode($array_response);
    }

    public function loadmanualentry()
    {
        $branchserialarray = $this->input->post('branch_start_manual');
        $branchserial = explode('$', $branchserialarray)[0];
        $dateformanual = $this->input->post('dateformanual');
        $dropdownemployeetoinputarray = $this->input->post('dropdownemployeetoinput');
        $employeetopin = explode('|', $dropdownemployeetoinputarray)[1];
        $array_selectmanual = array(
            'pin',
            'weekday',
            'normaltime',
            'login',
            'logout',
            'id_shift_def',
        );
        //Tem Change In Manual Update It Can Update Missing Values
        //INSERT INTO `attendencelog` (`serialnumber`, `pin`, `exactdate`, `verified`, `status`, `workcode`, `timeinserts`, `dateinsertserver`) VALUES ('AIOR181260320', '24870964', '2019-06-15 11:47:37', '1', '0', '0', '2019/06/15', '2019-06-15 15:42:23');
        $ragemeleaveopps = $this->universal_model->selectzy($array_selectmanual, 'trans', 'pin', $employeetopin, 'dateclock', $dateformanual);
        if (empty($ragemeleaveopps)) {
            $json_return = array(
                'report' => "These Dates Not Yet Covered By This User",
                'status' => 1,
            );
            echo json_encode($json_return);
            // echo json_encode($_POST);
        } else {
            $this->session->set_userdata('user_pin_manual', $employeetopin);
            $this->session->set_userdata('user_date_manual', $dateformanual);
            foreach ($ragemeleaveopps as $key => $valye) {
                if ($ragemeleaveopps[$key]['login'] == '') {
                    $ragemeleaveopps[$key]['login'] = '00:00';
                }
                if ($ragemeleaveopps[$key]['logout'] == '') {
                    $ragemeleaveopps[$key]['logout'] = '00:00';
                }
            }
            echo json_encode($ragemeleaveopps);
        }
    }

    public function loadleavedataper()
    {
        $action = $this->input->post('action');
        if ($action == 'edit') {
            $json_return = array(
                'report' => "Refreshed",
                'status' => 2,
            );
            echo json_encode($json_return);
        } else {
            $user_id_leave = $this->input->post('id');
            $ragemeleaveopps = $this->universal_model->selectz('*', 'attendence_leaves', 'id', $user_id_leave);
            $pin = $ragemeleaveopps[0]['userpin'];
            $dateclock = $ragemeleaveopps[0]['leavedate'];
            $array_for_trans = array(
                'leavestatus' => 'XXX',
            );
            $this->universal_model->updatem('pin', $pin, 'dateclock', $dateclock, 'trans', $array_for_trans);
            $datete = $this->universal_model->deletez('attendence_leaves', 'id', $user_id_leave);
            $json_return = array(
                'report' => "Leave Revocked Successfully",
                'status' => 2,
            );
            echo json_encode($json_return);
        }
        // if()
        // echo json_encode($_POST);
    }

    public function test()
    {
        //        echo date_format(date_create("2018-11-05 13:58:51"), "Y-m-d");
        $date = date('Y-m-d', time());
        print_array($date);
        // $checkuser_exist = $this->universal_model->selectzypdo('*', 'timeback', 'cardno', '4', 'dateadded', '2018-11-05');
        // print_array($checkuser_exist);
    }

    public function deleteallleaveinhere()
    {
        $employee = $this->input->post('employee');
        $startdate = $this->input->post('startdatex');
        $enddate = $this->input->post('enddatex');
        $leavecode = $this->input->post('leavecode');
        if ($employee == '' || $startdate == '' || $enddate == '' || $leavecode == '') {
            $json_return = array(
                'report' => "Select All Fields Before Removing The Leave",
                'status' => 1,
            );
            echo json_encode($json_return);
        } else {
            $employee_idpin = explode('|', $employee)[1];
            $array_for_trans = array(
                'leavestatus' => 'XXX',
            );
            $serial_id = $this->get_branchid($employee_idpin);
            $leavedaterange = getDatesFromRange($startdate, $enddate);
            foreach ($leavedaterange as $datedeleteupdate) {
                $this->universal_model->deletezm('attendence_leaves', 'userpin', $employee_idpin, 'leavedate', $datedeleteupdate);
                $this->universal_model->updatem('pin', $employee_idpin, 'dateclock', $datedeleteupdate, 'trans', $array_for_trans);
                $this->manualload($datedeleteupdate, $serial_id, $employee_idpin);
            }
            $json_return = array(
                'report' => 'All Leaves Revocked Successfully',
                'status' => 2,
            );
            // $ragemeleaveopps = $this->universal_model->updatemtimeleave($startdate, $enddate, 'timtrans', $array_leave);
            echo json_encode($json_return);
        }
        // echo json_encode($_POST);
    }

    public function loardcarddaily()
    {
        //        $_POST['branch_start_daily'] = "AF4C174960145$11008933 Update Update@11386387 Update Update@13 Update Update@140 Update Update@153 Update Update@154 Update Update@18 Update Update@2 Update Update@21998395 Update Update@22865597 Update Update@24171703 Update Update@24930659 Update Update@25238302 Update Update@26929726 Update Update@2705120 Update Update@30059475 Update Update@32611671 Update Update@35737055 Update Update@37 Update Update@4183636 Update Update@617 Update Update@6969 Update Update@75 Update Update@76 Update Update@810 Update Update@9495347 Update Update@9597347 Update Update@ADMIN Update Update@AGELLINE MUENI NZAMBIA@AKOLO GERALD AKHONYA@ALBERT M. OBERI@ALEXANDER NGOIYO MAINA@ALFRED N. IKUTWA@ALFRED SIKUKU Update@ALICE SILAPEI KAHIU@ALICE SILAPEI Update@AMOS KIPKIRUI BII@ANNE NJERI MUCHERU@ANTONY NJOROGE MACHARIA@ARCHILAUS WAMBANI INDAKW@ARPITA AMIN Update@ARTI KERAI Update@ASHISH VALJI Update@ATIF MAJOTHI KARIM@BEATRICE JUMA Update@BENARD M. IKUTWA@BENSON MUTHINI MUTUKU@BHARAT B. PATEL@BHARATH KUMAR Update@BRAMWEL S. BATON@BRIAN MAHELI AMALEMBA@CHANDRAKANT RAMBHAI PATE@CHARLES KYALO NZUKI@CHARLES OSCAR ODUNDO@CHARLES WAMEYO ALAKA@CHRISTOPHER M. NYAMAI@DAN ONDIASA OLOO@DANIEL E. OKACHA@DANIEL MULI MUTINDA@DANIEL MUTUNGA KIOKO@DANIEL MWANZIA Update@DAVID S. AMUKHOYE@DEEPAK PATEL Update@DENNY KOPIYO OGOGO@DHARMESH RASIKBHAI PATEL@DHRUV SUMANBHAI PATEL@DICKSON KALA MUNGUTI@DUNCAN MOGERE OSORO@EDWARD OMONDI OKEYO@EDWIN LUSENO AMBANI@EDWIN MORIASI ONYANCHA@ENOS V. WANYONYI@ERIC SOO MUSEMBI@ERICA KNOTT Update@ERICK MWATHI NJOROGE@ESTHER MWIKALI MUSYIMI@EVERLYNE AWUOR ORIMBA@EZEKIEL KIBE THUMBI@EZEKIEL KIPRUTO KOSGEI@EZEKIEL MOGOI ONYANCHA@FESTUS O. SHIMECHELO@FRANCIS MAINA MUTHAKA@FRANCIS S. MIDAKI@FRANKS R. WAYUMBU@FREDRICK JUMA ONDETA@FREDRICK MUSINJOLE NDUND@FREDRICK SILA MAKAU@GAUTAM JASHBHAI PATEL@GEORGE KAI GIKERA@GREGORY KIAMNI KALUNDE@GULAMHUSEIN A JIVANJEE@HARRISON MATOLO MUTISYA@HARSHAD KANUBHAI PATEL@HENAL MEHTA Update@HENRY OYARO OTEBO@HILLARY KIPKOECH KIRWA@ISHWAR LALJI HALAI@JACKSON MWANIKI MUSYOKI@JAGDISH HATHIBHAI PATEL@JAGDISHBHAI CHHOTABHAI P@JAIMIN PATEL Update@JAMES MUSAU Update@JANE NJERI CYRUS@JANET AWUOR OTIENO@JAYDIPKUMAR BANSHILAL SU@JOHN KITHEKA SYENGO@JOSEPH A. AMBANI@JOSEPH KAGWI KAMAU@JOSEPH LUBUTSE IMBUGA@JOSEPH MANYINSA ONSONGO@JOSEPH MUSA ESHIKUMO@JOSEPH MWANGI MENYE@JULIA IKHOLI SHIKUNYI@JULIUS MAGARE OMBASA@KANANDU AUGUSTINE MUSYOK@KANTILAL BHAISHANKER BHA@KENNETH JUMA CHIKAMAI@KENNETH KAMAU Update@KENNETH NJOROGE NJERI@KIRITKUMAR R PATEL@KUSH RAVJI VEKARIA@KYALO MALEVE Update@LAXMI CHETAN PANCHANI@LEONARD O. ANDONYA@LISTER MKANYI KARISA@LORNA NUNGARI KITEMA@LUCY NJERI MIRINGU@LUTFIYA ISMAIL MAALIM@LYDON B. WANYAMA@MADONY WICYLIFEE NDOLO@MARIA MATHEKA Update@MARTIN KITHURE KINYAKI@MARTIN MWANZA MUNYOKI@MATHEW GICHOHI WAMBUGU@MAURICE SIMIYU KHAEMBA@MEENA HEMANT PATEL@MEENA HEMANT Update@MEHUL H PATEL@MICHAEL AMUNGA AKUTE@MIZILA SANGALO KETENYI@MOHINI VALJI SIYANI@MOSES WAIGWA WANGOMBE@MUKULA NZANGE MUTIA@MUKUNGI MUSYOKA Update@MULI JORAM KIHARA@MULI MUE Update@MUSA SOITA WAFULA@MUTINDA M. KYALO@MWANTHI JEREMIAH MUMO@MWICHIGI STANLEY GIKUNI@NADHIM S VARVANI@NADHIM VARVANI Update@NARENDRA RABADIA Update@NATHAN NGUGI NJUGUNA@NAYNESHKUMAR JAYANT PATE@NDUNGU JOHN KINUTHIA@NICHOLAS MBULISHE Update@NICHOLAS MUNEENI MUSYOKA@NICOLAS KIRAGU GACHAU@NIMESH SURENDRAKUMAR PAT@NITINKUMAR JADAVJI PINDO@OBERI PATRICK MADAFU@OTHIENO N. CAROLYNE@OTIATO REBECCA O.@PARTH JAGDISH PATEL@PATEL ASHISH VINODBHAI@PATEL SATISH JASHBHAI@PATMAN OWILI OTIENO@PATRICK NGWILI KIVULUSA@PATRICK OMONDI OCHIENG@PAUL KYAMA NGUMBAU@PAUL MORARO OYONGO@PETER JASON OKARI@PETER KIMEU MUUMBI@PETER O. LENDE@PETER OCHIENG LELO@PHILIP MUINDI IVONGO@PHILIP NAMASAKA Update@RAKESH SAGARBHAI PATEL@RAPHAEL KYALO NGUMBI@RAVINDER KAUR CHANAE@RIAH RAMESHCHANDRA PREMJ@RIYA MANISHKUMAR DESAI@ROBERT GATIKI THUITA@RONALD KIPNGENO Update@RONALD N. OMWANGE@SACLIFF A. MWALE@SAMMY KARARU MAINA@SAMUEL M. MUSUNGA@SAMUEL OKWAYO KHAMALAH@SANJAY PRATAPBHAI CHAVDA@SENGERA ACHANG'A LAMECK@SHADRACK A. OKEMBO@SHAILESHBHAI BHOGILAL DE@SHAMJI MANJI PANCHANI@SHEILLAH NAOMI Update@SHEM MAGANA LUGA@SIMON MULEI OKACHA@SIMON NDETI KYENGO@SIMON SIMIYU NYONGESA@STELLA NABONGO Update@STEPHEN SHIZUGANE GUGU@SUSAN WANGECHI MWANGI@THOMAS O. OKONJI@TIMOTHY W. MWANIKI@TITUS MUTINDA MUTUA@TOM ABASI Update@Update Update Update@Update Update Update@Update Update Update@Update Update Update@Update Update Update@Update Update Update@Update Update Update@VEEKESH PREMJI MAVJI@VEEKESK JIVA Update@VINCENT KHAYUMBI IMBAHAL@VINCENT ORINA OBABI@VIRGINIA KILAA Update@WACHIRA ANTHONY KIBE@WAMBUA MARGARET NDUKU@WAMBUA MWILU Update@WARREN SACHAS MWAMJI@WASHINGTON O. IMENDE@WILLIAM M. MUTHENGI@WILLIAM O. HAUNA@WILLISON NDENGU Update@WYCLIFFE OMULAKU NYAWALO@WYCLIFFE ONDIEKI ONTITA$11008933@11386387@13@140@153@154@18@2@21998395@22865597@24171703@24930659@25238302@26929726@2705120@30059475@32611671@35737055@37@4183636@617@6969@75@76@810@9495347@9597347@3000@14522213@20339174@22179052@6140174@25691004@10841878@127@16@30507729@14680678@13703919@30487276@622@741@793@27613541@26626271@23419461@11052044@8932504@158@28963853@25902547@19@14615792@27786583@24773106@12574165@21767904@25610645@27968612@25888114@14616091@27590534@23279312@22429681@0@32741972@12767062@22189103@29037021@27289553@28867999@24930359@30278964@161@23571370@21@27539089@28486650@22915612@7302242@25041540@13394224@25084517@23782563@25570367@27438889@30216979@201654@13411040@28174867@3348509@22040027@30294612@17@22591886@27621468@30766743@28922059@24552229@23743691@688@786@29238406@25963554@854459@9426841@22859297@14566516@6847803@21974339@8740149@11@2081987@30189696@8965668@11591170@800@27919273@21907952@955278@34422100@25358052@27996416@12965791@23946964@24725620@21772935@26183743@24688377@11849073@799@22611210@9@1831507@29129098@32771196@781@132@1874956@64@32096178@13802076@20312972@20029650@8957226@22239252@25817681@20390574@13423729@7249725@13595959@123@656152@24734376@22824978@22319845@22382991@32450752@20699147@26928915@27660227@20305601@20267400@22282740@37367113@20154633@23121368@25181415@5@24@27094606@28423447@3@23951226@27051220@8142460@21752728@9993745@25387856@22101002@22196196@35451352@33115481@22135351@27671250@21517667@25899347@11286387@11850838@20147423@22596503@32566255@14432428@21912166@11590503@22669923@734@22866597@20639497@26561152@8351194@11235356@32410475@21220865@22108555@20073574@10615055@23397706@8536217@20045885@25971158@21671161@31625411@22161533@783@15@30692559@24521227@31437241@10242729@20827564@25015628@28125278@11233611@25019038@11671016@30294611@23653968@20541643";
        //        $_POST['date_mincardx_d'] = "2019-06-04";
        //        $_POST['employeenumbermaxx_d'] = "WYCLIFFE ONDIEKI ONTITA|20541643";
        //        $_POST['employeenumberminx_d'] = "AGELLINE MUENI NZAMBIA|14522213";
        //Start
        $id_payrollcat =  $this->input->post('id_payrollcat');
        $branch_start = $this->input->post('branch_start_daily');
        $date_maxncardx = $this->input->post('date_mincardx_d');
        $date_mincardx = $this->input->post('date_mincardx_d');
        $employeenumberminx = $this->input->post('employeenumberminx_d');
        $employeenumbermaxx = $this->input->post('employeenumbermaxx_d');
        $employeenumberminxarray = explode('|', $employeenumberminx);
        // //Process Two
        $employeenumbermaxxarray = explode('|', $employeenumbermaxx);
        $array_last_name = 0;
        if ($employeenumbermaxxarray[0] != '') {
            $array_last_name = $employeenumbermaxxarray[0][0];
        }
        $branchcode = explode('$', $branch_start);
        //plug start
        $brancharray = $this->universal_model->selectz(array('branchname'), 'util_branch_reader', 'readerserial', $branchcode[0]);
        $branchname = array_shift($brancharray)['branchname'];
        //plug end
        $gettimetrans = $this->universal_model->attendence_cardnewtrans($branchname, $date_mincardx, $date_maxncardx, $employeenumberminxarray[0][0], $array_last_name, $employeenumberminxarray[1], $id_payrollcat);
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
                    $carry[$city]['leavestatus'] .= '~' . $item['leavestatus'];
                    // $carry[$city]['id_shift_def'] .= '~' . $item['id_shift_def'];
                    // CreatedArrays Virtual
                } else {
                    // print_array($item);
                    $carry[$city] = $item;
                    // CreatedArrays Virtual
                }
                return $carry;
            }, array());
            $report_array = array_values($output);
            //            print_array($report_array);
            $json_return = array(
                'report' => "Range " . 'between ' . $date_mincardx . ' to ' . $date_maxncardx . ' loaded',
                'status' => 1,
                'data' => $this->timetest_daily($report_array, $date_mincardx, $date_maxncardx),
            );
            echo json_encode($json_return);
        }
    }

    public function loardcarddaily_en()
    {
        //        $branch_start = "AF4C174960145$11008933 Update Update@11386387 Update Update@13 Update Update@140 Update Update@153 Update Update@154 Update Update@18 Update Update@2 Update Update@21998395 Update Update@22865597 Update Update@24171703 Update Update@24930659 Update Update@25238302 Update Update@26929726 Update Update@2705120 Update Update@30059475 Update Update@32611671 Update Update@35737055 Update Update@37 Update Update@4183636 Update Update@617 Update Update@6969 Update Update@75 Update Update@76 Update Update@810 Update Update@9495347 Update Update@9597347 Update Update@ADMIN Update Update@AGELLINE MUENI NZAMBIA@AKOLO GERALD AKHONYA@ALBERT M. OBERI@ALEXANDER NGOIYO MAINA@ALFRED N. IKUTWA@ALFRED SIKUKU Update@ALICE SILAPEI KAHIU@ALICE SILAPEI Update@AMOS KIPKIRUI BII@ANNE NJERI MUCHERU@ANTONY NJOROGE MACHARIA@ARCHILAUS WAMBANI INDAKW@ARPITA AMIN Update@ARTI KERAI Update@ASHISH VALJI Update@ATIF MAJOTHI KARIM@BEATRICE JUMA Update@BENARD M. IKUTWA@BENSON MUTHINI MUTUKU@BHARAT B. PATEL@BHARATH KUMAR Update@BRAMWEL S. BATON@BRIAN MAHELI AMALEMBA@CHANDRAKANT RAMBHAI PATE@CHARLES KYALO NZUKI@CHARLES OSCAR ODUNDO@CHARLES WAMEYO ALAKA@CHRISTOPHER M. NYAMAI@DAN ONDIASA OLOO@DANIEL E. OKACHA@DANIEL MULI MUTINDA@DANIEL MUTUNGA KIOKO@DANIEL MWANZIA Update@DAVID S. AMUKHOYE@DEEPAK PATEL Update@DENNY KOPIYO OGOGO@DHARMESH RASIKBHAI PATEL@DHRUV SUMANBHAI PATEL@DICKSON KALA MUNGUTI@DUNCAN MOGERE OSORO@EDWARD OMONDI OKEYO@EDWIN LUSENO AMBANI@EDWIN MORIASI ONYANCHA@ENOS V. WANYONYI@ERIC SOO MUSEMBI@ERICA KNOTT Update@ERICK MWATHI NJOROGE@ESTHER MWIKALI MUSYIMI@EVERLYNE AWUOR ORIMBA@EZEKIEL KIBE THUMBI@EZEKIEL KIPRUTO KOSGEI@EZEKIEL MOGOI ONYANCHA@FESTUS O. SHIMECHELO@FRANCIS MAINA MUTHAKA@FRANCIS S. MIDAKI@FRANKS R. WAYUMBU@FREDRICK JUMA ONDETA@FREDRICK MUSINJOLE NDUND@FREDRICK SILA MAKAU@GAUTAM JASHBHAI PATEL@GEORGE KAI GIKERA@GREGORY KIAMNI KALUNDE@GULAMHUSEIN A JIVANJEE@HARRISON MATOLO MUTISYA@HARSHAD KANUBHAI PATEL@HENAL MEHTA Update@HENRY OYARO OTEBO@HILLARY KIPKOECH KIRWA@ISHWAR LALJI HALAI@JACKSON MWANIKI MUSYOKI@JAGDISH HATHIBHAI PATEL@JAGDISHBHAI CHHOTABHAI P@JAIMIN PATEL Update@JAMES MUSAU Update@JANE NJERI CYRUS@JANET AWUOR OTIENO@JAYDIPKUMAR BANSHILAL SU@JOHN KITHEKA SYENGO@JOSEPH A. AMBANI@JOSEPH KAGWI KAMAU@JOSEPH LUBUTSE IMBUGA@JOSEPH MANYINSA ONSONGO@JOSEPH MUSA ESHIKUMO@JOSEPH MWANGI MENYE@JULIA IKHOLI SHIKUNYI@JULIUS MAGARE OMBASA@KANANDU AUGUSTINE MUSYOK@KANTILAL BHAISHANKER BHA@KENNETH JUMA CHIKAMAI@KENNETH KAMAU Update@KENNETH NJOROGE NJERI@KIRITKUMAR R PATEL@KUSH RAVJI VEKARIA@KYALO MALEVE Update@LAXMI CHETAN PANCHANI@LEONARD O. ANDONYA@LISTER MKANYI KARISA@LORNA NUNGARI KITEMA@LUCY NJERI MIRINGU@LUTFIYA ISMAIL MAALIM@LYDON B. WANYAMA@MADONY WICYLIFEE NDOLO@MARIA MATHEKA Update@MARTIN KITHURE KINYAKI@MARTIN MWANZA MUNYOKI@MATHEW GICHOHI WAMBUGU@MAURICE SIMIYU KHAEMBA@MEENA HEMANT PATEL@MEENA HEMANT Update@MEHUL H PATEL@MICHAEL AMUNGA AKUTE@MIZILA SANGALO KETENYI@MOHINI VALJI SIYANI@MOSES WAIGWA WANGOMBE@MUKULA NZANGE MUTIA@MUKUNGI MUSYOKA Update@MULI JORAM KIHARA@MULI MUE Update@MUSA SOITA WAFULA@MUTINDA M. KYALO@MWANTHI JEREMIAH MUMO@MWICHIGI STANLEY GIKUNI@NADHIM S VARVANI@NADHIM VARVANI Update@NARENDRA RABADIA Update@NATHAN NGUGI NJUGUNA@NAYNESHKUMAR JAYANT PATE@NDUNGU JOHN KINUTHIA@NICHOLAS MBULISHE Update@NICHOLAS MUNEENI MUSYOKA@NICOLAS KIRAGU GACHAU@NIMESH SURENDRAKUMAR PAT@NITINKUMAR JADAVJI PINDO@OBERI PATRICK MADAFU@OTHIENO N. CAROLYNE@OTIATO REBECCA O.@PARTH JAGDISH PATEL@PATEL ASHISH VINODBHAI@PATEL SATISH JASHBHAI@PATMAN OWILI OTIENO@PATRICK NGWILI KIVULUSA@PATRICK OMONDI OCHIENG@PAUL KYAMA NGUMBAU@PAUL MORARO OYONGO@PETER JASON OKARI@PETER KIMEU MUUMBI@PETER O. LENDE@PETER OCHIENG LELO@PHILIP MUINDI IVONGO@PHILIP NAMASAKA Update@RAKESH SAGARBHAI PATEL@RAPHAEL KYALO NGUMBI@RAVINDER KAUR CHANAE@RIAH RAMESHCHANDRA PREMJ@RIYA MANISHKUMAR DESAI@ROBERT GATIKI THUITA@RONALD KIPNGENO Update@RONALD N. OMWANGE@SACLIFF A. MWALE@SAMMY KARARU MAINA@SAMUEL M. MUSUNGA@SAMUEL OKWAYO KHAMALAH@SANJAY PRATAPBHAI CHAVDA@SENGERA ACHANG'A LAMECK@SHADRACK A. OKEMBO@SHAILESHBHAI BHOGILAL DE@SHAMJI MANJI PANCHANI@SHEILLAH NAOMI Update@SHEM MAGANA LUGA@SIMON MULEI OKACHA@SIMON NDETI KYENGO@SIMON SIMIYU NYONGESA@STELLA NABONGO Update@STEPHEN SHIZUGANE GUGU@SUSAN WANGECHI MWANGI@THOMAS O. OKONJI@TIMOTHY W. MWANIKI@TITUS MUTINDA MUTUA@TOM ABASI Update@Update Update Update@Update Update Update@Update Update Update@Update Update Update@Update Update Update@Update Update Update@Update Update Update@VEEKESH PREMJI MAVJI@VEEKESK JIVA Update@VINCENT KHAYUMBI IMBAHAL@VINCENT ORINA OBABI@VIRGINIA KILAA Update@WACHIRA ANTHONY KIBE@WAMBUA MARGARET NDUKU@WAMBUA MWILU Update@WARREN SACHAS MWAMJI@WASHINGTON O. IMENDE@WILLIAM M. MUTHENGI@WILLIAM O. HAUNA@WILLISON NDENGU Update@WYCLIFFE OMULAKU NYAWALO@WYCLIFFE ONDIEKI ONTITA$11008933@11386387@13@140@153@154@18@2@21998395@22865597@24171703@24930659@25238302@26929726@2705120@30059475@32611671@35737055@37@4183636@617@6969@75@76@810@9495347@9597347@3000@14522213@20339174@22179052@6140174@25691004@10841878@127@16@30507729@14680678@13703919@30487276@622@741@793@27613541@26626271@23419461@11052044@8932504@158@28963853@25902547@19@14615792@27786583@24773106@12574165@21767904@25610645@27968612@25888114@14616091@27590534@23279312@22429681@0@32741972@12767062@22189103@29037021@27289553@28867999@24930359@30278964@161@23571370@21@27539089@28486650@22915612@7302242@25041540@13394224@25084517@23782563@25570367@27438889@30216979@201654@13411040@28174867@3348509@22040027@30294612@17@22591886@27621468@30766743@28922059@24552229@23743691@688@786@29238406@25963554@854459@9426841@22859297@14566516@6847803@21974339@8740149@11@2081987@30189696@8965668@11591170@800@27919273@21907952@955278@34422100@25358052@27996416@12965791@23946964@24725620@21772935@26183743@24688377@11849073@799@22611210@9@1831507@29129098@32771196@781@132@1874956@64@32096178@13802076@20312972@20029650@8957226@22239252@25817681@20390574@13423729@7249725@13595959@123@656152@24734376@22824978@22319845@22382991@32450752@20699147@26928915@27660227@20305601@20267400@22282740@37367113@20154633@23121368@25181415@5@24@27094606@28423447@3@23951226@27051220@8142460@21752728@9993745@25387856@22101002@22196196@35451352@33115481@22135351@27671250@21517667@25899347@11286387@11850838@20147423@22596503@32566255@14432428@21912166@11590503@22669923@734@22866597@20639497@26561152@8351194@11235356@32410475@21220865@22108555@20073574@10615055@8536217@31625411@20045885@23397706@25971158@21671161@22161533@783@15@30692559@24521227@31437241@10242729@20827564@25015628@28125278@11233611@25019038@11671016@30294611@23653968@20541643";
        //        $date_maxncardx = "2019-07-03";
        //        $date_mincardx = "2019-07-03";
        //        $employeenumbermaxx = "11386387 Update Update|11386387";
        //        $employeenumberminx = "11008933 Update Update|11008933";
        //Process Two
        $branch_start = $this->input->post('branch_start_daily');
        $date_maxncardx = $this->input->post('date_mincardx_d');
        $date_mincardx = $this->input->post('date_mincardx_d');
        $employeenumberminx = $this->input->post('employeenumberminx_d');
        $employeenumbermaxx = $this->input->post('employeenumbermaxx_d');
        //
        $employeenumberminxarray = explode('|', $employeenumberminx);
        // //Process Two
        $employeenumbermaxxarray = explode('|', $employeenumbermaxx);
        $array_last_name = 0;
        if ($employeenumbermaxxarray[0] != '') {
            $array_last_name = $employeenumbermaxxarray[0][0];
        }
        // //Codes
        $branchcode = explode('$', $branch_start);
        $gettimetrans = $this->universal_model->attendence_cardnewtrans($branchcode[0], $date_mincardx, $date_maxncardx, $employeenumberminxarray[0][0], $array_last_name, $employeenumberminxarray[1]);
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
                    $carry[$city]['leavestatus'] .= '~' . $item['leavestatus'];
                    // $carry[$city]['id_shift_def'] .= '~' . $item['id_shift_def'];
                    // CreatedArrays Virtual
                } else {
                    // print_array($item);
                    $carry[$city] = $item;
                    // CreatedArrays Virtual
                }
                return $carry;
            }, array());
            $report_array = array_values($output);
            //            print_array($report_array);
            $json_return = array(
                'report' => "Range " . 'between ' . $date_mincardx . ' to ' . $date_maxncardx . ' loaded',
                'status' => 1,
                'data' => $this->timetest_daily($report_array, $date_mincardx, $date_maxncardx),
            );
            echo json_encode($json_return);
        }
    }

    public function loardcarddata()
    {
        //        $_POST['branch_start'] = "AIOR181860073$ ABDUL KARIM SADIK KASSIM@AGELLINE MUENI NZAMBIA@AKOLO GERALD AKHONYA@ALBERT M. OBERI@ALEXANDER NGOIYO MAINA@ALFRED N. IKUTWA@ALFRED SIKUKU @AMOS KIPKIRUI BII@ANN JUDY WANGARI MACHARIA@ANNE NJERI MUCHERU@ANTONY NJOROGE MACHARIA@ARCHILAUS WAMBANI INDAKWA@BEATRICE JUMA @BENARD M. IKUTWA@BENSON MUTHINI MUTUKU@BHARAT B. PATEL@BHARATH KUMAR PALANIVELU@BHARATH KUMAR Update@BRAMWEL S. BATON@BRIAN MAHELI AMALEMBA@CALEB MALAKI ONGAI CALEB@CHANDRESH KUMAR A PATEL@CHARLES KYALO NZUKI@CHARLES OSCAR ODUNDO@CHARLES WAMEYO ALAKA@CHRISTOPHER M. NYAMAI@DAN ONDIASA OLOO@DANIEL E. OKACHA@DANIEL MULI MUTINDA@DANIEL MUTUNGA KIOKO@DANIEL MWANZIA @DANSON WESONGA ACHINGA ACHINGA@DAVID S. AMUKHOYE@DENNY KOPIYO OGOGO@DHARMESH RASIKBHAI PATEL@DHRUV SUMANBHAI PATEL@DICKSON KALA MUNGUTI@DUNCAN MOGERE OSORO@EDWARD OMONDI OKEYO@EDWIN LUSENO AMBANI@EDWIN MORIASI ONYANCHA@ELIZABETH WANGUI Update@ENOS V. WANYONYI@ERIC SOO MUSEMBI@ERICK MWATHI NJOROGE@EVERLYNE AWUOR ORIMBA@EZEKIEL KIBE THUMBI@EZEKIEL KIPRUTO KOSGEI@EZEKIEL MOGOI ONYANCHA@FESTUS O. SHIMECHELO@FRANCIS MAINA MUTHAKA@FRANCIS S. MIDAKI@FRANKS R. WAYUMBU@FREDRICK JUMA ONDETA@FREDRICK MUSINJOLE NDUNDE@FREDRICK SILA MAKAU@GAUTAM JASHBHAI PATEL@GREGORY KIAMNI KALUNDE@HARRISON MATOLO MUTISYA@HARSHAD KANUBHAI PATEL@HENRY OYARO OTEBO@HILLARY KIPKOECH KIRWA@JACKSON MWANIKI MUSYOKI@JAGDISH HATHIBHAI PATEL@JAMES MUSAU Update@JAMES MUSAU Update@JANE MUTHONI NDIRANGU@JANE NJERI CYRUS@JANET AWUOR OTIENO@JASUBEN HARISH KESRA JINA@JIVANJEE GULAMHUSEIN A@JOHN KITHEKA SYENGO@JOSEPH A. AMBANI@JOSEPH LUBUTSE IMBUGA@JOSEPH MANYINSA ONSONGO@JOSEPH MUSA ESHIKUMO@JOSEPH MWANGI MENYE@JULIA IKHOLI SHIKUNYI@JULIUS MAGARE OMBASA@KANANDU AUGUSTINE MUSYOKA@KELVIN LUGONZO @KENNETH KAMAU @KENNETH NJOROGE NJERI@KUSH RAVJI VEKARIA@KYALO MALEVE @LAXMI CHETAN PANCHANI@LEONARD O. ANDONYA@LILLIAN NDUKU KISILU@LISTER MKANYI KARISA@LORNA NUNGARI KITEMA@LUCY KANAA MUTINDA@LUCY NJERI MIRINGU@LYDON B. WANYAMA@MADONY WICYLIFEE NDOLO@MARTIN KITHURE KINYAKI@MATHEW GICHOHI WAMBUGU@MAURICE SIMIYU KHAEMBA@MEENA HEMANT PATEL@MOHINI VALJI SIYANI@MOSES WAIGWA WANGOMBE@MUKUNGI MUSYOKA @MULI JORAM KIHARA@MULI MUE @MUSA SOITA WAFULA@MUTINDA M. KYALO@MWANTHI JEREMIAH MUMO@MWICHIGI STANLEY GIKUNI@NARENDRA RABADIA @NATHAN NGUGI NJUGUNA@NDUNGU JOHN KINUTHIA@NICHOLAS MBULISHE @NICHOLAS MUNEENI MUSYOKA@NICOLAS KIRAGU GACHAU@NIKUNJ ASHOK VORA@OBERI PATRICK MADAFU@OLUOCH ANTONY ODHIAMBO@OTIATO REBECCA O.@PARIKH RONAK RAJENDRABHAI@PATEL ASHISH VINODBHAI@PATEL SATISH JASHBHAI@PATMAN OWILI OTIENO@PATRICK OMONDI OCHIENG@PAUL KYAMA NGUMBAU@PAUL MORARO OYONGO@PETER JASON OKARI@PETER KIMEU MUUMBI@PETER NJENGA MBATIA@PETER O. LENDE@PETER OCHIENG LELO@PHILIP MUINDI IVONGO@PHILIP NAMASAKA @PUNITKUMAR RAMESH PATEL@RAKESH SAGARBHAI PATEL@RAPHAEL KYALO NGUMBI@RAVINDER KAUR CHANAE@RIYA MANISHKUMAR DESAI@ROBERT GATIKI THUITA@RONALD KIPNGENO @RONALD N. OMWANGE@SACLIFF A. MWALE@SAMMY KARARU MAINA@SAMUEL M. MUSUNGA@SAMUEL OKWAYO KHAMALAH@SANJAY PRATAPBHAI CHAVDA@SATISHKUMAR MAGANBHAI PATEL@SENGERA ACHANG'A LAMECK@SHADRACK A. OKEMBO@SHAILESHBHAI BHOGILAL DESAI@SHAMJI MANJI PANCHANI@SHEILLAH NAOMI @SIMON MULEI OKACHA@SIMON NDETI KYENGO@SIMON SIMIYU NYONGESA@STELLA NABONGO @SUSAN WANGECHI MWANGI@TERESA KARUE @THOMAS O. OKONJI@TIMOTHY W. MWANIKI@TITUS MUTINDA MUTUA@TOM ABASI @VINCENT KHAYUMBI IMBAHALE@VINCENT ORINA OBABI@VIRGINIA KILAA @WACHIRA ANTHONY KIBE@WAMBUA MARGARET NDUKU@WAMBUA MWILU @WARREN SACHAS MWAMJI@WASHINGTON O. IMENDE@WILLIAM M. MUTHENGI@WILLIAM O. HAUNA@WILLISON NDENGU @WYCLIFFE OMULAKU NYAWALO@WYCLIFFE ONDIEKI ONTITA$25971158@14522213@20339174@22179052@6140174@25691004@10841878@30507729@22912021@14680678@13703919@30487276@26626271@23419461@11052044@8932504@521923@158@28963853@25902547@21671161@22161533@14615792@27786583@24773106@12574165@21767904@25610645@27968612@25888114@14616091@31625411@27590534@22429681@A1145913@32741972@12767062@22189103@29037021@27289553@28867999@not in payroll@24930359@30278964@23571370@27539089@28486650@22915612@7302242@25041540@13394224@25084517@23782563@25570367@27438889@30216979@201654@28174867@22040027@30294612@22591886@27621468@28922059@24552229@786@NOT IN@32611671@29238406@25963554@20045885@3348509@9426841@22859297@6847803@21974339@8740149@11008933@2081987@30189696@8965668@31190398@27919273@21907952@34422100@25358052@27996416@12965791@22459057@23946964@24725620@35737055@21772935@24688377@11849073@22611210@1831507@29129098@32771196@32096178@13802076@20029650@8957226@22239252@25817681@20390574@13423729@7249725@656152@24734376@22319845@22382991@32450752@20699147@34181108@20305601@21601673@22282740@A8510132@20154633@23121368@25181415@24171703@27094606@28423447@30059475@23951226@24617422@27051220@8142460@21752728@9993745@23565036@25387856@22101002@22196196@33115481@22135351@27671250@21517667@25899347@11286387@11850838@20147423@22596503@A916349@32566255@14432428@21912166@11590503@22669923@22866597@20639497@26561152@8351194@32410475@22186876@21220865@22108555@20073574@10615055@30692559@24521227@31437241@10242729@20827564@25015628@28125278@11233611@25019038@11671016@30294611@23653968@20541643";
        //        $_POST['date_maxncardx'] = "2019-09-15";
        //        $_POST['date_mincardx'] = "2019-09-01";
        //        $_POST['employeenumbermaxx'] = "WYCLIFFE ONDIEKI ONTITA|20541643";
        //        $_POST['employeenumberminx'] = "AGELLINE MUENI NZAMBIA|14522213";
        //Process Two
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
            //            print_array($report_array);
            $json_return = array(
                'report' => "Range " . 'between ' . $date_mincardx . ' to ' . $date_maxncardx . ' loaded',
                'status' => 1,
                'data' => $this->timetest($report_array, $date_mincardx, $date_maxncardx, $summery_id),
            );
            echo json_encode($json_return);
        }
    }

    // Helper Functions For Array
    public function getusernamesby_id($id)
    {
        $usernames = $this->universal_model->selectz('firstname,lastname', 'users', 'id', $id)[0];
        return $usernames['firstname'] . ' ' . $usernames['lastname'];
    }

    public function getleavestate($codeleave)
    {
        //        leaveconfig
        $leave = $this->universal_model->selectz('leavetype as shortdesc', 'leaveconfig', 'id', $codeleave)[0]['shortdesc'];
        //        $leave = $this->universal_model->selectz('shortdesc', 'att_timeatttimeoffs', 'type', $codeleave)[0]['shortdesc'];
        return $leave;
    }

    public function timeexpectedhrs($timeincrementaaray, $standardtime)
    {
        // public function timeexpectedhrs()
        $hours = convertfromdectime($standardtime);
        list($h, $m) = explode(':', $hours); // Split up string into hours/minutes
        $decimal = $m / 60; // get minutes as decimal
        $hoursAsDecimal = $h + $decimal;
        $countabledays = count($timeincrementaaray);
        $result = $hoursAsDecimal * $countabledays;
        // $numbertimes = 22;
        // $multiply = $time * $numbertimes;
        return $result;
    }

    public function trimmytime($timetotrime)
    {
        // $timetotrime = '10:9:40';
        $arraytime = explode(':', $timetotrime);
        if (count($arraytime) == 0) {
            return '';
        } elseif (count($arraytime) == 3) {
            return $arraytime[0] . ':' . $arraytime[1];
        } else {
            return $timetotrime;
        }
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

    public function getbranchnamebyserial($serialnumer)
    {
        // selectz($array_table_n, $table_n, $variable_1, $value_1)
        $whattoget = array(
            'branchname',
        );
        $branchnames = $this->universal_model->selectz($whattoget, 'util_branch_reader', 'readerserial', $serialnumer);
        return $branchnames[0];
    }

    public function celltotalworked($timeincrementaaray)
    {
        $timefinal = '00:00:00';
        foreach ($timeincrementaaray as $value) {
            //            print_array($value);
            $timefinal = sum_the_time($timefinal, convertfromdectime((float) $value));
        }
        return sum_the_time($timefinal, '00:00:00', 1);
        // $timefinal;
    }

    public function timetest_daily($test_datacard, $from, $to)
    {
        //        print_array($test_datacard);
        $template = array(
            'table_open' => '<table class="table table-striped table-hover" id="employee_attendence_cardtest_d">',
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
            'table_close' => '</table>',
        );
        $this->table->set_template($template);
        // Main Colums
        $cell = array(
            'data' => '<b>Total Offs</b>',
            'class' => ' info',
            // 'colspan' => '100%'
        );
        // Main Colums End
        $printernames = $this->universal_model->selectz(array('firstname', 'lastname'), 'users', 'user_id', $this->session->userdata('logged_in')['user_id'])[0];
        $theoneheader = '<THEAD>
    <TR>
      <TH SCOPE=colgroup COLSPAN="100%"><font size="4">ASL TRADING ' . 'DAILY REPORT  FOR ' . converttodate($from, 'F jS, Y') . '</font></TH>
    </TR>
    <TR>
      <TH SCOPE=colgroup COLSPAN="5%">Printed On: <b>' . date("d/m/Y") . '</b></TH>
      <TH SCOPE=colgroup COLSPAN="15%" style="text-align:right;">SHIFT DEF:<b>' . $test_datacard[0]['id_shift_def'] . ' ' . $this->getshiftdetails($test_datacard[0]['id_shift_def'])['shiftfrom'] . ' - ' . $this->getshiftdetails($test_datacard[0]['id_shift_def'])['shiftto'] . '</b></TH>
    </TR>
    <TR>
      <TH SCOPE=colgroup COLSPAN="2%">Printed Time: <b>' . date("h:i:s") . '</b></TH>
      <TH SCOPE=colgroup COLSPAN="4%">' . 'BRANCH ' . $this->getbranchnamebyserial($test_datacard[0]['serialnumber'])['branchname'] . '</TH>
      <TH SCOPE=colgroup COLSPAN="15%" style="text-align:right;">Printed By: <b>' . $printernames['firstname'] . ' ' . $printernames['lastname'] . '</b></TH>
    </TR>
    <TR>
      <TH SCOPE=col COLSPAN=1>Day</TH>
      <TH SCOPE=col COLSPAN=1>Date</TH>
      <TH SCOPE=col COLSPAN=1>Emp No</TH>
      <TH SCOPE=col COLSPAN=1>Names</TH>
      <TH SCOPE=col COLSPAN=1>Off</TH>
      <TH SCOPE=col COLSPAN=1>Shift</TH>
      <TH SCOPE=col COLSPAN=1>Login</TH>
      <TH SCOPE=col COLSPAN=1>Logout</TH>
      <TH SCOPE=col COLSPAN=1>Normal T</TH>
      <TH SCOPE=col COLSPAN=1>Tot Hrs</TH>
      <TH SCOPE=col COLSPAN=1>Lost T</TH>
      <TH SCOPE=col COLSPAN=1>Mode</TH>
    </TR>
  </THEAD>';
        $this->table->add_row($theoneheader);
        // Sift Is Attached To Department Later Ref
        // $this->table->add_row('Shifts Definitions : ', $test_datacard[0]['id_shift_def']);
        foreach ($test_datacard as $_cardtestgrandour) {
            $cell = array(
                'data' => '',
                'class' => 'highlight success',
                'colspan' => '100%',
            );
            $names = $this->getemployeename($_cardtestgrandour['pin'])['firstname'] . ' ' . $this->getemployeename($_cardtestgrandour['pin'])['lastname'];

            //            $this->table->add_row($cell);
            //            $this->table->add_row($cellempcodenuber, $cellempcode, $cellempnames);
            //            $this->table->add_row('<b>Day</b>', '<b>Date</b>', '<b>Week</b>', '<b>Off</b>', '<b>Shift</b>', '<b>Login</b>', '<b>Logout</b>', '<b>Normal T</b>', '<b>Tot Hrs</b>', '<b>mot15</b>', '<b>OT 1.5</b>', '<b>OT 2.0</b>', '<b>Lost T</b>', '<b>Mode</b>');
            $weekday = explode('~', $_cardtestgrandour['weekday']);
            $dateclock = explode('~', $_cardtestgrandour['dateclock']);
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
            $normaltime = $_cardtestgrandour['normaltime'];
            $id_shift_def = $_cardtestgrandour['id_shift_def'];
            //            print_array($login);
            foreach ($weekday as $key => $weekday_o) {
                // echo $manual[$key].'<br>';
                // Some Arithemetic
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
                    $normaltime = $_cardtestgrandour['normaltime'];
                    $id_shift_def = $_cardtestgrandour['id_shift_def'];
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
                $this->table->add_row($weekday_o, $dateclock[$key], $this->getemployeename($_cardtestgrandour['pin'])['employee_code'], $names, $off[$key], $id_shift_def, $absent_state, $logout[$key], $normaltime, $timeformat, $lostt[$key], $manual[$key]);
            }
        }
        return $this->table->generate();
    }

    public function timetest($test_datacard, $from, $to, $summery = 1)
    {
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
            'table_close' => '</table>',
        );
        $this->table->set_template($template);
        // Main Colums
        $cellspacecellspan = array(
            'data' => '',
            // 'class' => 'info'
            // 'style' => "font-size: 15px; color: black; background-color: burlywood;"
            'colspan' => 2,
        );

        $cellspacecell = array(
            'data' => '',
            'class' => 'info',
            // 'style' => "font-size: 15px; color: black; background-color: burlywood;"
            // 'colspan' => '100%'
        );
        $celloff = array(
            'data' => '<b>Total Offs</b>',
            'class' => ' info',
            // 'colspan' => '100%'
        );
        $cellsdaysworked = array(
            'data' => '<b>Days Worked</b>',
            'class' => ' info',
            // 'colspan' => '100%'
        );
        $celltotalhours = array(
            'data' => '<b>Total</b>',
            'class' => ' info',
            // 'colspan' => '100%'
        );
        $cellabsent = array(
            'data' => '<b>Days Absent</b>',
            'class' => ' info',
            // 'colspan' => '100%'
        );
        $celltotalworked = array(
            'data' => '<b>Tot Hrs</b>',
            'class' => ' info',
            // 'colspan' => '100%'
        );
        $cellmorningot = array(
            'data' => '<b>M 1.5</b>',
            'class' => ' info',
            // 'colspan' => '100%'
        );
        $cellot15 = array(
            'data' => '<b>OT 1.5</b>',
            'class' => ' info',
            // 'colspan' => '100%'
        );
        $cellot2o = array(
            'data' => '<b>OT 2.0</b>',
            'class' => ' info',
            // 'colspan' => '100%'
        );
        $cellshort = array(
            'data' => '<b>Lost T</b>',
            'class' => ' info',
            // 'colspan' => '100%'
        );
        $cell = array(
            'data' => '<b>Total Offs</b>',
            'class' => ' info',
            // 'colspan' => '100%'
        );
        // Main Colums End
        $celln = array(
            'data' => '<strong>Working. Dept: <strong>',
            'colspan' => 2,
        );
        $celln1 = array(
            'data' => '<strong>Branch Name:<strong>',
            'colspan' => 2,
        );
        $cellshiftdef1 = array(
            'data' => '<b>Shifts Def</b>',
            'class' => 'highlight',
            'colspan' => 1,
        );
        $cellshiftdef2 = array(
            'data' => '<b>' . $test_datacard[0]['id_shift_def'] . '</b>',
            'class' => 'highlight',
            'colspan' => 2,
        );
        $cellshiftdef3 = array(
            'data' => $this->getshiftdetails($test_datacard[0]['id_shift_def'])['shiftype'],
            'class' => 'highlight',
            'colspan' => 1,
        );
        $cellshiftdef4 = array(
            'data' => $this->getshiftdetails($test_datacard[0]['id_shift_def'])['shiftfrom'] . ' - ' . $this->getshiftdetails($test_datacard[0]['id_shift_def'])['shiftto'],
            'class' => 'highlight',
            'colspan' => 3,
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
                'colspan' => '100%',
            );
            // $cellemp = array(
            // 'data' => '<font size="3" color="red">Employee</font>',
            // // 'class' => 'highlight success',
            // 'colspan' => 2
            // );
            $cellempcode = array(
                'data' => 'PIN : ' . '<font size="3">' . $_cardtestgrandour['pin'] . '</font>',
                // 'class' => 'highlight success',
                'colspan' => 2,
            );

            $cellempcodenuber = array(
                'data' => 'EMPCODE : ' . '<font size="3">' . $this->getemployeename($_cardtestgrandour['pin'])['employee_code'] . '</font>',
                // 'class' => 'highlight success',
                'colspan' => 3,
            );
            $names = $this->getemployeename($_cardtestgrandour['pin'])['firstname'] . ' ' . $this->getemployeename($_cardtestgrandour['pin'])['lastname'];
            $cellempnames = array(
                'data' => '<font size="3">' . $names . '</font>',
                // 'class' => 'highlight success',
                'colspan' => 3,
            );
            $this->table->add_row($cell);
            $this->table->add_row($cellempcodenuber, $cellempcode, $cellempnames);
            $this->table->add_row('<b>Day</b>', '<b>Date</b>', '<b>Week</b>', '<b>Off</b>', '<b>Shift</b>', '<b>Login</b>', '<b>Logout</b>', '<b>Normal T</b>', '<b>Tot Hrs</b>', '<b>Lost T</b>', '<b>Mode</b>');
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
            $array_totalstandhrs = array();
            $array_totmorninot = array();
            $array_tot20 = array();
            $arrayot15 = array();
            $arraylost = array();
            $normaltime = explode('~', $_cardtestgrandour['normaltime']);
            $id_shift_def = $_cardtestgrandour['id_shift_def'];
            //            print_array($normaltime);
            foreach ($weekday as $key => $weekday_o) {
                $holidaycheck = converttodate($dateclock[$key], 'd-m');
                $holidaystake = $this->universal_model->selectall_var('*', 'holidayconfig', 'date like "%' . $holidaycheck . '%"');
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

                if ($off[$key] != 'worked off' && $off[$key] != 1 && decimalHours($login[$key]) == '0.00' && $leave[$key] == 'XXX') {
                    array_push($array_totaldaysabsent, 1);
                    $absent_state = 'ABSENT';
                }
                //Repition
                //                if ($off[$key] != 1 && decimalHours($login[$key]) != '0.00' && $leave[$key] == 'XXX') {
                //                    array_push($array_totalhrs, $tothrs[$key]);
                //                }
                if ($off[$key] != 1 && $leave[$key] == 'XXX') {
                    array_push($array_totalhrs, $tothrs[$key]);
                    array_push($array_totalstandhrs, $normaltime[$key]);
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
                    //                    $normaltime[$key] = '';
                    $id_shift_def = $_cardtestgrandour['id_shift_def'];
                }
                if ($lostt[$key] != '' && $lostt[$key] != null && $leave[$key] == 'XXX' && empty($holidaystake)) {
                    array_push($arraylost, $lostt[$key]);
                }
                //                $this->timeexpectedhrs($array_totalhrs, $_cardtestgrandour['normaltime'])
                $totalconvert = convertfromdectime($tothrs[$key], 2);
                //The Devil No Lost Hours On Holiday
                if ($totalconvert == "00:00" && $off[$key] != 1 && $leave[$key] == 'XXX') {
                    $lostt[$key] = '08:00';
                }
                if (!empty($holidaystake)) {
                    $absent_state = limit_words($holidaystake[0]['holidayname'], 35);
                    $lostt[$key] = '';
                }
                $totalnormaltime = convertfromdectime($normaltime[$key], 2);
                if ($summery == 0) {
                    $this->table->add_row($weekday_o, $dateclock[$key], $weekyear[$key], $off[$key], $id_shift_def, $absent_state, $logout[$key], $totalnormaltime, $totalconvert, $lostt[$key], $manual[$key]);
                }
            }
            $this->table->add_row($cellspacecell, $cellspacecell, $cellspacecell, $celloff, $cellspacecell, $cellsdaysworked, $cellabsent, $celltotalhours, $celltotalworked, $cellshort, $cellspacecell);
            $this->table->add_row('', '', '', count($array_totaloffs), '', count($array_totaldaysworked), count($array_totaldaysabsent), $this->celltotalworked($array_totalstandhrs), $this->celltotalworked($array_totalhrs), $this->celltotalworked($arraylost));
        }
        return $this->table->generate();
    }

    public function hours_tomins($timetoo, $timefrom)
    {
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

    public function addalloance()
    {
        $tablename = $this->input->post('tablename');
        switch ($tablename) {
            case 'advanceddeduction':
                $branch_start_manualallow = $this->input->post('branch_start_advanceadd');
                $dropdownemployeetoinputallow = $this->input->post('dropdownemployeetoadvandec');
                $dateformanualallow = $this->input->post('dateformanualaddadvanceallow');
                $amount = $this->input->post('amount');
                //        PROCESS
                $branch = explode('$', $branch_start_manualallow)[0];
                $userpin = explode('|', $dropdownemployeetoinputallow)[1];
                $checkers = $this->universal_model->selectzy('*', 'trans', 'pin', $userpin, 'dateclock', $dateformanualallow);
                if (empty($checkers)) {
                    $json_return = array(
                        'report' => 'Did Not Work On This Day',
                        'status' => 1,
                    );
                    echo json_encode($json_return);
                } else {
                    $dataforinsert = array(
                        'branch' => $branch,
                        'userpin' => $userpin,
                        'date' => $dateformanualallow,
                        'amount' => $amount,
                        'addedby' => $this->session->userdata('logged_in')['id'],
                    );
                    $inserted = $this->universal_model->updateOnDuplicate('advanceddeduction', $dataforinsert);
                    $json_return = array(
                        'report' => 'Successfully Added',
                        'status' => 0,
                    );
                    echo json_encode($json_return);
                }
                break;
            case 'allowances':
                $branch_start_manualallow = $this->input->post('branch_start_manualallow');
                $dropdownemployeetoinputallow = $this->input->post('dropdownemployeetoinputallow');
                $dateformanualallow = $this->input->post('dateformanualallow');
                $dropdownallowance = $this->input->post('dropdownallowance');
                $amount = $this->input->post('amount');
                //        PROCESS
                $branch = explode('$', $branch_start_manualallow)[0];
                $userpin = explode('|', $dropdownemployeetoinputallow)[1];
                $checkers = $this->universal_model->selectzy('*', 'trans', 'pin', $userpin, 'dateclock', $dateformanualallow);
                if (empty($checkers)) {
                    //Hard Coded
                    $json_return = array(
                        'report' => 'Did Not Work On This Day No Other Allowance',
                        'status' => 1,
                    );
                    echo json_encode($json_return);
                } else {
                    $dataforinsert = array(
                        'branch' => $branch,
                        'userpin' => $userpin,
                        'allowances_id' => $dropdownallowance,
                        'date' => $dateformanualallow,
                        'amount' => $amount,
                        'addedby' => $this->session->userdata('logged_in')['id'],
                    );
                    $inserted = $this->universal_model->updateOnDuplicate('manualallowences', $dataforinsert);
                    $json_return = array(
                        'report' => 'Successfully Added',
                        'status' => 0,
                    );
                    echo json_encode($json_return);
                }
                break;
            case 'appliedloans':
                $branch_start_manualallow = $this->input->post('branch_start_applyloan');
                $dropdownemployeetoinputallow = $this->input->post('dropdownemployeeapplyloan');
                $amount = $this->input->post('amount');
                $description = $this->input->post('description');
                $loantype = $this->input->post('dropdownloantype');
                $loanstate = $this->input->post('multifeatured_module')['module_id']['status'];
                $branch = explode('$', $branch_start_manualallow)[0];
                $userpin = explode('|', $dropdownemployeetoinputallow)[1];

                $dataarray = array(
                    'branch_id' => $branch,
                    'amount' => $amount,
                    'description' => $description,
                    'userpin' => $userpin,
                    'loanstate' => $loanstate,
                    'loantypes_id' => $loantype,
                    'currnetbalance' => $amount,
                    'addedby' => $this->session->userdata('logged_in')['id'],
                );
                $inserted = $this->universal_model->updateOnDuplicate('appliedloans', $dataarray);
                $json_return = array(
                    'report' => 'Successfully Added',
                    'status' => 0,
                );
                echo json_encode($json_return);
                break;
            default:
                break;
        }
    }

    public function loadallowances($tablenme)
    {
        switch ($tablenme) {
            case 'manualallowences':
                $whatineed = array(
                    'm.id',
                    'amount',
                    'userpin',
                    'firstname',
                    'lastname',
                    'allowance',
                    'date',
                );
                $loadregion = $this->universal_model->join_manualallowances($whatineed);
                $grid = new EditableGrid();
                $grid->addColumn('id', 'ID', 'string', null, false, null);
                $grid->addColumn('amount', 'ALLOWANCE AMOUNT', 'string', null, false);
                $grid->addColumn('userpin', 'USER PIN', 'string', null, false);
                $grid->addColumn('firstname', 'FIRST NAME', 'string', null, false);
                $grid->addColumn('lastname', 'LAST NAME', 'string', null, false);
                $grid->addColumn('allowance', 'ALLOWANCE TYPE', 'string', null, false);
                $grid->addColumn('date', 'DATE ', 'string', null, false);
                $grid->addColumn('action', 'DELETE', 'html', null, false, 'id');
                $grid->renderJSON($loadregion, false, false, !isset($_GET['data_only']));
                break;
            case 'advanceddeduction':
                $whatineed = array(
                    'm.id',
                    'amount',
                    'userpin',
                    'firstname',
                    'lastname',
                    'date',
                );
                $loadregion = $this->universal_model->join_advancededuc($whatineed);
                $grid = new EditableGrid();
                $grid->addColumn('id', 'ID', 'string', null, false, null);
                $grid->addColumn('amount', 'ADVANCE DEDUCTION', 'string', null, false);
                $grid->addColumn('userpin', 'USER PIN', 'string', null, false);
                $grid->addColumn('firstname', 'FIRST NAME', 'string', null, false);
                $grid->addColumn('lastname', 'LAST NAME', 'string', null, false);
                $grid->addColumn('date', 'DATE ', 'string', null, false);
                $grid->addColumn('action', 'DELETE', 'html', null, false, 'id');
                $grid->renderJSON($loadregion, false, false, !isset($_GET['data_only']));
                break;
            case 'appliedloans':
                $loadregion = $this->universal_model->selectall('*', 'appliedloans');
                $grid = new EditableGrid();
                $grid->addColumn('id', 'ID', 'string', null, false, null);
                $grid->addColumn('amount', 'AMOUNT', 'string', null, false, null);
                $grid->addColumn('currnetbalance', 'BALANCE', 'string', null, false, null);
                $grid->addColumn('loanstate', 'LOAN ACTIVE', 'boolean', null, false, null);
                $grid->addColumn('userpin', 'USER ID', 'string', null, false, null);
                $grid->addColumn('action', 'DELETE', 'html', null, false, 'id');
                $grid->renderJSON($loadregion, false, false, !isset($_GET['data_only']));
                break;
            case 'trans':
                $loadregion = $this->universal_model->selectzy('*', 'trans', 'pin', $this->session->user_pin_manual, 'dateclock', $this->session->user_date_manual);
                $grid = new EditableGrid();
                $grid->addColumn('id_shift_def', 'SHIFT ID', 'string', $this->fetch_pairs('attendence_shiftdef'), false);
                $grid->addColumn('weekday', 'weekday', 'WEEK DAY', null, false, null);
                $grid->addColumn('login', 'login', 'LOGIN', null, true, null);
                $grid->addColumn('logout', 'logout', 'LOGOUT', null, true, null);
                $grid->addColumn('action', 'DELETE', 'html', null, false, 'id');
                $grid->renderJSON($loadregion, false, false, !isset($_GET['data_only']));
                break;
        }
    }

    public function fetch_pairs($table_name)
    {
        // $table_name = 'continent';
        $allclients = $this->universal_model->selectall('*', $table_name);
        $finalarray = array();
        foreach ($allclients as $value) {
            $finalarray[$value['id']] = $value['shiftype'];
        }
        return $finalarray;
    }
    //Only With In Function
    public function get_branchid($user_id)
    {
        $allclients = $this->universal_model->selectz('*', 'users', 'pin', $user_id);
        $branch_id = array_shift($allclients)['branch_id'];
        $util_branch_reader = $this->universal_model->selectz('*', 'util_branch_reader', 'id', $branch_id);
        $serialreader = array_shift($util_branch_reader)['readerserial'];
        return $serialreader;
    }
}
