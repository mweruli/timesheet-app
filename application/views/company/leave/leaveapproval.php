<div class="panel-body">
    <p>
        Approve Pending Leave Requests
    </p>
    <table class="table table-hover" id="approva_leavetable">
        <thead>
            <tr>
                <th>Employee No</th>
                <th class="hidden-xs">Name</th>
                <th>Leave Type</th>
                <th class="hidden-xs">From</th>
                <th>To</th>
                <th class="hidden-xs">Leave Period</th>
                <th>Total Days</th>
                <th>Approve</th>
                <th>Reject</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($leavepending as $value) {
                ?>
                <tr class="info">
                    <td><?= $value['pin']; ?></td>
                    <td class="hidden-xs"><?= $value['names']; ?></td>
                    <td><?= $value['leavetype']; ?></td>
                    <td class="hidden-xs"><?= $value['leavefrom']; ?></td>
                    <td class=""><?= $value['leaveto']; ?></td>
                    <td class="hidden-xs"><?= $value['leaveperiod']; ?></td>
                    <td class=""><?= $value['leavebal']; ?></td>
                    <td class="">
                        <a class="btn btn-green" href="#" data-target="<?= $value['id'] . '|' . 'approve' ?>" ><i class="glyphicon glyphicon-thumbs-up"></i></a>
                    </td>
                    <td class="">
                        <a class="btn btn-red" href="#"  data-target="<?= $value['id'] . '|' . 'reject' ?>"><i class="fa fa-times fa fa-white"></i></a>
                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function () {
        $('#approva_leavetable').DataTable({
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "pageLength": 7
//            "paging": false,
//            "ordering": false,
//            "info": false
        });
        var approveurl = "<?php echo base_url("leave/approvalleave"); ?>";
        $(document).on('click', '[data-target]', function (e) {
            e.preventDefault();
            var getValue = $(this).attr("data-target");
            var fields = new Array();
            fields = getValue.split('|');
//            console.log(getValue);
            $.ajax({
                url: approveurl, //This is the current doc
                type: "POST",
                dataType: 'json', // add json datatype to get json
                data: ({leaveid: fields[0], status: fields[1]}),
                success: function (data) {
//                    console.log(data);
                    if (data.status === 1) {
                        $.notify(data.report, "success");
                    } else if (data.status === 2) {
                        $.notify(data.report, "error");
                    } else {
                        $.notify("Contact Admin Opreation Failed", "error");
                    }
                    sessionStorage.setItem("approvalleave", "true");
                    window.setTimeout(function () {
                        window.location.reload();
                    }, 1000);

                }
            });
        });
    });
    window.onload = function () {
        var sesforload = sessionStorage.getItem("approvalleave");
        if (sesforload) {
            sessionStorage.removeItem("approvalleave");
            var l = document.getElementById('id_leaveapprova_tab');
            l.click();
        }
    };
</script>
