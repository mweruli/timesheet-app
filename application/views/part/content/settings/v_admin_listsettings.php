<div class="table-responsive" id="mydivtwo">
    <table class="table table-striped table-hover" id="prodesion_table_rates">
        <thead>
            <tr>
                <th>Designation</th>
                <th>Rate</th>
                <th>Added By</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($data_tables as $value) {
                ?>
                <tr>
                    <td><?= $value['design'] ?></td>
                    <td><?= $value['rateamount'] ?></td>
                    <td><?= $supervisor_array['firstname'] . ' ' . $supervisor_array['lastname'] ?></td>
                    <td>
                        <a href="#" data-id="<?= $value['id'] ?>" class="edit-row" >
                            Edit
                        </a>
                    </td>
                    <td> 
                        <a href="#" onclick="deleteDesignations('<?= $value['id'] ?>', '<?= $value['design'] ?>', '<?= $value['rateamount'] ?>')">Delete
                        </a>
                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
</div>
<form id="userForm" method="post" class="form-horizontal" style="display: none;" >
    <div class="form-group" hidden="true">
        <label class="col-xs-3 control-label">ID</label>
        <div class="col-xs-3">
            <input type="text" class="form-control" name="id"  />
        </div>
    </div>
    <div class="form-group">
        <label class="col-xs-3 control-label">Designation</label>
        <div class="col-xs-5">
            <input type="text" class="form-control" name="design" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-xs-3 control-label" for="form-field-1">
            Rate Per Hour
        </label>
        <div class="col-xs-5">
            <input type="text" class="form-control" name="rateamount" />
        </div>
    </div>
    <div class="form-group">
        <div class="col-xs-5 col-xs-offset-3">
            <button type="submit" class="btn btn-default">Save</button>
        </div>
    </div>
</form>
<script>
    var url = '<?php echo base_url("welcome/deletetabledatas"); ?>';
    var urlxx = '<?php echo base_url("welcome/edittabledata/"); ?>';
    var comitedit_url = '<?php echo base_url("welcome/commitedit"); ?>';
    $('#prodesion_table_rates').DataTable({
//            "paging": false,
//            "ordering": false,
//            "info": false
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "pageLength": 7
    });

    $(document).ready(function () {
        $('#userForm')
                .formValidation({
                    framework: 'bootstrap',
                    icon: {
                        valid: 'glyphicon glyphicon-ok',
                        invalid: 'glyphicon glyphicon-remove',
                        validating: 'glyphicon glyphicon-refresh'
                    },
                    fields: {
                        design: {
                            validators: {
                                notEmpty: {
                                    message: 'Designation is required'
                                },
                                regexp: {
                                    regexp: /^[a-zA-Z\s]+$/,
                                    message: 'Designation can only consist of alphabetical characters'
                                }
                            }
                        },
                        rateamount: {
                            validators: {
                                notEmpty: {
                                    message: 'Rate can not be empty'
                                },
                                numeric: {
                                    message: 'The Rate value is not a number',
                                    // The default separators
                                }
                            }
                        }
                    }
                })
                .on('success.form.fv', function (e) {
                    // Save the form data via an Ajax request
                    e.preventDefault();
                    var $form = $(e.target),
                            id = $form.find('[name="id"]').val(),
                            name = $form.find('[name="design"]').val(),
                            type_value = $form.find('[name="rateamount"]').val();
                    // The url and method might be different in your application
                    $.ajax({
                        url: comitedit_url,
                        method: 'post',
                        dataType: "JSON",
                        data: $form.serialize()
                    }).done(function (response) {
                        // Get the cells
//                        alert(JSON.stringify(response));
                        var $button = $('a[data-id="' + id + '"]'),
                                $tr = $button.closest('tr'),
                                $cells = $tr.find('td');

                        // Update the cell data
                        $cells.eq(0).html(name).end()
                                .eq(1).html(type_value).end();
                        // Hide the dialog
                        $form.parents('.bootbox').modal('hide');
                        $.notify("Designation Edited Successfully", "success");
//                        var l = document.getElementById('my-link');
//                        l.click();
                        // You can inform the user that the data is updated successfully
                        // by highlighting the row or showing a message box
//                        bootbox.alert('The user profile is updated');
                    });
                });

        $('.edit-row').on('click', function () {
            // Get the record's ID via attribute
            var id = $(this).attr('data-id');
            $.ajax({
                url: urlxx + id,
                dataType: "JSON",
                method: 'GET'
            }).done(function (response) {
                // alert(JSON.stringify(dataxxx));
                // Populate the form fields with the data returned from server
                $('#userForm')
                        .find('[name="id"]').val(response.id).end()
                        .find('[name="design"]').val(response.design).end()
                        .find('[name="rateamount"]').val(response.rateamount).end();
                // Show the dialog
                bootbox
                        .dialog({
                            title: 'Edit Variables',
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
        });
    });
    function deleteDesignations(id, name, type_value) {
        // var the_divm = '"' + the_div + '"';
        //alert(the_divm);
        var dialog = bootbox.dialog({
            title: 'Confirm Deleting ' + type_value,
            message: "<p>" + "<h4>" + name + "</h4>" + "</p>",
            buttons: {
                cancel: {
                    label: '<i class="fa fa-check"></i> Delete',
                    className: 'btn-danger',
                    callback: function () {
                        $.post(url,
                                {
                                    valueid: id
                                },
                                function (data, status) {
                                    $.notify(type_value + " Deleted Successfully", "success");
                                    $("#mydivtwo").load(location.href + " #mydivtwo");
                                    var l = document.getElementById('my-link');
                                    l.click();
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
