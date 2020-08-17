<?php
$nationalitiesf = $controller->gettablecolumns('nationalities');
$nationalitiesvalues = array();
?>
<div class="row" id="nationalities_config">
    <div class="col-sm-12">
        <div class="panel-heading">
            <h4 class="panel-title"> <span class="text-bold">NATIONALITIES</span></h4>
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
            <form id="nationalities_configform" role="form" method="post" class="form-horizontal" novalidate>
                <input type="hidden"  id="tablename" name="tablename"  class="form-control" value="nationalities">
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($nationalitiesf, 'nationality')['status']) ?>>
                        <label class="col-sm-2 control-label" for="form-field-1">
                            NATIONALITY 
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="NATIONALITY" id="nationality" name="nationality" class="form-control"  value="<?= printvalues('nationality', $nationalitiesvalues) ?>">
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($nationalitiesf, 'description')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            DESCRIPTION
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="DESCRIPTION" id="description" name="description" class="form-control"  value="<?= printvalues('description', $nationalitiesvalues) ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-4 pull-right">
                        <button class="btn btn-green btn-block" type="submit">
                            Add &nbsp;<i class="fa fa-arrow-circle-right"></i>
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
                <div id="tablecontentnationalities"></div>
                <!-- Paginator control -->
                <div id="paginator"></div>
            </div>
        </div>
    </div>
</div>
<script>
    var addnationalities = "<?php echo base_url("company/add"); ?>";
    $(document).ready(function() {
       
        $('#nationalities_configform')
                .formValidation({
                    framework: 'bootstrap',
                    icon: {
                    },
                    fields: {
                        nationality: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($nationalitiesf, 'nationality')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Nationality is required'
                                }
                            }
                        }
                        ,
                        description: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($nationalitiesf, 'description')['mandatory']) ?>)),
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
                url: addnationalities,
                type: $(this).attr("method"),
                dataType: "json",
                data: new FormData(this),
                processData: false,
                contentType: false
            }).done(function(response) {
                datagrid.fetchGrid("nationalities");
                $('#nationalities_configform').formValidation('resetForm', true);
                console.log(JSON.stringify(response));
            });
        });
    });
</script>