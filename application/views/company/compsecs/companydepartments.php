<?php
$departmentsf = $controller->gettablecolumns('departments');
$departmentsvalues = array();
?>
<div class="row" id="company_departments">
    <div class="col-sm-12">
        <!-- start: TEXT FIELDS PANEL -->
        <!--<div class="panel panel-white">-->
        <div class="panel-heading">
            <h4 class="panel-title"> <span class="text-bold">DEPARTMENTS </span></h4>
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
            <form id="company_departments_form" role="form" method="post" class="form-horizontal" novalidate>
                <input type="hidden"  id="tablename" name="tablename"  class="form-control" value="departments">
                <div class="form-group" >
                    <div <?= hideorshow(array_keyvaluen($departmentsf, 'id_company')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            COMPANY
                        </label>
                        <div class="col-sm-4">
                            <select  class="form-control search-select" placeholder="Select Form" name="id_company" id="id_company"  >
                                <option value="">-SELECT COMPANY-</option>
                                <option selected="selected" value="<?= printvalues('id', $fieldsdata) ?>"><?= printvalues('name', $fieldsdata) ?></option>
                            </select>
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($departmentsf, 'department')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            DEPARTMENT NAME
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="DEPARTMENT" id="department" name="region" class="form-control"   value="<?= printvalues('department', $departmentsvalues) ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($departmentsf, 'telephone')['status']) ?>>
                        <label class="col-sm-2 control-label" for="form-field-1">
                            TELEPHONE
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="TELEPHONE" id="telephone" name="telephone" class="form-control"  value="<?= printvalues('telephone', $departmentsvalues) ?>">
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($departmentsf, 'email')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            EMAIL
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="EMAIL" id="email" name="email" class="form-control"  value="<?= printvalues('email', $departmentsvalues) ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($departmentsf, 'contactperson')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            CONTACT PERSON
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="CONTACT " id="contactperson" name="contactperson"  class="form-control" value="<?= printvalues('contactperson', $departmentsvalues) ?>">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <button class="btn btn-green btn-block" type="submit">
                            Add Department<i class="fa fa-arrow-circle-right"></i>
                        </button>
                    </div>
                </div>
            </form>
            <br><br>
            <div id="message"></div>
            <div id="wrap">
                <!-- Feedback message zone -->
                <div id="toolbar">
                    <input type="text" id="filter" name="filter"
                           placeholder="Filter :type any text here" class="form-control" />
                </div>
                <!-- Grid contents -->
                <div id="tablecontentdepartments"></div>
                <!-- Paginator control -->
                <div id="paginator"></div>
            </div>
        </div>
    </div>
</div>
<script>
    var addepartment = "<?php echo base_url("company/add"); ?>";
    $(document).ready(function() {
        datagrid = new DatabaseGrid('departments', "tablecontentdepartments");
        $("#filter").keyup(function() {
            datagrid.editableGrid.filter($(this).val());
            // To filter on some columns, you can set an array of column index 
            //datagrid.editableGrid.filter( $(this).val(), [0,3,5]);        
        });
        $('#company_departments_form')
                .formValidation({
                    framework: 'bootstrap',
                    icon: {
                    },
                    fields: {
                        id_company: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($departmentsf, 'id_company')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Company Name is required'
                                }
                            }
                        }
                        ,
                        email: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($departmentsf, 'email')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Email  is required'
                                },
                                emailAddress: {
                                    message: 'The email address is not valid'
                                }
                            }
                        }
                        ,
                        department: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($departmentsf, 'department')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Department Name  is required'
                                }
                            }
                        },
                        contactperson: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($departmentsf, 'contactperson')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Contact Person Required'
                                }
                            }
                        },
                        telephone: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($fields, 'telephone')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'The Telephone Number is required'
                                },
                                regexp: {
                                    regexp: /^[0-9,+]{13}$/,
                                    message: 'Enter Valid Contact Number format +254735973206'
                                }
                            }
                        }
                    }
                }).on('success.form.fv', function(e) {
            // Save the form data via an Ajax request
            e.preventDefault();
            $.ajax({
                url: addepartment,
                type: $(this).attr("method"),
                dataType: "json",
                data: new FormData(this),
                processData: false,
                contentType: false
            }).done(function(response) {
                datagrid.fetchGrid('departments');
                $('#company_departments_form').formValidation('resetForm', true);
                console.log(JSON.stringify(response));
            });
        });
    });
</script>
