<style>
    .disabled {
        pointer-events: none;
        cursor: default;
    }
</style>
<div class="tabbable no-margin no-padding partition-dark">
    <ul class="nav nav-tabs" id="myTab">
        <li class="active">
            <a data-toggle="tab" href="#users_tab_example1">
                All Employees
            </a>
        </li>
        <li class="">
            <a data-toggle="tab" href="#users_tab_example2" id="addemployee_link">
                Add New Employee
            </a>
        </li>
    </ul>
    <div class="tab-content partition-white">
        <div id="users_tab_example1" class="tab-pane padding-bottom-5 active">
            <?php echo $this->load->view('part/content/emp/v_list_employee', '', TRUE); ?>
        </div>
        <div id="users_tab_example2" class="tab-pane padding-bottom-5 ">
            <?php echo $this->load->view('part/content/emp/v_add_employee', '', TRUE); ?>
        </div>
    </div>
</div>
<script>
    window.onload = function () {
        var reloadppn = sessionStorage.getItem("reloadpp");
        if (reloadppn) {
            sessionStorage.removeItem("reloadpp");
            myreloadpp('hey');
        }
    }
    function reloadpp() {
        sessionStorage.setItem("reloadpp", "true");
        document.location.reload();
    }
    function myreloadpp(varia) {
        var l = document.getElementById('link_viewemployeemm');
        l.click();
    }
</script>