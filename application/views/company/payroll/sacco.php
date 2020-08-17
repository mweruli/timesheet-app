<?php
$saccosf = $controller->gettablecolumns('saccos');
$saccosvalues = array();
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
<div class="row" id="saccosconfig">
    <div class="col-sm-12">
        <!-- start: TEXT FIELDS PANEL -->
        <!--<div class="panel panel-white">-->
        <div class="panel-heading">
            <h4 class="panel-title"> <span class="text-bold">SACCO</span></h4>
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
            <form id="saccosconfigform" role="form" method="post" class="form-horizontal" novalidate>
                <input type="hidden"  id="tablename" name="tablename"  class="form-control" value="saccos">
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($saccosf, 'sacco')['status']) ?>>
                        <label class="col-sm-2 control-label" for="form-field-1">
                            SACCO
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="SACCO" id="sacco" name="sacco" class="form-control"  value="<?= printvalues('sacco', $saccosvalues) ?>">
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($saccosf, 'code')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            CODE
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="CODE" id="code" name="code"  class="form-control" value="<?= printvalues('code', $saccosvalues) ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($saccosf, 'recurring')['status']) ?>>
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
                <div id="tablecontentsaccos"></div>
                <!-- Paginator control -->
                <div id="paginator"></div>
            </div>
        </div>
    </div>
</div>
<script>
    var addsaccos = "<?php echo base_url("company/add"); ?>";
    $(document).ready(function() {
        datagrid = new DatabaseGrid('saccos', "tablecontentsaccos");
        $("#filter").keyup(function() {
            datagrid.editableGrid.filter($(this).val());
        });
        $('#saccosconfigform')
                .formValidation({
                    framework: 'bootstrap',
                    icon: {
                    },
                    fields: {
                        sacco: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($saccosf, 'sacco')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'SACCO   is required'
                                }
                            }
                        },
                        code: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($saccosf, 'code')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'CODE  is required'
                                }
                            }
                        },
                        recurring: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($saccosf, 'recurring')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'RECURRING  is required'
                                }
                            }
                        }
                    }
                }).on('success.form.fv', function(e) {
            // Save the form data via an Ajax request
            e.preventDefault();
            $.ajax({
                url: addsaccos,
                type: $(this).attr("method"),
                dataType: "json",
                data: new FormData(this),
                processData: false,
                contentType: false
            }).done(function(response) {
                datagrid.fetchGrid('saccos');
                $('#saccosconfigform').formValidation('resetForm', true);
                console.log(JSON.stringify(response));
            });
        });
    });
</script>
