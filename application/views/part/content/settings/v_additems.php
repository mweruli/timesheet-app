<div class="panel panel-white" id="my_div">
    <!-- start: TEXT FIELDS PANEL -->
    <!--<div class="panel panel-white">-->
    <div class="panel-heading">
        <h4 class="panel-title">Add <span class="text-bold">New Variables</span></h4><div id="movie-data"></div>
        <div class="panel-tools">
            <div class="dropdown">
                <a data-toggle="dropdown" class="btn btn-xs dropdown-toggle btn-transparent-grey">
                    <i class="fa fa-cog"></i>
                </a>
                <?php echo $this->load->view('part/include/formconfig', '', TRUE); ?>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <form id="department_addform" method="post" class="form-horizontal" role="form">
            <div class="form-group" id="mamamaa">
                <label class="col-sm-2 control-label">
                    Designation
                </label>
                <div class="col-sm-5">
                    <!--<input type="text" placeholder="Add A Department" id="add_department_id" class="form-control" required="true">-->
                    <span class="input-icon input-icon-right">
                        <input type="text" placeholder="Add A Designations" name="design" id="design" class="form-control" required="true">
                        <i class="fa fa-hand-o-left"></i> </span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">
                    Rate Per Hour
                </label>
                <div class="col-sm-5">
                    <input type="text" placeholder="Add A Rate" id="rateamount" name="rateamount" class="form-control" required="true">
                </div>
                <div class="col-sm-4">
                    <button class="btn btn-green btn-block" id="button_2">
                        Add <i class="fa fa-arrow-circle-right"></i>
                    </button>
                </div>
            </div>
        </form>
        <!--</form>-->
    </div>
    <hr>
    <div class="panel-body">
        <form id="employee_status_addform" method="post" class="form-horizontal" role="form">
            <div class="form-group">
                <label class="col-sm-2 control-label">
                    Add Employee Status Type
                </label>
                <div class="col-sm-5">
                    <input type="text" placeholder="Add A Status Type" id="employee_status" name="employee_status" class="form-control" required="true">
                </div>
                <div class="col-sm-4">
                    <button class="btn btn-green btn-block" id="employee_status_button">
                        Add Status Type <i class="fa fa-plus"></i>
                    </button>
                </div>
            </div>
        </form>
        <!--</form>-->
    </div>
    <!--<p>Suggestions: <span id="txtHint"></span></p>-->
</div>
<script>
    var url_setting = "<?php echo base_url("welcome/addsetting"); ?>";
    var addemplostate = "<?php echo base_url("welcome/addemplostate"); ?>";
    $(document).ready(function() {
        $('#employee_status_addform').formValidation({
            framework: 'bootstrap',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                employee_status: {
                    validators: {
                        notEmpty: {
                            message: 'Employee Status Type is required'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z\s]+$/,
                            message: 'Employee Status Type can only consist of alphabetical characters'
                        }
                    }
                }
            }
        }).on('success.form.fv', function(e) {
            e.preventDefault();
            var $form = $(e.target)
            $.ajax({
                url: addemplostate,
                method: 'post',
                dataType: "JSON",
                data: $form.serialize()
            }).done(function(response) {
//                alert(JSON.stringify(response));
//                        $('#skill_addform').formValidation('resetForm', true);
                if (response.status === 0) {
                    $.notify(response.report, "error");
                } else if (response.status === 1) {
                    $.notify(response.report, "success");
                    setTimeout(startRefresh, 1000);
                }
            });
        });
        //Net One
        $('#department_addform')
                .formValidation({
                    framework: 'bootstrap',
                    icon: {
                        valid: 'glyphicon glyphicon-ok',
                        invalid: 'glyphicon glyphicon-remove',
                        validating: 'glyphicon glyphicon-refresh'
                    },
                    fields: {
                        design: {
                            validators: {
                                notEmpty: {
                                    message: 'Designation is required'
                                },
                                regexp: {
                                    regexp: /^[a-zA-Z\s]+$/,
                                    message: 'Designation can only consist of alphabetical characters'
                                }
                            }
                        },
                        rateamount: {
                            validators: {
                                numeric: {
                                    message: 'The Rate value is not a number',
                                    // The default separators
                                }
                            }
                        }
                    }
                })
                .on('success.form.fv', function(e) {
                    // Save the form data via an Ajax request
                    e.preventDefault();
                    var $form = $(e.target),
                            valueme = $form.find('[name="valueme"]').val(),
                            type_value = $form.find('[name="type_value"]').val();
                    // The url and method might be different in your application
                    $.ajax({
                        url: url_setting,
                        method: 'post',
                        dataType: "JSON",
                        data: $form.serialize()
                    }).done(function(response) {
//                        alert(JSON.stringify(response));
//                        $('#skill_addform').formValidation('resetForm', true);
                        if (response.status === 1) {
                            $.notify(response.report, "error");
                        } else if (response.status === 2) {
                            $.notify(response.report, "success");
                            setTimeout(startRefresh, 1000);
                        }
                    });
                });
    });
    function startRefresh() {
        location.reload();
    }
</script> 
<!--</div>-->
<!-- end: TEXT FIELDS PANEL -->