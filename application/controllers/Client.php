<?php

class Client extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('universal_model');
        $this->load->model('user_model', '', TRUE);
        //$this->load->library('image_magician');
    }

    public function getsupervisernames($id) {
        $data_needed = array(
            'user_email',
            'firstname',
            'lastname',
            'contact'
        );
        $value = $this->universal_model->selectz($data_needed, 'users', 'id', $id);
        return $value;
    }

    function test() {
//        $this->curl->create(base_url('employee/closetak/') . $value['id'] . '/' . $valuep);
    }

    function editclientr($id) {
        $userprofile = $this->universal_model->selectz('*', 'client', 'id', $id);
        $supervisor_array = $this->getsupervisernames($userprofile[0]['addedby']);
        print_array($supervisor_array);
//        echo json_encode($_GET);
    }

    function editclient($id) {
        $userprofile = $this->universal_model->selectz('*', 'client', 'id', $id);
        $supervisor_array = $this->getsupervisernames($userprofile[0]['addedby']);
        $string_one = $userprofile[0]['occupation_client'];
        $string_one_one = str_replace('[', "", $string_one);
        $string_one_one_one = str_replace(']', "", $string_one_one);
        $string_one_one_1 = str_replace('"', "", $string_one_one_one);
        $string_one_one_2 = str_replace(',', " | ", $string_one_one_1);
        $userprofile[0]['occupation_client'] = $string_one_one_2;
        if (empty($supervisor_array)) {
            $supervisor_array[0]['firstname'] = "";
            $supervisor_array[0]['lastname'] = "";
        }
        $userprofile[0]['supervisor_names'] = $supervisor_array[0]['firstname'] . " " . $supervisor_array[0]['lastname'];
        $userprofile[0]['dateadded'] = date("F jS, Y", strtotime($userprofile[0]['dateadded']));
        echo json_encode($userprofile[0]);
    }

    function closeclient() {
        $id = $this->input->post('clientid');
        $variablec = array(
            'slug' => 0
        );
        $this->universal_model->updatez('id', $id, 'client', $variablec);
    }

    function addclient() {
        $this->form_validation->set_rules('client_email', 'Client Email', 'trim|required|is_unique[client.client_email]');
        $this->form_validation->set_rules('client_contact', 'Contact Number', 'required|is_unique[client.client_contact]');
        if ($this->form_validation->run() == FALSE) {
            $issue_one = form_error("client_email");
            $issue_two = form_error("client_contact");
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
                'report' => "New Client Added Successfully",
                'status' => 2
            );
            $this->addclient_subfunc();
            echo json_encode($json_return);
        }
    }

    public function create_thumbnail($width, $height, $new_image, $image_source) {
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

    function editclienttwo() {
        if ($this->input->post('client_email_old') !== $this->input->post('client_email')) {
            $this->form_validation->set_rules('client_email', 'CLIENT EMAIL', 'trim|required|is_unique[client.client_email]');
        }
        if ($this->input->post('pin_no_old') !== $this->input->post('pin_no')) {
            $this->form_validation->set_rules('pin_no', 'PIN NUMBER', 'trim|required|is_unique[client.pin_no]');
        }
        if ($this->input->post('phone_number_old') !== $this->input->post('client_contact')) {
            $this->form_validation->set_rules('client_contact', 'CONTACT NUMBER', 'required|is_unique[client.client_contact]');
        }
        if ($this->form_validation->run() == FALSE) {
            $issue_one = form_error("client_email");
            $issue_two = form_error("pin_no");
            $issue_three = form_error("client_contact");
            $variabone = strip_tags($issue_one, "<b><i>");
            $variabtwo = strip_tags($issue_two, "<b><i>");
            $variabthree = strip_tags($issue_three, "<b><i>");
            if ($variabone !== "" || $variabtwo !== "" || $variabthree !== "") {
                $json_return = array(
                    'report' => $variabone . " " . $variabtwo . " " . $variabthree,
                    'status' => 1
                );
                echo json_encode($json_return);
            }
        } else {
            $string_one_one = str_replace('50', "", $this->input->post('user_imagex'));
            $string_one_one = str_replace('_', "", $string_one_one);
            $_POST['user_imagex'] = $string_one_one;
            $user_add = array(
                'clientname' => $this->input->post('clientname'),
                'client_email' => $this->input->post('client_email'),
                'pin_no' => $this->input->post('pin_no'),
                'person_charge' => $this->input->post('person_charge'),
                'client_location' => $this->input->post('client_location'),
                'occupation_client' => json_encode($this->input->post('occupation_employee')),
                'website' => $this->input->post('website'),
                'client_type' => $this->input->post('client_type'),
                'client_contact' => $this->input->post('client_contact'),
                'addedby' => $this->session->userdata('logged_in')['id']
            );
//        unset_post($ararra, 'hshs');
            if ($this->input->post('website') == "") {
                unset_post($user_add, 'website');
            }
            if (empty($this->input->post('occupation_employee'))) {
                unset_post($user_add, 'occupation_client');
            }
            $this->updateclient_subfunc($user_add);
            $json_return = array(
                'report' => "Editted Successfully",
                'status' => 2
            );
            echo json_encode($json_return);
        }
    }

    function updateclient_subfunc($variablec) {
        if ($this->validate_image("userimage" . getToken(3))) {
            $data = array('upload_data' => $this->upload->data());
            $name_file = $data['upload_data'];
            $_POST['user_profile_pic'] = $name_file['file_name'];
            $this->create_thumbnail(50, 50, './upload/client/' . "50_" . $this->input->post('user_profile_pic'), './upload/client/' . $this->input->post('user_profile_pic'));
            $this->create_thumbnail(60, 60, './upload/client/' . "60_" . $this->input->post('user_profile_pic'), './upload/client/' . $this->input->post('user_profile_pic'));
            $this->create_thumbnail(500, 500, './upload/client/' . "500_" . $this->input->post('user_profile_pic'), './upload/client/' . $this->input->post('user_profile_pic'));
            $_POST['client_image_small'] = "50_" . $this->input->post('user_profile_pic');
            $_POST['client_image_medium'] = "60_" . $this->input->post('user_profile_pic');
            $_POST['client_image_big'] = "500_" . $this->input->post('user_profile_pic');
//            unlink('/upload/' . $this->input->post('user_profile_pic'));
            unlink("upload/client/" . $name_file['file_name']);
            unlink("upload/client/" . '500_' . $this->input->post('user_imagex'));
            unlink("upload/client/" . '60_' . $this->input->post('user_imagex'));
            unlink("upload/client/" . '50_' . $this->input->post('user_imagex'));

//            unlink($name_file['file_name']);
            $variablec['client_image_small'] = $this->input->post('client_image_small');
            $variablec['client_image_medium'] = $this->input->post('client_image_medium');
            $variablec['client_image_big'] = $this->input->post('client_image_big');
        } else {
            $_POST['client_image_small'] = '50_' . $this->input->post('user_imagex');
            $_POST['client_image_medium'] = '60_' . $this->input->post('user_imagex');
            $_POST['client_image_big'] = '500_' . $this->input->post('user_imagex');

            $variablec['client_image_small'] = $this->input->post('client_image_small');
            $variablec['client_image_medium'] = $this->input->post('client_image_medium');
            $variablec['client_image_big'] = $this->input->post('client_image_big');
        }
        $this->universal_model->updatez('id', $this->input->post('id'), 'client', $variablec);
    }

    function addclient_subfunc() {
        if ($this->validate_image("userimage" . getToken(3))) {
            $data = array('upload_data' => $this->upload->data());
            $name_file = $data['upload_data'];
            $_POST['user_profile_pic'] = $name_file['file_name'];
            $this->create_thumbnail(50, 50, './upload/client/' . "50_" . $this->input->post('user_profile_pic'), './upload/client/' . $this->input->post('user_profile_pic'));
            $this->create_thumbnail(60, 60, './upload/client/' . "60_" . $this->input->post('user_profile_pic'), './upload/client/' . $this->input->post('user_profile_pic'));
            $this->create_thumbnail(500, 500, './upload/client/' . "500_" . $this->input->post('user_profile_pic'), './upload/client/' . $this->input->post('user_profile_pic'));
            $_POST['user_image_small'] = "50_" . $this->input->post('user_profile_pic');
            $_POST['user_image_medium'] = "60_" . $this->input->post('user_profile_pic');
            $_POST['user_image_big'] = "500_" . $this->input->post('user_profile_pic');
//            unlink('/upload/' . $this->input->post('user_profile_pic'));
            unlink("upload/client/" . $name_file['file_name']);
//            unlink($name_file['file_name']);
        } else {
            $_POST['user_image_small'] = "50_icon_user_default.png";
            $_POST['user_image_medium'] = "60_icon_user_default.png";
            $_POST['user_image_big'] = "500_icon_user_default.png";
        }
        $user_add = array(
            'clientname' => $this->input->post('clientname'),
            'client_number' => $this->input->post('client_number'),
            'pin_no' => $this->input->post('pin_no'),
            'person_charge' => $this->input->post('person_charge'),
            'client_email' => $this->input->post('client_email'),
            'occupation_client' => $this->input->post('occupation_client'),
            'client_location' => $this->input->post('client_location'),
            'client_image_small' => $this->input->post('user_image_small'),
            'client_image_medium' => $this->input->post('user_image_medium'),
            'client_image_big' => $this->input->post('user_image_big'),
            'website' => $this->input->post('clientwebsite'),
            'client_type' => $this->input->post('optionsRadios'),
            'client_contact' => $this->input->post('client_contact'),
            'addedby' => $this->session->userdata('logged_in')['id']
        );
        $this->universal_model->insertz('client', $user_add);
//        echo $feed;
//        print_array($_POST);
//        echo json_encode($user_add);
    }

    public function validate_image($generatedname) {
        $config['overwrite'] = TRUE;
        $config['upload_path'] = './upload/client/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '10000';
        $config['max_width'] = '2024';
        $config['max_height'] = '1068';
        $config['file_name'] = $generatedname;
        $this->load->library('upload');
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('user_profile_pic')) {
            $error = array('error' => $this->upload->display_errors());
//            print_array($error);
            if (strpos($error['error'], "You did not select a file to upload.") !== FALSE) {
                $this->form_validation->set_message('validate_image', 'Please Select Profile Picture');
//                $this->session->set_flashdata('user_profile_pic_', "Please Select Profile Picture");
//                redirect(base_url() . "admin/admin/admin/2");
            } elseif
            (strpos($error['error'], "The uploaded file exceeds the maximum allowed size in your PHP configuration file.") !== FALSE) {
//                $this->session->set_flashdata('user_profile_pic_', "");
//                redirect(base_url() . "admin/admin/admin/2");
                $this->form_validation->set_message('validate_image', 'Profile Picture exceeds the required image size');
            }
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function addproject() {
        $project_add = array(
            'id_client' => $this->input->post('client_project'),
            'project_name' => $this->input->post('project_name'),
//            'project_pricing' => $this->input->post('project_pricing'),
            'start_date' => $this->input->post('start_date_project'),
            'end_date' => $this->input->post('end_date_project'),
            'addedby' => $this->session->userdata('logged_in')['id']
        );
        $valuestate = $this->universal_model->insertz('project', $project_add);
        //Insert in the tasks
        $project_milestone = $this->input->post('tasks_of_project');
        $array_tasks = explode(',', $project_milestone);
        foreach ($array_tasks as $pertask) {
            $task_add = array(
                'project_id' => $valuestate,
                'task' => trim($pertask)
            );
            $this->universal_model->insertz('project_milestone', $task_add);
        }
        if ($valuestate > 0) {
            $json_return = array(
                'report' => "Project Added Successfully",
                'status' => 2
            );
            echo json_encode($json_return);
        } else {
            $json_return = array(
                'report' => "Project Not Added",
                'status' => 1
            );
            echo json_encode($json_return);
        }
    }

    function setmeinvoice() {
        $this->session->unset_userdata('clientid_xxx');
        $this->session->unset_userdata('projectid_xxx');
        $project_id = $this->input->post('project_id');
        $client_id = $this->input->post('client_id');
        $this->session->set_userdata('clientid_xxx', $client_id);
        $this->session->set_userdata('projectid_xxx', $project_id);
////        $this->session->userdata($user_id);
//        $array_now = array(
//            $user_id
//        );
        echo json_encode($_POST);
    }

    function editproject($id) {
        $array_whatineed = array(
            'project_name',
            'clientname',
            'task',
            'start_date',
            'end_date',
            'client_number',
            'person_charge',
            'pin_no',
//            'client_image_medium',
            'client_type',
            'project_id'
        );
        $joined_state = $this->universal_model->join3oneproject($id, $array_whatineed);
        $tasks = array();
        $tasks_href_string = "";
        foreach ($joined_state as $value_task) {
            $tasks_href_string .= $value_task['task'] . ',';
            array_push($tasks, $value_task['task']);
        }
        $joined_state[0]['tasks_miles'] = removelastchar($tasks_href_string, ',');
        unset_post($joined_state[0], 'task');
        echo json_encode($joined_state[0]);
//        print_array($joined_state);
    }

    function damit() {
//        $data = array(
//            'id' => 42,
//            'task' => 'namitiz',
//            'project_id' => 1
//        );
//        $this->db->replace('project_milestone', $data);
        $project_id = $this->input->post('id');
    }

    function update_project() {
        $project_id = $this->input->post('id');
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $string_list = $this->input->post('tasks_miles');
        $array_taks = explode(',', $string_list);
//        echo json_encode($_POST);
        $tasksold = array();
        $assignedyet = $this->universal_model->selectz('*', 'project_milestone', 'project_id', $project_id);
        foreach ($assignedyet as $tobeupdated) {
            array_push($tasksold, $tobeupdated['task']);
        }
//        $brandnew = array_merge($array_taks, $tasksold);
//        $brandnewm = array_unique($brandnew);
        foreach ($tasksold as $valuecheck) {
            $this->universal_model->deletezn('project_milestone', 'project_id', $project_id, 'task', $valuecheck, 'closed', 0);
        }
        foreach ($array_taks as $value_task) {
//            $new_oh = $this->universal_model->selectzy('*', 'project_milestone', 'project_id', $project_id, 'task', $value_task);

            $datato = array(
                'project_id' => $project_id,
                'task' => $value_task
            );
            $datesm = array(
                'start_date' => $start_date,
                'end_date' => $end_date
            );
            $mage = $this->universal_model->insertz('project_milestone', $datato);
            $this->universal_model->updatez('id', $project_id, 'project', $datesm);
            if ($mage > 0) {
                $papa = array(
                    'status' => 1,
                    'report' => 'Tasks Have Been Updated'
                );
            } else {
                $papa = array(
                    'status' => 0,
                    'report' => 'Project Update Not Successfull'
                );
            }
        }
        echo json_encode($papa);
    }

    public function totalcostapproved($id) {
        $array_task = array(
            'project_task'
        );
        $allapproved = $this->universal_model->selectzy($array_task, 'employeeproject', 'approved', 1, 'id_project', $id);
        $alltask_array = array();
        $alltask_array_son = array();
        foreach ($allapproved as $value) {
//            array_push($alltask_array,json_decode($value['project_task'], true));
            $alltask_array = json_decode($value['project_task'], true);
            foreach ($alltask_array as $value_son) {
                array_push($alltask_array_son, $value_son);
            }
        }
        $array_unique = array_unique($alltask_array_son);
        $totaltimem = 0;
        foreach ($array_unique as $value_task) {
            $totaltimem += $this->simpleone($value_task);
        }
        echo $totaltimem;
//        print_array($allapprovedstepone);
    }

    public function simpleone($taskme) {
        $allapprovedstepone = $this->universal_model->joinonetotalcost('*', $taskme);
        $total_kitu = 0;
//        $incremental_cost = 0;
        foreach ($allapprovedstepone as $valuexc) {
            $string_one = $valuexc['occupation'];
//                            echo $string_one;
            $response2 = Requests::get(base_url('employee/getutilsetting/') . $string_one);
            $utilsetting = json_decode($response2->body, true);
            $costinperemployee = $utilsetting[0]['rateamount'];
            $total_kitu = $costinperemployee * $valuexc['time_taken'];
//            $incremental_cost += $total_kitu;
        }
        return $total_kitu;
    }

    public function generalreportm() {
        //Start Game
        //End Game
//        $today = date("Y-m-d H:i:s");
        $date_to = strtotime("now");
        $date_to_fot = date('Y-m-d H:i:s', $date_to);
        //Step Two
        $date_from = date('c', strtotime('-30 days'));
        $date_from_o = strtotime($date_from);
        $date_from_fot = date('Y-m-d H:i:s', $date_from_o);
//        $from_date = "";
        $allapprovedstepone = $this->universal_model->joingenrelreport3($date_from_fot, $date_to_fot);
//        foreach ($allapprovedstepone as $key => $value_core) {
//            $datewalah = date('Y-m-d', strtotime($value_core['when_date']));
////            echo $datewalah;
//            $total_time = $this->gettimeofday($datewalah);
//            $allapprovedstepone[$key]['totaltime_x'] = $total_time;
////            echo $total_time . '<br>';
//        }
//        print_array($allapprovedstepone);
        echo json_encode($allapprovedstepone);
    }

    public function gettimeofday($when_date_value) {
        $time_takenarray = array(
            'time_taken'
        );
//        $when_date_value = '2018-04-16';
        $arrayx = array(
            'when_date' => $when_date_value
        );
        $allapprovedstepone = $this->universal_model->selectzwherein($time_takenarray, 'project_update', $when_date_value);
        $total_timeday = 0;
        foreach ($allapprovedstepone as $value_time) {
            $total_timeday += $value_time['time_taken'];
        }
        return $total_timeday;
    }

}
