<?php
$jobgradesf = $controller->gettablecolumns('jobgrades');
//print_array($jobgradesf);
$jobgradesvalues = array();
?>
<div class="row" id="jobgrades_config">
    <div class="col-sm-12">
        <!-- start: TEXT FIELDS PANEL -->
        <!--<div class="panel panel-white">-->
        <div class="panel-heading">
            <h4 class="panel-title"> <span class="text-bold">JOB GRADES</span></h4>
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
            <form id="jobgrades_configform" role="form" method="post" class="form-horizontal" novalidate>
                <input type="hidden"  id="tablename" name="tablename"  class="form-control" value="jobgrades">
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($jobgradesf, 'jobgrade')['status']) ?>>
                        <label class="col-sm-2 control-label" for="form-field-1">
                            JOB GRADE
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder=" GRADE" id="jobgrade" name="jobgrade" class="form-control"  value="<?= printvalues('jobgrade', $jobgradesvalues) ?>">
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($jobgradesf, 'description')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            DESCRIPTION
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="DESCRIPTION" id="description" name="description" class="form-control"  value="<?= printvalues('description', $jobgradesvalues) ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($jobgradesf, 'minsalary')['status']) ?>>
                        <label class="col-sm-2 control-label" for="form-field-1">
                            MIN SALARY
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder=" MINIMUM SALARY" id="status" name="minsalary" class="form-control"  value="<?= printvalues('minsalary', $jobgradesvalues) ?>">
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($jobgradesf, 'maxsalary')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            MAX SALARY
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="MAXIMUM SALARY" id="maxsalary" name="maxsalary" class="form-control"  value="<?= printvalues('maxsalary', $jobgradesvalues) ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-4 pull-right">
                        <button class="btn btn-green btn-block" type="submit">
                            Add Job Grades&nbsp;<i class="fa fa-arrow-circle-right"></i>
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
                <div id="tablecontentjobgrades"></div>
                <!-- Paginator control -->
                <div id="paginator"></div>
            </div>
        </div>
    </div>
</div>
<script>
    var addjobgrades = "<?php echo base_url("company/add"); ?>";
    $(document).ready(function() {
        datagrid = new DatabaseGrid('jobgrades', "tablecontentjobgrades");
        $("#filter").keyup(function() {
            datagrid.editableGrid.filter($(this).val());
            // To filter on some columns, you can set an array of column index 
            //datagrid.editableGrid.filter( $(this).val(), [0,3,5]);        
        });
        $('#jobgrades_configform')
                .formValidation({
                    framework: 'bootstrap',
                    icon: {
                    },
                    fields: {
                        jobgrade: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($jobgradesf, 'jobgrade')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Job Grade is required'
                                }
                            }
                        }
                        ,
                        description: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($jobgradesf, 'description')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Description  is required'
                                }
                            }
                        }
                        ,
                        minsalary: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($jobgradesf, 'minsalary')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Min Pay  is required'
                                },
                                numeric: {
                                    message: 'Numbers are only numbers'
                                }
                            }
                        }
                        ,
                        maxsalary: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($jobgradesf, 'maxsalary')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Max Pay  is required'
                                },
                                numeric: {
                                    message: 'Numbers are only numbers'
                                }
                            }
                        }
                    }
                }).on('success.form.fv', function(e) {
            // Save the form data via an Ajax request
            e.preventDefault();
            $.ajax({
                url: addjobgrades,
                type: $(this).attr("method"),
                dataType: "json",
                data: new FormData(this),
                processData: false,
                contentType: false
            }).done(function(response) {
                datagrid.fetchGrid("employementstatus");
                $('#employementstatus_configform').formValidation('resetForm', true);
                console.log(JSON.stringify(response));
            });
        });
    });
</script>