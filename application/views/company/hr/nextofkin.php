<?php
$nextofkinf = $controller->gettablecolumns('nextofkin');
//print_array($nextofkinf);
$nextofkinvalues = array();
?>
<div class="row" id="nextofkin_config">
    <div class="col-sm-12">
        <!-- start: TEXT FIELDS PANEL -->
        <!--<div class="panel panel-white">-->
        <div class="panel-heading">
            <h4 class="panel-title"> NEXT OF <span class="text-bold">KIN</span></h4>
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
            <form id="nextofkin_configform" role="form" method="post" class="form-horizontal" novalidate>
                <input type="hidden"  id="tablename" name="tablename"  class="form-control" value="nextofkin">
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($nextofkinf, 'name')['status']) ?>>
                        <label class="col-sm-2 control-label" for="form-field-1">
                            NAME
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder=" NAME" id="name" name="name" class="form-control"  value="<?= printvalues('name', $nextofkinvalues) ?>">
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($nextofkinf, 'organization')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            ORGANIZATION
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="ORGANIZATION" id="organization" name="organization" class="form-control"  value="<?= printvalues('organization', $nextofkinvalues) ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($nextofkinf, 'jobtitle')['status']) ?>>
                        <label class="col-sm-2 control-label" for="form-field-1">
                            JOB TITLE
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder=" JOB TITLE" id="jobtitle" name="jobtitle" class="form-control"  value="<?= printvalues('jobtitle', $nextofkinvalues) ?>">
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($nextofkinf, 'memo')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            MEMO
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="MEMO" id="memo" name="memo" class="form-control"  value="<?= printvalues('memo', $nextofkinvalues) ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($nextofkinf, 'relationship')['status']) ?>>
                        <label class="col-sm-2 control-label" for="form-field-1">
                            RELATIONSHIP
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder=" RELATIONSHIP" id="relationship" name="relationship" class="form-control"  value="<?= printvalues('relationship', $nextofkinvalues) ?>">
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($nextofkinf, 'profession')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            PROFESSION
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="PROFESSION" id="profession" name="profession" class="form-control"  value="<?= printvalues('profession', $nextofkinvalues) ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($nextofkinf, 'email')['status']) ?>>
                        <label class="col-sm-2 control-label" for="form-field-1">
                            EMAIL
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder=" EMAIL" id="email" name="email" class="form-control"  value="<?= printvalues('email', $nextofkinvalues) ?>">
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($nextofkinf, 'cellphone')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            CELL PHONE
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="CELLPHONE" id="cellphone" name="cellphone" class="form-control"  value="<?= printvalues('cellphone', $nextofkinvalues) ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($nextofkinf, 'postaladdress')['status']) ?>>
                        <label class="col-sm-2 control-label" for="form-field-1">
                            POSTAL ADDRESS
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="POSTAL ADDRESS" id="postaladdress" name="postaladdress" class="form-control"  value="<?= printvalues('postaladdress', $nextofkinvalues) ?>">
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($nextofkinf, 'physicaladdress')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            PHYSICAL ADDRESS
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="PHYSICAL ADDRESS" id="physicaladdress" name="physicaladdress" class="form-control"  value="<?= printvalues('physicaladdress', $nextofkinvalues) ?>">
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col-sm-4 pull-right">
                        <button class="btn btn-green btn-block" type="submit">
                            Add Next Of Kin&nbsp;<i class="fa fa-arrow-circle-right"></i>
                        </button>
                    </div>
                </div>
            </form>
            <div id="message"></div>
            <div id="wrap">
                <!-- Feedback message zone -->
           
                <!-- Grid contents -->
                <div id="tablecontentnextofkin"></div>
                <!-- Paginator control -->
                <div id="paginator"></div>
            </div>
        </div>
    </div>
</div>
<script>
    var addnextofkin = "<?php echo base_url("company/add"); ?>";
    $(document).ready(function() {
        datagrid = new DatabaseGrid('nextofkin', "tablecontentnextofkin");
        $("#filter").keyup(function() {
            datagrid.editableGrid.filter($(this).val());
            // To filter on some columns, you can set an array of column index 
            //datagrid.editableGrid.filter( $(this).val(), [0,3,5]);        
        });
        $('#nextofkin_configform')
                .formValidation({
                    framework: 'bootstrap',
                    icon: {
                    },
                    fields: {
                        jobgrade: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($nextofkinf, 'jobgrade')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Job Grade is required'
                                }
                            }
                        }
                        ,
                        description: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($nextofkinf, 'description')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Description  is required'
                                }
                            }
                        }
                        ,
                        minsalary: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($nextofkinf, 'minsalary')['mandatory']) ?>)),
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
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($nextofkinf, 'maxsalary')['mandatory']) ?>)),
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
                url: addnextofkin,
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