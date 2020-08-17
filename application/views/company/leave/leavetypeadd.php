<?php
$leaveconfig = $controller->gettablecolumns('leaveconfig');
$leaveconfigvalues = array();
?>

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
                    <!--end-->
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
                    <div <?= hideorshow(array_keyvaluen($leaveconfig, 'payrate')['status']) ?>>
                        <label class="col-sm-2 control-label" for="form-field-1">
                            PAY RATE
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="PAY RATE" id="payrate" name="payrate" class="form-control"  value="<?= printvalues('payrate', $leaveconfigvalues) ?>">
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($leaveconfig, 'defaultentitlementleave')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            DEFAULT ENT DAYS
                        </label>
                        <div class="col-sm-1">
                            <input type="text" placeholder="20" id="defaultentitlementleave" name="defaultentitlementleave"  class="form-control" value="<?= printvalues('defaultentitlementleave', $leaveconfigvalues) ?>">
                        </div>
                    </div>

                </div>
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($leaveconfig, 'maximumdays')['status']) ?>>
                        <label class="col-sm-2 control-label" for="form-field-1">
                            MAXIMUM DAYS
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="10" id="maximumdays" name="maximumdays" class="form-control"  value="<?= printvalues('maximumdays', $leaveconfigvalues) ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($leaveconfig, 'recurring')['status']) ?>>
                        <label class="col-sm-2 control-label" for="form-field-1">
                            RECURRING
                        </label>
                        <div class="col-sm-2">
                            <div class="btn-group" id="recurringn" data-toggle="buttons">
                                <label class="btn btn-default btn-on ">
                                    <input type="radio" value="1" name="recurring" >YES</label>
                                <label class="btn btn-default btn-off active">
                                    <input type="radio" value="0" name="recurring" >NO</label>
                            </div>
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($leaveconfig, 'paid')['status']) ?> >
                        <label class="col-sm-1 control-label">
                            PAID
                        </label>
                        <div class="col-sm-2">
                            <div class="btn-group" id="paid" data-toggle="buttons">
                                <label class="btn btn-default btn-on ">
                                    <input type="radio" value="1" name="paid" >YES</label>
                                <label class="btn btn-default btn-off active">
                                    <input type="radio" value="0" name="paid" >NO</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
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

    $(document).ready(function () {
        datagrid = new DatabaseGrid('leaveconfig', "tablecontentleaveconfig");
        // key typed in the filter field
        $("#filterleaveconfig").keyup(function () {
            datagrid.editableGrid.filter($(this).val());
//            console.log($(this).val());
            // To filter on some columns, you can set an array of column index 
            //datagrid.editableGrid.filter( $(this).val(), [0,3,5]);
        });
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
                                },
                                numeric: {
                                    message: 'Only Numbers are Requireds'
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
                        }
                        ,
                        maximumdays: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($leaveconfig, 'maximumdays')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'MAXIMUM AMOUNT  is required'
                                },
                                numeric: {
                                    message: 'Only Numbers are Required'
                                }
                            }
                        }
                        ,
                        includehday: {
                            enabled: true,
                            validators: {
                                numeric: {
                                    message: 'Only Numbers are Required'
                                }
                            }
                        }
                    }
                }).on('success.form.fv', function (e) {
            // Save the form data via an Ajax request
            e.preventDefault();
            datagrid.addRow('leaveconfig', $(this).attr("method"), new FormData(this), "tablecontentleaveconfig");
            $('#leaveconfigconfigform').formValidation('resetForm', true);
        });
    });
</script>
