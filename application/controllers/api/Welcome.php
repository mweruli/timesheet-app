<?php

ini_set('max_execution_time', 600);
ini_set('memory_limit', '-1');
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/tad/lib/TADFactory.php';
require APPPATH . 'libraries/tad/lib/TAD.php';
require APPPATH . 'libraries/tad/lib/TADResponse.php';
require APPPATH . 'libraries/tad/lib/Providers/TADSoap.php';
require APPPATH . 'libraries/tad/lib/Providers/TADZKLib.php';
require APPPATH . 'libraries/tad/lib/Exceptions/ConnectionError.php';
require APPPATH . 'libraries/tad/lib/Exceptions/FilterArgumentError.php';
require APPPATH . 'libraries/tad/lib/Exceptions/UnrecognizedArgument.php';
require APPPATH . 'libraries/tad/lib/Exceptions/UnrecognizedCommand.php';
require_once APPPATH . 'libraries/sync.php';

use TADPHP\TADFactory;
use TADPHP\TAD;
use Brick\Db\Bulk\BulkInserter;
use Brick\Db\Bulk\BulkDeleter;

// require FCPATH . 'vendor/autoload.php';
class Welcome extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('universal_model');
        $this->load->model('user_model', '', TRUE);
    }

    public function index() {
        if ($this->session->userdata('logged_in')) {
            redirect(base_url('welcome/dashboard'));
        } else {
            // $this->load->view('includes/pane/v_login', $this->m_data->static_data());
            $this->load->view('part/outer/login');
        }
    }

    public function testnn() {
        $checkreader = $this->universal_model->joinclocks(9);
        print_array($checkreader);
        // attendence_alluserinfo
        // attendencelog
    }

    public function dashboard($section = 1) {
        $universal_model = new Universal_model();
        $category = $this->session->userdata('logged_in')['category'];
        if ($this->session->userdata('logged_in')) {
            switch ($section) {
                case 1:
                    $data['content_part'] = 'part/content/v_dashboard';
                    $this->load->view('part/inside/index', $data);
                    break;
                case 2:
                    $data['attendencelog'] = $universal_model->selectall('*', 'attendencelog');
                    $data['content_part'] = 'part/content/v_attendancelog';
                    $this->load->view('part/inside/index', $data);
                    break;
                case 3:
                    $data['domain'] = $this->getdomain();
                    $data['allreaders'] = $this->getallreaders();
                    $data['content_part'] = 'part/content/v_companyreader';
                    $this->load->view('part/inside/index', $data);
                    break;
                case 4:
                    $data['attendence_alluserinfo'] = $universal_model->selectall('*', 'attendence_alluserinfo');
                    $data['content_part'] = 'part/content/v_attendence_alluserinfo';
                    $this->load->view('part/inside/index', $data);
                    break;
                case 5:
                    $readers = $this->universal_model->selectall('*', 'company_reader');
                    // print_array($readers);
                    try {
                        $this->loaddatain();
                    } catch (Exception $e) {
                        // echo 'Message: ' . $e->getMessage();
                    }

                    break;
                default:
                    break;
            }
        } else {
            redirect(base_url('authentication'));
        }
    }

    public function sendingdata() {
        // $number_checketimes = 0;
        $file_namecore = str_replace("http://", "", $this->getdomain());
        $connected = @fsockopen($file_namecore, 80);
        // website, port (try 80 or 443)
        if ($connected) {
            $this->reporttome("connected", "sendingdata@Welcome");
            $this->loaddatain();
            fclose($connected);
        } else {
            $this->reporttome("notconnected", "sendingdata@Welcome");
        }
    }

    public function loaddatain() {
        $readers = $this->syncreaders();
        if (empty($readers)) {
            $this->reporttome("They are No Reader In The System", "loaddatain@Welcome");
        } else {
            try {
                $this->infolog();
                $this->addlog();
            } catch (Exception $e) {
                echo $e->getMessage();
            } finally {
                $this->get_accounts();
            }
        }
    }

    public function get_accounts() {
        // if($statknow[insertstate]!=0)
        try {
            $query = "TRUNCATE TABLE `attendencelogacttwo`";
            $this->quicksqlpdo("localhost", "root", "", $query);
            $sync = new SyncronizeDB();
            // masterSet(dbserver,user,password,db,table,index)
            $sync->masterSet("localhost", "root", "", "desktoptime", "attendencelog", "id");
            // serverSet(dbserver,user,password,db,table,index)
            $sync->slaveSet("localhost", "root", "", "desktoptime", "attendencelogactone", "id");
            // syncronizing the slave table with the master table (at row level)
            $sync->slaveSyncronization('attendencelogacttwo');

            // For Another Word
            $query = "TRUNCATE TABLE `infortwo`";
            $this->quicksqlpdo("localhost", "root", "", $query);
            $sync2 = new SyncronizeDB();
            $sync2->masterSet("localhost", "root", "", "desktoptime", "attendence_alluserinfo", "id");
            $sync2->slaveSet("localhost", "root", "", "desktoptime", "inforone", "id");
            $sync2->slaveSyncronization('infortwo');

            $this->reporttome("Data Suncronised Successfully", "get_accounts@Welcome");
        } catch (Exception $e) {
            $message_array = array(
                $e->getMessage(),
                $e->getTraceAsString()
            );
            $this->reporttome(json_enode($message_array), "get_accounts@Welcome");
            // echo $e->getMessage();
        } finally {
            $this->prepareuploadone__t();
        }
    }

    public function prepareuploadone__t() {
        try {
            $alluserinfo = $this->universal_model->selectall('*', 'infortwo');
            $this->db->trans_start();
            foreach ($alluserinfo as $oneuser) {
                $array_user = array(
                    'serialnumber' => $oneuser ['compay_reader_id'],
                    'pin' => $oneuser ['pin'],
                    'pintwo' => $oneuser ['pin2'],
                    'names' => $oneuser ['name'],
                    'previlage' => $oneuser ['privilageex'],
                );
                $this->universal_model->updateOnDuplicate('attendence_alluserinfo', $array_user);
            }
            $this->db->trans_complete();
        } catch (Exception $e) {
            $message_array = array(
                $e->getMessage(),
                $e->getTraceAsString()
            );
            $this->reporttome(json_enode($message_array), "prepareuploadone__t@Welcome");
        } finally {
            $this->prepareuploadone__steptwo();
        }
        //$varainfo = $this->universal_model->my_model_method();
        // print_array($varainfo);
    }

    function prepareuploadone__steptwo() {
        // $alluserinfo = $this->universal_model->selectall('*', 'attendencelogacttwo');
        try {
            $alllogs = $this->universal_model->selectall('*', 'attendencelogacttwo');
            $this->db->trans_start();
            foreach ($alllogs as $userlog) {
                // $totalrecords ++;
                // Njovu
                $this->userdefaultdata($userlog ['pin']);
                $userlogarray = array(
                    'serialnumber' => $userlog ['compay_reader_id'],
                    'pin' => $userlog ['pin'],
                    'exactdate' => $userlog ['datetime_reader'],
                    'verified' => $userlog ['verified'],
                    'status' => $userlog ['status'],
                    'workcode' => $userlog ['workcode'],
                    'timeinserts' => $userlog ['timeinserts']
                );
                $this->universal_model->updateOnDuplicate('attendencelog', $userlogarray);
                // array_push($megasega, $userlogarray);
            }
            $this->db->trans_complete();
        } catch (Exception $e) {
            $message_array = array(
                $e->getMessage(),
                $e->getTraceAsString()
            );
            $this->reporttome(json_enode($message_array), "prepareuploadone__t@Welcome");
        } finally {
            $curl = curl_init();
            // Set some options - we are passing in a useragent too here
            curl_setopt_array($curl, array(
                CURLOPT_TIMEOUT => 500,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => 'http://time.mathais.co.ke/aot/readmeerfolder',
                CURLOPT_USERAGENT => 'From Mathias'
            ));
            // Send the request & save response to $resp
            $resp = curl_exec($curl);
            print_array(json_decode($resp));
            // Close request to clear up some resources
            curl_close($curl);
            //$this->prepareuploadone__steptwo();
        }
    }

    public function prepareuploadone__tretired() {
        try {
            $uniqid = php_uname('n');
            // $domainsiniture = $this->getdomain();
            $file_namecore = str_replace("http://", "", $this->getdomain());
            $vara = $this->universal_model->selectall('*', 'attendencelogacttwo');
            $nameone = $file_namecore . $uniqid . '_attendencelog_' . "data.txt";
            $nametwo = $file_namecore . $uniqid . '_alluserinfo_' . "data.txt";
            file_put_contents(APPPATH . '/datamine/' . $nameone, '<?php return ' . var_export($vara, true) . ';');
            $varainfo = $this->universal_model->selectall('*', 'infortwo');
            file_put_contents(APPPATH . '/datamine/' . $nametwo, '<?php return ' . var_export($varainfo, true) . ';');
            // print_array($addlog);
            $this->reporttome("files written and ready for zipping", "prepareuploadone__t@Welcome");
        } catch (Exception $e) {
            $message_array = array(
                $e->getMessage(),
                $e->getTraceAsString()
            );
            $this->reporttome(json_enode($message_array), "prepareuploadone__t@Welcome");
        } finally {
            $this->zipappandupload($nameone, $nametwo, $uniqid);
        }
    }

    public function zipappandupload($nameone, $nametwo, $uniqid) {
        try {
            $file = APPPATH . 'datamine\\' . $nameone;
            $filetwo = APPPATH . 'datamine\\' . $nametwo;

            // $filem='C:\xampp\htdocs\timereader\application\datamine\mathais.co.keSERVER_attendencelog_data.txt';
            // echo $filem.'<br>';
            // echo $file.'<br>';
            $datesign = date("Ymd");
            $zip = new ZipArchive();
            if ($zip->open(APPPATH . '\meer\\' . $uniqid . '_' . $datesign . '.zip', ZipArchive::CREATE) === TRUE) {
                $zip->addFile($file, basename($file));
                $zip->addFile($filetwo, basename($filetwo));
                $zip->close();
            }
            // if ($result) {
            // // $this->uploadtoserver($uniqid . $datesign . '.zip');
            // } else {
            // throw new Exception("Can Not Zip File.");
            // }
            $this->reporttome("@fileone " . $file . '| @filetwo' . $filetwo . ' | @Zipped File ' . APPPATH . '\meer\\' . $uniqid . '_' . $datesign . '.zip', "zipappandupload@Welcome");
        } catch (Exception $e) {
            $message_array = array(
                $e->getMessage(),
                $e->getTraceAsString()
            );
            $this->reporttome(json_enode($message_array), "zipappandupload@Welcome");
        } finally {
            $this->uploadtoserver(APPPATH . '\meer\\' . $uniqid . '_' . $datesign . '.zip', $uniqid, $datesign);
        }
    }

    public function uploadtoserver($zipfile, $uniqid, $datesign) {
        $ftp_server = "time.mathais.co.ke";
        $ftp_user_name = 'alfaclient@time.mathais.co.ke'; /* username */
        $ftp_user_pass = 'Cq=K0OE<3,w6';
        $file = $uniqid . $datesign . '.zip';
        try {
            $con = ftp_connect($ftp_server, 21);
            if (false === $con) {
                // $this->reporttome("Failed to connect to the ftp server @".$ftp_server, "uploadtoserver@Welcome");
                throw new Exception('Unable to connect');
            }
            $loggedIn = ftp_login($con, $ftp_user_name, $ftp_user_pass);
            ftp_pasv($con, true);
            if (true === $loggedIn) {
                if (ftp_put($con, $file, $zipfile, FTP_BINARY)) {
                    $this->reporttome("Successfully Uploaded @" . $file, "uploadtoserver@Welcome");
                    unlink($zipfile);
                    sleep(2);
                } else {
                    $this->reporttome("Failed to connect to the ftp server @" . $ftp_server, "uploadtoserver@Welcome");
                }
            } else {
                throw new Exception('Unable to log in');
            }
            // print_r(ftp_nlist($con, "."));
            ftp_close($con);
        } catch (Exception $e) {
            $message_array = array(
                $e->getMessage(),
                $e->getTraceAsString()
            );
            $this->reporttome($e->getMessage(), "uploadtoserver@Welcome");
        }
        $vara = array(
            'fromdesktop',
            'moreinfoneeded'
        );
//         $request = Requests::post('http://mathais.co.ke/aot/readmeerfolder', array(), $vara);
//         $array_data = json_decode($request->body, true);
//         print_array($array_data);
        //End Game
        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
            CURLOPT_TIMEOUT => 500,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'http://time.mathais.co.ke/aot/readmeerfolder',
            CURLOPT_USERAGENT => 'From Mathias'
        ));
        // Send the request & save response to $resp
        $resp = curl_exec($curl);
        print_array(json_decode($resp));
        // Close request to clear up some resources
        curl_close($curl);
    }

    public function infolog() {
        // $this->syncreaders();
        $readers = $this->universal_model->selectall('*', 'company_reader');
        if (!empty($readers)) {
            // $number_data="";
            $servername = "localhost";
            $username = "root";
            $password = '';
            $pdo2 = new PDO("mysql:host=$servername;dbname=desktoptime", $username, $password);
            $pdo2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo2->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $sql = "TRUNCATE TABLE `attendence_alluserinfo`";
            $statement = $pdo2->prepare($sql);
            $statement->execute();
            $number_data = "";
            foreach ($readers as $reader) {
                $tad = (new TADFactory([
                            'ip' => $reader['device_ipaddress']
                                ]))->get_instance();
                $serialnumber = $tad->get_serial_number()->get_response([
                            'format' => 'array'
                        ])['Row']['Information'];
                $user_info = $tad->get_user_info()->get_response([
                            'format' => 'array'
                        ])['Row'];
                $user_info_clean = array();
                foreach ($user_info as $userone) {
                    if (!empty($userone['Name'])) {
                        if (empty($userone['Password'])) {
                            $userone['Password'] = '';
                        }
                        // $user_info_clean[$key]['timeinserts']=$date_time;
                        array_push($user_info_clean, $userone);
                    }
                }
                if (empty($user_info_clean)) {
                    // $this->reporttome("There is No User Information EMPTY", "infolog@Welcome");
                } else {
                    $number_data .= count($user_info_clean) . ' CHUNK ';

                    $inserter = new BulkInserter($pdo2, 'attendence_alluserinfo', [
                        'compay_reader_id',
                        'pin',
                        'name',
                        'privilageex',
                        'pin2'
                    ]);
                    $pdo2->beginTransaction();
                    foreach ($user_info_clean as $oneuser) {
                        // $check_data = $this->universal_model->selectinfouserbeforeinsert($serialnumber, $oneuser['PIN'], $oneuser['Name'], $oneuser['Privilege'], $oneuser['PIN2']);
                        // if (empty($check_data)) {
                        $inserter->queue($serialnumber, $oneuser['PIN'], $oneuser['Name'], $oneuser['Privilege'], $oneuser['PIN2']);
                        // }
                    }
                    $inserter->flush();
                    $pdo2->commit();
                }
            }
            $pdo2 = null;
            $this->reporttome("Chunks Inserted " . $number_data . ' ' . ' From Number Of Readers#' . count($readers), "infolog@Welcome");
        } else {
            $this->reporttome("They are no readers so no action ", "infolog@Welcome");
        }
    }

    public function addlog() {
        $readers = $this->universal_model->selectall('*', 'company_reader');
        if (!empty($readers)) {
            $servername = "localhost";
            $username = "root";
            $password = '';
            $pdo = new PDO("mysql:host=$servername;dbname=desktoptime", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $sql = "TRUNCATE TABLE `attendencelog`";
            $number_data = "";
            $statement = $pdo->prepare($sql);
            $statement->execute();
            foreach ($readers as $reader) {
                $tad = (new TADFactory([
                            'ip' => $reader['device_ipaddress']
                                ]))->get_instance();
                $serialnumber = $tad->get_serial_number()->get_response([
                            'format' => 'array'
                        ])['Row']['Information'];
                $attendence_log = $tad->get_att_log()->get_response([
                            'format' => 'array'
                        ])['Row'];

                if (empty($attendence_log)) {
                    
                } else {
                    $number_data .= count($attendence_log) . ' CHUNK ';
                    $inserter = new BulkInserter($pdo, 'attendencelog', [
                        'compay_reader_id',
                        'pin',
                        'datetime_reader',
                        'verified',
                        'status',
                        'workcode',
                        'timeinserts'
                    ]);
                    $pdo->beginTransaction();
                    foreach ($attendence_log as $attendelog) {
                        // $check_data = $this->universal_model->selectlogbeforeinsert($serialnumber, $attendelog['PIN'], $attendelog['DateTime'], $attendelog['Verified'], $attendelog['Status'], $attendelog['WorkCode']);
                        // if (empty($check_data)) {
                        // print_array(array('jackson','rebecca'));
                        $inserter->queue($serialnumber, $attendelog['PIN'], $attendelog['DateTime'], $attendelog['Verified'], $attendelog['Status'], $attendelog['WorkCode'], date("Y/m/d"));
                        // }
                    }
                    $inserter->flush();
                    $pdo->commit();
                }
            }
            $pdo = null;
            $this->reporttome("Chunks Inserted " . $number_data . ' ' . ' From Number Of Readers#' . count($readers), "addlog@Welcome");
        } else {
            $this->reporttome("They are no readers so no action ", "addlog@Welcome");
        }
    }

    public function syncreaders() {
        // Added Manually On The UI
        $readers = $this->universal_model->selectall('*', 'company_reader');
        $udates = 0;
        $removedreaders = "";
        ;
        foreach ($readers as $reader) {
            try {
                $tad = (new TADFactory([
                            'ip' => $reader['device_ipaddress']
                                ]))->get_instance();
                $serialnumber = $tad->get_serial_number()->get_response([
                            'format' => 'array'
                        ])['Row']['Information'];
                $devicename = $tad->get_device_name()->get_response([
                            'format' => 'array'
                        ])['Row']['Information'];
                $readerup = array(
                    'reader_serialnumber' => $serialnumber,
                    'device_name' => $devicename
                );
                $this->universal_model->updatez('device_ipaddress', $reader['device_ipaddress'], 'company_reader', $readerup);
                // echo 'Readers Updated' . '<br>';
                $udates ++;
            } catch (Exception $e) {
                // $readers = $this->universal_model->deletez('company_reader', 'id', $reader['id']);
                // $removedreaders .= $reader['device_ipaddress'];
                // echo 'Removed : ' . $e->getMessage();
            }
        }
        $this->reporttome("Number Syncronised #" . $udates . ' ' . json_encode($readers) . '#Removed ' . $removedreaders, "syncreaders@Welcome");
        $readers = $this->universal_model->selectall('*', 'company_reader');
        return $readers;
    }

    public function getallreaders() {
        $value = $this->universal_model->selectall('*', 'company_reader');
        // print_array($value);
        return $value;
    }

    public function getdomain() {
        $value = $this->universal_model->selectall('*', 'util_tools');
        if (empty($value)) {
            return '';
        } else {
            return $value[0]['hostdomain'];
        }
    }

    public function addclouddomain() {
        $clientwebsite = $this->input->post('clientwebsite');
        $array = array(
            'id' => 1,
            'hostdomain' => $clientwebsite
        );
        $value = $this->db->replace('util_tools', $array);
        if ($value >= 1) {
            $json_return = array(
                'report' => 'Cloud Storage Added Successfully',
                'status' => 2
            );
            echo json_encode($json_return);
        } else {
            $json_return = array(
                'report' => "Failed Contact Afrobiz",
                'status' => 1
            );
            echo json_encode($json_return);
        }
    }

    public function addreader() {
        $ipaddress = $this->input->post('ipaddress');
        // $portnumber = $this->input->post('portnumber');
        $array = array(
            'device_ipaddress' => $ipaddress,
            'company_name' => 'Afrobiz Company'
        );
        $result = $this->universal_model->select_like('device_ipaddress', 'company_reader', $ipaddress);
        if (empty($result)) {
            $value = $this->universal_model->insertz('company_reader', $array);
            if ($value >= 1) {
                $json_return = array(
                    'report' => 'Added Successfully',
                    'status' => 2
                );
                echo json_encode($json_return);
            } else {
                $json_return = array(
                    'report' => "Failed Contact Afrobiz",
                    'status' => 1
                );
                echo json_encode($json_return);
            }
        } else {
            $json_return = array(
                'report' => "IP Address Already Exists",
                'status' => 1
            );
            echo json_encode($json_return);
        }
    }

    public function removereader() {
        $reader_id = $this->input->post('reader_id');
        $result = $this->universal_model->deletez('company_reader', 'id', $reader_id);
    }

    function quicksqlpdo($localhost, $username, $password, $sqlquery) {
        $servername = $localhost;
        $username = $username;
        $password = $password;
        $pdo2 = new PDO("mysql:host=$servername;dbname=desktoptime", $username, $password);
        $pdo2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo2->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $sql = $sqlquery;
        $statement = $pdo2->prepare($sql);
        $statement->execute();
        $pdo2 = null;
    }

    function reporttome($message, $methodclass) {
        try {
            // Message
            $message_array = array(
                'message' => $message,
                'methodclass' => $methodclass
            );
            $this->universal_model->insertz('util_monitor', $message_array);
            print_array($message_array);
        } catch (Exception $e) {
            $message_array = array(
                $e->getMessage(),
                $e->getTraceAsString()
            );
            print_array($message_array);
        }
    }

}
