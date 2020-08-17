<?php
//print_array($all_active_clients);
?>
<script src="https://cdn.jsdelivr.net/bootstrap.tagsinput/0.4.2/bootstrap-tagsinput.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/bootstrap.tagsinput/0.4.2/bootstrap-tagsinput.css">
<style>
    .bootstrap-tagsinput {
        width: 100% !important;
    }
</style>
<div class="panel-heading" id="id_project_on">
    <h4 class="panel-title">Projects <span class="text-bold">In Progress</span></h4>
    <div class="btn-group pull-right" style="margin-top: -10px;">
        <button data-toggle="dropdown" class="btn btn-green dropdown-toggle">
            Export <i class="fa fa-angle-down"></i>
        </button>
        <ul class="dropdown-menu dropdown-light pull-right">
            <li>
                <a href="#" id="exportpdf" onclick="printJS({printable: 'projects_closed', type: 'html', header: 'Projects In Progress', maxWidth: '1000', honorMarginPadding: false, targetStyles: ['*']})">
                    Save as PDF
                </a>
            </li>
            <!--            <li>
                            <a href="#" class="export-excel" onclick="export_damclineteeh()">
                                Export to Excel
                            </a>
                        </li>-->
        </ul>
    </div>
</div>
<div class="panel-body" id="id_project_on_lower">
    <!--<div id="panel_projects" class="tab-pane fade">-->
    <table class="table table-striped table-bordered table-hover" id="projects_closed">
        <thead>
            <tr>
                <th class="col-sm-2">Project Name</th>
                <!--<th class="hidden-xs">Pricing</th>-->
                <th>Start End Date</th>
                <th class="col-sm-2">Client Name</th>
                <th class="hidden-xs center">Email and Contact</th>
                <th>Client Type</th>
                <!--<th>View Project</th>-->
                <!--<th>Priority</th>-->
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($all_active_clients as $value) {
                ?>
                <tr>
                    <td>
                        <a href="#">
                            <?= $value['project_name'] ?>&nbsp;&nbsp;<i class="fa fa-edit" data-id="<?= $value['project_id'] ?>"></i>
                        </a>
                    </td>
                    <!--<td class="hidden-xs"><?= $value['project_pricing'] ?></td>-->
                    <td><?= date("F jS, Y", strtotime($value['start_date'])) . ' <b><font size="2" color="blue">to</font></b> ' . date("F jS, Y", strtotime($value['end_date'])) ?></td>
                    <td class="hidden-xs">
                        <?= $value['clientname'] ?> 
                    </td>
                    <td class="center hidden-xs"><?= $value['client_email'] . ' | ' . $value['client_contact'] ?></td>
                    <td class="center hidden-xs"> <?= $value['client_type'] ?><a href="#" onclick="viewproject('<?= $value['project_id'] ?>')">
                            <i class="fa fa-share"></i>View Project
                        </a>
                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
    <!--</div>-->
</div>
<form id="editprojectform" class="form-horizontal" method="post" enctype="multipart/form-data" accept-charset="utf-8"  style="display: none;">
    <div class="form-group" hidden="true">
        <label class="col-xs-3 control-label" for="form-field-1">
            ID
        </label>
        <div class="col-xs-8">
            <!--hidden="true"-->
            <input type="text" class="form-control" name="id" id="id" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-xs-3 control-label" for="form-field-1">
            PROJECT NAME
        </label>
        <div class="col-xs-8">
            <input type="text" class="form-control" name="project_name" id="project_name" readonly="true"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-xs-3 control-label" for="form-field-1">
            START DATE
        </label>
        <div class="col-xs-8">
            <div class="input-group input-append date" id="start_date">
                <input type="text"  name="start_date" class="form-control">
                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
            </div>
            <!--<input type="text" class="form-control" name="start_date" id="start_date"/>-->
        </div>
    </div>
    <div class="form-group">
        <label class="col-xs-3 control-label" for="form-field-1">
            END DATE
        </label>
        <div class="col-xs-8">
            <div class="input-group input-append date" id="end_date">
                <input type="text"  name="end_date" class="form-control">
                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
            </div>
            <!--<input type="text" class="form-control" name="start_date" id="start_date"/>-->
        </div>
    </div>
    <div class="form-group">
        <label class="col-xs-3 control-label" for="form-field-1">
            TASKS
        </label>
        <div class="col-xs-8">
            <!--            <div id="tags_damit">
                            <input type="text" class="form-control" id="tags_1" name="tasks_miles" id="tasks_miles" value=""  />
                        </div>-->
            <input type="text"  name="tasks_miles" id="tasks_miles" data-role="tagsinput" style="width: 100px;"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-xs-3  control-label">CLIENT NAME</label>
        <div class="col-xs-8">
            <input type="text" class="form-control" name="clientname" id="clientname" readonly="true"/>
        </div>
    </div>

    <div class="form-group">
        <label class="col-xs-3 control-label" for="form-field-1">
            PIN NUMBER
        </label>
        <div class="col-xs-8">
            <input type="text" class="form-control" name="pin_no" id="pin_no" readonly="true"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-xs-3 control-label" for="form-field-1">
            PERSON IN CHARGE
        </label>
        <div class="col-xs-8">
            <input type="text" class="form-control" name="person_charge" id="person_charge" readonly="true"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-xs-3 control-label" for="form-field-1">
            CLIENT NUMBER
        </label>
        <div class="col-xs-8">
            <input type="text" class="form-control" name="client_number" id="client_number" readonly="true"/>
        </div>
    </div>
    <div class="form-group">
        <div class="col-xs-4 col-xs-offset-7">
            <button class="btn btn-green btn-block" type="submit">
                Update <i class="fa fa-arrow-circle-right"></i>
            </button>
        </div>
    </div>
</form>
<script>
    var update_project = '<?= base_url('client/update_project') ?>';
    $(document).ready(function () {
        $('#projects_closed').DataTable();
        $('#editprojectform')
                .formValidation({
                    framework: 'bootstrap',
                    icon: {
                        valid: 'glyphicon glyphicon-ok',
                        invalid: 'glyphicon glyphicon-remove',
                        validating: 'glyphicon glyphicon-refresh'
                    },
                    fields: {
                        end_date: {
                            validators: {
                                notEmpty: {
                                    message: 'End Date is required'
                                }
                                ,
                                date: {
                                    format: 'DD-MM-YYYY',
                                    message: 'The date format is DD-MM-YYYY'
                                }
                            }
                        },
                        start_date: {
                            validators: {
                                notEmpty: {
                                    message: 'Start Date is required'
                                },
                                date: {
                                    format: 'DD-MM-YYYY',
                                    message: 'The date is format DD-MM-YYYY'
                                }
                            }
                        }
                        ,
                        tasks_miles: {
                            validators: {
                                notEmpty: {
                                    message: 'Task/Tasks are  required'
                                }
                            }
                        }
                    }
                }).on('success.form.fv', function (e) {
            // Save the form data via an Ajax request
            e.preventDefault();
            // The url and method might be different in your application
            $.ajax({
                url: update_project,
                type: $(this).attr("method"),
                dataType: "JSON",
                data: new FormData(this),
                processData: false,
                contentType: false
//                url: url_addemployee,
//                method: 'post',
//                dataType: "JSON",
//                data: $form.serialize()
            }).done(function (response) {
//                alert(JSON.stringify(response));
                if (response.status === 0) {
//                    $.notify(response.report);
                    $.notify(response.report, "error");
                } else {
                    $('#editprojectform').formValidation('resetForm', true);
                    $.notify(response.report, "success");
                    setTimeout(location.reload.bind(location), 1200);
                    //reloadppr();
                }

            });
        });
        $('.fa-edit').on('click', function () {
            // Get the record's ID via attribute  editprojectform
            var id = $(this).attr('data-id');
//            alert(id);
            var urleditproject = '<?= base_url('client/editproject/') ?>';
            $.ajax({
                url: urleditproject + id,
                dataType: "JSON",
                method: 'POST'
            }).done(function (response) {
                $('#editprojectform')
                        .find('[name="id"]').val(response.project_id).end()
                        .find('[name="clientname"]').val(response.clientname).end()
                        .find('[name="project_name"]').val(response.project_name).end()
                        .find('[name="start_date"]').val(response.start_date).end()
                        .find('[name="end_date"]').val(response.end_date).end()
                        .find('[name="pin_no"]').val(response.pin_no).end()
                        .find('[name="person_charge"]').val(response.person_charge).end()
                        .find('[name="client_number"]').val(response.client_number).end();
//                        .find('[name="tasks_miles"]').val(response.project_name);
                $('#tasks_miles').tagsinput('add', response.tasks_miles);
                bootbox
                        .dialog({
                            title: 'View/Edit Project ',
                            message: $('#editprojectform'),
                            show: false // We will show it manually later
                        })
                        .on('shown.bs.modal', function () {
                            $('#editprojectform')
                                    .show()                             // Show the login form
                                    .formValidation('resetForm'); // Reset form
                        })
                        .on('hide.bs.modal', function (e) {
                            // Bootbox will remove the modal (including the body which contains the login form)
                            // after hiding the modal
                            // Therefor, we need to backup the form
                            $('#editprojectform').hide().appendTo('body');
                        })
                        .modal('show');
            });
        });
    });
    var urlviewproject = '<?php echo base_url("welcome/projectview/"); ?>';
    var urlviewprojectone = '<?php echo base_url("welcome/projectviewo/"); ?>';
    function viewproject(id) {
//        alert(id);
        $.ajax({
            url: urlviewproject + id,
            dataType: "JSON",
            method: 'POST',
            data: jQuery.param({user_id: id})
        }).done(function (response) {
//            alert(JSON.stringify(response));
            reloadppr();
//            location.reload();
//            mama();
//            var l = document.getElementById('link_viewemployeemm');
//            l.click();
        });
    }
    function reloadppr() {
        sessionStorage.setItem("jack", "true");
        document.location.reload();
        window.location = '<?= base_url('welcome/dashboard/3') ?>';
    }
    function export_damclineteeh() {
        $('#id_project_on').find('.buttons-excel').click();
//        document.getElementsByClassName('buttons-excel')[0].click();
    }
</script>