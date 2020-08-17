<?php
//print_array($data_tables);
?>
<!-- start: ACCORDION PANEL -->
<div class="panel-heading">
    <h4 class="panel-title">Settings</h4>
</div>
<div class="panel-body">
    <div class="panel-group accordion" id="accordion">
        <div class="panel panel-white">
            <div class="panel-heading">
                <h5 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                        <i class="icon-arrow"></i> Designation and Rates
                    </a>
                </h5>
            </div>
            <div id="collapseOne" class="panel-collapse collapse in">
                <div class="panel-body">
                    <?php
                    echo $this->load->view('part/content/settings/v_admin_listsettings', '', TRUE);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    window.onload = function() {
//        alert('Hell Yeah');
        var reloadupdatestate = sessionStorage.getItem("reloadtaskupdatorempstate");
        if (reloadupdatestate) {
            sessionStorage.removeItem("reloadtaskupdatorempstate");
            reloadupdatefuncstate();
        }
    };
    function reloadupdatefuncstate() {
//        var l = document.getElementById('collapseOne');
//        l.click();
//        $(e.target).parent('.panel-default').prop('collapseOne');
    }
</script>
<!-- end: ACCORDION PANEL -->
