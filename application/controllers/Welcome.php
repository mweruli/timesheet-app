<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('universal_model');
        // https://stackoverflow.com/questions/51238919/php-7-2-dom-mbstring-and-simplexml
        // https://techarise.com/codeigniter-import-excel-csv-file-data-into-mysql/
        // https://techarise.com/codeigniter-import-excel-csv-file-data-into-mysql/
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

    public function create_thumbnail($width, $height, $new_image, $image_source)
    {
        $config['image_library'] = 'gd2';
        $config['source_image'] = $image_source;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = $width;
        $config['height'] = $height;
        $config['new_image'] = $new_image;
        $this->load->library('image_lib');
        $this->image_lib->initialize($config);
        $this->image_lib->resize();
    }

    public function getskills()
    {
        $value = $this->universal_model->selectall('*', 'util_setting');
        return $value;
        // print_array($value);
    }

    public function getadmins()
    {
        $value = $this->universal_model->selectzwherenot('*', 'users', 'employee');
        return $value;
    }

    public function superadmins()
    {
        // function selectz($array_table_n, $table_n, $variable_1, $value_1) {
        $value = $this->universal_model->selectz('*', 'users', 'category', 'suadmin');
        return $value;
    }

    public function getdepartments()
    {
        $value = $this->universal_model->selectall('*', 'util_setting');
        return $value;
        // print_array($value);
    }

    public function getallemployees()
    {
        $value = $this->universal_model->selectzy('*', 'users', 'slug', 1, 'category', 'employee');
        // print_array($value);
        return $value;
    }

    public function getallclients()
    {
        $value = $this->universal_model->selectz('*', 'client', 'slug', 1);
        // print_array($value);
        return $value;
    }

    public function user14timesheet()
    {
        $value = $this->universal_model->selectall('*', 'timesheet');
        // print_array($value);
        return $value;
    }

    public function getsupervisernames($id)
    {
        if ($id == 0) {
            $id = $this->session->userdata('logged_in')['addedby'];
        }
        $data_needed = array(
            'emailaddress',
            'firstname',
            'lastname',
            'cellphone'
        );
        $value = $this->universal_model->selectz($data_needed, 'users', 'id', $id);
        // print_array($value);
        return $value;
    }

    public function getsupervisernamesbyiddirect($id)
    {
        $data_needed = array(
            'emailaddress',
            'firstname',
            'lastname',
            'cellphone'
        );
        $value = $this->universal_model->selectz($data_needed, 'users', 'id', $id);
        // echo $value[0]['firstname'] . ' ' . $value[0]['lastname'] . ' @ ' . $value[0]['emailaddress'];
        // print_array($value);
        return $value;
    }

    public function getsupervisernames_sub()
    {
        $id_once = $this->session->userdata('logged_in')['supervisedby'];
        if ($id_once == 0) {
            $id_once = $this->session->userdata('logged_in')['addedby'];
        }
        $data_needed = array(
            'emailaddress',
            'firstname',
            'lastname',
            'cellphone'
        );
        $value = $this->universal_model->selectz($data_needed, 'users', 'id', $id_once);
        // print_array($value);
        return $value;
    }

    public function getclient_bynumber_n($client_id)
    {
        $array_n = array(
            'id as client_id',
            'clientname',
            'client_image_medium'
        );
        $value = $this->universal_model->selectz($array_n, 'client', 'id', $client_id);
        // print_array($value);
        return $value[0];
    }

    public function getclient_bynumber($client_id)
    {
        $array_n = array(
            'clientname',
            'client_image_medium'
        );
        $value = $this->universal_model->selectz($array_n, 'client', 'id', $client_id);
        // print_array($value);
        return $value;
    }

    public function getemployeenamebypin($pin)
    {
        $array_n = array(
            'firstname',
            'lastname',
            'middlename'
        );

        $value = $this->universal_model->selectz($array_n, 'users', 'pin', $pin);
        if (empty($value)) {
            $value[0]['firstname'] = $pin;
            $value[0]['lastname'] = $pin;
            $value[0]['middlename'] = $pin;
        }
        // print_array($value);
        return $value[0];
    }

    public function getclient_bynumberjson($client_id)
    {
        $array_n = array(
            'clientname',
            'client_image_medium'
        );
        $value = $this->universal_model->selectz($array_n, 'client', 'id', $client_id);
        return $value;
    }

    public function getallavaileclients_n()
    {
        $value = $this->universal_model->selectz('id,client_image_medium,clientname,client_image_medium', 'client', 'slug', 1);
        // print_array($value);
        return $value;
    }

    //    public function dashboard($section = 6) {
    //        $category = $this->session->userdata('logged_in');
    //        print_array($category);
    //    }

    public function dashboard($section = 6)
    {
        $category = $this->session->userdata('logged_in')['category'];
        $data['payroll_categroy'] = $this->universal_model->selectall('*', 'payroll_categroy');
        if ($this->session->userdata('logged_in')) {
            switch ($section) {
                case 1:
                    switch ($category) {
                        case 'suadmin':
                            $data['all_people_assignable'] = $this->universal_model->selectzwherenot('*', 'users', '');
                            break;
                        default:
                            $data['all_people_assignable'] = $this->universal_model->selectzwherenot('*', 'users', 'suadmin');
                            break;
                    }
                    if ($category === "employee") {
                        redirect(base_url('welcome/dashboard'));
                    }
                    // Necessary Check
                    $data['utilsetting'] = $this->getutilsetting($this->session->userdata('logged_in')['employmenttype_id']);
                    $data['supervisors'] = $this->getadmins();
                    $data['controller'] = $this;
                    // Above All
                    $all_employess = $this->universal_model->selectzjoin_with_supervisors('*');
                    // $data['all_employees'] = $this->universal_model->selectall('*', 'users');
                    $data['all_employees'] = $all_employess;
                    $data['skill_items'] = $this->getskills();
                    $data['content_part'] = 'part/content/v_employee';
                    $this->load->view('part/inside/index', $data);
                    // print_array($arraymebb);
                    break;
                case 2:
                    if ($category === "employee") {
                        redirect(base_url('welcome/dashboard'));
                    }
                    $data['department_items'] = $this->getdepartments();
                    // Pigination Walah
                    $moreo = $this->getallclients();
                    // Another Pigi End
                    $data['all_clients'] = $moreo;
                    $data['supervisors'] = $this->getadmins();
                    // Next Time
                    $data['content_part'] = 'part/content/v_client';
                    $this->load->view('part/inside/index', $data);
                    break;
                case 5:
                    // TRUMP
                    $data['controller'] = $this;
                    $data['all_clients'] = $this->getallclients();
                    $data['task'] = $this->universal_model->selectall('*', 'task');
                    $data['user_id'] = $this->session->userdata('logged_in')['user_id'];
                    $data['content_part'] = 'part/content/v_timesheetmine';
                    $this->load->view('part/inside/index', $data);
                    break;
                case 6:
                    $data['controller'] = $this;
                    $data['supervisors'] = $this->getadmins();
                    $data['skill_items'] = $this->getskills();
                    $data['category'] = $category;
                    $supervisor_array_sub = $this->getsupervisernames_sub();
                    $supervisor_array = $this->getsupervisernames($this->session->userdata('logged_in')['addedby']);
                    if (empty($supervisor_array)) {
                        $supervisor_array[0]['firstname'] = "";
                        $supervisor_array[0]['lastname'] = "";
                    }
                    if (empty($supervisor_array_sub)) {
                        $supervisor_array_sub[0]['firstname'] = "";
                        $supervisor_array_sub[0]['lastname'] = "";
                    }
                    $data['supervisor_array_sub'] = $supervisor_array_sub[0];
                    $data['supervisor_array'] = $supervisor_array[0];
                    $user_id = $this->session->userdata('logged_in')['user_id'];
                    $userwho = $this->session->userdata('logged_in')['emailaddress'];
                    if ($userwho == "rajan@shahandassociates.co.ke") {
                        $data['array_employeesection'] = $this->universal_model->selectz('*', 'users', 'category', 'admin');
                    } else {
                        $data['array_employeesection'] = $this->getallemployee('employee');
                    }
                    $data['utilsetting'] = $this->getutilsetting($this->session->userdata('logged_in')['employmenttype_id']);
                    if ($category === "suadmin") {
                        $data['all_users'] = $this->universal_model->selectall('*', 'users');
                        $data['content_part'] = 'part/content/emp/user_profile_emp';
                    } else {
                        $data['content_part'] = 'part/content/emp/user_profile_emp_1';
                    }
                    $this->load->view('part/inside/index', $data);
                    break;
                case 7:
                    if ($category === "employee") {
                        redirect(base_url('welcome/dashboard'));
                    }
                    $supervisor_array = $this->getsupervisernames($this->session->userdata('logged_in')['addedby']);
                    if (empty($supervisor_array)) {
                        $supervisor_array[0]['firstname'] = "";
                        $supervisor_array[0]['lastname'] = "";
                    }
                    $data['supervisors'] = $this->superadmins();
                    $data['supervisor_array'] = $supervisor_array[0];
                    $data['all_admins'] = $this->universal_model->selectz('*', 'users', 'category', 'admin');
                    $data['data_tables'] = $this->universal_model->selectall('*', 'util_setting');
                    // End
                    // Start New State Employee
                    // New State Employee
                    $data['skill_items'] = $this->getskills();
                    $data['controller'] = $this;
                    $data['category'] = $category;
                    $data['content_part'] = 'part/include/admin_workspace';
                    $this->load->view('part/inside/index', $data);
                    break;
                case 8:
                    if ($category === "employee") {
                        redirect(base_url('welcome/dashboard'));
                    }
                    $data['controller'] = $this;
                    $allclients = $this->getallclients();
                    $timesheet = $this->user14timesheet();
                    // Another Pigi End
                    $data['all_clients'] = $allclients;
                    $data['timesheet'] = $timesheet;
                    $data['all_users'] = $this->universal_model->selectall('*', 'users');
                    $data['content_part'] = 'part/content/v_reportclient';
                    $data['task'] = $this->universal_model->selectall('*', 'task');
                    $client_select = array(
                        'id',
                        'clientname',
                        'client_number'
                    );
                    // $data ['indexdata'] = $this->load->view('index', '', TRUE);
                    $this->load->view('part/inside/index', $data);
                    break;
                case 10:
                    if ($category === "employee") {
                        redirect(base_url('welcome/dashboard'));
                    }
                    $data['alldepartments'] = $this->universal_model->selectall('*', 'attendence_util_department');
                    $data['shift_def'] = $this->universal_model->selectall('*', 'attendence_shiftdef');
                    $data['content_part'] = 'attend/walah';
                    $this->load->view('part/inside/index', $data);
                    break;
                case 11:
                
                    if ($category === "employee") {
                        redirect(base_url('welcome/dashboard'));
                    }
                    $data['controller'] = $this;
                    $data['allbranches'] = $this->universal_model->util_branch_reader();
                    $data['content_part'] = 'attend/v_timeattendence';
                    $this->load->view('part/inside/index', $data);
                    break;
                case 13:
                    if ($category === "employee") {
                        redirect(base_url('welcome/dashboard'));
                    }
                    $data['controller'] = $this;
                    $data['allbranches'] = $this->universal_model->util_branch_reader();
                    $data['content_part'] = 'attend/v_timeattendencedaily';
                    $this->load->view('part/inside/index', $data);
                    break;
                case 12:
                    if ($category === "employee") {
                        redirect(base_url('welcome/dashboard'));
                    }
                    $data['allowancecats'] = $this->universal_model->selectz('*', 'allowances', 'slug', 0);
                    $data['leavesall'] = $this->universal_model->selectall('*', 'att_timeatttimeoffs');
                    $data['allbranches'] = $this->universal_model->util_branch_reader();
                    $data['controller'] = $this;
                    $data['content_part'] = 'attend/v_timeattendence_1';
                    $this->load->view('part/inside/index', $data);
                    break;
                case 14:
                    if ($category === "employee") {
                        redirect(base_url('welcome/dashboard'));
                    }
                    $data['siftdef'] = $this->universal_model->selectall('*', 'attendence_shiftdef');
                    // $data['branch_serial'] = $this->universal_model->selectall('*', 'util_branch_reader');
                    $data['allbranches'] = $this->universal_model->util_branch_reader();
                    $data['leavesall'] = $this->universal_model->selectz('*', 'att_timeatttimeoffs', 'id', 4);
                    $data['content_part'] = 'attend/v_siftpanel';
                    $this->load->view('part/inside/index', $data);
                    break;
                default:
                    redirect(base_url('welcome/dashboard'));
                    break;
            }
        } else {
            redirect(base_url('authentication'));
        }
    }

    public function addsetting()
    {
        $designation = $this->input->post('design');
        $rate_amount = $this->input->post('rateamount');
        $table_value = array(
            'design' => $designation,
            'rateamount' => $rate_amount,
            'addedby' => $this->session->userdata('logged_in')['id']
        );
        $this->form_validation->set_rules('design', 'Designations', 'required|is_unique[util_setting.design]');
        if ($this->form_validation->run() == FALSE) {
            $issue_one = form_error("design");
            $variabone = strip_tags($issue_one, "<b><i>");
            if ($variabone !== "") {
                $json_return = array(
                    'report' => $variabone,
                    'status' => 1
                );
                echo json_encode($json_return);
            }
        } else {
            $json_return = array(
                'report' => "New Designation Added Successfully",
                'status' => 2
            );
            $this->universal_model->insertz('util_setting', $table_value);
            echo json_encode($json_return);
        }
    }

    public function deletetabledatas()
    {
        $id = $this->input->post('valueid');
        $this->universal_model->deletez('util_setting', 'id', $id);
    }

    public function edittabledata($id)
    {
        $status = $this->universal_model->selectz('*', 'util_setting', 'id', $id);
        echo json_encode($status[0]);
        // print_array($status[0]);
    }

    public function commitedit()
    {
        // $amama = $this->input->post();
        $variable_value = $this->input->post('id');
        $updated_values = array(
            'design' => $this->input->post('design'),
            'rateamount' => $this->input->post('rateamount')
        );
        $this->universal_model->updatez('id', $variable_value, 'util_setting', $updated_values);
        $status = $this->universal_model->selectz('*', 'util_setting', 'id', $variable_value);
        echo json_encode($status[0]);
        // echo json_encode($amama);
    }

    public function getmeusercreds($user_id)
    {
        $return_value = $this->universal_model->selectz('*', 'users', 'user_id', $user_id);
        return $return_value[0];
    }

    public function getallemployesbytype($param)
    {
        $return_value = $this->universal_model->selectz('*', 'users', 'category', $param);
        foreach ($return_value as $key => $value) {
            unset_post($return_value[$key], 'password');
        }
        echo json_encode($return_value);
        // print_array($return_value);
    }

    public function getallemployesbytype_better($param)
    {
        $return_value = $this->universal_model->selectz('*', 'users', 'category', $param);
        foreach ($return_value as $key => $value) {
            unset_post($return_value[$key], 'password');
        }
        return $return_value;
        // print_array($return_value);
    }

    // Neccessary Redundance PLEASE NOTE
    public function getutilsetting($id)
    {
        $vara = $this->universal_model->selectz('*', 'util_setting', 'id', $id);
        if (empty($vara)) {
            $resultarray[0] = array(
                'id' => 0,
                'design' => 'UPDATE OCCUPATION',
                'rateamount' => 10,
                'addedby' => 0
            );
            return $resultarray;
            // echo json_encode($resultarray);
        } else {
            return $vara;
        }
    }

    public function getallemployee($typeuser)
    {
        $value = $this->universal_model->selectz('*', 'users', 'category', $typeuser);
        // print_array($value);
        return $value;
    }

    function get_employeepricecloned($id)
    {
        $array_what = array(
            'rateamount'
        );
        $vara = $this->universal_model->joinemplyeeemploymenttype_id($id, $array_what);
        return $vara[0]['rateamount'];
    }

    public function test()
    {
        $vara = $this->universal_model->util_branch_reader();
        print_array($vara);
    }

    public function getmealltables()
    {
        $tables = $this->db->list_tables();
        foreach (array_keys($tables, 'util_auth_email', true) as $key) {
            unset($tables[$key]);
        }
        foreach (array_keys($tables, 'util_clienttask', true) as $key) {
            unset($tables[$key]);
        }
        foreach (array_keys($tables, 'util_monitor', true) as $key) {
            unset($tables[$key]);
        }
        foreach (array_keys($tables, 'util_setting', true) as $key) {
            unset($tables[$key]);
        }
        foreach (array_keys($tables, 'tablesettings', true) as $key) {
            unset($tables[$key]);
        }
        return $tables;
    }

    function selectafromonewhere($table_n, $variable_1, $value_1)
    {
        //        function selectz($array_table_n, $table_n, $variable_1, $value_1) {
        $resultem = $this->universal_model->selectz('*', $table_n, $variable_1, $value_1);
        return $resultem;
    }

    public function allselectablebytable($tablename)
    {
        $returnall = $this->universal_model->selectz('*', $tablename, 'slug', 0);
        return $returnall;
    }

    public function joku()
    {
        //        (int)
        //        $num = (float) ('7.75');
        //        $en = convertfromdectime($num);
        //        print_array($en);
        $date_day = converttodate('01-01', 'd-m');

        $returnall = $this->universal_model->selectall_var('*', 'holidayconfig', 'date like "%' . $date_day . '%"');
        if (!empty($returnall)) {
            print_array(limit_words($returnall[0]['holidayname'], 35));
        }
    }

    public function testreports()
    {
        $data['content_part'] = 'attend/reports/timeatt_details';
        $this->load->view('part/inside/index', $data);
    }
}
