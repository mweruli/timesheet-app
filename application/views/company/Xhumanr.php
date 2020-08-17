<div class="row" novalidate>
    <div class="col-sm-12">
        <div class="tabbable">
            <ul id="myTab2" class="nav nav-tabs">
                <li class="active">
                    <a href="#myTab2_newemployee" data-toggle="tab"> <i class="green fa fa-puzzle-piece" id="newemployeemanage">&nbsp;New Staff </i>
                    </a>
                </li>
                <li>
                    <a href="#myTab2_manageemployee" data-toggle="tab" id="manageemployees"> <i class="green fa fa-users"></i>&nbsp;Manage Staff 
                    </a>
                </li>
                <li>
                    <a href="#myTab2_manageemployee_two" data-toggle="tab" id="manageemployeestwo"> <i class="green fa fa-users"></i>&nbsp;Staff In Junk
                    </a>
                </li>
                <li>
                    <a href="#myTab2_employeereport" data-toggle="tab" id="employeereport"> <i class="green fa fa-file-pdf-o"></i>&nbsp;Employee Report 
                    </a>
                </li>
                <li>
                    <a href="#myTab2_biodata" data-toggle="tab" id="link_tab_addclient" class="is-disabled" > 
                        <i class="green fa fa-user">&nbsp;User Profile</i>
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade in active" id="myTab2_newemployee">
                    <?php echo $this->load->view('company/hr/newemployee', '', TRUE); ?>
                </div>
                <div class="tab-pane fade" id="myTab2_manageemployee">
                    <?php echo $this->load->view('company/hr/manageemployee', '', TRUE); ?>
                </div>
                <div class="tab-pane fade" id="myTab2_employeereport">
                    <?php echo $this->load->view('company/hr/employeeemployeereport', '', TRUE); ?>
                </div>
                <div class="tab-pane fade" id="myTab2_manageemployee_two">
                    <?php echo $this->load->view('company/hr/manageemployeetwo', '', TRUE); ?>
                </div>
                <div class="tab-pane fade" id="myTab2_biodata">
                    <?php echo $this->load->view('company/hr/employeeprofile', '', TRUE); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$data['controller'] = $controller;
echo $this->load->view('viewjs/employeeconfig', $data, TRUE);
