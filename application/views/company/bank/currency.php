<?php
$currenciesf = $controller->gettablecolumns('currencies');
$currenciesvalues = array();
?>
<div class="row" id="banksconfig">
    <div class="col-sm-12">
        <!-- start: TEXT FIELDS PANEL -->
        <!--<div class="panel panel-white">-->
        <div class="panel-heading">
            <h4 class="panel-title"> <span class="text-bold">CURRENCIES </span></h4>
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
            <form id="currenciesconfig_form" role="form" method="post" class="form-horizontal" novalidate>
                <input type="hidden"  id="tablename" name="tablename"  class="form-control" value="currencies">
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($currenciesf, 'currency')['status']) ?>>
                        <label class="col-sm-2 control-label" for="form-field-1">
                            CURRENCY
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="CURRENCY" id="currency" name="currency" class="form-control"  value="<?= printvalues('currency', $currenciesvalues) ?>">
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($currenciesf, 'exchangerate')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            EXCHANGE RATE
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="CODE" id="exchangerate" name="exchangerate" class="form-control"  value="<?= printvalues('exchangerate', $currenciesvalues) ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($currenciesf, 'description')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            DESCRIPTION
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="description " id="description" name="description"  class="form-control" value="<?= printvalues('description', $currenciesvalues) ?>">
                        </div>
                    </div>
                    <div class="col-sm-4 pull-right">
                        <button class="btn btn-green btn-block" type="submit">
                            Add&nbsp;<i class="fa fa-arrow-circle-right"></i>
                        </button>
                    </div>
                </div>
            </form>
            <br><br>
            <div id="message"></div>
            <div id="wrap">
                <!-- Feedback message zone -->
                <div id="toolbar">
                    <input type="text" id="filter" name="filter"
                           placeholder="Filter :type any text here" class="form-control" />
                </div>
                <!-- Grid contents -->
                <div id="tablecontentcurrencies"></div>
                <!-- Paginator control -->
                <div id="paginator"></div>
            </div>
        </div>
    </div>
</div>
<script>
    var addcurrencies = "<?php echo base_url("company/add"); ?>";
    $(document).ready(function() {
        datagrid = new DatabaseGrid('currencies', "tablecontentcurrencies");
        $("#filter").keyup(function() {
            datagrid.editableGrid.filter($(this).val());
            // To filter on some columns, you can set an array of column index 
            //datagrid.editableGrid.filter( $(this).val(), [0,3,5]);        
        });
        $('#currenciesconfig_form')
                .formValidation({
                    framework: 'bootstrap',
                    icon: {
                    },
                    fields: {
                        currency: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($currenciesf, 'currency')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Bank Name is required'
                                }
                            }
                        }
                        ,
                        exchangerate: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($currenciesf, 'exchangerate')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Bank Code  is required'
                                }
                            }
                        }
                        ,
                        description: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($currenciesf, 'description')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Description  is required'
                                }
                            }
                        }
                    }
                }).on('success.form.fv', function(e) {
            // Save the form data via an Ajax request
            e.preventDefault();
            $.ajax({
                url: addcurrencies,
                type: $(this).attr("method"),
                dataType: "json",
                data: new FormData(this),
                processData: false,
                contentType: false
            }).done(function(response) {
                datagrid.fetchGrid('currencies');
                $('#currenciesconfig_form').formValidation('resetForm', true);
                console.log(JSON.stringify(response));
            });
        });
    });
</script>
