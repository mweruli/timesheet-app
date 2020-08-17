<?php

require 'vendor/autoload.php';
require_once(APPPATH . 'libraries/EditableGrid.php');

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Firebase\Messaging\CloudMessage;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Leave extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('universal_model');
        $cat = $this->session->userdata('logged_in')['category'];
        if ($cat != 'suadmin') {
            redirect(base_url('welcome'));
        }
    }

    public function index()
    {
        if ($this->session->userdata('logged_in')) {
            redirect(base_url('welcome/dashboard'));
        } else {
            $this->load->view('part/outer/login');
        }
        // $this->load->view('temp/ui_notifications');
    }

    public function go($section = 1)
    {
        $category = $this->session->userdata('logged_in')['category'];
        $data['notifcations_en'] = $this->universal_model->get_me_unsceennotif($this->session->userdata('logged_in')['id']);
        if ($this->session->userdata('logged_in')) {
            switch ($section) {
                case 1:
                    if ($category === "employee") {
                        redirect(base_url('welcome/dashboard'));
                    }
                    //Edit Subject To 
                    $data['leavesall'] = $this->allselectablebytable('leaveconfig');
                    $data['allbranches'] = $this->universal_model->util_branch_reader();
                    $gettablecolums = $this->gettablecolumns('company');
                    $data['fields'] = $gettablecolums;
                    $data['controller'] = $this;
                    $data['content_part'] = 'company/Xleave';
                    $this->load->view('part/inside/index', $data);
                    //                    print_array($gettablecolums);
                    break;
                case 4:
                    $gettablecolums = $this->gettablecolumns('company');
                    $data['fields'] = $gettablecolums;
                    $data['controller'] = $this;
                    $branch_id = $this->check_gender_branch()['branch_id'];
                    $data['leavepending'] = $this->universal_model->selelectleavereqbybranch($branch_id, 0, 0);
                    $data['awardedleaves'] = $this->universal_model->selelectleavereqbybranch($branch_id, 0, 1);
                    $data['rejectedleaves'] = $this->universal_model->selelectleavereqbybranch($branch_id, 0, 2);
                    $data['content_part'] = 'company/Xleaveapproval';
                    $this->load->view('part/inside/index', $data);
                    break;
                case 9:
                    $gettablecolums = $this->gettablecolumns('company');
                    $data['fields'] = $gettablecolums;
                    $data['controller'] = $this;
                    $data['content_part'] = 'company/Xleavereports';
                    $this->load->view('part/inside/index', $data);
                    break;
                case 10:
                    $gettablecolums = $this->gettablecolumns('company');
                    $data['fields'] = $gettablecolums;
                    $data['controller'] = $this;
                    $data['content_part'] = 'company/Xleaverecallreports';
                    $this->load->view('part/inside/index', $data);
                    break;
                case 11:
                    $gettablecolums = $this->gettablecolumns('company');
                    $data['fields'] = $gettablecolums;
                    $data['controller'] = $this;
                    $data['content_part'] = 'company/Xleaverecallreversalreports';
                    $this->load->view('part/inside/index', $data);
                    break;
            }
        }
    }

    public function gettablecolumns($table)
    {

        //        $table = "company";
        $fields = $this->db->list_fields($table);
        foreach (array_keys($fields, 'slug', true) as $key) {
            unset($fields[$key]);
        }
        foreach (array_keys($fields, 'addedby', true) as $key) {
            unset($fields[$key]);
        }
        foreach (array_keys($fields, 'dateadded', true) as $key) {
            unset($fields[$key]);
        }
        foreach (array_keys($fields, 'id', true) as $key) {
            unset($fields[$key]);
        }
        $checkiftablecolums_exist = $this->universal_model->selectz('*', 'tablesettings', 'tablename', $table);
        if (empty($checkiftablecolums_exist)) {
            foreach ($fields as $tablecolumn) {
                $array_value = array(
                    'tablename' => $table,
                    'tablecolumn' => $tablecolumn,
                    'status' => 0,
                    'addedby' => $this->session->userdata('logged_in')['id']
                );
                $this->universal_model->insertz('tablesettings', $array_value);
            }
        }
        $checkiftablecolums_exist = $this->universal_model->selectz('*', 'tablesettings', 'tablename', $table);
        return $checkiftablecolums_exist;
    }

    //work company
    public function addcompany()
    { }

    //BRANCH START
    public function add()
    {
        $tablename = $this->input->post('tablename');
        switch ($tablename) {
            case 'addperdepartment':
                $array_insert = array(
                    'selectdepartment' => $this->input->post('selectdepartment'),
                    'id_leavetype' => $this->input->post('id_leavetype'),
                    'entitlement' => $this->input->post('entitlement'),
                    'startdate' => $this->input->post('startdaten'),
                    'enddate' => $this->input->post('enddaten'),
                    'addedby' => $this->session->userdata('logged_in')['id']
                );
                $gettablecolums = $this->universal_model->updateOnDuplicate($tablename, $array_insert);
                $arrayrep = array(
                    'status' => 0,
                    'message' => 'Successfully Updated'
                );
                echo json_encode($arrayrep);
                break;
            default:
                unset_post($_POST, 'tablename');
                $_POST['addedby'] = $this->session->userdata('logged_in')['id'];
                $gettablecolums = $this->universal_model->updateOnDuplicate($tablename, $_POST);
                $arrayrep = array(
                    'status' => 0,
                    'message' => 'Successfully Updated'
                );
                echo json_encode($arrayrep);
                break;
        }
    }

    public function loadbranch($tablenme)
    {
        // $tablenme = $this->input->post('tablename');
        switch ($tablenme) {
            case 'leaveconfig':
                //                $query = 'SELECT *, date_format(dateadded, "%d/%m/%Y") as dateadded,CONCAT(firstname," ",lastname) as names FROM  users WHERE branch_id = "' . $readerid . '"';
                //                $totalUnfiltered = $this->db->query($queryCount)->result_array();
                $loadregion = $this->universal_model->selectz('*', 'leaveconfig', 'slug', 0);
                $grid = new EditableGrid();
                $grid->addColumn('id', 'ID', 'string', NULL, false, NULL);
                $grid->addColumn('leavetype', 'LEAVE TYPE', 'string', NULL, false);
                $grid->addColumn('defaultentitlementleave', 'DEFAULT ENT', 'string', NULL, false);
                $grid->addColumn('maximumdays', 'MAXIMUM DAYS', 'string', NULL, false);
                $grid->addColumn('paid', 'PAID', 'boolean', NULL, false);
                $grid->addColumn('payrate', 'PAY RATE', 'string', NULL, false);
                $grid->addColumn('includehday', 'INCLUDE HOLIDAY', 'boolean', NULL, false);
                $grid->addColumn('narration', 'NARRATION', 'string', NULL, false);
                $grid->addColumn('recurring', 'RECURRING', 'boolean', NULL, false);
                $grid->addColumn('action', 'MANAGE', 'html', NULL, false, 'id');
                $grid->renderJSON($loadregion, false, false, !isset($_GET['data_only']));
                break;
            case 'holidayconfig':
                $loadregion = $this->universal_model->selectz('*', 'holidayconfig', 'slug', 0);
                $grid = new EditableGrid();
                $grid->addColumn('id', 'ID', 'string', NULL, false, NULL);
                $grid->addColumn('holidayname', 'HOLIDAY NAME ', 'string', NULL, false);
                $grid->addColumn('date', 'DATE', 'string', NULL, false);
                $grid->addColumn('repeatsannually', 'REPEATS ANNUALLY ', 'boolean', NULL, false);
                $grid->addColumn('payrate', 'PAY RATE', 'string', NULL, false);
                $grid->addColumn('action', 'MANAGE', 'html', NULL, false, 'id');
                $grid->renderJSON($loadregion, false, false, !isset($_GET['data_only']));
                break;
            case 'leaveapply':
                //                $id = $this->session->userdata('logged_in')['id'];
                $branch_id = $this->check_gender_branch()['branch_id'];
                $loadregion = $this->universal_model->selelectleavereqbybranch($branch_id, 0, 0);
                $grid = new EditableGrid();
                $grid->addColumn('id', 'ID', 'string', NULL, false, NULL);
                $grid->addColumn('id_leavetype', 'LEAVE TYPE', 'string', $this->leavetype(), false);
                $grid->addColumn('names', 'NAME', 'string', $this->leavetype(), false);
                $grid->addColumn('leaveperiod', 'LEAVE PERIOD', 'string', NULL, false);
                $grid->addColumn('leavefrom', 'FROM', 'string', NULL, false);
                $grid->addColumn('leaveto', 'TO', 'string', NULL, false);
                $grid->addColumn('leavebal', 'LEAVE BALANCE', 'string', NULL, false);
                $grid->addColumn('leavepurpose', 'PURPOSE', 'string', NULL, false);
                //                $grid->addColumn('documentleave', 'DOCUMENT LINK', 'string', NULL, false);
                $grid->addColumn('proceed', 'DOCUMENT LINK', 'html', NULL, false, 'id');
                $grid->addColumn('action', 'COUNSEL', 'html', NULL, false, 'id');
                $grid->renderJSON($loadregion, false, false, !isset($_GET['data_only']));
                break;
            case 'addperdepartment':
                $loadregion = $this->universal_model->selectz('*', 'addperdepartment', 'slug', 0);
                $grid = new EditableGrid();
                $grid->addColumn('id', 'ID', 'string', NULL, false, NULL);
                $grid->addColumn('id_leavetype', 'LEAVE TYPE', 'string', $this->leavetype(), false);
                $grid->addColumn('selectdepartment', 'DEPARTMENT', 'string', $this->departmenttype(), false);
                $grid->addColumn('startdate', 'START DATE', 'string', 'string', false);
                $grid->addColumn('enddate', 'END DATE', 'string', NULL, false);
                $grid->addColumn('entitlement', 'FROM', 'string', NULL, false);
                //                $grid->addColumn('leavebal', 'LEAVE BALANCE', 'string', NULL, false);
                //                $grid->addColumn('leavepurpose', 'PURPOSE', 'string', NULL, false);
                $grid->addColumn('action', 'REMOVE', 'html', NULL, false, 'id');
                $grid->renderJSON($loadregion, false, false, !isset($_GET['data_only']));
                break;
            case 'attendence_leaves':
                $startdate = $this->session->userdata('startdate_leave');
                $enddate = $this->session->userdata('enddate_leave');
                $pin = $this->session->userdata('user_pinleave');
                $loadregion = $this->universal_model->join_leave($startdate, $enddate, $pin);
                $grid = new EditableGrid();
                $grid->addColumn('id', 'ID', 'string', NULL, false, NULL);
                $grid->addColumn('idnumber', 'EMPLOYEE NO', 'string', NULL, false);
                $grid->addColumn('names', 'NAME', 'string', NULL, false);
                $grid->addColumn('leavedate', 'LEAVE DATE', 'string', NULL, false);
                $grid->addColumn('leavetype', 'LEAVE TYPE', 'string', NULL, false);
                $grid->addColumn('reverse', 'REVERSE', 'html', NULL, false, 'id');
                $grid->addColumn('recalls', 'RECALL', 'html', NULL, false, 'id');
                $grid->addColumn('action', 'REMOVE', 'html', NULL, false, 'id');
                $grid->renderJSON($loadregion, false, false, !isset($_GET['data_only']));
                break;
            default:
                break;
        }
    }

    public function loadleaveemployee($startdate, $endatex, $pin)
    {
        //          case 'attendence_leaves':
        //START
        $startdatex = tem_dateformat($startdate, 'Y-m-d');
        $endate = tem_dateformat($endatex, 'Y-m-d');
        $this->session->set_userdata('startdate_leave', $startdatex);
        $this->session->set_userdata('enddate_leave', $endate);
        $this->session->set_userdata('user_pinleave', $pin);
        //END
        //        data_for
        $loadregion = $this->universal_model->join_leave($startdatex, $endate, $pin);
        $grid = new EditableGrid();
        $grid->addColumn('id', 'ID', 'string', NULL, false, NULL);
        //        $grid->addColumn('idnumber', 'EMPLOYEE NO', 'string', NULL, false);
        $grid->addColumn('names', 'NAME', 'string', NULL, false);
        $grid->addColumn('leavedate', 'LEAVE DATE', 'string', NULL, false);
        $grid->addColumn('leavetype', 'LEAVE TYPE', 'string', NULL, false);
        //        $grid->addColumn('reverse', 'REVERSE', 'html', NULL, false, 'id');
        //        $grid->addColumn('recalls', 'RECALL', 'html', NULL, false, 'id');
        $grid->addColumn('action', 'REMOVE', 'html', NULL, false, 'id');
        $grid->renderJSON($loadregion, false, false, !isset($_GET['data_only']));
    }

    public function updatebranch()
    {
        $id = $this->input->post('id');
        $newvalue = $this->input->post('newvalue');
        $colname = $this->input->post('colname');
        $tablename = $this->input->post('tablename');
        $whatineed = array(
            $colname => $newvalue
        );
        // function updatez($variable, $value, $table_name, $updated_values) {
        $loadbranch = $this->universal_model->updatez('id', $id, $tablename, $whatineed);
        if ($loadbranch) {
            $arrayrep = array(
                'status' => 0,
                'message' => 'Successfully Updated'
            );
            echo json_encode($arrayrep);
        } else {
            $arrayrep = array(
                'status' => 1,
                'message' => 'Failed Updated'
            );
            echo json_encode($arrayrep);
        }
    }

    public function delete()
    {
        //        $_POST['tablename'] = 'attendence_leaves';
        //        $_POST['id'] = '115';
        $tablename = $this->input->post('tablename');
        $id = $this->input->post('id');
        switch ($tablename) {
            case 'attendence_leaves':
                $array_update = array(
                    'leavestatus' => 'XXX'
                );
                $leaveen = $this->universal_model->selectz('*', $tablename, 'id', $id);
                //                $dataarray = array_shift($leaveen);
                //START
                $this->session->set_flashdata('pin', $leaveen[0]['userpin']);
                //END
                $this->universal_model->deletez('attendence_leaves', 'id', $id);
                $this->universal_model->updatem('pin', $leaveen[0]['userpin'], 'dateclock', $leaveen[0]['leavedate'], 'trans', $array_update);
                $arrayrep = array(
                    'status' => 1,
                    'message' => 'Success '
                );
                echo json_encode($arrayrep);
                break;
            default:
                $this->universal_model->updatez('id', $id, $tablename, array('slug' => 1));
                $arrayrep = array(
                    'status' => 1,
                    'message' => 'Success '
                );
                echo json_encode($arrayrep);
                break;
        }
    }

    public function allselectablebytable($tablename)
    {
        $returnall = $this->universal_model->selectz('*', $tablename, 'slug', 0);
        return $returnall;
    }

    //BRANCH END
    public function leavegenerate()
    {
        //        $userid = 1406;
        $userid = $this->session->userdata('logged_in')['id'];
        $returnall = $this->universal_model->selectzy('*', 'users', 'slug', 0, 'id', $userid);
        if (!empty($returnall)) {
            $date_employed = $returnall[0]['dateemployeed'];
            $current_date = date('d-m-Y');
            if ($date_employed == "") {
                $date_employed = date('01-01-Y', strtotime($current_date));
                $array_updatedate = array(
                    'dateemployeed' => $date_employed
                );
                $this->universal_model->updatez('id', $userid, 'users', $array_updatedate);
            }
            //Number Of Months
            //Month End
            $diff = diffrencedatesmonths($date_employed, $current_date);
            //If Currey Forward 6 months expires
            if ($diff > 18) {
                $date_employed = date('01-01-Y', strtotime($current_date));
                $current_date = date('d-m-Y');
                $diff = diffrencedatesmonths($date_employed, $current_date);
            }
            $anualleave = round($diff * 1.75);
            $returnall = $this->universal_model->selectzy('*', 'leaverecord', 'slug', 0, 'id', $userid);
            if (empty($returnall)) {
                return $anualleave;
            } else {
                return $anualleave;
            }
        }
    }

    public function uploadapply()
    {
        //        $_POST['id'] = $this->session->userdata('logged_in')['id'];
        $id = $this->input->post('employee_id');
        $fileName = "";
        if (isset($_FILES['upload']['tmp_name'])) {
            for ($i = 0; $i < count($_FILES['upload']['tmp_name']); $i++) {
                $tmpFilePath = $_FILES['upload']['tmp_name'][$i];
                if (!empty($_FILES["upload"]["type"][$i])) {
                    $folder = 'leave';
                    //                    $fileName = time() . '_' . $_FILES['upload']['name'][$i];
                    $valid_extensions = array("jpeg", "jpg", "png", 'docx', 'doc', 'pdf', 'PDF');
                    $temporary = explode(".", $_FILES['upload']['name'][$i]);
                    $file_extension = end($temporary);
                    $fileName = getToken(4) . '_' . $id . '_' . $folder . '.' . $file_extension;
                    if (in_array($file_extension, $valid_extensions)) {
                        $sourcePath = $_FILES['upload']['tmp_name'][$i];
                        $targetPath = "upload/" . $folder . "/" . $fileName;
                        if (move_uploaded_file($sourcePath, $targetPath)) { }
                    } else {
                        $fileName = "failed";
                    }
                }
            }
        }
        if ($fileName != "failed") {
            $tablename = $this->input->post('tablename');
            $id_leavetype = $this->input->post('id_leavetype');
            $startdate = $this->input->post('startdate');
            $enddate = $this->input->post('enddate');
            $leaveto = $this->input->post('leaveto');
            $leavefrom = $this->input->post('leavefrom');
            $leavebal = $this->input->post('leavebal');
            $leavepurpose = $this->input->post('leavepurpose');
            $data_leaveapp = array(
                'leaveperiod' => $startdate . ' to ' . $enddate,
                'id_leavetype' => $id_leavetype,
                'appliedby' => $id,
                'leavefrom' => $leavefrom,
                'leaveto' => $leaveto,
                'leavebal' => $leavebal,
                'leavepurpose' => $leavepurpose,
                'documentleave' => $fileName,
                'addedby' => $this->session->userdata('logged_in')['id']
            );
            $this->universal_model->updateOnDuplicate($tablename, $data_leaveapp);
            echo json_encode(array('message' => 'Leave Successfully Applied', 'state' => 'ok'));
        } else if ($fileName == "failed") {
            echo json_encode(array('message' => 'Wrong File Format'));
        }
    }

    public function leavetype()
    {
        $arraysele = array(
            'id',
            'leavetype'
        );
        $allclients = $this->universal_model->selectall($arraysele, 'leaveconfig');
        $finalarray = array();
        foreach ($allclients as $value) {
            $finalarray[$value['id']] = $value['leavetype'];
        }
        return $finalarray;
    }

    public function departmenttype()
    {
        $arraysele = array(
            'id',
            'department'
        );
        $allclients = $this->universal_model->selectall($arraysele, 'departments');
        $finalarray = array();
        foreach ($allclients as $value) {
            $finalarray[$value['id']] = $value['department'];
        }
        $finalarray[0] = 'ALL';
        //        print_array($finalarray);
        return $finalarray;
    }

    public function check_gender_branch()
    {
        $id = $this->session->userdata('logged_in')['id'];
        $returnall = $this->universal_model->selectzy(array('id_gender', 'branch_id'), 'users', 'slug', 0, 'id', $id);
        return array_shift($returnall);
    }

    public function approvalleave_m()
    {
        //        $leaveid = 1;
        $leaveid = $this->input->post('leaveid');
        $status = $this->input->post('status');
        $getmeleave = $this->universal_model->selectz('*', 'leaveapply', 'id', $leaveid);
        //        print_array($getmeleave);s
        $from_date = $getmeleave[0]['leavefrom'];
        $to_date = $getmeleave[0]['leaveto'];
        $id_leavetype = $getmeleave[0]['id_leavetype'];
        $amountawarded = $getmeleave[0]['leavebal'];
        $appliedby = $getmeleave[0]['appliedby'];
        $id_standbycollege = $getmeleave[0]['id_standbycollege'];
        //        leavebalance
        //        //START GET LEAVE 
        $leavebalance = $this->universal_model->selectzy('*', 'leavebalance', 'leavetype', $id_leavetype, 'user_id', $appliedby);
        $leavecurrentbalance = $leavebalance[0]['leavecurrentbalance'];
        $reminder = $leavecurrentbalance - $amountawarded;
        $leavebalance[0]['leavecurrentbalance'] = $reminder;
        $this->universal_model->updateOnDuplicate('leavebalance', $leavebalance[0]);
        echo json_encode($leavebalance);
        //        //END LEAVE
        //        appliedby
    }

    public function approvalleave()
    {
        //        $_POST['leaveid'] = 3;
        //        $_POST['status'] = "reject";
        $leaveid = $this->input->post('leaveid');
        $status = $this->input->post('status');
        $getmeleave = $this->universal_model->selectz('*', 'leaveapply', 'id', $leaveid);
        $from_date = $getmeleave[0]['leavefrom'];
        $to_date = $getmeleave[0]['leaveto'];
        $id_leavetype = $getmeleave[0]['id_leavetype'];
        $amountawarded = $getmeleave[0]['leavebal'];
        $appliedby = $getmeleave[0]['appliedby'];
        $getmepin = $this->universal_model->selectz('*', 'users', 'id', $appliedby);
        $names = $getmepin[0]['firstname'] . ' ' . $getmepin[0]['lastname'];
        switch ($status) {
            case 'approve':
                //start
                $pin_user = $getmepin[0]['pin'];
                //MY DATA
                $data['names'] = $names;
                $data['startdate'] = $from_date;
                $data['enddate'] = $to_date;
                $data['leaveperiod'] = $getmeleave[0]['leaveperiod'];
                //MY DATA
                $rageme = $this->universal_model->selectrangedatesperpin($pin_user, $from_date, $to_date);
                $leavedaterange = getDatesFromRange($from_date, $to_date);
                if (!empty($rageme)) {
                    foreach ($leavedaterange as $dateleave) {
                        //Update Time Trans
                        $this->universal_model->updateOnDuplicate('leaverecord', array('userpin' => $pin_user, 'status' => 1, 'leavedate' => $dateleave, 'leavetype_id' => $id_leavetype));
                        $this->universal_model->updatem('pin', $pin_user, 'dateclock', $dateleave, 'trans', array(
                            'leavestatus' => $id_leavetype
                        ));
                    }
                }
                foreach ($leavedaterange as $dateleave) {
                    $array_instance_date = array(
                        'addedby' => $this->session->userdata('logged_in')['id'],
                        'leavecode' => $id_leavetype,
                        'leavedate' => $dateleave,
                        'userpin' => $pin_user
                    );
                    $this->universal_model->updateOnDuplicate('attendence_leaves', $array_instance_date);
                }
                //end
                $this->universal_model->updatez('id', $leaveid, 'leaveapply', array('state' => 1));
                $arrayrep = array(
                    'status' => 1,
                    'report' => 'Successfully Approved '
                );
                //NOTI START
                $body = $this->load->view('emailmessage/v_leaveawarded', $data, TRUE);
                $this->mailsender($body, 'LEAVE APPLICATION APPROVED', $getmepin[0]['emailaddress'], $names, 1);
                $array_time = array(
                    'comment_subject' => 'LEAVE APPROVED',
                    'to_id' => $appliedby,
                    'comment_text' => $names . ' ' . ' from ' . $from_date . ' to ' . $to_date,
                    'comment_status' => 1
                );
                $token_extract = $this->universal_model->selectz('*', 'util_tokens', 'user_id', $appliedby);
                if (!empty($token_extract)) {
                    $this->sendnotifications(array_shift($token_extract)['token'], 'LEAVE APPROVED', ' From ' . $from_date . ' to ' . $to_date);
                }
                $this->universal_model->updateOnDuplicate('util_comments', $array_time);
                //NOTI END
                //START GET LEAVE 
                $leavebalance = $this->universal_model->selectzy('*', 'leavebalance', 'leavetype', $id_leavetype, 'user_id', $appliedby);
                $leavecurrentbalance = $leavebalance[0]['leavecurrentbalance'];
                $reminder = $leavecurrentbalance - $amountawarded;
                $leavebalance[0]['leavecurrentbalance'] = $reminder;
                $this->universal_model->updateOnDuplicate('leavebalance', $leavebalance[0]);
                //        //END LEAVE
                echo json_encode($arrayrep);
                break;
            case 'reject':
                $pin_user = $getmepin[0]['pin'];
                $this->universal_model->updatez('id', $leaveid, 'leaveapply', array('state' => 2));
                $arrayrep = array(
                    'status' => 2,
                    'report' => 'Not Approved'
                );
                //NOTIS
                $data['names'] = $names;
                $data['startdate'] = $from_date;
                $data['enddate'] = $to_date;
                $data['leaveperiod'] = $getmeleave[0]['leaveperiod'];
                $body = $this->load->view('emailmessage/v_leavearejected', $data, TRUE);
                $this->mailsender($body, 'LEAVE APPLICATION REJECTED', $getmepin[0]['emailaddress'], $names, 0);
                $array_time = array(
                    'comment_subject' => 'LEAVE REJECTED',
                    'to_id' => $appliedby,
                    'comment_text' => $names . ' ' . ' from ' . $from_date . ' to ' . $to_date,
                    'comment_status' => 1
                );
                $token_extract = $this->universal_model->selectz('*', 'util_tokens', 'user_id', $appliedby);
                if (!empty($token_extract)) {
                    $this->sendnotifications(array_shift($token_extract)['token'], 'LEAVE REJECTED', ' From ' . $from_date . ' to ' . $to_date);
                }
                $this->universal_model->updateOnDuplicate('util_comments', $array_time);
                //NOTIS
                echo json_encode($arrayrep);
                break;
            default:
                break;
        }
        //        echo json_encode($arrayrep);
    }

    public function leaverevockreverse()
    {
        $leaveid = $this->input->post('leaveid');
        $getmeleave = $this->universal_model->selectz('*', 'attendence_leaves', 'id', $leaveid);
        if (!empty($getmeleave)) {
            $this->universal_model->updatem('pin', $getmeleave[0]['userpin'], 'dateclock', $getmeleave[0]['leavedate'], 'trans', array(
                'leavestatus' => 'XXX'
            ));
            //STEP 2
            $this->universal_model->updatez('id', $leaveid, 'leaveapply', array('state' => 2));
            $arrayrep = array(
                'status' => 1,
                'report' => 'Leave Revocked'
            );
            $this->universal_model->updateOnDuplicate('leaverecord', array('userpin' => $getmeleave[0]['userpin'], 'status' => '5', 'leavedate' => $getmeleave[0]['leavedate'], 'leavetype_id' => $getmeleave[0]['leavecode']));
            //STEP 3
            $useridarray = $this->universal_model->selectz(array('id'), 'users', 'pin', $getmeleave[0]['userpin']);
            $user_id = array_shift($useridarray)['id'];
            $array_time = array(
                'comment_subject' => 'LEAVE REVERSED BY ADMIN',
                'to_id' => $user_id,
                'comment_text' => ' Date Reversed ' . $getmeleave[0]['leavedate'],
                'comment_status' => 1
            );
            $token_extract = $this->universal_model->selectz('*', 'util_tokens', 'user_id', $user_id);
            if (!empty($token_extract)) {
                $this->sendnotifications(array_shift($token_extract)['token'], 'LEAVE REVERSED BY ADMIN', ' DATE ' . $getmeleave[0]['leavedate']);
            }
            $this->universal_model->updateOnDuplicate('util_comments', $array_time);
            $this->universal_model->deletez('attendence_leaves', 'id', $leaveid);
            echo json_encode($arrayrep);
        } else {
            $arrayrep = array(
                'status' => 0,
                'report' => 'Failed To Revocked Contact Admin'
            );
            echo json_encode($arrayrep);
        }
    }

    public function leavererecalls()
    {
        $leaveid = $this->input->post('leaveid');
        $getmeleave = $this->universal_model->selectz('*', 'attendence_leaves', 'id', $leaveid);
        if (!empty($getmeleave)) {
            $this->universal_model->updatem('pin', $getmeleave[0]['userpin'], 'dateclock', $getmeleave[0]['leavedate'], 'trans', array(
                'leavestatus' => 'XXX'
            ));
            //STEP 2
            //            $this->universal_model->updatez('id', $leaveid, 'leaveapply', array('state' => 3));
            $arrayrep = array(
                'status' => 1,
                'report' => 'Employee Recalled'
            );
            $this->universal_model->updateOnDuplicate('leaverecord', array('userpin' => $getmeleave[0]['userpin'], 'status' => '4', 'leavedate' => $getmeleave[0]['leavedate'], 'leavetype_id' => $getmeleave[0]['leavecode']));
            //STEP 3
            $useridarray = $this->universal_model->selectz(array('id'), 'users', 'pin', $getmeleave[0]['userpin']);
            $user_id = array_shift($useridarray)['id'];
            $array_time = array(
                'comment_subject' => 'LEAVE RECALLED BY ADMIN',
                'to_id' => $user_id,
                'comment_text' => ' Date Reversed ' . $getmeleave[0]['leavedate'],
                'comment_status' => 1
            );
            $token_extract = $this->universal_model->selectz('*', 'util_tokens', 'user_id', $user_id);
            if (!empty($token_extract)) {
                $this->sendnotifications(array_shift($token_extract)['token'], 'LEAVE RECALLED BY ADMIN', ' DATE ' . $getmeleave[0]['leavedate']);
            }
            $this->universal_model->updateOnDuplicate('util_comments', $array_time);
            $this->universal_model->deletez('attendence_leaves', 'id', $leaveid);
            echo json_encode($arrayrep);
        } else {
            $arrayrep = array(
                'status' => 0,
                'report' => 'Failed To Revocked Contact Admin'
            );
            echo json_encode($arrayrep);
        }
    }

    public function mailsender($html, $headermail, $email, $names, $state = 0)
    {
        $mail = new PHPMailer(true);
        try {
            //            $name_mail = array_shift($replaytoemail);
            //Server settings
            //            $mail->SMTPDebug = 2;                                       // Enable verbose debug output
            $mail->isSMTP();                                            // Set mailer to use SMTP
            $mail->Host = 'smtp.pepea.co.ke';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                                   // Enable SMTP authentication
            $mail->Username = 'biometrics@alfabiz.co.ke';                     // SMTP username
            $mail->Password = 'b10@1ph@biz';                               // SMTP password
            //            $mail->SMTPSecure = 'tls';
            $mail->SMTPSecure = false;
            $mail->SMTPAutoTLS = false; // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to
            //Recipients
            $mail->setFrom('biometrics@alfabiz.co.ke', 'Alfahrm HRMS');
            $mail->addAddress('dominic@alfabiz.co.ke', $names);
            if ($state == 1) {
                $mail->addAttachment(FCPATH . 'upload/leave/leaveapplication.PDF');
            }
            // Add a recipient
            // Attachments
            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $headermail . ' | ' . $names;
            $mail->Body = $html;
            //            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
            $mail->send();
            return true;
            //            echo 'Message has been sent';
        } catch (Exception $e) {
            return false;
            //            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    public function sendnotifications($token, $title, $body)
    {
        $serviceAccount = ServiceAccount::fromJsonFile(APPPATH . '/helpers/alfabiz-4ebd3-1a936e5e96fd.json');
        $firebase = (new Factory)
            ->withServiceAccount($serviceAccount)
            // The following line is optional if the project id in your credentials file
            // is identical to the subdomain of your Firebase project. If you need it,
            // make sure to replace the URL with the URL of your project.
            ->withDatabaseUri('https://alfabiz-4ebd3.firebaseio.com')
            ->create();
        $messaging = $firebase->getMessaging();
        $notification = Notification::create()
            ->withTitle($title)
            ->withBody($body);
        $message = CloudMessage::withTarget('token', $token)
            ->withNotification($notification);
        $messaging->send($message);
    }

    public function test()
    {
        $data['names'] = 'names';
        $data['startdate'] = 'from';
        $data['enddate'] = 'to';
        $data['leaveperiod'] = 'to from ';
        $this->load->view('emailmessage/v_leavearejected', $data);
        //        $body = $this->load->view('emailmessage/v_leavearejected', $data, TRUE);
        //        echo FCPATH . 'upload/leave/leaveapplication.PDF';
        //        $this->mailsender($body, 'LEAVE APPLICATION APPROVED', 'jovu', 'NJ');
        //        print_array($leavepending);
    }
}
