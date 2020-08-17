<?php
$employementtypesf = $controller->gettablecolumns('employementtypes');
$employementvalues = array();
?>
<div class="row" id="employementtypes_config">
    <div class="col-sm-12">
        <!-- start: TEXT FIELDS PANEL -->
        <!--<div class="panel panel-white">-->
        <div class="panel-heading">
            <h4 class="panel-title"> <span class="text-bold">EMPLOYMENT TYPE</span></h4>
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
            <form id="employementtypes_configform" role="form" method="post" class="form-horizontal" novalidate>
                <input type="hidden"  id="tablename" name="tablename"  class="form-control" value="employementtypes">
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($employementtypesf, 'employementtype')['status']) ?>>
                        <label class="col-sm-2 control-label" for="form-field-1">
                            EMPLOYMENT TYPE
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder=" EMPLOYMENT TYPE" id="employementtype" name="employementtype" class="form-control"  value="<?= printvalues('employementtype', $employementvalues) ?>">
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($employementtypesf, 'description')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            DESCRIPTION
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="DESCRIPTION" id="description" name="description" class="form-control"  value="<?= printvalues('description', $employementvalues) ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-4 pull-right">
                        <button class="btn btn-green btn-block" type="submit">
                            Add Employment Type<i class="fa fa-arrow-circle-right"></i>
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
                <div id="tablecontentemployementtypes"></div>
                <!-- Paginator control -->
                <div id="paginator"></div>
            </div>
        </div>
    </div>
</div>
<script>
    var addemptype = "<?php echo base_url("company/add"); ?>";
    $(document).ready(function() {
        datagrid = new DatabaseGrid('employementtypes', "tablecontentemployementtypes");
        $("#filter").keyup(function() {
            datagrid.editableGrid.filter($(this).val());
            // To filter on some columns, you can set an array of column index 
            //datagrid.editableGrid.filter( $(this).val(), [0,3,5]);        
        });
        $('#employementtypes_configform')
                .formValidation({
                    framework: 'bootstrap',
                    icon: {
                    },
                    fields: {
                        employementtype: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employementtypesf, 'employementtype')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Employement Type is required'
                                }
                            }
                        }
                        ,
                        description: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employementtypesf, 'description')['mandatory']) ?>)),
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
                url: addemptype,
                type: $(this).attr("method"),
                dataType: "json",
                data: new FormData(this),
                processData: false,
                contentType: false
            }).done(function(response) {
                datagrid.fetchGrid("employementtypes");
                $('#employementtypes_configform').formValidation('resetForm', true);
                console.log(JSON.stringify(response));
            });
        });
    });
</script>