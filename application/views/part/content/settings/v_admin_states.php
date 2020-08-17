<?php
//print_array($data_tablesx);
//$responseone = Requests::get(base_url('welcome/getalltaskperprojectstatus/') . $value_project['id'] . '/' . '0');
?>
<div class="table-responsive" id="mydivstateemployee">
    <table class="table table-striped table-hover" id="mydivstateemployeetable">
        <thead>
            <tr>
                <th>Employee State Type</th>
                <th>Added By</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($all_state_employee as $value) {
//                $responseone = Requests::get(base_url('welcome/getsupervisernamesbyiddirect/') . $value['added_by'] . '/' . '0');
                $array_data = $controller->getsupervisernamesbyiddirect($value['added_by']);
                $addedby = $supervisor_array['firstname'] . ' ' . $supervisor_array['lastname'] . ' @ ' . $supervisor_array['emailaddress'];
                ?>
                <tr>
                    <td><?= $value['task_name'] ?></td>
                    <td><?= $addedby ?></td>
                    <td>
                        <a href="#" data-id="<?= $value['id'] ?>" class="edit-row" id="editme" >
                            Edit
                        </a>
                    </td>
                    <td> 
                        <a href="#" onclick="deleteDesignationstate('<?= $value['id'] ?>', '<?= $value['task_name'] ?>', '<?= $addedby ?>')">Delete
                        </a>
                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
</div>
<form id="userFormstate" method="post" class="form-horizontal" style="display: none;" >
    <div class="form-group" hidden="true">
        <label class="col-xs-3 control-label">ID</label>
        <div class="col-xs-3">
            <input type="text" class="form-control" name="id_state"  />
        </div>
    </div>
    <div class="form-group">
        <label class="col-xs-3 control-label">Employee State Type</label>
        <div class="col-xs-5">
            <input type="text" class="form-control" name="employee_state" />
        </div>
    </div>
    <div class="form-group">
        <div class="col-xs-5 col-xs-offset-3">
            <button type="submit" class="btn btn-default">Save</button>
        </div>
    </div>
</form>
<script>
    var urldelete = '<?php echo base_url("welcome/deletetabledatastate"); ?>';
    var employe_edit_stateurl = '<?php echo base_url("welcome/edittabledatastateemployee/"); ?>';
    var comitedit_urlemployee = '<?php echo base_url("welcome/commiteditstateemployee"); ?>';
    $(document).ready(function () {
        $('#mydivstateemployeetable').DataTable();
    });
    $(document).ready(function () {
        $('#userFormstate')
                .formValidation({
                    framework: 'bootstrap',
                    icon: {
                        valid: 'glyphicon glyphicon-ok',
                        invalid: 'glyphicon glyphicon-remove',
                        validating: 'glyphicon glyphicon-refresh'
                    },
                    fields: {
                        employee_state: {
                            validators: {
                                notEmpty: {
                                    message: 'Employee State Type is required'
                                },
                                regexp: {
                                    regexp: /^[a-zA-Z\s]+$/,
                                    message: 'Employee State Type can only consist of alphabetical characters'
                                }
                            }
                        }
                    }
                })
                .on('success.form.fv', function (e) {
                    // Save the form data via an Ajax request
                    e.preventDefault();
                    var $form = $(e.target),
                            id_state = $form.find('[name="id_state"]').val(),
                            employee_state = $form.find('[name="employee_state"]').val();
                    // The url and method might be different in your application
                    $.ajax({
                        url: comitedit_urlemployee,
                        method: 'post',
                        dataType: "JSON",
                        data: $form.serialize()
                    }).done(function (response) {
                        // Get the cells
//                        alert(JSON.stringify(response));
                        var $button = $('a[data-id="' + id_state + '"]'),
                                $tr = $button.closest('tr'),
                                $cells = $tr.find('td');
                        // Update the cell data
                        $cells.eq(0).html(employee_state).end();
                        // Hide the dialog
                        $form.parents('.bootbox').modal('hide');
                        $.notify("Employee State Type Edited Successfully", "success");
                    });
                });

        $('#editme').on('click', function () {
            // Get the record's ID via attribute
            var id = $(this).attr('data-id');
            $.ajax({
                url: employe_edit_stateurl + id,
                dataType: "JSON",
                method: 'GET'
            }).done(function (response) {
                // alert(JSON.stringify(dataxxx));
                // Populate the form fields with the data returned from server
                $('#userFormstate')
                        .find('[name="id_state"]').val(response.id).end()
                        .find('[name="employee_state"]').val(response.task_name).end();
                // Show the dialog
                bootbox
                        .dialog({
                            title: 'Employee State Type',
                            message: $('#userFormstate'),
                            show: false // We will show it manually later
                        })
                        .on('shown.bs.modal', function () {
                            $('#userFormstate')
                                    .show()                             // Show the login form
                                    .formValidation('resetForm'); // Reset form
                        })
                        .on('hide.bs.modal', function (e) {
                            // Bootbox will remove the modal (including the body which contains the login form)
                            // after hiding the modal
                            // Therefor, we need to backup the form
                            $('#userFormstate').hide().appendTo('body');
                        })
                        .modal('show');
            });
        });
    });
    function reloadtaskupdatorempstate() {
        sessionStorage.setItem("reloadtaskupdatorempstate", "true");
        document.location.reload();
    }
    function deleteDesignationstate(id, taskname, addedbyvalue) {
        // var the_divm = '"' + the_div + '"';
        //alert(the_divm);
        var dialog = bootbox.dialog({
            title: 'Confirm Deleting ' + taskname,
            message: "<p> Added By" + "<h4>" + addedbyvalue + "</h4>" + "</p>",
            buttons: {
                cancel: {
                    label: '<i class="fa fa-check"></i> Delete',
                    className: 'btn-danger',
                    callback: function () {
                        $.post(urldelete,
                                {
                                    valueid: id
                                },
                                function (data, status) {
                                    $.notify(taskname + " Deleted Successfully", "success");
                                    setTimeout(function () {
                                        reloadtaskupdatorempstate();
                                    }, 2000);
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