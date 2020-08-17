<?php
// print_array($this->session->userdata('logged_in'));
// echo '---------';
// print_array($all_people_assignable);
?>
<!-- start: TEXT FIELDS PANEL -->
<!--<div class="panel panel-white">-->
<div class="panel-heading">
	<h4 class="panel-title">
		Assign <span class="text-bold">Project</span>
	</h4>
	<div class="panel-tools">
		<div class="dropdown">
			<a data-toggle="dropdown"
				class="btn btn-xs dropdown-toggle btn-transparent-grey"> <i
				class="fa fa-cog"></i>
			</a>
            <?php echo $this->load->view('part/include/formconfig', '', TRUE); ?>
        </div>
	</div>
</div>
<div class="panel-body">
	<form role="form" class="form-horizontal" method="post"
		id="add_project_xxx"
		action="<?php echo base_url('employee/add_projectcloneone'); ?>">
		<div class="form-group">
			<label class="col-sm-2 control-label" for="form-field-1"> Assign
				Employee </label>
			<div class="col-sm-9">
				<select id="user_id" class="form-control search-select"
					name="user_id" placeholder="Select Employee">
					<option value="">&nbsp;</option>
                    <?php
                    foreach ($all_people_assignable as $value) {
                        if ($this->session->userdata('logged_in')['id'] == $value['id']) {
                            $value['firstname'] = "MYSELF";
                            $value['lastname'] = "";
                        }
                        ?>
                        <option value="<?= $value['user_id']; ?>"><?= $value['firstname'] . "  " . $value['lastname'] . "  " . $value['emailaddress'] ?></option>
                        <?php
                    }
                    ?>
                </select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="form-field-1"> Project
				Name </label>
			<div class="col-sm-9">
				<select id="project_nameempadd" class="form-control search-select"
					onChange="check();" name="project_nameempadd"
					placeholder="Select Project">
					<option value="">&nbsp;</option>
                    <?php
                    foreach ($all_availableprojects as $value) {
                        ?>
                        <option
						value="<?= $value['id'] . "|" . $value['project_milestone'] ?>"><?= $value['project_name'] . " # " . $value['clientname'] ?></option>
                        <?php
                    }
                    ?>
                </select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="form-field-1"> Tasks </label>
			<div class="col-sm-9">
				<select multiple="multiple" id="specific_tasks"
					name="specific_tasks[]" class="form-control search-select"
					placeholder="Select Tasks">
					<option value=""></option>
				</select>
			</div>
		</div>
		<br>
		<div class="form-group">
			<div class="panel-body">
				<p>
					<button class="btn btn-green btn-block">
						Add Project<i class="fa fa-arrow-circle-right"></i>
					</button>
				</p>
			</div>
		</div>
	</form>
</div>
<script>
    var url_addworkone = "<?php echo base_url('employee/add_projectcloneone'); ?>";
    function check() {
        var e = document.getElementById("project_nameempadd");
        $('#specific_tasks').find('option:not(:first)').remove();
        var milearrays_on = new Array();
        var fields = new Array();
        var mile_stones = new Array();
        var strUser = "";
        strUser = e.options[e.selectedIndex].value;
        //alert(strUser);
        fields = strUser.split('|');
        //var name = fields[0];
        mile_stones = fields[1];
        //now array
        milearrays_on = mile_stones.split(',');
        var $dropdown = $("#specific_tasks");
        //alert(milearrays_on[0]);
        for (var i = 0; i < milearrays_on.length; i++) {
            $dropdown.append($("<option />").val(milearrays_on[i]).text(milearrays_on[i]));
        }
    }
    function checkx() {
//        alert('Hello hello');
    }
    $(document).ready(function () {
        $('#add_project_xxx')
                .formValidation({
                    framework: 'bootstrap',
                    icon: {
                        valid: 'glyphicon glyphicon-ok',
                        invalid: 'glyphicon glyphicon-remove',
                        validating: 'glyphicon glyphicon-refresh'
                    },
                    fields: {
                        project_nameempadd: {
                            validators: {
                                notEmpty: {
                                    message: 'Project Name is required'
                                }
                            }
                        },
                        user_id: {
                            validators: {
                                notEmpty: {
                                    message: 'Employee  is required'
                                }
                            }
                        },
                        'specific_tasks[]': {
                            validators: {
                                notEmpty: {
                                    message: 'Specific Task(s) is required'
                                }
                            }
                        }
                    }
                }).on('success.form.fv', function (e) {
            // Save the form data via an Ajax request
            e.preventDefault();
            $.ajax({
                url: url_addworkone,
                type: $(this).attr("method"),
                dataType: "JSON",
                data: new FormData(this),
                processData: false,
                contentType: false
            }).done(function (response) {
//                alert(JSON.stringify(response));
                if (response.status === 1) {
                    $('#add_project_xxx').formValidation('resetForm', true);
                    $.notify(response.report, "success");
                    setTimeout(location.reload.bind(location), 1200);
                } else {
                    $.notify(response.report, "error");
                }
            });
        });
    });
</script>
<!--</div>-->
<!-- end: TEXT FIELDS PANEL -->