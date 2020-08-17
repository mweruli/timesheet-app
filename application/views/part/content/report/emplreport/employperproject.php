<?php
//print_array($all_availableprojects);
//$idccc = 1;
$project_id = $this->session->userdata('employee_idxx');
$newproject = array();
foreach ($all_availableprojects as $valuehh) {
    if ($valuehh['id'] == $project_id) {
        array_push($newproject, $valuehh);
    }
}
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel-body" id="perproject_id">
            <!--<tbody>-->
            <?php
            foreach ($newproject as $value) {
                $number_task_completed = $controller->gettaskscompleted($value['id']);
                $number_people = $controller->getnumberproject($value['id']);
                $number_tasks = $controller->getnumbertasks($value['id']);
                ?>
                <!--<div class="panel panel-default">-->
                <div class="panel-heading">
                    <div class="panel-title">
                        <a href="#faq_1_5<?= $value['id'] ?>" data-parent="#accordion" data-toggle="collapse" class="accordion-toggle collapsed">
                            <i class="icon-arrow"></i> <?= $value['project_name']; ?>
                        </a>
                        <a class="pull-right btn" href="#" onclick="printJS({printable: 'perproject_id', type: 'html', header: '<?= $value['project_name'] . ' company: ' . $value['clientname']; ?>', maxWidth: '1000', honorMarginPadding: false, targetStyles: ['*'], ignoreElements: ['']})">
                            <i class="fa fa-print"></i>
                        </a>
                    </div>
                </div>
                <div class="panel-collapse collapse in" id="faq_1_5<?= $value['id'] ?>">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-green">
                                <div class="panel-heading">
                                    <h5 class="panel-title">General <span class="text-bold">Statistics</span></h5>
                                </div>
                                <div class="panel-body">
                                    <?= '&nbsp;<b>Client Name:</b>&nbsp;' . $value['clientname'] . ' | ' . '&nbsp;<b>People On The Project:</b>&nbsp;' . $number_people . ' | ' . '&nbsp;<b>Number Of Tasks:</b>&nbsp;' . $number_tasks . ' | ' . '&nbsp;<b>Number Of Completed Tasks:</b>&nbsp;' . $number_task_completed . ' | ' . '&nbsp;<b>Start Date</b>&nbsp;' . date("F jS, Y", strtotime($value['start_date'])) . ' | ' . '&nbsp;<b>End Date</b>&nbsp;' . date("F jS, Y", strtotime($value['end_date'])) ?>                                                          
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
//                                            $perproject = base_url('welcome/papa/' . $value['id']);
                    $array_data = $controller->threeiclone($value['id']);
//                        print_array($array_data);
                    ?>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="sample_2_m">
                                <thead>
                                    <tr>
                                        <th>Names</th>
                                        <th>Project Task</th>
                                        <th>Approved</th>
                                        <th>Closed</th>
                                        <th>Unit Cost</th>
                                        <th>Sum Cost</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
//                                    print_array($array_data);
                                    foreach ($array_data as $value) {
                                        ?>
                                        <tr>
                                            <td><?= $value['firstname'] . ' ' . $value['lastname'] ?></td>
                                            <td>
                                                <?php
                                                //Above minors
                                                $string_one = $value['project_task'];
                                                $array_datamm = json_decode($string_one, true);
                                                $totaldam = 0;
                                                foreach ($array_datamm as $valuep) {
                                                    $posted_valuesn = array(
                                                        'project_id' => $value['id_project'],
                                                        'task_workedone' => $valuep,
                                                        'employee_id' => $value['id_employee']
                                                    );
                                                    $total_cutter = $controller->totaltimepertask_clonexx($value['id_project'], $valuep, $value['id_employee']);
                                                    $totaldam += $total_cutter;
                                                    ?>
                                                    &nbsp;&nbsp;<a href="#"><?= $valuep . ' - ' . '<font size="2" color="blue">' . $total_cutter . ' hrs' . '</font><br>' ?></a>
                                                    <?php
                                                    $aclosed = $controller->closetak($value['id'], $valuep);
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if ($value['approved'] == 1) {
                                                    echo 'Yes';
                                                } else {
                                                    echo 'No';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if ($aclosed == 0) {
                                                    echo 'No';
                                                } else {
                                                    echo 'Yes';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                $string_onem = $value['employmenttype_id'];
                                                $utilsetting = $controller->getutilsetting($string_onem);
                                                $unit_cost = $utilsetting[0]['rateamount'];
                                                echo $unit_cost;
//                                                echo $totaldam;
                                                ?>
                                            </td>
                                            <td>
                                                <?= $totaldam * $unit_cost; ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!--</div>-->
                <?php
            }
            ?>
            <!--</tbody>-->
        </div>
        <!--</div>-->
    </div>
</div>
<script>
    $(document).ready(function () {
        //Data Table Initialised
        //$('p').append('');
//        $('#sample_2_m').DataTable();
//        $('#sample_2_mm').DataTable();
    });
    window.onload = function () {
        var reloading = sessionStorage.getItem("reloadm");
        if (reloading) {
            sessionStorage.removeItem("reloadm");
            myreloadm();
        }
    }
    function reloadm() {
        sessionStorage.setItem("reloadm", "true");
        document.location.reload();
    }
    function myreloadm() {
        var l = document.getElementById('report_per_project_xx_tt');
        l.click();
    }
</script>
<!-- end: PAGE CONTENT-->
