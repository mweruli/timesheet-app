<?php
//print_array($all_clients);
?>
<div class="panel-heading">
    <h4 class="panel-title">All <span class="text-bold">Clients</span></h4>
</div>
<div class="panel-body">
    <table class="table table-striped table-bordered table-hover table-full-width" id="listclientstable">
        <thead>
            <tr>
                <th>CLIENT NAME</th>
                <!--<th class="hidden-xs">Business Types</th>-->
                <th>PIN NUMBER</th>
                <th class="hidden-xs">CLIENT EMAIL & CONTACT</th>
                <th>CLIENT TYPE</th>
                <th class="hidden-xs">PERSON IN CHARGE</th>
                <th class="hidden-xs">CLOSE</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($all_clients as $value) {
                ?>
                <tr>
                    <td>
                        <img src="<?= base_url() ?>upload/client/<?= $value['client_image_small']; ?>" class="img-rounded" alt=""/>&nbsp;<a href="#" onclick="viewsinglclient('<?= $value['id'] ?>')"><?= $value['clientname']; ?>
                            <i class="fa fa-eye-slash"></i></a>
                    </td>
                    <td><?= $value['pin_no']; ?></td>
                    <td class="hidden-xs"><a href="mailto:<?= $value['client_email']; ?>"><?= $value['client_email']; ?></a> | <?= $value['client_contact']; ?></td>
                    <td><?= $value['client_type']; ?></td>
                    <td><?= $value['person_charge']; ?></td>
                    <td class="center">
                        <a onclick="closeClient('<?= $value['id'] ?>', '<?= $value['clientname'] ?>', '<?= $value['pin_no'] ?>')" href="#">
                            <i class="fa fa-times"></i>
                        </a>
                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
</div>
<form id="clientForm" class="form-horizontal" method="post" enctype="multipart/form-data" accept-charset="utf-8"  style="display: none;" novalidate>
    <div class="form-group">
        <div class="col-sm-5 col-xs-offset-1">
            <div class="alert alert-block alert-success fade in">
                <h4 class="alert-heading"><i class="fa fa-info"></i> Info!</h4>
                <p id="more_info_client">
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
        <label class="col-xs-3  control-label">CLIENT NAME</label>
        <div class="col-xs-8">
            <input type="text" class="form-control" name="clientname" id="clientname" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-xs-3 control-label" for="form-field-1">
            CLIENT EMAIL
        </label>
        <div class="col-xs-8">
            <input type="text" class="form-control" name="client_email" id="client_email"/>
        </div>
    </div>
    <div class="form-group" hidden="true">
        <label class="col-xs-3 control-label" for="form-field-1">
            EMAIL OLD
        </label>
        <div class="col-xs-8">
            <input type="text" class="form-control" name="client_email_old" id="client_email_old" hidden="true"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-xs-3 control-label" for="form-field-1">
            PIN NUMBER
        </label>
        <div class="col-xs-8">
            <input type="text" class="form-control" name="pin_no" id="pin_no"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-xs-3 control-label" for="form-field-1">
            PERSON IN CHARGE
        </label>
        <div class="col-xs-8">
            <input type="text" class="form-control" name="person_charge" id="person_charge"/>
        </div>
    </div>
    <div class="form-group" hidden="true">
        <label class="col-xs-3 control-label" for="form-field-1">
            PIN NUMBER OLD
        </label>
        <div class="col-xs-8">
            <input type="text" class="form-control" name="pin_no_old" id="pin_no_old" hidden="true"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-xs-3 control-label" for="form-field-1">
            CONTACT NUMBER
        </label>
        <div class="col-xs-8">
            <input type="text" class="form-control" name="client_contact" id="client_contact"/>
        </div>
    </div>
    <div class="form-group" hidden="true">
        <label class="col-xs-3 control-label" for="form-field-1">
            CONTACT NUMBER OLD
        </label>
        <div class="col-xs-8">
            <input type="text" class="form-control" name="phone_number_old" id="phone_number_old" hidden="true"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-xs-3 control-label" for="form-field-1">
            CLIENT LOCATION
        </label>
        <div class="col-xs-8">
            <input type="text" class="form-control" name="client_location" id="client_location"/>
        </div>
    </div>
    <div class="form-group" hidden="true">
        <label class="col-xs-3 control-label" for="form-field-1">
            Image Name
        </label>
        <div class="col-xs-8">
            <input type="text" class="form-control" name="user_imagex" id="user_imagex" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-xs-3 control-label" for="form-field-1">
            WEBSITE
        </label>
        <div class="col-xs-8">
            <input type="text" class="form-control" name="website" id="website" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-xs-3 control-label" for="form-field-1">
            UPDATE DEPARTMENT ?
        </label>
        <div class="col-xs-8">
            <input type="text" class="form-control" name="employmenttype_id_employee" id="employmenttype_id_employee" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-xs-3 control-label" for="form-field-1">
            CLIENT TYPE
        </label>
        <div class="col-xs-8">
            <select  class="form-control search-select" placeholder="Select employmenttype_ids" name="client_type" id="client_type">
                <option value="Company">Company</option>
                <option value="Individual">Individual</option>
            </select>
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
    var url_editclient = '<?php echo base_url("client/editclient/"); ?>';
    var url_picture = '<?= base_url() ?>upload/client/';
    var url_editclient_two = '<?php echo base_url("client/editclienttwo"); ?>';
    var url_closeclient = '<?php echo base_url("client/closeclient"); ?>';
    $(document).ready(function () {
        $('#listclientstable').DataTable({
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "pageLength": 7
//            "paging": false,
//            "ordering": false,
//            "info": false
        });
        $('#clientForm')
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
                                    message: 'Client name is required'
                                },
                                regexp: {
                                    regexp: /^[a-zA-Z\s]+$/,
                                    message: 'Client name can only consist of alphabetical characters'
                                }
                            }
                        },
                        client_contact: {
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
                        client_email: {
                            validators: {
                                notEmpty: {
                                    message: 'The email address is required'
                                },
                                emailAddress: {
                                    message: 'The email address is not valid'
                                }
                            }
                        }
                        ,
                        pin_no: {
                            validators: {
                                notEmpty: {
                                    message: 'The PIN NUMBER is required'
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
                        client_type: {
                            validators: {
                                notEmpty: {
                                    message: 'Client Type  is required'
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
                        website: {
                            validators: {
                                uri: {
                                    allowEmptyProtocol: true,
                                    message: 'The website address is not valid'
                                }
                            }
                        }
//                        'employmenttype_id_employee[]': {
//                            validators: {
//                                notEmpty: {
//                                    message: 'Department Atlest One is required'
//                                }
//                            }
//                        }
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
                        url: url_editclient_two,
                        type: $(this).attr("method"),
                        dataType: "JSON",
                        data: new FormData(this),
                        processData: false,
                        contentType: false
                    }).done(function (response) {
//                        alert(JSON.stringify(response));
                        if (response.status === 1) {
//                    $.notify(response.report);
                            $.notify(response.report, "error");
                        } else {
                            $('#clientForm').formValidation('resetForm', true);
                            $.notify(response.report, "success");
                            setTimeout(location.reload.bind(location), 1200);
                            //var l = document.getElementById('addemployee_link');
                            //l.click();
//                    $.notify(response.report);
                        }
                    });
                });
    });
    function viewsinglclient(id) {
//        var id = $(this).attr('data-id');
        $("#more_info_client").html("");
        //$('p').append('fffff');
        $.ajax({
            url: url_editclient + id,
            dataType: "JSON",
            method: 'GET'
        }).done(function (response) {
//                alert(response.id);
//            alert(JSON.stringify(response));
            $("#pic1").attr("src", url_picture + response.client_image_big);
            $("#more_info_client").append('<span id="add_here">' + response.employmenttype_id_client + '<br>Added By: ' + response.supervisor_names + '<br>Date Added: ' + response.dateadded + '<br>Active' + '</span>');
//                $('p').append('<span id="add_here">' + response.employmenttype_id + '<br>Supervisor: ' + response.supervisor_names + '<br>Date Hired: ' + response.dateemployeed + '<br>Validated' + '</span>');
            // Populate the form fields with the data returned from server
            $('#clientForm')
                    .find('[name="id"]').val(response.id).end()
                    .find('[name="clientname"]').val(response.clientname).end()
                    .find('[name="client_email"]').val(response.client_email).end()
                    .find('[name="pin_no"]').val(response.pin_no).end()
                    .find('[name="person_charge"]').val(response.person_charge).end()
                    .find('[name="pin_no_old"]').val(response.pin_no).end()
                    .find('[name="client_contact"]').val(response.client_contact).end()
                    .find('[name="client_location"]').val(response.client_location).end()
                    .find('[name="employmenttype_id_employee"]').val(response.employmenttype_id_client).end()
                    .find('[name="website"]').val(response.website).end()
                    .find('[name="user_imagex"]').val(response.client_image_small).end()
                    .find('[name="phone_number_old"]').val(response.client_contact).end()
                    .find('[name="client_email_old"]').val(response.client_email).end();
            // Show the dialog
            bootbox
                    .dialog({
                        title: 'View/Edit Client ',
                        message: $('#clientForm'),
                        show: false // We will show it manually later
                    })
                    .on('shown.bs.modal', function () {
                        $('#clientForm')
                                .show()                             // Show the login form
                                .formValidation('resetForm'); // Reset form
                    })
                    .on('hide.bs.modal', function (e) {
                        // Bootbox will remove the modal (including the body which contains the login form)
                        // after hiding the modal
                        // Therefor, we need to backup the form
                        $('#clientForm').hide().appendTo('body');
                    })
                    .modal('show');
        });
    }
    function closeClient(id, companyname, pin_no) {
        var dialog = bootbox.dialog({
            title: 'Confirm Deleting ' + companyname,
            message: "<p>" + "<h4><b>" + companyname + "</b></h4>" + "PIN NO : " + pin_no + "</p>",
            buttons: {
                cancel: {
                    label: '<i class="fa fa-check"></i> Delete',
                    className: 'btn-danger',
                    callback: function () {
                        $.post(url_closeclient,
                                {
                                    clientid: id
                                },
                                function (data, status) {
                                    $.notify(companyname + " Deleted Successfully", "success");
                                    reloadme();
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
    function reloadme() {
        sessionStorage.setItem("reloadingx", "true");
//        document.location.reload();
        window.setTimeout(function () {
            window.location.reload()
        }, 3000);
    }
    window.onload = function () {
        var reloadingx = sessionStorage.getItem("reloadingx");
        if (reloadingx) {
            sessionStorage.removeItem("reloadingx");
            myfuncx();
        }
    }
    function myfuncx() {
        var l = document.getElementById('link_list_all_clients');
        l.click();
    }
</script>