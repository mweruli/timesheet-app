<div class="row" id="add_manualallowence">
    <div class="col-sm-12">
        <!-- start: TEXT FIELDS PANEL -->
        <div class="panel-body">
            <form id="add_manualallowance" method="post" class="form-horizontal"
                  role="form">
                <input type="hidden"  id="tablename" name="tablename"  class="form-control" value="allowances">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="form-field-1"> Branch </label>
                    <div class="col-sm-4">
                        <select class="form-control search-select"
                                placeholder="Select Employee" name="branch_start_manualallow"
                                id="branch_start_manualallow" onChange="selectuserbranchallowence();">
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
                        <select id="dropdownemployeetoinputallow"
                                name="dropdownemployeetoinputallow" class="form-control search-select"
                                required>
                            <option value="">-SELECT EMPLOYEE-</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="form-field-1"> Allowance
                    </label>
                    <div class="col-sm-4">
                        <select id="dropdownallowance"
                                name="dropdownallowance" class="form-control search-select"
                                required>
                            <option value="">-SELECT ALLOWANCE CAT-</option>
                            <?php
                            foreach ($allowancecats as $allowances) {
                                ?>
                                <option value="<?= $allowances['id'] ?>"><?= $allowances['allowance'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <label class="col-sm-2 control-label"> Date </label>
                    <div class="col-sm-4 date">
                        <div class="input-group input-append date" id="dateformanualallow">
                            <input type="text" name="dateformanualallow" id="dateformanualvalallow"
                                   class="form-control"> <span class="input-group-addon add-on"><span
                                    class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"> Amount </label>
                    <div class="col-sm-4">
                        <input type="text" placeholder="Amount" id="amount" name="amount"  class="form-control">
                    </div>
                    <label class="col-sm-2 control-label">  </label>
                    <div class="col-sm-3">
                        <button class="btn btn-red btn-block" type="submit">
                            Add Allowance&nbsp;<i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
            </form>
            <div id="toolbar">
                <input type="text" id="filter" name="filter"
                       placeholder="Filter :type any text here" class="form-control" />
            </div>
            <!-- Grid contents -->
            <div  id="tablecontentallances">
            </div>
            <!-- Paginator control -->
            <div id="paginator"></div>
        </div>
        <!-- end: TEXT FIELDS PANEL -->
    </div>
</div>
<script>
//Employee Afair
    function selectuserbranchallowence() {
        var e = document.getElementById("branch_start_manualallow");
        $('#dropdownemployeetoinputallow').find('option:not(:first)').remove();
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

        var $dropdown = $("#dropdownemployeetoinputallow");
        for (var i = 0; i < milearrays_on.length; i++) {
            $dropdown.append($("<option />").val(milearrays_on[i] + '|' + milearrays_on2[i]).text(milearrays_on[i] + ' ~pin~ ' + milearrays_on2[i]));
        }
    }
    var loadallowanceurl = "<?php echo base_url("posts/addalloance"); ?>";
    $(document).ready(function () {
        datagrid = new DatabaseGrid('manualallowences', "tablecontentallances");
        // key typed in the filter field
        $("#filter").keyup(function () {
            datagrid.editableGrid.filter($(this).val());
//            console.log($(this).val());
            // To filter on some columns, you can set an array of column index 
            //datagrid.editableGrid.filter( $(this).val(), [0,3,5]);
        });
        $('#dateformanualallow')
                .datepicker({
                    format: 'yyyy-mm-dd'
                })
                .on('changeDate', function (e) {
                    // Revalidate the date field
                    $('#add_manualallowance').formValidation('revalidateField', 'dateformanualallow');
                });
    });
    $('#add_manualallowance')
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
                                message: 'Allowance Excceded The Limit'
                            }
                        }
                    },
                    branch_start_manualallow: {
                        validators: {
                            notEmpty: {
                                message: 'Branch is required'
                            }
                        }
                    },
                    dropdownemployeetoinputallow: {
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
                    dateformanualallow: {
                        validators: {
                            notEmpty: {
                                message: 'Date for Allowance is required'
                            },
                            date: {
                                format: 'YYYY-MM-DD',
                                message: 'The date is not a valid'
                            }
                        }
                    }
                }
            }).on('success.form.fv', function (e) {
        e.preventDefault();
        datagrid.addRow('manualallowences', $(this).attr("method"), new FormData(this), "tablecontentallances");
        $('#add_manualallowance').formValidation('resetForm', true);
    });
</script>