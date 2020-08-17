<div class="row">
    <div class="col-sm-12">
        <!-- start: INLINE TABS PANEL -->
        <!--<div class="panel panel-white">-->
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="tabbable">
                        <ul id="myTab" class="nav nav-tabs">
                            <li class="active">
                                <a href="#myTab_example1" data-toggle="tab">
                                    <i class="green fa fa-home"></i> Status of Projects Am In
                                </a>
                            </li>
                            <li>
                                <a href="#myTab_example2" data-toggle="tab">
                                    <i class="fa fa-circle-o-notch fa-spin"></i> Assign Myself A Project
                                </a>
                            </li>   
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="myTab_example1">
                                <?php echo $this->load->view('part/content/employee/v_employeeproject', '', TRUE); ?>
                            </div>
                            <div class="tab-pane fade" id="myTab_example2">
                                <?php echo $this->load->view('part/content/employee/v_employeeaddproject', '', TRUE); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end: INLINE TABS PANEL -->
    <!--</div>-->
</div>