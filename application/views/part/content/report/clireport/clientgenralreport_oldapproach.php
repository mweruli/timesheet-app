<script src="<?= base_url() ?>assets/js/editablejss/jquery.tabledit.js"></script>
<?php
//print_array($timesheettabledata);
//echo $daterange[0];
?>
<div class="panel-heading">
    <h4 class="panel-title">Shift <span class="text-bold">List</span></h4>
    <span class="table-add glyphicon glyphicon-plus"></span>
</div>
<div class="panel-body">
    <div class="table-responsive table-editable" id="table" style="overflow-x:auto;overflow-y:auto;">
        <table class="table table-hover" id="shift_tablelist">
            <thead>
                <tr>
                    <th>Id</th>
                    <th></th>
                    <th></th>
                    <!--<th></th>-->
                    <?php
                    foreach ($numbdays as $value) {
                        ?>
                        <th><?= $value ?></th>
                        <?php
                    }
                    ?>
                </tr>
                <tr>
                    <th>Id</th>
                    <th>COMPANY</th>
                    <th>TASK</th>
                    <?php
                    foreach ($letdays as $value) {
                        ?>
                        <th><?= $value ?></th>
                        <?php
                    }
                    ?>
                    <th>TOTAL</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (empty($timesheettabledata)) {
                    ?>
                <h2>Add Your Monthly Tasks Please</h2>
                <?php
            } else {
                foreach ($timesheettabledata as $key => $perrowtime) {
                    ?>
                    <tr class="">
                        <td ></td>
                        <td ><?= $perrowtime[$key]['clientname'] ?></td>
                        <td ><?= $perrowtime[$key]['taskname'] ?></td>
                        <?php
                        foreach ($perrowtime as $key => $pertable) {
                            ?>

                            <td ><?= $pertable['time'] ?></td>
                            <?php
                        }
                        ?>
                        <td >2</td>
                    </tr>
                    <?php
                }
            }
            ?>
            <tr class="hide">
                <td ></td>
                <td class="col-sm-4">--SELECT CLIENT--</td>
                <td class="col-sm-4">--SELECT TASK--</td>
                <td class="col-sm-1">0.0</td>
                <td class="col-sm-1">0.0</td>
                <td class="col-sm-1">0.0</td>
                <td class="col-sm-1">0.0</td>
                <td class="col-sm-1">0.0</td>
                <td class="col-sm-1">0.0</td>
                <td class="col-sm-1">0.0</td>
                <td class="col-sm-1">0.0</td>
                <td class="col-sm-1">0.0</td>
                <td class="col-sm-1">0.0</td>
                <td class="col-sm-1">0.0</td>
                <td >0.0</td>
                <td >0.0</td>
                <td >0.0</td>
                <td >0.0</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<script>
    var getmeallclients = "<?php echo base_url('ts/loadallclients'); ?>";
    var dataclients;
    var val1 = "<?php echo 'foo-' . $daterange[0] ?>";
    var val2 = "<?php echo 'foo-' . $daterange[1] ?>";
    var val3 = "<?php echo 'foo-' . $daterange[2] ?>";
    var val4 = "<?php echo 'foo-' . $daterange[3] ?>";
    var val5 = "<?php echo 'foo-' . $daterange[4] ?>";
    var val6 = "<?php echo 'foo-' . $daterange[5] ?>";
    var val7 = "<?php echo 'foo-' . $daterange[6] ?>";
    var val8 = "<?php echo 'foo-' . $daterange[7] ?>";
    var val9 = "<?php echo 'foo-' . $daterange[8] ?>";
    var val10 = "<?php echo 'foo-' . $daterange[9] ?>";
    var val11 = "<?php echo 'foo-' . $daterange[10] ?>";
    var val12 = "<?php echo 'foo-' . $daterange[11] ?>";
    var val13 = "<?php echo 'foo-' . $daterange[12] ?>";
    var val14 = "<?php echo 'foo-' . $daterange[13] ?>";
    $(function () {
        $.ajax({
            method: "POST",
            url: getmeallclients,
            data: {'clientid': 1}
        }).done(function (data) {
//            dataclients = "'" + data + "'";
//            var obj = JSON.parse(data);
            $('#shift_tablelist').Tabledit({
//        alert('Find Peace My Freind');
                url: '<?= base_url('ts/edittimeshifts') ?>',
                deleteButton: true,
                hideIdentifier: true,
                restoreButton: false,
                editmethod: 'post',
                deletemethod: 'post',
                rowIdentifier: 'id',
                columns: {
                    identifier: [0, 'id'],
                    editable: [[1, 'company', data], [2, 'task', '{"1": "AUDIT", "2": "ACCOUNTING", "3": "TAX", "4": "COMPANY SECRETARIATE", "5": "OTHERS"}'], [3, val1], [4, val2], [5, val3], [6, val4], [7, val5], [8, val6], [9, val7], [10, val8], [11, val9], [12, val10], [13, val11], [14, val12], [15, val13], [16, val14], [17, '20']]
                },
                onSuccess: function (data, textStatus, jqXHR) {
                    console.log(JSON.stringify(data));
//                    if (data.status === 0) {
//                        $.notify(data.report, "success");
//                    } else {
//                        $.notify(data.report, "error");
//                    }
                    return;
                }
            });
//            console.log(val);
        });
    });
    //Phase 2
    var $TABLE = $('#table');
    $('.table-add').click(function () {
        var $clone = $TABLE.find('tr.hide').clone(true).removeClass('hide table-line');
        $TABLE.find('table').append($clone);
    });

    $('.table-remove').click(function () {
        $(this).parents('tr').detach();
    });

    $('.table-up').click(function () {
        var $row = $(this).parents('tr');
        if ($row.index() === 1)
            return; // Don't go above the header
        $row.prev().before($row.get(0));
    });

    $('.table-down').click(function () {
        var $row = $(this).parents('tr');
        $row.next().after($row.get(0));
    });

// A few jQuery helpers for exporting only
    jQuery.fn.pop = [].pop;
    jQuery.fn.shift = [].shift;
</script>