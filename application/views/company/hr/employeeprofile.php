<?php
$employee = $controller->gettablecolumns('users');
//$hellohello = hideorshow(array_keyvaluen($employee, 'drivinflicense')['status']);
//print_array(array_keyvaluen($employee, 'drivinflicense')['status']);
$user_experience = $controller->gettablecolumns('user_experience');
$userexparray = $controller->allselectablebytablewhere('user_experience', 'id_employee', printvalues('id', $employeevaluesprofile));
$checkuserexperience = $this->session->flashdata('edituserexperience');
if (empty($checkuserexperience)) {
    $checkuserexperience = array();
} else {
    $checkuserexperience = $checkuserexperience[0];
}

if (empty($employeevaluesprofile)) {
    $employeevaluesprofile = array();
} else {
    
}
$otherpossiblevaluesemp = $controller->allselectablebytablewhere('employeeprofile', 'id', printvalues('id', $employeevaluesprofile))[0];
$data['userexparray'] = $userexparray;
$marital = $controller->allselectablebytablewhere('maritalstatus', 'id', printvalues('maritalstatus_id', $employeevaluesprofile));
$gender = $controller->allselectablebytablewhere('genders', 'id', printvalues('id_gender', $employeevaluesprofile));
$salutation = $controller->allselectablebytablewhere('salutations', 'id', printvalues('salutation_id', $employeevaluesprofile));
$company = $controller->allselectablebytablewhere('company', 'id', printvalues('company_id', $employeevaluesprofile));
$branch = $controller->allselectablebytablewhere('branches', 'id', printvalues('branch_id', $employeevaluesprofile));
$jobgroup = $controller->allselectablebytablewhere('jobgroups', 'id', printvalues('jobgroup_id', $employeevaluesprofile));
//print_array();
if (empty($marital)) {
    $maritalid = 2;
} else {
    $maritalid = $marital[0]['id'];
}
if (empty($gender)) {
    $genderid = 1;
} else {
    $genderid = $gender[0]['id'];
}
if (empty($salutation)) {
    $salutationid = 1;
} else {
    $salutationid = $salutation[0]['id'];
}
if (empty($company)) {
    $companyid = 1;
} else {
    $companyid = $company[0]['id'];
}
if (empty($jobgroup)) {
    $jobid = 2;
} else {
    $jobid = $jobgroup[0]['id'];
}
if (empty($branch)) {
    $branch = $controller->allselectablebytablewhere('branches', 'id', 1);
}
//print_array($jobgroup);
?>
<div class="row">
    <div class="col-md-3">
        <p class="statusMsg"></p>
        <form id="userprofilesummeryform" enctype="multipart/form-data" novalidate>
            <div class="user-left">
                <div class="center">
                    <h4>Employee Profile</h4>
                    <input type="hidden"  id="userprofileold" name="userprofileold"  class="form-control" value="<?= printvalues('user_image_small', $employeevaluesprofile) ?>">
                    <input type="hidden"  id="id" name="id"  class="form-control" value="<?= printvalues('id', $employeevaluesprofile) ?>">
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                        <div class="user-image">
                            <div class="fileupload-new thumbnail"><img src="<?= base_url() ?>upload/employeeprofile/<?= printvalues('user_image_small', $employeevaluesprofile) ?>" >
                            </div>
                            <div class="fileupload-preview fileupload-exists thumbnail"></div>
                            <div class="user-image-buttons">
                                <span class="btn btn-azure btn-file btn-sm"><span class="fileupload-new"><i class="fa fa-pencil"></i></span><span class="fileupload-exists"><i class="fa fa-pencil"></i></span>
                                    <input type="file" id="file" name="file">
                                </span>
                                <a href="#" class="btn fileupload-exists btn-red btn-sm" data-dismiss="fileupload">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th colspan="3">Summery Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Staff No:</td>
                            <td>
                                <a href="#">
                                    <?= printvalues('staffno', $employeevaluesprofile) ?>
                                </a>
                            </td>
                            <td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
                        </tr>
                        <tr>
                            <td>Employee Name:</td>
                            <td>
                                <a href="">
                                    <?= printvalues('firstname', $employeevaluesprofile) ?>&nbsp;<?= printvalues('middlename', $employeevaluesprofile) ?>&nbsp;<?= printvalues('lastname', $employeevaluesprofile) ?>
                                </a>
                            </td>
                            <td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
                        </tr>
                        <tr>
                            <td>Cellphone:</td>
                            <td><?= printvalues('cellphone', $employeevaluesprofile) ?></td>
                            <td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
                        </tr>
                        <tr>
                            <td>PIN Number:</td>
                            <td>
                                <a href="">
                                    <?= printvalues('pin', $employeevaluesprofile) ?>
                                </a>
                            </td>
                            <td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
                        </tr>
                        <tr>
                            <td>ID Number:</td>
                            <td>
                                <a href="">
                                    <?= printvalues('employee_code', $employeevaluesprofile) ?>
                                </a>
                            </td>
                            <td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
                        </tr>
                        <tr>
                            <td>NSSF Number:</td>
                            <td>
                                <a href="">
                                    <?= printvalues('nssfnumber', $employeevaluesprofile) ?>
                                </a>
                            </td>
                            <td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
                        </tr>
                        <tr>
                            <td>NHIF Number:</td>
                            <td>
                                <a href="">
                                    <?= printvalues('nhifnumber', $employeevaluesprofile) ?>
                                </a>
                            </td>
                            <td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>
                                <span class="label label-sm label-info"> <?php
                                    if (printvalues('category', $employeevaluesprofile) == '') {
                                        echo 'Employee';
                                    } else {
                                        echo printvalues('category', $employeevaluesprofile);
                                    }
                                    ?>
                                </span>
                            </td>
                            <td>
                                <a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a>
                            </td>

                        </tr>
                        <tr>
                            <td> </td>
                            <td> </td>
                            <td>            
                                <input type="submit" name="submit" class="btn btn-sm btn-danger submitBtn" value="Update"/>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </form>
    </div>
    <div class="col-md-9">
        <div class="panel-group accordion" id="accordion">
            <div class="panel panel-white">
                <div class="panel-heading">
                    <h5 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                            <i class="icon-arrow"></i> Bio Data
                        </a>
                    </h5>
                </div>
                <div id="collapseOne" class="collapse in">
                    <p class="updatepersone"></p>
                    <form id="employeeprofileconfigtwo" role="form" method="post" class="form-horizontal" enctype="multipart/form-data" novalidate>
                        <div class="panel-body">
                            <div class="form-group" >
                                <input type="hidden"  id="id" name="id"  class="form-control" value="<?= printvalues('id', $employeevaluesprofile) ?>">
                                <div <?= hideorshow(array_keyvaluen($employee, 'firstname')['status']) ?>>
                                    <label class="col-sm-2 control-label">
                                        First Name
                                    </label>
                                    <div class="col-sm-4">
                                        <input type="text" placeholder="First Name" id="firstname" name="firstname" class="form-control"  value="<?= printvalues('firstname', $employeevaluesprofile) ?>">
                                    </div>
                                </div>
                                <div <?= hideorshow(array_keyvaluen($employee, 'middlename')['status']) ?>>
                                    <label class="col-sm-2 control-label" for="form-field-1">
                                        Middle Name
                                    </label>
                                    <div class="col-sm-4">
                                        <input type="text" placeholder="Middle Name" id="middlename" name="middlename" class="form-control"  value="<?= printvalues('middlename', $employeevaluesprofile) ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" >
                                <div <?= hideorshow(array_keyvaluen($employee, 'lastname')['status']) ?>>
                                    <label class="col-sm-2 control-label">
                                        Last Name
                                    </label>
                                    <div class="col-sm-4">
                                        <input type="text" placeholder="Last Name" id="lastname" name="lastname" class="form-control"  value="<?= printvalues('lastname', $employeevaluesprofile) ?>">
                                    </div>
                                </div>
                                <div <?= hideorshow(array_keyvaluen($employee, 'staffno')['status']) ?>>
                                    <label class="col-sm-2 control-label">
                                        Staff No
                                    </label>
                                    <div class="col-sm-4">
                                        <input type="text" placeholder="Staff Number" id="staffno" name="staffno" class="form-control"   value="<?= printvalues('staffno', $employeevaluesprofile) ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" >
                                <div <?= hideorshow(array_keyvaluen($employee, 'nhifnumber')['status']) ?>>
                                    <label class="col-sm-2 control-label">
                                        NHIF No.
                                    </label>
                                    <div class="col-sm-4">
                                        <input type="text" placeholder="  NHIF No." id="nhifnumber" name="nhifnumber" class="form-control"  value="<?= printvalues('nhifnumber', $employeevaluesprofile) ?>">
                                    </div>
                                </div>
                                <div <?= hideorshow(array_keyvaluen($employee, 'nssfnumber')['status']) ?>>
                                    <label class="col-sm-2 control-label" for="form-field-1">
                                        NSSF No
                                    </label>
                                    <div class="col-sm-4">
                                        <input type="text" placeholder="NSSF No" id="nssfnumber" name="nssfnumber" class="form-control"  value="<?= printvalues('nssfnumber', $employeevaluesprofile) ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" >
                                <div <?= hideorshow(array_keyvaluen($employee, 'pin')['status']) ?>>
                                    <label class="col-sm-2 control-label">
                                        PIN No
                                    </label>
                                    <div class="col-sm-4">
                                        <input type="text" placeholder="PIN No" id="pin" name="pin" class="form-control"  value="<?= printvalues('pin', $employeevaluesprofile) ?>">
                                    </div>
                                </div>
                                <div <?= hideorshow(array_keyvaluen($employee, 'idnumber')['status']) ?>>
                                    <label class="col-sm-2 control-label" for="form-field-1">
                                        Id Number
                                    </label>
                                    <div class="col-sm-4">
                                        <input type="text" placeholder="Id Number" id="idnumber" name="idnumber" class="form-control"  value="<?= printvalues('idnumber', $employeevaluesprofile) ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" >
                                <div <?= hideorshow(array_keyvaluen($employee, 'dob')['status']) ?>>
                                    <label class="col-sm-2 control-label" for="form-field-1">
                                        D.O.B
                                    </label>
                                    <div class="col-sm-4">
                                        <!--<div class="input-group input-append date" >-->
                                        <input type="text"  placeholder="DD-MM-YYYY" name="dob" id="dob" class="form-control" value="<?= printvalues('dob', $employeevaluesprofile) ?>" >
                                        <!--<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>-->
                                        <!--</div>-->
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
                                                <option value="<?= $id_gender['id'] ?>" <?php
                                                if ($id_gender['id'] == $genderid) {
                                                    echo 'selected';
                                                }
                                                ?>><?= $id_gender['gender'] ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" >
                                <div <?= hideorshow(array_keyvaluen($employee, 'maritalstatus_id')['status']) ?>>
                                    <label class="col-sm-2 control-label">
                                        Marital Status
                                    </label>
                                    <div class="col-sm-4">
                                        <select  class="form-control search-select" placeholder="Select Form" name="maritalstatus_id" id="maritalstatus_id"  >
                                            <option value="">-SELECT Marital Status-</option>
                                            <!--<option value="2" selected>MARRIED</option>-->
                                            <?php
                                            foreach ($controller->allselectablebytable('maritalstatus') as $maritalstatu) {
                                                ?>
                                                <option value="<?= $maritalstatu['id'] ?>" <?php
                                                if ($maritalstatu['id'] == $maritalid) {
                                                    echo 'selected';
                                                }
                                                ?>><?= $maritalstatu['status'] ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                        </select>
                                    </div>
                                </div>
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
                                                <option value="<?= $salutation['id'] ?>" <?php
                                                if ($salutation['id'] == $salutationid) {
                                                    echo 'selected';
                                                }
                                                ?>><?= $salutation['salutation'] ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" >
                                <div <?= hideorshow(array_keyvaluen($employee, 'cellphone')['status']) ?>>
                                    <label class="col-sm-2 control-label" for="form-field-1">
                                        Cellphone
                                    </label>
                                    <div class="col-sm-4">
                                        <input type="text" placeholder="+254706161473" id="cellphone" name="cellphone" class="form-control"  value="<?= printvalues('cellphone', $employeevaluesprofile) ?>">
                                    </div>
                                </div>
                                <div <?= hideorshow(array_keyvaluen($employee, 'emailaddress')['status']) ?>>
                                    <label class="col-sm-2 control-label" for="form-field-1">
                                        Email Address
                                    </label>
                                    <div class="col-sm-4">
                                        <input type="text" placeholder="user@mail.com" id="emailaddress" name="emailaddress" class="form-control"  value="<?= printvalues('emailaddress', $employeevaluesprofile) ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" >
                                <div <?= hideorshow(array_keyvaluen($employee, 'passportnumber')['status']) ?>>
                                    <label class="col-sm-2 control-label">
                                        Passport No.
                                    </label>
                                    <div class="col-sm-4">
                                        <input type="text" placeholder="Passport No." id="passportnumber" name="passportnumber" class="form-control"  value="<?= printvalues('passportnumber', $employeevaluesprofile) ?>">
                                    </div>
                                </div>
                                <div <?= hideorshow(array_keyvaluen($employee, 'drivinflicense')['status']) ?>>
                                    <label class="col-sm-2 control-label">
                                        Driving License
                                    </label>
                                    <div class="col-sm-4">
                                        <input type="text" placeholder="Driving License" id="drivinflicense" name="drivinflicense" class="form-control"  value="<?= printvalues('drivinflicense', $employeevaluesprofile) ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" >
                                <div <?= hideorshow(array_keyvaluen($employee, 'dateemployeed')['status']) ?>>
                                    <label class="col-sm-2 control-label" for="form-field-1">
                                        Date Employed
                                    </label>
                                    <div class="col-sm-4">
                                        <!--<div class="input-group input-append date" >-->
                                        <input type="text"  placeholder="DD-MM-YYYY" name="dateemployeed" id="dateemployeed" class="form-control" value="<?= printvalues('dateemployeed', $employeevaluesprofile) ?>">
                                        <!--<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>-->
                                        <!--</div>-->
                                    </div>
                                </div>
                                <div <?= hideorshow(array_keyvaluen($employee, 'dateterminated')['status']) ?>>
                                    <label class="col-sm-2 control-label" for="form-field-1">
                                        Date Terminated
                                    </label>
                                    <div class="col-sm-4">
                                        <input type="text" placeholder="DD-MM-YYYY" id="dateterminated" name="dateterminated" class="form-control"  value="<?= printvalues('dateterminated', $employeevaluesprofile) ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" >
                                <div <?= hideorshow(array_keyvaluen($employee, 'ethnicity')['status']) ?>>
                                    <label class="col-sm-2 control-label">
                                        Ethnicity
                                    </label>
                                    <div class="col-sm-4">
                                        <input type="text" placeholder="Ethnicity" id="ethnicity" name="ethnicity" class="form-control"  value="<?= printvalues('ethnicity', $employeevaluesprofile) ?>">
                                    </div>
                                </div>
                                <div <?= hideorshow(array_keyvaluen($employee, 'yearsofservice')['status']) ?>>
                                    <label class="col-sm-2 control-label">
                                        Years of Service
                                    </label>
                                    <div class="col-sm-4">
                                        <input type="number" placeholder="Years of Service" id="yearsofservice" name="yearsofservice" class="form-control"  value="<?= printvalues('yearsofservice', $employeevaluesprofile) ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" >
                                <div <?= hideorshow(array_keyvaluen($employee, 'homedistrict')['status']) ?>>
                                    <label class="col-sm-2 control-label" for="form-field-1">
                                        Home District
                                    </label>
                                    <div class="col-sm-4">
                                        <input type="text" placeholder="Home District" id="homedistrict" name="homedistrict" class="form-control"  value="<?= printvalues('homedistrict', $employeevaluesprofile) ?>">
                                    </div>
                                </div>
                                <div <?= hideorshow(array_keyvaluen($employee, 'passportphoto')['status']) ?>>
                                    <label class="col-sm-2 control-label" for="form-field-1">
                                        Passport Photo
                                    </label>
                                    <div class="col-sm-4">
                                        <div data-provides="fileupload" class="fileupload fileupload-new">
                                            <span class="btn btn-file btn-light-grey"><i class="fa fa-folder-open-o"></i> <span class="fileupload-new">Select file</span><span class="fileupload-exists">Change</span>
                                                <input type="file" id="passport" name="upload[]">
                                                <input type="hidden"  id="passportold" name="passportold"  value="<?= printvalues('passportphoto', $employeevaluesprofile) ?>">
                                            </span>
                                            <span class="fileupload-preview"></span>
                                            <a data-dismiss="fileupload" class="close fileupload-exists float-none" href="#">
                                                &times;
                                            </a>
                                        </div>
                                        <p class="help-block">
                                            <?= printvalues('passportphoto', $employeevaluesprofile) ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" >
                                <div <?= hideorshow(array_keyvaluen($employee, 'curiculumvitae')['status']) ?>>
                                    <label class="col-sm-2 control-label" for="form-field-1">
                                        Curiculum Vitae
                                    </label>
                                    <div class="col-sm-4">
                                        <div data-provides="fileupload" class="fileupload fileupload-new">
                                            <span class="btn btn-file btn-light-grey"><i class="fa fa-folder-open-o"></i> <span class="fileupload-new">Select file</span><span class="fileupload-exists">Change</span>
                                                <input type="file" id="curiculumvitae" name="upload[]" >
                                                <input type="hidden"  id="curiculumvitaeold" name="curiculumvitaeold"  value="<?= printvalues('curiculumvitae', $employeevaluesprofile) ?>">
                                            </span>
                                            <span class="fileupload-preview"></span>
                                            <a data-dismiss="fileupload" class="close fileupload-exists float-none" href="#">
                                                &times;
                                            </a>
                                        </div>
                                        <p class="help-block">
                                            <?= printvalues('curiculumvitae', $employeevaluesprofile) ?>
                                        </p>
                                    </div>
                                </div>
                                <label class="col-sm-2 control-label" for="form-field-1">
                                    Active
                                </label>
                                <div class="col-sm-2">
                                    <div class="btn-group" id="status" data-toggle="buttons">
                                        <label class="btn btn-default btn-on <?php
                                        if (printvalues('activestateemployee', $employeevaluesprofile) == 1) {
                                            echo 'active';
                                        }
                                        ?>">
                                            <input type="radio" value="1" name="activestateemployee"  <?php
                                            if (printvalues('activestateemployee', $employeevaluesprofile) == 1) {
                                                echo 'checked="checked"';
                                            }
                                            ?>>YES</label>
                                        <label class="btn btn-default btn-off <?php
                                        if (printvalues('activestateemployee', $employeevaluesprofile) == 0) {
                                            echo 'active';
                                        }
                                        ?>">
                                            <input type="radio" value="0" name="activestateemployee" <?php
                                            if (printvalues('activestateemployee', $employeevaluesprofile) == 0) {
                                                echo 'checked="checked"';
                                            }
                                            ?>>NO</label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <button class="btn btn-azure btn-sm submitBtn" type="submit" name="submit">
                                        Update&nbsp;
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="panel panel-white">
                <div class="panel-heading">
                    <h5 class="panel-title">
                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" id="workinfotab">
                            <i class="icon-arrow"></i> Work Info
                        </a>
                    </h5>
                </div>
                <div id="collapseTwo" class="collapse">
                    <form id="employeeprofileconfigone" role="form" method="post" class="form-horizontal" novalidate>
                        <div class="panel-body">
                            <div class="form-group">
                                <input type="hidden"  id="id" name="id"  class="form-control" value="<?= printvalues('id', $employeevaluesprofile) ?>">
                                <div <?= hideorshow(array_keyvaluen($employee, 'company_id')['status']) ?>>
                                    <label class="col-sm-2 control-label">
                                        COMPANY
                                    </label>
                                    <div class="col-sm-4">
                                        <select  class="form-control search-select" placeholder="Select Form" name="company_id" id="company_id" onChange="checkselectedclientprofi();" >
                                            <option value="">-SELECT COMPANY-</option>
                                            <?php
                                            foreach ($controller->allselectablebytable('company') as $company) {
                                                ?>
                                                <option value="<?= $company['id'] ?>" <?php
                                                if ($company['id'] == $companyid) {
                                                    echo 'selected';
                                                }
                                                ?>><?= $company['name'] ?></option>
                                                    <?php }
                                                    ?>
                                        </select>
                                    </div>
                                </div>
                                <div <?= hideorshow(array_keyvaluen($employee, 'branch_id')['status']) ?>>
                                    <label class="col-sm-2 control-label">
                                        COMPANY BRANCH
                                        <!--InAct.-->
                                    </label>
                                    <div class="col-sm-4">
                                        <select  class="form-control search-select" placeholder="Select Form" name="branch_id" id="branch_id"  >
                                            <option value="">-SELECT Company Branch-</option>
                                            <?php
                                            foreach ($controller->allselectablebytablewhere('branches', 'id_company', $companyid) as $companybranch) {
                                                ?>
                                                <option value="<?= $companybranch['id'] ?>" <?php
                                                if ($companybranch['branch'] == printvalues('branchname', $otherpossiblevaluesemp)) {
                                                    echo 'selected';
                                                }
                                                ?>><?= $companybranch['branch'] ?></option>
                                                    <?php }
                                                    ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" >
                                <div <?= hideorshow(array_keyvaluen($employee, 'region_id')['status']) ?>>
                                    <label class="col-sm-2 control-label">
                                        Region
                                    </label>
                                    <div class="col-sm-4">
                                        <select  class="form-control search-select" placeholder="Select Form" name="region_id" id="region_id" >
                                            <option value="">-SELECT Region-</option>
                                            <?php
                                            foreach ($controller->allselectablebytablewhere('regions', 'id_company', $companyid) as $regions) {
                                                ?>
                                                <option value="<?= $regions['id'] ?>" <?php
                                                if ($regions['id'] == printvalues('region_id', $employeevaluesprofile)) {
                                                    echo 'selected';
                                                }
                                                ?>><?= $regions['region'] ?></option>
                                                    <?php }
                                                    ?>
                                        </select>
                                    </div>
                                </div>
                                <div <?= hideorshow(array_keyvaluen($employee, 'station_id')['status']) ?>>
                                    <label class="col-sm-2 control-label">
                                        Station
                                    </label>
                                    <div class="col-sm-4">
                                        <select  class="form-control search-select" placeholder="Select Form" name="region_id" id="region_id" >
                                            <option value="">-SELECT STATION-</option>
                                            <?php
                                            foreach ($controller->allselectablebytablewhere('stations', 'id_region', printvalues('region_id', $employeevaluesprofile)) as $stations) {
                                                ?>
                                                <option value="<?= $stations['id'] ?>" <?php
                                                if ($stations['id'] == printvalues('station_id', $employeevaluesprofile)) {
                                                    echo 'selected';
                                                }
                                                ?>><?= $stations['station'] ?></option>
                                                    <?php }
                                                    ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" >
                                <div <?= hideorshow(array_keyvaluen($employee, 'department_id')['status']) ?>>
                                    <label class="col-sm-2 control-label" for="form-field-1">
                                        Department
                                    </label>
                                    <div class="col-sm-4">
                                        <select  class="form-control search-select" placeholder="Select Form" name="department_id" id="department_id" >
                                            <option value="">-SELECT DEPARTMENT-</option>
                                            <?php
                                            foreach ($controller->allselectablebytablewhere('departments', 'id_company', $companyid) as $department) {
                                                ?>
                                                <option value="<?= $department['id'] ?>" <?php
                                                if ($department['id'] == printvalues('department_id', $employeevaluesprofile)) {
                                                    echo 'selected';
                                                }
                                                ?>><?= $department['department'] ?></option>
                                                    <?php }
                                                    ?>
                                        </select>
                                    </div>
                                </div>
                                <div <?= hideorshow(array_keyvaluen($employee, 'section_id')['status']) ?>>
                                    <label class="col-sm-2 control-label" for="form-field-1">
                                        Section
                                    </label>
                                    <div class="col-sm-4">
                                        <select  class="form-control search-select" placeholder="Select Form" name="section_id" id="section_id" >
                                            <option value="">-SELECT SECTION-</option>
                                            <?php
                                            foreach ($controller->allselectablebytablewhere('sections', 'id_department', printvalues('department_id', $employeevaluesprofile)) as $sections) {
                                                ?>
                                                <option value="<?= $sections['id'] ?>" <?php
                                                if ($sections['id'] == printvalues('section_id', $employeevaluesprofile)) {
                                                    echo 'selected';
                                                }
                                                ?>><?= $sections['section'] ?></option>
                                                    <?php }
                                                    ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" >
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
                                                <option value="<?= $jobgroup['id'] ?>" <?php
                                                if ($jobgroup['id'] == $jobid) {
                                                    echo 'selected';
                                                }
                                                ?>><?= $jobgroup['jobgroup'] ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                        </select>
                                    </div>
                                </div>
                                <div <?= hideorshow(array_keyvaluen($employee, 'designation_id')['status']) ?>>
                                    <label class="col-sm-2 control-label" for="form-field-1">
                                        Designation
                                    </label>
                                    <div class="col-sm-4">
                                        <select  class="form-control search-select" placeholder="Select Form" name="designation_id" id="designation_id"  >
                                            <option value="">-SELECT DESIGNATION-</option>
                                            <?php
                                            foreach ($controller->allselectablebytable('designations') as $designation) {
                                                ?>
                                                <option value="<?= $designation['id'] ?>" <?php
                                                if ($designation['id'] == printvalues('designation_id', $employeevaluesprofile)) {
                                                    echo 'selected';
                                                }
                                                ?>><?= $designation['designation'] ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" >
                                <div <?= hideorshow(array_keyvaluen($employee, 'jobgrade_id')['status']) ?>>
                                    <label class="col-sm-2 control-label" for="form-field-1">
                                        Job Grade
                                    </label>
                                    <div class="col-sm-4">
                                        <select  class="form-control search-select" placeholder="Select Form" name="jobgrade_id" id="jobgrade_id"  >
                                            <option value="">-SELECT JOB GRADES-</option>
                                            <?php
                                            foreach ($controller->allselectablebytable('jobgrades') as $jobgrades) {
                                                ?>
                                                <option value="<?= $jobgrades['id'] ?>" <?php
                                                if ($jobgrades['id'] == printvalues('jobgrade_id', $employeevaluesprofile)) {
                                                    echo 'selected';
                                                }
                                                ?>><?= $jobgrades['jobgrade'] ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                        </select>
                                    </div>
                                </div>
                                <div <?= hideorshow(array_keyvaluen($employee, 'employmenttype_id')['status']) ?>>
                                    <label class="col-sm-2 control-label" for="form-field-1">
                                        Employment Type
                                    </label>
                                    <div class="col-sm-4">
                                        <select  class="form-control search-select" placeholder="Select Form" name="employmenttype_id" id="employmenttype_id"  >
                                            <option value="">-SELECT EMP TYPE-</option>
                                            <?php
                                            foreach ($controller->allselectablebytable('employementtypes') as $employementtype) {
                                                ?>
                                                <option value="<?= $employementtype['id'] ?>" <?php
                                                if ($employementtype['id'] == printvalues('employmenttype_id', $employeevaluesprofile)) {
                                                    echo 'selected';
                                                }
                                                ?>><?= $employementtype['employementtype'] ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" >
                                <div <?= hideorshow(array_keyvaluen($employee, 'attendence_shiftdef_id')['status']) ?>>
                                    <label class="col-sm-2 control-label">
                                        Shift
                                    </label>
                                    <div class="col-sm-4">
                                        <select  class="form-control search-select" placeholder="Select Form" name="attendence_shiftdef_id" id="attendence_shiftdef_id"  >
                                            <option value="">-SELECT SHIFT-</option>
                                            <?php
                                            foreach ($controller->allselectablebytable('attendence_shiftdef') as $attendence_shiftdef) {
                                                ?>
                                                <option value="<?= $attendence_shiftdef['id'] ?>" <?php
                                                if ($attendence_shiftdef['id'] == printvalues('attendence_shiftdef_id', $employeevaluesprofile)) {
                                                    echo 'selected';
                                                }
                                                ?>><?= $attendence_shiftdef['shiftype'] ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                        </select>
                                    </div>
                                </div>
                                <div <?= hideorshow(array_keyvaluen($employee, 'homephone')['status']) ?>>
                                    <label class="col-sm-2 control-label">
                                        Home Phone
                                    </label>
                                    <div class="col-sm-4">
                                        <input type="text" placeholder="Home Phone" id="homephone" name="homephone" class="form-control"  value="<?= printvalues('homephone', $employeevaluesprofile) ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" >
                                <div <?= hideorshow(array_keyvaluen($employee, 'manager_id')['status']) ?>>
                                    <label class="col-sm-2 control-label">
                                        Manager
                                    </label>
                                    <div class="col-sm-4">
                                        <select  class="form-control search-select" name="manager_id" id="manager_id"  >
                                            <option value="">-SELECT MANAGER-</option>
                                            <?php
                                            foreach ($controller->allselectablebytablewhere('users', 'jobgroup_id', 1) as $jobgroupmanager) {
                                                ?>
                                                <option value="<?= $jobgroupmanager['id'] ?>" <?php
                                                if ($jobgroupmanager['id'] == printvalues('manager_id', $employeevaluesprofile)) {
                                                    echo 'selected';
                                                }
                                                ?>><?= $jobgroupmanager['id'] . ' : ' . $jobgroupmanager['firstname'] . ' ' . $jobgroupmanager['lastname'] ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                        </select>
                                    </div>
                                </div>
                                <div <?= hideorshow(array_keyvaluen($employee, 'astmanager_id')['status']) ?>>
                                    <label class="col-sm-2 control-label">
                                        Asst. Manager
                                    </label>
                                    <div class="col-sm-4">
                                        <select  class="form-control search-select" name="astmanager_id" id="astmanager_id"  >
                                            <option value="">-SELECT ASST MANAGER-</option>
                                            <?php
                                            foreach ($controller->allselectablebytablewhere('users', 'jobgroup_id', 3) as $jobgroupmanager) {
                                                ?>
                                                <option value="<?= $jobgroupmanager['id'] ?>" <?php
                                                if ($jobgroupmanager['id'] == printvalues('astmanager_id', $employeevaluesprofile)) {
                                                    echo 'selected';
                                                }
                                                ?>><?= $jobgroupmanager['id'] . ' : ' . $jobgroupmanager['firstname'] . ' ' . $jobgroupmanager['lastname'] ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" >
                                <div <?= hideorshow(array_keyvaluen($employee, 'prevemployer')['status']) ?>>
                                    <label class="col-sm-2 control-label">
                                        Previous Employer
                                    </label>
                                    <div class="col-sm-4">
                                        <input type="text" placeholder="Previous Employer" id="prevemployer" name="prevemployer" class="form-control"  value="<?= printvalues('prevemployer', $employeevaluesprofile) ?>">
                                    </div>
                                </div>
                                <div <?= hideorshow(array_keyvaluen($employee, 'nextemployer')['status']) ?>>
                                    <label class="col-sm-2 control-label">
                                        Next Employer
                                    </label>
                                    <div class="col-sm-4">
                                        <input type="text" placeholder="Next Employer" id="nextemployer" name="nextemployer" class="form-control"  value="<?= printvalues('nextemployer', $employeevaluesprofile) ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" >
                                <div <?= hideorshow(array_keyvaluen($employee, 'jobstatus_id')['status']) ?>>
                                    <label class="col-sm-2 control-label">
                                        Job Status
                                    </label>
                                    <div class="col-sm-4">
                                        <select  class="form-control search-select" name="jobstatus_id" id="jobstatus_id"  >
                                            <option value="">-SELECT JOB STATUS-</option>
                                            <?php
                                            foreach ($controller->allselectablebytable('employementstatus') as $employementstatus) {
                                                ?>
                                                <option value="<?= $employementstatus['id'] ?>" <?php
                                                if ($employementstatus['id'] == printvalues('jobstatus_id', $employeevaluesprofile)) {
                                                    echo 'selected';
                                                }
                                                ?>><?= $employementstatus['status'] ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                        </select>
                                    </div>
                                </div>
                                <label class="col-sm-2 control-label">
                                    Date Of Confirmation
                                </label>
                                <div class="col-sm-4">
                                    <input type="text" placeholder="DD-MM-YYYY" id="dateofconfirmation" name="dateofconfirmation" class="form-control"  value="<?= printvalues('dateofconfirmation', $employeevaluesprofile) ?>">
                                </div>
                            </div>
                            <div class="form-group" >
                                <div <?= hideorshow(array_keyvaluen($employee, 'confirmationstatus')['status']) ?>>
                                    <label class="col-sm-2 control-label">
                                        Confirmation Status
                                    </label>
                                    <div class="col-sm-4">
                                        <select  class="form-control search-select" name="confirmationstatus" id="confirmationstatus"  >
                                            <option value="">-CONFIRM STATUS-</option>
                                            <option value="1" <?php
                                            if (1 == printvalues('confirmationstatus', $employeevaluesprofile)) {
                                                echo 'selected';
                                            }
                                            ?>>YES</option>
                                            <option value="0" <?php
                                            if (0 == printvalues('confirmationstatus', $employeevaluesprofile)) {
                                                echo 'selected';
                                            }
                                            ?>>NO</option>
                                        </select>
                                    </div>
                                </div>
                                <label class="col-sm-2 control-label" for="form-field-1">
                                    Overtime
                                </label>
                                <div class="col-sm-2">
                                    <div class="btn-group" id="status" data-toggle="buttons">
                                        <label class="btn btn-default btn-on <?php
                                        if (printvalues('overtimestate', $employeevaluesprofile) == 1) {
                                            echo 'active';
                                        }
                                        ?>">
                                            <input type="radio" value="1" name="overtimestate"  <?php
                                            if (printvalues('overtimestate', $employeevaluesprofile) == 1) {
                                                echo 'checked="checked"';
                                            }
                                            ?>>YES</label>
                                        <label class="btn btn-default btn-off <?php
                                        if (printvalues('overtimestate', $employeevaluesprofile) == 0) {
                                            echo 'active';
                                        }
                                        ?>">
                                            <input type="radio" value="0" name="overtimestate" <?php
                                            if (printvalues('overtimestate', $employeevaluesprofile) == 0) {
                                                echo 'checked="checked"';
                                            }
                                            ?>>NO</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" >
                                <label class="col-sm-2 control-label" for="form-field-1">
                                    Penalise
                                </label>
                                <div class="col-sm-4">
                                    <div class="btn-group" id="status" data-toggle="buttons">
                                        <label class="btn btn-default btn-on <?php
                                        if (printvalues('penalisestate', $employeevaluesprofile) == 1) {
                                            echo 'active';
                                        }
                                        ?>">
                                            <input type="radio" value="1" name="penalisestate"  <?php
                                            if (printvalues('penalisestate', $employeevaluesprofile) == 1) {
                                                echo 'checked="checked"';
                                            }
                                            ?>>YES</label>
                                        <label class="btn btn-default btn-off <?php
                                        if (printvalues('penalisestate', $employeevaluesprofile) == 0) {
                                            echo 'active';
                                        }
                                        ?>">
                                            <input type="radio" value="0" name="penalisestate" <?php
                                            if (printvalues('penalisestate', $employeevaluesprofile) == 0) {
                                                echo 'checked="checked"';
                                            }
                                            ?>>NO</label>
                                    </div>
                                </div>
                                <label class="col-sm-2 control-label">
                                </label>
                                <div class="col-sm-4">
                                    <button class="btn btn-azure btn-sm submitBtn pull-right" type="submit" name="submit">
                                        Update&nbsp;
                                    </button>
                                </div>
                            </div>
                        </div>      
                    </form>
                </div>
            </div>
            <div class="panel panel-white">
                <div class="panel-heading">
                    <h5 class="panel-title">
                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" id="userexperience">
                            <i class="icon-arrow"></i> Experience
                        </a>
                    </h5>
                </div>
                <div id="collapseThree" class="collapse">
                    <p class="updatepersone"></p>
                    <form id="userexperienceform" role="form" method="post" class="form-horizontal" novalidate>
                        <input type="hidden"  id="id_employee" name="id_employee"  class="form-control" value="<?= printvalues('id', $employeevaluesprofile) ?>">
                        <div class="panel-body">
                            <div class="form-group" >
                                <div <?= hideorshow(array_keyvaluen($user_experience, 'organization')['status']) ?>>
                                    <label class="col-sm-2 control-label">
                                        Organization
                                    </label>
                                    <div class="col-sm-4">
                                        <input type="text" placeholder="Organization" id="organization" name="organization" class="form-control" value="<?= printvalues('organization', $checkuserexperience) ?>" >
                                    </div>
                                </div>
                                <div <?= hideorshow(array_keyvaluen($user_experience, 'jobtitle')['status']) ?>>
                                    <label class="col-sm-2 control-label">
                                        Job Title
                                    </label>
                                    <div class="col-sm-4">
                                        <input type="text" placeholder="Job Title" id="jobtitle" name="jobtitle" class="form-control" value="<?= printvalues('jobtitle', $checkuserexperience) ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" >
                                <div <?= hideorshow(array_keyvaluen($user_experience, 'fromexper')['status']) ?>>
                                    <label class="col-sm-2 control-label" for="form-field-1">
                                        From
                                    </label>
                                    <div class="col-sm-4">
                                        <input type="text" placeholder="DD-MM-YYYY" id="fromexper" name="fromexper" class="form-control"  value="<?= printvalues('fromexper', $checkuserexperience) ?>">
                                    </div>
                                </div>
                                <div <?= hideorshow(array_keyvaluen($user_experience, 'toexper')['status']) ?>>
                                    <label class="col-sm-2 control-label">
                                        To
                                    </label>
                                    <div class="col-sm-4">
                                        <input type="text" placeholder="DD-MM-YYYY" id="toexper" name="toexper" class="form-control"  value="<?= printvalues('toexper', $checkuserexperience) ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" >
                                <div <?= hideorshow(array_keyvaluen($user_experience, 'reasonforleaving')['status']) ?>>
                                    <label class="col-sm-2 control-label">
                                        Reason for Leaving
                                    </label>
                                    <div class="col-sm-4">
                                        <textarea id="reasonforleaving" name="reasonforleaving" class="form-control"><?= printvalues('reasonforleaving', $checkuserexperience) ?></textarea>
                                    </div>
                                </div>
                                <div <?= hideorshow(array_keyvaluen($user_experience, 'memo')['status']) ?>>
                                    <label class="col-sm-2 control-label">
                                        Memo
                                    </label>
                                    <div class="col-sm-4">
                                        <textarea id="memo" name="memo" class="form-control"><?= printvalues('memo', $checkuserexperience) ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" >
                                <div class="col-sm-12">
                                    <button class="btn btn-azure btn-sm submitBtn pull-right" type="submit" name="submit">
                                        Update&nbsp;
                                    </button>
                                </div>
                            </div>
                            <div class="form-group" >
                                <?php echo $this->load->view('company/hr/tablesprofile/table_experience', $data, TRUE); ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="panel panel-white">
                <div class="panel-heading">
                    <h5 class="panel-title">
                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapsextwo">
                            <i class="icon-arrow"></i>Next of Kin
                        </a>
                    </h5>
                </div>
                <div id="collapsextwo" class="panel-collapse collapse">
                    <p class="updatepersone"></p>
                    <form id="usernextofkinform" role="form" method="post" class="form-horizontal" novalidate>
                        <div class="panel-body">
                            <div class="form-group" >
                                <label class="col-sm-2 control-label">
                                    Name
                                </label>
                                <div class="col-sm-4">
                                    <input type="text" placeholder="Name" id="namenextkin" name="namenextkin" class="form-control"  value="<?= printvalues('namenextkin', $employeevaluesprofile) ?>">
                                </div>
                                <label class="col-sm-2 control-label">
                                    Organization
                                </label>
                                <div class="col-sm-4">
                                    <input type="text" placeholder="Organization" id="nextkinorganization" name="nextkinorganization" class="form-control"  value="<?= printvalues('nextkinorganization', $employeevaluesprofile) ?>">
                                </div>
                            </div>
                            <div class="form-group" >
                                <label class="col-sm-2 control-label">
                                    Job Title
                                </label>
                                <div class="col-sm-4">
                                    <input type="text" placeholder="Job Title" id="nextkinjobtitle" name="nextkinjobtitle" class="form-control"  value="<?= printvalues('nextkinjobtitle', $employeevaluesprofile) ?>">
                                </div>
                                <label class="col-sm-2 control-label">
                                    Memo
                                </label>
                                <div class="col-sm-4">
                                    <input type="text" placeholder="Memo" id="nextkinmemo" name="nextkinmemo" class="form-control"  value="<?= printvalues('nextkinmemo', $employeevaluesprofile) ?>">
                                </div>
                            </div>
                            <div class="form-group" >
                                <label class="col-sm-2 control-label">
                                    Relationship
                                </label>
                                <div class="col-sm-4">
                                    <input type="text" placeholder="Relationship" id="relationship" name="relationship" class="form-control"  value="<?= printvalues('relationship', $employeevaluesprofile) ?>">
                                </div>
                                <label class="col-sm-2 control-label">
                                    Profession
                                </label>
                                <div class="col-sm-4">
                                    <input type="text" placeholder="Profession" id="profession" name="profession" class="form-control"  value="<?= printvalues('profession', $employeevaluesprofile) ?>">
                                </div>
                            </div>
                            <div class="form-group" >
                                <label class="col-sm-2 control-label">
                                    Email
                                </label>
                                <div class="col-sm-4">
                                    <input type="text" placeholder="user@mail.com" id="nextkinemail" name="nextkinemail" class="form-control"  value="<?= printvalues('nextkinemail', $employeevaluesprofile) ?>">
                                </div>
                                <label class="col-sm-2 control-label">
                                    Cellphone
                                </label>
                                <div class="col-sm-4">
                                    <input type="text" placeholder="+254706161473" id="nextkincellphone" name="nextkincellphone" class="form-control"  value="<?= printvalues('nextkincellphone', $employeevaluesprofile) ?>">
                                </div>
                            </div>
                            <div class="form-group" >
                                <label class="col-sm-2 control-label">
                                    Postal Address
                                </label>
                                <div class="col-sm-4">
                                    <input type="text" placeholder="Postal Address" id="nextkinpostaladdress" name="nextkinpostaladdress" class="form-control"  value="<?= printvalues('nextkinpostaladdress', $employeevaluesprofile) ?>">
                                </div>
                                <label class="col-sm-2 control-label">
                                    Physical Address
                                </label>
                                <div class="col-sm-4">
                                    <input type="text" placeholder="Physical Address" id="nextkinphysicaladdress" name="nextkinphysicaladdress" class="form-control"  value="<?= printvalues('nextkinphysicaladdress', $employeevaluesprofile) ?>">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="panel panel-white">
                <div class="panel-heading">
                    <h5 class="panel-title">
                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapsexthree">
                            <i class="icon-arrow"></i>
                            Education
                        </a>
                    </h5>
                </div>
                <div id="collapsexthree" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="form-group" >
                            <label class="col-sm-2 control-label">
                                Course
                            </label>
                            <div class="col-sm-4">
                                <input type="text" placeholder="Course" id="nextkincourse" name="nextkincourse" class="form-control"  value="<?= printvalues('nextkincourse', $employeevaluesprofile) ?>">
                            </div>
                            <label class="col-sm-2 control-label">
                                Educational Level
                            </label>
                            <div class="col-sm-4">
                                <input type="text" placeholder="Educational Level" id="educationallevel" name="educationallevel" class="form-control"  value="<?= printvalues('educationallevel', $employeevaluesprofile) ?>">
                            </div>
                        </div>
                        <div class="form-group" >
                            <label class="col-sm-2 control-label">
                                Institution
                            </label>
                            <div class="col-sm-4">
                                <input type="text" placeholder="Institution" id="institution" name="institution" class="form-control"  value="<?= printvalues('institution', $employeevaluesprofile) ?>">
                            </div>
                            <label class="col-sm-2 control-label">
                                From
                            </label>
                            <div class="col-sm-4">
                                <input type="text"  id="educfrom" name="educfrom" class="form-control"  value="<?= printvalues('educfrom', $employeevaluesprofile) ?>">
                            </div>
                        </div>
                        <div class="form-group" >
                            <label class="col-sm-2 control-label">
                                To
                            </label>
                            <div class="col-sm-4">
                                <input type="text" id="educto" name="educto" class="form-control"  value="<?= printvalues('educto', $employeevaluesprofile) ?>">
                            </div>
                            <label class="col-sm-2 control-label">
                                Grade
                            </label>
                            <div class="col-sm-4">
                                <input type="text" id="grade" name="grade" class="form-control"  value="<?= printvalues('grade', $employeevaluesprofile) ?>">
                            </div>
                        </div>
                        <div class="form-group" >
                            <label class="col-sm-2 control-label">
                                Points
                            </label>
                            <div class="col-sm-4">
                                <input type="text" id="points" name="points" class="form-control"  value="<?= printvalues('points', $employeevaluesprofile) ?>">
                            </div>
                            <label class="col-sm-2 control-label">
                                Ranking
                            </label>
                            <div class="col-sm-4">
                                <input type="text" id="ranking" name="ranking" class="form-control"  value="<?= printvalues('ranking', $employeevaluesprofile) ?>">
                            </div>
                        </div>
                        <div class="form-group" >
                            <label class="col-sm-2 control-label">
                                Memo
                            </label>
                            <div class="col-sm-4">
                                <input type="text" id="educmemo" name="educmemo" class="form-control"  value="<?= printvalues('educmemo', $employeevaluesprofile) ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-white">
                <div class="panel-heading">
                    <h5 class="panel-title">
                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapsexfour">
                            <i class="icon-arrow"></i> Skills
                        </a>
                    </h5>
                </div>
                <div id="collapsexfour" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="form-group" >
                            <label class="col-sm-2 control-label">
                                Skill Category
                            </label>
                            <div class="col-sm-4">
                                <input type="text" id="skillcategory" name="skillcategory" class="form-control"  value="<?= printvalues('skillcategory', $employeevaluesprofile) ?>">
                            </div>
                            <label class="col-sm-2 control-label">
                                Skill
                            </label>
                            <div class="col-sm-4">
                                <input type="text" id="skill" name="skill" class="form-control"  value="<?= printvalues('skill', $employeevaluesprofile) ?>">
                            </div>
                        </div>
                        <div class="form-group" >
                            <label class="col-sm-2 control-label">
                                Description
                            </label>
                            <div class="col-sm-4">
                                <input type="text" id="skilldescription" name="skilldescription" class="form-control"  value="<?= printvalues('skilldescription', $employeevaluesprofile) ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-white">
                <div class="panel-heading">
                    <h5 class="panel-title">
                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapsexfive">
                            <i class="icon-arrow"></i>Documents
                        </a>
                    </h5>
                </div>
                <div id="collapsexfive" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="form-group" >
                            <label class="col-sm-2 control-label">
                                Document Name
                            </label>
                            <div class="col-sm-4">
                                <input type="text" id="document" name="document" class="form-control"  value="<?= printvalues('document', $employeevaluesprofile) ?>">
                            </div>
                            <label class="col-sm-2 control-label">
                                Select File
                            </label>
                            <div class="col-sm-4">
                                <input type="text" id="selectfile" name="selectfile" class="form-control"  value="<?= printvalues('selectfile', $employeevaluesprofile) ?>">
                            </div>
                        </div>
                        <div class="form-group" >
                            <label class="col-sm-2 control-label">
                                Ref No.
                            </label>
                            <div class="col-sm-4">
                                <input type="text" id="refno" name="refno" class="form-control"  value="<?= printvalues('refno', $employeevaluesprofile) ?>">
                            </div>
                            <label class="col-sm-2 control-label">
                                Description
                            </label>
                            <div class="col-sm-4">
                                <input type="text" id="docdescription" name="docdescription" class="form-control"  value="<?= printvalues('docdescription', $employeevaluesprofile) ?>">
                            </div>
                        </div>
                        <div class="form-group" >
                            <label class="col-sm-2 control-label">
                                Issued By
                            </label>
                            <div class="col-sm-4">
                                <input type="text" id="issuedby" name="issuedby" class="form-control"  value="<?= printvalues('issuedby', $employeevaluesprofile) ?>">
                            </div>
                            <label class="col-sm-2 control-label">
                                Issue Date
                            </label>
                            <div class="col-sm-4">
                                <input type="text" id="issuedate" name="issuedate" class="form-control"  value="<?= printvalues('issuedate', $employeevaluesprofile) ?>">
                            </div>
                        </div>
                        <div class="form-group" >
                            <label class="col-sm-2 control-label">
                                Expiry Date
                            </label>
                            <div class="col-sm-4">
                                <input type="text" id="expirydate" name="expirydate" class="form-control"  value="<?= printvalues('expirydate', $employeevaluesprofile) ?>">
                            </div>
                            <label class="col-sm-2 control-label">
                                Received Date
                            </label>
                            <div class="col-sm-4">
                                <input type="text" id="receiveddate" name="receiveddate" class="form-control"  value="<?= printvalues('receiveddate', $employeevaluesprofile) ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-white">
                <div class="panel-heading">
                    <h5 class="panel-title">
                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapsexsix">
                            <i class="icon-arrow"></i>Contacts
                        </a>
                    </h5>
                </div>
                <div id="collapsexsix" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="form-group" >
                            <div <?= hideorshow(array_keyvaluen($employee, 'postaladdress')['status']) ?>>
                                <label class="col-sm-2 control-label">
                                    Postal Address
                                </label>
                                <div class="col-sm-4">
                                    <input type="text" placeholder="Postal Address" id="postaladdress" name="postaladdress" class="form-control"  value="<?= printvalues('postaladdress', $employeevaluesprofile) ?>">
                                </div>
                            </div>
                            <label class="col-sm-2 control-label">
                                Street Address
                            </label>
                            <div class="col-sm-4">
                                <input type="text" id="streetaddress" name="streetaddress" class="form-control"  value="<?= printvalues('streetaddress', $employeevaluesprofile) ?>">
                            </div>
                        </div>
                        <div class="form-group" >
                            <div <?= hideorshow(array_keyvaluen($employee, 'postalcode')['status']) ?>>
                                <label class="col-sm-2 control-label" for="form-field-1">
                                    Postal Code
                                </label>
                                <div class="col-sm-4">
                                    <input type="text" placeholder="Postal Code" id="postalcode" name="postalcode" class="form-control"  value="<?= printvalues('postalcode', $employeevaluesprofile) ?>">
                                </div>
                            </div>
                            <div <?= hideorshow(array_keyvaluen($employee, 'town')['status']) ?>>
                                <label class="col-sm-2 control-label">
                                    Town
                                </label>
                                <div class="col-sm-4">
                                    <input type="text" placeholder="Town" id="town" name="town" class="form-control"  value="<?= printvalues('town', $employeevaluesprofile) ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group" >
                            <div <?= hideorshow(array_keyvaluen($employee, 'country')['status']) ?>>
                                <label class="col-sm-2 control-label" for="form-field-1">
                                    Country
                                </label>
                                <div class="col-sm-4">
                                    <input type="text" placeholder="Country" id="country" name="country" class="form-control"  value="<?= printvalues('country', $employeevaluesprofile) ?>">
                                </div>
                            </div>
                            <div <?= hideorshow(array_keyvaluen($employee, 'homephone')['status']) ?>>
                                <label class="col-sm-2 control-label">
                                    Home Phone
                                </label>
                                <div class="col-sm-4">
                                    <input type="text" placeholder="+254706161473" id="homephone" name="homephone" class="form-control"  value="<?= printvalues('homephone', $employeevaluesprofile) ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group" >
                            <div <?= hideorshow(array_keyvaluen($employee, 'cellphone')['status']) ?>>
                                <label class="col-sm-2 control-label" for="form-field-1">
                                    Cellphone
                                </label>
                                <div class="col-sm-4">
                                    <input type="text" placeholder="Cellphone" id="cellphone" name="cellphone" class="form-control"  value="<?= printvalues('cellphone', $employeevaluesprofile) ?>">
                                </div>
                            </div>
                            <label class="col-sm-2 control-label">
                                Work Telephone
                            </label>
                            <div class="col-sm-4">
                                <input type="text" placeholder="+254701161473" id="worktelephone" name="worktelephone" class="form-control"  value="<?= printvalues('worktelephone', $employeevaluesprofile) ?>">
                            </div>
                        </div>
                        <div class="form-group" >
                            <div <?= hideorshow(array_keyvaluen($employee, 'emailaddress')['status']) ?>>
                                <label class="col-sm-2 control-label" for="form-field-1">
                                    Email Address
                                </label>
                                <div class="col-sm-4">
                                    <input type="text" placeholder="Email Address" id="emailaddress" name="emailaddress" class="form-control"  value="<?= printvalues('emailaddress', $employeevaluesprofile) ?>">
                                </div>
                            </div>
                            <label class="col-sm-2 control-label">
                                Emergency Contact Person
                            </label>
                            <div class="col-sm-4">
                                <input type="text" id="emergencycontact" name="emergencyperson" class="form-control"  value="<?= printvalues('emergencyperson', $employeevaluesprofile) ?>">
                            </div>
                        </div>
                        <div class="form-group" >
                            <label class="col-sm-2 control-label" for="form-field-1">
                                Emergency Contact Cellphone
                            </label>
                            <div class="col-sm-4">
                                <input type="text" id="emergycontactcell" name="emergycontactcell" class="form-control"  value="<?= printvalues('emergycontactcell', $employeevaluesprofile) ?>">
                            </div>
                            <label class="col-sm-2 control-label">
                                Emergency Contact Relationship
                            </label>
                            <div class="col-sm-4">
                                <input type="text" id="emergyrelationship" name="emergyrelationship" class="form-control"  value="<?= printvalues('emergyrelationship', $employeevaluesprofile) ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-white">
                <div class="panel-heading">
                    <h5 class="panel-title">
                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapsexone">
                            <i class="icon-arrow"></i>Referees
                        </a>
                    </h5>
                </div>
                <div id="collapsexone" class="collapse">
                    <form id="referencesform" role="form" method="post" class="form-horizontal" novalidate>
                        <div class="panel-body">
                            <div class="form-group" >
                                <label class="col-sm-2 control-label" for="form-field-1">
                                    Name
                                </label>
                                <div class="col-sm-4">
                                    <input type="text" id="namerefre" name="namerefre" class="form-control"  value="<?= printvalues('namerefre', $employeevaluesprofile) ?>">
                                </div>
                                <label class="col-sm-2 control-label" for="form-field-1">
                                    Organization
                                </label>
                                <div class="col-sm-4">
                                    <input type="text" id="organizationrefre" name="organizationrefre" class="form-control"  value="<?= printvalues('organizationrefre', $employeevaluesprofile) ?>">
                                </div>
                            </div>
                            <div class="form-group" >
                                <label class="col-sm-2 control-label" for="form-field-1">
                                    Job Title
                                </label>
                                <div class="col-sm-4">
                                    <input type="text" id="jobtitlerefre" name="jobtitlerefre" class="form-control"  value="<?= printvalues('jobtitlerefre', $employeevaluesprofile) ?>">
                                </div>
                                <label class="col-sm-2 control-label" for="form-field-1">
                                    Profession
                                </label>
                                <div class="col-sm-4">
                                    <input type="text" id="professionrefre" name="professionrefre" class="form-control"  value="<?= printvalues('professionrefre', $employeevaluesprofile) ?>">
                                </div>
                            </div>
                            <div class="form-group" >
                                <label class="col-sm-2 control-label" for="form-field-1">
                                    Email
                                </label>
                                <div class="col-sm-4">
                                    <input type="text" id="emailrefre" name="emailrefre" class="form-control"  value="<?= printvalues('emailrefre', $employeevaluesprofile) ?>">
                                </div>
                                <label class="col-sm-2 control-label" for="form-field-1">
                                    Cellphone
                                </label>
                                <div class="col-sm-4">
                                    <input type="text" id="cellphonerefre" name="cellphonerefre" class="form-control"  value="<?= printvalues('cellphonerefre', $employeevaluesprofile) ?>">
                                </div>
                            </div>
                            <div class="form-group" >
                                <label class="col-sm-2 control-label" for="form-field-1">
                                    Postal Address
                                </label>
                                <div class="col-sm-4">
                                    <input type="text" id="postaladdressrefre" name="postaladdressrefre" class="form-control"  value="<?= printvalues('postaladdressrefre', $employeevaluesprofile) ?>">
                                </div>
                                <label class="col-sm-2 control-label" for="form-field-1">
                                    Physical Address
                                </label>
                                <div class="col-sm-4">
                                    <input type="text" id="physicaladdressrefre" name="physicaladdressrefre" class="form-control"  value="<?= printvalues('physicaladdressrefre', $employeevaluesprofile) ?>">
                                </div>
                            </div>
                            <div class="form-group" >
                                <label class="col-sm-2 control-label" for="form-field-1">
                                    Notes
                                </label>
                                <div class="col-sm-4">
                                    <textarea id="notesrefre" name="notesrefre" class="form-control"></textarea>
                                </div>
                                <label class="col-sm-2 control-label" for="form-field-1">
                                    Memo
                                </label>
                                <div class="col-sm-4">
                                    <textarea id="memofre" name="memofre" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

    var user = <?php echo json_encode($checkuserexperience); ?>;
    if (user.length !== 0) {
        var idtr = user.id_employee + user.organization + user.fromexper;
        var d = document.getElementById('' + idtr + '');
        d.className += "alert alert-success";
//        console.log(idtr);
    }
    window.onload = function () {
        var userprofileses = sessionStorage.getItem("useridprofile");
        var userexperience = sessionStorage.getItem("userexperiences");
        var workinfotab = sessionStorage.getItem("workinfotab");
        if (userprofileses) {
            sessionStorage.removeItem("useridprofile");
            var l = document.getElementById('link_tab_addclient');
            l.click();
        }
        if (userexperience) {
            sessionStorage.removeItem("userexperiences");
            var l = document.getElementById('userexperience');
            l.click();
        }
        if (workinfotab) {
            sessionStorage.removeItem("workinfotab");
            var l = document.getElementById('workinfotab');
            l.click();
        }
    };
    var getmebranches = "<?php echo base_url('humanr/loadbranch'); ?>";
    var branch_idn = document.getElementById("branch_idprofi");
    function checkselectedclientprofi() {
        //  console.log(branch_idn);
    }
    $(document).ready(function () {
        $('#employees_list_admin').DataTable({
//            dom: 'Bfrtip',
            retrieve: true,
            pageLength: 7
//            "paging": false,
//            "ordering": false,
//            "info": false
        });
        //Profile Summery Start
        postformdatajax("#userprofilesummeryform", 'submit', '<?= base_url('humanr/updateperson') ?>', '.statusMsg');
        validateinputtype("#file", '.statusMsg', '<span style="font-size:18px;color:#EA4335">Select a valid image file (JPEG/JPG/PNG).</span>', "image/jpeg", "image/png", "image/jpg");
        //Profile Summery End
        $('#dob')
                .datepicker({
                    format: 'dd-mm-yyyy'
                })
                .on('changeDate', function (e) {
                    // Revalidate the date field
                    $('#employeeprofileconfigtwo').formValidation('revalidateField', 'dob');
                });
        $('#dateterminated')
                .datepicker({
                    format: 'dd-mm-yyyy'
                })
                .on('changeDate', function (e) {
                    // Revalidate the date field
                    $('#employeeprofileconfigtwo').formValidation('revalidateField', 'dateterminated');
                });
        $('#dateemployeed')
                .datepicker({
                    format: 'dd-mm-yyyy'
                })
                .on('changeDate', function (e) {
                    // Revalidate the date field
                    $('#employeeprofileconfigtwo').formValidation('revalidateField', 'dateemployeed');
                });
        $('#dateofconfirmation')
                .datepicker({
                    format: 'dd-mm-yyyy'
                })
                .on('changeDate', function (e) {
                    // Revalidate the date field
                    $('#employeeprofileconfigone').formValidation('revalidateField', 'dateofconfirmation');
                });
        $('#fromexper')
                .datepicker({
                    format: 'dd-mm-yyyy'
                })
                .on('changeDate', function (e) {
                    // Revalidate the date field
                    $('#userexperienceform').formValidation('revalidateField', 'fromexper');
                });
        $('#toexper')
                .datepicker({
                    format: 'dd-mm-yyyy'
                })
                .on('changeDate', function (e) {
                    // Revalidate the date field
                    $('#userexperienceform').formValidation('revalidateField', 'toexper');
                });
        //FORM userexperienceform START
        $('#userexperienceform')
                .formValidation({
                    framework: 'bootstrap',
                    icon: {
                    },
                    fields: {
                        organization: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($user_experience, 'organization')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Organisation Is Required'
                                }
                            }
                        },
                        jobtitle: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($user_experience, 'jobtitle')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Job Title Is Required Required'
                                }
                            }
                        },
                        fromexper: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($user_experience, 'fromexper')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'From Date Is Required Required'
                                },
                                date: {
                                    format: 'DD-MM-YYYY',
                                    message: 'The date is not a valid'
                                }
                            }
                        }
                        ,
                        toexper: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($user_experience, 'toexper')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'To Date Is Required Required'
                                },
                                date: {
                                    format: 'DD-MM-YYYY',
                                    message: 'The date is not a valid'
                                }
                            }
                        }
                        ,
                        reasonforleaving: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($user_experience, 'reasonforleaving')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Reason For Leaving Is Required Required'
                                }
                            }
                        }
                        ,
                        memo: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($user_experience, 'memo')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Memo is Required'
                                }
                            }
                        }
                    }
                }).on('success.form.fv', function (e) {
//            console.log('people power');
            sessionStorage.setItem("userexperiences", 'added');
            postformdatajax("#userexperienceform", 'submit', '<?= base_url('humanr/userexperience') ?>', '.updatepersone');
//            validateinputtype("#file", '.updatepersone', '<span style="font-size:18px;color:#EA4335">Select a valid image file (JPEG/JPG/PNG).</span>', "image/jpeg", "image/png", "image/jpg");
        });
        //FORM userexperienceform END
        //Form 2
        $('#employeeprofileconfigone')
                .formValidation({
                    framework: 'bootstrap',
                    icon: {
                    },
                    fields: {
                        dateofconfirmation: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'dateofconfirmation')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Date Of Confirmation Is Required'
                                },
                                date: {
                                    format: 'DD-MM-YYYY',
                                    message: 'The date is not a valid'
                                }
                            }
                        },
                        jobstatus_id: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'jobstatus_id')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Job Status Is Required Required'
                                }
                            }
                        }, prevemployer: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'prevemployer')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Previous Employer Is Required Required'
                                }
                            }
                        },
                        nextemployer: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'nextemployer')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Next Employer Is Required Required'
                                }
                            }
                        }
                        ,
                        company_id: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'company_id')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Company is required'
                                }
                            }
                        }
                        ,
                        section_id: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'section_id')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Section is required'
                                }
                            }
                        },
                        branch_id: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'branch_id')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Company Branch Is Required'
                                }
                            }
                        },
                        region_id: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'region_id')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Region Is Required'
                                }
                            }
                        },
                        department_id: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'department_id')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Department Is Required Required'
                                }
                            }
                        },
                        jobgroup_id: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'jobgroup_id')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'JOB GROUP is required'
                                }
                            }
                        },
                        designation_id: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'designation_id')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Designation Is Required'
                                }
                            }
                        },
                        jobgrade_id: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'jobgrade_id')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Job Grade Is Required'
                                }
                            }
                        },
                        employmenttype_id: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'employmenttype_id')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Employement Type is required'
                                }
                            }
                        }
                        , attendence_shiftdef_id: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'attendence_shiftdef_id')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Shift Is Required'
                                }
                            }
                        }
                        , homephone: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'homephone')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Home Phone Is Required'
                                }
                            }
                        }
                        , manager_id: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'manager_id')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Manager Of This Employee is required'
                                }
                            }
                        }
                        ,
                        astmanager_id: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'astmanager_id')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Asst Manager is required'
                                }
                            }
                        }
                        ,
                        confirmationstatus: {
                            enabled: true,
                            validators: {
                                notEmpty: {
                                    message: 'Confirmation Status is required'
                                }
                            }
                        }
                    }
                }).on('success.form.fv', function (e) {
//            console.log('people power');
            postformdatajax("#employeeprofileconfigone", 'submit', '<?= base_url('humanr/updateworkinfo') ?>', '.updatepersone');
            sessionStorage.setItem("workinfotab", 'added');
//            validateinputtype("#file", '.updatepersone', '<span style="font-size:18px;color:#EA4335">Select a valid image file (JPEG/JPG/PNG).</span>', "image/jpeg", "image/png", "image/jpg");
        });
        //Form 2 End
        $('#employeeprofileconfigtwo')
                .formValidation({
                    framework: 'bootstrap',
                    icon: {
                    },
                    fields: {
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
                        firstname: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'firstname')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'First Name  Is Required Required'
                                }
                            }
                        }, middlename: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'middlename')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Middle Name  Is Required Required'
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
                        },
                        staffno: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'staffno')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Staff  No is required'
                                }
                            }
                        },
                        nhifnumber: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'nhifnumber')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'NHIF Number  Is Required'
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
                        },
                        idnumber: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'idnumber')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'ID Number  Is Required Required'
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
                        maritalstatus_id: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'maritalstatus_id')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Marital Status  Is Required'
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
                        cellphone: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'cellphone')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'The Telephone Number is required'
                                },
                                numeric: {
                                    message: 'Enter Valid Contact Number format E.g 254735973206'
                                }
                            }
                        }
                        , dateemployeed: {
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
                        }
                        , dateterminated: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'dateterminated')['mandatory']) ?>)),
                            validators: {
                                date: {
                                    format: 'DD-MM-YYYY',
                                    message: 'The date is not a valid'
                                }
                            }
                        }
                        , drivinflicense: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'drivinflicense')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Driving License Is Required'
                                }
                            }
                        }
                        , yearsofservice: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'yearsofservice')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Years of Service Is Required'
                                },
                                numeric: {
                                    message: 'Numbers are only numbers'
                                }
                            }
                        }
                        , ethnicity: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'ethnicity')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Ethinicity Is Required'
                                }
                            }
                        }
                        , emailaddress: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($employee, 'emailaddress')['mandatory']) ?>)),
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
            postformdatajax("#employeeprofileconfigtwo", 'submit', '<?= base_url('humanr/updatepersonbiodata') ?>', '.updatepersone');
            validateinputtype("#file", '.updatepersone', '<span style="font-size:18px;color:#EA4335">Select a valid image file (JPEG/JPG/PNG).</span>', "image/jpeg", "image/png", "image/jpg");
        });
        //Form Two
    }
    );
    function postformdatajax(formid, actioncalling, url, message) {
        $(formid).on(actioncalling, function (e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                dataType: "JSON",
                url: url,
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function () {
                    $('.submitBtn').attr("disabled", "disabled");
                    $(formid).css("opacity", ".5");
                },
                success: function (msg) {
                    console.log(msg);
                    $(message).html('');
                    if (msg.state === 'ok') {
                        $(formid)[0].reset();
//                        $(message).html('<span style="font-size:18px;color:#34A853">' + msg.message + '</span>');
                        sessionStorage.setItem("useridprofile", 'yes');
                        location.reload();
                    } else {
                        $(message).html('<span style="font-size:18px;color:#EA4335">' + msg.message + '</span>');
                    }
                    $(formid).css("opacity", "");
                    $(".submitBtn").removeAttr("disabled");
                }
            });
        });
    }
    function validateinputtype(validateid, wheremessage, message, ...args) {
        $(wheremessage).html('');
        $(validateid).change(function () {
            $(wheremessage).html('');
            var file = this.files[0];
            var imagefile = file.type;
            var match = args;
            if (!((imagefile === match[0]) || (imagefile === match[1]) || (imagefile === match[2]))) {
                $(wheremessage).html(message);
                $(validateid).val('');
                return false;
            }
        });
    }
</script>