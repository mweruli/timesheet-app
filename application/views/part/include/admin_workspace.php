<div class="row">
    <div class="col-sm-12">
        <div class="tabbable">
            <ul id="myTab2" class="nav nav-tabs">
                <li class="active">
                    <a href="#myTab2_example1" data-toggle="tab" id="my-linkaddsetting">
                        <i class="green fa fa-home"></i>Add Settings
                    </a>
                </li>
                <li>
                    <a href="#myTab2_example2" data-toggle="tab" id="my-link">
                        <i class="green fa fa-edit"></i>View Settings
                    </a>
                </li>
                <?php
                $category = $this->session->userdata('logged_in')['category'];
                if ($category == "suadmin") {
                    echo '<li>
                    <a href="#myTab2_example3" data-toggle="tab" id="my-link_admin">
                        <i class="green fa fa-edit"></i>Manage Administrators
                    </a>
                </li>';
                    echo '<li>
                    <a href="#myTab2_example4" data-toggle="tab">
                        <i class="green fa fa-edit"></i>Field Settings
                    </a>
                </li>';
                    echo '<li>
                    <a href="#myTab2_example5" data-toggle="tab">
                        <i class="green fa fa-edit"></i>Nav Bar Settings
                    </a>
                </li>';
                    echo '<li>
                    <a href="#myTab2_example6" data-toggle="tab">
                        <i class="green fa fa-edit"></i>Upload Data
                    </a>
                </li>';
                }
                ?>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade in active" id="myTab2_example1" id="my-linkcontensetting">
                    <?php echo $this->load->view('part/content/settings/v_additems', '', TRUE); ?>
                </div>
                <div class="tab-pane fade" id="myTab2_example2">
                    <?php echo $this->load->view('part/content/settings/v_adminsetting', '', TRUE); ?>
                </div>
                <div class="tab-pane fade" id="myTab2_example3">
                    <?php echo $this->load->view('part/content/settings/v_admin_listofadmins', '', TRUE); ?>
                </div>
                <div class="tab-pane fade" id="myTab2_example4">
                    <?php echo $this->load->view('part/content/settings/v_admin_listoffieldsettings', '', TRUE); ?>
                </div>
                <div class="tab-pane fade" id="myTab2_example5">
                    <?php echo $this->load->view('part/content/settings/v_navsettings', '', TRUE); ?>
                </div>
                <div class="tab-pane fade" id="myTab2_example6">
                    <?php echo $this->load->view('part/content/settings/v_filetype', '', TRUE); ?>
                </div>
            </div>
        </div>
    </div>
</div>