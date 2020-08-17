<?php
$leaveconfig = $controller->gettablecolumns('leaveconfig');
$leaveconfigvalues = array();
?>
<style>
    .material-switch > input[type="checkbox"] {
        display: none;   
    }
    .material-switch > label {
        cursor: pointer;
        height: 0px;
        position: relative; 
        width: 40px;  
    }

    .material-switch > label::before {
        background: rgb(0, 0, 0);
        box-shadow: inset 0px 0px 10px rgba(0, 0, 0, 0.5);
        border-radius: 8px;
        content: '';
        height: 16px;
        margin-top: -8px;
        position:absolute;
        opacity: 0.3;
        transition: all 0.4s ease-in-out;
        width: 40px;
    }
    .material-switch > label::after {
        background: rgb(255, 255, 255);
        border-radius: 16px;
        box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
        content: '';
        height: 24px;
        left: -4px;
        margin-top: -8px;
        position: absolute;
        top: -4px;
        transition: all 0.3s ease-in-out;
        width: 24px;
    }
    .material-switch > input[type="checkbox"]:checked + label::before {
        background: inherit;
        opacity: 0.5;
    }
    .material-switch > input[type="checkbox"]:checked + label::after {
        background: inherit;
        left: 20px;
    }
</style>
<div class="row" id="leaveconfigconfig">
    <div class="col-sm-12">
        <!-- start: TEXT FIELDS PANEL -->
        <!--<div class="panel panel-white">-->
        <div class="panel-heading">
            <h4 class="panel-title"> LEAVE <span class="text-bold">TYPE</span></h4>
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
            <form id="leaveconfigconfigform" role="form" method="post" class="form-horizontal" novalidate>
                <input type="hidden"  id="tablename" name="tablename"  class="form-control" value="leaveconfig">
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($leaveconfig, 'leavetype')['status']) ?>>
                        <label class="col-sm-2 control-label" for="form-field-1">
                            LEAVE TYPE
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder=" LEAVE TYPE" id="leavetype" name="leavetype" class="form-control"  value="<?= printvalues('leavetype', $leaveconfigvalues) ?>">
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($leaveconfig, 'defaultentitlementleave')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            DEFAULT  ENTITLEMENT
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder=" DEFAULT  ENTITLEMENT" id="defaultentitlementleave" name="defaultentitlementleave"  class="form-control" value="<?= printvalues('defaultentitlementleave', $leaveconfigvalues) ?>">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($leaveconfig, 'payrate')['status']) ?>>
                        <label class="col-sm-2 control-label" for="form-field-1">
                            PAY RATE
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="PAY RATE" id="payrate" name="payrate" class="form-control"  value="<?= printvalues('payrate', $leaveconfigvalues) ?>">
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($leaveconfig, 'narration')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            NARRATION 
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="" id="narration" name="narration"  class="form-control" value="<?= printvalues('narration', $leaveconfigvalues) ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($leaveconfig, 'maximumamount')['status']) ?>>
                        <label class="col-sm-2 control-label" for="form-field-1">
                            MAXIMUM AMOUNT
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder=" MAXIMUM AMOUNT" id="maximumamount" name="maximumamount" class="form-control"  value="<?= printvalues('maximumamount', $leaveconfigvalues) ?>">
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($leaveconfig, 'paid')['status']) ?>>
                        <label class="col-sm-2 control-label">

                        </label>
                        <div class="col-sm-4">
                            <li class="list-group-item">
                                PAID
                                <div class="material-switch pull-right">
                                    <input id="paid" name="paid" type="checkbox" />
                                    <label for="paid" class="label-success"></label>
                                </div>
                            </li>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($leaveconfig, 'recurring')['status']) ?>>
                        <label class="col-sm-2 control-label">
                        </label>
                        <div class="col-sm-4">
                            <li class="list-group-item">
                                RECURRING
                                <div class="material-switch pull-right">
                                    <input id="recurringn" name="recurring" type="checkbox" />
                                    <label for="recurringn" class="label-success"></label>
                                </div>
                            </li>
                        </div>
                    </div>
                    <div class="col-sm-4 pull-right">
                        <button class="btn btn-green btn-block" type="submit">
                            Add&nbsp;<i class="fa fa-arrow-circle-right"></i>
                        </button>
                    </div>
                </div>
            </form>
            <div id="message"></div>
            <div id="wrap">
                <!-- Feedback message zone -->
                <div id="toolbar">
                    <input type="text" id="filterleaveconfig" name="filterleaveconfig"
                           placeholder="Filter :type any text here" class="form-control" />
                </div>
                <!-- Grid contents -->
                <div id="tablecontentleaveconfig"></div>
                <!-- Paginator control -->
                <div id="paginator"></div>
            </div>
        </div>
    </div>
</div>
<script>
    var datagrid;
    window.onload = function() {
        datagrid = new DatabaseGrid('leaveconfig', "tablecontentleaveconfig");
        // key typed in the filter field
        $("#filterleaveconfig").keyup(function() {
            datagrid.editableGrid.filter($(this).val());
//            console.log($(this).val());
            // To filter on some columns, you can set an array of column index 
            //datagrid.editableGrid.filter( $(this).val(), [0,3,5]);
        });
    }
    $(document).ready(function() {
        $('#leaveconfigconfigform')
                .formValidation({
                    framework: 'bootstrap',
                    icon: {
                    },
                    fields: {
                        leavetype: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($leaveconfig, 'leavetype')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Leave Type  is required'
                                }
                            }
                        }
                        ,
                        defaultentitlementleave: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($leaveconfig, 'defaultentitlementleave')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'DEFAULT Entitlement  is required'
                                }
                            }
                        }
                        ,
                        payrate: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($leaveconfig, 'payrate')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Pay Rate  is required'
                                }
                            }
                        },
                        narration: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($leaveconfig, 'narration')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'NARRATION  Required'
                                }
                            }
                        },
                        maximumamount: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($leaveconfig, 'maximumamount')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'MAXIMUM AMOUNT  is required'
                                }
                            }
                        }
                    }
                }).on('success.form.fv', function(e) {
            // Save the form data via an Ajax request
            e.preventDefault();
            datagrid.addRow('leaveconfig', $(this).attr("method"), new FormData(this), "tablecontentleaveconfig");
            $('#leaveconfigconfigform').formValidation('resetForm', true);
        });
    });
</script>

