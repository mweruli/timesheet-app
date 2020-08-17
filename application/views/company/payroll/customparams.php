<?php
$customparamsf = $controller->gettablecolumns('customparams');
$customparamsvalues = array();
?>
<div class="row" id="customparamsconfig">
    <div class="col-sm-12">
        <!-- start: TEXT FIELDS PANEL -->
        <!--<div class="panel panel-white">-->
        <div class="panel-heading">
            <h4 class="panel-title"> CUSTOME <span class="text-bold">PARAMETER</span></h4>
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
            <form id="customparamsforms" role="form" method="post" class="form-horizontal" novalidate>
                <input type="hidden"  id="tablename" name="tablename"  class="form-control" value="customparams">
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($customparamsf, 'description')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            Description
                        </label>
                        <div class="col-sm-4">
                            <input type="text"  id="description" name="description"  class="form-control" value="<?= printvalues('description', $customparamsvalues) ?>">
                        </div>
                        <!--Trump-->
                    </div>
                    <div <?= hideorshow(array_keyvaluen($customparamsf, 'descriptionpayslip')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            Payslip Description
                        </label>
                        <div class="col-sm-4">
                            <textarea type="text" cols="4" rows="3" id="descriptionpayslip" name="descriptionpayslip"  class="form-control" value=""><?= printvalues('descriptionpayslip', $customparamsvalues) ?></textarea>
                        </div>
                        <!--Trump-->
                    </div>
                </div>
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($customparamsf, 'signnote')['status']) ?>>
                        <label class="col-sm-2 control-label" for="form-field-1">
                            Sign
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="+/-" id="signnote" name="signnote" class="form-control"  value="<?= printvalues('signnote', $customparamsvalues) ?>">
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($customparamsf, 'code')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            CODE
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="CODE" id="code" name="code"  class="form-control" value="<?= printvalues('code', $customparamsvalues) ?>">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">
                        Monthly Recurring
                    </label>
                    <div class="col-sm-2">
                        <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-default btn-on ">
                                <input type="radio" value="1" name="rmonthly" >YES</label>
                            <label class="btn btn-default btn-off active" checked="checked">
                                <input type="radio" value="0" name="rmonthly" >NO</label>
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($customparamsf, 'lbonus')['status']) ?>>
                        <label class="col-sm-1 control-label">
                            L Bonus
                        </label>
                        <div class="col-sm-2">
                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-default btn-on ">
                                    <input type="radio" value="1" name="lbonus" >YES</label>
                                <label class="btn btn-default btn-off active" checked="checked">
                                    <input type="radio" value="0" name="lbonus" >NO</label>
                            </div>
                        </div>
                        <label class="col-sm-1 control-label">
                            Arrears
                        </label>
                        <div class="col-sm-2">
                            <div class="btn-group" id="arrears" data-toggle="buttons">
                                <label class="btn btn-default btn-on ">
                                    <input type="radio" value="1" name="arrears" >YES</label>
                                <label class="btn btn-default btn-off active" checked="checked">
                                    <input type="radio" value="0" name="arrears" >NO</label>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">
                        Taxable
                    </label>
                    <div class="col-sm-2">
                        <div class="btn-group"  data-toggle="buttons">
                            <label class="btn btn-default btn-on ">
                                <input type="radio" value="1" name="taxable" >YES</label>
                            <label class="btn btn-default btn-off active" checked="checked">
                                <input type="radio" value="0" name="taxable" >NO</label>
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
                    <input type="text" id="filter" name="filter"
                           placeholder="Filter :type any text here" class="form-control" />
                </div>
                <!-- Grid contents -->
                <div id="tablecontentcustoms"></div>
                <!-- Paginator control -->
                <div id="paginator"></div>
            </div>
        </div>
    </div>
</div>
<script>
    var addsaccoscustoms = "<?php echo base_url("company/add"); ?>";
    $(document).ready(function () {
        datagrid = new DatabaseGrid('customparams', "tablecontentcustoms");
        $("#filter").keyup(function () {
            datagrid.editableGrid.filter($(this).val());
        });
        $('#customparamsforms')
                .formValidation({
                    framework: 'bootstrap',
                    icon: {
                    },
                    fields: {
                        signnote: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($customparamsf, 'signnote')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Sign is required'
                                }
                            }
                        },
                        code: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($customparamsf, 'code')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'CODE  is required'
                                }
                            }
                        }
                        ,
                        description: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($customparamsf, 'description')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Description  is required'
                                }
                            }
                        }
                        ,
                        descriptionpayslip: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($customparamsf, 'descriptionpayslip')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Payslip Description is required'
                                }
                            }
                        }
                    }
                }).on('success.form.fv', function (e) {
            // Save the form data via an Ajax request
            e.preventDefault();
            $.ajax({
                url: addsaccoscustoms,
                type: $(this).attr("method"),
                dataType: "json",
                data: new FormData(this),
                processData: false,
                contentType: false
            }).done(function (response) {
                datagrid.fetchGrid('customparams');
                $('#customparamsforms').formValidation('resetForm', true);
//                console.log(JSON.stringify(response));
            });
        });
    });
</script>

