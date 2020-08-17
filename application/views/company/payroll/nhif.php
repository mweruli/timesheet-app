<?php
$nhiff = $controller->gettablecolumns('nhif');
$nhifvalues = array();
?>
<div class="row" id="nhifconfig">
    <div class="col-sm-12">
        <!-- start: TEXT FIELDS PANEL -->
        <!--<div class="panel panel-white">-->
        <div class="panel-heading">
            <h4 class="panel-title"> <span class="text-bold">NHIF</span></h4>
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
            <form id="nhifconfigform" role="form" method="post" class="form-horizontal" novalidate>
                <input type="hidden"  id="tablename" name="tablename"  class="form-control" value="nhif">
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($nhiff, 'fromnumber')['status']) ?>>
                        <label class="col-sm-2 control-label" for="form-field-1">
                            FROM
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="FROM" id="fromnumber" name="fromnumber" class="form-control"  value="<?= printvalues('fromnumber', $nhifvalues) ?>">
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($nhiff, 'tonumber')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            TO
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="TO" id="tonumber" name="tonumber"  class="form-control" value="<?= printvalues('tonumber', $nhifvalues) ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($nhiff, 'rate')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            RATE
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="RATE" id="rate" name="rate" class="form-control"  value="<?= printvalues('rate', $nhifvalues) ?>">
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($nhiff, 'amount')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            AMOUNT
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="AMOUNT" id="contactperson" name="amount"  class="form-control" value="<?= printvalues('amount', $nhifvalues) ?>">
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
                    <input type="text" id="filter" name="filter"
                           placeholder="Filter :type any text here" class="form-control" />
                </div>
                <!-- Grid contents -->
                <div id="tablecontentnhif"></div>
                <!-- Paginator control -->
                <div id="paginator"></div>
            </div>
        </div>
    </div>
</div>
<script>
    var addnhif = "<?php echo base_url("company/add"); ?>";
    $(document).ready(function() {
        datagrid = new DatabaseGrid('nhif', "tablecontentnhif");
        $("#filter").keyup(function() {
            datagrid.editableGrid.filter($(this).val());
        });
        $('#nhifconfigform')
                .formValidation({
                    framework: 'bootstrap',
                    icon: {
                    },
                    fields: {
                        fromnumber: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($nhiff, 'fromnumber')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'FROM   is required'
                                },
                                numeric: {
                                    message: 'Numbers are only numbers'
                                }
                            }
                        },
                        tonumber: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($nhiff, 'tonumber')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'TO  is required'
                                },
                                numeric: {
                                    message: 'TO is only numbers'
                                }
                            }
                        },
                        rate: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($nhiff, 'rate')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'RATE  Required'
                                }
                            }
                        },
                        amount: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($nhiff, 'amount')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'AMOUNT  Required'
                                },
                                numeric: {
                                    message: 'Numbers are only numbers'
                                },
                            }
                        }
                    }
                }).on('success.form.fv', function(e) {
            // Save the form data via an Ajax request
            e.preventDefault();
            $.ajax({
                url: addnhif,
                type: $(this).attr("method"),
                dataType: "json",
                data: new FormData(this),
                processData: false,
                contentType: false
            }).done(function(response) {
                datagrid.fetchGrid('nhif');
                $('#nhifconfigform').formValidation('resetForm', true);
                console.log(JSON.stringify(response));
            });
        });
    });
</script>
