<script src="<?= base_url() ?>assets/js/editablejss/jquery.tabledit.js"></script>
<div class="panel-heading">
    <h4 class="panel-title">Shift <span class="text-bold">List</span></h4>
</div>
<div class="panel-body">
    <table class="table table-striped table-bordered table-hover table-full-width" id="shift_tablelist">
        <thead>
            <tr>
                <th>Id</th>
                <th>Shift From</th>
                <th class="hidden-xs">Shift To</th>
                <th>Shift Type</th>
                <th class="hidden-xs">Remarks</th>
                <th>Lunch (min)</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($siftdef as $value) {
                ?>
                <tr>
                    <td class="center"><?= $value['id'] ?></td>
                    <td class="center"><?= $value['shiftfrom'] ?></td>
                    <td class="center"><?= $value['shiftto'] ?></td>
                    <td class="center"><?= $value['shiftype'] ?></td>
                    <td class="center"><?= $value['remarks'] ?></td>
                    <td class="center"><?= $value['lunchmin'] ?></td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
</div>
<script>
    $('#shift_tablelist').Tabledit({
        url: '<?= base_url('posts/editshifts') ?>',
        deleteButton: true,
        hideIdentifier: true,
        restoreButton: false,
        editmethod: 'post',
        deletemethod: 'post',
        rowIdentifier: 'id',
        columns: {
            identifier: [0, 'id'],
            editable: [[1, 'shiftfrom'], [2, 'shiftto'], [3, 'shiftype'], [4, 'remarks'], [5, 'lunchmin']]
        },
        onSuccess: function (data, textStatus, jqXHR) {
//            alert(JSON.stringify(data));
            console.log(JSON.stringify(data));
            if (data.status === 0) {
                $.notify(data.report, "success");
            } else {
                $.notify(data.report, "error");
            }
            return;
        }
    });
</script>