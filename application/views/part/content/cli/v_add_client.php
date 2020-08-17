<?php
//print_array($department_items);
?>
<div class="row" id="div_addclient">
    <div class="col-sm-12">
        <!-- start: TEXT FIELDS PANEL -->
        <!--<div class="panel panel-white">-->
        <div class="panel-heading">
            <h4 class="panel-title">Add <span class="text-bold">New Client</span></h4>
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
            <form id="add_client" role="form" method="post" class="form-horizontal" novalidate>
                <div class="form-group">
                    <label class="col-sm-2 control-label">
                        Client Photo
                    </label>
                    <div class="col-sm-9">
                        <img id="uploadPreview"  src="http://www.placehold.it/200x150/EFEFEF/AAAAAA?text=no+image" onclick="Call_Uploader()" />
                        <input id="user_profile_pic" class="hidden" type="file" name="user_profile_pic" onChange="PreviewImage();" placeholder="Profile Picture" />
                        <script type="text/javascript">
                            function PreviewImage() {
                                var oFReader = new FileReader();
                                oFReader.readAsDataURL(document.getElementById("user_profile_pic").files[0]);
                                oFReader.onload = function(oFREvent) {
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
                        Client Names
                    </label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="Client Names" id="clientname" name="clientname" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="form-field-1">
                        Department
                    </label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="Identify Department" id="employmenttype_id_client" name="employmenttype_id_client" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="form-field-1">
                        Client Number
                    </label>
                    <div class="col-sm-4">
                        <input type="text" placeholder="Client Number" id="client_number" name="client_number" class="form-control" value="<?= crypto_rand_secure(0, 1000000) ?>" readonly="readonly">
                    </div>
                    <label class="col-sm-1 control-label">
                        Email
                    </label>
                    <div class="col-sm-4">
                        <input type="text" placeholder="Client Email" id="client_email" name="client_email" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">
                        Location
                    </label>
                    <div class="col-sm-4">
                        <input type="text" placeholder="Location" id="client_location" name="client_location"  class="form-control">
                    </div>
                    <label class="col-sm-1 control-label">
                        Contact
                    </label>
                    <div class="col-sm-4">
                        <input type="text" placeholder="Contact Number" id="client_contact" name="client_contact" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">
                        PIN NUMBER
                    </label>
                    <div class="col-sm-4">
                        <input type="text" placeholder="PIN NUMBER" id="pin_no" name="pin_no"  class="form-control">
                    </div>
                    <label class="col-sm-1 control-label">
                        PERSON CHARGE
                    </label>
                    <div class="col-sm-4">
                        <input type="text" placeholder="PERSON IN CHARGE" id="person_charge" name="person_charge" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">
                        Website
                    </label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="Website" id="clientwebsite" name="clientwebsite" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="form-field-1">
                        Type
                    </label>
                    <div class="col-sm-9">
                        <label class="radio-inline">
                            <input type="radio" value="Individual" name="optionsRadios" >
                            Individual
                        </label>
                        <label class="radio-inline">
                            <input type="radio" value="Company" name="optionsRadios" >
                            Company
                        </label>
                    </div>
                </div>

                <br>
                <div class="form-group">
                    <div class="panel-body">
                        <p>
                            <button class="btn btn-green btn-block" type="submit">
                                Add Client<i class="fa fa-arrow-circle-right"></i>
                            </button>
                        </p>
                    </div>
                </div>
            </form>
        </div>
        <!--</div>-->
        <!-- end: TEXT FIELDS PANEL -->
    </div>
</div>
<script>
    var url_addclient = "<?php echo base_url("client/addclient"); ?>";
    $(document).ready(function() {
        $('#add_client')
                .formValidation({
                    framework: 'bootstrap',
                    icon: {
                        valid: 'glyphicon glyphicon-ok',
                        invalid: 'glyphicon glyphicon-remove',
                        validating: 'glyphicon glyphicon-refresh'
                    },
                    fields: {
                        clientname: {
                            validators: {
                                notEmpty: {
                                    message: 'Client Names are required'
                                }
                                /*regexp: {
                                 regexp: /^[a-zA-Z\s]+$/,
                                 message: ' Names can only consist of alphabetical characters'
                                 }*/
                            }
                        }
                        ,
                        client_number: {
                            validators: {
                                notEmpty: {
                                    message: 'Client Number is required'
                                }
                            }
                        }
                        ,
                        pin_no: {
                            validators: {
                                notEmpty: {
                                    message: 'PIN Number is required'
                                }
                            }
                        }
                        ,
                        person_charge: {
                            validators: {
                                notEmpty: {
                                    message: 'Names Of Person In Charge Required'
                                }
                            }
                        }
                        ,
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
                        optionsRadios: {
                            validators: {
                                notEmpty: {
                                    message: 'Company Type  is required'
                                }
                            }
                        },
                        client_location: {
                            validators: {
                                notEmpty: {
                                    message: 'Client Location  is required'
                                }
                            }
                        },
                        client_email: {
                            validators: {
                                notEmpty: {
                                    message: 'The email address is required'
                                },
                                emailAddress: {
                                    message: 'The email address is not valid'
                                }
                            }
                        },
                        clientwebsite: {
                            validators: {
                                uri: {
                                    allowEmptyProtocol: true,
                                    message: 'The website address is not valid'
                                }
                            }
                        },
                        client_contact: {
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
                        }
//                        ,
//                        employmenttype_id_client: {
//                            validators: {
//                                notEmpty: {
//                                    message: 'Department Atlest One is required'
//                                }
//                            }
//                        }
                    }
                }).on('success.form.fv', function(e) {
            // Save the form data via an Ajax request
            e.preventDefault();
            var $form = $(e.target),
                    clientname = $form.find('[name="clientname"]').val(),
                    client_email = $form.find('[name="client_email"]').val();
            // The url and method might be different in your application
            $.ajax({
                url: url_addclient,
                type: $(this).attr("method"),
                dataType: "json",
                data: new FormData(this),
                processData: false,
                contentType: false
            }).done(function(response) {
                //alert(JSON.stringify(response));
                if (response.status === 1) {
//                    $.notify(response.report);
                    $.notify(response.report, "error");
                } else {
                    $('#add_client').formValidation('resetForm', true);
                    $.notify(response.report, "success");
                    reloadme('link_tab_setprojectclient');
//                    $("#div_addclient").load(location.href + " #div_addclient");
//                    link_tab_addclient
                    //reloadTabs(2);
//                    var l = document.getElementById('link_tab_addclient');
//                     l.click();
                }
            });
        });
    });
</script>