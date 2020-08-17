<div class="row" novalidate>
    <div class="col-sm-12">
        <div class="tabbable">
            <ul id="myTab2" class="nav nav-tabs">
                <li class="active"><a href="#myTab2_banks" data-toggle="tab"
                                      id="link_tab_addclient"> <i class="fa  fa-institution">&nbsp;Banks</i>
                    </a>
                </li>
                <li><a href="#myTab2_branches" data-toggle="tab"
                       > <i class="fa fa-code-fork"></i>&nbsp;Branches
                    </a>
                </li>
                <li><a href="#myTab2_paymentcategory" data-toggle="tab"
                       > <i class="fa fa-gears"></i>&nbsp;Payment  Categories
                    </a>
                </li>
                <li><a href="#myTab2_paymentmodes" data-toggle="tab"
                       > <i class="fa fa-external-link"></i>&nbsp;Payment  Modes
                    </a>
                </li>
                <li><a href="#myTab2_paymentfrequency" data-toggle="tab"
                       > <i class="fa fa-subscript"></i>&nbsp;Payment  Frequency
                    </a>
                </li>
                <li><a href="#myTab2_currency" data-toggle="tab"
                       > <i class="fa fa-exchange"></i>&nbsp;Currency
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade in active" id="myTab2_banks">
                    <?php echo $this->load->view('company/bank/banks', '', TRUE); ?>
                </div>
                <div class="tab-pane fade" id="myTab2_branches">
                    <?php echo $this->load->view('company/bank/branches', '', TRUE); ?>
                </div>
                <div class="tab-pane fade" id="myTab2_paymentcategory">
                    <?php echo $this->load->view('company/bank/paymentcategory', '', TRUE); ?>
                </div>
                <div class="tab-pane fade" id="myTab2_paymentmodes">
                    <?php echo $this->load->view('company/bank/paymentmodes', '', TRUE); ?>
                </div>
                <div class="tab-pane fade" id="myTab2_paymentfrequency">
                    <?php echo $this->load->view('company/bank/paymentfrequency', '', TRUE); ?>
                </div>
                <div class="tab-pane fade" id="myTab2_currency">
                    <?php echo $this->load->view('company/bank/currency', '', TRUE); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('viewjs/hrconfig', TRUE);    