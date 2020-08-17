<?php

class Universal_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->dbutil();
    }

    function select_like($columnname, $table_n, $value)
    {
        $this->db->like($columnname, $value);
        $this->db->from($table_n);
        $query = $this->db->get()->result_array();
        return $query;
    }

    function count_all_table($table_name)
    {
        return $this->db->count_all($table_name);
    }

    function selectall($array_table_n, $table_n)
    {
        $this->db->select($array_table_n);
        $this->db->from($table_n);
        $query = $this->db->get()->result_array();
        return $query;
    }

    function selectall_var($array_table_n, $table_n, $stringvariable)
    {
        $this->db->select($array_table_n);
        $this->db->from($table_n);
        $this->db->where($stringvariable);
        $query = $this->db->get()->result_array();
        return $query;
    }

    function selectzwherenot($array_table_n, $table_n, $leftout)
    {
        $this->db->select($array_table_n);
        $this->db->from($table_n);
        $this->db->where('category!=', $leftout);
        $query = $this->db->get()->result_array();
        return $query;
    }

    function selectz($array_table_n, $table_n, $variable_1, $value_1)
    {
        $this->db->select($array_table_n);
        $this->db->from($table_n);
        $this->db->where($variable_1, $value_1);
        $query = $this->db->get()->result_array();
        return $query;
    }

    function selectz_var($array_table_n, $table_n, $variable_1, $value_1, $stringvariable)
    {
        $this->db->select($array_table_n);
        $this->db->from($table_n);
        $this->db->where($variable_1, $value_1);
        $this->db->where($stringvariable);
        $query = $this->db->get()->result_array();
        return $query;
    }

    // newer
    function selectzjoin_with_supervisors($array_table_n)
    {
        $this->db->select($array_table_n);
        $this->db->from('users a');
        $this->db->join('util_setting b', 'b.id=a.occupation', 'left');
        $this->db->where('a.category', 'employee');
        $query = $this->db->get()->result_array();
        return $query;
    }

    //Implementing Views
    function selectjoinemployeetable($array_table_n)
    {
        $this->db->select($array_table_n);
        $this->db->from('users e');
        $this->db->join('attendence_alluserinfo c', 'c.pintwo=e.pin', 'left');
        $this->db->join('util_branch_reader b', 'b.readerserial=c.serialnumber', 'left');
        $this->db->join('employementtypes m', 'm.id=e.employmenttype_id', 'left');
        $query = $this->db->get()->result_array();
        return $query;
    }

    function join_getbranchcompany($array_table_n)
    {
        $this->db->select($array_table_n);
        $this->db->from('branches b');
        $this->db->join('company c', 'c.id=b.id_company', 'left');
        $query = $this->db->get()->result_array();
        return $query;
    }

    function join_getregioncompany($array_table_n)
    {
        $this->db->select($array_table_n);
        $this->db->from('regions b');
        $this->db->join('company c', 'c.id=b.id_company', 'left');
        $query = $this->db->get()->result_array();
        return $query;
    }

    function join_getdepartments($array_table_n)
    {
        $this->db->select($array_table_n);
        $this->db->from('departments d');
        $this->db->join('company c', 'c.id=d.id_company', 'left');
        $query = $this->db->get()->result_array();
        return $query;
    }

    function join_manualallowances($array_table_n)
    {
        $this->db->select($array_table_n);
        $this->db->from('manualallowences m');
        $this->db->join('allowances a', 'a.id=m.allowances_id', 'left');
        $this->db->join('users u', 'u.pin=m.userpin', 'left');
        $query = $this->db->get()->result_array();
        return $query;
    }

    function join_advancededuc($array_table_n)
    {
        $this->db->select($array_table_n);
        $this->db->from('advanceddeduction m');
        $this->db->join('users u', 'u.pin=m.userpin', 'left');
        $query = $this->db->get()->result_array();
        return $query;
    }

    function join_getstation($array_table_n)
    {
        $this->db->select($array_table_n);
        $this->db->from('stations s');
        $this->db->join('regions r', 'r.id=s.id_region', 'left');
        $this->db->join('company c', 'c.id=r.id_company', 'left');
        $query = $this->db->get()->result_array();
        return $query;
    }

    function join_getsection($array_table_n)
    {
        $this->db->select($array_table_n);
        $this->db->from('sections s');
        $this->db->join('departments d', 'd.id=s.id_department', 'left');
        $this->db->join('company c', 'c.id=d.id_company', 'left');
        $query = $this->db->get()->result_array();
        return $query;
    }

    function join_getbankbranches($array_table_n)
    {
        $this->db->select($array_table_n);
        $this->db->from('bankbranches b');
        $this->db->join('banks bb', 'bb.id=b.id_bank', 'left');
        $query = $this->db->get()->result_array();
        return $query;
    }

    function selectz_pigination($table_n, $variable_1, $value_1, $limit, $start)
    {
        $this->db->limit($limit, $start);
        // $this->db->select($array_table_n);
        $this->db->from($table_n);
        $this->db->where($variable_1, $value_1);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function fetch_tables_limit($limit, $start, $tablename)
    {
        $this->db->limit($limit, $start);
        $query = $this->db->get($tablename);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    function selectzwherein($array_table_n, $table_n, $variable_1)
    {
        $this->db->select($array_table_n);
        $this->db->from($table_n);
        // $this->db->like($variable_1);
        $this->db->where('STR_TO_DATE(date_done_task, "%Y-%m-%d") =', $variable_1);
        $query = $this->db->get()->result_array();
        return $query;
    }

    function selectzy($array_table_n, $table_n, $variable_1, $value_1, $variable_2, $value_2)
    {
        $this->db->select($array_table_n);
        $this->db->from($table_n);
        $this->db->where($variable_1, $value_1);
        $this->db->where($variable_2, $value_2);
        $query = $this->db->get()->result_array();
        // $sql = $this->db->last_query();
        return $query;
    }

    function selectzy_var($array_table_n, $table_n, $variable_1, $value_1, $variable_2, $value_2, $stringvariable)
    {
        $this->db->select($array_table_n);
        $this->db->from($table_n);
        $this->db->where($variable_1, $value_1);
        $this->db->where($variable_2, $value_2);
        $this->db->where($stringvariable);
        $query = $this->db->get()->result_array();
        // $sql = $this->db->last_query();
        return $query;
    }

    function non_selectzy($array_table_n, $table_n, $variable_1, $value_1, $variable_2, $value_2)
    {
        $this->db->select($array_table_n);
        $this->db->from($table_n);
        $this->db->where($variable_1, $value_1);
        // $this->db->where_not_in($variable_2, $value_2);
        $this->db->where($variable_2, $value_2);
        $query = $this->db->get()->result_array();
        return $query;
    }

    function selectzuniquei($distinct, $table_n, $variable_1, $value_1)
    {
        $this->db->select('*');
        $this->db->group_by($distinct);
        $this->db->from($table_n);
        $this->db->where($variable_1, $value_1);
        $query = $this->db->get();
        return $query->result_array();
    }

    function selectzuniquei_foruserclock($distinct, $table_n, $variable_1, $value_1, $value_2)
    {
        $this->db->select('*');
        $this->db->group_by($distinct);
        $this->db->from($table_n);
        $this->db->where($variable_1, $value_1);
        $this->db->like('exactdate', $value_2);
        $query = $this->db->get();
        return $query->result_array();
    }

    function selectzunique($distinct, $table_n, $variable_1, $value_1)
    {
        $this->db->distinct($distinct);
        $this->db->from($table_n);
        $this->db->where($variable_1, $value_1);
        $query = $this->db->get()->result_array();
        return $query;
    }

    //NEW START
    function payslipjoin($pin)
    {
        $this->db->select("u.staffno,u.firstname,u.lastname,d.department,c.code,c.description,j.jobgrade,jo.jobgroup,uc.amount,u.basicpay,c.signnote");
        $this->db->from('users u');
        $this->db->join('user_customeaddition uc', 'uc.user_pin=u.pin', 'left');
        $this->db->join('customparams c', 'c.id=uc.id_customdeduct', 'left');
        $this->db->join('departments d', 'd.id=u.department_id', 'left');
        $this->db->join('jobgrades j', 'j.id=u.jobgrade_id', 'left');
        $this->db->join('jobgroups jo', 'jo.id=u.jobgroup_id', 'left');
        $this->db->where("u.pin", $pin);
        //        $this->db->group_by('a.project_id');
        $query = $this->db->get()->result_array();
        return $query;
    }

    function selectzx($array_table_n, $table_n, $variable_1, $value_1, $variable_2, $value_2, $variable_3, $value_3)
    {
        $this->db->select($array_table_n);
        $this->db->from($table_n);
        $this->db->where($variable_1, $value_1);
        $this->db->where($variable_2, $value_2);
        $this->db->where($variable_3, $value_3);
        $query = $this->db->get()->result_array();
        return $query;
    }

    function selectzxpp($array_table_n, $table_n, $variable_1, $value_1, $variable_2, $value_2, $variable_3, $value_3)
    {
        $this->db->select($array_table_n);
        $this->db->from($table_n);
        $this->db->where($variable_1, $value_1);
        $this->db->where($variable_2, $value_2);
        $this->db->like($variable_3, $value_3);
        $query = $this->db->get()->result_array();
        return $query;
    }

    function deletez($table_name, $variable_1, $value_1)
    {
        return $this->db->delete($table_name, array(
            $variable_1 => $value_1
        ));
        // return $this->db->affected_rows();
    }

    function deletezm($table_name, $variable_1, $value_1, $variable_2, $value_2)
    {
        $this->db->delete($table_name, array(
            $variable_1 => $value_1,
            $variable_2 => $value_2
        ));
    }

    function deletezn($table_name, $variable_1, $value_1, $variable_2, $value_2, $variable_3, $value_3)
    {
        $this->db->delete($table_name, array(
            $variable_1 => $value_1,
            $variable_2 => $value_2,
            $variable_3 => $value_3
        ));
    }

    function insertz($table_name, $array_value)
    {
        $this->db->insert($table_name, $array_value);
        return $this->db->insert_id();
    }

    function insertzwhere($table_name, $array_value)
    {
        $this->db->insert($table_name, $array_value);
        return $this->db->insert_id();
    }

    function updatez($variable, $value, $table_name, $updated_values)
    {
        $this->db->where($variable, $value);
        return $this->db->update($table_name, $updated_values);
    }

    function updatem($variable, $value, $variable1, $value1, $table_name, $updated_values)
    {
        $this->db->where($variable, $value);
        $this->db->where($variable1, $value1);
        $this->db->update($table_name, $updated_values);
        return $this->db->affected_rows();
    }

    function updatep($variable, $value, $variable1, $value1, $variable2, $value2, $table_name, $updated_values)
    {
        $this->db->where($variable, $value);
        $this->db->where($variable1, $value1);
        $this->db->where($variable2, $value2);
        $response = $this->db->update($table_name, $updated_values);
    }

    public function joinonetotalcost($whattoselect, $taskdone)
    {
        $this->db->select($whattoselect)->where('task_workedone', $taskdone)->
            // ->where('taken', $variable)
            from('project_update')->join('users', 'project_update.user_id=users.user_id');
        $result = $this->db->get()->result_array();
        return $result;
    }

    public function joinreportclient($user_id)
    {
        $this->db->select("a.project_id as identi_project,project_name");
        $this->db->from('project_update a');
        $this->db->join('project_milestone b', 'b.project_id=a.project_id', 'left');
        $this->db->where('a.user_id', $user_id);
        // Last Minute
        // $this->db->where('b.closed', 1);
        $this->db->group_by('a.project_id');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function joinloanreduction($userpin, $loanstate)
    {
        $this->db->select('a.currnetbalance,l.ainterestrate');
        $this->db->from('appliedloans a');
        $this->db->join('loantypes l', 'l.id=a.loantypes_id', 'left');
        $this->db->where('a.userpin', $userpin);
        $this->db->where('a.loanstate', $loanstate);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function joinemplyeeoccupation($user_id, $whattoselect)
    {
        $this->db->select($whattoselect)->where('user_id', $user_id)->from('util_setting')->join('users', 'util_setting.id=users.occupation');
        $result = $this->db->get()->result_array();
        return $result;
    }

    function product_getTonotify($array_table_n, $item_id, $sellstate)
    {
        $this->db->select($array_table_n);
        $this->db->from('user');
        $this->db->join('item', 'item.user_id =user.id');
        $this->db->like('itemname', $item_id, 'both');
        // $this->db->join('user', 'user.id =item.user_id');
        $this->db->where('state_buy_sell', $sellstate);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function record_count($name_table)
    {
        return $this->db->count_all($name_table);
    }

    public function fetch_standard_table($limit, $start, $table_name)
    {
        $this->db->limit($limit, $start);
        $query = $this->db->get($table_name);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function replace($tablename, $arrayvalues)
    {
        $this->db->replace($tablename, $arrayvalues);
    }

    public function updateOnDuplicate($table, $data)
    {
        if (empty($table) || empty($data))
            return false;
        $duplicate_data = array();
        foreach ($data as $key => $value) {
            $duplicate_data[] = sprintf("%s='%s'", $key, mssql_escape($value));
        }
        $sql = sprintf("%s ON DUPLICATE KEY UPDATE %s", $this->db->insert_string($table, $data), implode(',', $duplicate_data));
        $this->db->query($sql);
        return $this->db->insert_id();
    }

    public function updateOnDuplicatetimesheet($datetime, $user_id, $company_id, $task_id, $comment, $time)
    {
        $sql = 'INSERT INTO timesheet (datetime, user_id, company_id, task_id,comment,time)
        VALUES (?, ?, ?, ?,?,?)
        ON DUPLICATE KEY UPDATE
            time=time+time;';
        $query = $this->db->query($sql, array(
            $datetime,
            $user_id,
            $company_id,
            $task_id,
            $comment,
            $time
        ));
        return $this->db->insert_id();
    }

    public function getrangetimesheet($user_id, $from_from, $to_to)
    {
        $this->db->select('*');
        $this->db->from('timesheet a');
        $this->db->where('a.user_id', $user_id);
        // $this->db->where("DATE_FORMAT(a.datetime,'%Y-%m-%d')>=", $from_from);
        // $this->db->where("DATE_FORMAT(a.datetime,'%Y-%m-%d')<=", $to_to);
        $this->db->order_by("a.id");
        $query = $this->db->get();
        $dataperuser = $query->result_array();
        // $mega = array_chunk($dataperuser, 14);
        return $dataperuser;
    }

    function selectallarray($array_table_n, $table_n)
    {
        // print_array($array_table_n);
        // $this->db->select($whatselect);
        $this->db->where($array_table_n);
        $this->db->from($table_n);
        $query = $this->db->get()->result_array();
        return $query;
    }

    function selectclienttasknotselectedone($user_id)
    {
        $this->db->select('c.id as cid,c.clientname,c.client_number,t.id as tid,ta.name');
        $this->db->from('timesheet t');
        $this->db->join('client c', 'c.id=t.company_id');
        $this->db->join('task ta', 'ta.id=t.task_id');
        $this->db->where('t.user_id', $user_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    function selectclienttasknotselectedtwo()
    {
        $this->db->select('c.id as cid,c.clientname,c.client_number,t.id as tid,t.name');
        $this->db->from('util_clienttask u');
        $this->db->join('task t', 't.id=u.taskid', 'left');
        $this->db->join('client c', 'c.id=u.clientid', 'left');
        // $this->db->join ( 'util_clienttask un', 'un.taskid=ta.id', 'left' );
        // $this->db->where ( 't.user_id', $user_id );
        // $this->db->where ( 't.task_id', NULL );
        $query = $this->db->get();
        return $query->result_array();
    }

    function testcheckinjson()
    {
        $this->db->select('*');
        $this->db->from('timesheet a');
        $this->db->where_in('time', '2019-02-15');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function liasebranc($pin)
    {
        $this->db->select('b.id as branchid');
        $this->db->from('util_branch_reader b');
        $this->db->join('attendence_alluserinfo a', 'a.serialnumber=b.readerserial', 'left');
        $this->db->where('a.pintwo', $pin);
        $this->db->order_by('a.dateadded', 'desc');
        $query = $this->db->get()->result_array();
        if (!empty($query)) {
            return $query[0];
        } else {
            return $query;
        }
    }

    public function util_branch_reader($type = null)
    {
        //        $where_dateclock = "a.dateclock LIKE '%" . $daterangeone . "%' and u.employmenttype_id=2";
        $this->db->select('b.branchname,b.readerserial,u.pin as userpin,CONCAT(u.firstname," ",u.lastname," ",u.middlename) as names');
        $this->db->from('users u');
        $this->db->join('util_branch_reader b', 'b.id=u.branch_id', 'left');
        $this->db->where('u.slug!=', 1);
        if ($type != null) {
            switch ($type) {
                case 'p':
                    $this->db->where('u.employmenttype_id', 2);
                    break;
                default:
                    break;
            }
        }
        $this->db->order_by('names asc');
        $query = $this->db->get()->result_array();
        $output = array_reduce($query, function (array $carry, array $item) {
            $city = $item['branchname'];
            if (array_key_exists($city, $carry)) {
                //                $carry [$city] ['names'] .= '@' . $this->nameaffair($item ['names'], $item ['firstname'], $item ['lastname'], $item ['middlename']);
                $carry[$city]['userpin'] .= '@' . $item['userpin'];
                $carry[$city]['names'] .= '@' . $item['names'];
                // CreatedArrays Virtual
            } else {
                $carry[$city] = $item;
            }
            return $carry;
        }, array());
        return array_values($output);
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

    function getlastrow($tablename)
    {
        $row = $this->db->get($tablename)->last_row();
        // print_array($row);
        // $last_row = $this->db->select('employee_code')->order_by('employee_code', "desc")->limit(1)->get($tablename)->result_array();
        return $row;
    }

    function getlastrowusers($tablename)
    {
        // $row = $this->db->get($tablename)->last_row();
        // print_array($row);
        $last_row = $this->db->select('employee_code')->order_by('employee_code', "desc")->limit(1)->get($tablename)->result_array();
        return $last_row;
    }

    //Needs Revisiting
    function attendence_cardnewtrans($serialnumberone, $daterangetwo, $daterangeone, $employeerangeone, $employeerangetwo, $pin, $payrollcat = NULL)
    {
        if ($employeerangeone == $employeerangetwo && $employeerangetwo != "") {
            $this->db->where("LEFT (b.firstname, 1) = '" . $employeerangetwo . "'");
            // $query = $this->db->query('select * ');
        } elseif ($employeerangeone != $employeerangetwo && $employeerangetwo != "") {
            $where_employee_code = " LEFT (b.firstname, 1) >= '" . $employeerangeone . "' AND LEFT (b.firstname, 1) <='" . $employeerangetwo . "'";
            $this->db->where($where_employee_code);
        } elseif ($employeerangetwo == "" && $employeerangeone != '') {
            $this->db->where("b.pin", $pin);
        }
        $where_date_range = "a.dateclock BETWEEN '" . $daterangetwo . "' AND '" . $daterangeone . "'";
        $this->db->select('a.pin,serialnumber,dateclock,login,off,weekday,weekyear,logout,employee_code,deptcode,id_shift_def,normaltime,tothrs,ot15,mot15,ot20,lostt,manual,leavestatus,firstname,lastname');
        $this->db->from('trans a');
        $this->db->join('users b', 'b.pin=a.pin', 'left');
        $this->db->join('util_branch_reader r', 'r.readerserial=a.serialnumber', 'left');
        // $this->db->where("b.pin", $pin);
        $this->db->order_by('dateclock', 'asc');
        $this->db->where($where_date_range);
        $this->db->where('r.branchname', $serialnumberone);
        if ($payrollcat != NULL || $payrollcat != "") {
            $this->db->where('b.payroll_category', $payrollcat);
        }
        $this->db->order_by('dateclock', 'asc');
        $query = $this->db->get()->result_array();
        return $query;
    }

    function daily_absent_call($serialnumberone, $daterangetwo, $daterangeone, $payrollcat = NULL)
    {
        //        $where_date_range = "a.dateclock BETWEEN '" . $daterangetwo . "' AND '" . $daterangeone . "'";
        $where_hours = "a.lostt>= '" . '4' . "' AND  a.login<='" . '0' . "'";
        //        $where_hoursm = "a.lostt>= 8";
        $this->db->select('a.pin,b.employee_code,b.pin,serialnumber,dateclock,login,off,weekday,weekyear,logout,employee_code,deptcode,id_shift_def,normaltime,tothrs,ot15,mot15,ot20,lostt,manual,leavestatus,firstname,lastname');
        $this->db->from('trans a');
        $this->db->join('users b', 'b.pin=a.pin', 'left');
        $this->db->join('util_branch_reader r', 'r.readerserial=a.serialnumber', 'left');
        $this->db->where('a.dateclock<=', $daterangetwo);
        $this->db->where('a.dateclock>=', $daterangeone);
        //        $this->db->where('a.serialnumber', $serialnumberone);
        $this->db->where('b.pin!=', "");
        $this->db->where('a.leavestatus', "XXX");
        $this->db->where('r.branchname', $serialnumberone);
        if ($payrollcat != NULL || $payrollcat != "") {
            $this->db->where('b.payroll_category', $payrollcat);
        }
        $this->db->where($where_hours);
        //        $this->db->or_where($where_hoursm);
        $this->db->order_by('dateclock', 'asc');
        $query = $this->db->get()->result_array();
        return $query;
    }

    function daily_late_call($serialnumberone, $daterangetwo, $daterangeone, $payrollcat = NULL)
    {
        $where_date_range = "a.dateclock BETWEEN '" . $daterangetwo . "' AND '" . $daterangeone . "'";
        $this->db->select('a.pin,b.employee_code,b.pin,serialnumber,dateclock,login,off,weekday,weekyear,logout,employee_code,deptcode,id_shift_def,normaltime,tothrs,ot15,mot15,ot20,lostt,manual,leavestatus,firstname,lastname');
        $this->db->from('trans a');
        $this->db->join('users b', 'b.pin=a.pin', 'left');
        $this->db->join('util_branch_reader r', 'r.readerserial=a.serialnumber', 'left');
        $this->db->order_by('dateclock', 'asc');
        $this->db->where($where_date_range);
        //        $this->db->where('a.serialnumber', $serialnumberone);
        $this->db->where('r.branchname', $serialnumberone);
        //        $this->db->where('a.lostt<', $hourslost);
        $this->db->where('a.login!=', "");
        $this->db->where('a.lostt>', 0);
        if ($payrollcat != NULL || $payrollcat != "") {
            $this->db->where('b.payroll_category', $payrollcat);
        }
        $this->db->order_by('dateclock', 'asc');
        $query = $this->db->get()->result_array();
        return $query;
    }

    function daily_ot_call($serialnumberone, $daterangetwo, $daterangeone, $payrollcat = NULL)
    {
        $where_date_range = "a.dateclock BETWEEN '" . $daterangetwo . "' AND '" . $daterangeone . "'";
        $this->db->select('a.pin,b.employee_code,b.pin,serialnumber,dateclock,login,off,weekday,weekyear,logout,employee_code,deptcode,id_shift_def,normaltime,tothrs,ot15,mot15,ot20,lostt,manual,leavestatus,firstname,lastname');
        $this->db->from('trans a');
        $this->db->join('users b', 'b.pin=a.pin', 'left');
        $this->db->order_by('dateclock', 'asc');
        $this->db->where($where_date_range);
        $this->db->where('a.serialnumber', $serialnumberone);
        if ($payrollcat != NULL || $payrollcat != "") {
            $this->db->where('b.payroll_category', $payrollcat);
        }
        $this->db->where('a.ot15>', 0);
        $this->db->or_where('a.mot15>', 0);
        $this->db->order_by('dateclock', 'asc');
        $query = $this->db->get()->result_array();
        return $query;
    }

    //New Concept Of Joins
    function attendence_fortnight($serialnumberone, $daterangetwo, $daterangeone, $pin)
    {
        $where_date_range = "a.dateclock BETWEEN '" . $daterangetwo . "' AND '" . $daterangeone . "'";
        $this->db->select('a.pin,serialnumber,dateclock,login,off,nhifnumber,nssfnumber,saccoamount,lunchamount,employee_code,weekday,weekyear,logout,employee_code,deptcode,id_shift_def,normaltime,tothrs,ot15,mot15,ot20,lostt,manual,leavestatus,firstname,lastname,m.amount as otherallowance,ad.amount as advanceddeduction');
        $this->db->from('trans a');
        $this->db->join('users b', 'b.pin=a.pin', 'left');
        $this->db->join('manualallowences m', 'm.userpin=a.pin and m.date=a.dateclock ', 'left');
        $this->db->join('advanceddeduction ad', 'ad.userpin=a.pin and ad.date=a.dateclock ', 'left');
        $this->db->where("a.pin", $pin);
        $this->db->where($where_date_range);
        $this->db->where('a.serialnumber', $serialnumberone);
        $this->db->order_by('a.dateclock', 'asc');
        $query = $this->db->get()->result_array();
        return $query;
    }

    function attendence_allowances($serialnumberone, $daterangetwo, $daterangeone, $pin)
    {
        $where_date_range = "a.dateclock BETWEEN '" . $daterangetwo . "' AND '" . $daterangeone . "'";
        $this->db->select('amount');
        $this->db->from('manualallowences a');
        $this->db->where("b.userpin", $pin);
        $this->db->where($where_date_range);
        $this->db->where('branch', $serialnumberone);
        $this->db->order_by('a.dateclock', 'asc');
        $query = $this->db->get()->result_array();
        return $query;
    }

    function getrangeforfortnight($whattoselect, $namerangeone, $namerangetwo, $serialbranch, $employeetype)
    {
        $this->db->select($whattoselect);
        $this->db->from('attendence_alluserinfo a');
        $this->db->join('users b', 'b.pin=a.pintwo', 'left');
        if ($namerangetwo == 0) {
            $where_employee_code = " LEFT (a.names, 1) >= '" . $namerangeone . "'";
        } else {
            $where_employee_code = " LEFT (a.names, 1) >= '" . $namerangeone . "' AND LEFT (a.names, 1) <='" . $namerangetwo . "'";
        }
        $this->db->where($where_employee_code);
        $this->db->where('serialnumber', $serialbranch);
        $this->db->where('slug', 0);
        $this->db->where('b.employmenttype_id', $employeetype);
        $this->db->order_by('names', 'asc');
        $query = $this->db->get()->result_array();
        return $query;
    }

    //This function has mysterious behaviour
    function getrangeforemployeereport_xx($whattoselect, $namerangeone, $namerangetwo, $serialbranch, $employeetype, $employementstatus_id)
    {
        $this->db->select($whattoselect);
        $this->db->from('attendence_alluserinfo a');
        $this->db->join('users b', 'b.pin=a.pintwo', 'left');
        // $where_employee_code = " LEFT (a.names, 1) >= '" . $namerangeone . "' AND LEFT (a.names, 1) <='" . $namerangetwo . "'";
        // $this->db->where($where_employee_code);
        $this->db->where('a.serialnumber', $serialbranch);
        $this->db->where('b.slug', 0);
        $this->db->where('b.employmenttype_id', $employeetype);
        $this->db->where('b.jobstatus_id', $employementstatus_id);
        $this->db->order_by('names', 'asc');
        $query = $this->db->get()->result_array();
        return $query;
    }

    //Better
    function getrangeforemployeereport($whattoselect, $serialbranch)
    {
        $this->db->select($whattoselect);
        $this->db->from('users b');
        $this->db->join('util_branch_reader r', 'r.id=b.branch_id', 'left');
        // $where_employee_code = " LEFT (a.names, 1) >= '" . $namerangeone . "' AND LEFT (a.names, 1) <='" . $namerangetwo . "'";
        // $this->db->where($where_employee_code);
        $this->db->where('r.branchname', $serialbranch);
        $this->db->where('b.slug', 0);
        $this->db->order_by('b.firstname', 'asc');
        $query = $this->db->get()->result_array();
        return $query;
    }

    //
    function testspeedmodel($serialnumberone, $daterangeone, $daterangetwo, $employeetype, $namerangeone, $namerangetwo)
    {
        $this->db->select('names,time,gross,paye,nhif,nssf,pinnumber,branch,mindate,maxidate,employmenttype_id');
        $this->db->from('payfortnight a');
        $where_employee_code = " LEFT (a.names, 1) >= '" . $namerangeone . "' AND LEFT (a.names, 1) <='" . $namerangetwo . "'";
        //        $where_date_range = "a.mindate BETWEEN '" . $daterangetwo . "' AND '" . $daterangeone . "'";
        $this->db->where($where_employee_code);
        //        $this->db->where("a.mindate>=", $daterangeone);
        //        $this->db->where("a.maxidate<=", $daterangetwo);
        $this->db->where("a.employmenttype_id", $employeetype);
        $this->db->order_by('names', 'asc');
        $query = $this->db->get()->result_array();
        return $query;
    }

    function firstfortnightsingleuser($arrayselect, $serialnumberone, $daterangeone, $daterangetwo, $userpin)
    {
        $this->db->select($arrayselect);
        $this->db->from('payfortnight a');
        //        $where_employee_code = " LEFT (a.names, 1) >= '" . $namerangeone . "' AND LEFT (a.names, 1) <='" . $namerangetwo . "'";
        //        $where_date_range = "a.mindate BETWEEN '" . $daterangetwo . "' AND '" . $daterangeone . "'";
        $this->db->where("a.mindate>=", $daterangeone);
        $this->db->where("a.maxidate<=", $daterangetwo);
        $this->db->where("a.branch", $serialnumberone);
        $this->db->where("a.pinnumber", $userpin);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function util_br($reader)
    {
        $query = $this->db->select('attendencelog.pin as pina')->from('attendencelog')->join('attendence_alluserinfo', 'attendence_alluserinfo.pintwo = attendencelog.pin', 'left')->where('attendencelog.serialnumber', $reader)->where('attendence_alluserinfo.pintwo', NULL)->distinct()->get();
        $updateuserifo = $query->result_array();
        $this->db->trans_start();
        foreach ($updateuserifo as $value) {
            $array_userinfotemp = array(
                'serialnumber' => $reader,
                'pin' => $value['pina'],
                'pintwo' => $value['pina'],
                'names' => $value['pina'],
                'previlage' => 0
            );
            $this->insertz('attendence_alluserinfo', $array_userinfotemp);
        }
        $this->db->trans_complete();
        return $updateuserifo;
    }

    public function getuserbybranch_joinshift($whattoselect, $branchid = null, $branchserialnumber = null)
    {
        $this->db->select($whattoselect);
        $this->db->from('attendence_alluserinfo a');
        $this->db->join('branches  b', 'b.readerserial=a.serialnumber', 'left');
        $this->db->join('users u', 'u.pin=a.pintwo', 'left');
        $this->db->where('b.id', $branchid);
        $this->db->or_where('b.readerserial', $branchserialnumber);
        $this->db->order_by('u.firstname', 'asc');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function attendence_joinshift($shift_id, $id_department, $allocated)
    {
        $selectwhat = array(
            'a.id',
            'a.user_id',
            'firstname',
            'lastname'
        );
        $this->db->select($selectwhat);
        $this->db->from('users a');
        $this->db->join('attendence_util_user_shift b', 'b.user_id=a.id', 'left');
        $this->db->join('attendence_shiftdef c', 'c.id=b.id_shift_def', 'left');
        $this->db->where('b.id_util_department', $id_department);
        $this->db->where('a.status_alocated', $allocated);
        $this->db->where('c.id', $shift_id);
        $this->db->order_by('a.firstname', 'asc');
        $query = $this->db->get();
        // $result = $this->dbutil->optimize_database();
        $this->dbutil->optimize_table('attendence_util_user_shift');
        return $query->result_array();
    }

    function selectuniuquefortransupadte($date, $reader)
    {
        $this->db->distinct();
        $this->db->select('serialnumber,pin,DATE_FORMAT(exactdate,"%Y-%m") as datelike,timeinserts');
        $this->db->from('attendencelog');
        $this->db->where("DATE_FORMAT(exactdate,'%Y-%m')", $date);
        $this->db->where('serialnumber', $reader);
        //Temp
        $this->db->where('pin', '27771420');
        $this->db->order_by('pin asc, datelike asc,timeinserts ASC');
        $query = $this->db->get()->result_array();
        // echo $this->db->last_query();
        return $query;
    }

    // Margical
    function selectuniuquefortransupadteday($date, $reader)
    {
        $this->db->distinct();
        $this->db->select('serialnumber,pin,DATE_FORMAT(exactdate,"%Y-%m") as datelike,timeinserts');
        $this->db->from('attendencelog');
        $this->db->where("DATE_FORMAT(exactdate,'%Y-%m-%d')", $date);
        $this->db->where('serialnumber', $reader);
        $this->db->order_by('pin asc, datelike asc,timeinserts ASC');
        $query = $this->db->get()->result_array();
        // echo $this->db->last_query();
        return $query;
    }

    function selectuniuquefortransupadtedayfullmonth($date, $reader)
    {
        $this->db->distinct();
        $this->db->select('serialnumber,pin,DATE_FORMAT(exactdate,"%Y-%m") as datelike,timeinserts');
        $this->db->from('attendencelog');
        $this->db->where("DATE_FORMAT(exactdate,'%Y-%m')", $date);
        $this->db->where('serialnumber', $reader);
        $this->db->order_by('pin asc, datelike asc,timeinserts ASC');
        $query = $this->db->get()->result_array();
        // echo $this->db->last_query();
        return $query;
    }

    // Check If This Is A Holiday
    function selectztimholmt($value_1)
    {
        $this->db->select('desc,DATE_FORMAT(date,"%m-%d") as timeholiday');
        $this->db->from('timholmt');
        $this->db->where("DATE_FORMAT(date,'%m-%d')", $value_1);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function joinpinscard_prev($pin, $date, $serialreader)
    {
        $this->db->distinct();
        $this->db->select('a.pin,exactdate,DATE_FORMAT(a.exactdate,"%Y-%m-%d") as dateclock,DATE_FORMAT(a.exactdate,"%H:%i:%s") as dateclocktime,a.exactdate as firstdayofweek,a.serialnumber,timeinserts,dateinsertserver,names,c.user_id,id_util_department,id_shift_def,shiftmancode,shiftfrom,shiftto,shiftype,lunchmin,deptcode');
        $this->db->from('attendencelog a');
        $this->db->join('attendence_alluserinfo b', 'b.pintwo=a.pin', 'left');
        $this->db->join('users c', 'c.pin=a.pin', 'left');
        $this->db->join('attendence_util_user_shift m', 'm.user_id=c.id', 'left');
        $this->db->join('attendence_shiftdef x', 'x.id=m.id_shift_def', 'left');
        //        $this->db->join('shiftdefdetails w', 'w.id_attendence_shiftdef=x.id', 'left');
        $this->db->join('attendence_util_department d', 'd.id=m.id_util_department', 'left');
        $this->db->where('a.pin', $pin);
        $this->db->where('a.serialnumber', $serialreader);
        if ($date != 0) {
            $this->db->where("DATE_FORMAT(a.exactdate,'%Y-%m')", $date);
            // $this->db->where('DATE(a.dateinsertserver)', $date);
        }
        $this->db->order_by('exactdate', 'asc');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function joinpinscard($date, $serialreader, $employpin = null)
    {
        $countdate = explode('-', $date);
        $this->db->distinct();
        $this->db->select('a.pin,exactdate,DATE_FORMAT(a.exactdate,"%Y-%m-%d") as dateclock,DATE_FORMAT(a.exactdate,"%H:%i:%s") as dateclocktime,a.exactdate as firstdayofweek,a.serialnumber,timeinserts,dateinsertserver,names,c.user_id,id_util_department,id_shift_def,shiftmancode,shiftfrom,shiftto,shiftype,lunchmin,deptcode');
        $this->db->from('attendencelog a');
        $this->db->join('attendence_alluserinfo b', 'b.pintwo=a.pin', 'left');
        $this->db->join('users c', 'c.pin=a.pin', 'left');
        $this->db->join('attendence_util_user_shift m', 'm.user_id=c.id', 'left');
        $this->db->join('attendence_shiftdef x', 'x.id=m.id_shift_def', 'left');
        //        $this->db->join('shiftdefdetails w', 'w.id_attendence_shiftdef=x.id', 'left');
        $this->db->join('attendence_util_department d', 'd.id=m.id_util_department', 'left');
        //        $this->db->where('a.pin', '25181415');
        //        $this->db->where('a.serialnumber', $serialreader);
        if ($employpin != null) {
            $this->db->where('a.pin', $employpin);
        }
        if ($date != 0 && count($countdate) == 2) {
            $this->db->where("DATE_FORMAT(a.exactdate,'%Y-%m')", $date);
            // $this->db->where('DATE(a.dateinsertserver)', $date);
        } elseif ($date != 0 && count($countdate) == 3) {
            $this->db->where("DATE_FORMAT(a.exactdate,'%Y-%m-%d')", $date);
        }

        $this->db->order_by('exactdate', 'asc');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getlatestupdatebybranch($branchserial)
    {
        $this->db->select_max('exactdate');
        $this->db->from('attendencelog');
        $this->db->where('serialnumber', $branchserial);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function insertorignore($tablename, $datainsers)
    {
        $insert_query = $this->db->insert_string($tablename, $datainsers);
        $insert_query = str_replace('INSERT INTO', 'INSERT IGNORE INTO', $insert_query);
        $this->db->query($insert_query);
    }

    public function get_me_unsceennotif($userid)
    {
        $returnall = $this->universal_model->selectzy(array('id', 'comment_subject', 'comment_text', 'dateadded'), 'util_comments', 'to_id', $userid, 'comment_status', 1);
        //        print_array($returnall);
        return $returnall;
    }

    function selectz_unqie($array_table_n, $table_n, $variable_1, $value_1, $unique)
    {
        $this->db->select($array_table_n);
        $this->db->from($table_n);
        $this->db->where($variable_1, $value_1);
        $this->db->group_by($unique);
        $query = $this->db->get()->result_array();
        return $query;
    }

    //LEAVE JOIN QUERIRS\
    public function selelectleavereqbybranch($branchid, $slug, $state)
    {
        $this->db->select('CONCAT(c.firstname," ",c.lastname) as names,l.id_leavetype,l.leaveperiod,leavefrom,leaveto,leavebal,leavepurpose,t.leavetype,c.pin,l.id');
        $this->db->from('leaveapply l');
        $this->db->join('users c', 'c.id=l.appliedby', 'left');
        $this->db->join('leaveconfig t', 't.id=l.id_leavetype', 'left');
        $this->db->where('l.id_branch', $branchid);
        $this->db->where('l.slug', $slug);
        $this->db->where('l.state', $state);
        $this->db->order_by('l.dateadded', 'asc');
        $query = $this->db->get();
        return $query->result_array();
    }

    //    function simplegendercheck($array_table_n, $id) {
    //        $this->db->select($array_table_n);
    //        $this->db->from('users u');
    //        $this->db->join('genders g', 'u.id_gender=g.id', 'left');
    //        $this->db->where('u.id', $id);
    //        $this->db->where('u.slug', 0);
    //        $query = $this->db->get()->result_array();
    //        return $query;
    //    }

    function selectrangedatesperpin($pin_user, $mindate, $maxdate)
    {
        $this->db->select('*');
        $this->db->from('trans');
        $this->db->where('pin', $pin_user);
        $this->db->where('dateclock>=', $mindate);
        $this->db->where('dateclock<=', $maxdate);
        $query = $this->db->get();
        return $query->result_array();
    }

    function join_leave($startdatex, $endate, $pin)
    {
        $this->db->select('a.id,a.leavedate,l.leavetype,CONCAT(u.firstname," ",u.lastname) as names,u.idnumber');
        //        $daterange = "a.leavedate >= '" . $startdatex . "' a.leavedate <='" . $endate . "'";
        $this->db->from('attendence_leaves a');
        $this->db->join('users u', 'u.pin=a.userpin', 'left');
        $this->db->join('leaveconfig l', 'l.id=a.leavecode', 'left');
        $this->db->where('a.userpin', $pin);
        $where_date_range = "a.leavedate BETWEEN '" . $startdatex . "' AND '" . $endate . "'";
        $this->db->where($where_date_range);
        $query = $this->db->get()->result_array();
        //        print_array($this->db->last_query());
        return $query;
    }
}
