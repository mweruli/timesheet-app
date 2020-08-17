<?php
$salutationsf = $controller->gettablecolumns('salutations');
$salutationsvalues = array();
?>
<div class="row" id="salutations_config">
    <div class="col-sm-12">
        <!-- start: TEXT FIELDS PANEL -->
        <!--<div class="panel panel-white">-->
        <div class="panel-heading">
            <h4 class="panel-title"> <span class="text-bold">SALUTATIONS</span></h4>
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
            <form id="salutations_config_form" role="form" method="post" class="form-horizontal" novalidate>
                <input type="hidden"  id="tablename" name="tablename"  class="form-control" value="salutations">
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($salutationsf, 'salutation')['status']) ?>>
                        <label class="col-sm-2 control-label" for="form-field-1">
                            SALUTATION
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="SALUTATION" id="salutation" name="salutation" class="form-control"  value="<?= printvalues('salutation', $salutationsvalues) ?>">
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($salutationsf, 'description')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            DESCRIPTION
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="DESCRIPTION" id="description" name="description" class="form-control"  value="<?= printvalues('description', $salutationsvalues) ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-4 pull-right">
                        <button class="btn btn-green btn-block" type="submit">
                            Add Salutation<i class="fa fa-arrow-circle-right"></i>
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
                <div id="tablecontentsalutations"></div>
                <!-- Paginator control -->
                <div id="paginator"></div>
            </div>
        </div>
    </div>
</div>
<script>
    var addsalutations = "<?php echo base_url("company/add"); ?>";
    $(document).ready(function() {
        
        $('#salutations_config_form')
                .formValidation({
                    framework: 'bootstrap',
                    icon: {
                    },
                    fields: {
                        salutation: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($salutationsf, 'salutation')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Salutation  is required'
                                }
                            }
                        }
                        ,
                        description: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($salutationsf, 'description')['mandatory']) ?>)),
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
                url: addsalutations,
                type: $(this).attr("method"),
                dataType: "json",
                data: new FormData(this),
                processData: false,
                contentType: false
            }).done(function(response) {
                datagrid.fetchGrid("salutations");
                console.log(JSON.stringify(response));
            });
        });
    });
</script>