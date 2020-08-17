<div class="row" id="add_advancededection">
    <div class="col-sm-12">
        <!-- start: TEXT FIELDS PANEL -->
        <div class="panel-body">
            <form id="add_advancededectionform" method="post" class="form-horizontal"
                  role="form">
                <input type="hidden"  id="tablename" name="tablename"  class="form-control" value="advanceddeduction">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="form-field-1"> Branch </label>
                    <div class="col-sm-4">
                        <select class="form-control search-select"
                                placeholder="Select Employee" name="branch_start_advanceadd"
                                id="branch_start_advanceadd" onChange="selectuseradvanced();">
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
                        <select id="dropdownemployeetoadvandec"
                                name="dropdownemployeetoadvandec" class="form-control search-select"
                                required>
                            <option value="">-SELECT EMPLOYEE-</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"> Amount </label>
                    <div class="col-sm-4">
                        <input type="text" placeholder="Amount" id="amount" name="amount"  class="form-control">
                    </div>
                    <label class="col-sm-2 control-label"> Date </label>
                    <div class="col-sm-4 date">
                        <div class="input-group input-append date" id="dateformanualaddadvanceallow">
                            <input type="text" name="dateformanualaddadvanceallow" id="dateformanualaddadvancevalallow"
                                   class="form-control"> <span class="input-group-addon add-on"><span
                                    class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-4 pull-right">
                        <button class="btn btn-red btn-block" type="submit">
                            Advance Deduction&nbsp;<i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
            </form>
            <div id="toolbar">
                <input type="text" id="filter" name="filter"
                       placeholder="Filter :type any text here" class="form-control" />
            </div>
            <!-- Grid contents -->
            <div 
                id="tablecontentadvancededuc">

            </div>
            <!-- Paginator control -->
            <div id="paginator"></div>
        </div>
        <!-- end: TEXT FIELDS PANEL -->
    </div>
</div>
<script>
//Employee Afair
    function selectuseradvanced() {
        var e = document.getElementById("branch_start_advanceadd");
        $('#dropdownemployeetoadvandec').find('option:not(:first)').remove();
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

        var $dropdown = $("#dropdownemployeetoadvandec");
        for (var i = 0; i < milearrays_on.length; i++) {
            $dropdown.append($("<option />").val(milearrays_on[i] + '|' + milearrays_on2[i]).text(milearrays_on[i] + ' ~pin~ ' + milearrays_on2[i]));
        }
    }
    $(document).ready(function() {
        datagrid = new DatabaseGrid('advanceddeduction', "tablecontentadvancededuc");
        // key typed in the filter field
        $("#filtercompanybranch").keyup(function() {
            datagrid.editableGrid.filter($(this).val());
//            console.log($(this).val());
            // To filter on some columns, you can set an array of column index 
            //datagrid.editableGrid.filter( $(this).val(), [0,3,5]);
        });
        $('#dateformanualaddadvanceallow')
                .datepicker({
                    format: 'yyyy-mm-dd'
                })
                .on('changeDate', function(e) {
                    // Revalidate the date field
                    $('#add_advancededectionform').formValidation('revalidateField', 'dateformanualaddadvanceallow');
                });
    });
    $('#add_advancededectionform')
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
                    branch_start_advanceadd: {
                        validators: {
                            notEmpty: {
                                message: 'Branch is required'
                            }
                        }
                    },
                    dropdownemployeetoadvandec: {
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
                    dateformanualaddadvanceallow: {
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
            }).on('success.form.fv', function(e) {
        e.preventDefault();
        datagrid.addRow('advanceddeduction', $(this).attr("method"), new FormData(this), "tablecontentadvancededuc");
        $('#add_advancededectionform').formValidation('resetForm', true);
    });
</script>