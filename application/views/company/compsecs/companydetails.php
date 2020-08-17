<?php
//print_array($fields);
?>
<div class="row" id="company_detailsid">
    <div class="col-md-12">
        <div class="panel-heading">
            <!--<h4 class="panel-title">General <span class="text-bold">COMPANY SETTINGS</span></h4>-->
            <div class="panel-tools">
                <div class="dropdown">
                    <a data-toggle="dropdown" class="btn btn-xs dropdown-toggle btn-transparent-grey">
                        <i class="fa fa-cog"></i>
                    </a>
                    <?php echo $this->load->view('part/include/formconfig', '', TRUE); ?>
                </div>
            </div>
        </div>
        <div class="panel-body" style="margin-top: -50px;">
            <form id="company_detailsid_form" role="form" method="post" class="form-horizontal" novalidate >
                <div class="form-group" <?= hideorshow(array_keyvaluen($fields, 'companylogo')['status']) ?>>
                    <label class="col-md-2 control-label">
                        Company  Logo
                    </label>
                    <div class="col-md-9">
                        <img id="uploadPreview"  
                        <?php
                        $imageurl = printvalues('companylogo', $fieldsdata);
                        if ($imageurl == '') {
                            $imagesource = 'http://www.placehold.it/200x150/EFEFEF/AAAAAA?text=no+image';
                        } else {
                            $imagesource = base_url('upload/client/') . $imageurl;
                        }
                        ?>
                             src="<?= $imagesource ?>" 
                             onclick="Call_Uploader()" width="210" height="200" />
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
                    <div <?= hideorshow(array_keyvaluen($fields, 'name')['status']) ?>>
                        <label class="col-md-2 control-label" for="form-field-1" >
                            NAME
                        </label>
                        <div class="col-md-4" >
                            <input type="text" placeholder="Company Name" id="name" name="name" class="form-control" value="<?= printvalues('name', $fieldsdata) ?>">
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($fields, 'email')['status']) ?>>
                        <label class="col-md-2 control-label">
                            EMAIL
                        </label>
                        <div class="col-md-4">
                            <input type="text" placeholder="Company Email" id="email" name="email" class="form-control" value="<?= printvalues('email', $fieldsdata) ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($fields, 'pinno')['status']) ?>>
                        <label class="col-md-2 control-label" for="form-field-1">
                            PIN NO
                        </label>
                        <div class="col-md-4">
                            <input type="text" placeholder="Pin" id="pinno" name="pinno" class="form-control" value="<?= printvalues('pinno', $fieldsdata) ?>">
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($fields, 'pinno')['status']) ?>>
                        <label class="col-md-2 control-label">
                            NHIF NO
                        </label>
                        <div class="col-md-4">
                            <input type="text" placeholder="Nhif " id="nhifno" name="nhifno" class="form-control" value="<?= printvalues('nhifno', $fieldsdata) ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($fields, 'nssfno')['status']) ?>>
                        <label class="col-md-2 control-label" for="form-field-1">
                            NSSF NO
                        </label>
                        <div class="col-md-4">
                            <input type="text" placeholder="NSSF Number" id="nssfno" name="nssfno" class="form-control" value="<?= printvalues('nssfno', $fieldsdata) ?>">
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($fields, 'regnumber')['status']) ?>>
                        <label class="col-md-2 control-label">
                            REG. NO
                        </label>
                        <div class="col-md-4">
                            <input type="text" placeholder="REG Number" id="regnumber" name="regnumber" class="form-control" value="<?= printvalues('regnumber', $fieldsdata) ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($fields, 'postaladdress')['status']) ?>>
                        <label class="col-md-2 control-label">
                            POSTAL ADD
                        </label>
                        <div class="col-md-4">
                            <input type="text" placeholder="POSTAL Address" id="postaladdress" name="postaladdress"  class="form-control" value="<?= printvalues('postaladdress', $fieldsdata) ?>">
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($fields, 'pysicaladdress')['status']) ?>>
                        <label class="col-md-2 control-label">
                            PHYSICAL ADD
                        </label>
                        <div class="col-md-4">
                            <input type="text" placeholder="PYSICAL Address" id="pysicaladdress" name="pysicaladdress" class="form-control" value="<?= printvalues('pysicaladdress', $fieldsdata) ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($fields, 'telephone')['status']) ?>>
                        <label class="col-md-2 control-label">
                            TELEPHONE
                        </label>
                        <div class="col-md-4">
                            <input type="text" placeholder="TELEPHONE" id="telephone" name="telephone"  class="form-control" value="<?= printvalues('telephone', $fieldsdata) ?>">
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($fields, 'cellphone')['status']) ?>>
                        <label class="col-md-2 control-label">
                            CELL PHONE
                        </label>
                        <div class="col-md-4">
                            <input type="text" placeholder="CELL PHONE" id="cellphone" name="cellphone" class="form-control" value="<?= printvalues('cellphone', $fieldsdata) ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($fields, 'fax')['status']) ?>>
                        <label class="col-md-2 control-label">
                            FAX
                        </label>
                        <div class="col-md-4">
                            <input type="text" placeholder="FAX" id="fax" name="fax" class="form-control" value="<?= printvalues('fax', $fieldsdata) ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <button class="btn btn-green btn-block" type="submit">
                            Update<i class="fa fa-arrow-circle-right"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    var url_addcompany = "<?php echo base_url("company/addcompany"); ?>";
    $(document).ready(function() {
        $('#company_detailsid_form')
                .formValidation({
                    framework: 'bootstrap',
                    icon: {
                    },
                    fields: {
                        name: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($fields, 'name')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Company Name is required'
                                },
                                regexp: {
                                    regexp: /^[a-zA-Z\s]+$/,
                                    message: ' Names can only consist of alphabetical characters'
                                }
                            }
                        }
                        ,
                        email: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($fields, 'email')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Company Email  is required'
                                },
                                emailAddress: {
                                    message: 'The email address is not valid'
                                }
                            }
                        }
                        ,
                        pinno: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($fields, 'pinno')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'PIN Number is required'
                                }
                            }
                        }
                        ,
                        nhifno: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($fields, 'nhifno')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'NHIF number Required'
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
                        nssfno: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($fields, 'nssfno')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'NSSF  Number is required'
                                }
                            }
                        },
                        regnumber: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($fields, 'regnumber')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Registration Number is required'
                                }
                            }
                        },
                        postaladdress: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($fields, 'postaladdress')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Postal Address  is required'
                                }
                            }
                        },
                        pysicaladdress: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($fields, 'pysicaladdress')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Pysical Address  is required'
                                }
                            }
                        },
                        telephone: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($fields, 'telephone')['mandatory']) ?>)),
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
                        cellphone: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($fields, 'cellphone')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'The Contact Number is required'
                                },
                                regexp: {
                                    regexp: /^[0-9,+]{13}$/,
                                    message: 'Enter Valid Contact Number format +254735973206'
                                }
                            }
                        },
                        fax: {
                            validators: {
                                notEmpty: {
                                    message: 'FAX is required'
                                }
                            }
                        }
                    }
                }).on('success.form.fv', function(e) {
            // Save the form data via an Ajax request
            e.preventDefault();
            $.ajax({
                url: url_addcompany,
                type: $(this).attr("method"),
                dataType: "json",
                data: new FormData(this),
                processData: false,
                contentType: false
            }).done(function(response) {
//                console.log(JSON.stringify(response));
//                if (response.status === 1) {
//                    $.notify(response.report, "error");
//                } else {
////                    $('#add_client').formValidation('resetForm', true);
//                    $.notify(response.report, "success");
//                }
            });
        });
    });
</script>