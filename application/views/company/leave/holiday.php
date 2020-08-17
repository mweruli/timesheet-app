<?php
$holidayconfig = $controller->gettablecolumns('holidayconfig');
$holidayconfigvalues = array();
?>
<div class="row" id="holidayconfigconfig">
    <div class="col-sm-12">
        <!-- start: TEXT FIELDS PANEL -->
        <!--<div class="panel panel-white">-->
        <div class="panel-heading">
            <h4 class="panel-title"> <span class="text-bold">HOLIDAY</span></h4>
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
            <form id="holidayconfigconfigform" role="form" method="post" class="form-horizontal" novalidate>
                <input type="hidden"  id="tablename" name="tablename"  class="form-control" value="holidayconfig">
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($holidayconfig, 'holidayname')['status']) ?>>
                        <label class="col-sm-2 control-label" for="form-field-1">
                            HOLIDAY NAME
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder=" HOLIDAY NAME" id="holidayname" name="holidayname" class="form-control"  value="<?= printvalues('holidayname', $holidayconfigvalues) ?>">
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($holidayconfig, 'date')['status']) ?>>
                        <label class="col-sm-2 control-label" for="form-field-1">
                            DATE
                        </label>
                        <div class="col-sm-4">
                            <div class="input-group input-append date" id="date">
                                <input type="text"  placeholder="12-09-2012" name="date" class="form-control" value="<?= printvalues('date', $holidayconfigvalues) ?>" >
                                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($holidayconfig, 'payrate')['status']) ?>>
                        <label class="col-sm-2 control-label" for="form-field-1">
                            PAY RATE
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="PAY RATE" id="payrate" name="payrate" class="form-control"  value="<?= printvalues('payrate', $holidayconfigvalues) ?>">
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($holidayconfig, 'description')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            DESCRIPTION
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder=" DESCRIPTION " id="description" name="description"  class="form-control" value="<?= printvalues('description', $holidayconfigvalues) ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($holidayconfig, 'repeatsannually')['status']) ?>>
                        <label class="col-sm-2 control-label" for="form-field-1">
                            REPEATS ANNUALLY
                        </label>
                        <div class="col-sm-2">
                            <div class="btn-group" id="repeatsannually" data-toggle="buttons">
                                <label class="btn btn-default btn-on ">
                                    <input type="radio" value="1" name="repeatsannually" >YES</label>
                                <label class="btn btn-default btn-off active">
                                    <input type="radio" value="0" name="repeatsannually" >NO</label>
                            </div>
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
                    <input type="text" id="filterholidayconfig" name="filterholidayconfig"
                           placeholder="Filter :type any text here" class="form-control" />
                </div>
                <!-- Grid contents -->
                <div id="tablecontentholidayconfig"></div>
                <!-- Paginator control -->
                <div id="paginator"></div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        // key typed in the filter field
        $('#date')
                .datepicker({
                    format: 'dd-mm-yyyy'
                })
                .on('changeDate', function (e) {
                    // Revalidate the date field
                    $('#employeeconfigform').formValidation('revalidateField', 'dob');
                });
        $('#holidayconfigconfigform')
                .formValidation({
                    framework: 'bootstrap',
                    icon: {
                    },
                    fields: {
                        holidayname: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($holidayconfig, 'holidayname')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'HOLIDAY Name  is required'
                                }
                            }
                        }
                        ,
                        date: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($holidayconfig, 'date')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'DATE   is required'
                                },
                                date: {
                                    format: 'DD-MM-YYYY',
                                    message: 'The date is not a valid'
                                }
                            }
                        }
                        ,
                        payrate: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($holidayconfig, 'payrate')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'PAY RATE  is required'
                                }
                            }
                        },
                        description: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($holidayconfig, 'description')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'DESCRIPTION is required'
                                }
                            }
                        }
                    }
                }).on('success.form.fv', function (e) {
            // Save the form data via an Ajax request
            e.preventDefault();
            datagrid.addRow('holidayconfig', $(this).attr("method"), new FormData(this), "tablecontentholidayconfig");
            $('#holidayconfigconfigform').formValidation('resetForm', true);
        });
    });
</script>

