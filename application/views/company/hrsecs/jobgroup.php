<?php
$jobgroupsf = $controller->gettablecolumns('jobgroups');
$jobgroupsvalues = array();
?>
<div class="row" id="jobgroups_config">
    <div class="col-sm-12">
        <div class="panel-heading">
            <h4 class="panel-title"> <span class="text-bold">JOB GROUPS</span></h4>
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
            <form id="jobgroups_configform" role="form" method="post" class="form-horizontal" novalidate>
                <input type="hidden"  id="tablename" name="tablename"  class="form-control" value="jobgroups">
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($jobgroupsf, 'jobgroup')['status']) ?>>
                        <label class="col-sm-2 control-label" for="form-field-1">
                            JOB GROUP
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder=" JOB GROUP" id="jobgroup" name="jobgroup" class="form-control"  value="<?= printvalues('jobgroup', $jobgroupsvalues) ?>">
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($jobgroupsf, 'description')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            DESCRIPTION
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="DESCRIPTION" id="description" name="description" class="form-control"  value="<?= printvalues('description', $jobgroupsvalues) ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-4 pull-right">
                        <button class="btn btn-green btn-block" type="submit">
                            Add Job Group&nbsp;<i class="fa fa-arrow-circle-right"></i>
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
                <div id="tablecontentjobgroups"></div>
                <!-- Paginator control -->
                <div id="paginator"></div>
            </div>
        </div>
    </div>
</div>
<script>
    var addjobgroups = "<?php echo base_url("company/add"); ?>";
//    window.onload = setdatatable("jobgroups");
    $(document).ready(function () {
//        datagrid = new DatabaseGrid('jobgroups', "tablecontentjobgroups");
//        $("#filter").keyup(function () {
//            datagrid.editableGrid.filter($(this).val());
//            // To filter on some columns, you can set an array of column index 
//            //datagrid.editableGrid.filter( $(this).val(), [0,3,5]);        
//        });
        $('#jobgroups_configform')
                .formValidation({
                    framework: 'bootstrap',
                    icon: {
                    },
                    fields: {
                        jobgroup: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($jobgroupsf, 'jobgroup')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Job Group is required'
                                }
                            }
                        }
                        ,
                        description: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($jobgroupsf, 'description')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Description  is required'
                                }
                            }
                        }
                    }
                }).on('success.form.fv', function (e) {
            // Save the form data via an Ajax request
            e.preventDefault();
            $.ajax({
                url: addjobgroups,
                type: $(this).attr("method"),
                dataType: "json",
                data: new FormData(this),
                processData: false,
                contentType: false
            }).done(function (response) {
                datagrid.fetchGrid("jobgroups");
                $('#jobgroups_configform').formValidation('resetForm', true);
                console.log(JSON.stringify(response));
            });
        });
    });
</script>