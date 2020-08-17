<?php
$attributes = array(
    'role' => 'form',
    'id' => "form_edituserdd",
    'method' => "post"
);
//echo form_open_multipart(base_url('authentication/updateprofile'), $attributes);
?>
<form role="form" id="form_edituser" method="post" enctype="multipart/form-data" accept-charset="utf-8">
    <div class="row">
        <div class="col-md-12">
            <h3>Account Info</h3>
            <hr>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label">
                    First Name
                </label>
                <input type="text" placeholder="first name" class="form-control" id="firstname" name="firstname" value="<?= $this->session->userdata('logged_in')['firstname'] ?>" 
                <?php
                if ($category == 'employee') {
                    echo 'readonly="readonly"';
                }
                ?>>
            </div>
            <div class="form-group">
                <label class="control-label">
                    Last Name
                </label>
                <input type="text" placeholder="lastname" class="form-control" id="lastname" name="lastname" value="<?= $this->session->userdata('logged_in')['lastname'] ?>"
                <?php
                if ($category == 'employee') {
                    echo 'readonly="readonly"';
                }
                ?>>
            </div>
            <div class="form-group">
                <label class="control-label">
                    Email Address
                </label>
                <input type="email" placeholder="email" class="form-control" id="email_value" name="email_value" value="<?= $this->session->userdata('logged_in')['emailaddress'] ?>"
                <?php
                if ($category == 'employee') {
                    echo 'readonly="readonly"';
                }
                ?>>
            </div>
            <div class="form-group">
                <label class="control-label">
                    Phone
                </label>
                <input type="text" placeholder="phone number" class="form-control" id="phone" name="phone" value="<?= $this->session->userdata('logged_in')['cellphone'] ?>"
                <?php
                if ($category == 'employee') {
                    echo 'readonly="readonly"';
                }
                ?>>
            </div>
            <div class="form-group">
                <label class="control-label">
                    Password
                </label>
                <input type="password" placeholder="password" class="form-control" name="password" id="password">
            </div>
            <div class="form-group">
                <label class="control-label">
                    Confirm Password
                </label>
                <input type="password"  placeholder="password" class="form-control" id="password_again" name="password_again">
            </div>
        </div>
        <?php
        if ($category != 'employee') {
            ?>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">
                        EMPLOYMENT TYPE
                    </label>
                    <div>
                        <label><?= $utilsetting[0]['design'] ?></label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">
                                Date of Birth
                            </label>
                            <input class="form-control"  type="text" name="date_of_birth" id="date_of_birth" readonly="readonly" value="<?= $this->session->userdata('logged_in')['dob'] ?>">
                        </div>
                    </div>
                    <div class="col-md-12" hidden="true">
                        <div class="form-group">
                            <label class="control-label">
                                Old Image Name
                            </label>
                            <input class="form-control"  type="text" name="user_imagex" id="user_imagex" value="<?= $this->session->userdata('logged_in')['user_image_small'] ?>">
                            <input class="form-control"  type="text" name="id" id="id" value="<?= $this->session->userdata('logged_in')['id'] ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div>
                        Click On Profile Image To Upload A New One
                        <div>
                            <img id="uploadPreview" src="<?= base_url() ?>upload/<?= $this->session->userdata('logged_in')['user_image_medium'] ?>" alt="Click Here To Upload" onclick="Call_Uploader()" height="100" width="100">
                            <br><br>
                            <h6 class="error"><?php echo ($this->session->flashdata('user_profile_pic')) ?></h6>
                            <input id="user_profile_pic" class="hidden" type="file" name="user_profile_pic" onChange="PreviewImage();" placeholder="Profile Picture" />
                            <script type="text/javascript">
                                function PreviewImage() {
                                    var oFReader = new FileReader();
                                    oFReader.readAsDataURL(document.getElementById("user_profile_pic").files[0]);
                                    oFReader.onload = function (oFREvent) {
                                        document.getElementById("uploadPreview").src = oFREvent.target.result;
                                        //document.getElementById("uploadImage").disabled = true
                                    };
                                }
                                ;
                                function Call_Uploader() {
                                    $('#user_profile_pic').click();
                                }
                            </script>
                        </div>
                    </div>
                </div>
                <div class="form-group connected-group">
                    <label class="control-label">
                        <h3>Update Employment Type?</h3>
                    </label>
                    <div class="row">
                        <div class="col-md-9">
                            <select  id="form-field-select-4" class="form-control search-select" placeholder="Select employmenttype_ids" name="employmenttype_id_employee" id="employmenttype_id_employee">
                                <option value="">-SELECT Employment Type-</option>
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
                </div>
                <br>
            </div>
            <?php
        }
        ?>
    </div>
    <br>
    <div class="row">
        <div class="col-md-4">
            <p>
                By clicking UPDATE, you are agreeing to the Policy Terms &amp; Conditions.
            </p>
        </div>
        <div class="col-md-8">
            <button class="btn btn-sm btn-green btn-block" type="submit">
                Update <i class="fa fa-arrow-circle-right"></i>
            </button>
        </div>
    </div>
</form>
<script>
    var url_update_user = '<?php echo base_url("authentication/updateprofile"); ?>';
    $(document).ready(function () {
        $('#form_edituser')
                .formValidation({
                    framework: 'bootstrap',
                    icon: {
                        valid: 'glyphicon glyphicon-ok',
                        invalid: 'glyphicon glyphicon-remove',
                        validating: 'glyphicon glyphicon-refresh'
                    },
                    fields: {
                        firstname: {
                            validators: {
                                notEmpty: {
                                    message: 'The First Name is required'
                                },
                                regexp: {
                                    regexp: /^[a-zA-Z\s]+$/,
                                    message: 'The full name can only consist of alphabetical characters'
                                }
                            }
                        },
                        lastname: {
                            validators: {
                                notEmpty: {
                                    message: 'Last name is required'
                                },
                                regexp: {
                                    regexp: /^[a-zA-Z\s]+$/,
                                    message: 'The full name can only consist of alphabetical characters'
                                }
                            }
                        },
                        email_value: {
                            validators: {
                                notEmpty: {
                                    message: 'The email address is required'
                                },
                                emailAddress: {
                                    message: 'The email address is not valid'
                                }
                            }
                        },
                        phone: {
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
                        password: {
                            validators: {
                                identical: {
                                    field: 'password_again',
                                    message: 'The password and its confirm are not the same'
                                }
                            }
                        },
                        password_again: {
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

                    // The url and method might be different in your application
                    $.ajax({
                        url: url_update_user,
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
//                            alert(JSON.stringify(response));
//                            $('#form_edituser').formValidation('resetForm', true);
                            $.notify(response.report, "success");
                            setTimeout(function () {
                                reloadeditaccount();
                            }, 2000);
                        }
                    });
                });
    });
    function reloadeditaccount() {
        sessionStorage.setItem("reloadeditaccount", "true");
        document.location.reload();
    }
    window.onload = function () {
        var editaccount = sessionStorage.getItem("reloadeditaccount");
        if (editaccount) {
            sessionStorage.removeItem("reloadeditaccount");
            myreloadeditaccount('hey');
        }
    }
    function myreloadeditaccount(varia) {
        var l = document.getElementById('id_editaccount');
        l.click();
    }
</script>