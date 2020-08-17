<style>
    .disabled {
        pointer-events: none;
        cursor: default;
    }
</style>
<div class="tabbable no-margin no-padding partition-bricky">
    <ul class="nav nav-tabs" id="myTab">
        <li class="active">
            <a data-toggle="tab" href="#allemployeer">
                All Employees
            </a>
        </li>
        <li class="">
            <a data-toggle="tab" href="#employejobs" id="addemployee_linkrr">
                Jobs Of Employees
            </a>
        </li>
        <li class="">
            <a data-toggle="tab" href="#reminderxx" id="report_per_project_xx_tt" class="disabled">
                Report Per Project
            </a>
        </li>   
    </ul>
    <div class="tab-content partition-white">
        <div id="allemployeer" class="tab-pane padding-bottom-5 active">
            <?php echo $this->load->view('part/content/report/emplreport/v_allemployeeviewreport', '', TRUE); ?>
        </div>
        <div id="employejobs" class="tab-pane padding-bottom-5">
            <?php echo $this->load->view('part/content/report/emplreport/v_allprojectemployereport', '', TRUE); ?>
        </div>
        <div id="reminderxx" class="tab-pane padding-bottom-5">
            <?php echo $this->load->view('part/content/report/emplreport/employperproject', '', TRUE); ?>
        </div>
    </div>
</div> 
<script>
    $(function () {
//        alert('hey');
        $('.buttons-excel').hide();
//        document.getElementsByClassName('buttons-excel')[0].style.visibility = 'hidden';
    });
</script>
