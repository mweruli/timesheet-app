<div id="slidingbar-area">
    <div id="slidingbar">
        <div class="row">
            <!-- start: SLIDING BAR FIRST COLUMN -->
            <div class="col-md-4 col-sm-4">
                <h2>My Options</h2>
                <div class="row">
                    <div class="col-xs-6 col-lg-3">
                        <button class="btn btn-icon btn-block space10">
                            <i class="fa fa-folder-open-o"></i>
                            Projects <span class="badge badge-info partition-red"> 4 </span>
                        </button>
                    </div>
                    <div class="col-xs-6 col-lg-3">
                        <button class="btn btn-icon btn-block space10">
                            <i class="fa fa-envelope-o"></i>
                            Messages <span class="badge badge-info partition-red"> 23 </span>
                        </button>
                    </div>
                    <div class="col-xs-6 col-lg-3">
                        <button class="btn btn-icon btn-block space10">
                            <i class="fa fa-calendar-o"></i>
                            Calendar <span class="badge badge-info partition-blue"> 5 </span>
                        </button>
                    </div>
                    <div class="col-xs-6 col-lg-3">
                        <button class="btn btn-icon btn-block space10">
                            <i class="fa fa-bell-o"></i>
                            Notifications <span class="badge badge-info partition-red"> 9 </span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- end: SLIDING BAR FIRST COLUMN -->
            <!-- start: SLIDING BAR SECOND COLUMN -->
            <!-- end: SLIDING BAR SECOND COLUMN -->
            <!-- start: SLIDING BAR THIRD COLUMN -->
            <div class="col-md-4 col-sm-4">
                <h2>My Info</h2>
                <address class="margin-bottom-40">
                    <?= $this->session->userdata('logged_in')['firstname'] . " " . $this->session->userdata('logged_in')['lastname']; ?>
                    <br>
                    P: <?php
                    echo $this->session->userdata('logged_in')['cellphone'];
                    ?>  
                    <br>
                    Email:
                    <a href="#">
                        <?= $this->session->userdata('logged_in')['emailaddress'] ?>
                    </a>
                </address>
                <!--                <a class="btn btn-transparent-white" href="#">
                                    <i class="fa fa-pencil"></i> Edit
                                </a>-->
            </div>
            <!-- end: SLIDING BAR THIRD COLUMN -->
        </div>
        <div class="row">
            <!-- start: SLIDING BAR TOGGLE BUTTON -->
            <div class="col-md-12 text-center">
                <a href="#" class="sb_toggle"><i class="fa fa-chevron-up"></i></a>
            </div>
            <!-- end: SLIDING BAR TOGGLE BUTTON -->
        </div>
    </div>
</div>