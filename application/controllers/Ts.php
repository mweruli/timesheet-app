<?php

require_once (APPPATH . 'libraries/EditableGrid.php');

class Ts extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('universal_model');
        $this->load->model('user_model', '', TRUE);
    }

    public function index() {
        echo '<h1>Ts Api</h1>';
    }

    public function loadallclients() {
        $whattoselect = array(
            'id',
            'clientname',
            'client_number'
        );
        $allclients = $this->universal_model->selectall($whattoselect, 'client');
        $companies = array();
        foreach ($allclients as $value) {
            $companies [$value ['id']] = $value ['clientname'] . ' | ' . $value ['client_number'];
        }
        // print_array($companies);
        echo json_encode($companies);
    }

    public function testconnection($userid = NULL) {
        $today_date = date("Y-m-d");
        $day_of_week = $this->weekOfMonth($today_date);
        $startcountdate = date("Y-m-d");
        switch ($day_of_week) {
            case 1 :
                $startcountdate = date('Y-m-01');
                break;
            case 2 :
                $startcountdate = date('Y-m-08');
                break;
            case 3 :
                $startcountdate = date('Y-m-15');
                break;
            case 4 :
                $startcountdate = date('Y-m-22');
                break;
            case 5 :
                $startcountdate = date('Y-m-29');
                break;
        }
        // echo $day_of_week;
        // $today_date = date ( "2018-08-01" );
        $datefromnow = date('Y-m-d', strtotime($startcountdate . ' + 13 days'));
        $daterange = getDatesFromRange($startcountdate, $datefromnow);
        $varone = $this->rowwidths($startcountdate, $datefromnow);
        $vartwo = $this->rowwidthstwo($startcountdate, $datefromnow);
        $main_array = array();
        $main_array ['daterange'] = $daterange;
        $main_array ['datename'] = $varone;
        $main_array ['dateabv'] = $vartwo;
        return $main_array;
        // return json_encode($daterange) . '@' . json_encode($varone,true) . '@' . json_encode($vartwo);
    }

    function weekOfMonth($strDate) {
        $dateArray = explode("-", $strDate);
        $date = new DateTime ();
        $date->setDate($dateArray [0], $dateArray [1], $dateArray [2]);
        return floor((date_format($date, 'j') - 1) / 7) + 1;
    }

    function rowwidthstwo($date_from_fot, $date_to_fot) {
        $my_dates = getDatesFromRange($date_from_fot, $date_to_fot);
        $clomun_headertwo = array();
        foreach ($my_dates as $date_value) {
            array_push($clomun_headertwo, date('jS', strtotime($date_value)));
        }
        return $clomun_headertwo;
    }

    function rowwidths($date_from_fot, $date_to_fot) {
        $my_dates = getDatesFromRange($date_from_fot, $date_to_fot);
        $clomun_headertwo = array();
        foreach ($my_dates as $date_value) {
            array_push($clomun_headertwo, date('D', strtotime($date_value)));
        }
        return $clomun_headertwo;
    }

    function loaddata() {
        $_GET ['db_tablename'] = 'timesheet';
        $user_id = $this->session->userdata('logged_in') ['user_id'];
        $grid = new EditableGrid ();
        $grid->addColumn('id', 'ID', 'integer', NULL, false);
        $grid->addColumn('company_id', 'COMPANY', 'string', $this->fetch_pairs_company(), false);
        $grid->addColumn('task_id', 'TASK', 'string', $this->fetch_pairs('task'), false);
        $grid->addColumn('comment', 'COMMENT', 'string(40)');
        $days = $this->testconnection($user_id) ['dateabv'];
        $daterange = $this->testconnection($user_id) ['daterange'];
        foreach ($days as $key => $value) {
            // $dayname = 'datetime' . $key;
            $grid->addColumn($daterange [$key], $value, 'double(1)');
        }
        $grid->addColumn('id_total', 'TOTAL', 'double(h, 1)', NULL, false);
        $grid->addColumn('action', 'Action', 'html', NULL, false, 'id');
        $result = $this->pama($user_id);
        $grid->renderJSON($result, false, false, !isset($_GET ['data_only']));
//        print_array($result);
    }

    function loaddatabysu() {
        $_GET ['db_tablename'] = 'timesheet';
        $user_id = $this->input->post('employee_selecttime');
        $datestart = $this->input->post('state_startdatetime');
        $dateend = $this->input->post('state_enddatetime');
        // $user_id = '6XERNm1n';
        // $datestart = '2019-02-15';
        // $dateend = '2019-02-28';
        $grid = new EditableGrid ();
        $grid->addColumn('id', 'ID', 'integer', NULL, false);
        $grid->addColumn('company_id', 'COMPANY', 'string', $this->fetch_pairs_company(), false);
        $grid->addColumn('task_id', 'TASK', 'string', $this->fetch_pairs('task'), false);
        // $grid->addColumn ( 'comment', 'COMMENT', 'string(40)', false );
        $days = $this->testconnection($user_id) ['dateabv'];
        $daterange = $this->testconnection($user_id) ['daterange'];
        foreach ($days as $key => $value) {
            // $dayname = 'datetime' . $key;
            $grid->addColumn($daterange [$key], $value, 'double(1)');
        }
        $grid->addColumn('id_total', 'TOTAL', 'double(h, 1)', NULL, false);
        $grid->addColumn('admincomment', 'Admin Comment', 'string(60)', false);
        // $grid->addColumn ( 'action', 'Action', 'html', NULL, false, 'id' );
        $result = $this->pama_by_admin($user_id, $datestart, $dateend);
        $grid->renderJSON($result, false, false, !isset($_GET ['data_only']));
    }

    function pama($user_id) {
        // $user_id = $this->session->userdata ( 'logged_in' ) ['user_id'];
        $daterange = $this->testconnection($user_id) ['daterange'];
        $result = $this->universal_model->getrangetimesheet($user_id, $daterange [0], $daterange [sizeof($daterange) - 1]);
        $megaarray = array();
        foreach ($result as $value) {
            $arrayx = array();
            $arrayx ['id'] = $value ['id'];
            $mytimes = $value ['time'];
            $timing = array();
            if ($mytimes != '' || $mytimes != null) {
                $timing = json_decode($mytimes, true);
            }
            foreach ($timing as $key => $valuemm) {
                $arrayx [$key] = $valuemm;
            }
            $arrayx ['company_id'] = $value ['company_id'];
            $arrayx ['task_id'] = $value ['task_id'];
            $arrayx ['comment'] = $value ['comment'];
            $arrayx ['id_total'] = $value ['id_total'];
            // $result = $this->universal_model->updateOnDuplicate('timesheet', array('id_total' => $total));
            array_push($megaarray, $arrayx);
        }
        // print_array ( $megaarray );
        return $megaarray;
    }

    // Maintained For The Pignation
    function loaddatax() {
        $_GET ['db_tablename'] = 'demo';
        $grid = new EditableGrid ();
        $grid->addColumn('id', 'ID', 'integer', NULL, false);
        $grid->addColumn('name', 'Name', 'string');
        $grid->addColumn('firstname', 'Firstname', 'string');
        $grid->addColumn('age', 'Age', 'integer');
        $grid->addColumn('height', 'Height', 'float');
        /* The column id_country and id_continent will show a list of all available countries and continents. So, we select all rows from the tables */
        $grid->addColumn('id_continent', 'Continent', 'string', $this->fetch_pairs('continent'), true);
        $grid->addColumn('id_country', 'Country', 'string', $this->fetch_pairs('country'), true);
        $grid->addColumn('email', 'Email', 'email');
        $grid->addColumn('freelance', 'Freelance', 'boolean');
        $grid->addColumn('lastvisit', 'Lastvisit', 'date');
        $grid->addColumn('website', 'Website', 'string');
        $grid->addColumn('action', 'Action', 'html', NULL, false, 'id');
        $mydb_tablename = (isset($_GET ['db_tablename'])) ? stripslashes($_GET ['db_tablename']) : 'demo';
        error_log(print_r($_GET, true));
        $query = 'SELECT *, date_format(lastvisit, "%d/%m/%Y") as lastvisit FROM ' . $mydb_tablename;
        $queryCount = 'SELECT count(id) as nb FROM ' . $mydb_tablename;
        $totalUnfiltered = $this->db->query($queryCount)->result_array() [0] ['nb'];
        $total = $totalUnfiltered;
        $page = 0;
        if (isset($_GET ['page']) && is_numeric($_GET ['page']))
            $page = (int) $_GET ['page'];
        $rowByPage = 50;
        $from = ($page - 1) * $rowByPage;
        if (isset($_GET ['filter']) && $_GET ['filter'] != "") {
            $filter = $_GET ['filter'];
            $query .= '  WHERE name like "%' . $filter . '%" OR firstname like "%' . $filter . '%"';
            $queryCount .= '  WHERE name like "%' . $filter . '%" OR firstname like "%' . $filter . '%"';
            $total = $this->db->query($queryCount)->result_array() [0] ['nb'];
        }
        if (isset($_GET ['sort']) && $_GET ['sort'] != "")
            $query .= " ORDER BY " . $_GET ['sort'] . ($_GET ['asc'] == "0" ? " DESC " : "");

        $query .= " LIMIT " . $from . ", " . $rowByPage;

        error_log("pageCount = " . ceil($total / $rowByPage));
        error_log("total = " . $total);
        error_log("totalUnfiltered = " . $totalUnfiltered);

        $grid->setPaginator(ceil($total / $rowByPage), (int) $total, (int) $totalUnfiltered, null);
        /* END SERVER SIDE */
        error_log($query);
        $result = $this->db->query($query)->result_array();
        $grid->renderJSON($result, false, false, !isset($_GET ['data_only']));
    }

    public function update() {
        $tablename = $this->input->post('tablename');
        $id = $this->input->post('id');
        $value = $this->input->post('newvalue');
        $colname = $this->input->post('colname');
        $coltype = $this->input->post('coltype');
        if ($coltype == 'double') {
            // More
            if ($value == 'NaN') {
                $value = 0;
            }
            $evaluea = explode('.', $value);
            $evalueafirst = $evaluea [0];
            if ($evalueafirst > 14) {
                echo 'novalidvalue';
            } else if ($value < 0.5 && $value != 0) {
                echo "lessthan";
            } else {
                $chekerz = $this->universal_model->selectz('*', $tablename, 'id', $id);
                if (!empty($chekerz) && $value != 0) {

                    $timechain = $chekerz [0] ['time'];
                    $timechainarray = array();
                    if ($timechain != '' || $timechain != null) {
                        $timechainarray = json_decode($timechain, true);
                    }
                    $timechainarray [$colname] = $value;
                    $total = 0;
                    foreach ($timechainarray as $key => $timevalue) {
                        $total = $total + $timevalue;
                    }
                    $values = array(
                        'time' => json_encode($timechainarray),
                        'id_total' => $total
                    );
                    $return = $this->universal_model->updatez('id', $id, $tablename, $values);
                    if ($return) {
                        echo $total;
                    } else {
                        echo 'error';
                    }
                } else {
                    echo 'nonvalue';
                }
            }
        } else if ($coltype == 'string' && $value != 'NaN') {
            $values = array(
                $colname => $value
            );
            $this->universal_model->updatez('id', $id, $tablename, $values);
            // echo json_encode($values);
            echo 'commentupdate';
        } else {
            echo "ok";
        }
    }

    public function delete() {
        $id = $this->input->post('id');
        $tablename = $this->input->post('tablename');
        // function deletez($table_name, $variable_1, $value_1) {
        $return = $this->universal_model->deletez($tablename, 'id', $id);
        echo $return ? "ok" : "error";
    }

    public function add() {
        $client_id = $this->input->post('client_id');
        $user_task_id = $this->input->post('user_task_id');
        $tablename = $this->input->post('tablename');
        $user_id = $this->session->userdata('logged_in') ['user_id'];
        $arrayinsert = array(
            'user_id' => $user_id,
            'company_id' => $client_id,
            'task_id' => $user_task_id
        );
        $return = $this->universal_model->insertz($tablename, $arrayinsert);
        if ($return > 0) {
            echo 'ok';
        } else {
            echo 'error';
        }
        //
    }

    public function fetch_pairs($table_name) {
        // $table_name = 'continent';
        $allclients = $this->universal_model->selectall('*', $table_name);
        $finalarray = array();
        foreach ($allclients as $value) {
            $finalarray [$value ['id']] = $value ['name'];
        }
        return $finalarray;
        // print_array($finalarray);
    }

    public function fetch_pairs_company() {
        // $table_name = 'continent';
        $arraysele = array(
            'id',
            'clientname',
            'client_number'
        );
        $allclients = $this->universal_model->selectall($arraysele, 'client');
        $finalarray = array();
        foreach ($allclients as $value) {
            $finalarray [$value ['id']] = $value ['clientname'] . ' @ ' . $value ['client_number'];
        }
        return $finalarray;
        // print_array($finalarray);
    }

    // To Move To UTIL CONTROLLER
    public function once_run_companytasknot() {
        $querypermutation = 'SELECT task.id as taskid, client.id as clientid from task JOIN client ON task.id!=client.id';
        $permutation = $this->db->query($querypermutation)->result_array();
        // print_array($permutation);
        return $permutation;
        // $array_finalnot=array_unique($permutation,SORT_REGULAR); #True Permitation
    }

    public function once_run_companytask() {
        $querypermutation = 'SELECT task.id as taskid, client.id as clientid from task JOIN client ON task.id=client.id';
        $permutation = $this->db->query($querypermutation)->result_array();
        // print_array($permutation);
        return $permutation;
        // print_array($permutation);
    }

    public function initialtaskcombinationinsert() {
        $this->db->trans_start();
        $this->db->insert_batch('util_clienttask', $this->once_run_companytask());
        $this->db->insert_batch('util_clienttask', $this->once_run_companytasknot());
        $this->db->trans_complete();
    }

    public function getreportbyclienttask() {
        $client_name = $this->input->post('gettaskname');
        $client_id = $this->input->post('getclientid');
        // $client_name = "Dominic";
        // $client_id = 2;
        $task_id = $this->input->post('gettaskid');
        $daterange = $this->testconnection() ['daterange'];
        $firstrange = $daterange [0];
        $lastdaterange = $daterange [count($daterange) - 1];
        $stringrange = 'DATE_FORMAT(dateinserted,"%Y-%m-%d") BETWEEN "' . $firstrange . '" and "' . $lastdaterange . '"';
        $selectbyclienttime = $this->universal_model->selectzy_var('*', 'timesheet', 'company_id', $client_id, 'task_id', $task_id, $stringrange);
        foreach ($selectbyclienttime as $key => $value) {
            $userdetails = $this->get_userbyid($value ['user_id']);
            $selectbyclienttime [$key] ['user_email'] = $userdetails ['user_email'];
            $selectbyclienttime [$key] ['occupation'] = $userdetails ['occupation'];
            $selectbyclienttime [$key] ['firstname'] = $userdetails ['firstname'];
            $selectbyclienttime [$key] ['lastname'] = $userdetails ['lastname'];
            $selectbyclienttime [$key] ['rateamount'] = $userdetails ['rateamount'];
            $selectbyclienttime [$key] ['contact'] = $userdetails ['contact'];
        }
        if (empty($selectbyclienttime)) {
            $json_return = array(
                'report' => "No Report Found For This Client Task Combination",
                'status' => 0
            );
            echo json_encode($json_return);
        } else {
            $json_return = array(
                'report' => "Report For Client/Task " . $client_name,
                'status' => 1,
                'data' => $this->timePerClientTaskReport($selectbyclienttime, $client_name)
            );
            echo json_encode($json_return);
        }
    }

    public function getreportperstaff() {
        $userid = $this->input->post('userid');
        $client_id = $this->input->post('clientid');
        $client_name = $this->input->post('usernames');
        // $client_name = "Dominic";
        // $client_id = 2;
        $task_id = $this->input->post('gettaskid');
        $daterange = $this->testconnection() ['daterange'];
        $firstrange = $daterange [0];
        $lastdaterange = $daterange [count($daterange) - 1];
        $stringrange = 'DATE_FORMAT(dateinserted,"%Y-%m-%d") BETWEEN "' . $firstrange . '" and "' . $lastdaterange . '"';
        $selectbyclienttime = $this->universal_model->selectzy_var('*', 'timesheet', 'company_id', $client_id, 'user_id', $userid, $stringrange);
        foreach ($selectbyclienttime as $key => $value) {
            $userdetails = $this->get_userbyid($value ['user_id']);
            $selectbyclienttime [$key] ['user_email'] = $userdetails ['user_email'];
            $selectbyclienttime [$key] ['occupation'] = $userdetails ['occupation'];
            $selectbyclienttime [$key] ['firstname'] = $userdetails ['firstname'];
            $selectbyclienttime [$key] ['lastname'] = $userdetails ['lastname'];
            $selectbyclienttime [$key] ['rateamount'] = $userdetails ['rateamount'];
            $selectbyclienttime [$key] ['contact'] = $userdetails ['contact'];
            $selectbyclienttime [$key] ['taskname'] = $this->get_taskbyid($value ['task_id']);
        }
        if (empty($selectbyclienttime)) {
            $json_return = array(
                'report' => "No Report Found For  Client/Staff In This Range ",
                'status' => 0
            );
            echo json_encode($json_return);
        } else {
            $json_return = array(
                'report' => "Report For Client/Staff " . $client_name,
                'status' => 1,
                'data' => $this->timePerClientStaff($selectbyclienttime, $client_name)
            );
            echo json_encode($json_return);
        }
        // echo json_encode ( $_POST );
        // print_array($selectbyclienttime);
    }

    public function getreportbyclient() {
        // $user_id = $this->session->userdata ( 'logged_in' ) ['user_id'];
        $client_name = $this->input->post('selectclientname');
        $client_id = $this->input->post('selectclientid');
        $daterange = $this->testconnection() ['daterange'];
        $firstrange = $daterange [0];
        $lastdaterange = $daterange [count($daterange) - 1];
        $stringrange = 'DATE_FORMAT(dateinserted,"%Y-%m-%d") BETWEEN "' . $firstrange . '" and "' . $lastdaterange . '"';
        $selectbyclienttime = $this->universal_model->selectz_var('*', 'timesheet', 'company_id', $client_id, $stringrange);
        foreach ($selectbyclienttime as $key => $value) {
            $userdetails = $this->get_userbyid($value ['user_id']);
            $selectbyclienttime [$key] ['user_email'] = $userdetails ['user_email'];
            $selectbyclienttime [$key] ['occupation'] = $userdetails ['occupation'];
            $selectbyclienttime [$key] ['firstname'] = $userdetails ['firstname'];
            $selectbyclienttime [$key] ['lastname'] = $userdetails ['lastname'];
            $selectbyclienttime [$key] ['rateamount'] = $userdetails ['rateamount'];
            $selectbyclienttime [$key] ['contact'] = $userdetails ['contact'];
            $selectbyclienttime [$key] ['taskname'] = $this->get_taskbyid($value ['task_id']);
            // print_array ( $userdetails );
        }
        // return $selectbyclienttime;
        // print_array ( $selectbyclienttime );
        if (empty($selectbyclienttime)) {
            $json_return = array(
                'report' => "No Report Found For This Client In This Range ",
                'status' => 0
            );
            echo json_encode($json_return);
        } else {
            $json_return = array(
                'report' => "Report For Client " . $client_name,
                'status' => 1,
                'data' => $this->timePerClientReport($selectbyclienttime, $client_name)
            );
            echo json_encode($json_return);
        }
    }

    public function get_taskbyid($id) {
        $selectget = $this->universal_model->selectz('*', 'task', 'id', $id);
        // print_array($selectget);
        return $selectget [0] ['name'];
    }

    public function get_userbyid($id) {
        $selectget = $this->universal_model->selectz('user_email,occupation,firstname,lastname,contact', 'users', 'user_id', $id);
        $selectget [0] ['rateamount'] = $this->get_employeepricecloned($id);
        $selectget [0] ['occupation'] = $this->get_employeepriceoccu($id);
        return $selectget [0];
    }

    function get_employeepricecloned($id) {
        $array_what = array(
            'rateamount'
        );
        $vara = $this->universal_model->joinemplyeeoccupation($id, $array_what);
        return $vara [0] ['rateamount'];
    }

    function get_employeepriceoccu($id) {
        $array_what = array(
            'design'
        );
        $vara = $this->universal_model->joinemplyeeoccupation($id, $array_what);
        return $vara [0] ['design'];
    }

    function timePerClientStaff($test_datacard, $client_name) {
        $edit_cell = array(
            'class' => "hidden-xs intro",
            'style' => "background-color: lightpink"
        );
        $template = array(
            'table_open' => '<table class="table table-hover" id="timecostbyclientstaff">',
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
        $cell = array(
            'data' => '<h4>' . $client_name . '</h4>',
            'class' => 'highlight',
            'colspan' => 4
        );
        $cell1 = array(
            'data' => 'SHAH AND ASSOCIATES',
            'colspan' => 8
        );
        $this->table->set_heading($cell1, $cell);
        $totaltime = 0;
        foreach ($test_datacard as $_cardtest) {
            // End For Cals
            $timedates = $_cardtest ['time'];
            $timeasis = json_decode($timedates, true);
            // print_array($timeasis);
            $stingtime = '';
            foreach ($timeasis as $key => $time) {
                $stingtime .= $key . ' | ' . $time . 'hrs' . ' , ';
            }
            $stingtimen = array(
                'data' => $stingtime,
                'colspan' => 12
            );
            // echo $stingtime;
            $calu = $_cardtest ['id_total'] * $_cardtest ['rateamount'];
            $this->table->add_row('<b>Task</b>', '<h4><b>' . $_cardtest ['taskname'] . '<b></h4>', '', '', '', '', '', '', '', '');
            $this->table->add_row('<b>Contacts</b>', '<b>' . $_cardtest ['contact'] . '</b>', '<b>' . $_cardtest ['user_email'] . '</b>', '<b>' . $_cardtest ['occupation'] . '</b>');
            $this->table->add_row('Date|Time', $stingtime);
            $this->table->add_row('Comments', $_cardtest ['comment']);
            $this->table->add_row('Total Time', $_cardtest ['id_total']);
            $this->table->add_row('Occupation/Rate Amount', $_cardtest ['rateamount']);
            // $this->table->add_row ( 'Expected Compition Date', $_cardtest ['enddate'] );
            $this->table->add_row('Total Amount Per Task', $calu);
            $totaltime += $calu;
        }
        $celltotal = array(
            'data' => '<h3>Total Amount Of Staff</h3>',
            'colspan' => 6
        );
        $this->table->add_row($celltotal, '<h3>' . $totaltime . '</h3>');
        return $this->table->generate();
    }

    function timePerClientReport($test_datacard, $client_name) {
        $edit_cell = array(
            'class' => "hidden-xs intro",
            'style' => "background-color: lightpink"
        );
        $template = array(
            'table_open' => '<table class="table table-hover" id="timecostbyclient">',
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
        $cell = array(
            'data' => '<h4>' . $client_name . '</h4>',
            'class' => 'highlight',
            'colspan' => 6
        );
        $cell1 = array(
            'data' => 'SHAH AND ASSOCIATES',
            'colspan' => 6
        );
        $this->table->set_heading($cell1, $cell);
        $totaltime = 0;
        foreach ($test_datacard as $_cardtest) {
            // End For Cals
            $timedates = $_cardtest ['time'];
            $timeasis = json_decode($timedates, true);
            // print_array($timeasis);
            $stingtime = '';
            foreach ($timeasis as $key => $time) {
                $stingtime .= $key . ' | ' . $time . 'hrs' . ' , ';
            }
            $stingtimen = array(
                'data' => $stingtime,
                'colspan' => 12
            );
            // echo $stingtime;
            $calu = $_cardtest ['id_total'] * $_cardtest ['rateamount'];
            $this->table->add_row('<b>Person</b>', '<h4><b>' . $_cardtest ['firstname'] . ' ' . $_cardtest ['lastname'] . '<b></h4>', '', '', '', '', '', '', '', '');
            $this->table->add_row('<b>Contacts</b>', '<b>' . $_cardtest ['contact'] . '</b>', '<b>' . $_cardtest ['user_email'] . '</b>', '<b>' . $_cardtest ['occupation'] . '</b>');
            $this->table->add_row('Task', $_cardtest ['taskname'], '', '', '', '', '', '', '', '');
            $this->table->add_row('Date|Time', $stingtime);
            $this->table->add_row('Comments', $_cardtest ['comment']);
            $this->table->add_row('Total Time', $_cardtest ['id_total']);
            $this->table->add_row('Occupation/Rate Amount', $_cardtest ['rateamount']);
            // $this->table->add_row ( 'Expected Compition Date', $_cardtest ['enddate'] );
            $this->table->add_row('Total Amount Per Task', $calu);
            $totaltime += $calu;
        }
        $celltotal = array(
            'data' => '<h3>Total Amount On Client</h3>',
            'colspan' => 6
        );
        $this->table->add_row($celltotal, '<h3>' . $totaltime . '</h3>');
        return $this->table->generate();
    }

    function timePerClientTaskReport($test_datacard, $taskname) {
        $edit_cell = array(
            'class' => "hidden-xs intro",
            'style' => "background-color: lightpink"
        );
        $template = array(
            'table_open' => '<table class="table table-hover" id="costclienttaskcomb">',
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
        $cell = array(
            'data' => '<h4>' . $taskname . '</h4>',
            'class' => 'highlight',
            'colspan' => 6
        );
        $cell1 = array(
            'data' => 'SHAH AND ASSOCIATES',
            'colspan' => 6
        );
        $this->table->set_heading($cell1, $cell);
        $totaltime = 0;
        foreach ($test_datacard as $_cardtest) {
            // End For Cals
            $timedates = $_cardtest ['time'];
            $timeasis = json_decode($timedates, true);
            // print_array($timeasis);
            $stingtime = '';
            foreach ($timeasis as $key => $time) {
                $stingtime .= $key . ' | ' . $time . 'hrs' . ' , ';
            }
            $stingtimen = array(
                'data' => $stingtime,
                'colspan' => 12
            );
            // echo $stingtime;
            $calu = $_cardtest ['id_total'] * $_cardtest ['rateamount'];
            $this->table->add_row('<b>Person</b>', '<h4><b>' . $_cardtest ['firstname'] . ' ' . $_cardtest ['lastname'] . '<b></h4>', '', '', '', '', '', '', '', '');
            $this->table->add_row('<b>Contacts</b>', '<b>' . $_cardtest ['contact'] . '</b>', '<b>' . $_cardtest ['user_email'] . '</b>', '<b>' . $_cardtest ['occupation'] . '</b>');
            $this->table->add_row('Date|Time', $stingtime);
            $this->table->add_row('Comments', $_cardtest ['comment']);
            $this->table->add_row('Total Time', $_cardtest ['id_total']);
            $this->table->add_row('Occupation/Rate Amount', $_cardtest ['rateamount']);
            // $this->table->add_row ( 'Expected Compition Date', $_cardtest ['enddate'] );
            $this->table->add_row('Total Amount Per Person', $calu);
            $totaltime += $calu;
        }
        $celltotal = array(
            'data' => '<h3>Total Amount On Task</h3>',
            'colspan' => 6
        );
        $this->table->add_row($celltotal, '<h3>' . $totaltime . '</h3>');
        return $this->table->generate();
    }

    public function pama_by_admin($user_id, $datestart, $dateend) {
        $daterange = getDatesFromRange($datestart, $dateend);
        // foreach ( array_keys ( $daterange, '2019-02-16', true ) as $key ) {
        // unset ( $daterange [$key] );
        // }
        $selectget = $this->universal_model->selectz('*', 'timesheet', 'user_id', $user_id);
        $availabletimesheet = array();
        foreach ($selectget as $key => $valueem) {
            $array_date = json_decode($valueem ['time'], true);
            $am = array_intersect_key($array_date, array_flip($daterange));
            if (!empty($am)) {
                $arraypertime = array(
                    'id' => $valueem ['id'],
                    // 'user_id' => $valueem ['user_id'],
                    'company_id' => $valueem ['company_id'],
                    'task_id' => $valueem ['task_id'],
                    'comment' => $valueem ['comment'],
                    'id_total' => $valueem ['id_total']
                        // 'dateinserted' => $valueem ['dateinserted']
                );
                foreach ($am as $key => $valuedate) {
                    $arraypertime [$key] = $valuedate;
                }
                array_push($availabletimesheet, $arraypertime);
            }
        }
        return $availabletimesheet;
        // print_array ( );
    }

}
