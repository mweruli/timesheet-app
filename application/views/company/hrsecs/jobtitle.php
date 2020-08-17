<?php
$jobtitlesf = $controller->gettablecolumns('jobtitles');
$jobtitlesvalues = array();
?>
<div class="row" id="jobtitles_config">
    <div class="col-sm-12">
        <!-- start: TEXT FIELDS PANEL -->
        <!--<div class="panel panel-white">-->
        <div class="panel-heading">
            <h4 class="panel-title"> <span class="text-bold">JOB TITLE</span></h4>
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
            <form id="jobtitles_configform" role="form" method="post" class="form-horizontal" novalidate>
                <input type="hidden"  id="tablename" name="tablename"  class="form-control" value="jobtitles">
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($jobtitlesf, 'jobtitle')['status']) ?>>
                        <label class="col-sm-2 control-label" for="form-field-1">
                            JOB TITLE
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder=" TITLE" id="jobtitle" name="jobtitle" class="form-control"  value="<?= printvalues('jobtitle', $jobtitlesvalues) ?>">
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($jobtitlesf, 'description')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            DESCRIPTION
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="DESCRIPTION" id="description" name="description" class="form-control"  value="<?= printvalues('description', $jobtitlesvalues) ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($jobtitlesf, 'minsalary')['status']) ?>>
                        <label class="col-sm-2 control-label" for="form-field-1">
                            MIN SALARY
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder=" MINIMUM SALARY" id="status" name="minsalary" class="form-control"  value="<?= printvalues('minsalary', $jobtitlesvalues) ?>">
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($jobtitlesf, 'maxsalary')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            MAX SALARY
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="MAXIMUM SALARY" id="maxsalary" name="maxsalary" class="form-control"  value="<?= printvalues('maxsalary', $jobtitlesvalues) ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-4 pull-right">
                        <button class="btn btn-green btn-block" type="submit">
                            Add Job Title&nbsp;<i class="fa fa-arrow-circle-right"></i>
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
                <div id="tablecontentjobtitles"></div>
                <div id="paginator"></div>
            </div>
        </div>
    </div>
</div>
<script>
    var addjobtitles = "<?php echo base_url("company/add"); ?>";
    $(document).ready(function() {
        
        $('#jobtitles_configform')
                .formValidation({
                    framework: 'bootstrap',
                    icon: {
                    },
                    fields: {
                        jobtitle: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($jobtitlesf, 'jobtitle')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Job Grade is required'
                                }
                            }
                        }
                        ,
                        description: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($jobtitlesf, 'description')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Description  is required'
                                }
                            }
                        }
                        ,
                        minsalary: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($jobtitlesf, 'minsalary')['mandatory']) ?>)),
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
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($jobtitlesf, 'maxsalary')['mandatory']) ?>)),
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
                url: addjobtitles,
                type: $(this).attr("method"),
                dataType: "json",
                data: new FormData(this),
                processData: false,
                contentType: false
            }).done(function(response) {
                datagrid.fetchGrid("jobtitles");
                $('#jobtitles_configform').formValidation('resetForm', true);
                console.log(JSON.stringify(response));
            });
        });
    });
</script>