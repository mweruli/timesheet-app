<div class="row" novalidate>
    <div class="col-sm-12">
        <div class="tabbable">
            <ul id="myTab2" class="nav nav-tabs">
                <li class="active"><a href="#myTab2_nhif" data-toggle="tab"
                                      > <i class="fa  fa-institution">&nbsp;Nhif</i>
                    </a>
                </li>
                <li>
                    <a href="#myTab2_paye" data-toggle="tab"
                       > <i class="fa fa-code-fork"></i>&nbsp;Paye
                    </a>
                </li>
                <li>
                    <a href="#myTab2_allowances" data-toggle="tab"
                       > <i class="fa fa-gears"></i>&nbsp;Allowances
                    </a>
                </li>
                <li><a href="#myTab2_commission" data-toggle="tab"
                       > <i class="fa fa-external-link"></i>&nbsp;Commission
                    </a>
                </li>
                <li><a href="#myTab2_sacco" data-toggle="tab"
                       > <i class="fa fa-subscript"></i>&nbsp;Sacco
                    </a>
                </li>
                <li><a href="#myTab2_loantypes" data-toggle="tab"
                       > <i class="fa fa-exchange"></i>&nbsp;Loan Types
                    </a>
                </li>
                <li><a href="#myTab2_pension" data-toggle="tab"
                       > <i class="fa fa-exchange"></i>&nbsp;Pension
                    </a>
                </li>
                <li><a href="#myTab2_custparams" data-toggle="tab"
                       > <i class="fa fa-exchange"></i>&nbsp;Custom Parameters
                    </a>
                </li>
                <li><a href="#myTab2_noncashben" data-toggle="tab"
                       > <i class="fa fa-exchange"></i>&nbsp;Non-cash Benefits
                    </a>
                </li>
                <li><a href="#myTab2_relief" data-toggle="tab"
                       > <i class="fa fa-exchange"></i>&nbsp;Relief
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade in active" id="myTab2_nhif">
                    <?php echo $this->load->view('company/payroll/nhif', '', TRUE); ?>
                </div>
                <div class="tab-pane fade" id="myTab2_paye">
                    <?php echo $this->load->view('company/payroll/paye', '', TRUE); ?>
                </div>
                <div class="tab-pane fade" id="myTab2_allowances">
                    <?php echo $this->load->view('company/payroll/allowences', '', TRUE); ?>
                </div>
                <div class="tab-pane fade" id="myTab2_commission">
                    <?php echo $this->load->view('company/payroll/commissions', '', TRUE); ?>
                </div>
                <div class="tab-pane fade" id="myTab2_sacco">
                    <?php echo $this->load->view('company/payroll/sacco', '', TRUE); ?>
                </div>
                <div class="tab-pane fade" id="myTab2_loantypes">
                    <?php echo $this->load->view('company/payroll/loantypes', '', TRUE); ?>
                </div>
                <div class="tab-pane fade" id="myTab2_pension">
                    <?php echo $this->load->view('company/payroll/pension', '', TRUE); ?>
                </div>
                <div class="tab-pane fade" id="myTab2_custparams">
                    <?php echo $this->load->view('company/payroll/customparams', '', TRUE); ?>
                </div>
                <div class="tab-pane fade" id="myTab2_noncashben">
                    <?php echo $this->load->view('company/payroll/noncashbenefits', '', TRUE); ?>
                </div>
                <div class="tab-pane fade" id="myTab2_relief">
                    <?php echo $this->load->view('company/payroll/relif', '', TRUE); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$this->load->view('viewjs/hrconfig', TRUE);
