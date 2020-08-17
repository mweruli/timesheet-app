<table class="table table-striped table-hover" id="employees_list_admin">
    <thead>
        <tr>
            <th>Organization</th>
            <th>Job Title</th>
            <th>From Date</th>
            <th>To</th>
            <th>Reason For Leaving</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        <?php
//        print_array($userexparray);
        foreach ($userexparray as $value) {
            ?>
            <tr id="<?= $value['id_employee'] . $value['organization'] . $value['fromexper'] ?>">
                <td>
                    <?= $value['organization'] ?>
                </td>
                <td><?= $value['jobtitle'] ?></td>
                <td ><?= $value['fromexper'] ?></td>
                <td ><?= $value['toexper'] ?></td>
                <td><?= $value['reasonforleaving'] ?></td>
                <td><a href="#" onclick="editemployeeex('<?= $value['id_employee'] ?>', '<?= $value['organization'] ?>', '<?= $value['fromexper'] ?>')" class="btn">
                        <i class="fa fa-edit"></i>
                    </a>
                </td>
                <td><a href="#" onclick="viewsingleemployee('<?= $value['id_employee'] ?>', '<?= $value['organization'] ?>', '<?= $value['fromexper'] ?>')" class="btn">
                        <i class="fa fa-times"></i>
                    </a>
                </td>
            </tr>
            <?php
        }
        ?>
    </tbody>
    <script>
        function viewsingleemployee(emplid, org, from) {
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: '<?= base_url('humanr/deletetable') ?>',
                data: {emply_id: emplid, oraganisation: org, fromdate: from},
                success: function (msg) {
                    sessionStorage.setItem("userexperiences", 'added');
                    sessionStorage.setItem("useridprofile", 'added');
                    document.location.reload(true);
                }
            });
        }
        function editemployeeex(emplid, org, from) {
//            var idtd = emplid + org + from;   
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: '<?= base_url('humanr/edituserinfo') ?>',
                data: {emply_id: emplid, oraganisation: org, fromdate: from},
                success: function (msg) {
//                    console.log(msg);
                    if (msg.status === 1) {
                        sessionStorage.setItem("userexperiences", 'added');
                        sessionStorage.setItem("useridprofile", 'added');
                        document.location.reload(true);
                    }
                }
            });
        }
    </script>
</table>