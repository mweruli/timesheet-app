<?php
$response = Requests::get(base_url('timesheetcore/pigi'));
$array_data = json_decode($response->body, true);
print_array($array_data);
// $response = Requests::get(base_url('welcome/threei/') . $value['id']);
//$array_data = json_decode($response->body, true);
