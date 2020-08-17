<?php
//print_array($all_projects);
?>
<div class="panel panel-white">
    <div class="panel-heading border-light">
        <!--<span class="text-extra-small text-dark">LAST PROJECT: </span><span class="text-large text-white">Luxury Store</span>-->
        <div class="panel-tools">
            <div class="dropdown">
                <a data-toggle="dropdown" class="btn btn-xs dropdown-toggle btn-transparent-white">
                    <i class="fa fa-cog"></i>
                </a>
                <ul class="dropdown-menu dropdown-light pull-right" role="menu">
                    <!--                    <li>
                                            <a class="panel-collapse collapses" href="#"><i class="fa fa-angle-up"></i> <span>Collapse</span> </a>
                                        </li>-->
                    <!--                    <li>
                                            <a class="panel-refresh" href="#">
                                                <i class="fa fa-refresh"></i> <span>Refresh</span>
                                            </a>
                                        </li>-->
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

                <div class="btn-group pull-right" style="">
                    &nbsp;&nbsp;
                    <div class="form-group">
                        <!--                    <label class="col-sm-2 control-label">
                                                Start Date
                                            </label>-->
                        <div class="col-sm-6 date">
                            <div class="input-group input-append date" id="start_date_projectxx">
                                <input type="date"  name="start_date_projectxx" class="form-control" >
                                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="content">
            <div class="table-responsive">
                <table class="table table-hover" id="sample-table-1expo">
                    <thead>
                        <tr>
                            <th>Project Name</th>
                            <th>Total Amount</th>
                            <th>Tasks Done</th>
                            <th>Project Pricing</th>
                            <th>Tasks Pending</th>
                            <!--<th>My Task</th>-->
                            <th>Total Time Spent</th>
                            <th>Date Started</th>
                            <th>End Date</th>
                        </tr>
                    </thead>    
                    <tbody>
                        <?php
                        foreach ($all_projects as $value_project) {
                            //Tasks Pending
                            $array_data = $controller->getalltaskperprojectstatus($value_project['id'], 0);
                            //Tasks Taken
                            $array_data_two = $controller->getalltaskperprojectstatus($value_project['id'], 1);
//                        print_array($array_data);
                            //Total Time Spent Per project
                            $array_data_t3 = $controller->totaltimeperprojectperson($value_project['id'], $this->session->userdata('logged_in')['user_id']);
//                            print_array($array_data_t3);
                            ?>
                            <tr>
                                <td><?= $value_project['project_name'] ?></td>
                                <td><?= $array_data_t3 * $value_project['project_pricing'] ?></td>
                                <td>
                                    <?php
                                    $valuetaskn = " ";
                                    foreach ($array_data_two as $obedtwo) {
                                        $valuetaskn .= " " . '<a href="#">' . $obedtwo['task'] . '</a>' . ',';
                                    }
                                    echo $valuetaskn;
                                    ?>
                                </td>
                                <td><?= $value_project['project_pricing'] ?></td>
                                <td>
                                    <?php
                                    $valuetask = " ";
                                    foreach ($array_data as $obed) {
                                        $valuetask .= " " . '<a href="#">' . $obed['task'] . '</a>' . ',';
                                    }
                                    echo $valuetask;
                                    ?>
                                </td>
                                <!--<td>My Task</td>-->
                                <td><?= $array_data_t3 . ' ' . 'hours' ?></td>
                                <td><?= date("F jS, Y", strtotime($value_project['start_date'])); ?></td>
                                <td><?php
                                    $today = date("d-m-Y");
                                    $dateme = $value_project['end_date'];
//                                echo $dateme;
                                    if (new DateTime() > new DateTime($dateme)) {
                                        echo '<font  color="red">' . date("F jS, Y", strtotime($dateme)) . '</font>';
                                    } else {
                                        echo '<font  color="blue">' . date("F jS, Y", strtotime($dateme)) . '</font>';
                                    }
//                                if ($dateme < $today) {
//                                    echo 'joash';
//                                } else {
//                                    echo $dateme;
//                                }
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
</div>
<script>
    $(document).ready(function () {
//        Main.init();
        $('#sample-table-1expo').DataTable();
//        TableExport.init();
    });
</script>