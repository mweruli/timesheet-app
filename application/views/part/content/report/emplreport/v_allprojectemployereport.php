<?php
//print_array($employeeproject);
?>
<div class="panel-body" id="employem_two">
    <div class="row">
        <div class="col-md-12">
            <!-- start: EXPORT DATA TABLE PANEL  -->
            <div class="panel panel-white">
                <div class="panel-heading btn-blue">
                    <h4 class="panel-title">Employee Project<span class="text-bold">Data</span></h4>
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
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12 space20">
                            <!--<div class="btn-group pull-left">-->
                            <div class="col-sm-6">
                                <div id="reportrange_jaja" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
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
                                        <a href="#" id="savepdftwo" onclick="printJS({printable: 'employee_allreport_proj', type: 'html', header: 'Jobs Of Employees', maxWidth: '1000', honorMarginPadding: false, targetStyles: ['*']})">
                                            Save as PDF
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" id="saveexceltwo" onclick="export_dam1()">
                                            Export to Excel
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="employee_allreport_proj">
                            <thead>
                                <tr>
                                    <th>Full Name</th>
                                    <th>Tasks - Time Taken</th>
                                    <th>Project Name</th>
                                    <th>Client Name</th>
                                    <th>Pin Number</th>
                                    <th>Date Assigned</th>
                                    <th>Deadline Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($employeeproject as $value_one) {
                                    $array_data = $controller->getmeusercreds($value_one['id_employee']);
//                                    print_array($array_data);
                                    //Get Project name Client Name
                                    $array_datax = $controller->getAllproclienr($value_one['id_project']);
//                                    print_array($array_datax[0]);
                                    ?>
                                    <tr>
                                        <td class="center"><img src="<?= base_url() ?>upload/<?= $array_data['user_image_small'] ?>" class="img-circle" alt="<?= $array_data['emailaddress'] ?>"/>&nbsp;<?= $array_data['firstname'] . ' ' . $array_data['lastname'] ?></td>
                                        <td>
                                            <?php
                                            $tasks = $value_one['project_task'];
                                            $tasks_one = json_decode($tasks);
                                            $valuemm = "";
                                            foreach ($tasks_one as $valuememe) {
                                                $posted_valuesn = array(
                                                    'project_id' => $value_one['id_project'],
                                                    'task_workedone' => $valuememe,
                                                    'employee_id' => $value_one['id_employee']
                                                );
//                                                print_array($posted_valuesn);
//                                                $responseone_wine = Requests::post(base_url('welcome/totaltimepertask_clone'), '', $posted_valuesn);
                                                $total_cutter = $controller->totaltimepertask_clonexx($value_one['id_project'], $valuememe, $value_one['id_employee']);
                                                $valuemm .= " " . '<a href="#">' . $valuememe . '</a>' . ' - ' . '<font size="2" color="blue">' . $total_cutter . ' hrs' . '</font><br>';
                                            }
                                            echo $valuemm;
                                            ?>
                                        </td>
                                        <td><a href="#" class="btn" onclick="viewoneproject('<?= $value_one['id_project'] ?>')">
                                                <i class="fa fa-expand"></i>&nbsp;<?= $array_datax[0]['project_name'] ?>
                                            </a>
                                        </td>
                                        <td><?= $array_datax[0]['clientname'] ?></td>
                                        <td><?= $array_datax[0]['pin_no'] ?></td>
                                        <td><?= date("F jS, Y", strtotime($array_datax[0]['start_date'])); ?></td>
                                        <td>
                                            <?php
                                            $today = date("d-m-Y");
                                            $dateme = $array_datax[0]['end_date'];
                                            if (new DateTime() > new DateTime($dateme)) {
                                                echo '<font  color="red">' . date("F jS, Y", strtotime($dateme)) . '</font>';
                                            } else {
                                                echo '<font  color="blue">' . date("F jS, Y", strtotime($dateme)) . '</font>';
                                            }
                                            ?>
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
        $('#employee_allreport_proj').DataTable({
            dom: 'Bfrtip',
            buttons: [
//                'copyHtml5',
                'excelHtml5'
//                'csvHtml5',
//                'pdfHtml5'
            ]
        }).container().appendTo($('#employem_two'));
    });
//        Main.init();
//    $('#employee_allreport_proj').DataTable();
////        TableExport.init();
//    });
    $(function () {
        var start = moment().subtract(29, 'days');
        var end = moment();
        function cb(start, end) {
            $('#reportrange_jaja span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }

        $('#reportrange_jaja').daterangepicker({
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
    function viewoneproject(project_id) {
        var url_setmeoneemployee = '<?php echo base_url("employee/setoneproject"); ?>';
        $.ajax({
            url: url_setmeoneemployee,
            dataType: "JSON",
            method: 'POST',
            data: jQuery.param({project_id: project_id})
        }).done(function (response) {
//            alert(JSON.stringify(response));
            reloadm();
//            location.reload();
//            mama();
//            var l = document.getElementById('link_viewemployeemm');
//            l.click();
        });
    }
    function export_dam1() {
        $('#employem_two').find('.buttons-excel').click();
//        document.getElementsByClassName('buttons-excel').click();
    }
</script>