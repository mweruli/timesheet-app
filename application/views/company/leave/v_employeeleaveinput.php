<div class="row" id="addemployeeleave">
    <div class="col-sm-12">
        <!-- start: TEXT FIELDS PANEL -->
        <div class="panel-body">
            <form id="addemployeeleave_form" method="post" class="form-horizontal" role="form">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="form-field-1"> Branch </label>
                    <div class="col-sm-4">
                        <select class="form-control search-select" placeholder="Select Employee" name="branch_start_manualleave" id="branch_start_manualleave" onChange="selectuserleave();">
                            <option selected="selected" value="">-SELECT BRANCH-</option>
                            <?php
                            foreach ($allbranches as $value) {
                                ?>
                                <option value="<?= $value['readerserial'] . '$' . $value['names'] . '$' . $value['userpin'] ?>"><?= $value['branchname'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <label class="col-sm-2 control-label" for="form-field-1"> Employee
                    </label>
                    <div class="col-sm-4">
                        <select id="from_employee_leave" name="from_employee_leave" class="form-control search-select" required onChange="notmyleaves();">
                            <option value="">-SELECT EMPLOYEE-</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">
                        FROM
                    </label>
                    <div class="col-sm-4">
                        <div class="input-group input-append date" id="leavefromact">
                            <input type="text" placeholder="12-09-2012" name="leavefromact" id="leavefromactx" class="form-control">
                            <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </div>
                    <label class="col-sm-2 control-label" for="form-field-1">
                        TO
                    </label>
                    <div class="col-sm-4">
                        <div class="input-group input-append date" id="leavetoact">
                            <input type="text" placeholder="12-30-2012" name="leavetoact" id="leavetoactx" class="form-control">
                            <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="form-field-1"> Leave
                        Code
                    </label>
                    <div class="col-sm-4">
                        <select class="form-control search-select" placeholder="Leave Code" name="leavecode" id="leavecode" onclick="setbalance()">
                            <option value="">-SELECT LEAVE-</option>
                            <?php
                            foreach ($leavesall as $valueleave) {
                                ?>
                                <option value="<?= $valueleave['id'] ?>"><?= $valueleave['leavetype'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <label class="col-sm-2 control-label">
                        LEAVE BALANCE
                    </label>
                    <div class="col-sm-4">
                        <input type="text" placeholder="LEAVE BALANCE" id="leavebalact" name="leavebalact" class="form-control" readonly>
                    </div>
                </div>
                <div class="form-group hidden">
                    <input type="text" id="startdatex" name="startdatex"> <input type="text" id="enddatex" name="enddatex">
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">
                    </label>
                    <div class="col-sm-4 pull-right">
                        <button class="btn btn-orange btn-block" type="submit">
                            Load Employee Leave | or Add &nbsp;<i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
                <br>
                <div class="form-group" id="tableleavediv">
                    <!--<div id="eachTable">-->
                    <table id="tableleave" class='table table-striped table-hover'>
                    </table>
                    <!--</div>-->
                </div>
            </form>
            <div id="wrap">
                <!-- Feedback message zone -->
                <div id="toolbar">
                    <input type="text" id="leaveperfilter" name="leaveperfilter" placeholder="Filter :type any text here" class="form-control" />
                </div>
                <!-- Grid contents -->
                <div id="tablecontentleave"></div>
                <!-- Paginator control -->
                <div id="paginator"></div>
            </div>
            <div id="leavedelbutton_id">
                <button class="btn btn-green btn-block" type="submit">
                    Delete All The Above Leave&nbsp;<i class="fa fa-minus"></i>
                </button>
            </div>
        </div>
        <!-- end: TEXT FIELDS PANEL -->
    </div>
</div>
<script>
    function selectuserleave() {
        var e = document.getElementById("branch_start_manualleave");
        $('#from_employee_leave').find('option:not(:first)').remove();
        //To Extraxt
        var milearrays_on = new Array();
        var milearrays_on2 = new Array();
        var fields = new Array();
        var mile_stones = new Array();
        var strUser = "";
        strUser = e.options[e.selectedIndex].value;
        //alert(strUser);
        fields = strUser.split('$');
        mile_stones = fields[1];
        //  mile_stones1=fields[2];
        mile_stones2 = fields[2];
        milearrays_on = mile_stones.split('@');
        milearrays_on2 = mile_stones2.split('@');

        var $dropdown = $("#from_employee_leave");
        for (var i = 0; i < milearrays_on.length; i++) {
            $dropdown.append($("<option />").val(milearrays_on[i] + '|' + milearrays_on2[i]).text(milearrays_on[i] + ' ~pin~ ' + milearrays_on2[i]));
        }
    }
    var loadleavedata = "<?php echo base_url("posts/loadleavedata"); ?>";
    var deleteall = "<?php echo base_url("posts/deleteallleaveinhere"); ?>";

    function notmyleaves() {
        $("#leavedelbutton_id").hide();
    }
    $("#leavedelbutton_id").hide();
    $(function() {
        $('#leavefromact')
            .datepicker({
                format: 'dd-mm-yyyy'
            })
            .on('changeDate', function(e) {
                // Revalidate the date field
                $('#addemployeeleave_form').formValidation('revalidateField', 'leavefromact');
            });
        $('#leavetoact')
            .datepicker({
                format: 'dd-mm-yyyy'
            })
            .on('changeDate', function(e) {
                // Revalidate the date field
                $('#addemployeeleave_form').formValidation('revalidateField', 'leavetoact');
            });
        //     	notmyleaves()
        var start = moment().subtract(29, 'days');
        var end = moment();
        var startdatex = start.format('YYYY-MM-DD');
        var endate = end.format('YYYY-MM-DD');
        $("#startdatex").val(startdatex);
        $("#enddatex").val(endate);
        //        alert(start+' '+end);
    });
    $('#addemployeeleave_form')
        .formValidation({
            framework: 'bootstrap',
            icon: {
                //                     valid: 'glyphicon glyphicon-ok',
                //                     invalid: 'glyphicon glyphicon-remove',
                //                    validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                branch_start_manualleave: {
                    validators: {
                        notEmpty: {
                            message: 'Branch is required'
                        }
                    }
                },
                leavefromact: {
                    validators: {
                        notEmpty: {
                            message: 'Leave From is required'
                        }
                    }
                },
                leavebalact: {
                    validators: {
                        notEmpty: {
                            message: 'Leave Amount'
                        }
                    }
                },
                leavetoact: {
                    validators: {
                        notEmpty: {
                            message: 'Leave To is required'
                        }
                    }
                },
                from_employee_leave: {
                    validators: {
                        notEmpty: {
                            message: 'From Employee is required'
                        }
                    }
                },
                leavecode: {
                    validators: {
                        notEmpty: {
                            message: 'Leave Code is required'
                        }
                    }
                }
            }
        }).on('success.form.fv', function(e) {
            e.preventDefault();
            var leave_validation = '<?= base_url() ?>staff/validation_steptwo';
            var from_employee_leave = document.getElementById("from_employee_leave");
            var from_employee_leave_value = from_employee_leave.options[from_employee_leave.selectedIndex].value;
            //One
            var leavebal = document.getElementById("leavebalact").value;
            var startdaten = document.getElementById("leavefromactx").value;
            var enddaten = document.getElementById("leavetoactx").value;
            var leavecode = document.getElementById("leavecode");
            var leavecode_value = leavecode.options[leavecode.selectedIndex].value;
            var pin = from_employee_leave_value.split('|')[1];
            $.ajax({
                url: leave_validation, //This is the current doc
                type: "POST",
                dataType: 'json', // add json datatype to get json
                data: {
                    pin: pin,
                    leavetype: leavecode_value,
                    leavebal: leavebal,
                    startdate: startdaten,
                    enddate: enddaten
                },
                success: function(response) {
                    if (response.report === 1) {
                        $.notify(response.error, "error");
                    } else {
                        var from_employee_leave = document.getElementById("from_employee_leave");
                        var employee_idvalue = from_employee_leave.options[from_employee_leave.selectedIndex].value;
                        //One
                        var startdatex = document.getElementById("leavefromactx").value;
                        var endate = document.getElementById("leavetoactx").value;
                        var leavecode = document.getElementById("leavecode");
                        var leavecode_value = leavecode.options[leavecode.selectedIndex].value;
                        $.ajax({
                            url: loadleavedata, //This is the current doc
                            type: "POST",
                            dataType: 'json', // add json datatype to get json
                            data: ({
                                from_employee_leave: employee_idvalue,
                                startdatex: startdatex,
                                enddatex: endate,
                                leavecode: leavecode_value
                            }),
                            success: function(response) {
                                //                            console.log(startdaten + ' ' + enddaten + ' ' + leavecode_value + ' ' + pin);
                                datagrid = new DatabaseGrid('attendence_leaves', "tablecontentleave", startdaten, enddaten, leavecode_value, pin);
                                $("#leavedelbutton_id").show();
                            }
                        });
                    }
                }
            });
        });
    document.getElementById('leavedelbutton_id').onclick = function() {
        var from_employee_leave = document.getElementById("from_employee_leave");
        var from_employee_leave_value = from_employee_leave.options[from_employee_leave.selectedIndex].value;
        //One
        var startdatex = document.getElementById("leavefromactx").value;
        var endate = document.getElementById("leavetoactx").value;
        var leavecode = document.getElementById("leavecode");
        var leavecode_value = leavecode.options[leavecode.selectedIndex].value;
        $.ajax({
            url: deleteall, //This is the current doc
            type: "POST",
            dataType: 'json', // add json datatype to get json
            data: ({
                employee: from_employee_leave_value,
                startdatex: startdatex,
                enddatex: endate,
                leavecode: leavecode_value
            }),
            success: function(data) {
                //                console.log(data);
                if (data.status === 1) {
                    $.notify(data.report, "error");
                    $("#leavedelbutton_id").hide();
                } else if (data.status === 2) {
                    $.notify(data.report, "success");
                    empleave_list();
                }
            }
        });
    };

    function empleave_list() {
        sessionStorage.setItem("empleave", "true");
        //        document.location.reload();
        window.setTimeout(function() {
            window.location.reload();
        }, 2000);
    };
    window.onload = function() {
        var reloadingwala = sessionStorage.getItem("empleave");
        if (reloadingwala) {
            sessionStorage.removeItem("empleave");
            var l = document.getElementById('id_employeeleaveapp');
            l.click();
        }
    };

    function setbalance() {
        var url_balanceleave = '<?= base_url() ?>staff/calculateleave_admin';
        //        var leavetypeid = document.getElementById("id_leavetype").value;
        var e = document.getElementById("leavecode");
        var leavetypeid = e.options[e.selectedIndex].value;
        var leavetypename = e.options[e.selectedIndex].value;
        //        alert(leavetypename + startdate + enddate);
        var from_employee_leave = document.getElementById("from_employee_leave");
        var from_employee_leave_value = from_employee_leave.options[from_employee_leave.selectedIndex].value;
        var pin = from_employee_leave_value.split('|')[1];
        //END
        //        var startdatex = document.getElementById("startdatex").value;
        //        var endatex = document.getElementById("enddatex").value;
        var startdatex = document.getElementById("leavefromactx").value;
        var endatex = document.getElementById("leavetoactx").value;
        //        console.log(startdatex + endatex + ' ' + pin);
        $.ajax({
            url: url_balanceleave, //This is the current doc
            type: "POST",
            dataType: 'json', // add json datatype to get json
            data: {
                pin: pin,
                leavetype: leavetypeid,
                leavename: leavetypename,
                startdate: startdatex,
                enddate: endatex
            },
            success: function(response) {
                //                console.log(response);
                if (response.report === '1') {
                    $.notify(response.error, "error");
                } else {
                    $.notify(response.message, "success");
                    document.getElementById("leavebalact").value = response.amount;
                }
            }
        });
    }
</script>