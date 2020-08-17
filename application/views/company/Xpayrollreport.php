<div class="row" novalidate>
    <div class="col-sm-12">
        <div class="tabbable">
            <ul id="myTab2" class="nav nav-tabs">
                <li class="active">
                    <a href="#myTab2_payslip" data-toggle="tab"
                       > <i class="fa  fa-institution">&nbsp;Payslips</i>
                    </a>
                </li>
                <li>
                    <a href="#myTab2_sumreport" data-toggle="tab"
                       > <i class="fa  fa-institution">&nbsp;Summary Report </i>
                    </a>
                </li>
                <li>
                    <a href="#myTab2_pansionreport" data-toggle="tab" 
                       id="pansionreport"> <i class="fa  fa-bookmark-o">&nbsp;Pension Report </i>
                    </a>
                </li>
                <li><a href="#myTab2_unionreport" data-toggle="tab" 
                       id="unionreport"> <i class="fa  fa-arrows">&nbsp;Union Report </i>
                    </a>
                </li>
                <li><a href="#myTab2_nhif" data-toggle="tab" 
                       id="nhif"> <i class="fa  fa-arrows">&nbsp;Nhif</i>
                    </a>
                </li>
                <li><a href="#myTab2_nssf" data-toggle="tab" 
                       id="nssf"> <i class="fa  fa-arrows">&nbsp;Nssf</i>
                    </a>
                </li>
                <li><a href="#myTab2_banktransfer" data-toggle="tab" 
                       id="banktransfer"> <i class="fa  fa-arrows">&nbsp;Bank Transfer</i>
                    </a>
                </li>
                <li><a href="#myTab2_chequepayment" data-toggle="tab" 
                       id="chequepayment"> <i class="fa  fa-arrows">&nbsp;Cheque Payments</i>
                    </a>
                </li>
                <li><a href="#myTab2_companytotal" data-toggle="tab" 
                       id="companytotal"> <i class="fa  fa-arrows">&nbsp;Company Total</i>
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade in active" id="myTab2_payslip">
                </div>
                <div class="tab-pane" id="myTab2_sumreport">
                </div>
                <div class="tab-pane" id="myTab2_pansionreport">
                </div>
                <div class="tab-pane" id="myTab2_unionreport">
                </div>
                <div class="tab-pane" id="myTab2_nhif">
                </div>
                <div class="tab-pane" id="myTab2_nssf">
                </div>
                <div class="tab-pane" id="myTab2_banktransfer">
                </div>
                <div class="tab-pane" id="myTab2_chequepayment">
                </div>
                <div class="tab-pane" id="myTab2_companytotal">
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$data['controller'] = $controller;
echo $this->load->view('viewjs/payrollemploylistconfig', $data, TRUE);
