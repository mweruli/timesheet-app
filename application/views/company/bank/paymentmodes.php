<?php
$paymentmodesf = $controller->gettablecolumns('paymentmodes');
$paymentmodesvalues = array();
?>
<div class="row" id="paymentmodesconfig">
    <div class="col-sm-12">
        <!-- start: TEXT FIELDS PANEL -->
        <!--<div class="panel panel-white">-->
        <div class="panel-heading">
            <h4 class="panel-title">PAYMENT <span class="text-bold">MODES </span></h4>
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
            <form id="paymentmodesconfigform" role="form" method="post" class="form-horizontal" novalidate>
                <input type="hidden"  id="tablename" name="tablename"  class="form-control" value="paymentmodes">
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($paymentmodesf, 'paymentmode')['status']) ?>>
                        <label class="col-sm-2 control-label" for="form-field-1">
                            PAYMENT MODE
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="PAYMENT MODE" id="paymentmode" name="paymentmode" class="form-control"  value="<?= printvalues('paymentmode', $paymentmodesvalues) ?>">
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($paymentmodesf, 'description')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            DESCRIPTION
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="description " id="description" name="description"  class="form-control" value="<?= printvalues('description', $paymentmodesvalues) ?>">
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
                <div id="tablecontentpaymentmodes"></div>
                <!-- Paginator control -->
                <div id="paginator"></div>
            </div>
        </div>
    </div>
</div>
<script>
    var addpaymentmode = "<?php echo base_url("company/add"); ?>";
    $(document).ready(function() {
        datagrid = new DatabaseGrid('paymentmodes', "tablecontentpaymentmodes");
        $("#filter").keyup(function() {
            datagrid.editableGrid.filter($(this).val());
            // To filter on some columns, you can set an array of column index 
            //datagrid.editableGrid.filter( $(this).val(), [0,3,5]);        
        });
        $('#paymentmodesconfigform')
                .formValidation({
                    framework: 'bootstrap',
                    icon: {
                    },
                    fields: {
                        paymentmode: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($paymentmodesf, 'paymentmode')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'is required'
                                }
                            }
                        }
                        ,
                        description: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($paymentmodesf, 'description')['mandatory']) ?>)),
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
                url: addpaymentmode,
                type: $(this).attr("method"),
                dataType: "json",
                data: new FormData(this),
                processData: false,
                contentType: false
            }).done(function(response) {
                datagrid.fetchGrid('paymentmodes');
                $('#paymentmodesconfigform').formValidation('resetForm', true);
                console.log(JSON.stringify(response));
            });
        });
    });
</script>
