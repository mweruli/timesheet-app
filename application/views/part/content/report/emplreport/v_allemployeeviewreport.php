<div class="panel-body">
    <div class="row">
        <div class="col-md-12">
            <!-- start: EXPORT DATA TABLE PANEL  -->
            <div class="panel panel-white">
                <div class="panel-heading btn-green">
                    <h4 class="panel-title">Employee <span class="text-bold">Data</span></h4>
                    <div class="panel-tools">
                        <div class="dropdown">
                            <a data-toggle="dropdown" class="btn btn-xs dropdown-toggle btn-transparent-grey">
                                <i class="fa fa-cog"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-light pull-right" role="menu">
                                <li>
                                    <a class="panel-refresh" href="#">
                                        <i class="fa fa-refresh"></i> <span>Refresh</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="panel-expand" href="#">
                                        <i class="fa fa-expand"></i> <span>Fullscreen</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="panel-body" id="employm_one">
                    <div class="row">
                        <div class="col-md-12 space20">
                            <!--<div class="btn-group pull-left">-->
                            <div class="col-sm-6">
                                <div id="reportrange_one" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                                    <span></span> <b class="caret"></b>
                                </div>
                            </div>
                            <!--</div>-->
                            <div class="btn-group pull-right" style="margin-top: -10px;">
                                <button data-toggle="dropdown" class="btn btn-green dropdown-toggle">
                                    Export <i class="fa fa-angle-down"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-light pull-right">
                                    <li>
                                        <a href="#" id="savpdfone" onclick="printJS({printable: 'employee_allreport', type: 'html', header: 'All Employees', maxWidth: '1000', honorMarginPadding: false, targetStyles: ['*']})" >
                                            Save as PDF
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" id="saveexcelone" onclick="export_dam()">
                                            Export to Excel
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="employee_allreport">
                            <thead>
                                <tr>
                                    <th>Full Name</th>
                                    <th class="center">Role</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Date Hired</th>
                                    <th class="center">Age</th>
                                    <th>Projects Worked On</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($array_data as $valueme) {
                                    //Projects Per User
                                    $number_tasks = $controller->getnumprojectsperuser($valueme['user_id']);
                                    ?>
                                    <tr>
                                        <td><img src="<?= base_url() ?>upload/<?= $valueme['user_image_small'] ?>" class="img-circle" alt="<?= $valueme['firstname'] ?>"/>&nbsp;<?= $valueme['firstname'] . ' ' . $valueme['lastname'] ?></td>
                                        <td class="center">
                                            <?php
                                            $string_one = $valueme['employmenttype_id'];
                                            $utilsetting = $controller->getutilsetting($string_one);
                                            echo $utilsetting[0]['design'];
                                            ?>
                                        </td>
                                        <td><?= $valueme['cellphone'] ?></td>
                                        <td>
                                            <a href="#" class="edit-row">
                                                <?= $valueme['emailaddress'] ?>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="#" class="delete-row">
                                                <?php
                                                echo date("F jS, Y", strtotime($valueme['dateemployeed']));
                                                ?>

                                            </a>
                                        </td>
                                        <td class="center">
                                            <?php
                                            echo getage($valueme['dateofbirth'], '-');
                                            ?>
                                        </td>
                                        <td class="center">
                                            <?= count($number_tasks); ?>
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
            <!-- end: EXPORT DATA TABLE PANEL -->
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
//        document.getElementsByClassName('buttons-excel')[0].visibility = 'hidden';

//        Main.init();
//        $('#employee_allreport').DataTable();
//        TableExport.init();
        $('#employee_allreport').DataTable({
//            "paging": false,
//            "ordering": false,
//            "info": false,
            dom: 'Bfrtip',
            buttons: [
//                'copyHtml5',
                'excelHtml5',
//                'csvHtml5',
//                'pdfHtml5'
            ],
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "pageLength": 7
        }).container().appendTo($('#employm_one'));
    });

    $(function () {
//        document.getElementsByClassName('buttons-excel')[0].style.visibility = 'hidden';
        var start = moment().subtract(29, 'days');
        var end = moment();
        function cb(start, end) {
            $('#reportrange_one span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }
        $('#reportrange_one').daterangepicker({
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
    function export_dam() {
        $('#employm_one').find('.buttons-excel').click();
//        document.getElementsByClassName('buttons-excel')[0].click();
    }
</script>