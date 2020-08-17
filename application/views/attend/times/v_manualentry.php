<!-- <script src="<?= base_url() ?>assets/js/editablejss/jquery.tabledit.js"></script> -->
<div class="row" id="add_manualentryui">
    <div class="col-sm-12">
        <!-- start: TEXT FIELDS PANEL -->
        <div class="panel-body">
            <form id="add_manualalues" method="post" class="form-horizontal" role="form">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="form-field-1"> Branch </label>
                    <div class="col-sm-9">

                        <select class="form-control search-select" placeholder="Select Employee" name="branch_start_manual" id="branch_start_manual" onChange="selectuserbranchmanual();">
                            <option selected="selected" value="">-SELECT BRANCH-</option>
                            <?php
                            if (!empty($allbranches)) {
                                ?>
                                <option value="<?= $allbranches[0]['readerserial'] . '$' . $allbranches[0]['names'] . '$' . $allbranches[0]['userpin'] ?>"><?= $allbranches[0]['branchname'] ?></option>
                            <?php
                                array_shift($allbranches);
                            }
                            foreach ($allbranches as $value) {
                                ?>
                                <option value="<?= $value['readerserial'] . '$' . $value['names'] . '$' . $value['userpin'] ?>"><?= $value['branchname'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="form-field-1"> Employee
                    </label>
                    <div class="col-sm-9">
                        <select id="dropdownemployeetoinput" name="dropdownemployeetoinput" class="form-control search-select" required>
                            <option value="">-SELECT EMPLOYEE-</option>
                            <!-- 					<option value="">--EMPLOYEE RANGE START --</option> -->
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"> Date </label>
                    <div class="col-sm-4 date">
                        <div class="input-group input-append date" id="dateformanual">
                            <input type="text" name="dateformanual" id="dateformanualval" class="form-control"> <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <button class="btn btn-red btn-block" type="submit">
                            Add Manual Entry&nbsp;<i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
            </form>
            <div id="toolbar">
                <input type="text" id="filtermanualentry" name="filtermanualentry" placeholder="Filter :type any text here" class="form-control" />
            </div>
            <div id="tablecontentallancesmanual">
            </div>
            <!-- Paginator control -->
            <div id="paginator"></div>
        </div>
        <!-- end: TEXT FIELDS PANEL -->
    </div>
</div>
<script>
    //Employee Afair
    function selectuserbranchmanual() {
        var e = document.getElementById("branch_start_manual");
        $('#dropdownemployeetoinput').find('option:not(:first)').remove();
        //To Extraxt

        var milearrays_on = new Array();
        var milearrays_on1 = new Array();
        var milearrays_on2 = new Array();
        var fields = new Array();
        var mile_stones = new Array();
        var strUser = "";
        strUser = e.options[e.selectedIndex].value;
        //alert(strUser);
        fields = strUser.split('$');
        mile_stones = fields[1];
        //      mile_stones1=fields[2];
        mile_stones2 = fields[2];
        milearrays_on = mile_stones.split('@');
        milearrays_on2 = mile_stones2.split('@');

        var $dropdown = $("#dropdownemployeetoinput");
        for (var i = 0; i < milearrays_on.length; i++) {
            $dropdown.append($("<option />").val(milearrays_on[i] + '|' + milearrays_on2[i]).text(milearrays_on[i] + ' ~pin~ ' + milearrays_on2[i]));
        }
    }
    var loadmanualentry = "<?php echo base_url("posts/loadmanualentry"); ?>";
    $(document).ready(function() {
        $('#dateformanual')
            .datepicker({
                format: 'yyyy-mm-dd'
            })
            .on('changeDate', function(e) {
                // Revalidate the date field
                $('#add_manualalues').formValidation('revalidateField', 'dateformanual');
            });
    });
    $('#add_manualalues')
        .formValidation({
            framework: 'bootstrap',
            icon: {
                //                     valid: 'glyphicon glyphicon-ok',
                //                     invalid: 'glyphicon glyphicon-remove',
                //                     validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                branch_start_manual: {
                    validators: {
                        notEmpty: {
                            message: 'Branch is required'
                        }
                    }
                },
                dropdownemployeetoinput: {
                    validators: {
                        notEmpty: {
                            message: 'Employee is required'
                        }
                    }
                },
                dateformanual: {
                    validators: {
                        notEmpty: {
                            message: 'Date for Manual is required'
                        },
                        date: {
                            format: 'YYYY-MM-DD',
                            message: 'The date is not a valid'
                        }
                    }
                }
            }
        }).on('success.form.fv', function(e) {
            e.preventDefault();
            $.ajax({
                url: loadmanualentry,
                type: $(this).attr("method"),
                dataType: "JSON",
                data: new FormData(this),
                processData: false,
                contentType: false
            }).done(function(response) {
                //            console.log(response);
                if (response.status === 1) {
                    $.notify(response.report, "error");
                } else {
                    datagrid = new DatabaseGrid('trans', "tablecontentallancesmanual");
                    $("#filter").keyup(function() {
                        datagrid.editableGrid.filter($(this).val());
                    });
                }
            });
        });
</script>