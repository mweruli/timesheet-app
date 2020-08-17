<?php

require_once (APPPATH . 'libraries/EditableGrid.php');

class Payroll extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('universal_model');
    }

    public function go($section = 1, $userid = null) {
        $category = $this->session->userdata('logged_in') ['category'];
        if ($this->session->userdata('logged_in')) {
            switch ($section) {
                case 1 :
                    if ($category === "employee") {
                        redirect(base_url('welcome/dashboard'));
                    } else if ($userid != null) {
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
                    $data['departments'] = $this->universal_model->selectz('*', 'departments', 'slug', 0);
                    $data['allbranches'] = $this->universal_model->util_branch_reader('p');
                    $data ['controller'] = $this;
                    $data ['content_part'] = 'company/Xpayrolloperations';
                    $this->load->view('part/inside/index', $data);
                    break;
                case 2 :
                    $data['departments'] = $this->universal_model->selectz('*', 'departments', 'slug', 0);
                    $data['allbranches'] = $this->universal_model->util_branch_reader('p');
                    $data ['controller'] = $this;
                    $data ['content_part'] = 'company/Xpayrollreport';
                    $this->load->view('part/inside/index', $data);
                    break;
            }
        }
    }

    public function getemployeetype() {
        $emptype = $this->universal_model->selectz('*', 'employementtypes', 'slug', 0);
        return $emptype;
    }

    public function loadjobtitle() {
        $checkiftablecolums_exist = $this->universal_model->selectz('*', 'jobtitles', 'slug', 0);
//        print_array($checkiftablecolums_exist);
        return $checkiftablecolums_exist;
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

    public function loademployeescustome($readerid) {
        $query = 'SELECT *, date_format(dateadded, "%d/%m/%Y") as dateadded,CONCAT(firstname," ",lastname) as names FROM  customparamsview WHERE branch_id = "' . $readerid . '"';
        $queryCount = 'SELECT count(branch_id) as nb FROM  customparamsview WHERE branch_id = "' . $readerid . '"';
        $totalUnfiltered = $this->db->query($queryCount)->result_array() [0] ['nb'];
        $total = $totalUnfiltered;
        $page = 0;
        if (isset($_GET ['page']) && is_numeric($_GET ['page']))
            $page = (int) $_GET ['page'];
        $rowByPage = 10;
        if ($page != 0) {
            $from = ($page - 1) * $rowByPage;
        } else {
            $from = 0;
        }
        if (isset($_GET ['filter']) && $_GET ['filter'] != "") {
            $filter = $_GET ['filter'];
            $query .= '  AND lastname like "%' . $filter . '%" OR firstname like "%' . $filter . '%"';
            $queryCount .= '  AND lastname like "%' . $filter . '%" OR firstname like "%' . $filter . '%"';
            $total = $this->db->query($queryCount)->result_array() [0] ['nb'];
        }
        if (isset($_GET ['sort']) && $_GET ['sort'] != "")
            $query .= " AND ORDER BY " . $_GET ['sort'] . ($_GET ['asc'] == "0" ? " DESC " : "");
//                $loadregion = $this->universal_model->selectjoinemployeetable($array_selectable);
        $query .= " LIMIT " . $from . ", " . $rowByPage;
        //END PIGNATION
        $grid = new EditableGrid ();
        $grid->addColumn('code', 'DEDUCTION CODE', 'string', NULL, false);
        $grid->addColumn('emailaddress', 'EMAIL', 'string', NULL, false);
        $grid->addColumn('names', 'NAMES', 'string', NULL, false);
        $grid->addColumn('description', 'DESCRIPTION', 'string', NULL, false);
        $grid->addColumn('amount', 'AMOUNT', 'string', NULL, false);
        $grid->addColumn('dateadded', 'DATE ADDED', 'string', NULL, false);
//                $grid->addColumn('delete', 'MANAGE', 'html', NULL, false, 'id');
        $grid->setPaginator(ceil($total / $rowByPage), (int) $total, (int) $totalUnfiltered, null);
//        $result = $this->db->query($query)->result_array();
        $result = $this->db->query($query)->result_array();
        $grid->renderJSON($result, false, false, !isset($_GET ['data_only']));
    }

    public function loademployeesbybranch($readerid) {

//customparamsview
        //        $loadregion = $this->universal_model->selectz('*', 'employeeprofile', 'branchname', $readerid);
        $query = 'SELECT *, date_format(dateadded, "%d/%m/%Y") as dateadded,CONCAT(firstname," ",lastname) as names FROM  users WHERE branch_id = "' . $readerid . '"';
        $queryCount = 'SELECT count(id) as nb FROM  users WHERE branch_id = "' . $readerid . '"';
        $totalUnfiltered = $this->db->query($queryCount)->result_array() [0] ['nb'];
        $total = $totalUnfiltered;
        $page = 0;
        if (isset($_GET ['page']) && is_numeric($_GET ['page']))
            $page = (int) $_GET ['page'];
        $rowByPage = 10;
        if ($page != 0) {
            $from = ($page - 1) * $rowByPage;
        } else {
            $from = 0;
        }
        if (isset($_GET ['filter']) && $_GET ['filter'] != "") {
            $filter = $_GET ['filter'];
            $query .= '  AND lastname like "%' . $filter . '%" OR firstname like "%' . $filter . '%"';
            $queryCount .= '  AND lastname like "%' . $filter . '%" OR firstname like "%' . $filter . '%"';
            $total = $this->db->query($queryCount)->result_array() [0] ['nb'];
        }
        if (isset($_GET ['sort']) && $_GET ['sort'] != "")
            $query .= " AND ORDER BY " . $_GET ['sort'] . ($_GET ['asc'] == "0" ? " DESC " : "");
//                $loadregion = $this->universal_model->selectjoinemployeetable($array_selectable);
        $query .= " LIMIT " . $from . ", " . $rowByPage;
        //END PIGNATION
        $grid = new EditableGrid ();
        $grid->addColumn('employee_code', 'EMP NO', 'string', NULL, false);
        $grid->addColumn('pin', 'ID NUMBER', 'string', NULL, false);
        $grid->addColumn('nhifnumber', 'NHIF NUMBER', 'string', NULL, false);
        $grid->addColumn('nssfnumber', 'NSSF NUMBER', 'string', NULL, false);
        $grid->addColumn('names', 'NAMES', 'string', NULL, false);
        $grid->addColumn('action', 'MANAGE', 'html', NULL, false, 'id');
        $grid->addColumn('proceed', 'ADD LOAN', 'html', NULL, false, 'id');
        $grid->setPaginator(ceil($total / $rowByPage), (int) $total, (int) $totalUnfiltered, null);
//        $result = $this->db->query($query)->result_array();
        $result = $this->db->query($query)->result_array();
        $grid->renderJSON($result, false, false, !isset($_GET ['data_only']));
    }

    public function addcustomstouser() {
        $branch_start = $this->input->post('branch_start');
        $employeenumberminxarray = $this->input->post('employeenumberminx');
        $employeenumbermin = explode('|', $employeenumberminxarray);
        $employmenttype_id = $this->input->post('employmenttype_id');
        $customededuc_id = $this->input->post('customededuc_id');
        $amount_custome = $this->input->post('amount_custome');
        $array_getbranch = explode('$', $branch_start);
        $array_proof = array(
            'branch_id' => $array_getbranch[0],
            'user_pin' => $employeenumbermin[1],
            'id_customdeduct' => $customededuc_id,
            'amount' => $amount_custome,
            'id_emptype' => $employmenttype_id,
            'addedby' => $this->session->userdata('logged_in') ['id']
        );
        $gettablecolums = $this->universal_model->updateOnDuplicate('user_customeaddition', $array_proof);
        $arrayrep = array(
            'status' => $gettablecolums,
            'message' => 'Not Successfull Contact Admin'
        );
        echo json_encode($arrayrep);
    }

    public function payslip() {
        //START
//        $datemonthly
//        userid
//        END
//        $gettablecolums = $this->universal_model->selectzy('*', 'users', 'employmenttype_id', 2, 'branch_id', 6);
//        $gettablecolums = $this->universal_model->selectzx('*', 'users', 'employmenttype_id', 2, 'branch_id', 6, 'id', 628);
//        print_array($gettablecolums);
        //users
        //employmenttype_id
        //branch_id
        //Date Monthly
    }

    public function testbranch() {
//        payslipjoin COMING SOON
        $allbranches = $this->universal_model->util_branch_reader('p');
        print_array($allbranches);
    }

}
