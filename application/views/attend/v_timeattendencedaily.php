<div class="row" novalidate>
    <div class="col-sm-12">
        <div class="tabbable">
            <ul id="myTab2" class="nav nav-tabs">
                <li class="active">
                    <a href="#myTab2_daily" data-toggle="tab"
                       > 
                        <i class="green fa fa-home">&nbsp; Daily Attendance Report  </i>
                    </a>
                </li>
                <li>
                    <a href="#myTab2_daily_absent" data-toggle="tab">Daily Absent Report 
                    </a>
                </li>
                <li>
                    <a href="#myTab2_daily_latenes" data-toggle="tab">Daily Lateness Report 
                    </a>
                </li>
                <li>
                    <a href="#" >Daily OT Report
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade in active" id="myTab2_daily">
                    <?php echo $this->load->view('attend/v_testcardsdaily', '', TRUE); ?>
                </div>
                <div class="tab-pane fade" id="myTab2_daily_absent">
                    <?php echo $this->load->view('attend/v_testcardsdailyabsent', '', TRUE); ?>
                </div>
                <div class="tab-pane fade" id="myTab2_daily_latenes">
                    <?php echo $this->load->view('attend/v_testcardsdailylateness', '', TRUE); ?>
                </div>
                <div class="tab-pane fade" id="myTab2_daily_ott">
                    <?php echo $this->load->view('attend/v_testcardsdailyott', '', TRUE); ?>
                </div>
            </div>
        </div>
    </div>
</div>
