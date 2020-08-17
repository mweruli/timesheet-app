<div class="row" novalidate>
    <div class="col-sm-12">
        <div class="tabbable">
            <ul id="myTab2" class="nav nav-tabs">
                <li class="active"><a href="#myTab2_example1" data-toggle="tab"
                                      id="link_tab_addclient"> <i class="green fa fa-home"></i>List Of
                        Clients
                    </a></li>
                <li><a href="#myTab2_example3" data-toggle="tab"
                       id="link_list_all_clients"> <i class="green fa fa-list"></i>&nbsp;Add
                        Client
                    </a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade in active" id="myTab2_example1">
                    <?php echo $this->load->view('part/content/cli/v_clients_list', '', TRUE); ?>
                </div>
                <div class="tab-pane fade" id="myTab2_example3">
                    <?php echo $this->load->view('part/content/cli/v_add_client', '', TRUE); ?>
                </div>
            </div>
        </div>
    </div>
</div>