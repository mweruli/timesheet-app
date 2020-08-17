<?php

require_once (APPPATH . 'libraries/EditableGrid.php');

class Utilcontroller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('universal_model');
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

    function loadtablesintable($tablename) {
        $grid = new EditableGrid ();
//        $grid->addColumn('id', 'FIELD', 'string', NULL, false);
        $grid->addColumn('tablecolumn', 'FIELD', 'string', NULL, false);
        $grid->addColumn('status', 'HIDE', 'boolean');
        $grid->addColumn('mandatory', 'MANDATORY', 'boolean');
        $result = $this->gettablecolumns($tablename);
        $grid->renderJSON($result, false, false, !isset($_GET ['data_only']));
    }

    function update() {
        $id = $this->input->post('id');
        $value = $this->input->post('newvalue');
        $colname = $this->input->post('colname');
//        $coltype = $this->input->post('coltype');
//           function updatez($variable, $value, $table_name, $updated_values) {
        $arrayupdate = array(
            $colname => $value
        );
        $this->universal_model->updatez('id', $id, 'tablesettings', $arrayupdate);
        echo json_encode('ok');
    }

    function navsettings() {
        $nav_value = $this->input->post('nav_value');
        $_POST['userid'] = $this->session->userdata('logged_in')['user_id'];
        $state = $this->universal_model->updateOnDuplicate('util_navsettings', $_POST);
        $arrayrep = array(
            'status' => 0,
            'message' => 'Successfully Updated'
        );
        echo json_encode($_POST);
    }

}
