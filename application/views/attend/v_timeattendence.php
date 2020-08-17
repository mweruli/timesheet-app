<div class="row" novalidate>
    <div class="col-sm-12">
        <div class="tabbable">
            <ul id="myTab2" class="nav nav-tabs">
                <li class="active">
                    <a href="#myTab2_attendencareport" data-toggle="tab"
                       id="link_tab_addclient"> 
                        <i class="green fa fa-home">&nbsp; Attendance Report Card  </i>
                    </a>
                </li>
                <li>
                    <!--myTab2_paysheetfourght data-toggle="tab"-->
                    <a href="#">Paysheet Fourtnight
                    </a>
                </li>
                <li>
                    <!--myTab2_paysheetsummery data-toggle="tab"-->
                    <a href="#" >Paysheet  Summery
                    </a>
                </li>
                <!--myTab2_paysheetcoinage data-toggle="tab"-->
                <li><a href="#" >Coinage Report
                    </a>
                </li>
                <!--myTab2_paysheetcoinagesum data-toggle="tab"-->
                <li><a href="#">NSSF Report
                    </a>
                </li>
                <li>
                    <!--myTab2_nhifreport data-toggle="tab"-->
                    <a href="#">NHIF Report</a>
                </li>
                <li>
                    <!--myTab2_lunchreport data-toggle="tab"-->
                    <a href="#" >LUNCH Report</a>
                </li>
                <li>
                    <!--myTab2_saccoreport data-toggle="tab"-->
                    <a href="#" >SACCO Report</a>
                </li>
            </ul>
            
            <div class="tab-content">
                <div class="tab-pane fade in active" id="myTab2_attendencareport">
                    <?php echo $this->load->view('attend/v_testcards', '', TRUE); ?>
                </div>
                <div class="tab-pane fade" id="myTab2_paysheetfourght">
                    <?php echo $this->load->view('payslips/payslipfort', '', TRUE); ?>
                </div>
                <div class="tab-pane fade" id="myTab2_paysheetsummery">
                    <?php echo $this->load->view('payslips/payslipfortsum', '', TRUE); ?>
                </div>
                <div class="tab-pane fade" id="myTab2_paysheetcoinage">
                    <?php echo $this->load->view('payslips/paysheetcoinage', '', TRUE); ?>
                </div>
                <div class="tab-pane fade" id="myTab2_paysheetcoinagesum">
                    <?php echo $this->load->view('payslips/paysheetcoinagesum', '', TRUE); ?>
                </div>
                <div class="tab-pane fade" id="myTab2_nhifreport">
                    <?php echo $this->load->view('payslips/paysheetnhif', '', TRUE); ?>
                </div>
                <div class="tab-pane fade" id="myTab2_lunchreport">
                    <?php echo $this->load->view('payslips/paysheetlunch', '', TRUE); ?>
                </div>
                <div class="tab-pane fade" id="myTab2_saccoreport">
                    <?php echo $this->load->view('payslips/paysheetsacco', '', TRUE); ?>
                </div>
            </div>
        </div>
    </div>
</div>
