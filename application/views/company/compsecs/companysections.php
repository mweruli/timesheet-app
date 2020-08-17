<?php
$sectionsf = $controller->gettablecolumns('sections');
$sectionvalues = array();
?>
<div class="row" id="company_sections">
    <div class="col-sm-12">
        <!-- start: TEXT FIELDS PANEL -->
        <!--<div class="panel panel-white">-->
        <div class="panel-heading">
            <h4 class="panel-title"> <span class="text-bold">SECTIONS</span></h4>
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
            <form id="company_sections_form" role="form" method="post" class="form-horizontal" novalidate>
                <input type="hidden"  id="tablename" name="tablename"  class="form-control" value="sections">
                <div class="form-group" >
                    <div <?= hideorshow(array_keyvaluen($sectionsf, 'id_company')['status']) ?>>
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
                    <div <?= hideorshow(array_keyvaluen($sectionsf, 'id_department')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            DEPARTMENT
                        </label>
                        <div class="col-sm-4">
                            <select  class="form-control search-select" placeholder="Select Form" name="id_department" id="id_department"  >
                                <option value="">-SELECT DEPARTMENT-</option>
                                <?php
                                foreach ($departments as $department) {
                                    ?>
                                    <option value="<?= $department['id'] ?>"><?= $department['department'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($sectionsf, 'telephone')['status']) ?>>
                        <label class="col-sm-2 control-label" for="form-field-1">
                            TELEPHONE
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="TELEPHONE" id="telephone" name="telephone" class="form-control"  value="<?= printvalues('telephone', $sectionvalues) ?>">
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($sectionsf, 'section')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            SECTION
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="SECTION NAME" id="section" name="section"  class="form-control" value="<?= printvalues('section', $sectionvalues) ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($sectionsf, 'email')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            EMAIL
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="EMAIL" id="email" name="email" class="form-control"  value="<?= printvalues('email', $sectionvalues) ?>">
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($sectionsf, 'contactperson')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            CONTACT PERSON
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="CONTACT Person" id="contactperson" name="contactperson"  class="form-control" value="<?= printvalues('contactperson', $sectionvalues) ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-4 pull-right">
                        <button class="btn btn-green btn-block" type="submit">
                            Add Section<i class="fa fa-arrow-circle-right"></i>
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
                <div id="tablecontentsections"></div>
                <div id="paginator"></div>
            </div>
        </div>
    </div>
</div>
<script>
    var addsection = "<?php echo base_url("company/add"); ?>";
    $(document).ready(function() {
        datagrid = new DatabaseGrid('sections', "tablecontentsections");
        $("#filter").keyup(function() {
            datagrid.editableGrid.filter($(this).val());
        });
        $('#company_sections_form')
                .formValidation({
                    framework: 'bootstrap',
                    icon: {
                    },
                    fields: {
                        id_company: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($sectionsf, 'id_company')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Company Name is required'
                                }
                            }
                        }
                        ,
                        email: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($sectionsf, 'email')['mandatory']) ?>)),
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
                        section: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($sectionsf, 'section')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Section Name   is required'
                                }
                            }
                        }
                        ,
                        id_department: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($sectionsf, 'id_department')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Region Name  is required'
                                }
                            }
                        },
                        contactperson: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($sectionsf, 'contactperson')['mandatory']) ?>)),
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
                url: addsection,
                type: $(this).attr("method"),
                dataType: "json",
                data: new FormData(this),
                processData: false,
                contentType: false
            }).done(function(response) {
                datagrid.fetchGrid('sections');
                $('#company_sections_form').formValidation('resetForm', true);
                console.log(JSON.stringify(response));
            });
        });
    });
</script>
