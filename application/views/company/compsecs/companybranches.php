<?php
$branchf = $controller->gettablecolumns('branches');
//print_array($branchf);
$branchvalues = array();
?>
<div class="row" id="company_branches">
    <div class="col-sm-12">
        <!-- start: TEXT FIELDS PANEL -->
        <!--<div class="panel panel-white">-->
        <div class="panel-heading">
            <h4 class="panel-title"> <span class="text-bold">BRANCHES</span></h4>
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
            <form id="company_branches_form" role="form" method="post" class="form-horizontal" novalidate>
                <input type="hidden"  id="tablename" name="tablename"  class="form-control" value="branches">
                <div class="form-group" >
                    <div <?= hideorshow(array_keyvaluen($branchf, 'id_company')['status']) ?>>
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
                    <div <?= hideorshow(array_keyvaluen($branchf, 'branch')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            BRANCH
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="Branch" id="branch" name="branch" class="form-control"   value="<?= printvalues('branch', $branchvalues) ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($branchf, 'telephone')['status']) ?>>
                        <label class="col-sm-2 control-label" for="form-field-1">
                            TELEPHONE
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="TELEPHONE" id="telephone" name="telephone" class="form-control"  value="<?= printvalues('telephone', $branchvalues) ?>">
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($branchf, 'email')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            EMAIL
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="BRANCH Email" id="email" name="email" class="form-control"  value="<?= printvalues('email', $branchvalues) ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($branchf, 'contactperson')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            CONTACT PERSON
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="CONTACT Person" id="contactperson" name="contactperson"  class="form-control" value="<?= printvalues('contactperson', $branchvalues) ?>">
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($branchf, 'readerserial')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            COMPANY READER
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="AIOR181260486" id="readerserial" name="readerserial"  class="form-control" value="<?= printvalues('readerserial', $branchvalues) ?>">
                        </div>
                    </div>

                </div>
                <div class="form-group">
                    <div class="col-sm-4 pull-right">
                        <button class="btn btn-green btn-block" type="submit">
                            Add Branch<i class="fa fa-arrow-circle-right"></i>
                        </button>
                    </div>
                </div>
            </form>
            <br><br>
            <div id="wrap" >
                <!-- Feedback message zone -->
                <div id="toolbar" >
                    <input type="text" id="filtercompanybranch" name="filtercompanybranch"
                           placeholder="Filter :type any text here" class="form-control col-sm-6"/>
                </div>
                <br><br>
                <!-- Grid contents -->
                <div id="tablecontent"></div>
                <div id="paginator"></div>
            </div>
        </div>
    </div>
</div>
<script>
    var datagrid;
    window.onload = function() {
        datagrid = new DatabaseGrid('branches', "tablecontent");
        // key typed in the filter field
        $("#filtercompanybranch").keyup(function() {
            datagrid.editableGrid.filter($(this).val());
//            console.log($(this).val());
            // To filter on some columns, you can set an array of column index 
            //datagrid.editableGrid.filter( $(this).val(), [0,3,5]);
        });
    };
    $(document).ready(function() {
        $('#company_branches_form')
                .formValidation({
                    framework: 'bootstrap',
                    icon: {
                    },
                    fields: {
                        id_company: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($branchf, 'id_company')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Company Name is required'
                                }
                            }
                        }
                        ,
                        email: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($branchf, 'email')['mandatory']) ?>)),
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
                        branch: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($branchf, 'branch')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Branch Name  is required'
                                }
                            }
                        },
                        readerserial: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($branchf, 'readerserial')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Reader Serial Number  is required'
                                }
                            }
                        },
                        contactperson: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($branchf, 'contactperson')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Contact Person Required'
                                }
                            }
                        },
                        telephone: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($branchf, 'telephone')['mandatory']) ?>)),
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
            datagrid.addRow('branches', $(this).attr("method"), new FormData(this), "tablecontent");
            $('#company_branches_form').formValidation('resetForm', true);
        });
    });
</script>