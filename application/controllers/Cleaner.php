<?php

class Cleaner extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('universal_model');
        $this->load->model('user_model', '', TRUE);
        //$this->load->library('image_magician');
    }

    public function index() {
        echo '<h1>Cleaner Api</h1>';
    }

    public function remove_allusersnotloginin() {
        $checkuser = $this->universal_model->selectall('*', 'users');
        $amount_junk = 0;
        foreach ($checkuser as $getperpin) {
            $valueisthere = $this->universal_model->selectz_unqie('*', 'attendencelog', 'pin', $getperpin['pin'], 'pin');
            if (empty($valueisthere)) {
//                print_array($getperpin['pin']);
                $amount_junk++;
                $this->universal_model->updateOnDuplicate('usersjunk', $getperpin);
                $this->universal_model->deletez('users', 'id', $getperpin['id']);
            }
        }
        echo json_encode(array('done' => 'yes', 'amountcleaned' => $amount_junk));
    }

    public function remove_junklogs() {
        $checkuser = $this->universal_model->selectall('*', 'users');
        $amount_junk = 0;
        foreach ($checkuser as $getperpin) {
            $valueisthere = $this->universal_model->selectz_unqie('*', 'trans', 'pin', $getperpin['pin'], 'pin');
            if (empty($valueisthere)) {
//                print_array($getperpin['pin']);
                $amount_junk++;
                $this->universal_model->updateOnDuplicate('usersjunk', $getperpin);
                $this->universal_model->deletez('users', 'id', $getperpin['id']);
            }
        }
        echo json_encode(array('done' => 'yes', 'amountcleaned' => $amount_junk));
    }

}
