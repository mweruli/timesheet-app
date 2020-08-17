<script src="https://cdn.jsdelivr.net/npm/formvalidation@0.6.2-dev/dist/js/formValidation.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/formvalidation@0.6.2-dev/dist/js/framework/bootstrap.min.js"></script>
<div class="row">
    <div class="col-sm-12">
        <!-- start: TEXT FIELDS PANEL -->
        <!--<div class="panel panel-white">-->
        <div class="panel-heading">
            <h4 class="panel-title">Add <span class="text-bold">Set Client Terms</span></h4>
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
            <form role="form"  id="addprojectclient" method="post" class="form-horizontal">
                <div class="form-group">
                    <label class="col-sm-2 control-label">
                        Select Client
                    </label>
                    <div class="col-sm-9">
                        <select id="client_project" class="form-control search-select" placeholder="Select Client" name="client_project">
                            <option value="">&nbsp;</option>
                            <!--                            <option value="AL">Client 1</option>
                                                        <option value="AK">Client 2</option>
                                                        <option value="AZ">Client 3</option>
                                                        <option value="AR">Client 4</option>-->
                            <?php
                            foreach ($all_clients as $value) {
                                ?>
                                <option value="<?= $value['id'] ?>"><?= $value['clientname'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">
                        Project Name
                    </label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="Project Name" id="project_name" name="project_name" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="form-field-1">
                        Mile Stones
                    </label>
                    <div class="col-sm-9">
                        <input type="text" name="tasks_of_project"   class="tag" id="tags_1">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">
                        Start Date
                    </label>
                    <div class="col-sm-4 date">
                        <div class="input-group input-append date" id="start_date_project">
                            <input type="text"  name="start_date_project" class="form-control">
                            <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </div>
                    <label class="col-sm-1 control-label">
                        End Date
                    </label>
                    <div class="col-sm-4 date">
                        <div class="input-group input-append date" id="end_date_project">
                            <input type="text"  class="form-control" name="end_date_project">
                            <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </div>
                </div>
                <br>
                <div class="form-group">
                    <div class="panel-body">
                        <p>
                            <button class="btn btn-yellow btn-block" type="submit">
                                Add Project&nbsp;<i class="fa fa-arrow-circle-right"></i>
                            </button>
                        </p>
                    </div>
                </div>
            </form>
        </div>
        <!--</div>-->
        <!-- end: TEXT FIELDS PANEL -->
    </div>
</div>
<script>
    var url_addproject = "<?php echo base_url("client/addproject"); ?>";
    $(document).ready(function () {
        $('#start_date_project')
                .datepicker({
                    format: 'dd-mm-yyyy'
                })
                .on('changeDate', function (e) {
                    // Revalidate the date field
                    $('#addprojectclient').formValidation('revalidateField', 'start_date_project');
                });
        $('#end_date_project')
                .datepicker({
                    format: 'dd-mm-yyyy'
                })
                .on('changeDate', function (e) {
                    // Revalidate the date field
                    $('#addprojectclient').formValidation('revalidateField', 'end_date_project');
                });
    });
    $('#addprojectclient')
            .formValidation({
                framework: 'bootstrap',
                icon: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    client_project: {
                        validators: {
                            notEmpty: {
                                message: 'Client is required'
                            }
                        }
                    },
                    project_name: {
                        validators: {
                            notEmpty: {
                                message: 'Project name is required'
                            },
                            regexp: {
                                regexp: /^[a-zA-Z\s]+$/,
                                message: 'Project name can only consist of alphabetical characters'
                            }
                        }
                    },
                    end_date_project: {
                        validators: {
                            notEmpty: {
                                message: 'End Date is required'
                            }
                            ,
                            date: {
                                format: 'DD-MM-YYYY',
                                message: 'The date is not a valid'
                            }
                        }
                    },
                    start_date_project: {
                        validators: {
                            notEmpty: {
                                message: 'Start Date is required'
                            },
                            date: {
                                format: 'DD-MM-YYYY',
                                message: 'The date is not a valid'
                            }
                        }
                    },
                    'tasks_of_project': {
                        validators: {
                            notEmpty: {
                                message: 'Task/Tasks are  required'
                            }
                        }
                    }
                }
            }).on('success.form.fv', function (e) {
        // Save the form data via an Ajax request
        e.preventDefault();
        // The url and method might be different in your application
        $.ajax({
            url: url_addproject,
            type: $(this).attr("method"),
            dataType: "JSON",
            data: new FormData(this),
            processData: false,
            contentType: false
//                url: url_addemployee,
//                method: 'post',
//                dataType: "JSON",
//                data: $form.serialize()
        }).done(function (response) {
            // alert(JSON.stringify(response));
            if (response.status === 1) {
//                    $.notify(response.report);
                $.notify(response.report, "error");
            } else {
                $('#addprojectclient').formValidation('resetForm', true);
                $.notify(response.report, "success");
                reloadmexx();
//                    $("#div_addclient").load(location.href + " #div_addclient");
//                    link_tab_addclient
                // var l = document.getElementById();
                // reloadTabs(2);
                // l.click(); 
            }

        });
    });
    function reloadmexx() {
        sessionStorage.setItem("reloadingxx", "true");
//        document.location.reload();
        window.setTimeout(function () {
            window.location.reload();
        }, 3000);
    }
    window.onload = function () {
        var reloadingxx = sessionStorage.getItem("reloadingxx");
        if (reloadingxx) {
            sessionStorage.removeItem("reloadingxx");
            myfuncxx();
        }
    }
    function myfuncxx() {
        var l = document.getElementById('link_tab_setprojectclient');
        l.click();
    }
</script>