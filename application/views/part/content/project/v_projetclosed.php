<?php
//print_array($all_active_clients);
?>
<div class="panel-heading" id="id_project_on_xxx">
    <h4 class="panel-title">Projects <span class="text-bold">Closed</span></h4>
    <div class="btn-group pull-right" style="margin-top: -10px;">
        <button data-toggle="dropdown" class="btn btn-green dropdown-toggle">
            Export <i class="fa fa-angle-down"></i>
        </button>
        <ul class="dropdown-menu dropdown-light pull-right">
            <li>
                <a href="#"  onclick="printJS({printable: 'sample_2_mm', type: 'html', header: 'Projects Closed', maxWidth: '1000', honorMarginPadding: false, targetStyles: ['*']})">
                    Save as PDF
                </a>
            </li>
            <li>
                <a href="#" class="export-excel" onclick="export_damclineteehe()">
                    Export to Excel
                </a>
            </li>
        </ul>
    </div>
</div>
<div class="panel-body" id="id_project_on_xxxlower">
    <!--<div id="panel_projects" class="tab-pane fade">-->
    <table class="table table-striped table-bordered table-hover" id="sample_2_mm">
        <thead>
            <tr>
                <th>Project Name</th>
                <!--<th class="hidden-xs">Pricing</th>-->
                <th>Start End Date</th>
                <th class="hidden-xs">Client Name</th>
                <th class="hidden-xs center">Email and Contact</th>
                <th>Client Type</th>
                <!--<th>Priority</th>-->
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($all_close_clients as $value) {
                ?>
                <tr>
                    <td><?= $value['project_name'] ?></td>
                    <td><?= $value['start_date'] . ' to ' . $value['end_date'] ?></td>
                    <td class="hidden-xs">
                        <?= $value['clientname'] ?> 
                    </td>
                    <td class="center hidden-xs"><?= $value['client_email'] . ' | ' . $value['client_contact'] ?></td>
                    <td class="center hidden-xs"> <?= $value['client_type'] ?></td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
    <!--</div>-->
</div>
<script>
    $(document).ready(function () {
        $('#sample_2_mm').DataTable({
            dom: 'Bfrtip',
            buttons: [
//                'copyHtml5',
                'excelHtml5'
//                'csvHtml5',
//                'pdfHtml5'
            ]
        }).container().appendTo($('#id_project_on_xxxlower'));

    });
    function export_damclineteehe() {
        $('#id_project_on_xxxlower').find('.buttons-excel').click();
//        document.getElementsByClassName('buttons-excel')[0].click();
    }
</script>
<!-- end: PAGE CONTENT-->
