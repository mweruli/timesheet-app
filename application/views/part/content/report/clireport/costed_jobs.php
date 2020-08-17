<div class="panel-body" id="client_three">
    <div class="row">
        <div class="col-md-12 space20">
            <div class="col-sm-6">
                <div id="reportrange_two" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                    <span></span> <b class="caret"></b>
                </div>
            </div>
            <div class="btn-group pull-right" style="margin-top: -10px;">
                <button data-toggle="dropdown" class="btn btn-green dropdown-toggle">
                    Export <i class="fa fa-angle-down"></i>
                </button>
                <ul class="dropdown-menu dropdown-light pull-right">
                    <li>
                        <a href="#" id="exportpdf" onclick="printJS({printable: 'costed_table', type: 'html', header: 'Costed Jobs', maxWidth: '1000', honorMarginPadding: false, targetStyles: ['*']})">
                            Save as PDF
                        </a>
                    </li>
                    <li>
                        <a href="#" class="export-excel"  onclick="export_damclinet3()">
                            Export to Excel
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div id="content">
        <div class="table-responsive">
            <table class="table table-hover" id="costed_table">
                <thead>
                    <tr>
                        <th>Project Name</th>
                        <!--<th>Pricing Per Hour</th>-->
                        <th>Costed</th>
                        <th>Client Name</th>
                        <th>Person In Charge</th>
                        <th>Total Cost</th>
                        <th>Date Finished</th>
                        <th>Invoiced</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($all_costed_jobs as $value_client) {
                        $taskopenreturndata = $controller->totalcostapproved($value_client['id'])
                        ?>
                        <tr>
                            <td><?= $value_client['project_name'] ?></td>
                            <td>Yes</td>
                            <td><?= $value_client['clientname'] ?></td>
                            <td><?= $value_client['person_charge'] ?></td>
                            <td><?= $taskopenreturndata ?></td>
                            <td><?= date("F jS, Y", strtotime($value_client['end_date'])); ?></td>
                            <td>
                                <a class="btn" href="#" onclick="fillInvoice('<?= $value_client['id'] ?>', '<?= $value_client['id_client'] ?>')">
                                    <i class="fa fa-inbox"></i>
                                </a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
//        $('#costed_table').DataTable({
//            dom: 'Bfrtip',
//            buttons: [
////                'copyHtml5',
//                'excelHtml5'
////                'csvHtml5',
////                'pdfHtml5'
//            ]
//        }).container().appendTo($('#client_three'));
        var table = $('#costed_table').DataTable({
            dom: 'Bfrtip',
            buttons: [
//                'copyHtml5',
                'excelHtml5'
//                'csvHtml5',
//                'pdfHtml5'
            ],
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "pageLength": 7
        });
        $('#client_three').append(table);
    });
    function fillInvoice(project_id, client_id) {
        var url_setmeoneemployee = '<?php echo base_url("client/setmeinvoice"); ?>';
        $.ajax({
            url: url_setmeoneemployee,
            dataType: "JSON",
            method: 'POST',
            data: jQuery.param({project_id: project_id, client_id: client_id}),
        }).done(function (response) {
            reloadpp();
//            location.reload();
//            mama();
//            var l = document.getElementById('link_viewemployeemm');
//            l.click();
        });
    }
    $(function () {

        var start = moment().subtract(29, 'days');
        var end = moment();
        function cb(start, end) {
            $('#reportrange_two span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }

        $('#reportrange_two').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        cb(start, end);

    });
    function export_damclinet3() {
        $('#client_three').find('.buttons-excel').click();
//        document.getElementsByClassName('buttons-excel')[0].click();
    }
</script>