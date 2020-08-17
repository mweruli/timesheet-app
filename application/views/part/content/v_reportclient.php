<style>
    .disabled {
        pointer-events: none;
        cursor: default;
    }
</style>
<div class="tabbable no-margin no-padding partition-azure">
    <ul class="nav nav-tabs" id="myTab">
        <li class="active"><a data-toggle="tab" href="#clintelxxmm"> Time
                Sheet Entry</a></li>
        <li class=""><a data-toggle="tab" href="#allclientel"
                        id="allclient_report"> Time Per Client </a></li>
        <li class=""><a data-toggle="tab" href="#clinteljobs"
                        id="addemployee_linkrr"> Time Per Task</a></li>
        <li class=""><a data-toggle="tab" href="#costedjobsdetailsxx"
                        id="costedjobsdetails"> Time Per Staff </a></li>
    </ul>
    <div class="tab-content partition-white">
        <div id="clintelxxmm" class="tab-pane padding-bottom-5 active">
            <?php echo $this->load->view('part/content/report/clireport/clientgenralreport', '', TRUE); ?>
        </div>
        <div id="allclientel" class="tab-pane padding-bottom-5 ">
            <?php echo $this->load->view('part/content/report/clireport/v_allclientviewreport', '', TRUE); ?>
        </div>
        <div id="clinteljobs" class="tab-pane padding-bottom-5 ">
            <?php echo $this->load->view('part/content/report/clireport/v_currentprojectviewreport', '', TRUE); ?>
        </div>
        <div id="costedjobsdetailsxx" class="tab-pane padding-bottom-5">
            <?php echo $this->load->view('part/content/report/clireport/v_costed_jobsdetails', '', TRUE); ?>
        </div>
    </div>
</div>
<script>
    $(function() {
        $('.buttons-excel').hide();
    });
</script>