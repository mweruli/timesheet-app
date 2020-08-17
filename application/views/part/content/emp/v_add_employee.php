<?php
//print_array($skill_list_one);
?>
<div class="row" id="add_employeediv">
    <div class="col-sm-12">
        <!-- start: TEXT FIELDS PANEL -->
        <div class="panel panel-white">
            <div class="panel-heading">
                <h4 class="panel-title">Add <span class="text-bold">New Employee</span></h4>
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
                <form id="add_employee" method="post" class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Employee Photo
                        </label>
                        <div class="col-sm-9">
                            <img id="uploadPreview"  src="http://www.placehold.it/200x150/EFEFEF/AAAAAA?text=no+image" onclick="Call_Uploader()" width="300" height="200" />
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
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Names
                        </label>
                        <div class="col-sm-5">
                            <input type="text" placeholder="First Name" name="firstname_client" id="firstname_client" class="form-control">
                        </div>
                        <div class="col-sm-4">
                            <input type="text" placeholder="Last Name" id="lastname_client" name="lastname_client" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Employee Number
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="Employee Number" id="employee_number" name="employee_number" class="form-control" value="<?= get_random_password(6, 8, true, true, false) ?>" readonly="readonly">
                        </div>
                        <label class="col-sm-1 control-label" for="form-field-1">
                            Gender
                        </label>
                        <div class="col-sm-3">
                            <label class="radio-inline">
                                <input type="radio" value="Male" name="optionsRadios" >
                                Male
                            </label>
                            <label class="radio-inline">
                                <input type="radio" value="Female" name="optionsRadios">
                                Female
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Email
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="Employee Email" id="email_employee" name="email_employee" class="form-control">
                        </div>
                        <label class="col-sm-1 control-label">
                            Contact
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="Employee Contact" name="contact_employee" id="contact_employee" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Date of Birth
                        </label>
                        <div class="col-sm-4 date">
                            <div class="input-group input-append date" id="date_of_birthemployee">
                                <input type="text"  name="date_of_birthemployee" class="form-control">
                                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                        </div>
                        <label class="col-sm-1 control-label">
                            Date Hired
                        </label>
                        <div class="col-sm-4 date">
                            <div class="input-group input-append date" id="date_of_employement">
                                <input type="text"  class="form-control" name="date_of_employement">
                                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="form-field-1">
                            Designation
                        </label>
                        <div class="col-sm-9">
                            <select  id="form-field-select-4" class="form-control search-select" placeholder="Select employmenttype_ids" name="employmenttype_id_employee" id="employmenttype_id_employee">
                                <option value="">-SELECT DESIGNATION-</option>
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
                    <?php
                    $category = $this->session->userdata('logged_in')['category'];
                    if ($category == "suadmin") {
                        echo '<div class="form-group">
                        <label class="col-sm-2 control-label">
                            User Category
                        </label>
                        <div class="col-sm-4">
                            <label class="radio-inline">
                                <input type="radio" value="admin" name="category" >
                                Admin
                            </label>
                            <label class="radio-inline">
                                <input type="radio" value="employee" name="category">
                                Employee
                            </label>
                            <label class="radio-inline">
                                <input type="radio" value="suadmin" name="category">
                                Super Admin
                            </label>
                        </div> 
                    </div>';
                    } else {
                        echo '<div class="form-group hidden">
                        <label class="col-sm-2 control-label">
                            User Category
                        </label>
                        <div class="col-sm-9">
                            <input type="text"  name="category" id="category" class="form-control" value="employee">
                        </div>
                        </div>';
                    }
                    ?>
                    <br>
                    <div class="form-group">
                        <div class="panel-body">
                            <p>
                                <button class="btn btn-blue btn-block" type="submit">
                                    Add Employee<i class="fa fa-arrow-circle-right"></i>
                                </button>
                            </p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- end: TEXT FIELDS PANEL -->
    </div>
</div>
<script>
    var url_addemployee = "<?php echo base_url("employee/addemployee"); ?>";
    $(document).ready(function () {
        $('#date_of_employement')
                .datepicker({
                    format: 'dd-mm-yyyy'
                })
                .on('changeDate', function (e) {
                    // Revalidate the date field
                    $('#add_employee').formValidation('revalidateField', 'date_of_employement');
                });
        $('#date_of_birthemployee')
                .datepicker({
                    format: 'dd-mm-yyyy'
                })
                .on('changeDate', function (e) {
                    // Revalidate the date field
                    $('#add_employee').formValidation('revalidateField', 'date_of_birthemployee');
                });
        $('#add_employee')
                .formValidation({
                    framework: 'bootstrap',
                    icon: {
                        valid: 'glyphicon glyphicon-ok',
                        invalid: 'glyphicon glyphicon-remove',
                        validating: 'glyphicon glyphicon-refresh'
                    },
                    fields: {
                        firstname_client: {
                            validators: {
                                notEmpty: {
                                    message: 'First Name is required'
                                },
                                regexp: {
                                    regexp: /^[a-zA-Z\s]+$/,
                                    message: 'First Name can only consist of alphabetical characters'
                                }
                            }
                        },
                        lastname_client: {
                            validators: {
                                notEmpty: {
                                    message: 'Last Name is required'
                                },
                                regexp: {
                                    regexp: /^[a-zA-Z\s]+$/,
                                    message: 'Last Name can only consist of alphabetical characters'
                                }
                            }
                        },
                        user_profile_pic: {
                            enabled: false,
                            validators: {
                                notEmpty: {
                                    message: 'No Profile Picture'
                                }
                            }
                        },
                        employee_number: {
                            validators: {
                                notEmpty: {
                                    message: 'Employee Number is required'
                                }
                            }
                        },
                        category: {
                            validators: {
                                notEmpty: {
                                    message: 'User Category is required'
                                }
                            }
                        },
                        optionsRadios: {
                            validators: {
                                notEmpty: {
                                    message: 'Gender Option is required'
                                }
                            }
                        },
                        email_employee: {
                            validators: {
                                notEmpty: {
                                    message: 'The email address is required'
                                },
                                emailAddress: {
                                    message: 'The email address is not valid'
                                }
                            }
                        },
                        contact_employee: {
                            validators: {
                                notEmpty: {
                                    message: 'The Contact Number is required'
                                },
                                regexp: {
                                    regexp: /^[0-9,+]{13}$/,
                                    message: 'Enter Valid Contact Number format +254735973206'
                                }
//                                numeric: {
//                                    message: 'The Contact Number is only numbers',
//                                    // The default separators
//                                }
                            }
                        },
                        date_of_birthemployee: {
                            validators: {
                                notEmpty: {
                                    message: 'Date of Birth is required'
                                }
                                ,
                                date: {
                                    format: 'DD-MM-YYYY',
                                    message: 'The date is not a valid'
                                }
                            }
                        },
                        date_of_employement: {
                            validators: {
                                notEmpty: {
                                    message: 'Date Hired is required'
                                },
                                date: {
                                    format: 'DD-MM-YYYY',
                                    message: 'The date is not a valid'
                                }
                            }
                        },
                        employmenttype_id_employee: {
                            validators: {
                                notEmpty: {
                                    message: 'Ocupation is required'
                                }
                            }
                        }, eventDate: {
                            validators: {
                                notEmpty: {
                                    message: 'The date is required'
                                },
                                date: {
                                    format: 'DD-MM-YYYY',
                                    message: 'The date is not a valid'
                                }
                            }
                        }
                    }
                }).on('success.form.fv', function (e) {
            // Save the form data via an Ajax request
            e.preventDefault();
            var $form = $(e.target),
                    firstname_client = $form.find('[name="firstname_client"]').val(),
                    email_employee = $form.find('[name="email_employee"]').val();
            // The url and method might be different in your application
            $.ajax({
                url: url_addemployee,
                type: $(this).attr("method"),
                dataType: "JSON",
                data: new FormData(this),
                processData: false,
                contentType: false
//                url: url_addemployee,
//                method: 'post',
//                dataType: "JSON",
//                data: $form.serialize()
            }).done(function (response) {
                if (response.status === 1) {
//                    $.notify(response.report);
                    $.notify(response.report, "error");
                } else {
                    $('#add_employee').formValidation('resetForm', true);
                    $.notify(response.report, "success");
                    setTimeout(location.reload.bind(location), 1200);
                    // $("#add_employeediv").load(location.href + " #add_employeediv");
                    //var l = document.getElementById('addemployee_link');
                    //l.click();
//                    $.notify(response.report);
                }

            });
        });
    });
</script>