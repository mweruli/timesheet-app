<?php

require_once (APPPATH . 'libraries/EditableGrid.php');

class Humanr extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('universal_model');
//        https://github.com/chat21
    }

    public function index() {
        $this->go();
    }

    public function go($section = 1, $userid = null) {
        $category = $this->session->userdata('logged_in') ['category'];
        switch ($section) {
            case 1 :
                if ($category === "employee") {
                    redirect(base_url('welcome/dashboard'));
                }
                $gettablecolums = $this->universal_model->selectz('*', 'tablesettings', 'tablename', 'company');
//                $regions = $this->universal_model->selectz('*', 'regions', 'slug', 0);
                $fieldsdata = $this->universal_model->selectall('*', 'company');
                if (empty($fieldsdata)) {
                    $data['fieldsdata'] = array();
                } else {
                    $data['fieldsdata'] = $fieldsdata[array_keys($fieldsdata)[0]];
                }
                $data['companies'] = $fieldsdata;
                $data['fields'] = $gettablecolums;
                $data ['controller'] = $this;
                if ($userid != null) {
                    $employeevaluesprofile = $this->universal_model->selectz('*', 'users', 'id', $userid);
                    if (!empty($employeevaluesprofile)) {
                        $employeevaluesprofile = $employeevaluesprofile[0];
                    }
                    $lastnameto = explode(" ", $employeevaluesprofile['lastname']);
                    if (count($lastnameto) >= 1) {
                        $employeevaluesprofile['lastname'] = $lastnameto[0];
//                        print_array($lastnameto);
                        if (array_key_exists(1, $lastnameto)) {
                            if ($lastnameto[1] != $employeevaluesprofile['firstname']) {
                                $employeevaluesprofile['middlename'] = $lastnameto[1];
                            }
                        }
                    }
                    $data['employeevaluesprofile'] = $employeevaluesprofile;
                }
                $data['employementtypes'] = $this->getemployeetype();
//                $data['companybranch'] = $this->getcompanybranch();
                $data['jobtitle'] = $this->loadjobtitle();
                $data['allbranches'] = $this->universal_model->util_branch_reader();
                $data['departments'] = $this->universal_model->selectz('*', 'departments', 'slug', 0);
                $data ['content_part'] = 'company/Xhumanr';
                $this->load->view('part/inside/index', $data);
                break;
        }
    }

    public function getemployeetype() {
        $emptype = $this->universal_model->selectz('*', 'employementtypes', 'slug', 0);
        return $emptype;
    }

    public function getcompanybranch() {
        $emptype = $this->universal_model->selectz('*', 'branches', 'slug', 0);
        return $emptype;
    }

    public function gettablecolumns($table) {
//        $table = "company";
        $fields = $this->db->list_fields($table);
        foreach (array_keys($fields, 'slug', true) as $key) {
            unset($fields [$key]);
        }
        foreach (array_keys($fields, 'addedby', true) as $key) {
            unset($fields [$key]);
        }
        foreach (array_keys($fields, 'dateadded', true) as $key) {
            unset($fields [$key]);
        }
        foreach (array_keys($fields, 'id', true) as $key) {
            unset($fields [$key]);
        }
        $checkiftablecolums_exist = $this->universal_model->selectz('*', 'tablesettings', 'tablename', $table);
        if (empty($checkiftablecolums_exist)) {
            foreach ($fields as $tablecolumn) {
                $array_value = array(
                    'tablename' => $table,
                    'tablecolumn' => $tablecolumn,
                    'status' => 0,
                    'addedby' => $this->session->userdata('logged_in') ['id']
                );
                $this->universal_model->insertz('tablesettings', $array_value);
            }
        }
        $checkiftablecolums_exist = $this->universal_model->selectz('*', 'tablesettings', 'tablename', $table);
        return $checkiftablecolums_exist;
    }

    public function loadbranch() {
        $companyid = $this->input->post('companyid');
        $companybranches = $this->universal_model->selectz('*', 'branches', 'id_company', $companyid);
        echo json_encode($companybranches);
    }

    public function humanperson() {
        $employeevalues = array();
        $employeevalues['firstname'] = 'blue';
        printvalues('dob', $employeevalues);
        echo printvalues('firstname', $employeevalues);
//        $id = $this->input->post('id');
//        echo json_encode($_POST);
    }

    public function updateperson() {

        if (!empty($_FILES['file']['name'])) {
            $uploadedFile = '';
            if (!empty($_FILES["file"]["type"])) {
                $fileName = time() . '_' . $_FILES['file']['name'];
                $valid_extensions = array("jpeg", "jpg", "png");
                $temporary = explode(".", $_FILES["file"]["name"]);
                $file_extension = end($temporary);
                if ((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/jpeg")) && in_array($file_extension, $valid_extensions)) {
                    $sourcePath = $_FILES['file']['tmp_name'];
                    $targetPath = "upload/employeeprofile/" . $fileName;
                    if (move_uploaded_file($sourcePath, $targetPath)) {
                        $uploadedFile = $fileName;
                    }
                }
            }
            $datatoadd = array(
                'user_image_small' => $uploadedFile
            );
            $this->universal_model->updatez('id', $this->input->post('id'), 'users', $datatoadd);
//            $insert = $db->query("INSERT form_data (name,email,file_name) VALUES ('" . $name . "','" . $email . "','" . $uploadedFile . "')");
            if ($this->input->post('userprofileold') != '' || $this->input->post('userprofileold') != null) {
//                unlink("upload/employeeprofile/" . $this->input->post('userprofileold'));
            }
            $message = array(
                'state' => 'ok',
                'message' => 'User Profile Updated Successfully'
            );
            echo json_encode($message);
        } else {
            $message = array(
                'state' => 'err',
                'message' => 'Select a valid image file (JPEG/JPG/PNG)'
            );
            echo json_encode($message);
        }
    }

    function updateworkinfo() {
        $id = $this->input->post('id');
        unset_post($_POST, 'id');
        unset_post($_POST, 'submit');
        $this->universal_model->updatez('id', $id, 'users', $_POST);
        $message = array(
            'state' => 'ok',
            'message' => 'User Work Info Updated Successfully'
        );
        echo json_encode($message);
    }

    function userexperience() {
//        $id = $this->input->post('id');
//        unset_post($_POST, 'id');
        unset_post($_POST, 'submit');
//        $this->universal_model->updatez('id', $id, 'users', $_POST);
//        $message = array(
//            'state' => 'ok',
//            'message' => 'User Bio Data Updated Successfully'
//        );
//        echo json_encode($message);
        $this->universal_model->updateOnDuplicate('user_experience', $_POST);
        $message = array(
            'state' => 'ok',
            'message' => 'User Experience Updated Successfully'
        );
        echo json_encode($message);
    }

    function deletetable() {
        $emp_id = $this->input->post('emply_id');
        $oraganisation = $this->input->post('oraganisation');
        $fromdate = $this->input->post('fromdate');
        $this->universal_model->deletezn('user_experience', 'id_employee', $emp_id, 'organization', $oraganisation, 'fromexper', $fromdate);
//         deletezm($table_name, $variable_1, $value_1, $variable_2, $value_2) {
        $response = array(
            'status' => 1,
            'message' => 'Successfully Deleted'
        );
        echo json_encode($response);
    }

    function edituserinfo() {
        $emp_id = $this->input->post('emply_id');
        $oraganisation = $this->input->post('oraganisation');
        $fromdate = $this->input->post('fromdate');
        $dataperuser = $this->universal_model->selectzxpp('*', 'user_experience', 'id_employee', $emp_id, 'organization', $oraganisation, 'fromexper', $fromdate);
        $this->session->set_flashdata('edituserexperience', $dataperuser);
//         deletezm($table_name, $variable_1, $value_1, $variable_2, $value_2) {
        $response = array(
            'status' => 1,
            'message' => 'Successfully Deleted'
        );
        echo json_encode($response);
    }

    function updatepersonbiodata() {
        $array_analyseglob = array();
        if (isset($_FILES['upload']['tmp_name'])) {
            for ($i = 0; $i < count($_FILES['upload']['tmp_name']); $i++) {
                $tmpFilePath = $_FILES['upload']['tmp_name'][$i];
                $array_analyse = array();
                if (!empty($_FILES["upload"]["type"][$i])) {
                    $folder = 'cvs';
//                    $fileName = time() . '_' . $_FILES['upload']['name'][$i];
                    $valid_extensions = array("jpeg", "jpg", "png", 'docx', 'doc', 'pdf');
                    if ($i === 0) {
                        $folder = 'passportphotos';
                    }
                    if ($i === 1) {
                        $folder = 'cvs';
                    }
                    $temporary = explode(".", $_FILES['upload']['name'][$i]);
                    $file_extension = end($temporary);
                    $fileName = $this->input->post('firstname') . '_' . $this->input->post('id') . '_' . $folder . '.' . $file_extension;
                    if (in_array($file_extension, $valid_extensions)) {
                        $sourcePath = $_FILES['upload']['tmp_name'][$i];
                        $targetPath = "upload/" . $folder . "/" . $fileName;
                        if (move_uploaded_file($sourcePath, $targetPath)) {
                            $uploadedFile = $fileName;
                            $array_analyse[$folder] = $uploadedFile;
                            array_push($array_analyseglob, $array_analyse);
                        }
//                        if ($this->input->post('passportold') != '' || $this->input->post('passportold') != null) {
//                            unlink("upload/passportphotos/" . $this->input->post('passportold'));
//                        }
//                        if ($this->input->post('curiculumvitaeold') != '' || $this->input->post('curiculumvitaeold') != null) {
//                            unlink("upload/cvs/" . $this->input->post('curiculumvitaeold'));
//                        }
                    }
                }
            }
        }
        if (!empty($array_analyseglob)) {
            if (isset($array_analyseglob[0]['passportphotos'])) {
                $_POST['passportphoto'] = $array_analyseglob[0]['passportphotos'];
            }
            if (isset($array_analyseglob[1]['cvs'])) {
                $_POST['curiculumvitae'] = $array_analyseglob[1]['cvs'];
            }
        }
        $id = $this->input->post('id');
        if ($this->input->post('dateterminated') != null || $this->input->post('dateterminated') != "") {
            $_POST['activestateemployee'] = 0;
        } else {
            $_POST['activestateemployee'] = 1;
        }
        unset_post($_POST, 'curiculumvitaeold');
        unset_post($_POST, 'id');
        unset_post($_POST, 'passportold');
        unset_post($_POST, 'submit');
        $this->universal_model->updatez('id', $id, 'users', $_POST);
        $message = array(
            'state' => 'ok',
            'message' => 'User Bio Data Updated Successfully'
        );
        echo json_encode($message);
    }

    public function loadbankbranch() {
        $bankid = $this->input->post('bankid');
        $bankbranches = $this->universal_model->selectz('*', 'bankbranches', 'id_bank', $bankid);
        echo json_encode($bankbranches);
    }

    public function loadjobtitle() {
        $checkiftablecolums_exist = $this->universal_model->selectz('*', 'jobtitles', 'slug', 0);
//        print_array($checkiftablecolums_exist);
        return $checkiftablecolums_exist;
    }

    public function allselectablebytable($tablename) {
        $returnall = $this->universal_model->selectz('*', $tablename, 'slug', 0);
        return $returnall;
    }

    public function allselectablebytablewhere($tablename, $variable, $value) {
        $returnalln = $this->universal_model->selectz('*', $tablename, $variable, $value);
        return $returnalln;
    }

    public function allselectablebytablewhereone($tablename, $variable, $value, $variable1, $value1) {
        $returnalln = $this->universal_model->selectzy('*', $tablename, $variable, $value, $variable1, $value1);
        return $returnalln;
    }

    public function getforeightable($arraywhatselec, $table, $refrence, $value) {
//        function selectzy($array_table_n, $table_n, $variable_1, $value_1, $variable_2, $value_2) {
        $datarefrence = $this->universal_model->selectzy($arraywhatselec, $table, $refrence, $value, 'slug', 0);
        return $datarefrence;
    }

//so it begins
    public function add() {
        $tablename = $this->input->post('tablename');
        unset_post($_POST, 'tablename');
        $gettablecolums = $this->universal_model->updateOnDuplicate($tablename, $_POST);
        $arrayrep = array(
            'status' => 0,
            'message' => 'Successfully Updated'
        );
        echo json_encode($arrayrep);
    }

    function test() {
        $values = $this->allselectablebytable('util_branch_reader');
        print_array($values);
    }

    function emreportreport__temp() {
        echo json_encode($_POST);
    }

    function emreportreport() {
        $branch_startpay = $this->input->post('branch_startpayemreport');
        $employeenumbermaxxpay = $this->input->post('employeenumbermaxxpayemreport');
        $employeenumberminxpay = $this->input->post('employeenumberminxpayemreport');
        $employmenttype_id = $this->input->post('employmenttype_id');
        $employementstatus_id = $this->input->post('employementstatus_id');
        // PROCESS
        $employeenumberminxarray = explode('|', $employeenumberminxpay);
        $employeenumbermaxxarray = explode('|', $employeenumbermaxxpay);
        $array_last_name = 0;
        if ($employeenumbermaxxarray[0] != '') {
            $array_last_name = $employeenumbermaxxarray[0][0];
        }
        $branchcode = explode('$', $branch_startpay);
        //plug start
        $brancharray = $this->universal_model->selectz(array('branchname'), 'util_branch_reader', 'readerserial', $branchcode[0]);
        $branchname = array_shift($brancharray)['branchname'];
        //plug end
        $reportarray = $this->universal_model->getrangeforemployeereport(array('pysicaladdress', 'firstname', 'lastname', 'middlename', 'staffno', 'employee_code', 'basicpay', 'b.pin', 'nssfnumber', 'nhifnumber', 'accountnumber', 'idnumber'), $branchname);
        // print_array($reportarray);
//        echo json_encode($reportarray);
        if (empty($reportarray)) {
            $report = "No Data Found For This Request Adjust Parameters ";
            $json_return = array(
                'report' => $report,
                'status' => 0
            );
            echo json_encode($json_return);
        } else {
//            echo json_encode($reportarray);
            $json_return = array(
                'report' => "Data For This Request loaded",
                'status' => 1,
                'data' => $this->generatereportemreportablehtml($reportarray, $employmenttype_id, $employementstatus_id, $branchcode[0])
            );
            echo json_encode($json_return);
        }
    }

    function generatereportemreportablehtml($reportarray, $employmenttype_id, $employementstatus_id, $branchcode) {
        $template = array(
            'table_open' => '<table class="table table-striped table-hover" id="emreportfortnight_card">',
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
        $branchname = $this->universal_model->selectz(array('branchname'), 'util_branch_reader', 'readerserial', $branchcode)[0]['branchname'];
        $printernames = $this->universal_model->selectz(array('firstname', 'lastname'), 'users', 'user_id', $this->session->userdata('logged_in') ['user_id'])[0];
        $name = 'PRINTED BY:' . $printernames['firstname'] . "~" . $printernames['lastname'];
        $one = '<TR><TH SCOPE=colgroup COLSPAN="100%"><font size="5" color="green">ASL TRADING - ' . $this->universal_model->selectz(array('employementtype'), 'employementtypes', 'id', $employmenttype_id)[0]['employementtype'] . ' STAFF</font></TH></TR>';
        $oneone = '<TR><TH SCOPE=colgroup COLSPAN="100%"><font size="4">BRANCH :</font><font size="4" color="brown">' . $branchname . '</font><font size="4"> STATE : </font> <font size="4" color="brown">' . $this->universal_model->selectz(array('status'), 'employementstatus', 'id', $employementstatus_id)[0]['status'] . '</font></TH></TR>';
        $two = '<TR>
      <TH SCOPE=colgroup COLSPAN="7%">Printed On: <b>' . date("d/m/Y") . '</b></TH>
      <TH SCOPE=colgroup COLSPAN="40%"><b style="text-align:right;">' . $name . '</b></TH></TR>';
        $coinagecountheader = '<TR><TH SCOPE=colgroup COLSPAN=4>STAFF NUMBER</TH><TH COLSPAN=4>NAMES</TH><TH COLSPAN=4>ID NO</TH></TR>';
        $headerheader = '<THEAD>' . $one . $oneone . $two . $coinagecountheader . '<THEAD>';
        $this->table->add_row($headerheader);
        $totalemployees = 0;
        foreach ($reportarray as $reportdata) {
            $totalemployees += 1;
            $employee_codecol = array(
                'data' => $reportdata['employee_code'],
                // 'class' => 'info'
                // 'style' => "font-size: 15px; color: black; background-color: burlywood;"
                'colspan' => 2
            );
            $namescol = array(
                'data' => $reportdata['firstname'] . ' ' . $reportdata['lastname'] . ' ' . $reportdata['middlename'],
                // 'class' => 'info'
                // 'style' => "font-size: 15px; color: black; background-color: burlywood;"
                'colspan' => 2
            );
            $pincol = array(
                'data' => $reportdata['pin'],
                // 'class' => 'info'
                // 'style' => "font-size: 15px; color: black; background-color: burlywood;"
                'colspan' => 2
            );
            $space = array(
                'data' => '',
                // 'class' => 'info'
                // 'style' => "font-size: 15px; color: black; background-color: burlywood;"
                'colspan' => 2
            );
            $this->table->add_row($employee_codecol, $space, $namescol, $space, $pincol);
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
            'data' => $totalemployees,
            'style' => "font-size: 15px;",
            // 'class' => 'info'
            'colspan' => 2
        );
        $this->table->add_row($grandtotal, $space, $nettotalv, $space, $space, $space, $space);
        // $this->getdaterangechosen($startcountdate, $datefromnow);
        return $this->table->generate();
    }

}
