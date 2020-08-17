<?php
$bankbranchesf = $controller->gettablecolumns('bankbranches');
$bankbranchesvalues = array();
?>
<div class="row" id="bankbranchesconfig">
    <div class="col-sm-12">
        <div class="panel-heading">
            <h4 class="panel-title">BANK<span class="text-bold">BRANCHES</span></h4>
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
            <form id="bankbranchesconfig_form" role="form" method="post" class="form-horizontal" novalidate>
                <input type="hidden"  id="tablename" name="tablename"  class="form-control" value="bankbranches">
                <div class="form-group" >
                    <div <?= hideorshow(array_keyvaluen($bankbranchesf, 'id_bank')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            BANK
                        </label>
                        <div class="col-sm-4">
                            <select  class="form-control search-select" placeholder="Select Form" name="id_bank" id="id_bank"  >
                                <option value="">-SELECT BANK-</option>
                                <?php
                                foreach ($banksid as $banks) {
                                    ?>
                                    <option  value="<?= $banks['id'] ?>"><?= $banks['bank'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($bankbranchesf, 'bankbranch')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            BRANCH
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="Branch" id="bankbranch" name="bankbranch" class="form-control"   value="<?= printvalues('bankbranch', $bankbranchesvalues) ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($bankbranchesf, 'code')['status']) ?>>
                        <label class="col-sm-2 control-label" for="form-field-1">
                            CODE
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="CODE" id="code" name="code" class="form-control"  value="<?= printvalues('code', $bankbranchesvalues) ?>">
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($bankbranchesf, 'description')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            DESCRIPTION
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="DESCRIPTION" id="description" name="description" class="form-control"  value="<?= printvalues('description', $bankbranchesvalues) ?>">
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
                <div id="tablecontent"></div>
                <!-- Paginator control -->
                <div id="paginator"></div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('viewjs/branch', TRUE);
?>
<script>
    var addbankbranches = "<?php echo base_url("company/add"); ?>";
    $(document).ready(function () {
        datagrid = new DatabaseGrid('bankbranches', "tablecontent");
        $("#filter").keyup(function () {
            datagrid.editableGrid.filter($(this).val());
            // To filter on some columns, you can set an array of column index 
            //datagrid.editableGrid.filter( $(this).val(), [0,3,5]);        
        });
        $('#bankbranchesconfig_form')
                .formValidation({
                    framework: 'bootstrap',
                    icon: {
                    },
                    fields: {
                        id_bank: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($bankbranchesf, 'id_bank')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Bank Name is required'
                                }
                            }
                        }
                        ,
                        description: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($bankbranchesf, 'description')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Description  is required'
                                }
                            }
                        }
                        ,
                        bankbranch: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($bankbranchesf, 'bankbranch')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Branch Name  is required'
                                }
                            }
                        },
                        code: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($bankbranchesf, 'code')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Branch Code is required'
                                }
                            }
                        }
                    }
                }).on('success.form.fv', function (e) {
            // Save the form data via an Ajax request
            e.preventDefault();
            $.ajax({
                url: addbankbranches,
                type: $(this).attr("method"),
                dataType: "json",
                data: new FormData(this),
                processData: false,
                contentType: false
            }).done(function (response) {
                datagrid.fetchGrid("bankbranches");
                $('#bankbranchesconfig_form').formValidation('resetForm', true);
                //                console.log(JSON.stringify(response));
            });
        });
    });
</script>