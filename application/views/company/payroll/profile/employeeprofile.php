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