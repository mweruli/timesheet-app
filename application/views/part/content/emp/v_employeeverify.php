<?php
//print_array($all_availableprojects);
?>
<div class="row">
    <div class="col-md-12">
        <!-- start: DYNAMIC TABLE PANEL -->
        <!--<div class="panel panel-white">-->
        <div class="panel-heading">
            <h4 class="panel-title">Approve <span class="text-bold">Assignments</span></h4>
        </div>
        <div class="panel-body">
            <div class="table-responsive" id="project_assgn">
                <table class="table table-striped table-hover" id="sample_2_mm">
                    <thead>
                        <tr>
                            <th>Project Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($all_availableprojects as $value) {
                            $number_task_completed = $value['number_task_completed'];
                            $number_people = $value['number_people'];
                            $number_tasks = $value['number_tasks'];
//                            $number_tasks = 1;
//                            $number_task_completed = $value['number_task_completed'];
                            ?>
                            <tr>
                                <td>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <div class="panel-title">
                                                <a href="#faq_1_5<?= $value['id'] ?>" data-parent="#accordion" data-toggle="collapse" class="accordion-toggle collapsed">
                                                    <i class="icon-arrow"></i> <?= $value['project_name']; ?>
                                                </a>
                                                <a class="pull-right btn" href="#" onclick="closeproject('<?= $value['id'] ?>', '<?= $value['project_name']; ?>')">
                                                    <i class="fa fa-times"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="panel-collapse collapse" id="faq_1_5<?= $value['id'] ?>">
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
                                            <div class="panel-body">
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-hover" id="sample_2_m">
                                                        <thead>
                                                            <tr>
                                                                <th>Names</th>
                                                                <th>Project Task</th>
                                                                <th>Approved</th>
                                                                <th>Closed</th>
                                                                <th>Date Taken</th>
                                                                <th>Un Award</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            foreach ($value['array_dataone'] as $value) {
                                                                ?>
                                                                <tr>
                                                                    <td><?= $value['firstname'] . ' ' . $value['lastname'] ?></td>
                                                                    <td><?php
                                                                        //Above minors
                                                                        $string_one = $value['project_task'];
                                                                        $array_datamm = json_decode($string_one, true);
                                                                        $att = '';
                                                                        foreach ($array_datamm as $valuep) {
//                                                                            $att .= $valuep;
                                                                            ?>
                                                                            &nbsp;&nbsp;<a href="#" onclick="checkTask('<?= $valuep ?>', '<?= $value['id_project'] ?>', '<?= $value['user_id'] ?>', '<?= $value['project_name'] ?>', '<?= $value['date_taken'] ?>', '<?= $value['id_client'] ?>')"><?= $valuep ?></a>
                                                                            <?php
                                                                            $arrayclosed = array(
                                                                                'closed'
                                                                            );
                                                                            $this->db->select($arrayclosed);
                                                                            $this->db->from('project_milestone');
                                                                            $this->db->where('project_id', $value['id']);
                                                                            $this->db->where('task', $valuep);
                                                                            $query = $this->db->get()->result_array();
                                                                            //print_array();
                                                                            $aclosed = 1;
                                                                            foreach ($query as $valueclose) {
                                                                                $aclosed = $valueclose['closed'];
                                                                            }
                                                                            //echo $aclosed;
                                                                            //$aclosed = $query[0]['closed'];
                                                                            //Check For Closures
                                                                            //$aclosed = 1;
                                                                            $this->db->select('*');
                                                                            $this->db->from('project_milestone');
                                                                            $this->db->where('project_id', $value['id']);
                                                                            $this->db->where('closed', 0);
                                                                            $query = $this->db->get()->result_array();
                                                                            if (empty($query)) {
                                                                                $update_array = array(
                                                                                    'status' => 1
                                                                                );
                                                                                $this->db->where('id', $value['id']);
                                                                                $this->db->update('project', $update_array);
                                                                            }
                                                                        }
//                                                                        echo $att;
//                                                                        $data_x = $value['project_task']
                                                                        ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php
                                                                        if ($value['approved'] == 1) {
                                                                            echo 'Yes';
                                                                        } else {
                                                                            echo 'No';
                                                                        }
                                                                        ?></td>
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
                                                                        <?= date("F jS, Y", strtotime($value['date_taken'])) ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php
                                                                        if ($aclosed != 0) {
                                                                            
                                                                        } else {
                                                                            ?>
                                                                            <a href="#" onclick="checkTaskremove('<?= $value['user_id'] ?>', '<?= $string_one; ?>', '<?= $value['id_project'] ?>', '<?= $value['firstname'] . ' ' . $value['lastname'] ?>', '<?= $value['project_name'] ?>')">Remove</a>

                                                                            <?php
                                                                        }
                                                                        ?>
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
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!--</div>-->
    </div>
</div>
<form id="userFormTask" method="post" class="form-horizontal" style="display: none;">
    <div class="form-group" hidden="true">
        <label class="col-sm-2 control-label" for="form-field-1">
            ID
        </label>
        <div class="col-sm-9">
            <input type="text" class="form-control" name="id_client" id="id_client" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="form-field-1">
            Client Name
        </label>
        <div class="col-sm-9">
            <input type="text" class="form-control" name="client_name" id="client_name" readonly="readonly"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="form-field-1">
            Project Name
        </label>
        <div class="col-sm-9">
            <input type="text" class="form-control" name="project_name" id="project_name" readonly="readonly"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="form-field-1">
            Task
        </label>
        <div class="col-sm-9">
            <input type="text" class="form-control" name="task" id="task" placeholder="In Hours Example 0.2 hours or 1 Hours" readonly="readonly"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="form-field-1">
            Time Spent
        </label>
        <div class="col-sm-9">
            <input type="text" class="form-control" name="time_spent" id="time_spent" placeholder="In Hours Example 0.2 hours or 1 Hours" readonly="readonly"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="form-field-1">
            Total Cost
        </label>
        <div class="col-sm-9">
            <input type="text" class="form-control" name="total_cost" id="total_cost"  readonly="readonly"/>
        </div>
    </div>
</form>
<script>
    var url = '<?php echo base_url("employee/unaward_project"); ?>';
    var project_close = '<?php echo base_url("employee/close_project"); ?>';
    var url_revocktask = '<?php echo base_url("employee/unaward_task"); ?>';
    var url_task_detail = '<?php echo base_url("employee/taskdetail"); ?>';
    var url_approvetask = '<?php echo base_url("employee/approvetask"); ?>';
    $(document).ready(function () {
        //Data Table Initialised
        //$('p').append('');
        $('#sample_2_m').DataTable({
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "pageLength": 7
//            "paging": false,
//            "info": false
        });
        $('#sample_2_mm').DataTable({
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "pageLength": 7
//            "paging": false,
//            "info": false
        });
    });
    function checkTaskremove(user_id, tasks, project_id, names, project_name) {
//        alert(user_id + " " + tasks + " " + project_id + " " + names + " " + project_name);
        var dialog = bootbox.dialog({
            title: 'Confirm Revock Project: ' + '<b>' + project_name + '</b>',
            message: "<p>" + "From <h4>" + names + "</h4>" + "</p>",
            buttons: {
                cancel: {
                    label: '<i class="fa fa-check"></i> Revock',
                    className: 'btn-warning',
                    callback: function () {
                        $.post(url,
                                {
                                    id_project: project_id,
                                    id_employee: user_id,
                                    tasks: tasks
                                },
                                function (data, status) {
                                    $.notify(project_name + " Revocked Successfully", "success");
                                    $("#project_assgn").load(location.href + " #project_assgn");
                                    var l = document.getElementById('approveemployee_link');
                                    l.click();
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
    function checkTaskm(task, project_id, user_id, project_name, date_taken, client_id) {

    }
    function checkTask(task, project_id, user_id, project_name, date_taken, client_id) {
//            alert(obed + obedff);
//            var task_specificone = $(this).attr('data-mm');
//            alert(task_specificone.toString());
        bootbox.dialog({
            title: 'Update Done Tasks',
            message: $('#userFormTask'),
            show: false, // We will show it manually later
            buttons: {
                cancel: {
                    label: '<i class="fa fa-check"></i> Revock',
                    className: 'btn-danger',
                    callback: function () {
                        $.post(url_revocktask,
                                {
                                    id_project: project_id,
                                    user_id: user_id,
                                    task: task,
                                    date_taken: date_taken
                                },
                                function (data, status) {
                                    //alert(data);
                                    $.notify(task + " Revocked Successfully", "success");
                                    $("#project_assgn").load(location.href + " #project_assgn");
                                    var l = document.getElementById('addemployee_link');
                                    l.click();
                                });
                    }
                }
                ,
                approve: {
                    label: '<i class="fa fa-times"></i> Approve',
                    className: 'btn-info',
                    callback: function () {
                        $.post(url_approvetask,
                                {
                                    id_project: project_id,
                                    id_employee: user_id,
                                    task: task
                                },
                                function (data, status) {
                                    $.notify(task + " Approved Successfully", "success");
                                    reloadm();
                                });
                    }
                }
            }
        }).on('shown.bs.modal', function () {
            $('#userFormTask')
                    .show()                             // Show the login form
                    .formValidation('resetForm'); // Reset form
        }).on('hide.bs.modal', function (e) {
            // Bootbox will remove the modal (including the body which contains the login form)
            // after hiding the modal
            // Therefor, we need to backup the form
            $('#userFormTask').hide().appendTo('body');
        }).modal('show');
        $.ajax({
            url: url_task_detail,
            dataType: "JSON",
            method: 'POST',
            data: jQuery.param({task: task, project_id: project_id, client_id: client_id, user_id: user_id}),
        }).done(function (response) {
//            var reponsex = JSON.stringify(response);
//            alert(reponsex);
            $('#userFormTask')
                    .find('[name="time_spent"]').val(response.total_time).end()
                    .find('[name="client_name"]').val(response.client_name).end()
                    .find('[name="project_name"]').val(project_name).end()
                    .find('[name="total_cost"]').val(response.total_cost).end()
                    .find('[name="task"]').val(task).end();
        });
    }
    function checkTaskm(task, project_id, user_id, project_name, date_taken) {
        var dialog = bootbox.dialog({
            title: 'Confirm Task :' + '<b>' + task + '</b> of ' + project_name,
            message: "<p>" + "<h4>" + project_id + "</h4>" + "</p>",
            buttons: {
                cancel: {
                    label: '<i class="fa fa-check"></i> Revock',
                    className: 'btn-danger',
                    callback: function () {
                        $.post(url_revocktask,
                                {
                                    id_project: project_id,
                                    user_id: user_id,
                                    task: task,
                                    date_taken: date_taken
                                },
                                function (data, status) {
                                    $.notify(task + " Revocked Successfully", "success");
                                    reloadm();
                                });
                    }
                }
                ,
                approve: {
                    label: '<i class="fa fa-times"></i> Approve',
                    className: 'btn-info',
                    callback: function () {
                        $.post(url_approvetask,
                                {
                                    id_project: project_id,
                                    id_employee: user_id,
                                    task: task
                                },
                                function (data, status) {
                                    $.notify(task + " Approved Successfully", "success");
                                    reloadm();
                                });
                    }
                }
            }
        });
    }
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
        var l = document.getElementById('approveemployee_link');
        l.click();
    }
    function closeproject(projectid, projectname) {
        var dialog = bootbox.dialog({
            title: 'Confirm  Project: ' + '<b>Closure</b>',
            message: "<p>" + "<h4>" + projectname + "</h4>" + "</p>",
            buttons: {
                cancel: {
                    label: '<i class="fa fa-check"></i> Close',
                    className: 'btn-danger',
                    callback: function () {
                        $.post(project_close,
                                {
                                    id_project: projectid,
                                },
                                function (data, status) {
                                    $.notify(projectname + " Closed Successfully", "success");
                                    $("#project_assgn").load(location.href + " #project_assgn");
                                    var l = document.getElementById('approveemployee_link');
                                    l.click();
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
<!-- end: PAGE CONTENT-->
