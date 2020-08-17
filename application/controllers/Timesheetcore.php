<?php

defined('BASEPATH') OR exit('No direct script access allowed');

//include APPPATH . 'controllers/CMySQL.php';

class Timesheetcore extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('universal_model');
    }

    public function index() {
        $all_clients = $this->getallclients();
        $recordsnumber = count($all_clients);
        $config = array();
        $config["base_url"] = base_url() . "timesheetcore/index";
        $config["total_rows"] = $recordsnumber;
        $config["per_page"] = 20;
        $config["uri_segment"] = 3;
        $this->pagination->initialize($config);
//Next
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["results"] = $this->universal_model->
                selectz_pigination('client', 'slug', 1, $config["per_page"], $page);
        $data["links"] = $this->pagination->create_links();
        $this->load->view("part/content/report/clireport/v_pignationsample", $data);
    }

    public function pigi() {
        $all_clients = $this->getallclients();
        $data['walahdata'] = $all_clients;
        echo json_encode($data);
    }

    public function pigi_employee() {
        $allemployees = $this->getallemployee('employee');
        $data['walahdataX'] = $allemployees;
        echo json_encode($data);
    }

    public function getallclients() {
        $value = $this->universal_model->selectz('*', 'client', 'slug', 1);
//        print_array($value);
        return $value;
    }

    public function getallemployee($typeuser) {
        $value = $this->universal_model->selectz('*', 'users', 'category', $typeuser);
//        print_array($value);
        return $value;
    }

    public function reportmine() {
        $response = Requests::get(base_url('timesheetcore/pigi_employee'));
        $array_data = json_decode($response->body, true);
        print_array($array_data);
//        $this->load->view("part/content/report/clireport/v_samplepigrest");
    }

    public function gettimeofuser() {
        $client_id = $this->input->post('client_id');
        $employee_id = $this->input->post('employee_id');
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $my_dates = getDatesFromRange($start_date, $end_date);
        $dates_day_namesxx = array();
        foreach ($my_dates as $date_value) {
            array_push($dates_day_namesxx, date('D', strtotime($date_value)) . ' ' . date('jS', strtotime($date_value)));
        }
        echo json_encode($dates_day_namesxx);
    }

    public function lestseemm() {
        $client_id = 1;
//        $client_id = $this->input->post('client_id');
        $userid = '9TC9Rs';
//        $userid = $this->input->post('employee_id');
        $date_from_fot = '2017-06-01';
//        $date_from_fot = $this->input->post('start_date');
        $date_to_fot = '2017-06-30';
//        $date_to_fot = $this->input->post('end_date');
        $ask = $this->columnheader($date_from_fot, $date_to_fot);
        print_array($ask);
//        echo json_encode($ask);
    }

    public function lestsee() {
//        $client_id = $this->input->post('client_id');
//        $userid = '9TC9Rs';
        $userid = $this->input->post('employee_id');
//        $date_from_fot = '2017-06-01';
        $date_from_fot = $this->input->post('start_date');
//        $date_to_fot = '2017-06-30';
        $date_to_fot = $this->input->post('end_date');
        echo '{
           "colHeaders":' . $this->columnheader($date_from_fot, $date_to_fot) . ',
           "client_bar":' . $this->clientbar($date_from_fot, $date_to_fot) . ',
           "headerone":' . $this->typecolums($date_from_fot, $date_to_fot) . ',
           "headertwo":' . $this->rowwidths($date_from_fot, $date_to_fot) . ',
           "headertwoone":' . $this->rowwidthstwo($date_from_fot, $date_to_fot) . ',
           "headerthree":' . $this->colwidths($date_from_fot, $date_to_fot) . ',
           "contant_table":' . $this->generateday($userid, $date_from_fot, $date_to_fot) . '
             }';
    }

    public function generateday($userid, $date_from_fot, $date_to_fot) {
        $my_dates = getDatesFromRange($date_from_fot, $date_to_fot);
        $ask = $this->universal_model->reportsingle($userid, $date_from_fot, $date_to_fot);
        $data_available_notuni = array();
//        $data_available = array();
        foreach ($ask as $value) {
            $date = date_create($value['date_done_task']);
            $dmdmd = date_format($date, "Y-m-d");
            $daaaa = $this->universal_model->reportsinglesub($value['user_id'], $value['project_id'], $dmdmd);
            array_push($data_available_notuni, $daaaa[0]);
        }
        $data_available_notuni = array_unique($data_available_notuni, SORT_REGULAR);
        foreach ($data_available_notuni as $key => $formatone) {
            foreach ($my_dates as $date_value) {
                if ($formatone['niceDate'] == $date_value) {
//                    $float = (float) $formatone['totatimetaken'];
                    $pertime = $formatone['totatimetaken'];
                    $data_available_notuni[$key][$date_value] = round($pertime, 2) . '';
                } else {
                    $data_available_notuni[$key][$date_value] = "";
                }
            }
        }
        foreach ($data_available_notuni as $key => $formatone) {
            foreach ($my_dates as $date_value) {
                if ($formatone['niceDate'] == $date_value) {
//                    $float = (float) $formatone['totatimetaken'];
                    $pertime = $formatone['totatimetaken'];
                    $data_available_notuni[$key][$date_value] = round($pertime, 2) . '';
                } else {
                    $data_available_notuni[$key][$date_value] = "";
                }
            }
        }
        $newarray = array();
        foreach ($data_available_notuni as $ar) {
            foreach ($ar as $k => $v) {
                if (array_key_exists($v, $newarray)) {
                    $datatoday = $ar['niceDate'];
                    $newarray[$v][$datatoday] = $newarray[$v][$datatoday] + $ar[$datatoday];
                } else if ($k == 'client_id') {
                    $newarray[$v] = $ar;
                }
            }
        }
        //$newarray Very Pivotal Point
        $cleaner_array = array();
        $storevalues = array();
        foreach ($newarray as $removeunesce) {
            unset_post($removeunesce, 'project_id');
            unset_post($removeunesce, 'user_id');
            unset_post($removeunesce, 'totatimetaken');
            unset_post($removeunesce, 'niceDate');
            unset_post($removeunesce, 'client_id');
            unset_post($removeunesce, 'project_name');
            array_push($storevalues, array($removeunesce['id'], $removeunesce['clientname']));
//            $storevalues = array_me($storevalues,$mfmff);
//            $output = array_slice($removeunesce, 2);
//            $totalsum = array_sum($output);
//            $removeunesce['total'] = round($totalsum, 2);
//            print_array($removeunesce);
            unset_post($removeunesce, 'id');
            array_push($cleaner_array, $removeunesce);
        }
        $cleaner_array_onblock = $this->testign($userid, $date_from_fot, $date_to_fot);
        $cleaner_array_leter = $cleaner_array;
        $cleaner_array = array_merge($cleaner_array, $cleaner_array_onblock);
        $megastring = "";
//        $mega_sub_string = "";
//        $number_roow
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
            $mega_sub_string = substr($mega_sub_string, 0, -1);
            $megastring .= '[' . $mega_sub_string . ',' . '"' . '=SUM(' . $formular . ')' . '"' . ']' . ',';
//Better
//            $data_pipe = array_values($data_pipe);
//            foreach ($data_pipe as $value) {
//                $megastring += $value;
//            }
        }
        //FINAL TOUCH PLEASE
        array_unshift($my_dates, 'shiftwer');
        $my_dateskeys = array_keys($my_dates);
        $lastrowformular = '';
        foreach ($my_dateskeys as $valuebetween) {
            $count_start = $valuebetween + 2;
            $firstcolumn = $this->translatref($count_start);
//            echo $firstcolumn . '<br>';
            $startref = '';
            $endref = '';
            $startref = $firstcolumn . '' . 1;
            $endref = $firstcolumn . '' . count($cleaner_array_leter);
            //Lets See
//            echo $number_;
            $subtractionadd = '';
            $number_ = count($cleaner_array_leter);
//            echo count($cleaner_array_onblock);
            foreach ($cleaner_array_onblock as $keynext => $value) {
//            print_array($value);
                $adjan = $keynext + $number_ + 1;
                $subtraction = '-' . $firstcolumn . '' . $adjan;
                $subtractionadd .= $subtraction;
            }
            if (count($cleaner_array_leter) <= 1) {
                if ($subtractionadd == '') {
                    $lastrowformular .= '"' . '' . '"' . ',';
                } else {
                    $lastrowformular .= '"' . '=SUM(' . $startref . ')' . $subtractionadd . '"' . ',';
                }
            } else {
                $lastrowformular .= '"' . '=SUM(' . $startref . ':' . $endref . ')' . $subtractionadd . '"' . ',';
            }
        }
        $lastrowformular_sqlbra = '[' . '"' . '",' . substr($lastrowformular, 0, -1) . ']';
        $megastring = $megastring . $lastrowformular_sqlbra;
        //FINAL TOUCH END
//        $megastring = substr($megastring, 0, -1);
//        echo '[' . $megastring . ']';
        return '[' . $megastring . ']';
    }

    public function generatedaymm($userid, $date_from_fot, $date_to_fot) {
//        For The Below user
//        $userid = 'C77ytO';
        $my_dates = getDatesFromRange($date_from_fot, $date_to_fot);
        $ask = $this->universal_model->reportsingle($userid, $date_from_fot, $date_to_fot);
        $data_available_notuni = array();
//        $data_available = array();
        foreach ($ask as $value) {
            $date = date_create($value['date_done_task']);
            $dmdmd = date_format($date, "Y-m-d");
            $daaaa = $this->universal_model->reportsinglesub($value['user_id'], $value['project_id'], $dmdmd);
            array_push($data_available_notuni, $daaaa[0]);
        }
        $data_available_notuni = array_unique($data_available_notuni, SORT_REGULAR);
        foreach ($data_available_notuni as $key => $formatone) {
            foreach ($my_dates as $date_value) {
                if ($formatone['niceDate'] == $date_value) {
//                    $float = (float) $formatone['totatimetaken'];
                    $pertime = $formatone['totatimetaken'];
                    $data_available_notuni[$key][$date_value] = round($pertime, 2) . '';
                } else {
                    $data_available_notuni[$key][$date_value] = "";
                }
            }
        }
        $newarray = array();
        foreach ($data_available_notuni as $ar) {
            foreach ($ar as $k => $v) {
                if (array_key_exists($v, $newarray)) {
                    $datatoday = $ar['niceDate'];
                    $newarray[$v][$datatoday] = $newarray[$v][$datatoday] + $ar[$datatoday];
                } else if ($k == 'project_id') {
                    $newarray[$v] = $ar;
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
            array_push($storevalues, array($removeunesce['id'], $removeunesce['project_name']));
//            $storevalues = array_me($storevalues,$mfmff);
//            $output = array_slice($removeunesce, 2);
//            $totalsum = array_sum($output);
//            $removeunesce['total'] = round($totalsum, 2);
//            print_array($removeunesce);
            unset_post($removeunesce, 'id');
            array_push($cleaner_array, $removeunesce);
        }
        $cleaner_array_onblock = $this->testign($userid, $date_from_fot, $date_to_fot);
        $cleaner_array_leter = $cleaner_array;
        $cleaner_array = array_merge($cleaner_array, $cleaner_array_onblock);
        $megastring = "";
//        $mega_sub_string = "";
//        $number_roow
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
            $mega_sub_string = substr($mega_sub_string, 0, -1);
            $megastring .= '[' . $mega_sub_string . ',' . '"' . '=SUM(' . $formular . ')' . '"' . ']' . ',';
//Better
//            $data_pipe = array_values($data_pipe);
//            foreach ($data_pipe as $value) {
//                $megastring += $value;
//            }
        }
        //FINAL TOUCH PLEASE
        array_unshift($my_dates, 'shiftwer');
        $my_dateskeys = array_keys($my_dates);
        $lastrowformular = '';
        foreach ($my_dateskeys as $valuebetween) {
            $count_start = $valuebetween + 2;
            $firstcolumn = $this->translatref($count_start);
//            echo $firstcolumn . '<br>';
            $startref = '';
            $endref = '';
            $startref = $firstcolumn . '' . 1;
            $endref = $firstcolumn . '' . count($cleaner_array_leter);
            //Lets See
//            echo $number_;
            $subtractionadd = '';
            $number_ = count($cleaner_array_leter);
//            echo count($cleaner_array_onblock);
            foreach ($cleaner_array_onblock as $keynext => $value) {
//            print_array($value);
                $adjan = $keynext + $number_ + 1;
                $subtraction = '-' . $firstcolumn . '' . $adjan;
                $subtractionadd .= $subtraction;
            }
            if (count($cleaner_array_leter) <= 1) {
                if ($subtractionadd == '') {
                    $lastrowformular .= '"' . '' . '"' . ',';
                } else {
                    $lastrowformular .= '"' . '=SUM(' . $startref . ')' . $subtractionadd . '"' . ',';
                }
            } else {
                $lastrowformular .= '"' . '=SUM(' . $startref . ':' . $endref . ')' . $subtractionadd . '"' . ',';
            }
        }
        $lastrowformular_sqlbra = '[' . '"' . '",' . substr($lastrowformular, 0, -1) . ']';
        $megastring = $megastring . $lastrowformular_sqlbra;
        //FINAL TOUCH END
//        $megastring = substr($megastring, 0, -1);
//        echo '[' . $megastring . ']';
        return '[' . $megastring . ']';
    }

    public function typecolums($date_from_fot, $date_to_fot) {
        $my_dates = getDatesFromRange($date_from_fot, $date_to_fot);
        array_unshift($my_dates, 'project_name');
        array_unshift($my_dates, 'id_update');
        array_unshift($my_dates, 'total');
        $keysmy = array_keys($my_dates);
        $columtype = '';
        foreach ($keysmy as $valuecol) {
            if ($valuecol == 0) {
                $valuem = "text";
            } else if ($valuecol == 1) {
                $valuem = "text";
            } else {
                $valuem = "numeric";
            }

            $columtype .= '{' . '"' . "type" . '"' . ':' . '"' . $valuem . '"' . '},';
        }
        $columtype = '[' . substr($columtype, 0, -1) . ']';
        return $columtype;
//        echo count($keysmy);
    }

    function colwidths($date_from_fot, $date_to_fot) {
        $my_dates = getDatesFromRange($date_from_fot, $date_to_fot);
        array_unshift($my_dates, 'project_name');
        array_unshift($my_dates, 'id_update');
        array_unshift($my_dates, 'total');
        $keysmy = array_keys($my_dates);
        $columwidths = '';
        foreach ($keysmy as $valuecol) {
            if ($valuecol == 0) {
                $valuem = 250;
            } else {
                $valuem = 80;
            }
            $columwidths .= $valuem . ',';
        }
        $columwidths = '[' . substr($columwidths, 0, -1) . ']';
//        print_array($my_dates);
        return $columwidths;
//        echo count($keysmy);
    }

    function rowwidths($date_from_fot, $date_to_fot) {
        $my_dates = getDatesFromRange($date_from_fot, $date_to_fot);
//        $my_dates[31] = $userid;
//        array_unshift($my_dates, $userid);
        $clomun_headertwo = "";
//         $clomun_headerone = '[' . $key . ',' . '"' . $date_value . '"' . ']' . ',';
        foreach ($my_dates as $date_value) {
            $clomun_headertwo .= '[' . '"' . date('D', strtotime($date_value)) . '"' . ']' . ',';
        }
//Cleaner Columns
        $clomun_headertwo = '[ ' . '[' . '""' . '],' . substr($clomun_headertwo, 0, -1) . ',' . '[' . '""' . ']' . ' ]';
        return $clomun_headertwo;
//        echo $clomun_headertwo;
    }

    function clientbar($fromdate, $todate) {
        $my_dates = getDatesFromRange($fromdate, $todate);
//        $my_dates[31] = $userid;
//        array_unshift($my_dates, $userid);
        $clomun_headertwo = "";
//         $clomun_headerone = '[' . $key . ',' . '"' . $date_value . '"' . ']' . ',';
        foreach ($my_dates as $date_value) {
            $clomun_headertwo .= '[' . '"' . '' . '"' . ']' . ',';
        }
//Cleaner Columns
        $clomun_headertwo = '[ ' . '[' . '"NAME OF CLIENT"' . '],' . substr($clomun_headertwo, 0, -1) . ',' . '[' . '""' . ']' . ' ]';
        return $clomun_headertwo;
//        echo $clomun_headertwo;
    }

    function rowwidthstwo($date_from_fot, $date_to_fot) {
        $my_dates = getDatesFromRange($date_from_fot, $date_to_fot);
//        $my_dates[31] = $userid;
//        array_unshift($my_dates, $userid);
        $clomun_headertwo = "";
//         $clomun_headerone = '[' . $key . ',' . '"' . $date_value . '"' . ']' . ',';
        foreach ($my_dates as $date_value) {
            $clomun_headertwo .= '[' . '"' . date('jS', strtotime($date_value)) . '"' . ']' . ',';
        }
//Cleaner Columns
        $clomun_headertwo = '[ ' . '[' . '""' . '],' . substr($clomun_headertwo, 0, -1) . ',' . '[' . '"TOTAL"' . ']' . ' ]';
        return $clomun_headertwo;
//        echo $clomun_headertwo;
    }

    public function columnheader($date_from_fot, $date_to_fot) {
        $clomun_headertwo = "";
//         $clomun_headerone = '[' . $key . ',' . '"' . $date_value . '"' . ']' . ',';
        $my_dates = getDatesFromRange($date_from_fot, $date_to_fot);
        foreach ($my_dates as $date_value) {
//            $clomun_headertwo .= '[' . '"' . date('D', strtotime($date_value)) . ' ' . date('jS', strtotime($date_value)) . '"' . ']' . ',';
            $clomun_headertwo .= '"' . ' ' . '",';
        }
        $clomun_headertwo .= '"' . ' ' . '",';
//Cleaner Columns   
        $clomun_headertwo = '[ ' . substr($clomun_headertwo, 0, -1) . ',' . '" "' . ' ]';
        return $clomun_headertwo;
    }

    public function translatref($value) {
        return columnLetter($value);
    }

    public function selfshif() {
        echo $this->translatref(65);
    }

    public function testign($userid, $startdate, $enddate) {
//        For The Below user
//        $userid = 'C77ytO';
        $my_dates = getDatesFromRange($startdate, $enddate);
        $data_available_notuni_juni = array();
        $data_available_notuni = array();
//        $data_available = array();
        $vara = $this->universal_model->selectz('*', 'util_project_updatem', 'user_id', $userid);
        foreach ($vara as $key => $letsgetthis) {
            $data_available_notuni['project_name'] = $vara[$key]['project_name'];
            foreach ($my_dates as $mydateend) {
                $varamax = $this->universal_model->reportsinglestate($letsgetthis['id_otherstate'], $mydateend);
                if (empty($varamax)) {
                    $data_available_notuni[$mydateend] = "";
                } else {
                    $data_available_notuni[$mydateend] = $varamax[0]['time_taken'];
                }
            }
            array_push($data_available_notuni_juni, $data_available_notuni);
//            foreach ($varamax as $valuepp) {
//                $data_available_notuni[$valuepp['date_done_task']] = $valuepp['time_taken'];
//            }
//            array_push($data_available_notuni_juni, $data_available_notuni);
//            echo $key;
        }
        return $data_available_notuni_juni;
    }

    public function testme() {
        $userid = 'WmX82S1';
//        For The Below user
//        $userid = 'C77ytO';
        $date_from_fot = '2018-06-17';
        $date_to_fot = '2018-08-20';
        $start = $this->testign($userid, $date_from_fot, $date_to_fot);
        print_array($start);
    }

    function newblood() {
        
    }

}

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

