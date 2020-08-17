<div class="row" novalidate>
    <div class="col-sm-12">
        <div class="tabbable">
            <ul id="myTab2" class="nav nav-tabs">
                <li class="active"><a href="#myTab2_example1" data-toggle="tab"
                                      id="link_tab_addclient"> <i class="green fa fa-home">&nbsp;Company</i>
                    </a>
                </li>
                <li><a href="#myTab2_example2" data-toggle="tab"
                       > <i class="fa fa-code-fork"></i>&nbsp;Branches
                    </a>
                </li>
                <li><a href="#myTab2_example3" data-toggle="tab"
                       > <i class="fa fa-share-alt"></i>&nbsp;Regions
                    </a>
                </li>
                <li><a href="#myTab2_example4" data-toggle="tab"
                       > <i class="fa fa-building"></i>&nbsp;Stations
                    </a>
                </li>
                <li><a href="#myTab2_example5" data-toggle="tab"
                       > <i class="fa fa-building-o"></i>&nbsp;Departments
                    </a>
                </li>
                <li><a href="#myTab2_example6" data-toggle="tab"
                       > <i class="fa  fa-bars"></i>&nbsp;Sections
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade in active" id="myTab2_example1">
                    <?php echo $this->load->view('company/compsecs/companydetails', '', TRUE); ?>
                </div>
                <div class="tab-pane fade" id="myTab2_example2">
                    <?php echo $this->load->view('company/compsecs/companybranches', '', TRUE); ?>
                </div>
                <div class="tab-pane fade" id="myTab2_example3">
                    <?php echo $this->load->view('company/compsecs/companyregions', '', TRUE); ?>
                </div>
                <div class="tab-pane fade" id="myTab2_example4">
                    <?php echo $this->load->view('company/compsecs/companystations', '', TRUE); ?>
                </div>
                <div class="tab-pane fade" id="myTab2_example5">
                    <?php echo $this->load->view('company/compsecs/companydepartments', '', TRUE); ?>
                </div>
                <div class="tab-pane fade" id="myTab2_example6">
                    <?php echo $this->load->view('company/compsecs/companysections', '', TRUE); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$this->load->view('viewjs/branch', TRUE);
