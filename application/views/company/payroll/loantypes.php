<?php
$loantypes = $controller->gettablecolumns('loantypes');
$loantypesvalues = array();
?>
<div class="row" id="loantypesconfig">
    <div class="col-sm-12">
        <!-- start: TEXT FIELDS PANEL -->
        <!--<div class="panel panel-white">-->
        <div class="panel-heading">
            <h4 class="panel-title">LOAN<span class="text-bold">TYPES</span></h4>
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
            <form id="loantypesconfigform" role="form" method="post" class="form-horizontal" novalidate>
                <input type="hidden"  id="tablename" name="tablename"  class="form-control" value="loantypes">
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($loantypes, 'loantype')['status']) ?>>
                        <label class="col-sm-2 control-label" for="form-field-1">
                            LOAN TYPE
                        </label>

                        <div class="col-sm-4">
                            <input type="text" placeholder="INTEREST METHOD" id="loantype" name="loantype"  class="form-control" value="<?= printvalues('interestmethod', $loantypesvalues) ?>">
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($loantypes, 'interestmethod')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            INTEREST METHOD
                        </label>
                        <div class="col-sm-4">
                            <select  class="form-control search-select" placeholder="Select Form" name="interestmethod" id="interestmethod"  >
                                <option value="">-INTEREST METHOD-</option>
                                <option value="reducing">Reducing</option>
                                <option value="simple">Simple</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($loantypes, 'ainterestrate')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            ANNUAL INTEREST  RATE
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="RATE" id="ainterestrate" name="ainterestrate" class="form-control"  value="<?= printvalues('ainterestrate', $loantypesvalues) ?>">
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($loantypes, 'description')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            DESCRIPTION
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="DESC" id="description" name="description"  class="form-control" value="<?= printvalues('description', $loantypesvalues) ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($loantypes, 'code')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            CODE
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="CODE" id="code" name="code"  class="form-control" value="<?= printvalues('code', $loantypesvalues) ?>">
                        </div>
                    </div>
                    <label class="col-sm-2 control-label">
                    </label>
                    <div class="col-sm-4">
                        <button class="btn btn-green btn-block" type="submit">
                            Add Loan Type&nbsp;<i class="fa fa-arrow-circle-right"></i>
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
                <div id="tablecontentloantype"></div>
                <!-- Paginator control -->
                <div id="paginator"></div>
            </div>
        </div>
    </div>
</div>
<script>
    var addpaye = "<?php echo base_url("company/add"); ?>";
    $(document).ready(function() {
        datagrid = new DatabaseGrid('loantypes', "tablecontentloantype");
        $("#filter").keyup(function() {
            datagrid.editableGrid.filter($(this).val());
        });
        $('#loantypesconfigform')
                .formValidation({
                    framework: 'bootstrap',
                    icon: {
                    },
                    fields: {
                        loantype: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($loantypes, 'loantype')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Loan Type   is required'
                                }
                            }
                        },
                        interestmethod: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($loantypes, 'interestmethod')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Intrest Method  is required'
                                }

                            }
                        },
                        ainterestrate: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($loantypes, 'ainterestrate')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'RATE  Required'
                                }
                            }
                        },
                        description: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($loantypes, 'description')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Description  Required'
                                }
                            }
                        }
                    }
                }).on('success.form.fv', function(e) {
            // Save the form data via an Ajax request
            e.preventDefault();
            $.ajax({
                url: addpaye,
                type: $(this).attr("method"),
                dataType: "json",
                data: new FormData(this),
                processData: false,
                contentType: false
            }).done(function(response) {
                datagrid.fetchGrid('loantypes');
                $('#loantypesconfigform').formValidation('resetForm', true);
                console.log(JSON.stringify(response));
            });
        });
    });
</script>
