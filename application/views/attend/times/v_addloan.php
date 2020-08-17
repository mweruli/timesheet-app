<div class="row" id="idpaneladdloan">
    <div class="col-sm-12">
        <!-- start: TEXT FIELDS PANEL -->
        <div class="panel-body">
            <form id="idpaneladdloanform" method="post" class="form-horizontal"
                  role="form">
                <input type="hidden"  id="tablename" name="tablename"  class="form-control" value="appliedloans">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="form-field-1"> Branch </label>
                    <div class="col-sm-4">
                        <select class="form-control search-select"
                                placeholder="Select Employee" name="branch_start_applyloan"
                                id="branch_start_applyloan" onChange="selectuserloanapply();">
                            <option selected="selected" value="">-SELECT BRANCH-</option>
                            <?php
                            if (!empty($allbranches)) {
                                ?>
                                <option
                                    value="<?= $allbranches[0]['readerserial'] . '$' . $allbranches[0]['names'] . '$' . $allbranches[0]['userpin'] ?>"><?= $allbranches[0]['branchname'] ?></option>
                                    <?php
                                    array_shift($allbranches);
                                }
                                foreach ($allbranches as $value) {
                                    ?>
                                <option
                                    value="<?= $value['readerserial'] . '$' . $value['names'] . '$' . $value['userpin'] ?>"><?= $value['branchname'] ?></option>
                                    <?php
                                }
                                ?>
                        </select>
                    </div>
                    <label class="col-sm-2 control-label" for="form-field-1"> Employee
                    </label>
                    <div class="col-sm-4">
                        <select id="dropdownemployeeapplyloan"
                                name="dropdownemployeeapplyloan" class="form-control search-select"
                                required>
                            <option value="">-SELECT EMPLOYEE-</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Loan  Amount </label>
                    <div class="col-sm-4">
                        <input type="text" placeholder="Loan Amount" id="amount" name="amount"  class="form-control">
                    </div>

                    <label class="col-sm-2 control-label">Description</label>
                    <div class="col-sm-4">
                        <input type="text" placeholder="Description" id="description" name="description"  class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="form-field-1"> Loan Type
                    </label>
                    <div class="col-sm-4">
                        <select id="dropdownloantype"
                                name="dropdownloantype" class="form-control search-select"
                                required>
                            <option value="">-SELECT LOAN TYPE-</option>
                            <?php
                            foreach ($controller->allselectablebytable('loantypes') as $loantypes) {
                                ?>
                                <option value="<?= $loantypes['id'] ?>"><?= $loantypes['loantype'] . ' |  ' . $loantypes['interestmethod'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <label class="col-sm-2 control-label" for="form-field-1">
                    </label>
                    <div class="col-sm-2">
                        <div class="btn-group" id="status" data-toggle="buttons">
                            <label class="btn btn-default btn-on active">
                                <input type="radio" value="1" name="multifeatured_module[module_id][status]" checked="checked">ACT</label>
                            <label class="btn btn-default btn-off">
                                <input type="radio" value="0" name="multifeatured_module[module_id][status]">OFF</label>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <button class="btn btn-small btn-red" type="submit">
                            Advance Loan&nbsp;<i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
            </form>
            <div id="toolbar">
                <input type="text" id="filter" name="filter"
                       placeholder="Filter :type any text here" class="form-control" />
            </div>
            <!-- Grid contents -->
            <div  id="tablecontentloanapply">

            </div>
            <!-- Paginator control -->
            <div id="paginator"></div>
        </div>
        <!-- end: TEXT FIELDS PANEL -->
    </div>
</div>
<script>
//Employee Afair
    function selectuserloanapply() {
        var e = document.getElementById("branch_start_applyloan");
        $('#dropdownemployeeapplyloan').find('option:not(:first)').remove();
        //To Extraxt

        var milearrays_on = new Array();
        var milearrays_on1 = new Array();
        var milearrays_on2 = new Array();
        var fields = new Array();
        var mile_stones = new Array();
        var strUser = "";
        strUser = e.options[e.selectedIndex].value;
        //alert(strUser);
        fields = strUser.split('$');
        mile_stones = fields[1];
//      mile_stones1=fields[2];
        mile_stones2 = fields[2];
        milearrays_on = mile_stones.split('@');
        milearrays_on2 = mile_stones2.split('@');

        var $dropdown = $("#dropdownemployeeapplyloan");
        for (var i = 0; i < milearrays_on.length; i++) {
            $dropdown.append($("<option />").val(milearrays_on[i] + '|' + milearrays_on2[i]).text(milearrays_on[i] + ' ~pin~ ' + milearrays_on2[i]));
        }
    }
    var loadallowanceurl = "<?php echo base_url("posts/addalloance"); ?>";
    $(document).ready(function () {
        datagrid = new DatabaseGrid('appliedloans', "tablecontentloanapply");
        // key typed in the filter field
        $("#filtercompanybranch").keyup(function () {
            datagrid.editableGrid.filter($(this).val());
//            console.log($(this).val());
            // To filter on some columns, you can set an array of column index 
            //datagrid.editableGrid.filter( $(this).val(), [0,3,5]);
        });
        $('#loanapproveddate')
                .datepicker({
                    format: 'yyyy-mm-dd'
                })
                .on('changeDate', function (e) {
                    // Revalidate the date field
                    $('#idpaneladdloanform').formValidation('revalidateField', 'loanapproveddate');
                });
    });
    $('#idpaneladdloanform')
            .formValidation({
                framework: 'bootstrap',
                icon: {
//                     valid: 'glyphicon glyphicon-ok',
//                     invalid: 'glyphicon glyphicon-remove',
//                     validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    amount: {
                        validators: {
                            notEmpty: {
                                message: 'Amount is required'
                            },
                            regexp: {
                                regexp: /^\d{1,5}$/,
                                message: 'Advanced  Deduction Reached The Limit'
                            }
                        }
                    },
                    branch_start_applyloan: {
                        validators: {
                            notEmpty: {
                                message: 'Branch is required'
                            }
                        }
                    },
                    dropdownemployeeapplyloan: {
                        validators: {
                            notEmpty: {
                                message: 'Employee is required'
                            }
                        }
                    },
                    dropdownallowance: {
                        validators: {
                            notEmpty: {
                                message: 'Allowance Category is required'
                            }
                        }
                    },
                    loanapproveddate: {
                        validators: {
                            notEmpty: {
                                message: 'Date for Allowance is required'
                            },
                            date: {
                                format: 'YYYY-MM-DD',
                                message: 'The date is not a valid'
                            }
                        }
                    },
                    dropdownloantype: {
                        validators: {
                            notEmpty: {
                                message: 'Loan Type  is required'
                            }
                        }
                    }
                }
            }).on('success.form.fv', function (e) {
        e.preventDefault();
        datagrid.addRow('appliedloans', $(this).attr("method"), new FormData(this), "tablecontentloanapply");
        $('#idpaneladdloanform').formValidation('resetForm', true);
    });
</script>