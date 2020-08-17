<div class="row" novalidate>
    <div class="col-sm-12">
        <div class="tabbable">
            <ul id="myTab2" class="nav nav-tabs">
                <li class="active">
                    <a href="#myTab2_customededuc" data-toggle="tab"
                       > <i class="fa  fa-institution">&nbsp;Add Custom Deductions </i>
                    </a>
                </li>
                <li>
                    <a href="#myTab2_payrollemploy" data-toggle="tab"
                       > <i class="fa  fa-institution">&nbsp;Employees Payroll </i>
                    </a>
                </li>
                <li>
                    <a href="#myTab2_payrolmaster" data-toggle="tab" class="is-disabled"
                       id="payrollmasteridtab"> <i class="fa  fa-bookmark-o">&nbsp;Payroll Master </i>
                    </a>
                </li>
                <li><a href="#myTab2_payrollloan" data-toggle="tab" class="is-disabled"
                       id="loanpayrollid"> <i class="fa  fa-arrows">&nbsp;Loans Payroll </i>
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade in active" id="myTab2_customededuc">
                    <?php echo $this->load->view('company/payroll/ops/payrollcustoms', '', TRUE); ?>
                </div>
                <div class="tab-pane" id="myTab2_payrollemploy">
                    <?php echo $this->load->view('company/payroll/ops/payrollemployeelist', '', TRUE); ?>
                </div>
                <div class="tab-pane" id="myTab2_payrolmaster">
                    <?php echo $this->load->view('company/payroll/ops/payrolloanemployee', '', TRUE); ?>
                </div>
                <div class="tab-pane" id="myTab2_payrollloan">
                    <?php echo $this->load->view('company/payroll/ops/payrollloan', '', TRUE); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$data['controller'] = $controller;
echo $this->load->view('viewjs/payrollemploylistconfig', $data, TRUE);
