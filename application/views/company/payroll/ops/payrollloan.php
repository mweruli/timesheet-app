<?php
if (empty($employeevaluesprofile)) {
    $employeevaluesprofile = array();
}
$employee = $controller->gettablecolumns('users');
$user_experience = $controller->gettablecolumns('user_experience');
$userdepartments = $controller->allselectablebytablewhere('departments', 'id', printvalues('department_id', $employeevaluesprofile));
if (!empty($userdepartments)) {
    $departments = printvalues('department', $userdepartments[0]);
} else {
    $departments = 'Update';
}
//department_id
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
                            <td>Emp No:</td>
                            <td>
                                <a href="#">
                                    <?= printvalues('employee_code', $employeevaluesprofile) ?>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>Employee Name:</td>
                            <td>
                                <a href="">
                                    <?= printvalues('firstname', $employeevaluesprofile) ?>&nbsp;<?= printvalues('middlename', $employeevaluesprofile) ?>&nbsp;<?= printvalues('lastname', $employeevaluesprofile) ?>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>Cellphone:</td>
                            <td><?= printvalues('cellphone', $employeevaluesprofile) ?></td>
                        </tr>
                        <tr>
                            <td>PIN Number:</td>
                            <td>
                                <a href="">
                                    <?= printvalues('pin', $employeevaluesprofile) ?>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>ID Number:</td>
                            <td>
                                <a href="">
                                    <?= printvalues('employee_code', $employeevaluesprofile) ?>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>NSSF Number:</td>
                            <td>
                                <a href="">
                                    <?= printvalues('nssfnumber', $employeevaluesprofile) ?>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>NHIF Number:</td>
                            <td>
                                <a href="">
                                    <?= printvalues('nhifnumber', $employeevaluesprofile) ?>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>Department:</td>
                            <td>
                                <a href="">
                                    <?= $departments; ?>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>
                                <span class="label label-sm label-info"> <?php
                                    if (printvalues('category', $employeevaluesprofile) == '') {
                                        echo 'Employee';
                                    } else {
//                                        print_array($employeevaluesprofile);
                                        echo printvalues('category', $employeevaluesprofile);
                                    }
                                    ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
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
                            <i class="icon-arrow"></i>Payments
                        </a>
                    </h5>
                </div>
                <div id="collapseOne" class="collapse in">
                    <p class="updatepersone"></p>
                    <form id="employeeprofileconfigtwo" role="form" method="post" class="form-horizontal" enctype="multipart/form-data" novalidate>
                        <div class="panel-body">
                            <div class="form-group" >


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
                            </div>
                            <div class="form-group" ></div>
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
                        <div class="panel-body">
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

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>