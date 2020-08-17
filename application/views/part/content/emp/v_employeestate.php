<div class="row" id="add_employeedivstate">
    <div class="col-sm-12">
        <!-- start: TEXT FIELDS PANEL -->
        <div class="panel-body">
            <form id="add_employeestate" method="post" class="form-horizontal" role="form">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="form-field-1">
                        Employee
                    </label>
                    <div class="col-sm-9">
                        <select  id="form-field-select-4one" class="form-control search-select" placeholder="Select Employee" name="employee_select" id="employee_select">
                            <option value="">-SELECT EMPLOYEE-</option>
                            <?php
                            foreach ($array_employeesection as $value) {
                                ?>
                                <option value="<?= $value['user_id'] ?>"><?= $value['emailaddress'] . ' ' . $value['cellphone'] . ' ' . $value['firstname'] . ' ' . $value['lastname'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="form-field-1">
                        Time Award Per Day(hours)
                    </label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="Time Award" class="form-control" name="time_award" id="time_award">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="form-field-1">
                        Comments
                    </label>
                    <div class="col-sm-9">
                        <textarea rows="4" cols="40" class="form-control" name="comment_state_task" id="comment_state_task"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">
                        Start Date
                    </label>
                    <div class="col-sm-4 date">
                        <div class="input-group input-append date" id="state_startdate">
                            <input type="text"  name="state_startdate" class="form-control" id="state_startdateid">
                            <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </div>
                    <label class="col-sm-1 control-label">
                        End Date
                    </label>
                    <div class="col-sm-4 date">
                        <div class="input-group input-append date" id="state_enddate">
                            <input type="text"  class="form-control" name="state_enddate" id="state_enddateid">
                            <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="form-field-1">
                        Employee Status
                    </label>
                    <div class="col-sm-9">
                        <select  id="form-field-select-4two" class="form-control search-select" placeholder="Select Status" name="employee_status" id="employee_status">
                            <option value="">-SELECT STATUS-</option>
                            <?php
                            foreach ($emloyee_state as $value) {
                                ?>
                                <option value="<?= $value['id'] . '@' . $value['task_name'] ?>"><?= $value['task_name'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <br>
                <div class="form-group">
                    <div class="panel-body">
                        <p>
                            <button class="btn btn-blue btn-block" type="submit">
                                Add State&nbsp;<i class="fa fa-plus"></i>
                            </button>
                        </p>
                    </div>
                </div>
            </form>
        </div>
        <!-- end: TEXT FIELDS PANEL -->
    </div>
</div>
<script>
    var url_addemployeeone = "<?php echo base_url("employee/addemployeeisstate"); ?>";
    $(document).ready(function () {
        var startdate = $('#state_startdateid').val();
        var enddate = $('#state_enddateid').val();
        $('#state_startdate')
                .datepicker({
                    format: 'yyyy-mm-dd'
                })
                .on('changeDate', function (e) {
                    // Revalidate the date field
                    $('#add_employeestate').formValidation('revalidateField', 'state_startdate');
                });
        $('#state_enddate')
                .datepicker({
                    format: 'yyyy-mm-dd'
                })
                .on('changeDate', function (e) {
                    // Revalidate the date field
                    $('#add_employeestate').formValidation('revalidateField', 'state_enddate');
                });
        $('#add_employeestate')
                .formValidation({
                    framework: 'bootstrap',
                    icon: {
                        valid: 'glyphicon glyphicon-ok',
                        invalid: 'glyphicon glyphicon-remove',
                        validating: 'glyphicon glyphicon-refresh'
                    },
                    fields: {
                        state_startdate: {
                            validators: {
                                notEmpty: {
                                    message: 'State Start Date'
                                }
                                ,
                                date: {
                                    format: 'YYYY-MM-DD',
//                                    max: enddate,
                                    message: 'The date is not a valid'
                                }
//                                ,
//                                greaterThan: {
//                                    message: 'The value must be greater than or equal to 18',
//                                    min: enddate
//                                }
                            }
                        },
                        state_enddate: {
                            validators: {
                                notEmpty: {
                                    message: 'Expected State End Date'
                                },
                                date: {
                                    format: 'YYYY-MM-DD',
                                    message: 'The date is not a valid',
                                }
                            }
                        },
                        employee_select: {
                            validators: {
                                notEmpty: {
                                    message: 'Employee is required'
                                }
                            }
                        },
                        employee_status: {
                            validators: {
                                notEmpty: {
                                    message: 'Employee State is required'
                                }
                            }
                        }
                        ,
                        time_award: {
                            validators: {
                                notEmpty: {
                                    message: 'Time Award Per Day is required'
                                },
                                regexp: {
                                    regexp: /^[0-9]{1}$/,
                                    message: 'Enter only numbers not more than 9'
                                }
                            }
                        }
                    }
                }).on('success.form.fv', function (e) {

            console.log(startdate + ' ' + enddate);
            // Save the form data via an Ajax request
            e.preventDefault();
            var $form = $(e.target);
            // The url and method might be different in your application
            $.ajax({
                url: url_addemployeeone,
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
//                console.log(response);
                if (response.status === 1) {
//                    $.notify(response.report);
                    $.notify(response.report, "error");
                } else {
                    $.notify(response.report, "success");
                    $('#add_employee').formValidation('resetForm', true);
                    setid_editaccount();
                    setTimeout(location.reload.bind(location), 1500);
//                    setTimeout(setid_editaccount(), 3000);
//                    setTimeout();
                }
            });
        });
    });
//    setTimeout(explode, 2000);
    function setid_editaccount() {
        sessionStorage.setItem("id_editaccount", "true");
//        document.location.reload();
    }
</script>