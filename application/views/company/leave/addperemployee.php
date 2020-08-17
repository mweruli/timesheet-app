<?php
$leaveapply = $controller->gettablecolumns('leaveapply');
$leaveapplyvalues = array();
$gen_branch = $controller->check_gender_branch();
$branch_id = $gen_branch['branch_id'];
$leavetypes = $controller->allselectablebytable('leaveconfig');
?>
<div class="row" id="leaveapllyconfig">
    <div class="col-sm-12">
        <div class="panel-heading">
            <h4 class="panel-title">APPLY <span class="text-bold">LEAVE</span></h4>
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
            <p  id="updatepersone"></p>
            <form id="leaveconfigform" role="form" method="post" class="form-horizontal" novalidate>
                <input type="hidden"  id="id_branch" name="id_branch"  class="form-control" value="<?= $branch_id ?>">
                <input type="hidden"  id="tablename" name="tablename"  class="form-control" value="leaveapply">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="form-field-1">
                        EMPLOYEE
                    </label>
                    <div class="col-sm-4">
                        <select  class="form-control search-select" placeholder="Select Form" name="employee_id" id="employee_id"  >
                            <option value="">-SELECT EMPLOYEE-</option>
                            <?php
                            foreach ($controller->allselectablebytable('users') as $employee) {
                                ?>
                                <option value="<?= $employee['id'] ?>"><?= $employee['firstname'] . ' ' . $employee['lastname'] . '  ~EMPLOYEE NO~ ' . $employee['employee_code'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($leaveapply, 'leaveperiod')['status']) ?>>
                        <label class="col-sm-2 control-label" for="form-field-1">
                            LEAVE PERIOD
                        </label>
                        <div class="col-sm-4">
                            <div id="leaveperiod" class="pull-right"
                                 style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                                <span></span> <b class="caret"></b>
                            </div>
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($leaveapply, 'id_leavetype')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            LEAVE TYPE
                        </label>
                        <div class="col-sm-4">
                            <select  class="form-control search-select" placeholder="Select Form" name="id_leavetype" id="id_leavetype" onclick="setbalance()"  >
                                <option value="">-LEAVE TYPE-</option>
                                <?php
                                foreach ($leavetypes as $employee) {
                                    ?>
                                    <option value="<?= $employee['id'] ?>"><?= $employee['leavetype'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group hidden">
                    <input type="text" id="startdate" name="startdate"> <input
                        type="text" id="enddate" name="enddate">
                </div>
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($leaveapply, 'leavefrom')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            FROM
                        </label>
                        <div class="col-sm-4">
                            <div class="input-group input-append date" id="leavefrom">
                                <input type="text"  placeholder="12-09-2012" name="leavefrom" class="form-control" value="<?= printvalues('leavefrom', $leaveapplyvalues) ?>">
                                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($leaveapply, 'leaveto')['status']) ?>>
                        <label class="col-sm-2 control-label" for="form-field-1">
                            TO
                        </label>
                        <div class="col-sm-4">
                            <div class="input-group input-append date" id="leaveto">
                                <input type="text"  placeholder="12-30-2012" name="leaveto" class="form-control" value="<?= printvalues('leaveto', $leaveapply) ?>" >
                                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($leaveapply, 'leavebal')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            LEAVE BALANCE 
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="LEAVE BALANCE" id="leavebal" name="leavebal"  class="form-control"  readonly>
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($leaveapply, 'leavepurpose')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            PURPOSE
                        </label>
                        <div class="col-sm-4">
                            <textarea id="leavepurpose" name="leavepurpose"  class="form-control"><?= printvalues('leavepurpose', $leaveapplyvalues) ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($leaveapply, 'documentleave')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            ATTACH A DOCUMENT 
                        </label>
                        <div class="col-sm-4">
                            <div data-provides="fileupload" class="fileupload fileupload-new">
                                <span class="btn btn-file btn-light-grey"><i class="fa fa-folder-open-o"></i> <span class="fileupload-new">Select file</span><span class="fileupload-exists">Change</span>
                                    <input type="file" id="documentleave" name="upload[]" >
                                </span>
                                <span class="fileupload-preview"></span>
                                <a data-dismiss="fileupload" class="close fileupload-exists float-none" href="#">
                                    &times;
                                </a>
                            </div>
                            <p class="help-block">
                                <?= printvalues('documentleave', $leaveapplyvalues) ?>
                            </p>
                        </div>
                    </div>
                    <div class="col-sm-4 pull-right">
                        <button class="btn btn-green btn-block" type="submit">
                            Apply Leave&nbsp;<i class="fa fa-arrow-circle-right"></i>
                        </button>
                    </div>
                </div>
            </form>
            <div id="wrap">
                <!-- Feedback message zone -->
                <div id="toolbar">
                    <input type="text" id="tablecontentleaveapplicationsfilter" name="tablecontentleaveapplicationsfilter"
                           placeholder="Filter :type any text here" class="form-control" />
                </div>
                <!-- Grid contents -->
                <div id="tablecontentleaveapplications"></div>
                <!-- Paginator control -->
                <div id="paginator"></div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        //LOAD TABLE
        datagrid = new DatabaseGrid('leaveapply', "tablecontentleaveapplications");
        $("#tablecontentleaveapplicationsfilter").keyup(function () {
            datagrid.editableGrid.filter($(this).val());
//            datagrid.editableGrid.filter( $(this).val(), [0,3,5]);        
        });
        //END LOAD TABLE
        var start = moment().subtract(29, 'days');
        var end = moment();
        function cb(start, end) {
            $('#leaveperiod span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            var startdate = start.format('YYYY-MM-DD');
            var endate = end.format('YYYY-MM-DD');
            //            $('#startdate').val = startdate;
            $("#startdate").val(startdate);
            $("#enddate").val(endate);
            //            alert(startdate + ' ' + end);
        }
        $('#leaveperiod').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);
        cb(start, end);
        //        alert(start+' '+end);
    });
    $(document).ready(function () {
        $('#leavefrom')
                .datepicker({
                    format: 'dd-mm-yyyy'
                })
                .on('changeDate', function (e) {
                    // Revalidate the date field
                    $('#leaveconfigform').formValidation('revalidateField', 'leavefrom');
                });
        $('#leaveto')
                .datepicker({
                    format: 'dd-mm-yyyy'
                })
                .on('changeDate', function (e) {
                    // Revalidate the date field
                    $('#leaveconfigform').formValidation('revalidateField', 'leaveto');
                });
        $('#leaveconfigform')
                .formValidation({
                    framework: 'bootstrap',
                    icon: {
                    },
                    fields: {
                        leavefrom: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($leaveapply, 'leavefrom')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'From Date  is required'
                                }
                            }
                        },
                        leaveto: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($leaveapply, 'leaveto')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'To Date  is required'
                                }
                            }
                        },
                        leavebal: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($leaveapply, 'leavebal')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Balance  is required'
                                }
                            }
                        },
                        leavepurpose: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($leaveapply, 'leavepurpose')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Leave  is required'
                                }
                            }
                        },
                        id_leavetype: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($leaveapply, 'id_leavetype')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Leave Type is required'
                                }
                            }
                        },
                        employee_id: {
                            enabled: true,
                            validators: {
                                notEmpty: {
                                    message: 'Employee is required'
                                }
                            }
                        }
                    }
                }).on('success.form.fv', function (e) {
            postformdatajax("#leaveconfigform", 'submit', '<?= base_url('leave/uploadapply') ?>', '#updatepersone');
            validateinputtype("#file", '#updatepersone', '<span style="font-size:18px;color:#EA4335">Select a valid image file (JPEG/JPG/PNG).</span>', "image/jpeg", "image/png", "image/jpg");
        });

    });
    function validateinputtype(validateid, wheremessage, message, ...args) {
        $(wheremessage).html('');
        $(validateid).change(function () {
            $(wheremessage).html('');
            var file = this.files[0];
            var imagefile = file.type;
            var match = args;
            if (!((imagefile === match[0]) || (imagefile === match[1]) || (imagefile === match[2]))) {
                $(wheremessage).html(message);
                $(validateid).val('');
                return false;
            }
        });
    }

    function postformdatajax(formid, actioncalling, url, message) {
        $(formid).on(actioncalling, function (e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                dataType: "JSON",
                url: url,
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function () {
                    $('.submitBtn').attr("disabled", "disabled");
                    $(formid).css("opacity", ".5");
                },
                success: function (msg) {
//                    console.log(msg);
                    $(message).html('');
                    if (msg.state === 'ok') {
                        $(formid)[0].reset();
                        $(message).html('<span style="font-size:18px;color:#34A853">' + msg.message + '</span>');
                        datagrid.fetchGrid("leaveapply");
                        $('#leaveconfigform').formValidation('resetForm', true);
                    } else {
                        $(message).html('<span style="font-size:18px;color:#EA4335">' + msg.message + '</span>');
                    }
                    $(formid).css("opacity", "");
                    $(".submitBtn").removeAttr("disabled");
                }
            });
        });
    }
    function setbalance() {
        var url_balanceleave = '<?= base_url() ?>leave/calculateleave';
        var user_id = '<?= $this->session->userdata('logged_in')['id'] ?>';
//        var leavetypeid = document.getElementById("id_leavetype").value;
        var e = document.getElementById("id_leavetype");
        var leavetypeid = e.options[e.selectedIndex].value;
        var leavetypename = e.options[e.selectedIndex].text;
        $.ajax({
            url: url_balanceleave,
            type: 'POST',
            dataType: "json",
            data: {userid: user_id, leavetype: leavetypeid, leavename: leavetypename}
        }).done(function (response) {
//            console.log(response);
            document.getElementById("leavebal").value = response.balance;
        });
    }
</script>
