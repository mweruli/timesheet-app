<?php
//print_array($all_active_clients);
$projectsession = $this->session->userdata('projectsession');
$array_projectsession = json_decode($projectsession, true);
//print_array($array_projectsession);
//print_array($humble_valuable);
$humble_valuable = in_array_r($array_projectsession['id_client'], $all_active_clients);
//print_array($humble_valuable);
?>
<div class="panel panel-dark">
    <div class="panel-heading">
        <h4 class="panel-title"><?= $humble_valuable[0]['project_name'] ?></h4> Status:<b>
            <?php
            if ($array_projectsession['status'] == 0) {
                echo 'Open';
            } else {
                echo 'Closed';
            }
            ?>
        </b>
        <div class="panel-tools">
            <div class="dropdown">
                <a data-toggle="dropdown" class="btn btn-xs dropdown-toggle btn-transparent-white">
                    <i class="fa fa-cog"></i>
                </a>
                <ul class="dropdown-menu dropdown-light pull-right" role="menu">
                    <li>
                        <a class="panel-expand" href="#">
                            <i class="fa fa-expand"></i> <span>Fullscreen</span>
                        </a>
                    </li>
                    <li>
                        <a class="panel-refresh" href="#" onclick="deleteProject('<?= $humble_valuable[0]['project_id'] ?>', '<?= $humble_valuable[0]['project_name'] ?>', '<?= $humble_valuable[0]['clientname'] ?>')">
                            <i class="fa fa-refresh"></i> <span>Delete Project</span>
                        </a>
                    </li>
                </ul>
            </div>
            <!--            <a class="btn btn-xs btn-link panel-close" href="#">
                            <i class="fa fa-times"></i>
                        </a>-->
        </div>
    </div>
    <div class="panel-body no-padding">
        <?php
        $taskavailablearray = $controller->getmeone($humble_valuable[0]['project_id']);
//        print_array($taskavailablearray);
        //Time 
        ?>
        <div class="partition-green padding-15 text-center">
            <h4 class="no-margin"><?= $humble_valuable[0]['clientname'] ?></h4>
            <span class="text-light">Client Name</span>
        </div>
        <div id="accordion" class="panel-group accordion accordion-white no-margin">
            <div class="panel no-radius">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a href="#collapseOnev" data-parent="#accordion" data-toggle="collapse" class="accordion-toggle padding-15">
                            <i class="icon-arrow"></i>
                            Number Of Tasks <span class="label label-danger pull-right"><?= count($taskavailablearray) ?></span>
                        </a>
                    </h4>
                </div>
                <div class="panel-collapse collapse in" id="collapseOne">
                    <div class="panel-body no-padding partition-light-grey">
                        <table class="table" id="table_project_tasks">
                            <tbody>
                            <thead>
                                <tr>
                                    <th>Task</th>
                                    <th>Total Time Taken</th>
                                    <th>Attended To</th>
                                    <th>Status</th>
                                    <th>Urgent</th>
                                    <!--<th>View Status</th>-->
                                </tr>
                            </thead>
                            <?php
//                                print_array($taskavailablearray);
                            foreach ($taskavailablearray as $value_mealso) {
                                ?>
                                <tr>
                                    <td class="left"><?= $value_mealso['task'] ?></td>
                                    <td class="left">
                                        <?php
                                        $taskavailablereturndataperson = $controller->totaltimepertaskone($value_mealso['project_id'], $value_mealso['task']);
                                        echo $taskavailablereturndataperson;
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $time_check = (int) $taskavailablereturndataperson;
                                        if ($time_check <= 0) {
                                            echo 'No Taken';
                                        } else {
                                            echo 'In Progress';
                                        }
                                        ?>
                                    </td>
                                    <td class="left">
                                        <?php
                                        if ($value_mealso['closed'] == 0) {
                                            echo 'Still Pending';
                                        } else {
                                            echo 'Finished';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <i class="fa fa-caret-down 
                                           <?php
                                           if ($value_mealso['closed'] == 0) {
                                               echo 'text-red';
                                           } else {
                                               echo 'text-blue';
                                           }
                                           ?>">
                                        </i>
                                    </td>
                                </tr>
                                <?php
                            }
//                                print_array($taskavailablearray);
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    window.onload = function () {
        var reloadppn = sessionStorage.getItem("jack");
        if (reloadppn) {
            sessionStorage.removeItem("jack");
            menone();
        }
    }
    function menone() {
        var l = document.getElementById('project_view_id');
        l.click();
    }
    var url = '<?php echo base_url("welcome/deleteproject"); ?>';
    function deleteProject(id, name, clientname) {
        // var the_divm = '"' + the_div + '"';
        //alert(the_divm);
        var dialog = bootbox.dialog({
            title: 'Confirm Deleting ' + name,
            message: "<p>" + "<h4>" + name + " Is Owned By " + clientname + "</h4>" + "</p>",
            buttons: {
                cancel: {
                    label: '<i class="fa fa-check"></i> Delete',
                    className: 'btn-danger',
                    callback: function () {
                        $.post(url,
                                {
                                    valueid: id
                                },
                                function (data, status) {
                                    $.notify(name + " Deleted Successfully", "success");
                                    setTimeout(location.reload.bind(location), 1200);
                                });
                    }
                },
                ok: {
                    label: '<i class="fa fa-times"></i> Cancel',
                    className: 'btn-info'
                }
            }
        });
    }
</script>
