<?php
//print_array($skill_list_one);
?>
<div class="row" id="addshiftdiv">
    <div class="col-sm-12">
        <!-- start: TEXT FIELDS PANEL -->
        <!--<div class="panel panel-white">-->
        <div class="panel-heading">
            <h4 class="panel-title">Add <span class="text-bold">New Shift Type</span></h4>
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
            <form id="add_shift" method="post" class="form-horizontal" role="form">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="form-field-1">
                        Name Of Shift
                    </label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="Name Of Shift" name="nameofshift" id="nameofshift" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">
                        Shift 
                    </label>
                    <div class="col-sm-5">
                        <input type="text" placeholder="Time From" name="time_from" id="time_from" class="form-control">
                    </div>
                    <div class="col-sm-4">
                        <input type="text" placeholder="Time To" id="time_to" name="time_to" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="form-field-1">
                        Remarks
                    </label>
                    <div class="col-sm-9">
                        <textarea rows="4" cols="40" class="form-control" name="remarks_timeshift" id="remarks_timeshift"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">
                        Lunch(Minutes)
                    </label>
                    <div class="col-sm-5">
                        <input type="text" placeholder="Lunch(Minutes)" id="lunch_mins" name="lunch_mins" class="form-control">
                    </div>
                </div>
                <br>
                <div class="form-group">
                    <div class="panel-body">
                        <p>
                            <button class="btn btn-blue btn-block" type="submit">
                                Add Time Shift<i class="fa fa-arrow-circle-right"></i>
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
    var url_addshift = "<?php echo base_url("posts/addshift"); ?>";
    $('#add_shift')
            .formValidation({
                framework: 'bootstrap',
                icon: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    nameofshift: {
                        validators: {
                            notEmpty: {
                                message: 'Name Of Shift is required'
                            }
                        }
                    },
                    time_from: {
                        validators: {
                            notEmpty: {
                                message: 'From Time is required'
                            },
                            regexp: {
                                regexp: /^(([0-1][0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?)$/,
                                message: 'From Time can only consist of Hours'
                            }
                        }
                    },
                    time_to: {
                        validators: {
                            notEmpty: {
                                message: 'To Time is required'
                            }
                            ,
                            regexp: {
                                regexp: /^(([0-1][0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?)$/,
                                message: 'To Time can only consist of Hours'
                            }
                        }
                    },
                    lunch_mins: {
                        validators: {
                            notEmpty: {
                                message: 'Lunch minutes required'
                            }
                            ,
                            regexp: {
                                regexp: /^(([0-0][0-0]):[0-5][0-9](:[0-5][0-9])?)$/,
                                message: 'Lunch minutes consist of Minutes format 00:30'
                            }
                        }
                    }

                }
            }).on('success.form.fv', function (e) {
        // Save the form data via an Ajax request
        e.preventDefault();
        // The url and method might be different in your application
        $.ajax({
            url: url_addshift,
            type: $(this).attr("method"),
            dataType: "JSON",
            data: new FormData(this),
            processData: false,
            contentType: false
        }).done(function (response) {
            $.notify(response.report, "success");
            reloadmeaddshift();
        });
    });
    function reloadmeaddshift() {
        sessionStorage.setItem("reloadingxx", "true");
//        document.location.reload();
        window.setTimeout(function () {
            window.location.reload();
        }, 3000);
    }
    window.onload = function () {
        var reloadingxx = sessionStorage.getItem("reloadingxx");
        if (reloadingxx) {
            sessionStorage.removeItem("reloadingxx");
            myfuncxx();
        }
    }
    function myfuncxx() {
        var l = document.getElementById('shift_addsec');
        l.click();
    }
</script>