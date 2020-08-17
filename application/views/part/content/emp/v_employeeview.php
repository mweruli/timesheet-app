<?php
//print_array($all_availableprojects);
$user_idxxx = $this->session->userdata('user_idxxxx');
//echo $user_idxxx;
$array_userprofile = $controller->getmeusercreds($user_idxxx);
$liveprojectnum = $controller->x_countprojects($user_idxxx, 0, 0);
$closedprojectnum = $controller->x_countprojects($user_idxxx, 1, 0);
$closeprojectarray = $controller->x_countprojects($user_idxxx, 1, 1);
$liveprojectarray = $controller->x_countprojects($user_idxxx, 1, 1);
//print_array($liveprojectarray);
?>
<div class="panel-body no-padding" id="one_employeexx">
    <div class="padding-10">
        <img width="50" height="50" alt="" class="img-circle pull-left" src="<?= base_url() ?>upload/<?= $array_userprofile['user_image_medium'] ?>">
        <h4 class="no-margin inline-block padding-5"><div><?= $array_userprofile['lastname'] . ' ' . $array_userprofile['firstname'] ?></div> 
            <span class="block text-small text-left">
                <?php
//                echo $array_userprofile['employmenttype_id'];
                $utilsetting = $controller->getutilsetting($array_userprofile['employmenttype_id']);
                echo $utilsetting[0]['design'];
                ?>
            </span>
        </h4>
        <div class="pull-right padding-15">
            <span class="text-small text-bold text-green"><i class="fa fa-dot-circle-o"></i> on-line</span>
        </div>
    </div>
    <div class="clearfix padding-5 space5">
        <div class="col-xs-6 text-center no-padding">
            <div class="border-right border-dark">
                <a href="#" class="text-dark">
                    Total Current Projects&nbsp;<i class="fa fa-heart-o text-red"></i>&nbsp;<?= $liveprojectnum ?>
                </a>
            </div>
        </div>
        <div class="col-xs-6 text-center no-padding">
            <div class="border-right border-dark">
                <a href="#" class="text-dark">
                    Total Closed Projects&nbsp;<i class="fa fa-bookmark-o text-green"></i>&nbsp;<?= $closedprojectnum ?>
                </a>
            </div>
        </div>
    </div>
    <div class="tabbable no-margin no-padding partition-white">
        <ul class="nav nav-tabs" id="myTab">
            <li class="active">
                <a data-toggle="tab" href="#users_tab_example11">
                    Projects Being Worked On
                </a>
            </li>
            <li class="">
                <a data-toggle="tab" href="#users_tab_example22">
                    Projects Closed
                </a>
            </li>
        </ul>
        <div class="tab-content partition-white">
            <div id="users_tab_example11" class="tab-pane padding-bottom-5 active">
                <table class="table table-striped table-hover" id="walah_one">
                    <tbody>
                    <thead>
                        <tr>
                            <th>Client</th>
                            <th>Project Name</th>
                            <th>Tasks</th>
                            <th>End Date</th>
                            <th>Amount</th>
                            <!--<th>View Status</th>-->
                        </tr>
                    </thead>
                    <?php
//                    print_array($liveprojectarray);
                    foreach ($liveprojectarray as $valueyy) {
                        $clienarray = $controller->getclient_bynumberjson($valueyy['id_client']);
//                        print_array($clienarray);
                        //Let Us Try This
                        $taskopenreturndata = $controller->getme($user_idxxx, 0, $valueyy['id_client']);
                        $sliptdataone = explode('|', $taskopenreturndata);
                        $taskopenarray = json_decode($sliptdataone[0], true);
                        $totalhours = $sliptdataone[1];
                        ?>
                        <tr>
                            <td class="center">
                                <img src="<?= base_url() ?>upload/client/<?= $clienarray[0]['client_image_medium'] ?>" class="img-circle" alt="image" width="40" height="40"/>
                                <?= $clienarray[0]['clientname'] ?>
                            </td>
                            <td><span class="text-large"><?= $valueyy['project_name'] ?></span></td>
                            <td>
                                <span class="text-large">
                                    <?php
                                    $string_tasks = "";
                                    foreach ($taskopenarray as $valueb) {
                                        $string_tasks .= $valueb . " ";
                                    }
                                    echo '<a href="#">' . $string_tasks . '</a>';
                                    ?>
                                </span>
                            </td>
                            <td>
                                <span class="text-large">
                                    <?php
                                    echo date("F jS, Y", strtotime($valueyy['end_date']));
                                    ?>
                                </span></td>
                            <td>
                                <span class="text-large">
                                    <?php
//                                    $myprice_url = Requests::get(base_url('employee/get_employeepricecloned/') . $valueyy['id_employee']);
                                    $theprice = $controller->get_employeepricecloned($valueyy['id_employee']);
                                    $total_cost = $totalhours * $theprice;
                                    echo $total_cost;
                                    ?>
                                </span>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
            <div id="users_tab_example22" class="tab-pane padding-bottom-5">
                <table class="table table-striped table-hover" id="walah_two">
                    <tbody>
                    <thead>
                        <tr>
                            <th>Client</th>
                            <th>Project Name</th>
                            <th>Tasks</th>
                            <th>End Date</th>
                            <th>Amount Due</th>
                            <th>View Status</th>
                        </tr>
                    </thead>
                    <?php
//                    print_array($closeprojectarray);
                    foreach ($closeprojectarray as $valuexx) {
                        $clienarray = $controller->getclient_bynumberjson($valuexx['id_client']);
//                        print_array($clienarray);
                        $taskclosereturndata = $controller->getme($user_idxxx, 1, $valuexx['id_client']);
                        $sliptdataoneclose = explode('|', $taskclosereturndata);
                        $taskclosearray = json_decode($sliptdataoneclose[0], true);
                        $totalhoursclose = $sliptdataoneclose[1];
                        ?>
                        <tr>
                            <td class="center">
                                <img src="<?= base_url() ?>upload/client/<?= $clienarray[0]['client_image_medium'] ?>" class="img-circle" alt="image" width="40" height="40"/>
                                <?= $clienarray[0]['clientname'] ?>
                            </td>
                            <td><span class="text-large"><?= $valuexx['project_name'] ?></span></td>
                            <td>
                                <span class="text-large">
                                    <?php
                                    $string_tasks = "";
                                    foreach ($taskclosearray as $valueb) {
                                        $string_tasks .= $valueb . " ";
                                    }
                                    echo '<a href="#">' . $string_tasks . '</a>';
                                    ?>
                                </span>
                            </td>
                            <td><span class="text-large">
                                    <?php
                                    echo date("F jS, Y", strtotime($valuexx['end_date']));
                                    ?></span>
                            </td>
                            <td>
                                <span class="text-large">
                                    <?php
                                    $thepriceclosed = $controller->get_employeepricecloned($valuexx['id_employee']);
                                    $total_costclosed = $totalhoursclose * $thepriceclosed;
                                    echo $total_costclosed;
                                    ?>
                                </span>
                            </td>
                            <td>
                                <a href="#" class="btn" onclick="flagpay('<?= $valuexx['id'] ?>', '<?= $valuexx['paid']; ?>', '<?= $valuexx['project_name'] ?>')">
                                    <i class="fa fa-money"></i>
                                    <?php
                                    if ($valuexx['paid'] == 0) {
                                        echo 'No paid yet';
                                    } else {
                                        echo 'Paid';
                                    }
                                    ?>
                                </a>
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
</div>
<script>
    var project_payupdate = '<?php echo base_url("employee/updatepay"); ?>';
    $(document).ready(function () {
//        var session_id = sessionStorage.getItem("SessionName");
//        alert(session_id);
//        alert('<?= $this->session->userdata('user_idxxxx') ?>');
        $('#walah_one').DataTable();
        $('#walah_two').DataTable();
    });

    function flagpay(id, statuspaid, projectname) {
        var dialog = bootbox.dialog({
            title: 'Confirm  Project: ' + '<b>Pay</b>',
            message: "<p>" + "<h4>" + projectname + "</h4>" + "</p>",
            buttons: {
                cancel: {
                    label: '<i class="fa fa-check"></i> Update Pay',
                    className: 'btn-success',
                    callback: function () {
                        $.post(project_payupdate,
                                {
                                    id_project: id,
                                    state: 1
                                },
                                function (data, status) {
//                                    alert()
                                    $.notify(projectname + " Updated Successfully", "success");
                                    // $("#project_assgn").load(location.href + " #project_assgn");
                                    // var l = document.getElementById('approveemployee_link');
                                    // l.click();
                                    reloadpp();
                                });
                    }
                },
                ok: {
                    label: '<i class="fa fa-times"></i> Cancel',
                    className: 'btn-info',
                    callback: function () {
                        $.post(project_payupdate,
                                {
                                    id_project: id,
                                    state: 0
                                },
                                function (data, status) {
//                                    alert()
                                    $.notify(projectname + " Canceled Successfully", "success");
                                    $("#project_assgn").load(location.href + " #project_assgn");
                                    var l = document.getElementById('approveemployee_link');
                                    l.click();
                                });
                    }
                }
            }
        });
    }
</script>

