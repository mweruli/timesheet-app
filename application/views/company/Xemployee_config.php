<div class="row" novalidate>
    <div class="col-sm-12">
        <div class="tabbable">
            <ul id="myTab2" class="nav nav-tabs">
                <li class="active"><a href="#myTab2_leaveapp" data-toggle="tab"
                                      id="link_tab_addclient"> <i class="green fa fa-home">&nbsp;Leave
                            Application</i>
                    </a></li>
                <li><a href="#myTab2_leavebal" data-toggle="tab"> <i
                            class="fa fa-share-alt"></i>&nbsp;Leave Balances
                    </a></li>
                <li><a href="#myTab2_leavestate" data-toggle="tab"> <i
                            class="fa fa-building"></i>&nbsp;My Leave Status
                    </a></li>
                <li><a href="#myTab2_leavestat" data-toggle="tab"> <i
                            class="fa fa-building-o"></i>&nbsp;My Leave Stats
                    </a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade in active" id="myTab2_leaveapp">
                    <?php echo $this->load->view('company/employeeself/leaveapply', '', TRUE); ?>
                </div>
                <div class="tab-pane fade" id="myTab2_leavebal">
                    <?php echo $this->load->view('company/employeeself/leavebalance', '', TRUE); ?>
                </div>
                <div class="tab-pane fade" id="myTab2_leavestate"></div>
                <div class="tab-pane fade" id="myTab2_leavestat"></div>
            </div>
        </div>
    </div>
</div>
<?php
$this->load->view('viewjs/leaveemp', TRUE);
