<?php

class Employee extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('universal_model');
        $this->load->model('user_model', '', TRUE);
        // $this->load->library('image_magician');
    }

    public function index() {
        echo '<h1>Api ..</h1>';
    }

    public function jez() {
        $hdhd = $this->getoccupation(1);
        echo $hdhd;
    }

    function getallemployees() {
        $vara = $this->universal_model->selectz('*', 'users', 'category', 'employee');
        print_array($vara);
    }

    function closetak($project_id, $task) {
        $arrayclosed = array(
            'closed'
        );
        $vara = $this->universal_model->selectzy($arrayclosed, 'project_milestone', 'project_id', $project_id, 'task', $task);
        $this->isproject_closed($project_id);
        echo $vara [0] ['closed'];
    }

    function isproject_closed($id) {
        $vara = $this->universal_model->non_selectzy('*', 'project_milestone', 'project_id', $id, 'closed', 0);
        if (empty($vara)) {
            $update_array = array(
                'status' => 1
            );
            $this->universal_model->updatez('id', $id, 'project', $update_array);
        }
        // print_array($vara);
    }

    function addemployeeisstatex() {
        $employee_id = $this->input->post('employee_select');
        $startdate = $this->input->post('state_startdate');
        $enddate = $this->input->post('state_enddate');
        $employee_statusdata = $this->input->post('employee_status');
        $comment_made = $this->input->post('comment_state_task');
        $time_award = $this->input->post('time_award');
        // Chapter Two
        $dataempl = explode('@', $employee_statusdata);
        $employee_statusid = $dataempl [0];
        $project_name = $dataempl [1];
        $task_workedone = strtolower($dataempl [1]);
        // Chapter Two 1
        $date1 = date_create($startdate);
        $date2 = date_create($enddate);
        $diff = date_diff($date1, $date2);
        $datadiff = $diff->format("%R%a days");
        $stata = array(
            'one' => $employee_id,
            'two' => $startdate,
            'three' => $enddate,
            'four' => $comment_made,
            'five' => $time_award,
            'six' => $employee_statusid,
            'seven' => $project_name,
            'eight' => $task_workedone,
            'nine' => $date1,
            'ten' => $date2,
            'eleven' => $diff,
            'twelve' => $datadiff
        );
        if ($datadiff < 0) {
            $issue_one = 'Start Date Should Be Less than End Date';
            $json_return = array(
                'report' => $issue_one,
                'status' => 1
            );
            echo json_encode($json_return);
        } else {
            echo json_encode($stata);
        }
    }

    function addemployeeisstate() {
        echo 'Function To Do';
    }

    // function addemployeeisstate() {
    // $employee_id = $this->input->post('employee_select');
    // $startdate = $this->input->post('state_startdate');
    // $enddate = $this->input->post('state_enddate');
    // $employee_statusdata = $this->input->post('employee_status');
    // $comment_made = $this->input->post('comment_state_task');
    // $time_award = $this->input->post('time_award');
    // $dataempl = explode('@', $employee_statusdata);
    // $employee_statusid = $dataempl[0];
    // $project_name = $dataempl[1];
    // $task_workedone = strtolower($dataempl[1]);
    // $date1 = date_create($startdate);
    // $date2 = date_create($enddate);
    // $diff = date_diff($date1, $date2);
    // $datadiff = $diff->format("%R%a days");
    // //Step Two
    // // $time = strtotime("+1 year", time());
    // // $nt = date("Y-m-d", $time);
    // // echo $date;
    // if ($datadiff < 0) {
    // $issue_one = 'Start Date Should Be Less than End Date';
    // $json_return = array(
    // 'report' => $issue_one,
    // 'status' => 1
    // );
    // echo json_encode($json_return);
    // } else {
    // $dateregone = $this->universal_model->reportselectzorjoin($employee_id, $employee_statusid, $startdate, $enddate);
    // $datereg = $this->universal_model->selectzx('*', 'util_project_updatem', 'startdate', $startdate, 'enddate', $enddate, 'id_otherstate', $employee_statusid);
    // if (!empty($dateregone)) {
    // $issue_one = 'Same State Has Already Been Booked By Same User';
    // $json_return = array(
    // 'report' => $issue_one,
    // 'status' => 1
    // );
    // echo json_encode($json_return);
    // } else if (empty($datereg)) {
    // $my_dates = getDatesFromRange($startdate, $enddate);
    // $daatama = array(
    // 'startdate' => $startdate,
    // 'enddate' => $enddate,
    // 'user_id' => $employee_id,
    // 'id_otherstate' => $employee_statusid,
    // 'project_name' => $project_name,
    // 'task_workedone' => $task_workedone,
    // 'comment_update_task' => $comment_made
    // );
    // $id_ref = $this->universal_model->insertz('util_project_updatem', $daatama);
    // foreach ($my_dates as $datenow) {
    // $dataarray = array(
    // 'util_project_updatem_id' => $id_ref,
    // 'date_done_task' => $datenow,
    // 'time_taken' => $time_award,
    // 'ip_address' => $this->input->ip_address()
    // );
    // $vara = $this->universal_model->insertz('project_updatem', $dataarray);
    // }
    // $issue_one = 'User State Successfully Updated';
    // $json_return = array(
    // 'report' => $issue_one,
    // 'status' => 0
    // );
    // echo json_encode($json_return);
    // } else {
    // $issue_one = 'User Is Already Having This State';
    // $json_return = array(
    // 'report' => $issue_one,
    // 'status' => 1
    // );
    // echo json_encode($json_return);
    // }
    // }
    // }
    function addemployee() {
        $this->form_validation->set_rules('email_employee', 'Employee Email', 'trim|required|is_unique[users.user_email]');
        $this->form_validation->set_rules('contact_employee', 'Employee Contact ', 'required|is_unique[users.contact]');
        if ($this->form_validation->run() == FALSE) {
            $issue_one = form_error("email_employee");
            $issue_two = form_error("contact_employee");
            $variabone = strip_tags($issue_one, "<b><i>");
            $variabtwo = strip_tags($issue_two, "<b><i>");
            if ($variabone !== "") {
                $json_return = array(
                    'report' => $variabone,
                    'status' => 1
                );
                echo json_encode($json_return);
            } else if ($variabtwo !== "") {
                $json_return = array(
                    'report' => $variabtwo,
                    'status' => 1
                );
                echo json_encode($json_return);
            }
        } else {
            $json_return = array(
                'report' => "New Employee Added Successfully",
                'status' => 2
            );
            $this->addemployee_subfunc();
            echo json_encode($json_return);
        }
    }

    public function create_thumbnail($width, $height, $new_image, $image_source) {
        $config ['image_library'] = 'gd2';
        $config ['source_image'] = $image_source;
        $config ['maintain_ratio'] = TRUE;
        $config ['width'] = $width;
        $config ['height'] = $height;
        $config ['new_image'] = $new_image;
        $this->load->library('image_lib');
        $this->image_lib->initialize($config);
        $this->image_lib->resize();
    }

    public function htmlmail($email_source, $email_desitination, $email_html, $title_email, $sub_title, $data_array) {
        $config = Array(
            'protocol' => 'sendmail',
            'smtp_host' => 'your domain SMTP host',
            'smtp_port' => 25,
            'smtp_user' => 'SMTP Username',
            'smtp_pass' => 'SMTP Password',
            'smtp_timeout' => '4',
            'mailtype' => 'html',
            'charset' => 'iso-8859-1'
        );
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");

        $this->email->from($email_source, $title_email);
        $this->email->to($email_desitination); // replace it with receiver mail id
        $this->email->subject($sub_title); // replace it with relevant subject
        // $this->load->view('part/outer/login', $data, TRUE);
        $body = $this->load->view($email_html, $data_array, TRUE);
        $this->email->message($body);
        $this->email->send();
    }

    function addemployee_subfunc() {
        if ($this->validate_image("userimage" . getToken(3))) {
            $data = array(
                'upload_data' => $this->upload->data()
            );
            $name_file = $data ['upload_data'];
            $_POST ['user_profile_pic'] = $name_file ['file_name'];
            $this->create_thumbnail(50, 50, './upload/' . "50_" . $this->input->post('user_profile_pic'), './upload/' . $this->input->post('user_profile_pic'));
            $this->create_thumbnail(60, 60, './upload/' . "60_" . $this->input->post('user_profile_pic'), './upload/' . $this->input->post('user_profile_pic'));
            $this->create_thumbnail(500, 500, './upload/' . "500_" . $this->input->post('user_profile_pic'), './upload/' . $this->input->post('user_profile_pic'));
            // $this->image_magician->create_thumbnail('./upload/' . $this->input->post('user_profile_pic'), './upload/' . "60_" . $this->input->post('user_profile_pic'), 60, 60);
            // $this->image_magician->create_thumbnail('./upload/' . $this->input->post('user_profile_pic'), './upload/' . "500_" . $this->input->post('user_profile_pic'), 500, 500);
            $_POST ['user_image_small'] = "50_" . $this->input->post('user_profile_pic');
            $_POST ['user_image_medium'] = "60_" . $this->input->post('user_profile_pic');
            $_POST ['user_image_big'] = "500_" . $this->input->post('user_profile_pic');
            // unlink('/upload/' . $this->input->post('user_profile_pic'));
            unlink("upload/" . $name_file ['file_name']);
            // unlink($name_file['file_name']);
        } else {
            $_POST ['user_image_small'] = "50_icon_user_default.png";
            $_POST ['user_image_medium'] = "60_icon_user_default.png";
            $_POST ['user_image_big'] = "500_icon_user_default.png";
        }
        $user_add = array(
            'user_id' => $this->input->post('employee_number'),
            'user_image_small' => $this->input->post('user_image_small'),
            'user_image_medium' => $this->input->post('user_image_medium'),
            'user_image_big' => $this->input->post('user_image_big'),
            'user_email' => $this->input->post('email_employee'),
            'password' => "123456",
            'firstname' => $this->input->post('firstname_client'),
            'lastname' => $this->input->post('lastname_client'),
            'contact' => $this->input->post('contact_employee'),
            'category' => $this->input->post('category'),
            'datehired' => $this->input->post('date_of_employement'),
            'dateofbirth' => $this->input->post('date_of_birthemployee'),
            'occupation' => $this->input->post('occupation_employee'),
            'slug' => 1,
            'addedby' => $this->session->userdata('logged_in') ['id'],
            'dateofbirth' => $this->input->post('date_of_birthemployee'),
            'id_gender' => $this->input->post('optionsRadios')
        );
        $this->universal_model->insertz('users', $user_add);
        $data_array ['names'] = $this->input->post('firstname_client') . " " . $this->input->post('lastname_client');
        $data_array ['user_id'] = $this->input->post('employee_number');
        $data_array ['password'] = '123456';
        $data_array ['email'] = $this->input->post('email_employee');
        $this->htmlmail('dominic@alfabiz.co.ke', $this->input->post('email_employee'), 'part/outer/v_sendcredentials', 'Alfabiz Timesheet', 'Timesheet|Credentials', $data_array);
        // $this->htmlmail('njovujsh@gmail.com', $this->input->post('email_employee'), 'part/outer/v_sendcredentials', 'Alfabiz Timesheet', 'Timesheet|Credentials', $data_array);
        // echo $feed;
        // print_array($_POST);
        // echo json_encode($user_add);
    }

    public function validate_image($generatedname) {
        $config ['overwrite'] = TRUE;
        $config ['upload_path'] = './upload/';
        $config ['allowed_types'] = 'gif|jpg|png';
        $config ['max_size'] = '10000';
        $config ['max_width'] = '2024';
        $config ['max_height'] = '1068';
        $config ['file_name'] = $generatedname;
        $this->load->library('upload');
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('user_profile_pic')) {
            $error = array(
                'error' => $this->upload->display_errors()
            );
            // print_array($error);
            if (strpos($error ['error'], "You did not select a file to upload.") !== FALSE) {
                $this->form_validation->set_message('validate_image', 'Please Select Profile Picture');
                // $this->session->set_flashdata('user_profile_pic_', "Please Select Profile Picture");
                // redirect(base_url() . "admin/admin/admin/2");
            } elseif (strpos($error ['error'], "The uploaded file exceeds the maximum allowed size in your PHP configuration file.") !== FALSE) {
                // $this->session->set_flashdata('user_profile_pic_', "");
                // redirect(base_url() . "admin/admin/admin/2");
                $this->form_validation->set_message('validate_image', 'Profile Picture exceeds the required image size');
            }
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function add_projectx() {
        $user_id = $this->input->post('user_id_data');
        $newuser_tasks_array = $this->input->post('specific_tasks');
        $project_values = $this->input->post('project_name');
        $value_twoarray = explode('|', $project_values);
        $id_project = $value_twoarray [0];
        echo json_encode($_POST);
    }

    function add_project() {
        $user_id = $this->input->post('user_id_data');
        $newuser_tasks_array = $this->input->post('specific_tasks');
        $project_values = $this->input->post('project_name');
        $value_twoarray = explode('|', $project_values);
        $id_project = $value_twoarray [0];
        $data_state = $this->universal_model->selectzy('*', 'employeeproject', 'id_project', $id_project, 'id_employee', $user_id);
        if (empty($data_state)) {
            // If user has never been assigned to this project
            $data_nsert = array(
                'id_project' => $id_project,
                'id_employee' => $user_id,
                'approved' => 1,
                'project_task' => json_encode($newuser_tasks_array)
            );
            $id = $this->universal_model->insertz('employeeproject', $data_nsert);
            foreach ($newuser_tasks_array as $value_now) {
                $data_nserty = array(
                    'taken' => 1
                );
                $this->universal_model->updatem('project_id', $value_twoarray [0], 'task', $value_now, 'project_milestone', $data_nserty);
            }
            $json_return = array(
                'report' => "Project Assigned Successfully",
                'status' => 1
            );
            echo json_encode($json_return);
        } else {
            $array_existingtask = json_decode($data_state [0] ['project_task']);
            if ($newuser_tasks_array == $array_existingtask) {
                $json_return = array(
                    'report' => "Already Assigned To This User",
                    'status' => 0
                );
                echo json_encode($json_return);
            } else {
                $array_unique = array_unique(array_merge($newuser_tasks_array, $array_existingtask));
                $values_data = array_values($array_unique);
                $data_update = array(
                    'project_task' => json_encode($values_data)
                );
                $resultnn = array_values(array_diff($newuser_tasks_array, $array_existingtask));
                if (empty($resultnn)) {
                    $json_return = array(
                        'report' => "Task(s) Already Assigned To This User",
                        'status' => 0
                    );
                    echo json_encode($json_return);
                } else {
                    $id = $this->universal_model->updatem('id_project', $id_project, 'id_employee', $user_id, 'employeeproject', $data_update);
                    if ($id > 0) {
                        foreach ($resultnn as $value_now) {
                            $data_nserty = array(
                                'taken' => 1
                            );
                            $this->universal_model->updatem('project_id', $id_project, 'task', $value_now, 'project_milestone', $data_nserty);
                        }
                        $json_return = array(
                            'report' => "User Added Project Tasks",
                            'status' => 1
                        );
                        echo json_encode($json_return);
                    } else if ($id >= 0) {
                        $json_return = array(
                            'report' => "Failed Adding Assignment Contact Admin",
                            'status' => 0
                        );
                        echo json_encode($id);
                    }
                }
            }
        }
    }

    function add_project_backup() {
        $project_values = $this->input->post('project_name');
        // $project_subtasks = $this->input->post('specific_tasks');
        $value_twoarray = explode('|', $project_values);
        $_POST ['user_id'] = $this->session->userdata('logged_in') ['user_id'];
        $_POST ['id_project'] = $value_twoarray [0];
        $data_nsert = array(
            'id_project' => $this->input->post('id_project'),
            'id_employee' => $this->input->post('user_id'),
            'approved' => 1,
            'project_task' => json_encode($this->input->post('specific_tasks'))
        );
        $id = $this->universal_model->insertz('employeeproject', $data_nsert);
        $array_tasks = $this->input->post('specific_tasks');
        foreach ($array_tasks as $value_now) {
            $data_nserty = array(
                'taken' => 1
            );
            $this->universal_model->updatem('project_id', $value_twoarray [0], 'task', $value_now, 'project_milestone', $data_nserty);
        }
        if ($id > 0) {
            $json_return = array(
                'report' => "Project Assigned",
                'status' => 1
            );
            echo json_encode($json_return);
        } else if ($id >= 0) {
            $json_return = array(
                'report' => "Failed  Update Contact Admin",
                'status' => 0
            );
            echo json_encode($json_return);
        }
    }

    function add_projectcloneone() {
        $project_values = $this->input->post('project_nameempadd');
        $value_twoarray = explode('|', $project_values);
        $user_id = $this->input->post('user_id');
        $id_project = $value_twoarray [0];
        $assignedyet = $this->universal_model->selectzy('*', 'employeeproject', 'id_project', $id_project, 'id_employee', $user_id);
        if (empty($assignedyet)) {
            $data_nsert = array(
                'id_project' => $value_twoarray [0],
                'approved' => 1,
                'approved_by' => $this->session->userdata('logged_in') ['id'],
                'id_employee' => $this->input->post('user_id'),
                'project_task' => json_encode($this->input->post('specific_tasks'))
            );
            $id = $this->universal_model->insertz('employeeproject', $data_nsert);
            if ($id > 0) {
                $json_return = array(
                    'report' => "Project Assigned",
                    'status' => 1
                );
                echo json_encode($json_return);
            } else {
                $json_return = array(
                    'report' => "Failed  Update Contact Admin",
                    'status' => 0
                );
                echo json_encode($json_return);
            }
        } else {
            $array_task_uni = $assignedyet [0] ['project_task'];
            $new_taskaddition = $this->input->post('specific_tasks');
            $array_task_uni_ur = json_decode($array_task_uni, true);
            $brandnew = array_merge($new_taskaddition, $array_task_uni_ur);
            $brandnewm = array_unique($brandnew);
            $array_nokeys = array();
            foreach ($brandnewm as $valueher) {
                array_push($array_nokeys, $valueher);
            }
            // echo json_encode($brandnewm);
            $updated_values = array(
                'project_task' => json_encode($array_nokeys)
            );
            // echo json_encode($array_task_uni);
            $id = $this->universal_model->updatem('id_project', $id_project, 'id_employee', $user_id, 'employeeproject', $updated_values);
            if ($id > 0) {
                $json_return = array(
                    'report' => "Project Assignment Updated",
                    'status' => 1
                );
                echo json_encode($json_return);
            } else {
                $json_return = array(
                    'report' => "Project Assignment Updated",
                    'status' => 1
                );
                echo json_encode($json_return);
            }
        }
    }

    function updatetasks() {
        $_POST ['user_id'] = $this->session->userdata('logged_in') ['user_id'];
        $data_nsert = array(
            'user_id' => $this->input->post('user_id'),
            'project_id' => $this->input->post('id'),
            'project_name' => $this->input->post('name'),
            'ip_address' => $this->input->ip_address(),
            'task_workedone' => $this->input->post('specific_tasks'),
            'time_taken' => $this->input->post('time_spent'),
            'date_done_task' => $this->input->post('date_done_task'),
            'comment_update_task' => $this->input->post('comment_update_task')
        );
        $flag = $this->universal_model->insertz('project_update', $data_nsert);
        if ($flag > 0) {
            $json_return = array(
                'report' => "Task Updated",
                'status' => 1
            );
            echo json_encode($json_return);
        } else if ($flag >= 0) {
            $json_return = array(
                'report' => "Failed To Update Contact Admin",
                'status' => 0
            );
            echo json_encode($json_return);
        }
    }

    function updatetasksc() {
        $_POST ['user_id'] = $this->session->userdata('logged_in') ['user_id'];
        $data_nsert = array(
            'user_id' => $this->input->post('user_id'),
            'project_id' => $this->input->post('id'),
            'project_name' => $this->input->post('name'),
            'ip_address' => $this->input->ip_address(),
            'task_workedone' => $this->input->post('specific_tasks'),
            'time_taken' => $this->input->post('time_spent'),
            'date_done_task' => $this->input->post('date_done_task'),
            'comment_update_task' => $this->input->post('comment_update_task')
        );
        $flag = $this->universal_model->insertz('project_update', $data_nsert);
        if ($flag > 0) {
            $json_return = array(
                'report' => "Task Updated",
                'status' => 1
            );
            echo json_encode($json_return);
        } else if ($flag >= 0) {
            $json_return = array(
                'report' => "Failed To Update Contact Admin",
                'status' => 0
            );
            echo json_encode($json_return);
        }
        // echo json_encode($_POST);
    }

    function edittabledata($id) {
        $userprofile = $this->universal_model->selectz('*', 'users', 'id', $id);
        // print_array($datatone);
        $supervisor_array = $this->getsupervisernames($userprofile [0] ['supervisedby']);
        $string_one = $userprofile [0] ['occupation'];
        $userprofile [0] ['occupation'] = $this->getoccupation($string_one);
        if (empty($supervisor_array)) {
            $supervisor_array [0] ['firstname'] = "";
            $supervisor_array [0] ['lastname'] = "";
        }
        $userprofile [0] ['whoadded'] = $this->getaddedby($userprofile [0] ['addedby']);
        $userprofile [0] ['supervisor_names'] = $supervisor_array [0] ['firstname'] . " " . $supervisor_array [0] ['lastname'];
        $userprofile [0] ['datehired'] = date("F jS, Y", strtotime($userprofile [0] ['datehired']));
        echo json_encode($userprofile [0]);
    }

    public function getoccupation($id) {
        // function selectz($array_table_n, $table_n, $variable_1, $value_1) {
        $array_toget = array(
            'design'
        );
        $value = $this->universal_model->selectz($array_toget, 'util_setting', 'id', $id);
        if (empty($value)) {
            return 'UPDATE OCCUPATION ?';
        } else {
            return $value [0] ['design'];
        }
    }

    public function getaddedby($id) {
        $array_toget = array(
            'firstname',
            'lastname'
        );
        $value = $this->universal_model->selectz($array_toget, 'users', 'id', $id);
        return $value [0] ['firstname'] . ' ' . $value [0] ['lastname'];
    }

    public function getsupervisernames($id) {
        if ($id == 0) {
            $id = $this->session->userdata('logged_in') ['addedby'];
        }
        $data_needed = array(
            'user_email',
            'firstname',
            'lastname',
            'contact'
        );
        $value = $this->universal_model->selectz($data_needed, 'users', 'id', $id);
        // print_array($value);
        return $value;
    }

    public function updatepay() {
        $id_project = $this->input->post('id_project');
        $array_updated = array(
            'paid' => $this->input->post('state')
        );
        $this->universal_model->updatez('id', $id_project, 'project', $array_updated);
    }

    public function close_project() {
        $id_project = $this->input->post('id_project');
        $array_updated = array(
            'status' => 1
        );
        $this->universal_model->updatez('id', $id_project, 'project', $array_updated);
    }

    public function unaward_project() {
        $id_project = $this->input->post('id_project');
        $id_employee = $this->input->post('id_employee');
        $tasks = $this->input->post('tasks');
        $array_tasks = explode(',', $tasks);
        // function deletez($table_name, $variable_1, $value_1) {
        $this->universal_model->deletezm('employeeproject', 'id_employee', $id_employee, 'id_project', $id_project);
        $this->universal_model->deletezm('project_update', 'user_id', $id_employee, 'project_id', $id_project);
        foreach ($array_tasks as $valuek) {
            $array_updated = array(
                'taken' => 0
            );
            $this->universal_model->updatem('project_id', $id_project, 'task', $valuek, 'project_milestone', $array_updated);
        }
    }

    public function deleteuser() {
        $user_id = $this->input->post('user_id');
        $user = $this->universal_model->selectz('*', 'users', 'user_id', $user_id);
        // Images
        $string_one_one = str_replace('50', "", $user [0] ['user_image_small']);
        $string_one_one = str_replace('_', "", $string_one_one);
        if ($string_one_one != "icon_user_default.png") {
            unlink("upload/" . '500_' . $string_one_one);
            unlink("upload/" . '60_' . $string_one_one);
            unlink("upload/" . '50_' . $string_one_one);
        }
        $this->universal_model->deletez('users', 'user_id', $user_id);
        $this->universal_model->deletez('users', 'user_id', $user_id);
        $this->universal_model->deletez('project_update', 'user_id', $user_id);
        $this->universal_model->deletez('employeeproject', 'id_employee', $user_id);
        echo json_encode($user [0] ['id']);
    }

    public function unaward_task() {
        // {"id_project":"1","user_id":"9TC9Rs","task":"namitiz","date_taken":"2018-04-12 16:58:56"}
        $array_updated = array(
            'taken' => 0
        );
        $id_project = $this->input->post('id_project');
        $user_id = $this->input->post('user_id');
        $task = $this->input->post('task');
        $date_taken = $this->input->post('date_taken');
        $arraymm = array(
            'project_task'
        );
        $vara = $this->universal_model->selectzxpp($arraymm, 'employeeproject', 'id_employee', $user_id, 'id_project', $id_project, 'project_task', $task);
        $varibal_raw = $vara [0] ['project_task'];
        // echo $varibal_raw;
        $array_vara = json_decode($varibal_raw, true);
        if (($key = array_search($task, $array_vara)) !== false) {
            unset($array_vara [$key]);
        }
        $array_updatedtwo = array(
            'project_task' => json_encode($array_vara)
        );
        $this->universal_model->deletezn('project_update', 'user_id', $user_id, 'project_id', $id_project, 'task_workedone', $task);
        $this->universal_model->updatem('project_id', $id_project, 'task', $task, 'project_milestone', $array_updated);
        $this->universal_model->updatep('id_project', $id_project, 'id_employee', $user_id, 'date_taken', $date_taken, 'employeeproject', $array_updatedtwo);
    }

    public function approvetask() {
        $array_updated = array(
            'closed' => 1
        );
        $id_project = $this->input->post('id_project');
        $task = $this->input->post('task');
        $this->universal_model->updatem('project_id', $id_project, 'task', $task, 'project_milestone', $array_updated);
        $this->isproject_closed($id_project);
    }

    public function taskdetail() {
        // "task":"namitiz","project_id":"1","client_id":"1","user_id":"9TC9Rs"
        $task = $this->input->post('task');
        $project_id = $this->input->post('project_id');
        $client_id = (int) $this->input->post('client_id');
        $user_id = $this->input->post('user_id');
        $total_time = $this->total_time_pertask($project_id, $task, $user_id);
        $client_name = $this->get_companyname($client_id);
        $totaln_cost = $this->get_employeeprice($user_id);
        $total_cost = $totaln_cost * $total_time;
        $what_want = array(
            'total_time' => $total_time,
            'client_name' => $client_name,
            'total_cost' => $total_cost
        );
        echo json_encode($what_want);
    }

    public function taskdetailm() {
        // "task":"namitiz","project_id":"1","client_id":"1","user_id":"9TC9Rs"
        $task = $this->input->post('task');
        $project_id = $this->input->post('project_id');
        $client_id = 1;
        $user_id = "9TC9Rs";
        $total_time = $this->total_time_pertask($project_id, $task, $user_id);
        $client_name = $this->get_companyname($client_id);
        $totaln_cost = $this->get_employeeprice($user_id);
        $total_cost = $totaln_cost * $total_time;
        $what_want = array(
            'total_time' => $total_time,
            'client_name' => $client_name,
            'total_cost' => $total_cost
        );
        echo json_encode($what_want);
    }

    function get_employeeprice($id) {
        $array_what = array(
            'rateamount'
        );
        $vara = $this->universal_model->joinemplyeeoccupation($id, $array_what);
        return $vara [0] ['rateamount'];
    }

    function get_employeepricecloned($id) {
        $array_what = array(
            'rateamount'
        );
        $vara = $this->universal_model->joinemplyeeoccupation($id, $array_what);
        echo $vara [0] ['rateamount'];
    }

    function total_time_pertask($project_id, $task, $user_id) {
        $time_total = array(
            'time_taken'
        );
        $vara = $this->universal_model->selectzx($time_total, 'project_update', 'project_id', $project_id, 'task_workedone', $task, 'user_id', $user_id);
        $tatol_time = 0;
        foreach ($vara as $value) {
            $tatol_time += $value ['time_taken'];
        }
        return $tatol_time;
    }

    function get_companyname($id_client) {
        $array_chosse = array(
            'clientname'
        );
        $vara = $this->universal_model->selectz($array_chosse, 'client', 'client_number', $id_client);
        return $vara [0] ['clientname'];
        // print_array($vara);
    }

    function gettaskscompleted($project_id) {
        $vara = $this->universal_model->selectzy('*', 'project_milestone', 'project_id', $project_id, 'closed', 1);
        echo count($vara);
    }

    function getutilsetting($id) {
        $vara = $this->universal_model->selectz('*', 'util_setting', 'id', $id);
        if (empty($vara)) {
            $resultarray [0] = array(
                'id' => 0,
                'design' => 'UPDATE OCCUPATION',
                'rateamount' => 10,
                'addedby' => 0
            );
            return $resultarray;
        } else {
            return $vara;
        }
    }

    function getnumberproject($project_id) {
        $vara = $this->universal_model->selectzunique('id_employee', 'employeeproject', 'id_project', $project_id);
        echo count($vara);
    }

    function getnumbertasks($project_id) {
        $vara = $this->universal_model->selectzunique('task', 'project_milestone', 'project_id', $project_id);
        echo count($vara);
    }

    function setmeoneemployee() {
        $this->session->unset_userdata('user_idxxxx');
        $user_id = $this->input->post('user_id');
        $this->session->set_userdata('user_idxxxx', $user_id);
        // $this->session->userdata($user_id);
        $array_now = array(
            $user_id
        );
        echo json_encode($array_now);
    }

    public function checkout() {
        $client_id = 2;
        $userid = 'WmX82S1';
        // For The Below user
        // $userid = 'C77ytO';
        $date_from_fot = '2018-06-17';
        $date_to_fot = '2018-08-20';
        $my_dates = getDatesFromRange($date_from_fot, $date_to_fot);
        $ask = $this->universal_model->reportsingle($userid, $client_id, $date_from_fot, $date_to_fot);
        $data_available_notuni = array();
        // $data_available = array();
        foreach ($ask as $value) {
            $date = date_create($value ['date_done_task']);
            $dmdmd = date_format($date, "Y-m-d");
            $daaaa = $this->universal_model->reportsinglesub($value ['user_id'], $value ['project_id'], $dmdmd);
            array_push($data_available_notuni, $daaaa [0]);
        }
        $data_available_notuni = array_unique($data_available_notuni, SORT_REGULAR);
        foreach ($data_available_notuni as $key => $formatone) {
            foreach ($my_dates as $date_value) {
                if ($formatone ['niceDate'] == $date_value) {
                    // $float = (float) $formatone['totatimetaken'];
                    $pertime = $formatone ['totatimetaken'];
                    $data_available_notuni [$key] [$date_value] = round($pertime, 2) . '';
                } else {
                    $data_available_notuni [$key] [$date_value] = "";
                }
            }
        }
        $newarray = array();
        foreach ($data_available_notuni as $ar) {
            foreach ($ar as $k => $v) {
                if (array_key_exists($v, $newarray)) {
                    $datatoday = $ar ['niceDate'];
                    $newarray [$v] [$datatoday] = $newarray [$v] [$datatoday] + $ar [$datatoday];
                } else if ($k == 'project_id') {
                    $newarray [$v] = $ar;
                }
            }
        }
        $cleaner_array = array();
        $storevalues = array();
        foreach ($newarray as $removeunesce) {
            unset_post($removeunesce, 'project_id');
            unset_post($removeunesce, 'user_id');
            unset_post($removeunesce, 'totatimetaken');
            unset_post($removeunesce, 'niceDate');
            array_push($storevalues, array(
                $removeunesce ['id'],
                $removeunesce ['project_name']
            ));
            // $storevalues = array_me($storevalues,$mfmff);
            // $output = array_slice($removeunesce, 2);
            // $totalsum = array_sum($output);
            // $removeunesce['total'] = round($totalsum, 2);
            // print_array($removeunesce);
            unset_post($removeunesce, 'id');
            array_push($cleaner_array, $removeunesce);
        }
        $cleaner_array_onblock = $this->testign($userid, $date_from_fot, $date_to_fot);
        $cleaner_array = array_merge($cleaner_array, $cleaner_array_onblock);
        $megastring = "";
        $megastring = "";
        // $mega_sub_string = "";
        // $number_roow
        foreach ($cleaner_array as $key => $data_pipe) {
            $indexnumber = $key + 1;
            $mega_sub_string = "";
            $damru = array_values($data_pipe);
            foreach ($damru as $vvvvv) {
                $mega_sub_string .= '"' . $vvvvv . '"' . ',';
            }
            $firstcolumn = $this->translatref(2) . '' . $indexnumber;
            $lastcolum = $this->translatref(count($damru)) . '' . $indexnumber;
            $formular = $firstcolumn . ':' . $lastcolum;
            // echo $this->translatref(count($damru)) . '<br>';
            $mega_sub_string = substr($mega_sub_string, 0, - 1);
            $megastring .= '[' . $mega_sub_string . ',' . '"' . '=SUM(' . $formular . ')' . '"' . ']' . ',';
            // Better
            // $data_pipe = array_values($data_pipe);
            // foreach ($data_pipe as $value) {
            // $megastring += $value;
            // }
        }
        // Last Row Start
        // echo count($data_available_notuni);
        array_unshift($my_dates, 'shiftwer');
        $my_dateskeys = array_keys($my_dates);
        $lastrowformular = '';
        foreach ($my_dateskeys as $valuebetween) {
            $count_start = $valuebetween + 2;
            $firstcolumn = $this->translatref($count_start);
            // echo $firstcolumn . '<br>';
            foreach ($data_available_notuni as $key => $value) {
                $number_ = $key + 1;
                $startref = $firstcolumn . '' . $number_;
                break;
            }
            foreach ($data_available_notuni as $key => $value) {
                $number_ = $key + 1;
                $endref = $firstcolumn . '' . $number_;
            }
            $subtractionadd = '';
            foreach ($cleaner_array_onblock as $keynext => $value) {
                // print_array($value);
                $adjan = $number_ + $keynext + 1;
                $subtraction = '-' . $firstcolumn . '' . $adjan;
                $subtractionadd .= $subtraction;
            }
            // echo $subtractionadd . '<br>';
            // $endref = $firstcolumn . '' . $number_;
            $lastrowformular .= '"' . '=SUM(' . $startref . ':' . $endref . ')' . $subtractionadd . '"' . ',';

            // echo $number_;
        }
        $lastrowformular_sqlbra = '[' . '"' . '",' . substr($lastrowformular, 0, - 1) . ']';
        // $lastrowformular_sqlbra = '[' . '"' . '",' . $lastrowformular . ']';
        $megastring = $megastring . $lastrowformular_sqlbra;
        // Last Row End
        // $megastring = substr($megastring, 0, -1);
        echo '[' . $megastring . ']';
        // return '[' . $megastring . ']';
    }

    public function translatref($value) {
        return columnLetter($value);
    }

    public function testign($userid, $date_from_fot, $date_to_fot) {
        // For The Below user
        // $userid = 'C77ytO';
        $my_dates = getDatesFromRange($date_from_fot, $date_to_fot);
        $data_available_notuni_juni = array();
        $data_available_notuni = array();
        // $data_available = array();
        $vara = $this->universal_model->selectz('*', 'util_project_updatem', 'user_id', $userid);
        foreach ($vara as $key => $letsgetthis) {
            $data_available_notuni ['project_name'] = $vara [$key] ['project_name'];
            foreach ($my_dates as $mydateend) {
                $varamax = $this->universal_model->reportsinglestate($letsgetthis ['id_otherstate'], $mydateend);
                if (empty($varamax)) {
                    $data_available_notuni [$mydateend] = "";
                } else {
                    $data_available_notuni [$mydateend] = $varamax [0] ['time_taken'];
                }
            }
            array_push($data_available_notuni_juni, $data_available_notuni);
            // foreach ($varamax as $valuepp) {
            // $data_available_notuni[$valuepp['date_done_task']] = $valuepp['time_taken'];
            // }
            // array_push($data_available_notuni_juni, $data_available_notuni);
            // echo $key;
        }
        return $data_available_notuni_juni;
    }

    function setoneproject() {
        $this->session->unset_userdata('employee_idxx');
        $employee_id = $this->input->post('project_id');
        $this->session->set_userdata('employee_idxx', $employee_id);
        echo json_encode($_POST);
    }

}
