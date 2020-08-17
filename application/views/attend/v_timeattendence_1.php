<div class="tabbable no-margin no-padding  partition-black">
    <ul class="nav nav-tabs">
        <li class="active">
            <a data-toggle="tab" href="#manualentry"
               id="listmanualentry"> Manual Entry </a>
        </li>
        <li class=""><a data-toggle="tab" href="#empleaveinput"
                        id="listempleaveinput"> Allowance  Input </a></li>
        <li class="">
            <a data-toggle="tab" href="#myTab2_advancededuction"
               id="listempleaveinput"> Advance Deduction</a>
        </li>
        <li class="">
            <a data-toggle="tab" href="#myTab2_loanem"
               id="listempleaveinput"> Advance Loan</a>
        </li>
    </ul>
    <div class="tab-content partition-white">
        <div id="manualentry" class="tab-pane padding-bottom-5 active">
            <?php echo $this->load->view('attend/times/v_manualentry', '', TRUE); ?>
        </div>
        <div id="empleaveinput" class="tab-pane padding-bottom-5 ">
            <?php echo $this->load->view('attend/times/v_allowence', '', TRUE); ?>
        </div>
        <div class="tab-pane fade" id="myTab2_advancededuction">
            <?php echo $this->load->view('attend/times/v_advancededuction', '', TRUE); ?>
        </div>
        <div class="tab-pane fade" id="myTab2_loanem">
            <?php echo $this->load->view('attend/times/v_addloan', '', TRUE); ?>
        </div>
    </div>
</div>
<?php
$this->load->view('viewjs/manualentry', TRUE);