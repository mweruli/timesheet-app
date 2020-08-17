<?php
$employee = $controller->gettablecolumns('users');
$employeevalues = array();
?>
<div class="row" id="employeeconfig">
    <div class="col-sm-12">
        <!-- start: TEXT FIELDS PANEL -->
        <!--<div class="panel panel-white">-->
        <div class="panel-heading">
            <h4 class="panel-title"> NEW<span class="text-bold"> EMPLOYEE</span></h4>
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
            <form id="employeeconfigform" role="form" method="post" class="form-horizontal" novalidate>
                <input type="hidden"  id="tablename" name="tablename"  class="form-control" value="users">
                <div class="form-group" >
                    <div <?= hideorshow(array_keyvaluen($employee, 'staffno')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            Staff No
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="Staff Number" id="staffno" name="staffno" class="form-control"   value="<?= printvalues('staffno', $employeevalues) ?>">
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($employee, 'employmenttype_id')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            Employment Type
                        </label>
                        <div class="col-sm-4">
                            <select  class="form-control search-select" placeholder="Select Form" name="employmenttype_id" id="employmenttype_id"  >
                                <option value="">-SELECT Employment Type-</option>
                                <?php
                                foreach ($employementtypes as $emptyp) {
                                    ?>
                                    <option  value="<?= $emptyp['id'] ?>"><?= $emptyp['employementtype'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($employee, 'company_id')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            COMPANY
                        </label>
                        <div class="col-sm-4">
                            <select  class="form-control search-select" placeholder="Select Form" name="company_id" id="company_id" onChange="checkselectedclient();" >
                                <option value="">-SELECT COMPANY-</option>
                                <?php
                                foreach ($controller->allselectablebytable('company') as $company) {
                                    ?>
                                    <option value="<?= $company['id'] ?>"><?= $company['name'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($employee, 'branch_id')['status']) ?>>
                        <label class="col-sm-2 control-label" for="form-field-1">
                            Company Branch
                        </label>
                        <div class="col-sm-4">
                            <select  class="form-control search-select" placeholder="Select Form" name="branch_id" id="branch_id"  >
                                <option value="">-SELECT Company Branch-</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($employee, 'jobtitle_id')['status']) ?>>
                        <label class="col-sm-2 control-label" for="form-field-1">
                            Job Title
                        </label>
                        <div class="col-sm-4">
                            <select  class="form-control search-select" placeholder="Select Form" name="jobtitle_id" id="jobtitle_id"  >
                                <option value="">-SELECT JOB TITLE-</option>
                                <?php
                                foreach ($jobtitle as $titlejob) {
                                    ?>
                                    <option value="<?= $titlejob['id'] ?>"><?= $titlejob['jobtitle'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($employee, 'firstname')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            First Name
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="firstname" id="firstname" name="firstname" class="form-control"  value="<?= printvalues('firstname', $employeevalues) ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($employee, 'middlename')['status']) ?>>
                        <label class="col-sm-2 control-label" for="form-field-1">
                            Middle Name
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="Middle Name" id="middlename" name="middlename" class="form-control"  value="<?= printvalues('middlename', $employeevalues) ?>">
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($employee, 'lastname')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            Last Name
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="Last Name" id="lastname" name="lastname" class="form-control"  value="<?= printvalues('lastname', $employeevalues) ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($employee, 'idnumber')['status']) ?>>
                        <label class="col-sm-2 control-label" for="form-field-1">
                            Id Number
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="Id Number" id="idnumber" name="idnumber" class="form-control"  value="<?= printvalues('idnumber', $employeevalues) ?>">
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($employee, 'nhifnumber')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            NHIF No.
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="  NHIF No." id="nhifnumber" name="nhifnumber" class="form-control"  value="<?= printvalues('nhifnumber', $employeevalues) ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($employee, 'nssfnumber')['status']) ?>>
                        <label class="col-sm-2 control-label" for="form-field-1">
                            NSSF No
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="NSSF No" id="nssfnumber" name="nssfnumber" class="form-control"  value="<?= printvalues('nssfnumber', $employeevalues) ?>">
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($employee, 'id_gender')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            Gender
                        </label>
                        <div class="col-sm-4">
                            <select  class="form-control search-select" placeholder="Select Form" name="id_gender" id="id_gender"  >
                                <option value="">-SELECT GENDER-</option>
                                <?php
                                foreach ($controller->allselectablebytable('genders') as $id_gender) {
                                    ?>
                                    <option value="<?= $id_gender['id'] ?>"><?= $id_gender['gender'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($employee, 'id_gender')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            Marital Status
                        </label>
                        <div class="col-sm-4">
                            <select  class="form-control search-select" placeholder="Select Form" name="maritalstatus_id" id="maritalstatus_id"  >
                                <option value="">-SELECT Marital Status-</option>
                                <?php
                                foreach ($controller->allselectablebytable('maritalstatus') as $maritalstatu) {
                                    ?>
                                    <option value="<?= $maritalstatu['id'] ?>"><?= $maritalstatu['status'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($employee, 'dob')['status']) ?>>
                        <label class="col-sm-2 control-label" for="form-field-1">
                            D.O.B
                        </label>
                        <div class="col-sm-4">
                            <div class="input-group input-append date" id="dob">
                                <input type="text"  placeholder="12-09-2012" name="dob" class="form-control" value="<?= printvalues('dob', $employeevalues) ?>" >
                                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($employee, 'salutation_id')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            Salutation
                        </label>
                        <div class="col-sm-4">
                            <select  class="form-control search-select" placeholder="Select Form" name="salutation_id" id="salutation_id"  >
                                <option value="">-SELECT Salutation-</option>
                                <?php
                                foreach ($controller->allselectablebytable('salutations') as $salutation) {
                                    ?>
                                    <option value="<?= $salutation['id'] ?>"><?= $salutation['salutation'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($employee, 'dateemployeed')['status']) ?>>
                        <label class="col-sm-2 control-label" for="form-field-1">
                            Date Employed
                        </label>
                        <div class="col-sm-4">
                            <div class="input-group input-append date" id="dateemployeed">
                                <input type="text"  placeholder="12-09-2012" name="dateemployeed" class="form-control" value="<?= printvalues('dateemployeed', $employeevalues) ?>">
                                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($employee, 'cellphone')['status']) ?>>
                        <label class="col-sm-2 control-label" for="form-field-1">
                            Cellphone
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="Cellphone" id="cellphone" name="cellphone" class="form-control"  value="<?= printvalues('cellphone', $employeevalues) ?>">
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($employee, 'pin')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            PIN No
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="PIN No" id="pin" name="pin" class="form-control"  value="<?= printvalues('pin', $employeevalues) ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($employee, 'jobgroup_id')['status']) ?>>
                        <label class="col-sm-2 control-label" for="form-field-1">
                            Job Group
                        </label>
                        <div class="col-sm-4">
                            <select  class="form-control search-select" placeholder="Select Form" name="jobgroup_id" id="jobgroup_id"  >
                                <option value="">-SELECT JOB GROUP-</option>
                                <?php
                                foreach ($controller->allselectablebytable('jobgroups') as $jobgroup) {
                                    ?>
                                    <option value="<?= $jobgroup['id'] ?>"><?= $jobgroup['jobgroup'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($employee, 'payfrequency_id')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            Pay Frequency
                        </label>
                        <div class="col-sm-4">
                            <select  class="form-control search-select" placeholder="Select Form" name="payfrequency_id" id="payfrequency_id"  >
                                <option value="">-SELECT Pay Frequency-</option>
                                <?php
                                foreach ($controller->allselectablebytable('paymentfrequency') as $paymentfrequency) {
                                    ?>
                                    <option value="<?= $paymentfrequency['id'] ?>"><?= $paymentfrequency['frequency'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($employee, 'bank_id')['status']) ?>>
                        <label class="col-sm-2 control-label" for="form-field-1">
                            Bank
                        </label>
                        <div class="col-sm-4">
                            <select  class="form-control search-select" placeholder="Select Form" name="bank_id" id="bank_id"  onChange="getmebankbranch();" >
                                <option value="">-SELECT Bank-</option>
                                <?php
                                foreach ($controller->allselectablebytable('banks') as $banks) {
                                    ?>
                                    <option value="<?= $banks['id'] ?>"><?= $banks['bank'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($employee, 'bankbranch_id')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            Bank Branch
                        </label>
                        <div class="col-sm-4">
                            <select  class="form-control search-select" placeholder="Select Form" name="bankbranch_id" id="bankbranch_id"  >
                                <option value="">-SELECT Bank Branch-</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($employee, 'accountnumber')['status']) ?>>
                        <label class="col-sm-2 control-label" for="form-field-1">
                            Account No
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="   Account No" id="accountnumber" name="accountnumber" class="form-control"  value="<?= printvalues('accountnumber', $employeevalues) ?>">
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($employee, 'basicpay')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            Basic Pay
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="Basic Pay" id="basicpay" name="basicpay" class="form-control"  value="<?= printvalues('basicpay', $employeevalues) ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($employee, 'houseallowance')['status']) ?>>
                        <label class="col-sm-2 control-label" for="form-field-1">
                            House Allowance
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="House Allowance" id="houseallowance" name="houseallowance" class="form-control"  value="<?= printvalues('houseallowance', $employeevalues) ?>">
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($employee, 'dailyrate')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            Daily Rate
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="Daily Rate" id="dailyrate" name="dailyrate" class="form-control"  value="<?= printvalues('dailyrate', $employeevalues) ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($employee, 'emailaddress')['status']) ?>>
                        <label class="col-sm-2 control-label" for="form-field-1">
                            Email Address
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="Email Address" id="emailaddress" name="emailaddress" class="form-control"  value="<?= printvalues('emailaddress', $employeevalues) ?>">
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($employee, 'postaladdress')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            Postal Address
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="Postal Address" id="postaladdress" name="postaladdress" class="form-control"  value="<?= printvalues('postaladdress', $employeevalues) ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($employee, 'postalcode')['status']) ?>>
                        <label class="col-sm-2 control-label" for="form-field-1">
                            Postal Code
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="Postal Code" id="postalcode" name="postalcode" class="form-control"  value="<?= printvalues('postalcode', $employeevalues) ?>">
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($employee, 'town')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            Town
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="Town" id="town" name="town" class="form-control"  value="<?= printvalues('town', $employeevalues) ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($employee, 'country')['status']) ?>>
                        <label class="col-sm-2 control-label" for="form-field-1">
                            Country
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="Country" id="country" name="country" class="form-control"  value="<?= printvalues('country', $employeevalues) ?>">
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($employee, 'homephone')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            Home Phone
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="Home Phone" id="homephone" name="homephone" class="form-control"  value="<?= printvalues('homephone', $employeevalues) ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($employee, 'passportnumber')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            Passport No.
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="Passport No." id="passportnumber" name="passportnumber" class="form-control"  value="<?= printvalues('passportnumber', $employeevalues) ?>">
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($employee, 'homedistrict')['status']) ?>>
                        <label class="col-sm-2 control-label" for="form-field-1">
                            Home District
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="Home District" id="homedistrict" name="homedistrict" class="form-control"  value="<?= printvalues('homedistrict', $employeevalues) ?>">
                        </div>
                    </div> 
                </div>
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($employee, 'employee_code')['status']) ?>>
                        <label class="col-sm-2 control-label" for="form-field-1">
                            Employee Number
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="Employee Number" id="employee_code" name="employee_code" class="form-control"  value="<?= printvalues('employee_code', $employeevalues) ?>">
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($employee, 'department_id')['status']) ?>>
                        <label class="col-sm-2 control-label" for="form-field-1">
                            Department
                        </label>
                        <div class="col-sm-4">
                            <select  class="form-control search-select" placeholder="Select Form" name="department_id" id="department_id" >
                                <option value="">-SELECT DEPARTMENT-</option>
                                <?php
                                foreach ($controller->allselectablebytable('departments') as $department) {
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
                    <label class="col-sm-2 control-label" for="form-field-1">
                    </label>
                    <div class="col-sm-4 pull-right">
                        <button class="btn btn-green btn-block" type="submit">
                            Add&nbsp;<i class="fa fa-arrow-circle-right"></i>
                        </button>
                    </div>
                </div>
            </form>
            <br>
            <div id="message"></div>
        </div>
    </div>
</div>
<script>
    var getmebranches = "<?php echo base_url('humanr/loadbranch'); ?>";
    var getmebankbranck = "<?php echo base_url('humanr/loadbankbranch'); ?>";
    var branch_id = document.getElementById("branch_id");
    var bankbranch_id = document.getElementById("bankbranch_id");
    function checkselectedclient() {
//        console.log(branch_id);
        var frag = document.createDocumentFragment(),
                elOption;
        var company_id = document.getElementById("company_id");
        var companyvalue = company_id.options[company_id.selectedIndex].value;
//                                    alert(companyvalue);
        $.ajax({
            method: "POST",
            url: getmebranches,
            data: {'companyid': companyvalue}
        }).
                done(function (data) {
                    $('#branch_id').find('option:not(:first)').remove();
                    var obj = JSON.parse(data);
                    for (var i = 0; i < obj.length; i++) {
                        elOption = frag.appendChild(document.createElement('option'));
                        var counter = obj[i];
                        elOption.text = counter.branch;
                        elOption.value = counter.id;
                        console.log(counter.branch);
                    }
                    branch_id.appendChild(frag);
                });
    }
    function getmebankbranch() {
        var frag = document.createDocumentFragment(),
                elOption;
        var bank_id = document.getElementById("bank_id");
        var bankvalue = bank_id.options[bank_id.selectedIndex].value;
//                                    alert(companyvalue);
        $.ajax({
            method: "POST",
            url: getmebankbranck,
            data: {'bankid': bankvalue}
        }).
                done(function (data) {
//                                                console.log(data);
                    $('#bankbranch_id').find('option:not(:first)').remove();
                    var obj = JSON.parse(data);
                    for (var i = 0; i < obj.length; i++) {
                        elOption = frag.appendChild(document.createElement('option'));
                        var counter = obj[i];
                        elOption.text = counter.bankbranch;
                        elOption.value = counter.id;
                        console.log(counter.bankbranch);
                    }
                    bankbranch_id.appendChild(frag);
                });
    }
    var addemployee = "<?php echo base_url("humanr/add"); ?>";
    $(document).ready(function () {
        $('#dateemployeed')
                .datepicker({
                    format: 'dd-mm-yyyy'
                })
                .on('changeDate', function (e) {
                    // Revalidate the date field
                    $('#employeeconfigform').formValidation('revalidateField', 'dateemployeed');
                });
        $('#dob')
                .datepicker({
                    format: 'dd-mm-yyyy'
                })
                .on('changeDate', function (e) {
                    // Revalidate the date field
                    $('#employeeconfigform').formValidation('revalidateField', 'dob');
                });
        $('#employeeconfigform')
                .formValidation({
                    framework: 'bootstrap',
                    icon: {
                    },
                    fields: {
                        staffno: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'staffno')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Staff  No is required'
                                }
//                                                            ,
//                                                            numeric: {
//                                                                message: 'Numbers are only numbers'
//                                                            }
                            }
                        },
                        employee_code: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'employee_code')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Employee No is required'
                                }
                            }
                        },
                        emailaddress: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'emailaddress')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Email  is required'
                                },
                                emailAddress: {
                                    message: 'The email address is not valid'
                                }
                            }
                        },
                        employmenttype_id: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'employmenttype_id')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Employment Type  is required'
                                }
                            }
                        },
                        company_id: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'company_id')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Company Is Required Required'
                                }
                            }
                        },
                        branch_id: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'branch_id')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Branch  Is Required Required'
                                }
                            }
                        },
                        department_id: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'department_id')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Department  Is Required Required'
                                }
                            }
                        },
                        jobtitle_id: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'jobtitle_id')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Job Title  Is Required Required'
                                }
                            }
                        },
                        firstname: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'firstname')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'First Name  Is Required Required'
                                }
                            }
                        },
                        lastname: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'lastname')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Last Name  Is Required Required'
                                }
                            }
                        }
                        , middlename: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'middlename')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Middle Name  Is Required Required'
                                }
                            }
                        },
                        idnumber: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'idnumber')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'ID Number  Is Required Required'
                                }
                            }
                        }
                        ,
                        nhifnumber: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'nhifnumber')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'NHIF Number  Is Required'
                                }
                            }
                        }
                        ,
                        id_gender: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'id_gender')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Gender  Is Required'
                                }
                            }
                        },
                        nssfnumber: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'nssfnumber')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'NSSF Number  Is Required'
                                }
                            }
                        }
                        ,
                        pysicaladdress: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'pysicaladdress')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'PYSCIAL Address  Is Required'
                                }
                            }
                        }
                        ,
                        maritalstatus_id: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'maritalstatus_id')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Marital Status  Is Required'
                                }
                            }
                        }
                        ,
                        dob: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'dob')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'D.O.B  Is Required'
                                },
                                date: {
                                    format: 'DD-MM-YYYY',
                                    message: 'The date is not a valid'
                                }
                            }
                        },
                        salutation_id: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'salutation_id')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Salutation  Is Required'
                                }
                            }
                        },
                        dateemployeed: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'dateemployeed')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Date Of Employment  Is Required'
                                },
                                date: {
                                    format: 'DD-MM-YYYY',
                                    message: 'The date is not a valid'
                                }
                            }
                        },
                        cellphone: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'cellphone')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'The Telephone Number is required'
                                },
                                regexp: {
                                    regexp: /^[0-9,+]{13}$/,
                                    message: 'Enter Valid Contact Number format +254735973206'
                                }
                            }
                        },
                        pin: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'pin')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'The PIN Number is required'
                                }
                            }
                        },
                        jobgroup_id: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'jobgroup_id')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'JOB Group is required'
                                }
                            }
                        }
                        ,
                        payfrequency_id: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'payfrequency_id')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Pay Frequency  is required'
                                }
                            }
                        },
                        bank_id: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'bank_id')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Bank  is required'
                                }
                            }
                        },
                        bankbranch_id: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'bankbranch_id')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Bank Branch  is required'
                                }
                            }
                        },
                        accountnumber: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'accountnumber')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Account Number  is required'
                                }
                            }
                        },
                        basicpay: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'basicpay')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Basic Pay  is required'
                                }
                            }
                        },
                        dailyrate: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'dailyrate')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Daily Rate  is required'
                                }
                            }
                        },
                        houseallowance: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'houseallowance')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'House Allowance  is required'
                                }
                            }
                        },
                        passportnumber: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'passportnumber')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Passport Number  is required'
                                }
                            }
                        },
                        postaladdress: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'postaladdress')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Postal Address  is required'
                                }
                            }
                        },
                        postalcode: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'postalcode')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Postal Code  is required'
                                }
                            }
                        },
                        town: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'town')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Town  is required'
                                }
                            }
                        },
                        country: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'country')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Country  is required'
                                }
                            }
                        },
                        homephone: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'homephone')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Home Phone  is required'
                                }
                            }
                        },
                        homedistrict: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'homedistrict')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Home District  is required'
                                }
                            }
                        }
                    }
                }).on('success.form.fv', function (e) {
            // Save the form data via an Ajax request
            e.preventDefault();
            $.ajax({
                url: addemployee,
                type: $(this).attr("method"),
                dataType: "json",
                data: new FormData(this),
                processData: false,
                contentType: false
            }).done(function (response) {
//                datagrid.fetchGrid("employeeprofile");
                $('#employeeconfigform').formValidation('resetForm', true);
//                console.log(JSON.stringify(response));
            });
        });
    });
</script>
