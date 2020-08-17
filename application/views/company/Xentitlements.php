<div class="row" >
    <div class="col-sm-12">
        <div class="tabbable">
            <ul id="myTab2" class="nav nav-tabs">
                <li class="active">
                    <a href="#myTab2_addperemployee" data-toggle="tab" > 
                        <i class="fa fa-user">&nbsp;Add Per Employee </i>
                    </a>
                </li>
                <li>
                    <a href="#myTab2_addperdepartment" data-toggle="tab" id="link_tab_addclient"> 
                        <i class="green fa fa-home">&nbsp;Add Per Department</i>
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane  in active" id="myTab2_addperemployee">
                    <?php echo $this->load->view('company/leave/addperemployee', '', TRUE); ?>
                </div>
                <div class="tab-pane fade" id="myTab2_addperdepartment">
                    <?php echo $this->load->view('company/leave/addperdepartment', '', TRUE); ?>
                </div>
            </div>
        </div>
    </div>
</div>