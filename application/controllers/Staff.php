<?php

require 'vendor/autoload.php';
require_once(APPPATH . 'libraries/EditableGrid.php');

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Firebase\Messaging\CloudMessage;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader


class Staff extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('universal_model');
    }

    public function index()
    {
        if ($this->session->userdata('logged_in')) {
            redirect(base_url('welcome/dashboard'));
        } else {
            $this->load->view('part/outer/login');
        }
    }

    public function go($to = 1)
    {
        $data['notifcations_en'] = $this->universal_model->get_me_unsceennotif($this->session->userdata('logged_in')['id']);
        switch ($to) {
            case 1:
                $data['controller'] = $this;
                $branch = $this->check_gender_branch()['branch_id'];
                $id = $this->session->userdata('logged_in')['id'];
                $data['leavepending'] = $this->universal_model->selelectleavereqbybranchperuser($branch, 0, 0, $id);
                $data['awardedleaves'] = $this->universal_model->selelectleavereqbybranchperuser($branch, 0, 1, $id);
                $data['rejectedleaves'] = $this->universal_model->selelectleavereqbybranchperuser($branch, 0, 2, $id);
                $data['content_part'] = 'company/Xleavestaff';
                $this->load->view('part/inside/index', $data);
                break;
            case 2:
                $data['controller'] = $this;
                $data['content_part'] = 'company/Xleavestaffleavestatus';
                $this->load->view('part/inside/index', $data);
                break;
            default:
                break;
        }
    }

    public function uploadapply()
    {
        $_POST['id'] = $this->session->userdata('logged_in')['id'];
        $leavefrom = $this->input->post('leavefrom');
        $leaveto = $this->input->post('leaveto');
        $leavebal = $this->input->post('leavebal');
        $count = count(getDatesFromRange($leavefrom, $leaveto));
        $leavebalm = (int) $leavebal;
        $current_date = date('d-m-Y');
        $id_branch = $this->input->post('id_branch');
        $id = $this->input->post('id');
        $tablename = $this->input->post('tablename');
        $id_leavetype = $this->input->post('id_leavetype');
        $startdate = $this->input->post('startdate');
        $enddate = $this->input->post('enddate');
        $leavepurpose = $this->input->post('leavepurpose');
        $id_standbycollege = $this->input->post('id_standbycollege');
        $fileName = "";
        //NO OF APPLICATIONS PER DAY
        $current_date_m = date('Y-m');
        $checkapplications = $this->universal_model->selectz_var('*', 'leaveapply', 'appliedby', $id, "DATE_FORMAT(dateadded,'%Y-%m-%d')=" . '"' . $current_date . '"');
        $checkapplications_m = $this->universal_model->selectz_var('*', 'leaveapply', 'appliedby', $id, "DATE_FORMAT(dateadded,'%Y-%m')=" . '"' . $current_date_m . '"');
        $amountofallplocations = count($checkapplications);
        $amountofallplocations_m = count($checkapplications_m);
        //END
        if (strtotime($leaveto) < strtotime($leavefrom) || strtotime($leaveto) == strtotime($leavefrom) || $count >= 200) {
            echo json_encode(array('report' => 1, 'error' => 'Invalid Date Range FROM and TO'));
        }
        //        && strtotime($leaveto) > strtotime($leavefrom)
        else if (strtotime($current_date) > strtotime($leavefrom)) {
            echo json_encode(array('report' => 1, 'error' => 'You can not go for leave in the past'));
        } else if ($count >= $leavebalm) {
            echo json_encode(array('report' => 1, 'error' => 'Days away exceeds requested days'));
        } else if ($amountofallplocations > 3 || $amountofallplocations_m > 5) {
            echo json_encode(array('report' => 1, 'error' => 'Number Of Applications Have Exceeded Maximum Number'));
        } else {
            if (isset($_FILES['upload']['tmp_name'])) {
                for ($i = 0; $i < count($_FILES['upload']['tmp_name']); $i++) {
                    $tmpFilePath = $_FILES['upload']['tmp_name'][$i];
                    if (!empty($_FILES["upload"]["type"][$i])) {
                        $folder = 'leave';
                        //                    $fileName = time() . '_' . $_FILES['upload']['name'][$i];
                        $valid_extensions = array("jpeg", "jpg", "png", 'docx', 'doc', 'pdf', 'PDF');
                        $temporary = explode(".", $_FILES['upload']['name'][$i]);
                        $file_extension = end($temporary);
                        $fileName = getToken(4) . '_' . $this->input->post('id') . '_' . $folder . '.' . $file_extension;
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
                $data_leaveapp = array(
                    'leaveperiod' => $startdate . ' to ' . $enddate,
                    'id_leavetype' => $id_leavetype,
                    'appliedby' => $this->session->userdata('logged_in')['id'],
                    'leavefrom' => $leavefrom,
                    'leaveto' => $leaveto,
                    //Leave Balance Is The Date Range
                    'leavebal' => $count,
                    'id_standbycollege' => $id_standbycollege,
                    'leavepurpose' => $leavepurpose,
                    'id_branch' => $id_branch,
                    'documentleave' => $fileName,
                    'addedby' => $this->session->userdata('logged_in')['id']
                );
                $this->universal_model->updateOnDuplicate($tablename, $data_leaveapp);
                $adminsperbranch = $this->universal_model->selectzy(array('id', 'emailaddress', 'CONCAT(users.firstname," ",users.lastname) as names'), 'users', 'branch_id', $id_branch, 'category', 'suadmin');
                //MESSAGE CONSTRUCT
                $_namesmail = $this->universal_model->selectz(array('CONCAT(users.firstname," ",users.lastname) as names', 'emailaddress'), 'users', 'id', $id);
                //        $data['name'] = array_shift($_namesmail)['names'];
                $names = array_shift($_namesmail)['names'];
                $startdate_of = $this->input->post('startdate');
                $enddate_of = $this->input->post('enddate');
                $data['names'] = $names;
                $data['startdate'] = $startdate_of;
                $data['enddate'] = $enddate_of;
                $data['leavefrom'] = $this->input->post('leavefrom');
                $data['leaveto'] = $this->input->post('leaveto');
                foreach ($adminsperbranch as $emailneeded) {
                    $array_time = array(
                        'comment_subject' => 'LEAVE APPLICATION',
                        'to_id' => $emailneeded['id'],
                        'comment_text' => $names . ' ' . ' applied leave from ' . $startdate_of . ' to ' . $enddate_of,
                        'comment_status' => 1
                    );
                    $token_extract = $this->universal_model->selectz('*', 'util_tokens', 'user_id', $emailneeded['id']);
                    if (!empty($token_extract)) {
                        $this->sendnotifications(array_shift($token_extract)['token'], 'LEAVE APPLICATION', $names . ' ' . ' applied leave from ' . $startdate_of . ' to ' . $enddate_of);
                    }
                    $this->universal_model->updateOnDuplicate('util_comments', $array_time);
                }
                //        $this->load->view('emailmessage/v_sendcredentials', $data);emailaddress
                //        $body = $this->load->view('emailmessage/v_leaverequested', $data, TRUE);
                //        $this->mailsender($body, $adminsperbranch, $adminsperbranch);
                echo json_encode(array('message' => 'Leave Successfully Applied', 'state' => 'ok'));
            } else if ($fileName == "failed") {
                echo json_encode(array('report' => 1, 'error' => 'Wrong File Format'));
            }
        }
    }

    public function gettablecolumns($table)
    {
        // $table = "company";
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

    public function allselectablebytable($tablename)
    {
        $returnall = $this->universal_model->selectz('*', $tablename, 'slug', 0);
        return $returnall;
    }

    public function leavegenerate($userid, $leaveype)
    {
        // $checkthisuser = $this->universal_model->selectz('*', 'leavebalance', 'user_id', $userid);
        $checkthisuser = $this->universal_model->selectzy('*', 'leavebalance', 'user_id', $userid, 'leavetype', $leaveype);
        if (empty($checkthisuser)) {
            //             function selectz($array_table_n, $table_n, $variable_1, $value_1)
            $returnall = $this->universal_model->selectz('*', 'users', 'id', $userid);
            $date_employed = $returnall[0]['dateemployeed'];
            //            $id_gender = $returnall[0]['id_gender'];
            $gendername = $returnall[0]['id_gender'];
            $current_date = date('d-m-Y');
            if ($date_employed == "") {
                $date_employed = date('01-01-Y', strtotime($current_date));
                $array_updatedate = array(
                    'dateemployeed' => $date_employed
                );
                $this->universal_model->updatez('id', $userid, 'users', $array_updatedate);
            }
            //IF MALE
            $allleave = $this->universal_model->selectz('*', 'leaveconfig', 'slug', 0);
            //            if ($gendername == 1) {
            //                $allleave = $this->universal_model->selectz_var('*', 'leaveconfig', 'slug', 0, 'leavetype!="' . $leaveype . '"');
            //            }
            //            //IF FEMALE
            //            else if ($gendername == 0) {
            //                $allleave = $this->universal_model->selectz_var('*', 'leaveconfig', 'slug', 0, 'leavetype!="' . $leaveype . '"');
            ////                echo '<br>MALE';
            //            } else {
            //                $allleave = $this->universal_model->selectz('*', 'leaveconfig', 'slug', 0);
            //            }
            $diff = diffrencedatesmonths($date_employed, $current_date);
            //If Currey Forward 6 months expires
            if ($diff > 18) {
                $date_employed = date('01-01-Y', strtotime($current_date));
                $current_date = date('d-m-Y');
                $diff = diffrencedatesmonths($date_employed, $current_date);
            }
            $anualleave = round($diff * 1.75);
            foreach ($allleave as $extraleaves) {
                if (strpos($extraleaves['leavetype'], 9) !== false) {
                    $extraleaves['defaultentitlementleave'] = $anualleave;
                }
                $en_array = array(
                    'user_id' => $userid,
                    'leavetype' => $extraleaves['id'],
                    'leavebroughtforward' => 0,
                    'leavecurrentbalance' => $extraleaves['defaultentitlementleave'],
                );
                //                print_array($en_array);
                $this->universal_model->updateOnDuplicate('leavebalance', $en_array);
            }
        }
        $checkthisuser = $this->universal_model->selectzy('*', 'leavebalance', 'user_id', $userid, 'leavetype', $leaveype);
        //        print_array($checkthisuser);
        return $checkthisuser;
    }

    public function check_gender_branch()
    {
        $id = $this->session->userdata('logged_in')['id'];
        $returnall = $this->universal_model->simplegendercheck(array('u.id_gender', 'u.branch_id', 'g.gender'), $id);
        return array_shift($returnall);
    }

    public function loadbranch($tablenme)
    {
        // $tablenme = $this->input->post('tablename');
        switch ($tablenme) {
            case 'leaveapply':
                $id = $this->session->userdata('logged_in')['id'];
                $loadregion = $this->universal_model->selectzx('*', 'leaveapply', 'slug', 0, 'appliedby', $id, 'state', 0);
                $grid = new EditableGrid();
                $grid->addColumn('id', 'ID', 'string', NULL, false, NULL);
                $grid->addColumn('id_leavetype', 'LEAVE TYPE', 'string', $this->leavetype(), false);
                $grid->addColumn('leaveperiod', 'LEAVE PERIOD', 'string', NULL, false);
                $grid->addColumn('leavefrom', 'FROM', 'string', NULL, false);
                $grid->addColumn('leaveto', 'TO', 'string', NULL, false);
                $grid->addColumn('leavebal', 'DAYS REQYESTED', 'string', NULL, false);
                $grid->addColumn('leavepurpose', 'PURPOSE', 'string', NULL, false);
                //                $grid->addColumn('documentleave', 'DOCUMENT LINK', 'string', NULL, false);
                $grid->addColumn('proceed', 'DOCUMENT LINK', 'html', NULL, false, 'id');
                $grid->addColumn('action', 'COUNSEL', 'html', NULL, false, 'id');
                $grid->renderJSON($loadregion, false, false, !isset($_GET['data_only']));
                break;
            default:
                break;
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

    public function delete()
    {
        $tablename = $this->input->post('tablename');
        $id = $this->input->post('id');
        switch ($tablename) {
            case 'leaveapply':
                $this->universal_model->deletez($tablename, 'id', $id);
                //                You will come back here
                //                $this->universal_model->deletez('util_comments', 'id', $id);
                break;
            default:
                $this->universal_model->deletez($tablename, 'id', $id);
                break;
        }
        echo json_encode($_POST);
    }

    public function calldocument($id)
    {
        $lockfordoc = $this->universal_model->selectz('*', 'leaveapply', 'id', $id);
        if (!empty($lockfordoc)) {
            $doc_url = base_url('/upload/leave/' . array_shift($lockfordoc)['documentleave']);
        } else {
            $doc_url = "";
        }
        echo json_encode(array('docurl' => $doc_url));
    }

    //    public function mailsender($html, $_namesmail, $replaytoemail) {
    //        $name_mail = array_shift($replaytoemail);
    //        print_array($_namesmail);
    //    }
    public function mailsender($html, $_namesmail, $replaytoemail)
    {
        $mail = new PHPMailer(true);
        try {
            $name_mail = array_shift($replaytoemail);
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
            if (!empty($_namesmail)) {
                foreach ($_namesmail as $nameemail) {
                    $mail->addAddress($nameemail['emailaddress'], $nameemail['names']);
                }
            }
            // Add a recipient
            // Attachments
            // Content
            if ($name_mail['emailaddress'] != "") {
                $mail->addReplyTo($replaytoemail, 'Information');
            }
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'LEAVE APPLICATION | ' . $name_mail['names'];
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

    //Notification
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

    public function get_me_alluser_perbranch($branch_id)
    {
        $users_branches = $this->universal_model->selectzy('*', 'users', 'branch_id', $branch_id, 'slug', 0);
        return $users_branches;
    }

    function calculateleave()
    {
        $id = $this->input->post('userid');
        $id_leavetype = $this->input->post('leavetype');
        $datarangestart = $this->input->post('startdate');
        $datarangeend = $this->input->post('enddate');
        $current_date = date('d-m-Y');
        $diffinmonths = diffrencedatesmonths($datarangestart, $datarangeend);
        if ($diffinmonths > 18) {
            echo json_encode(array('report' => 1, 'error' => 'Should Not Exceed 18 Months Backwards'));
        } else if (strtotime($current_date) <= strtotime($datarangeend) || strtotime($current_date) <= strtotime($datarangestart) || strtotime($datarangeend) == strtotime($datarangestart)) {
            echo json_encode(array('report' => 1, 'error' => 'Invalid Date Range of LEAVE PERIOD'));
        } else {
            $leave_value = $this->leavegenerate($id, $id_leavetype);
            $count = count(getDatesFromRange($datarangestart, $datarangeend));
            $availabedays = $leave_value[0]['leavebroughtforward'] + $leave_value[0]['leavecurrentbalance'];
            if ($count > $availabedays) {
                echo json_encode(array('report' => 1, 'error' => 'Leave Requested Is More Than Available Days'));
            } else {
                echo json_encode(array('report' => 0, 'message' => 'Balance Loaded Successfully', 'amount' => $count));
            }
        }
    }

    function calculateleave_admin()
    {
        //        $_POST['pin'] = "33108322";
        //        $_POST['enddate'] = "2019-09-24";
        //        $_POST['startdate'] = "2019-08-26";
        //        $_POST['leavetype'] = '6';
        $pin = $this->input->post('pin');
        $getuser_id = $this->universal_model->selectz(array('id'), 'users', 'pin', $pin);
        $id = $getuser_id[0]['id'];
        $id_leavetype = $this->input->post('leavetype');
        $datarangestart = $this->input->post('startdate');
        $datarangeend = $this->input->post('enddate');
        $diffinmonths = diffrencedatesmonths($datarangestart, $datarangeend);
        //        print_array($diffinmonths);
        if ($diffinmonths > 18) {
            echo json_encode(array('report' => 1, 'error' => 'Should Not Exceed 18 Months Backwards'));
        }
        //        else if (strtotime($current_date) <= strtotime($datarangeend) || strtotime($current_date) <= strtotime($datarangestart) || strtotime($datarangeend) == strtotime($datarangestart)) {
        //            echo json_encode(array('report' => 1, 'error' => 'Invalid Date Range of LEAVE PERIOD'));
        //        }
        else {
            $leave_value = $this->leavegenerate($id, $id_leavetype);
            $count = count(getDatesFromRange($datarangestart, $datarangeend));
            //            print_array($datarangeend);
            //            print_array($datarangestart);
            $availabedays = $leave_value[0]['leavebroughtforward'] + $leave_value[0]['leavecurrentbalance'];
            if ($count > $availabedays) {
                echo json_encode(array('report' => 1, 'error' => 'Leave Requested Is More Than Available Days'));
            } else {
                echo json_encode(array('report' => 0, 'message' => 'Balance Loaded Successfully', 'amount' => $count));
            }
        }
    }

    function validation_steptwo()
    {
        $pin = $this->input->post('pin');
        $getuser_id = $this->universal_model->selectz(array('id'), 'users', 'pin', $pin);
        $id = $getuser_id[0]['id'];
        $leavefrom = $this->input->post('startdate');
        $leaveto = $this->input->post('enddate');
        $leavebal = $this->input->post('leavebal');
        $count = count(getDatesFromRange($leavefrom, $leaveto));
        $leavebalm = (int) $leavebal;
        $current_date = date('d-m-Y');
        //        $id = $this->input->post('id');
        //NO OF APPLICATIONS PER DAY
        $current_date_m = date('Y-m');
        $checkapplications = $this->universal_model->selectz_var('*', 'leaveapply', 'appliedby', $id, "DATE_FORMAT(dateadded,'%Y-%m-%d')=" . '"' . $current_date . '"');
        $checkapplications_m = $this->universal_model->selectz_var('*', 'leaveapply', 'appliedby', $id, "DATE_FORMAT(dateadded,'%Y-%m')=" . '"' . $current_date_m . '"');
        $amountofallplocations = count($checkapplications);
        $amountofallplocations_m = count($checkapplications_m);
        //END
        // || strtotime($leaveto) == strtotime($leavefrom)
        if (strtotime($leaveto) < strtotime($leavefrom) || $count >= 200) {
            echo json_encode(array('report' => 1, 'error' => 'Invalid Date Range FROM and TO'));
        }
        //        else if (strtotime($current_date) > strtotime($leavefrom)) {
        //            echo json_encode(array('report' => 1, 'error' => 'You can not go for leave in the past'));
        //        } 
        else if ($count > $leavebalm) {
            echo json_encode(array('report' => 1, 'error' => 'Days away exceeds requested days'));
        } else if ($amountofallplocations > 3 || $amountofallplocations_m > 5) {
            echo json_encode(array('report' => 1, 'error' => 'Number Of Applications Have Exceeded Maximum Number'));
        } else {
            echo json_encode(array('report' => 4, 'error' => 'This Works'));
        }
    }
}
