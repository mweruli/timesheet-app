<div id="listemployeestable" class="panel-body">
    <table class="table table-striped table-hover" id="employees_list_admin">
        <thead>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($all_employees as $value) {
                ?>
                <tr>
                    <td class="center"><img src="<?= base_url() ?>upload/<?= $value['user_image_small'] ?>" class="img-circle" alt="<?= $value['emailaddress'] ?>" height="40" width="40"/></td>
                    <td>
                        <span class="text-small block text-light">
                            <?= $value['design'] ?>
                        </span>
                        <span class="text-large"><?= $value['firstname'] . " " . $value['lastname'] ?></span>
                        <a href="#" onclick="viewsingleemployee('<?= $value['user_id'] ?>')" class="btn">
                            <i class="fa fa-eye"></i>
                        </a>
                    </td>
                    <td class="center"><?= $value['emailaddress'] ?></td>
                    <td class="center"><?= $value['cellphone'] ?></td>
                    <td class="center"><?= $value['id_gender'] ?></td>
                    <td class="center">
                        <div>
                            <div class="btn-group">
                                <a class="btn btn-transparent-grey dropdown-toggle btn-sm" data-toggle="dropdown" href="#">
                                    <i class="fa fa-cog"></i> <span class="caret"></span>
                                </a>
                                <ul role="menu" class="dropdown-menu dropdown-dark pull-right">
                                    <li role="presentation">
                                        <a role="menuitem" tabindex="-1" onclick="viewsing('<?= $value['id'] ?>')" href="#" data-id="<?= $value['id'] ?>" id="<?php echo 'edit_profile' . $value['id']; ?>">
                                            <i class="fa fa-pencil"></i> Edit Profile/View
                                        </a>
                                    </li>
                                    <li role="presentation">
                                        <a role="menuitem" tabindex="-1" onclick="deleteuser('<?= $value['id'] ?>', '<?= $value['firstname'] . " " . $value['lastname'] ?>', '<?= $value['emailaddress'] ?>', '<?= $value['cellphone'] ?>', '<?= $value['user_id'] ?>')" href="#" data-id="<?= $value['id'] ?>" >
                                            <i class="fa fa-times"></i> Delete Employee
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
</div>
<!--style="display: none;"-->
<form id="userForm" class="form-horizontal" method="post" enctype="multipart/form-data" accept-charset="utf-8" action="<?= base_url("authentication/edittabledatatwo") ?>" style="display: none;">
    <div class="form-group">
        <div class="col-sm-5 col-xs-offset-1">
            <div class="alert alert-block alert-info fade in">
                <h4 class="alert-heading"><i class="fa fa-info"></i> Info!</h4>
                <p id="more_info">

                </p>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="fileupload fileupload-new" data-provides="fileupload">
                <div class="fileupload-new thumbnail"><img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA?text=no+image" alt="" id="pic1"/>
                </div>
                <div class="fileupload-preview fileupload-exists thumbnail"></div>
                <div>
                    <span class="btn btn-light-grey btn-file"><span class="fileupload-new"><i class="fa fa-picture-o"></i> Select image</span><span class="fileupload-exists"><i class="fa fa-picture-o"></i> Change</span>
                        <input type="file" name="user_profile_pic" id="userimage">
                    </span>
                    <a href="#" class="btn fileupload-exists btn-light-grey" data-dismiss="fileupload">
                        <i class="fa fa-times"></i> Remove
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group" hidden="true">
        <label class="col-xs-3 control-label" for="form-field-1">
            ID
        </label>
        <div class="col-xs-8">
            <input type="text" class="form-control" name="id" id="id" hidden="true"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-xs-3  control-label">User ID</label>
        <div class="col-xs-8">
            <input type="text" class="form-control" name="user_idemployelist" id="user_idemployelist" readonly="readonly"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-xs-3 control-label" for="form-field-1">
            Email
        </label>
        <div class="col-xs-8">
            <input type="text" class="form-control" name="employee_email" id="employee_email"/>
        </div>
    </div>
    <div class="form-group" hidden="true">
        <label class="col-xs-3 control-label" for="form-field-1">
            Email Old
        </label>
        <div class="col-xs-8">
            <input type="text" class="form-control" name="employee_email_old" id="employee_email_old" hidden="true"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-xs-3 control-label" for="form-field-1">
            Phone Number
        </label>
        <div class="col-xs-8">
            <input type="text" class="form-control" name="phone_number" id="phone_number"/>
        </div>
    </div>
    <div class="form-group" hidden="true">
        <label class="col-xs-3 control-label" for="form-field-1">
            Phone Number Old
        </label>
        <div class="col-xs-8">
            <input type="text" class="form-control" name="phone_number_old" id="phone_number_old" hidden="true"/>
        </div>
    </div>
    <div class="form-group" hidden="true">
        <label class="col-xs-3 control-label" for="form-field-1">
            Image Name
        </label>
        <div class="col-xs-8">
            <input type="text" class="form-control" name="user_imagex" id="user_imagex" hidden="true"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-xs-3 control-label" for="form-field-1">
            First Name
        </label>
        <div class="col-xs-8">
            <input type="text" class="form-control" name="first_name" id="first_name" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-xs-3 control-label" for="form-field-1">
            Last Name
        </label>
        <div class="col-xs-8">
            <input type="text" class="form-control" name="last_name" id="last_name" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-xs-3 control-label" for="form-field-1">
            Update employmenttype_id?
        </label>
        <div class="col-xs-8">
            <select  class="form-control search-select" placeholder="Select employmenttype_ids" name="employmenttype_id_employee" id="employmenttype_id_employee">
                <option value="">-SELECT employmenttype_id-</option>
                <?php
                foreach ($skill_items as $value) {
                    ?>
                    <option value="<?= $value['id'] ?>"><?= $value['design'] ?></option>
                    <?php
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-xs-3 control-label" for="form-field-1">
            Update Supervisor?
        </label>
        <div class="col-xs-8">
            <select  class="form-control search-select" placeholder="Select Supervisor" name="supervisor_employee" id="supervisor_employee">
                <option value="">-SELECT SUPERVISOR-</option>
                <?php
                foreach ($supervisors as $value) {
                    ?>
                    <option value="<?= $value['id'] ?>"><?= $value['firstname'] . ' ' . $value['lastname'] . ' # ' . $value['emailaddress'] ?></option>
                    <?php
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-xs-3 control-label" for="form-field-1">
            Password
        </label>
        <div class="col-xs-8">
            <input type="password" class="form-control" name="password" name="password" id="password"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-xs-3 control-label" for="form-field-1">
            Confirm Password
        </label>
        <div class="col-xs-8">
            <input type="password" class="form-control" name="re_password" id="re_password" />
        </div>
    </div>
    <div class="form-group">
        <div class="col-xs-4 col-xs-offset-7">
            <button class="btn btn-green btn-block" type="submit">
                Update <i class="fa fa-arrow-circle-right"></i>
            </button>
        </div>
    </div>
</form>
<script>
    var url_edituser = '<?php echo base_url("employee/edittabledata/"); ?>';
    var url_edituser_two = '<?php echo base_url("authentication/edittabledatatwo"); ?>';
    var url_picture = '<?= base_url() ?>upload/';
    $(document).ready(function () {
        //Data Table Initialised
        //$('p').append('');
        $('#employees_list_admin').DataTable({
            "pageLength": 7
//            "paging": false,
//            "ordering": false,
//            "info": false
        });
//        $('#employees_list_admin').DataTable();
        //valudations and on success
        $('#userForm')
                .formValidation({
                    framework: 'bootstrap',
                    icon: {
                        valid: 'glyphicon glyphicon-ok',
                        invalid: 'glyphicon glyphicon-remove',
                        validating: 'glyphicon glyphicon-refresh'
                    },
                    fields: {
                        first_name: {
                            validators: {
                                notEmpty: {
                                    message: 'First name is required'
                                },
                                regexp: {
                                    regexp: /^[a-zA-Z\s]+$/,
                                    message: 'First name can only consist of alphabetical characters'
                                }
                            }
                        },
                        last_name: {
                            validators: {
                                notEmpty: {
                                    message: 'Last name is required'
                                },
                                regexp: {
                                    regexp: /^[a-zA-Z\s]+$/,
                                    message: 'Last name can only consist of alphabetical characters'
                                }
                            }
                        },
                        phone_number: {
                            validators: {
                                notEmpty: {
                                    message: 'Contact Number is required'
                                },
                                regexp: {
                                    regexp: /^[0-9,+]{13}$/,
                                    message: 'Enter Valid Contact Number format +254735973206'
                                }
                            }
                        },
                        employee_email: {
                            validators: {
                                notEmpty: {
                                    message: 'The email address is required'
                                },
                                emailAddress: {
                                    message: 'The email address is not valid'
                                }
                            }
                        },
                        password: {
                            validators: {
                                identical: {
                                    field: 're_password',
                                    message: 'The password and its confirm are not the same'
                                }
                            }
                        },
                        re_password: {
                            validators: {
                                identical: {
                                    field: 'password',
                                    message: 'The password and its confirm are not the same'
                                }
                            }
                        }
                    }
                })
                .on('success.form.fv', function (e) {
                    // Save the form data via an Ajax request
                    e.preventDefault();
                    var $form = $(e.target),
                            id = $form.find('[name="id"]').val();
                    //alert(id);
                    // The url and method might be different in your application
                    $.ajax({
                        url: url_edituser_two,
                        type: $(this).attr("method"),
                        dataType: "JSON",
                        data: new FormData(this),
                        processData: false,
                        contentType: false
                    }).done(function (response) {
                        if (response.status === 1) {
//                    $.notify(response.report);
                            $.notify(response.report, "error");
                        } else {
                            $('#userForm').formValidation('resetForm', true);
                            $.notify(response.report, "success");
                            setTimeout(location.reload.bind(location), 1200);
//                            $("#form_edituser").load(location.href + " #form_edituser");
                            //var l = document.getElementById('addemployee_link');
                            //l.click();
//                    $.notify(response.report);
                        }
                    });
                });
    });

    function viewsing(id) {
//        var id = $(this).attr('data-id');
        $("#more_info").html("");
        //$('p').append('fffff');
        $.ajax({
            url: url_edituser + id,
            dataType: "JSON",
            method: 'GET'
        }).done(function (response) {
//                alert(response.id);
//                alert(JSON.stringify(response));
            $("#pic1").attr("src", url_picture + response.user_image_big);
            $("#more_info").append('<span id="add_here">' + response.employmenttype_id + '<br>Supervisor: ' + response.supervisor_names + '<br>Date Hired: ' + response.dateemployeed + '<br>Validated' + '</span>');
//                $('p').append('<span id="add_here">' + response.employmenttype_id + '<br>Supervisor: ' + response.supervisor_names + '<br>Date Hired: ' + response.dateemployeed + '<br>Validated' + '</span>');
            // Populate the form fields with the data returned from server
            $('#userForm')
                    .find('[name="id"]').val(response.id).end()
                    .find('[name="user_idemployelist"]').val(response.user_id).end()
                    .find('[name="employee_email"]').val(response.emailaddress).end()
                    .find('[name="employee_email_old"]').val(response.emailaddress).end()
                    .find('[name="first_name"]').val(response.firstname).end()
                    .find('[name="last_name"]').val(response.lastname).end()
                    .find('[name="employmenttype_id"]').val(response.employmenttype_id).end()
                    .find('[name="employmenttype_id_employee"]').val(response.employmenttype_id).end()
                    .find('[name="user_imagex"]').val(response.user_image_small).end()
                    .find('[name="phone_number_old"]').val(response.cellphone).end()
                    .find('[name="phone_number"]').val(response.cellphone).end();
            // Show the dialog
            bootbox
                    .dialog({
                        title: 'Edit User Profile ',
                        message: $('#userForm'),
                        show: false // We will show it manually later
                    })
                    .on('shown.bs.modal', function () {
                        $('#userForm')
                                .show()                             // Show the login form
                                .formValidation('resetForm'); // Reset form
                    })
                    .on('hide.bs.modal', function (e) {
                        // Bootbox will remove the modal (including the body which contains the login form)
                        // after hiding the modal
                        // Therefor, we need to backup the form
                        $('#userForm').hide().appendTo('body');
                    })
                    .modal('show');
        });
    }
    function viewsingleemployeex(user_id) {
        alert(user_id);
    }
    function viewsingleemployee(user_id) {
        var url_setmeoneemployee = '<?php echo base_url("employee/setmeoneemployee"); ?>';
        $.ajax({
            url: url_setmeoneemployee,
            dataType: "JSON",
            method: 'POST',
            data: jQuery.param({user_id: user_id}),
        }).done(function (response) {
            reloadpp();
//            location.reload();
//            mama();
//            var l = document.getElementById('link_viewemployeemm');
//            l.click();
        });

    }
    var userdelete = '<?php echo base_url("employee/deleteuser"); ?>';
    function deleteuser(id, username, useremail, cellphone, user_id) {
        var dialog = bootbox.dialog({
            title: 'Confirm  Deletion Of : ' + '<b>' + username + '</b>',
            message: "<p>" + 'Names :' + username + '<br>Email :' + "<h4>" + useremail + "</h4>" + 'Contact :' + cellphone + "</p>",
            buttons: {
                cancel: {
                    label: '<i class="fa fa-check"></i> Delete',
                    className: 'btn-danger',
                    callback: function () {
                        $.post(userdelete,
                                {
                                    id: id,
                                    user_id: user_id
                                },
                                function (data, status) {
                                    $.notify(username + " Deleted Successfully", "success");
                                    setTimeout(location.reload.bind(location), 1200);
                                });
                    }
                },
                ok: {
                    label: '<i class="fa fa-times"></i> Cancel',
                    className: 'btn-info'
                }
            }
        });
    }
</script>