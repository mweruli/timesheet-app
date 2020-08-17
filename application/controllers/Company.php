<?php

require_once (APPPATH . 'libraries/EditableGrid.php');

class Company extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('universal_model');
    }

    public function go($section = 1) {
        $category = $this->session->userdata('logged_in') ['category'];
        if ($this->session->userdata('logged_in')) {
            switch ($section) {
                case 1 :
                    if ($category === "employee") {
                        redirect(base_url('welcome/dashboard'));
                    }
                    $gettablecolums = $this->universal_model->selectz('*', 'tablesettings', 'tablename', 'company');
                    $regions = $this->universal_model->selectz('*', 'regions', 'slug', 0);
                    $fieldsdata = $this->universal_model->selectall('*', 'company');
                    if (empty($fieldsdata)) {
                        $data['fieldsdata'] = array();
                    } else {
                        $data['fieldsdata'] = $fieldsdata[array_keys($fieldsdata)[0]];
                    }
                    $data['regions'] = $regions;
                    $data['companies'] = $fieldsdata;
                    $data['fields'] = $gettablecolums;
                    $data ['controller'] = $this;
                    $data['departments'] = $this->universal_model->selectz('*', 'departments', 'slug', 0);
                    $data ['content_part'] = 'company/Xcompany_config';
                    $this->load->view('part/inside/index', $data);
                    break;
                case 2:
                    $data ['controller'] = $this;
                    $data ['content_part'] = 'company/Xhr_config';
                    $this->load->view('part/inside/index', $data);
                    break;
                case 3:
                    $data ['controller'] = $this;
                    $data ['content_part'] = 'company/Xother_config';
                    $this->load->view('part/inside/index', $data);
                    break;
                case 4:
                    $data['banksid'] = $this->universal_model->selectz('*', 'banks', 'slug', 0);
                    $data ['controller'] = $this;
                    $data ['content_part'] = 'company/Xbank';
                    $this->load->view('part/inside/index', $data);
                    break;
                case 5:
                    $data ['controller'] = $this;
                    $data ['content_part'] = 'company/Xpayroll';
                    $this->load->view('part/inside/index', $data);
                    break;
            }
        }
    }

    public function test() {
        $loadregion = $this->gettablecolumns('users');
        print_array($loadregion);
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

//work company
    public function addcompany() {
        //check
        $fieldsdata = $this->universal_model->selectall('*', 'company');
        if (!empty($fieldsdata)) {
            $singularfiled = $fieldsdata[array_keys($fieldsdata)[0]];
            if ($singularfiled['companylogo'] != '500_iconuserdefault.png') {
                unlink("upload/client/" . $singularfiled['companylogo']);
            }
        }
        $generatedname = "companylogo" . getToken(3);
        $config ['overwrite'] = TRUE;
        $config['upload_path'] = './upload/client/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 4000;
        $config ['file_name'] = $generatedname;
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('user_profile_pic')) {
            $error = array('error' => $this->upload->display_errors());
            $_POST ['companylogo'] = "500_iconuserdefault.png";
//            echo json_encode($error);
        } else {
            $data = array('upload_data' => $this->upload->data());
            $name_file = $data ['upload_data'];
            $_POST ['companylogo'] = $name_file ['file_name'];
//            echo json_encode($data);
        }
        $gettablecolums = $this->universal_model->updateOnDuplicate('company', $_POST);
        if ($gettablecolums <= 0) {
            $arrayrep = array(
                'status' => 0,
                'message' => 'Not Successfull Contact Admin'
            );
            echo json_encode($arrayrep);
        } else {
            $arrayrep = array(
                'status' => 0,
                'message' => 'Successfully Updated'
            );
            echo json_encode($arrayrep);
        }
    }

//BRANCH START

    public function add_test() {
        echo json_encode($_POST);
    }

    public function add() {
        $tablename = $this->input->post('tablename');
        unset_post($_POST, 'tablename');
        $_POST['addedby'] = $this->session->userdata('logged_in') ['id'];
        $gettablecolums = $this->universal_model->updateOnDuplicate($tablename, $_POST);
        $arrayrep = array(
            'status' => 0,
            'message' => 'Successfully Updated'
        );
        echo json_encode($arrayrep);
//        echo json_encode($_POST);
    }

    public function loadbranch($tablenme) {
//        $tablenme = $this->input->post('tablename');
        switch ($tablenme) {
            case 'branches':
                $whatineed = array(
                    'b.id as id',
                    'b.slug',
                    'branch',
                    'contactperson',
                    'b.email',
                    'b.telephone',
                    'c.name as companyname'
                );
                $loadbranch = $this->universal_model->join_getbranchcompany($whatineed);
                foreach ($loadbranch as $key => $valuesn) {
                    if ($valuesn['slug'] == 1) {
                        $loadbranch[$key]['slug'] = 'YES';
                    } elseif ($valuesn['slug'] == 0) {
                        $loadbranch[$key]['slug'] = 'NO';
                    }
                }
                $grid = new EditableGrid ();
                $grid->addColumn('id', 'BRANCH ID', 'string', NULL, false);
                $grid->addColumn('slug', 'DISABLED', 'string', NULL, false);
                $grid->addColumn('branch', 'BRANCH NAME', 'string');
                $grid->addColumn('contactperson', 'CONTACT PERSON', 'string');
                $grid->addColumn('email', 'CONTACT EMAIL', 'string');
                $grid->addColumn('telephone', 'CONTACT PHONE', 'string');
                $grid->addColumn('readerserial', 'BRANCH READERS', 'string', NULL, false);
                $grid->addColumn('action', 'ABLE/DIS', 'html', NULL, false, 'id');
                //filter
                $mydb_tablename = 'branches';
                $query = 'SELECT *, date_format(dateadded, "%d/%m/%Y") as lastvisit FROM ' . $mydb_tablename;
                $queryCount = 'SELECT count(id) as nb FROM ' . $mydb_tablename;
                $totalUnfiltered = $this->db->query($queryCount)->result_array() [0] ['nb'];
                $total = $totalUnfiltered;
                $page = 0;
                if (isset($_GET['page']) && is_numeric($_GET['page']))
                    $page = (int) $_GET['page'];
                $rowByPage = 50;
//                if ($page != 0) {
//                    $from = ($page - 1) * $rowByPage;
//                } else {
//                    $from = 0;
//                }
                $from = ($page - 1) * $rowByPage;
                if (isset($_GET['filter']) && $_GET['filter'] != "") {
                    $filter = $_GET['filter'];
                    $query .= '  WHERE branch like "%' . $filter . '%" OR contactperson like "%' . $filter . '%"';
                    $queryCount .= '  WHERE branch like "%' . $filter . '%" OR contactperson like "%' . $filter . '%"';
                    $total = $this->db->query($queryCount)->result_array() [0] ['nb'];
                }
                if (isset($_GET['sort']) && $_GET['sort'] != "")
                    $query .= " ORDER BY " . $_GET['sort'] . ( $_GET['asc'] == "0" ? " DESC " : "" );
                $query .= " LIMIT " . $from . ", " . $rowByPage;
                $grid->setPaginator(ceil($total / $rowByPage), (int) $total, (int) $totalUnfiltered, null);
                $result = $this->db->query($query)->result_array();
                //filter end
                $grid->renderJSON($result, false, false, !isset($_GET ['data_only']));
                break;
            case 'regions':
                $whatineed = array(
                    'b.id as id',
                    'b.slug',
                    'region',
                    'contactperson',
                    'b.email',
                    'b.telephone',
                    'c.name as companyname'
                );
                $loadregion = $this->universal_model->join_getregioncompany($whatineed);
                foreach ($loadregion as $key => $valuesn) {
                    if ($valuesn['slug'] == 1) {
                        $loadregion[$key]['slug'] = 'YES';
                    } elseif ($valuesn['slug'] == 0) {
                        $loadregion[$key]['slug'] = 'NO';
                    }
                }
                $grid = new EditableGrid ();
                $grid->addColumn('id', 'REGION ID', 'string', NULL, false);
                $grid->addColumn('slug', 'DISABLED', 'string', NULL, false);
                $grid->addColumn('companyname', 'COMPANY', 'string', NULL, false);
                $grid->addColumn('region', 'REGION', 'string');
                $grid->addColumn('email', 'EMAIL', 'string');
                $grid->addColumn('telephone', 'CONTACT', 'string');
                $grid->addColumn('action', 'DIS?ABLE', 'html', NULL, false, 'id', false, true);
                $grid->renderJSON($loadregion, false, false, !isset($_GET ['data_only']));
                break;
            case 'stations':
                $whatineed = array(
                    's.id as id',
                    's.contactperson',
                    'c.name as companyname',
                    'r.region as region',
                    's.station as station',
                    's.telephone'
                );
                $loadregion = $this->universal_model->join_getstation($whatineed);
                $grid = new EditableGrid ();
                $grid->addColumn('id', 'ID', 'string', NULL, false, NULL);
                $grid->addColumn('companyname', 'COMPANY', 'string', NULL, false);
                $grid->addColumn('region', 'REGION', 'string');
                $grid->addColumn('station', 'STATION', 'string');
                $grid->addColumn('contactperson', 'CONTACT PERSON', 'string');
                $grid->addColumn('telephone', 'CONTACT', 'string');
                $grid->addColumn('action', 'DIS?ABLE', 'html', NULL, false, 'id');
                $grid->renderJSON($loadregion, false, false, !isset($_GET ['data_only']));
                break;
            case 'departments':
                $whatineed = array(
                    'd.id as id',
                    'department',
                    'contactperson',
                    'd.telephone',
                    'c.name as companyname'
                );
                $loadregion = $this->universal_model->join_getdepartments($whatineed);
                $grid = new EditableGrid ();
                $grid->addColumn('id', 'ID', 'string', NULL, false, NULL);
                $grid->addColumn('companyname', 'COMPANY', 'string', NULL, false);
                $grid->addColumn('department', 'DEPERTMENT', 'string');
                $grid->addColumn('contactperson', 'CONTACT PERSON', 'string');
                $grid->addColumn('telephone', 'CONTACT', 'string');
                $grid->renderJSON($loadregion, false, false, !isset($_GET ['data_only']));
                break;
            case 'sections':
                $whatineed = array(
                    's.id as id',
                    's.contactperson as contactperson',
                    's.contactperson as contactperson',
                    's.email as email',
                    'c.name as companyname',
                    'd.department as department',
                    's.section as section'
                );
                $loadregion = $this->universal_model->join_getsection($whatineed);
                $grid = new EditableGrid ();
                $grid->addColumn('id', 'ID', 'string', NULL, false, NULL);
                $grid->addColumn('companyname', 'COMPANY', 'string', NULL, false);
                $grid->addColumn('contactperson', 'PERSON IN CHARGE', 'string', NULL, false);
                $grid->addColumn('email', 'EMAIL', 'string', NULL, false);
                $grid->addColumn('department', 'DEPERTMENT', 'string');
                $grid->addColumn('section', 'SECTION', 'string');
                $grid->addColumn('section', 'SECTION', 'string');
                $grid->renderJSON($loadregion, false, false, !isset($_GET ['data_only']));
                break;
            case 'genders':
                $loadregion = $this->universal_model->selectall('*', 'genders');
                $grid = new EditableGrid ();
                $grid->addColumn('id', 'ID', 'string', NULL, false, NULL);
                $grid->addColumn('id_gender', 'GENDER', 'string');
                $grid->addColumn('description', 'DESCRIPTION', 'string');
                $grid->addColumn('action', 'DELETE', 'html', NULL, false, 'id');
                $grid->renderJSON($loadregion, false, false, !isset($_GET ['data_only']));
                break;
            case 'employementtypes':
                $loadregion = $this->universal_model->selectall('*', 'employementtypes');
                $grid = new EditableGrid ();
                $grid->addColumn('id', 'ID', 'string', NULL, false, NULL);
                $grid->addColumn('employementtype', 'EMPLOYEMENT', 'string');
                $grid->addColumn('description', 'DESCRIPTION', 'string');
                $grid->addColumn('action', 'DELETE', 'html', NULL, false, 'id');
                $grid->renderJSON($loadregion, false, false, !isset($_GET ['data_only']));
                break;
            case 'employementstatus':
                $loadregion = $this->universal_model->selectall('*', 'employementstatus');
                $grid = new EditableGrid ();
                $grid->addColumn('id', 'ID', 'string', NULL, false, NULL);
                $grid->addColumn('status', 'STATUS', 'string');
                $grid->addColumn('description', 'DESCRIPTION', 'string');
                $grid->addColumn('action', 'DELETE', 'html', NULL, false, 'id');
                $grid->renderJSON($loadregion, false, false, !isset($_GET ['data_only']));
                break;
            case 'jobgrades':
                $loadregion = $this->universal_model->selectall('*', 'jobgrades');
                $grid = new EditableGrid ();
                $grid->addColumn('id', 'ID', 'string', NULL, false, NULL);
                $grid->addColumn('jobgrade', 'JOB GRADE', 'string');
                $grid->addColumn('description', 'DESCRIPTION', 'string');
                $grid->addColumn('minsalary', 'MIN SALARY', 'integer');
                $grid->addColumn('maxsalary', 'MAX SALARY', 'integer');
                $grid->addColumn('action', 'DELETE', 'html', NULL, false, 'id');
                $grid->renderJSON($loadregion, false, false, !isset($_GET ['data_only']));
                break;
            case 'jobgroups':
                $loadregion = $this->universal_model->selectall('*', 'jobgroups');
                $grid = new EditableGrid ();
                $grid->addColumn('id', 'ID', 'string', NULL, false, NULL);
                $grid->addColumn('jobgroup', 'JOB GROUP', 'string');
                $grid->addColumn('description', 'DESCRIPTION', 'string');
                $grid->addColumn('action', 'DELETE', 'html', NULL, false, 'id');
                $grid->renderJSON($loadregion, false, false, !isset($_GET ['data_only']));
                break;
            case 'jobtitles':
                $loadregion = $this->universal_model->selectall('*', 'jobtitles');
                $grid = new EditableGrid ();
                $grid->addColumn('id', 'ID', 'string', NULL, false, NULL);
                $grid->addColumn('jobtitle', 'TITLE', 'string');
                $grid->addColumn('minsalary', 'MIN SALARY', 'integer');
                $grid->addColumn('maxsalary', 'MAX SALARY', 'integer');
                $grid->addColumn('description', 'DESCRIPTION', 'string');
                $grid->addColumn('action', 'DELETE', 'html', NULL, false, 'id');
                $grid->renderJSON($loadregion, false, false, !isset($_GET ['data_only']));
                break;
            case 'salutations':
                $loadregion = $this->universal_model->selectall('*', 'salutations');
                $grid = new EditableGrid ();
                $grid->addColumn('id', 'ID', 'string', NULL, false, NULL);
                $grid->addColumn('salutation', 'SALUTATION', 'string');
                $grid->addColumn('description', 'DESCRIPTION', 'string');
                $grid->addColumn('action', 'DELETE', 'html', NULL, false, 'id');
                $grid->renderJSON($loadregion, false, false, !isset($_GET ['data_only']));
                break;
            case 'nationalities':
                $loadregion = $this->universal_model->selectall('*', 'nationalities');
                $grid = new EditableGrid ();
                $grid->addColumn('id', 'ID', 'string', NULL, false, NULL);
                $grid->addColumn('nationality', 'NATIONALITY', 'string');
                $grid->addColumn('description', 'DESCRIPTION', 'string');
                $grid->addColumn('action', 'DELETE', 'html', NULL, false, 'id');
                $grid->renderJSON($loadregion, false, false, !isset($_GET ['data_only']));
                break;
            case 'maritalstatus':
                $loadregion = $this->universal_model->selectall('*', 'maritalstatus');
                $grid = new EditableGrid ();
                $grid->addColumn('id', 'ID', 'string', NULL, false, NULL);
                $grid->addColumn('status', 'STATUS', 'string', false);
                $grid->addColumn('description', 'DESCRIPTION', 'string', false);
                $grid->addColumn('action', 'DELETE', 'html', NULL, false, 'id');
                $grid->renderJSON($loadregion, false, false, !isset($_GET ['data_only']));
                break;
            case 'designations':
                $loadregion = $this->universal_model->selectall('*', 'designations');
                $grid = new EditableGrid ();
                $grid->addColumn('id', 'ID', 'string', NULL, false, NULL);
                $grid->addColumn('designation', 'DESIGNATION', 'string', false);
                $grid->addColumn('description', 'DESCRIPTION', 'string', false);
                $grid->addColumn('action', 'DELETE', 'html', NULL, false, 'id');
                $grid->renderJSON($loadregion, false, false, !isset($_GET ['data_only']));
                break;
            case 'terminationtypes':
                $loadregion = $this->universal_model->selectall('*', 'terminationtypes');
                $grid = new EditableGrid ();
                $grid->addColumn('id', 'ID', 'string', NULL, false, NULL);
                $grid->addColumn('terminationtype', 'TYPE', 'string');
                $grid->addColumn('description', 'DESCRIPTION', 'string');
//                $grid->addColumn('action', 'DELETE', 'html', NULL, false, 'id');
                $grid->renderJSON($loadregion, false, false, !isset($_GET ['data_only']));
                break;
            case 'indisplinecategs':
                $loadregion = $this->universal_model->selectall('*', 'indisplinecategs');
                $grid = new EditableGrid ();
                $grid->addColumn('id', 'ID', 'string', NULL, false, NULL);
                $grid->addColumn('indisplinecateg', 'INDISPLINE CATEGORY', 'string');
                $grid->addColumn('description', 'DESCRIPTION', 'string');
//                $grid->addColumn('action', 'DELETE', 'html', NULL, false, 'id');
                $grid->renderJSON($loadregion, false, false, !isset($_GET ['data_only']));
                break;
            case 'indisplineactions':
                $loadregion = $this->universal_model->selectall('*', 'indisplineactions');
                $grid = new EditableGrid ();
                $grid->addColumn('id', 'ID', 'string', NULL, false, NULL);
                $grid->addColumn('indisplineaction', 'INDISPLINE ACTION', 'string');
                $grid->addColumn('description', 'DESCRIPTION', 'string');
//                $grid->addColumn('action', 'DELETE', 'html', NULL, false, 'id');
                $grid->renderJSON($loadregion, false, false, !isset($_GET ['data_only']));
                break;
            case 'banks':
                $loadregion = $this->universal_model->selectall('*', 'banks');
                $grid = new EditableGrid ();
                $grid->addColumn('id', 'ID', 'string', NULL, false, NULL);
                $grid->addColumn('bank', 'BANK', 'string', NULL, false);
                $grid->addColumn('code', 'CODE', 'string', NULL, false);
                $grid->addColumn('description', 'DESCRIPTION', 'string', NULL, false);
                $grid->addColumn('action', 'DELETE', 'html', NULL, false, 'id');
                $grid->renderJSON($loadregion, false, false, !isset($_GET ['data_only']));
                break;
            case 'bankbranches':
                $whatineed = array(
                    'b.id as id',
                    'b.bankbranch as branch',
                    'b.code',
                    'bb.bank',
                    'b.description'
                );
                $loadregion = $this->universal_model->join_getbankbranches($whatineed);
                $grid = new EditableGrid ();
                $grid->addColumn('id', 'ID', 'string', NULL, false, NULL);
                $grid->addColumn('branch', 'BRANCH', 'string', NULL, false);
                $grid->addColumn('code', 'CODE', 'string', NULL, false);
                $grid->addColumn('bank', 'BANK', 'string', NULL, false);
                $grid->addColumn('description', 'DESCRIPTION', 'string', NULL, false);
//                $grid->addColumn('action', 'DELETE', 'html', NULL, false, 'id');
                $grid->renderJSON($loadregion, false, false, !isset($_GET ['data_only']));
                break;
            case 'paymentcategories':
                $loadregion = $this->universal_model->selectall('*', 'paymentcategories');
                $grid = new EditableGrid ();
                $grid->addColumn('id', 'ID', 'string', NULL, false, NULL);
                $grid->addColumn('paymentcategory', 'PAYMENT CATEGORY', 'string', NULL, false);
                $grid->addColumn('description', 'DESCRIPTION', 'string', NULL, false);
                $grid->addColumn('action', 'DELETE', 'html', NULL, false, 'id');
                $grid->renderJSON($loadregion, false, false, !isset($_GET ['data_only']));
                break;
            case 'paymentmodes':
                $loadregion = $this->universal_model->selectall('*', 'paymentmodes');
                $grid = new EditableGrid ();
                $grid->addColumn('id', 'ID', 'string', NULL, false, NULL);
                $grid->addColumn('paymentmode', 'PAYMENT MODE', 'string', NULL, false);
                $grid->addColumn('description', 'DESCRIPTION', 'string', NULL, false);
                $grid->addColumn('action', 'DELETE', 'html', NULL, false, 'id');
                $grid->renderJSON($loadregion, false, false, !isset($_GET ['data_only']));
                break;
            case 'paymentfrequency':
                $loadregion = $this->universal_model->selectall('*', 'paymentfrequency');
                $grid = new EditableGrid ();
                $grid->addColumn('id', 'ID', 'string', NULL, false, NULL);
                $grid->addColumn('frequency', 'PAY FREQUENCY', 'string', NULL, false);
                $grid->addColumn('description', 'DESCRIPTION', 'string', NULL, false);
                $grid->addColumn('action', 'DELETE', 'html', NULL, false, 'id');
                $grid->renderJSON($loadregion, false, false, !isset($_GET ['data_only']));
                break;
            case 'currencies':
                $loadregion = $this->universal_model->selectall('*', 'currencies');
                $grid = new EditableGrid ();
                $grid->addColumn('id', 'ID', 'string', NULL, false, NULL);
                $grid->addColumn('currency', 'CURRENCY', 'string', NULL, false);
                $grid->addColumn('exchangerate', 'EXCHANGE RATE', 'string', NULL, false);
                $grid->addColumn('description', 'DESCRIPTION', 'string', NULL, false);
                $grid->addColumn('action', 'DELETE', 'html', NULL, false, 'id');
                $grid->renderJSON($loadregion, false, false, !isset($_GET ['data_only']));
                break;
            case 'nhif':
                $loadregion = $this->universal_model->selectall('*', 'nhif');
                $grid = new EditableGrid ();
                $grid->addColumn('id', 'ID', 'string', NULL, false, NULL);
                $grid->addColumn('fromnumber', 'FROM', 'string', NULL, false);
                $grid->addColumn('tonumber', 'TO', 'string', NULL, false);
                $grid->addColumn('rate', 'RATE', 'string', NULL, false);
                $grid->addColumn('amount', 'AMOUNT', 'string', NULL, false);
                $grid->addColumn('action', 'DELETE', 'html', NULL, false, 'id');
                $grid->renderJSON($loadregion, false, false, !isset($_GET ['data_only']));
                break;
            case 'paye':
                $loadregion = $this->universal_model->selectall('*', 'paye');
                $grid = new EditableGrid ();
                $grid->addColumn('id', 'ID', 'string', NULL, false, NULL);
                $grid->addColumn('fromnumber', 'FROM', 'string', NULL, false);
                $grid->addColumn('tonumber', 'TO', 'string', NULL, false);
                $grid->addColumn('rate', 'RATE', 'string', NULL, false);
                $grid->addColumn('amount', 'VALUE', 'string', NULL, false);
                $grid->addColumn('action', 'DELETE', 'html', NULL, false, 'id');
                $grid->renderJSON($loadregion, false, false, !isset($_GET ['data_only']));
                break;
            case 'allowances':
                $loadregion = $this->universal_model->selectall('*', 'allowances');
                $grid = new EditableGrid ();
                $grid->addColumn('id', 'ID', 'string', NULL, false, NULL);
                $grid->addColumn('allowance', 'ALLOWANCE', 'string', NULL, false);
                $grid->addColumn('recurring', 'RECURRING', 'boolean');
                $grid->addColumn('taxable', 'TAXABLE', 'boolean');
                $grid->addColumn('code', 'CODE', 'string', NULL, false);
                $grid->addColumn('action', 'DELETE', 'html', NULL, false, 'id');
                $grid->renderJSON($loadregion, false, false, !isset($_GET ['data_only']));
                break;
            case 'commissions':
                $loadregion = $this->universal_model->selectall('*', 'commissions');
                $grid = new EditableGrid ();
                $grid->addColumn('id', 'ID', 'string', NULL, false, NULL);
                $grid->addColumn('commission', 'COMISSION', 'string', NULL, false);
                $grid->addColumn('recurring', 'RECURRING', 'boolean');
                $grid->addColumn('taxable', 'TAXABLE', 'boolean');
                $grid->addColumn('code', 'CODE', 'string', NULL, false);
                $grid->addColumn('action', 'DELETE', 'html', NULL, false, 'id');
                $grid->renderJSON($loadregion, false, false, !isset($_GET ['data_only']));
                break;
            case 'saccos':
                $loadregion = $this->universal_model->selectall('*', 'saccos');
                $grid = new EditableGrid ();
                $grid->addColumn('id', 'ID', 'string', NULL, false, NULL);
                $grid->addColumn('sacco', 'SACCO', 'string', NULL, false);
                $grid->addColumn('recurring', 'RECURRING', 'boolean');
                $grid->addColumn('code', 'CODE', 'string', NULL, false);
                $grid->addColumn('action', 'DELETE', 'html', NULL, false, 'id');
                $grid->renderJSON($loadregion, false, false, !isset($_GET ['data_only']));
                break;
            case 'pensions':
                $loadregion = $this->universal_model->selectall('*', 'saccos');
                $grid = new EditableGrid ();
                $grid->addColumn('id', 'ID', 'string', NULL, false, NULL);
                $grid->addColumn('pension', 'PENSION', 'string', NULL, false);
                $grid->addColumn('code', 'CODE', 'string', NULL, false);
                $grid->addColumn('rate', 'RATE', 'boolean');
                $grid->addColumn('taxable', 'TAXABLE', 'boolean');
                $grid->addColumn('userate', 'USE RATE', 'boolean');
                $grid->addColumn('recurring', 'RECURRING', 'boolean');
                $grid->addColumn('action', 'DELETE', 'html', NULL, false, 'id');
                $grid->renderJSON($loadregion, false, false, !isset($_GET ['data_only']));
                break;
            case 'employeeprofile':
                //PIGNATION
                $tablename = 'employeeprofile';
                $query = 'SELECT *, date_format(dateadded, "%d/%m/%Y") as dateadded FROM ' . $tablename;
                $queryCount = 'SELECT count(id) as nb FROM ' . $tablename;
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
                    $query .= '  WHERE lastname like "%' . $filter . '%" OR firstname like "%' . $filter . '%"';
                    $queryCount .= '  WHERE lastname like "%' . $filter . '%" OR firstname like "%' . $filter . '%"';
                    $total = $this->db->query($queryCount)->result_array() [0] ['nb'];
                }
                if (isset($_GET ['sort']) && $_GET ['sort'] != "")
                    $query .= " ORDER BY " . $_GET ['sort'] . ($_GET ['asc'] == "0" ? " DESC " : "");
//                $loadregion = $this->universal_model->selectjoinemployeetable($array_selectable);
                $query .= " LIMIT " . $from . ", " . $rowByPage;
                //END PIGNATION
                $grid = new EditableGrid ();
//                $grid->addColumn('id', 'ID', 'string', NULL, false, NULL);
                $grid->addColumn('employee_code', 'EMP NO', 'string', NULL, true);
                $grid->addColumn('userpin', 'EMP PIN', 'string', NULL, false);
                $grid->addColumn('firstname', 'FIRST NAME', 'string', NULL, false);
                $grid->addColumn('lastname', 'LAST NAME ', 'string', NULL, false);
                $grid->addColumn('basicpay', 'BASIC PAY', 'integer', NULL, true);
                $grid->addColumn('dailyrate', 'DAILY RATE', 'float', NULL, true);
                $grid->addColumn('nssfstate', 'NSSF REDU', 'boolean', NULL, true);
                $grid->addColumn('nhifstate', 'NHIF REDU', 'boolean', NULL, true);
                $grid->addColumn('loanstate', 'LOAN REDU', 'boolean', NULL, true);
                $grid->addColumn('advancestate', 'ADV REDU', 'boolean', NULL, true);
                $grid->addColumn('payestate', 'PAYE REDU', 'boolean', NULL, true);
                $grid->addColumn('saccostate', 'SACCO REDU', 'boolean', NULL, true);
                $grid->addColumn('lunchstate', 'LUNCH REDU', 'boolean', NULL, true);
                $grid->addColumn('employmenttype_id', 'EMP TYPE', 'string', $this->employementtype(), true);
                $grid->addColumn('branchname', 'BRANCH', 'string', NULL, false);
                $grid->addColumn('action', 'MANAGE', 'html', NULL, false, 'id');
                $grid->setPaginator(ceil($total / $rowByPage), (int) $total, (int) $totalUnfiltered, null);
                $result = $this->db->query($query)->result_array();
                $grid->renderJSON($result, false, false, !isset($_GET ['data_only']));
                break;
            case 'leaveconfig':
                $loadregion = $this->universal_model->selectall('*', 'leaveconfig');
                $grid = new EditableGrid ();
                $grid->addColumn('id', 'ID', 'string', NULL, false, NULL);
                $grid->addColumn('leavetype', 'LEAVE TYPE', 'string', NULL, false);
                $grid->addColumn('defaultentitlementleave', 'DEFAULT ENT', 'string', NULL, false);
                $grid->addColumn('payrate', 'PAY RATE', 'string', NULL, false);
                $grid->addColumn('narration', 'NARRATION', 'string', NULL, false);
                $grid->addColumn('recurring', 'RECURRING', 'string', NULL, false);
                $grid->addColumn('maximumamount', 'MAX AMOUNT', 'string', NULL, false);
                $grid->addColumn('action', 'MANAGE', 'html', NULL, false, 'id');
                $grid->renderJSON($loadregion, false, false, !isset($_GET ['data_only']));
                break;
            case 'holidayconfig':
                $loadregion = $this->universal_model->selectall('*', 'holidayconfig');
                $grid = new EditableGrid ();
                $grid->addColumn('id', 'ID', 'string', NULL, false, NULL);
                $grid->addColumn('holidayname', 'HOLIDAY NAME ', 'string', NULL, false);
                $grid->addColumn('date', 'DATE', 'string', NULL, false);
                $grid->addColumn('repeatsannually', 'REPEATS ANNUALLY ', 'string', NULL, false);
                $grid->addColumn('payrate', 'PAY RATE', 'string', NULL, false);
                $grid->addColumn('action', 'MANAGE', 'html', NULL, false, 'id');
                $grid->renderJSON($loadregion, false, false, !isset($_GET ['data_only']));
                break;
            case 'loantypes':
                $loadregion = $this->universal_model->selectall('*', 'loantypes');
                $grid = new EditableGrid ();
                $grid->addColumn('id', 'ID', 'string', NULL, false, NULL);
                $grid->addColumn('loantype', 'LOAN TYPE', 'string', NULL, false, NULL);
                $grid->addColumn('interestmethod', 'INTREST METHOD', 'string', NULL, false, NULL);
                $grid->addColumn('description', 'DESCRIPTION', 'string', NULL, false, NULL);
                $grid->addColumn('ainterestrate', 'INTREST METHOD', 'string', NULL, false, NULL);
                $grid->addColumn('action', 'DELETE', 'html', NULL, false, 'id');
                $grid->renderJSON($loadregion, false, false, !isset($_GET ['data_only']));
                break;
            case 'customparams':
                $loadregion = $this->universal_model->selectall('*', 'customparams');
                $grid = new EditableGrid ();
                $grid->addColumn('id', 'ID', 'string', NULL, false, NULL);
                $grid->addColumn('signnote', 'SIGN', 'string', NULL, false, NULL);
                $grid->addColumn('code', 'CODE', 'string', NULL, false, NULL);
                $grid->addColumn('description', 'DESCRIPTION', 'string', NULL, false, NULL);
                $grid->addColumn('rmonthly', 'RECURE MONTHLY', 'boolean', NULL, false, NULL);
                $grid->addColumn('taxable', 'TAXABLE', 'boolean', NULL, false, NULL);
                $grid->addColumn('lbonus', 'L BONUS', 'boolean', NULL, false, NULL);
                $grid->addColumn('arrears', 'ARREARS', 'boolean', NULL, false, NULL);
                $grid->addColumn('action', 'DELETE', 'html', NULL, false, 'id');
                $grid->renderJSON($loadregion, false, false, !isset($_GET ['data_only']));
                break;
            default:
                break;
        }
    }

    public function updatebranchemployeemange() {

        $id = $this->input->post('id');
        $newvalue = $this->input->post('newvalue');
        $colname = $this->input->post('colname');
        $whatineed = array(
            $colname => $newvalue
        );
        $state = true;
        if ($colname == 'id_util_department') {
            $state = false;
            $whatineed = array(
                'department_id' => $newvalue
            );
            $whatineedn = array(
                'id_util_department' => $newvalue
            );
            $this->universal_model->updatez('id', $id, 'users', $whatineed);
            $this->universal_model->updatez('user_id', $id, 'attendence_util_user_shift', $whatineedn);
        } elseif ($colname == 'id_shift_def') {
            $state = false;
            $whatineed = array(
                'attendence_shiftdef_id' => $newvalue
            );
            $whatineedn = array(
                'id_shift_def' => $newvalue
            );
            $this->universal_model->updatez('id', $id, 'users', $whatineed);
            $this->universal_model->updatez('user_id', $id, 'attendence_util_user_shift', $whatineedn);
        } elseif ($colname == 'user_branch_id') {
            $state = false;
            $whatineed_n = array(
                'branch_id' => $newvalue
            );
            $this->universal_model->updatez('id', $id, 'users', $whatineed_n);
            $readertransfer_array = $this->universal_model->selectz(array('readerserial'), 'util_branch_reader', 'id', $newvalue);
            //GET ME THE PINN
            $userpin_array = $this->universal_model->selectz(array('pin'), 'users', 'id', $id);
            //EXTRACT VALUES
            $trans_user_branch = array_shift($readertransfer_array)['readerserial'];
            $userpin = array_shift($userpin_array)['pin'];
            $serialtransupdate = array(
                'serialnumber' => $trans_user_branch
            );
            $this->universal_model->updatez('pin', $userpin, 'trans', $serialtransupdate);
            echo json_encode($whatineed_n);
        } elseif ($state) {
            $this->universal_model->updatez('id', $id, 'users', $whatineed);
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

    public function updatebranchemployeemange_temp() {
        $id = $this->input->post('id');
        $newvalue = $this->input->post('newvalue');
        $colname = $this->input->post('colname');
        $whatineed = array(
            $colname => $newvalue
        );
        if ($colname == 'user_branch_id') {
            $whatineed_n = array(
                'branch_id' => $newvalue
            );
            $this->universal_model->updatez('id', $id, 'users', $whatineed_n);
            $readertransfer_array = $this->universal_model->selectz(array('readerserial'), 'util_branch_reader', 'id', $newvalue);
            //GET ME THE PINN
            $userpin_array = $this->universal_model->selectz(array('pin'), 'users', 'id', $id);
            //EXTRACT VALUES
            $trans_user_branch = array_shift($readertransfer_array)['readerserial'];
            $userpin = array_shift($userpin_array)['pin'];
            $serialtransupdate = array(
                'serialnumber' => $trans_user_branch
            );
            $this->universal_model->updatez('pin', $userpin, 'trans', $serialtransupdate);
            echo json_encode($whatineed_n);
        } else {
            $loadbranch = $this->universal_model->updatez('id', $id, 'users', $whatineed);
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
    }

    public function updatebranch() {
        $id = $this->input->post('id');
        $newvalue = $this->input->post('newvalue');
        $colname = $this->input->post('colname');
        $tablename = $this->input->post('tablename');
        $whatineed = array(
            $colname => $newvalue
        );
//         function updatez($variable, $value, $table_name, $updated_values) {
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

    public function disable() {
        $tablename = $this->input->post('tablename');
        $id = $this->input->post('id');
        $checkem = $this->universal_model->selectz('*', $tablename, 'id', $id);
//        echo json_encode($_POST);
        $slug = 0;
        if ($checkem[0]['slug'] == 0) {
            $slug = 1;
        } else if ($checkem[0]['slug'] == 1) {
            $slug = 0;
        }
        $arrayupdate = array(
            'slug' => $slug
        );
        $loadbranch = $this->universal_model->updatez('id', $id, $tablename, $arrayupdate);
        if ($loadbranch) {
            $arrayrep = array(
                'status' => 0,
                'message' => 'Successfully Updated',
                'tablename' => $tablename
            );
            echo json_encode($arrayrep);
        } else {
            $arrayrep = array(
                'status' => 1,
                'message' => 'Failed Contact Admin'
            );
            echo json_encode($arrayrep);
        }
    }

    public function delete() {
        $tablename = $this->input->post('tablename');
        $id = $this->input->post('id');
        $checkem = $this->universal_model->deletez($tablename, 'id', $id);
//        echo $this->db->last_query();
        $arrayrep = array(
            'status' => 1,
            'message' => 'Success '
        );
        echo json_encode($arrayrep);
    }

//BRANCH END
    public function testnow() {
        $regions = $this->universal_model->selectz('*', 'regions', 'slug', 0);
        $checkem = $this->universal_model->selectz('*', 'branches', 'id', 1);
        print_array($regions);
    }

    public function message() {
        $data ['content_part'] = 'message/v_message';
        $this->load->view('part/inside/index', $data);
    }

    public function employementtype() {
        $arraysele = array(
            'id',
            'employementtype'
        );
        $allclients = $this->universal_model->selectall($arraysele, 'employementtypes');
        $finalarray = array();
        foreach ($allclients as $value) {
            $finalarray [$value ['id']] = $value ['employementtype'];
        }
        return $finalarray;
        // print_array($finalarray);
    }

    public function branch_type_change() {
        $arraysele = array(
            'id',
            'branchname'
        );
        $allclients = $this->universal_model->selectall($arraysele, 'util_branch_reader');
        $finalarray = array();
        foreach ($allclients as $value) {
            $finalarray [$value ['id']] = $value ['branchname'];
        }
        return $finalarray;
        // print_array($finalarray);
    }

    public function shiftallocate() {
        $arraysele = array(
            'shiftmancode',
            'shiftype'
        );
        $allclients = $this->universal_model->selectall($arraysele, 'attendence_shiftdef');
        $finalarray = array();
        foreach ($allclients as $value) {
            $finalarray [$value ['shiftmancode']] = $value ['shiftype'];
        }
        return $finalarray;
        // print_array($finalarray);
    }

    public function loademployeesbybranch($branchid) {
//        $loadregion = $this->universal_model->selectz('*', 'employeeprofile', 'branchname', $readerid);
        $query = 'SELECT *, date_format(dateadded, "%d/%m/%Y") as dateadded,CONCAT(firstname," ",lastname) as names FROM  employeeprofile WHERE branch_id = "' . $branchid . '"';
        $queryCount = 'SELECT count(id) as nb FROM  employeeprofile WHERE branch_id = "' . $branchid . '" ';
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
            $query .= '  AND lastname like "%' . $filter . '%" OR firstname like "%' . $filter . '%" OR userpin like "%' . $filter . '%" OR employee_code like "%' . $filter . '%" ';
            $queryCount .= '  AND lastname like "%' . $filter . '%" OR firstname like "%' . $filter . '%" OR userpin like "%' . $filter . '%" OR employee_code like "%' . $filter . '%" ';
            $total = $this->db->query($queryCount)->result_array() [0] ['nb'];
        }
        if (isset($_GET ['sort']) && $_GET ['sort'] != "")
            $query .= " AND ORDER BY " . $_GET ['sort'] . ($_GET ['asc'] == "0" ? " DESC " : "");
//                $loadregion = $this->universal_model->selectjoinemployeetable($array_selectable);
        $query .= " LIMIT " . $from . ", " . $rowByPage;
        //END PIGNATION
        $grid = new EditableGrid ();
        $grid->addColumn('employee_code', 'PAYROLL NO', 'string', NULL, true);
        $grid->addColumn('userpin', 'STAFF ID', 'string', NULL, false);
        $grid->addColumn('names', ' NAMES', 'string', NULL, false);
        $grid->addColumn('exempt_ot', 'EXEMPT OT', 'boolean', NULL, true);
        $grid->addColumn('exempt_lost', 'EXEMPT LOST HOURS', 'boolean', NULL, true);
        $grid->addColumn('exempt_clocking', 'EXEMPT CLOCKING', 'boolean', NULL, true);
        $grid->addColumn('employmenttype_id', 'EMP TYPE', 'string', $this->employementtype(), true);
        $grid->addColumn('user_branch_id', 'BRANCH', 'string', $this->branch_type_change(), true);
//        $grid->addColumn('id_shift_def', 'SHIFT', 'string', $this->shiftallocate(), true);
        $grid->addColumn('action', 'MANAGE', 'html', NULL, false, 'id');
        $grid->addColumn('delete', 'DELETE', 'html', NULL, false, 'id');
        $grid->setPaginator(ceil($total / $rowByPage), (int) $total, (int) $totalUnfiltered, null);
//        $result = $this->db->query($query)->result_array();
        $result = $this->db->query($query)->result_array();
        $grid->renderJSON($result, false, false, !isset($_GET ['data_only']));
    }

    public function loademployeesbybranch_junk($branchid) {
        $query = 'SELECT *, date_format(dateadded, "%d/%m/%Y") as dateadded,CONCAT(firstname," ",lastname) as names FROM  usersjunk WHERE branch_id = "' . $branchid . '"';
        $queryCount = 'SELECT count(id) as nb FROM  usersjunk WHERE branch_id = "' . $branchid . '"';
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
            $query .= '  AND lastname like "%' . $filter . '%" OR firstname like "%' . $filter . '%" OR pin like "%' . $filter . '%" OR employee_code like "%' . $filter . '%"';
            $queryCount .= '  AND lastname like "%' . $filter . '%" OR firstname like "%' . $filter . '%" OR pin like "%' . $filter . '%" OR employee_code like "%' . $filter . '%"';
            $total = $this->db->query($queryCount)->result_array() [0] ['nb'];
        }
        if (isset($_GET ['sort']) && $_GET ['sort'] != "")
            $query .= " AND ORDER BY " . $_GET ['sort'] . ($_GET ['asc'] == "0" ? " DESC " : "");
//                $loadregion = $this->universal_model->selectjoinemployeetable($array_selectable);
        $query .= " LIMIT " . $from . ", " . $rowByPage;
        //END PIGNATION
        $grid = new EditableGrid ();
        $grid->addColumn('employee_code', 'PAYROLL NO', 'string', NULL, false);
        $grid->addColumn('pin', 'STAFF ID', 'string', NULL, false);
        $grid->addColumn('names', 'NAMES', 'string', NULL, false);
//        $grid->addColumn('exempt_lost', 'EXEMPT LOST HOURS', 'boolean', NULL, true);
//        $grid->addColumn('exempt_clocking', 'EXEMPT CLOCKING', 'boolean', NULL, true);
        $grid->addColumn('employmenttype_id', 'EMP TYPE', 'string', $this->employementtype(), false);
        $grid->addColumn('branch_id', 'BRANCH', 'string', $this->branch_type_change(), false);
//        $grid->addColumn('branchname', 'BRANCH', 'string', NULL, false);
        $grid->addColumn('restore', 'RESTORE', 'html', NULL, false, 'id');
        $grid->setPaginator(ceil($total / $rowByPage), (int) $total, (int) $totalUnfiltered, null);
//        $result = $this->db->query($query)->result_array();
        $result = $this->db->query($query)->result_array();
        $grid->renderJSON($result, false, false, !isset($_GET ['data_only']));
    }

//For Eddition

    public function staffdelete() {
        $tablename = $this->input->post('tablename');
        $id = $this->input->post('id');
        $checkem = $this->universal_model->selectz(array('userpin'), $tablename, 'id', $id);
        if (!empty($checkem)) {
            $userpin = array_shift($checkem)['userpin'];
            $userbunch = $this->universal_model->selectz('*', 'users', 'pin', $userpin);
            $this->universal_model->updateOnDuplicate('usersjunk', array_shift($userbunch));
            $this->universal_model->deletez('users', 'pin', $userpin);
        }
        $arrayrep = array(
            'status' => 1,
            'message' => 'Success '
        );
        echo json_encode($arrayrep);
    }

    public function staffrestore() {
        $tablename = $this->input->post('tablename');
        $id = $this->input->post('id');
        $userrestor = $this->universal_model->selectz('*', $tablename, 'id', $id);
        if (!empty($userrestor)) {
            $this->universal_model->updateOnDuplicate('users', array_shift($userrestor));
            $this->universal_model->deletez('usersjunk', 'id', $id);
        }
        $arrayrep = array(
            'status' => 1,
            'message' => 'Success '
        );
        echo json_encode($arrayrep);
    }

}
