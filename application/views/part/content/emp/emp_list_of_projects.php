<?php
// print_array($my_active_projects);
?>
<div class="table-responsive">
	<table class="table table-bordered table-striped"
		id="active_employee_projects">
		<thead>
			<tr>
				<th>Project Name</th>
				<th>Project Code</th>
				<th>Start Date</th>
				<th>End Date</th>
				<th>Update Work</th>
				<!--<th>View Status</th>-->
			</tr>
		</thead>
		<tbody>
            <?php
            foreach ($my_active_projects as $value) {
                // $response = Requests::get(base_url('welcome/testbed/') . $value['id_project']);
                $array_data = $controller->testbed($value['id_project']);
                // End Now
                // More
                // $string_onex = $value['project_task'];
                // messages = json_decode($string_onex);
                if (empty($array_data)) {
                    $our_tasks = json_decode($value['project_task'], true);
                    $finalvalue = "";
                    foreach ($our_tasks as $value_tata) {
                        $finalvalue .= $value_tata . ',';
                    }
                    $finalvalue = rtrim($finalvalue, ",");
                    // print_array();
                } else {
                    // in_array_r($needle, $haystack);
                    // print_array($ann_an);
                    $finalvalue = json_decode($value['project_task'], true)[0];
                    // print_array(json_decode($value['project_task'],true)[0]);
                }
                // echo $finalvalue;
                ?>
                <tr>
				<td><?= $value['project_name'] ?></td>
				<td><?= $value['id_project'] . ' XXX' ?></td>
				<td><?php
                $dateone = $value['start_date'];
                $date_real = str_replace('"', "", $dateone);
                echo date("F jS, Y", strtotime($date_real));
                ?>
                    </td>
                    <?php
                if (empty($value['clientname'])) {
                    $client_nameme = "";
                } else {
                    $client_nameme = $value['clientname'][0]['clientname'];
                }
                ?>
                    <td><?= date("F jS, Y", strtotime($value['end_date'])) ?></td>
				<td><button type="button"
						data-id="<?= $value['id_project'] . '|' . $finalvalue . '|' . $value['project_name'] . '|' . $client_nameme; ?>"
						class="btn btn-default editButton">Update</button></td>
				<!--<td><a href="#" onclick="">View Project Progress</a></td>-->
			</tr>
                <?php
            }
            ?>
        </tbody>
	</table>
</div>
<!-- The form which is used to populate the item data -->
<!--style="display: none;"-->
<form id="userForm" method="post" class="form-horizontal"
	style="display: none;">
	<div class="form-group" hidden="true">
		<label class="col-sm-2 control-label" for="form-field-1"> ID </label>
		<div class="col-sm-9">
			<input type="text" class="form-control" name="id" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="form-field-1"> Client </label>
		<div class="col-sm-9">
			<input type="text" class="form-control" name="client_name"
				id="client_name" readonly="readonly" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="form-field-1"> Project Name
		</label>
		<div class="col-sm-9">
			<input type="text" class="form-control" name="name" id="name"
				readonly="readonly" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="form-field-1"> Date </label>
		<div class="col-sm-9">
			<!--input-mask-date-->
			<input type="text" class="form-control"
				placeholder="Format 2016-04-09" id="date_done_task"
				name="date_done_task">
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="form-field-1"> Comments </label>
		<div class="col-sm-9">
			<textarea rows="4" cols="40" class="form-control"
				name="comment_update_task" id="comment_update_task"></textarea>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="form-field-1"> Tasks </label>
		<div class="col-sm-9">
			<select id="specific_tasks" name="specific_tasks"
				class="form-control search-select" placeholder="Select Tasks">
				<option value=""></option>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="form-field-1"> Time
			Spent(Hrs) </label>
		<div class="col-sm-9">
			<input type="text" class="form-control" name="time_spent"
				id="time_spent" placeholder="In Hours Example 0.2 or 1.0" />
		</div>
	</div>
	<div class="form-group">
		<div class="panel-body">
			<p>
				<button class="btn btn-green btn-block" type="submit">
					Save<i class="fa fa-arrow-circle-right"></i>
				</button>
			</p>
		</div>
	</div>
</form>
<script>
    function reloadtaskupdator() {
        sessionStorage.setItem("reloadtaskupdator", "true");
        document.location.reload();
    }
    var url = '<?php echo base_url("employee/updatetasks"); ?>';
    $(document).ready(function () {
        $('#active_employee_projects').DataTable();
        $('#userForm')
                .formValidation({
                    framework: 'bootstrap',
                    icon: {
                        valid: 'glyphicon glyphicon-ok',
                        invalid: 'glyphicon glyphicon-remove',
                        validating: 'glyphicon glyphicon-refresh'
                    },
                    fields: {
                        name: {
                            validators: {
                                notEmpty: {
                                    message: 'The project name is required'
                                },
                                regexp: {
                                    regexp: /^[a-zA-Z\s]+$/,
                                    message: 'The project name can only consist of alphabetical characters'
                                }
                            }
                        },
                        specific_tasks: {
                            validators: {
                                notEmpty: {
                                    message: 'The Task Name is required'
                                },
                                regexp: {
                                    regexp: /^[a-zA-Z\s]+$/,
                                    message: 'The Task Name can only consist of alphabetical characters'
                                }
                            }
                        },
                        date_done_task: {
                            validators: {
                                notEmpty: {
                                    message: 'Date of Task Done is required'
                                },
                                date: {
                                    format: 'YYYY-MM-DD',
                                    message: 'The date format is YYYY-MM-DD'
                                }
                            }
                        }
                        ,
                        time_spent: {
                            validators: {
                                notEmpty: {
                                    message: 'Hours worked required'
                                }
                                ,
                                regexp: {
                                    regexp: /^[0-9]{1}(\.[0-9]+)$/,
                                    message: 'Enter not more than 9 hours per entry Format 3.0'
                                }
                            }
                        },
                    }
                })
                .on('success.form.fv', function (e) {
                    // Save the form data via an Ajax request
                    e.preventDefault();
                    var $form = $(e.target),
                            id = $form.find('[name="id"]').val();
                    // The url and method might be different in your application
                    $.ajax({
                        url: url,
                        method: 'POST',
                        dataType: "JSON",
                        data: $form.serialize()
                    }).done(function (response) {
//                        alert(JSON.stringify(response));
                        if (response.status === 1) {
                            $.notify(response.report, "success");
                            setTimeout(function () {
                                reloadtaskupdator();
                            }, 3000);
//                            setTimeout(reloadtaskupdator(), 10000);
                            $('#userForm').formValidation('resetForm', true);
                        } else if (response.status === 0) {
                            // alert(JSON.stringify(response));
                            $.notify(response.report, "error");
                        }
                        $form.parents('.bootbox').modal('hide');
                    });
                });

        $('.editButton').on('click', function () {
            // Get the record's ID via attribute
            var $dropdown = $("#specific_tasks");
            var man_value = $(this).attr('data-id');
            $('#specific_tasks').find('option:not(:first)').remove();
            fields = man_value.split('|');
            fieldsm = fields[1].split(',');
//            alert(obed + obedff);
//            var task_specificone = $(this).attr('data-mm');
//            alert(task_specificone.toString());
            $('#userForm')
                    .find('[name="id"]').val(fields[0]).end()
                    .find('[name="name"]').val(fields[2]).end()
                    .find('[name="client_name"]').val(fields[3]).end();
            for (var i = 0; i < fieldsm.length; i++) {
                $dropdown.append($("<option />").val(fieldsm[i]).text(fieldsm[i]));
            }
            bootbox.dialog({
                title: 'Update Done Tasks',
                message: $('#userForm'),
                show: false // We will show it manually later
            }).on('shown.bs.modal', function () {
                $('#userForm')
                        .show()                             // Show the login form
                        .formValidation('resetForm'); // Reset form
            }).on('hide.bs.modal', function (e) {
                // Bootbox will remove the modal (including the body which contains the login form)
                // after hiding the modal
                // Therefor, we need to backup the form
                $('#userForm').hide().appendTo('body');
            }).modal('show');
        });
    });
</script>