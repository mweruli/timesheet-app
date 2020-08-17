<?php

class Authentication extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('universal_model');
        $this->load->model('user_model', '', TRUE);
    }

    public function index() {
//        $this->session->set_userdata('some_name', 'some_value');
        $this->load->view('part/outer/login');
    }

    function lockscreen() {
//        $myid = $this->session->userdata('logged_in')['id'];
//        print_array($array);
        $data['user_id'] = $this->session->userdata('logged_in')['emailaddress'];
        $data['user_image_big'] = $this->session->userdata('logged_in')['user_image_big'];
        $newdata = array(
            'id' => '',
            'user_id' => '',
            'user_image_small' => '',
            'user_image_medium' => '',
            'user_image_big' => '',
            'emailaddress' => '',
            'firstname' => '',
            'lastname' => '',
            'cellphone' => '',
            'category' => '',
            'dateemployeed' => '',
            'dob' => '',
            'employmenttype_id' => '',
            'slug' => '',
            'supervisedby' => '',
            'dateadded' => '',
            'id_gender' => ''
        );
        $this->session->unset_userdata($newdata);
        $this->session->sess_destroy();
        $this->load->view('part/outer/lockscreen', $data);
    }

    function unlock() {
        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('password', form_error('password'));
            redirect(base_url('authentication/lockscreen'));
        } else {
            $this->login();
        }
    }

    public function login() {
        if ($this->session->userdata('logged_in')) {
            redirect(base_url('welcome/dashboard'));
        } else {
            $this->form_validation->set_rules('user_id', 'User Email', 'trim|required|xss_clean');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_database');
//        $result = $this->user_model->login($this->input->post('user_id'), $this->input->post('password'));
//        print_array($result);
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('user_id', form_error('user_id'));
                $this->session->set_flashdata('password', form_error('password'));
                redirect(base_url('authentication'));
            } else {
                redirect(base_url('welcome/dashboard'));
            }
        }
    }

    function logout() {
        $this->session->unset_userdata('logged_in');
        $this->session->sess_destroy();
//        $this->load->view('includes/pane/v_login', $this->m_data->static_data());
        redirect(base_url());
    }

    public function select_user_id_pass($id) {
        $array_userpass = array(
            'user_id',
            'password'
        );
        $result = $this->universal_model->selectz($array_userpass, 'users', 'id', $id);
        return $result;
//        $_POST['user_id'] = $result[0]['user_id'];
//        $_POST['password'] = $result[0]['password'];
//        $this->login();
    }

    public function check_database($password) {
        $user_id = $this->input->post('user_id');
        //query the database
        $result = $this->user_model->login($user_id, $password);
        if ($result) {
            $sess_array = array();
            foreach ($result as $row) {
                $sess_array = array(
                    'id' => $row->id,
                    'user_id' => $row->user_id,
                    'user_image_small' => $row->user_image_small,
                    'user_image_medium' => $row->user_image_medium,
                    'user_image_big' => $row->user_image_big,
                    'emailaddress' => $row->emailaddress,
                    'firstname' => $row->firstname,
                    'lastname' => $row->lastname,
                    'cellphone' => $row->cellphone,
                    'category' => $row->category,
                    'dateemployeed' => $row->dateemployeed,
                    'dob' => $row->dob,
                    'employmenttype_id' => $row->employmenttype_id,
                    'slug' => $row->slug,
                    'dateadded' => $row->dateadded,
                    'supervisedby' => $row->supervisedby,
                    'addedby' => $row->addedby,
                    'id_gender' => $row->id_gender
                );
            }
            $this->session->set_userdata('logged_in', $sess_array);
            return TRUE;
        } else {
            $this->form_validation->set_message('check_database', 'Invalid User Email or Password');
            return false;
        }
    }

    public function forgot_pass() {
        $email_requesting = $this->input->post('email');
        $result = $this->universal_model->selectz('*', 'users', 'emailaddress', $email_requesting);
        if (!empty($result)) {
//            $hash = md5(rand(0, 1000));
//            $array_insert = array(
//                'id_user' => $email_requesting,
//                'reg_token' => $hash
//            );
            //$result = $this->universal_model->insertz('util_auth_email', $array_insert);
            $this->session->set_flashdata('success', $this->input->post('email') . " " . "Check your email for your credentials!");
            $data_array['names'] = $result[0]['firstname'] . " " . $result[0]['lastname'];
            $data_array['user_id'] = $result[0]['user_id'];
            $data_array['password'] = $result[0]['password'];
            $data_array['email'] = $this->input->post('email');
            $this->htmlmail('dominic@alfabiz.co.ke', $email_requesting, 'part/outer/v_sendcredentials', 'Alfabiz Timesheet', 'Timesheet|Password Recovery', $data_array);
            //echo $result[0]['user_id'];
            //print_array($result[0]);
            redirect(base_url('authentication'));
        } else if (empty($result)) {
            $this->session->set_flashdata('status', "User does not exist, Please cellphone Administrator!");
            redirect(base_url('authentication'));
        }
//        print_array($result);
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
        $this->email->to($email_desitination);  // replace it with receiver mail id
        $this->email->subject($sub_title); // replace it with relevant subject 
//        $this->load->view('part/outer/login', $data, TRUE);
        $body = $this->load->view($email_html, $data_array, TRUE);
        $this->email->message($body);
        $this->email->send();
    }

    public function resquestaccount() {
        $email_requesting = $this->input->post('email');
        $result = $this->universal_model->selectz('*', 'users', 'emailaddress', $email_requesting);
        if (!empty($result)) {
            $this->session->set_flashdata('status', "User Already Exists Can Not Request Account!");
            redirect(base_url('authentication'));
        } else if (empty($result)) {
            $data_array['firstname'] = $this->input->post('firstname');
            $data_array['lastname'] = $this->input->post('lastname');
            $data_array['date_of_birth'] = $this->input->post('date_of_birth');
            $data_array['id_gender'] = $this->input->post('id_gender');
            $data_array['email'] = $this->input->post('email');
//            print_array($this->input->post());
//        dominic@alfabiz.co.ke
            $this->htmlmail($this->input->post('email'), "dominic@alfabiz.co.ke", 'part/outer/v_requestaccount', 'Alfabiz Timesheet', 'Timesheet|Requesting Account', $data_array);
            $this->session->set_flashdata('success', $this->input->post('email') . " Your request has been sent!");
            redirect(base_url('authentication'));
        }
//        print_array($_POST);
    }

    public function updateprofile() {
        $_POST['check'] = "one";
        $this->form_validation->set_rules('check', 'Check', 'required');
        if ($this->input->post('email_value') !== $this->session->userdata('logged_in')['emailaddress']) {
            $this->form_validation->set_rules('email_value', 'Email', 'trim|required|is_unique[users.emailaddress]');
        } else if ($this->input->post('phone') !== $this->session->userdata('logged_in')['cellphone']) {
            $this->form_validation->set_rules('phone', 'Phone number', 'required|is_unique[users.cellphone]');
        }
        if ($this->form_validation->run()) {

            $id = $this->input->post('id');
            $string_one_one = str_replace('50', "", $this->input->post('user_imagex'));
            $string_one_onen = str_replace('_', "", $string_one_one);
            $_POST['user_imagex'] = $string_one_onen;
            $ararra = array(
                'emailaddress' => $this->input->post('email_value'),
                'password' => $this->input->post('password'),
                'firstname' => $this->input->post('firstname'),
                'lastname' => $this->input->post('lastname'),
                'cellphone' => $this->input->post('phone'),
                'employmenttype_id' => json_encode($this->input->post('employmenttype_id_employee')),
            );
//        unset_post($ararra, 'hshs');
            if ($this->input->post('password') == "") {
                unset_post($ararra, 'password');
            }
            if ($this->input->post('employmenttype_id_employee') == "") {
                unset_post($ararra, 'employmenttype_id');
            }
            //$ararra['hary'] = "njovu";
            $this->updateprofile_subfunc($ararra);
            $json_return = array(
                'report' => "Editted Successfully",
                'status' => 2
            );

            //$this->session->unset_userdata('logged_in');
            //$this->session->sess_destroy();
//            sleep(4);
            $cedes = $this->select_user_id_pass($id);
            $result = $this->user_model->login($cedes[0]['user_id'], $cedes[0]['password']);
            if ($result) {
                $sess_array = array();
                foreach ($result as $row) {
                    $sess_array = array(
                        'id' => $row->id,
                        'user_id' => $row->user_id,
                        'user_image_small' => $row->user_image_small,
                        'user_image_medium' => $row->user_image_medium,
                        'user_image_big' => $row->user_image_big,
                        'emailaddress' => $row->emailaddress,
                        'firstname' => $row->firstname,
                        'lastname' => $row->lastname,
                        'cellphone' => $row->cellphone,
                        'category' => $row->category,
                        'dateemployeed' => $row->dateemployeed,
                        'dob' => $row->dob,
                        'employmenttype_id' => $row->employmenttype_id,
                        'slug' => $row->slug,
                        'dateadded' => $row->dateadded,
                        'addedby' => $row->addedby,
                        'supervisedby' => $row->supervisedby,
                        'id_gender' => $row->id_gender
                    );
                }
                $this->session->set_userdata('logged_in', $sess_array);
            }
            echo json_encode($json_return);
        } else {
            $issue_one = form_error("email_value");
            $issue_two = form_error("phone");
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
        }

//        echo validation_errors();
//        die;
    }

    public function updateprofilexx() {
        if ($this->input->post('email_value') !== $this->session->userdata('logged_in')['emailaddress']) {
            $this->form_validation->set_rules('email_value', 'Email', 'trim|required|is_unique[users.emailaddress]');
        } else if ($this->input->post('phone') !== $this->session->userdata('logged_in')['cellphone']) {
            $this->form_validation->set_rules('phone', 'Phone number', 'required|is_unique[users.cellphone]');
        }
        if ($this->form_validation->run() == FALSE) {
            $issue_one = form_error("email_value");
            $issue_two = form_error("phone");
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
            $id = $this->input->post('id');
            $string_one_one = str_replace('50', "", $this->input->post('user_imagex'));
            $string_one_one = str_replace('_', "", $string_one_one);
            $_POST['user_imagex'] = $string_one_one;
            $ararra = array(
                'emailaddress' => $this->input->post('email_value'),
                'password' => $this->input->post('password'),
                'firstname' => $this->input->post('firstname'),
                'lastname' => $this->input->post('lastname'),
                'cellphone' => $this->input->post('phone'),
                'employmenttype_id' => json_encode($this->input->post('employmenttype_id_employee')),
            );
//        unset_post($ararra, 'hshs');
            if ($this->input->post('password') == "") {
                unset_post($ararra, 'password');
            }
            if ($this->input->post('employmenttype_id_employee') == "") {
                unset_post($ararra, 'employmenttype_id');
            }
            //$ararra['hary'] = "njovu";
            $this->updateprofile_subfunc($ararra);
            $json_return = array(
                'report' => "Editted Successfully",
                'status' => 2
            );

            //$this->session->unset_userdata('logged_in');
            //$this->session->sess_destroy();
//            sleep(4);
            $cedes = $this->select_user_id_pass($id);
            $result = $this->user_model->login($cedes[0]['user_id'], $cedes[0]['password']);
            if ($result) {
                $sess_array = array();
                foreach ($result as $row) {
                    $sess_array = array(
                        'id' => $row->id,
                        'user_id' => $row->user_id,
                        'user_image_small' => $row->user_image_small,
                        'user_image_medium' => $row->user_image_medium,
                        'user_image_big' => $row->user_image_big,
                        'emailaddress' => $row->emailaddress,
                        'firstname' => $row->firstname,
                        'lastname' => $row->lastname,
                        'cellphone' => $row->cellphone,
                        'category' => $row->category,
                        'dateemployeed' => $row->dateemployeed,
                        'dob' => $row->dob,
                        'employmenttype_id' => $row->employmenttype_id,
                        'slug' => $row->slug,
                        'dateadded' => $row->dateadded,
                        'addedby' => $row->addedby,
                        'supervisedby' => $row->supervisedby,
                        'id_gender' => $row->id_gender
                    );
                }
                $this->session->set_userdata('logged_in', $sess_array);
            }
            echo json_encode($json_return);
//            redirect(base_url('welcome/dashboard'));
        }
    }

    public function updateprofile_subfunc($variablec) {
        if ($this->validate_image("userimage" . getToken(3))) {
            $data = array('upload_data' => $this->upload->data());
            $name_file = $data['upload_data'];
            $_POST['user_profile_pic'] = $name_file['file_name'];
            $this->create_thumbnail(50, 50, './upload/' . "50_" . $this->input->post('user_profile_pic'), './upload/' . $this->input->post('user_profile_pic'));
            $this->create_thumbnail(60, 60, './upload/' . "60_" . $this->input->post('user_profile_pic'), './upload/' . $this->input->post('user_profile_pic'));
            $this->create_thumbnail(500, 500, './upload/' . "500_" . $this->input->post('user_profile_pic'), './upload/' . $this->input->post('user_profile_pic'));
            $_POST['user_image_small'] = "50_" . $this->input->post('user_profile_pic');
            $_POST['user_image_medium'] = "60_" . $this->input->post('user_profile_pic');
            $_POST['user_image_big'] = "500_" . $this->input->post('user_profile_pic');
//            unlink('/upload/' . $this->input->post('user_profile_pic'));
            unlink("upload/" . $name_file['file_name']);
            unlink("upload/" . '500_' . $this->input->post('user_imagex'));
            unlink("upload/" . '60_' . $this->input->post('user_imagex'));
            unlink("upload/" . '50_' . $this->input->post('user_imagex'));

            $variablec['user_image_small'] = $this->input->post('user_image_small');
            $variablec['user_image_medium'] = $this->input->post('user_image_medium');
            $variablec['user_image_big'] = $this->input->post('user_image_big');
//            unlink($name_file['file_name']);
        } else {
            $_POST['user_image_small'] = '50_' . $this->input->post('user_imagex');
            $_POST['user_image_medium'] = '60_' . $this->input->post('user_imagex');
            $_POST['user_image_big'] = '500_' . $this->input->post('user_imagex');

            $variablec['user_image_small'] = $this->input->post('user_image_small');
            $variablec['user_image_medium'] = $this->input->post('user_image_medium');
            $variablec['user_image_big'] = $this->input->post('user_image_big');
        }
        $this->universal_model->updatez('id', $this->input->post('id'), 'users', $variablec);
    }

    public function validate_image($generatedname) {
        $config['overwrite'] = TRUE;
        $config['upload_path'] = './upload/';
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

    function edittabledatatwo() {
        $_POST['check'] = "one";
        $this->form_validation->set_rules('check', 'Check', 'required');
        if ($this->input->post('employee_email_old') !== $this->input->post('employee_email')) {
            $this->form_validation->set_rules('employee_email', 'Email', 'trim|required|is_unique[users.emailaddress]');
        }
        if ($this->input->post('phone_number_old') !== $this->input->post('phone_number')) {
            $this->form_validation->set_rules('phone_number', ' Phone Number', 'required|is_unique[users.cellphone]');
        }
        if ($this->form_validation->run() == FALSE) {
            $issue_one = form_error("employee_email");
            $issue_two = form_error("phone_number");
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
            $id = $this->input->post('id');
            $string_one_one = str_replace('50', "", $this->input->post('user_imagex'));
            $string_one_one = str_replace('_', "", $string_one_one);
            $_POST['user_imagex'] = $string_one_one;
            $ararra = array(
                'emailaddress' => $this->input->post('employee_email'),
                'password' => $this->input->post('password'),
                'firstname' => $this->input->post('first_name'),
                'lastname' => $this->input->post('last_name'),
                'cellphone' => $this->input->post('phone_number'),
                'employmenttype_id' => $this->input->post('employmenttype_id_employee'),
                'supervisedby' => $this->input->post('supervisor_employee'),
                'category' => $this->input->post('usertype')
            );
//        unset_post($ararra, 'hshs');
            if ($this->input->post('password') == "") {
                unset_post($ararra, 'password');
            }
            if ($this->input->post('employmenttype_id_employee') == "") {
                unset_post($ararra, 'employmenttype_id');
            }
            if ($this->input->post('supervisor_employee') == "") {
                unset_post($ararra, 'supervisedby');
            }
            if ($this->input->post('usertype') == "") {
                unset_post($ararra, 'category');
            }
            $this->updateprofile_subfunc($ararra);
            $json_return = array(
                'report' => "Editted Successfully",
                'status' => 2
            );
            echo json_encode($json_return);
        }
    }

}
