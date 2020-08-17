<div class="panel-body">
    <form class="form-horizontal" role="form" method="post"
          name="att_card_formx" id="att_card_formx" novalidate>
        <div class="form-group">
            <label class="col-sm-1 control-label"> Branch </label>
            <div class="col-sm-5">
                <select id="branch_start" name="branch_start"
                        class="form-control search-select" onclick="selectuserbranch();">
                    <option value="">--SELECT BRANCH --</option>
                    <?php
                    foreach ($allbranches as $value) {
                        ?>
                        <option
                            value="<?= $value['readerserial'] . '$' . $value['names'] . '$' . $value['userpin'] ?>"><?= $value['branchname'] ?></option>
                            <?php
                        }
                        ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label"> Employee </label>
            <div class="col-sm-4">
                <select id="employeenumberminx" name="employeenumberminx"
                        class="form-control search-select" required>
                    <!-- 					<option value="">--EMPLOYEE RANGE START --</option> -->
                </select>
            </div>
            <label class="col-sm-1 control-label">Type </label>
            <div class="col-sm-4">
                <select  class="form-control search-select" placeholder="Select Form" name="employmenttype_id" id="employmenttype_id" disabled>
                    <option value="">-SELECT Employment Type-</option>
                    <?php
                    foreach ($controller->allselectablebytable('employementtypes') as $emptyp) {
                        if ($emptyp['id'] == 2) {
                            ?>
                            <option  value="<?= $emptyp['id'] ?>" selected><?= $emptyp['employementtype'] ?></option>
                            <?php
                        } else {
                            ?>
                            <option  value="<?= $emptyp['id'] ?>" disabled><?= $emptyp['employementtype'] ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label"> Custom Deduction </label>
            <div class="col-sm-4">
                <select  class="form-control search-select" placeholder="Select Form" name="customededuc_id" id="customededuc_id"  >
                    <option value="">-SELECT Custom Deduc-</option>
                    <?php
                    foreach ($controller->allselectablebytable('customparams') as $emptyp) {
                        ?>
                        <option  value="<?= $emptyp['id'] ?>"><?= $emptyp['code'] . ' | ' . $emptyp['description'] ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <label class="col-sm-1 control-label"> Amount </label>
            <div class="col-sm-4">
                <input type="text" placeholder="100" id="amount_custome" name="amount_custome" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-7" id="lastupdateupdate">
            </div>
            <div class="col-sm-5">
                <button class="btn btn-azure btn-sm" type="submit">
                    Add&nbsp;<i class="fa fa-plus"></i>
                </button>
            </div>
        </div>
    </form>
    <div id="wrap panel-white col-sm-12">
        <div id="tablecontentcustome">
        </div>
        <!-- Paginator control -->
        <div id="paginatorcustome" class="paginator"></div>
    </div>
</div>
<script>
    var loadcard = "<?php echo base_url("payroll/addcustomstouser"); ?>";
    var checklastupdatedand = "<?php echo base_url("aot/reportlastupdate"); ?>";
    function selectuserbranch() {
        var e = document.getElementById("branch_start");
        $('#employeenumberminx').find('option:not(:first)').remove();

        //To Extraxt
        var milearrays_on = new Array();
//         var milearrays_on1 = new Array();
        var milearrays_on2 = new Array();
        var fields = new Array();
        //Seqg
        var mile_stones = new Array();
//         var mile_stones1 = new Array();
        var mile_stones2 = new Array();
        var strUser = "";
        strUser = e.options[e.selectedIndex].value;
        //alert(strUser);
        fields = strUser.split('$');
        var name = fields[0];
        mile_stones = fields[1];
//         mile_stones1=fields[2];
        mile_stones2 = fields[2];
        milearrays_on = mile_stones.split('@');
//         milearrays_on1=mile_stones1.split('@');
        milearrays_on2 = mile_stones2.split('@');
//         console.log(mile_stones2);
        var $dropdown = $("#employeenumberminx");
        //alert(milearrays_on[0]);
        for (var i = 0; i < milearrays_on.length; i++) {
            $dropdown.append($("<option />").val(milearrays_on[i] + '|' + milearrays_on2[i]).text(milearrays_on[i] + ' ~pin~ ' + milearrays_on2[i]));
            if (i === 0) {
                $dropdown.val(milearrays_on[i] + '|' + milearrays_on2[i]).change();
//                console.log('joash njovu');
            }
        }
        //START
        datagrid = new DatabaseGrid(name, "tablecontentcustome", 'paginatorcustome', 'user_customeaddition');
        $("#filter").keyup(function () {
            datagrid.editableGrid.filter($(this).val());
            // To filter on some columns, you can set an array of column index 
            //datagrid.editableGrid.filter( $(this).val(), [0,3,5]);        
        });
        //END
        //Some Ajax Reporting
        $.ajax({
            url: checklastupdatedand + '/' + name,
            type: 'POST',
            dataType: "JSON",
            data: {branchserial: 'abcd'},
            processData: false,
            contentType: false
        }).done(function (response) {
//            console.log(response);
//            console.log(name + ' jacki sumayiya');
            document.getElementById('lastupdateupdate').innerHTML = "<p>" + "<font size='1'>" + 'Last Updated On ' + "</font>" + "<font size='1' color='red'>" + response.lastupdate + "</font>" + " " + "<font size='1'>" + " TOTAL NO OF EMPLOYEES " + "</font>" + "<font size='1' color='green'>" + response.numberofemply + "</font>" + "<font size='1' color='blue'>" + ' TOTAL CASUALS ' + "</font>" + "<font size='1' color='green'>" + response.CASUALS + "</font>" + ' ' + "<font size='1' color='blue'>" + ' TOTAL CONTRACT ' + "</font>" + "<font size='1' color='green'>" + response.CONTRACT + "</font>" + "<font size='1' color='blue'>" + ' TOTAL PERMANENT ' + "</font>" + "<font size='1' color='green'>" + response.PERMANENT + "</font>" + "</p>";
        });
//        console.log(strUser);
    }
    //Date Affair
    $(document).ready(function () {
        $("#employeenumberminx").val($("#employeenumberminx option:first").val());
// console.log(date);
    });
    $("#att_card_formx").formValidation({
        framework: 'bootstrap',
        icon: {
//            valid: 'glyphicon glyphicon-ok',
//            invalid: 'glyphicon glyphicon-remove',
//            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            employmenttype_id: {
                validators: {
                    notEmpty: {
                        message: 'Employee Type is required'
                    }
                }
            },
            customededuc_id: {
                validators: {
                    notEmpty: {
                        message: 'Custome Deduction is required'
                    }
                }
            },
            employeenumberminx: {
                validators: {
                    notEmpty: {
                        message: 'Employee is required'
                    }
                }
            },
            amount_custome: {
                validators: {
                    notEmpty: {
                        message: 'To Amount is required'
                    },
                    numeric: {
                        message: 'Only Numbers are allowed'
                    }
                }
            }
        }
    }).on('success.form.fv', function (e) {
        e.preventDefault();
        $.ajax({
            url: loadcard,
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
            var e = document.getElementById("branch_start");
            var strUser = "";
            strUser = e.options[e.selectedIndex].value;
            //alert(strUser);
            fields = strUser.split('$');
            var name = fields[0];
//            console.log(name);
            datagrid = new DatabaseGrid(name, "tablecontentcustome", 'paginatorcustome', 'user_customeaddition');
            datagrid.loadCustomeParams(name);
        });
    });
</script>