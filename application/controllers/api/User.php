<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author joash
 */
class User extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('universal_model');
        $this->event = new EventDispatcher();
    }

    public function index()
    {
        echo '<h1>User Section ....</h1>';
    }

    public function test()
    {
        try {
            for ($x = 0; $x <= 10000000; $x ++) {
                echo "The number is: $x <br>";
            }
        } catch (Exception $e) {
            $e->getMessage();
        } finally {
            $this->testimoney(0);
            // $this->event->dispatch('event_name');
        }
    }

    public function testimoney($id)
    {
        if ($id == 0) {
            $this->event->addListener('event_name', $this->pickstuf());
        } else {
            echo 'bankuza';
        }
    }

    public function pickstuf()
    {
        $attendencelog = $this->universal_model->selectall('*', 'attendencelog');
        echo json_encode($attendencelog);
    }

    // put your code here
}
