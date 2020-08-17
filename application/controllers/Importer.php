<?php

//use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Importer extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('universal_model');
    }

    public function index()
    {
        echo '<h1><b>' . 'Importer' . '</b></h1>';
    }

    public function test_one()
    {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $file = APPPATH . 'meer\ASTD_Bc.XLSX';
        $spreadsheet = $reader->load($file);
        $allDataInSheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        $arrayCount = count($allDataInSheet);
        $flag = 0;
        $createArray = array('empno', 'othernames', 'surname', 'names', 'deptcode', 'empdate', 'termdate', 'bdate', 'idno');
        $makeArray = array('empno' => 'empno', 'othernames' => 'othernames', 'surname' => 'surname', 'names' => 'names', 'deptcode' => 'deptcode', 'empdate' => 'empdate', 'termdate' => 'termdate', 'bdate' => 'bdate', 'idno' => 'idno');
        $SheetDataKey = array();
        foreach ($allDataInSheet as $dataInSheet) {
            foreach ($dataInSheet as $key => $value) {
                if (in_array(trim($value), $createArray)) {
                    $value = preg_replace('/\s+/', '', $value);
                    $SheetDataKey[trim($value)] = $key;
                }
            }
        }
        $dataDiff = array_diff_key($makeArray, $SheetDataKey);
        if (empty($dataDiff)) {
            $flag = 1;
        }
        // match excel sheet column
        if ($flag == 1) {
            for ($i = 2; $i <= $arrayCount; $i++) {
                $empno = $SheetDataKey['empno'];
                $othernames = $SheetDataKey['othernames'];
                $surname = $SheetDataKey['surname'];
                $names = $SheetDataKey['names'];
                $deptcode = $SheetDataKey['deptcode'];
                $empdate = $SheetDataKey['empdate'];
                $termdate = $SheetDataKey['termdate'];
                $bdate = $SheetDataKey['bdate'];
                $idno = $SheetDataKey['idno'];

                $empno = filter_var(trim($allDataInSheet[$i][$empno]), FILTER_SANITIZE_STRING);
                $othernames = filter_var(trim($allDataInSheet[$i][$othernames]), FILTER_SANITIZE_STRING);
                $surname = filter_var(trim($allDataInSheet[$i][$surname]), FILTER_SANITIZE_EMAIL);
                $names = filter_var(trim($allDataInSheet[$i][$names]), FILTER_SANITIZE_STRING);
                $deptcode = filter_var(trim($allDataInSheet[$i][$deptcode]), FILTER_SANITIZE_STRING);
                $empdate = filter_var(trim($allDataInSheet[$i][$empdate]), FILTER_SANITIZE_STRING);
                $termdate = filter_var(trim($allDataInSheet[$i][$termdate]), FILTER_SANITIZE_STRING);
                $bdate = filter_var(trim($allDataInSheet[$i][$bdate]), FILTER_SANITIZE_STRING);
                $idno = filter_var(trim($allDataInSheet[$i][$idno]), FILTER_SANITIZE_STRING);
                $empdaten = date("d-m-Y", strtotime($empdate));
                $bdaten = date("d-m-Y", strtotime($bdate));
                $fetchData[] = array('empno' => $empno, 'othernames' => $othernames, 'surname' => $surname, 'names' => $names, 'deptcode' => $deptcode, 'empdate' => $empdaten, 'termdate' => $termdate, 'bdate' => $bdaten, 'idno' => $idno);
                //                $getnames_array = $this->universal_model->selectz('names', 'attendence_alluserinfo', 'pintwo', $idno);
                //                print_array($names);
                //                print_array('.....');
                //                print_array($getnames_array);
            }
            echo json_encode($fetchData);
        } else {
            echo json_encode("Please import correct file, did not match excel sheet column");
            //            echo "Please import correct file, did not match excel sheet column";
        }
        //        print_array($allDataInSheet);
    }
    function updatepersonbiodata()
    {
        $filetype = $this->input->post('filetype');
        if ($filetype == 2) {
            $this->updatepersonbiodata_payroll();
        } else if ($filetype == 1) {
            $this->updatepersonbiodata_en();
        }
    }
    function updatepersonbiodata_payroll()
    {
        if (!empty($_FILES['fileloader']['name'])) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('fileloader', 'Upload File', 'callback_checkFileValidation');
            if ($this->form_validation->run() == false) {
                echo json_encode(array('state' => 'notok', 'message' => 'Upload CSV/XLSX/XLS Type of File'));
            } else {
                $extension = pathinfo($_FILES['fileloader']['name'], PATHINFO_EXTENSION);
                if ($extension == 'csv') {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
                } elseif ($extension == 'xlsx') {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                } else {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
                }
                $spreadsheet = $reader->load($_FILES['fileloader']['tmp_name']);
                $allDataInSheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
                $flag = 0;
                $arrayCount = count($allDataInSheet);
                $createArray = array('payrollcat', 'idno');
                $makeArray = array('payrollcat' => 'payrollcat', 'idno' => 'idno');
                $SheetDataKey = array();
                foreach ($allDataInSheet as $dataInSheet) {
                    foreach ($dataInSheet as $key => $value) {
                        if (in_array(trim($value), $createArray)) {
                            $value = preg_replace('/\s+/', '', $value);
                            $SheetDataKey[trim($value)] = $key;
                        }
                    }
                }
                $dataDiff = array_diff_key($makeArray, $SheetDataKey);
                if (empty($dataDiff)) {
                    $flag = 1;
                }
                $fetchData = array();
                if ($flag == 1) {
                    $array_letssee = array();
                    for ($i = 2; $i <= $arrayCount; $i++) {
                        $idno = $SheetDataKey['idno'];
                        $payrollcat = $SheetDataKey['payrollcat'];
                        //
                        $idno = filter_var(trim($allDataInSheet[$i][$idno]), FILTER_SANITIZE_STRING);
                        $payrollcat = filter_var(trim($allDataInSheet[$i][$payrollcat]), FILTER_SANITIZE_STRING);
                        $idn = numerify($idno);
                        $valueisthere = $this->universal_model->selectz('*', 'users', 'pin', $idn);
                        $valueisjunck = $this->universal_model->selectz('*', 'usersjunk', 'pin', $idn);
                        if (!empty($valueisthere)) {
                            $this->universal_model->updatez('pin', $idn, 'users', array('payroll_category' => $payrollcat));
                        }
                        if (!empty($valueisjunck)) {
                            $this->universal_model->updatez('pin', $idn, 'usersjunk', array('payroll_category' => $payrollcat));
                        }
                        $added_by = $this->session->userdata('logged_in')['id'];
                        if ($payrollcat != ""  && strlen($payrollcat) == 1) {
                            $this->universal_model->updateOnDuplicate('payroll_categroy', array('name' => $payrollcat, 'addedby' => $added_by));
                        }
                    }
                }
                echo json_encode(array('state' => 'ok', 'message' => 'Payroll Categories Successfully Updated!'));
            }
        } else {
            echo json_encode(array('state' => 'notok', 'message' => 'Please Upload Folder'));
        }
    }
    function updatepersonbiodata_en()
    {
        //        echo json_encode($_POST);
        if (!empty($_FILES['fileloader']['name'])) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('fileloader', 'Upload File', 'callback_checkFileValidation');
            if ($this->form_validation->run() == false) {
                echo json_encode(array('state' => 'notok', 'message' => 'Upload CSV/XLSX/XLS Type of File'));
            } else {
                $extension = pathinfo($_FILES['fileloader']['name'], PATHINFO_EXTENSION);
                if ($extension == 'csv') {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
                } elseif ($extension == 'xlsx') {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                } else {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
                }
                $spreadsheet = $reader->load($_FILES['fileloader']['tmp_name']);
                $allDataInSheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
                $flag = 0;
                $arrayCount = count($allDataInSheet);
                $createArray = array('empno', 'names', 'idno', 'deptcode');
                $makeArray = array('empno' => 'empno', 'names' => 'names', 'idno' => 'idno', 'deptcode' => 'deptcode');
                $SheetDataKey = array();
                foreach ($allDataInSheet as $dataInSheet) {
                    foreach ($dataInSheet as $key => $value) {
                        if (in_array(trim($value), $createArray)) {
                            $value = preg_replace('/\s+/', '', $value);
                            $SheetDataKey[trim($value)] = $key;
                        }
                    }
                }
                $dataDiff = array_diff_key($makeArray, $SheetDataKey);
                if (empty($dataDiff)) {
                    $flag = 1;
                }
                // match excel sheet column
                if ($flag == 1) {
                    $array_letssee = array();
                    for ($i = 2; $i <= $arrayCount; $i++) {
                        $empno = $SheetDataKey['empno'];
                        $names = $SheetDataKey['names'];
                        $idno = $SheetDataKey['idno'];
                        $deptcode = $SheetDataKey['deptcode'];
                        //
                        $empno = filter_var(trim($allDataInSheet[$i][$empno]), FILTER_SANITIZE_STRING);
                        $names = filter_var(trim($allDataInSheet[$i][$names]), FILTER_SANITIZE_STRING);
                        $idno = filter_var(trim($allDataInSheet[$i][$idno]), FILTER_SANITIZE_STRING);
                        $deptcode = filter_var(trim($allDataInSheet[$i][$deptcode]), FILTER_SANITIZE_STRING);
                        // $fetchData[] = array('empno' => $empno, 'names' => $names, 'idno' => $idno,'user_id'=>$empno);
                        $namesarray = explode(' ', $names);
                        $numbernames = count($namesarray);
                        if ($numbernames == 1) {
                            $updatearray = array('staffno' => $empno, 'pin' => $idno, 'department_id' => $deptcode, 'employee_code' => $empno, 'firstname' => $namesarray[0]);
                        } elseif ($numbernames == 2) {
                            $updatearray = array('staffno' => $empno, 'pin' => $idno, 'department_id' => $deptcode, 'employee_code' => $empno, 'firstname' => $namesarray[0], 'lastname' => $namesarray[1]);
                        } elseif ($numbernames == 3) {
                            $updatearray = array('staffno' => $empno, 'pin' => $idno, 'department_id' => $deptcode, 'employee_code' => $empno, 'firstname' => $namesarray[0], 'lastname' => $namesarray[1], 'middlename' => $namesarray[2]);
                        } else {
                            $updatearray = array('staffno' => $empno, 'pin' => $idno, 'department_id' => $deptcode, 'employee_code' => $empno, 'firstname' => $namesarray[0], 'lastname' => $namesarray[1], 'middlename' => $namesarray[2] . ' ' . $namesarray[3]);
                        }
                        //get branch
                        $valueisthere = $this->universal_model->selectz_unqie('*', 'attendencelog', 'pin', $idno, 'pin');
                        if (empty($valueisthere)) {
                            $branch_id = 0;
                            $array_user_adding = array(
                                'user_image_small' => '50_iconuserdefault.png',
                                'user_image_medium' => '60_iconuserdefault.png',
                                'user_image_big' => '500_iconuserdefault.png',
                                'password' => '123456',
                                'cellphone' => '0000000000',
                                'branch_id' => $branch_id
                            );
                            $full_user = array_merge($array_user_adding, $updatearray);
                            $user_id = $this->universal_model->updateOnDuplicate('usersjunk', $full_user);
                            if ($user_id != 0) {
                                $get_user_id = $this->universal_model->selectz(array('id as user_id', 'department_id as id_util_department', 'attendence_shiftdef_id as id_shift_def'), 'users', 'pin', $idno);
                                $this->universal_model->updateOnDuplicate('attendence_util_user_shift', array_shift($get_user_id));
                            }
                        } else {
                            $valueisthere = $this->universal_model->selectz('*', 'util_branch_reader', 'readerserial', array_shift($valueisthere)['serialnumber']);
                            $branch_id = array_shift($valueisthere)['id'];
                            $array_user_adding = array(
                                'user_image_small' => '50_iconuserdefault.png',
                                'user_image_medium' => '60_iconuserdefault.png',
                                'user_image_big' => '500_iconuserdefault.png',
                                'password' => '123456',
                                'cellphone' => '0000000000',
                                'branch_id' => $branch_id
                            );
                            $full_user = array_merge($array_user_adding, $updatearray);
                            $user_id = $this->universal_model->updateOnDuplicate('users', $full_user);
                            if ($user_id != 0) {
                                $get_user_id = $this->universal_model->selectz(array('id as user_id', 'department_id as id_util_department', 'attendence_shiftdef_id as id_shift_def'), 'users', 'pin', $idno);
                                $this->universal_model->updateOnDuplicate('attendence_util_user_shift', array_shift($get_user_id));
                            }
                        }
                        //end get branch
                    }
                    echo json_encode(array('state' => 'ok', 'message' => 'Names Successfully Updated!'));
                } else {
                    echo json_encode(array('state' => 'notok', 'message' => 'Uploaded Filed Has Wrong Formated Headers'));
                }
            }
        } else {
            echo json_encode(array('state' => 'notok', 'message' => 'Please Upload Folder'));
        }
    }

    // checkFileValidation
    public function checkFileValidation($string)
    {
        $file_mimes = array(
            'text/x-comma-separated-values',
            'text/comma-separated-values',
            'application/octet-stream',
            'application/vnd.ms-excel',
            'application/x-csv',
            'text/x-csv',
            'text/csv',
            'application/csv',
            'application/excel',
            'application/vnd.msexcel',
            'text/plain',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        );
        if (isset($_FILES['fileloader']['name'])) {
            $arr_file = explode('.', $_FILES['fileloader']['name']);
            $extension = end($arr_file);
            if (($extension == 'xlsx' || $extension == 'xls' || $extension == 'csv') && in_array($_FILES['fileloader']['type'], $file_mimes)) {
                return true;
            } else {
                //                $this->form_validation->set_message('checkFileValidation', 'Please choose correct file.');
                return false;
            }
        } else {
            //            $this->form_validation->set_message('checkFileValidation', 'Please choose a file.');
            return false;
        }
    }

    public function getdepartmentidbyname()
    {
        $idget = $this->universal_model->select_like('deptname', 'attendence_util_department', 'DEPARTMENT ONE');
        return $idget[0]['id'];
    }

    public function getshiftidbyname()
    {
        $idget = $this->universal_model->select_like('shiftype', 'attendence_shiftdef', 'DAY SHIFT-NORMAL');
        return $idget[0]['id'];
    }
}
