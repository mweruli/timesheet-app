<div class="topbar-tools">
    <!-- start: TOP NAVIGATION MENU -->
    <ul class="nav navbar">
<!--        <li class="right-menu-toggle pull-left">
            <a href="#" class="sb-toggle-left">
                <i class="fa fa-globe toggle-icon"></i> <i class="fa fa-caret-right"></i> <span class="notifications-count badge badge-default hide"> 7</span>
            </a>
        </li>-->
        <li class="dropdown" >
            <p></p>
            <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" data-close-others="true" href="#">
                <span class="messages-count badge badge-default">3</span> <i class="fa fa-envelope"></i> MESSAGES&nbsp;
                <!--badge-default hide-->
            </a>
            <ul class="dropdown-menu dropdown-dark dropdown-messages">
                <li>
                    <span class="dropdown-header"> You have 9 messages</span>
                </li>
                <li>
                    <div class="drop-down-wrapper ps-container" style="width: 250px;">
                        <ul>
                            <li class="unread">
                                <a href="javascript:;" class="unread">
                                    <div class="clearfix">
                                        <div class="thread-image">
                                            <img src="<?= base_url() ?>upload/50_userimagebYE.jpg" alt="">
                                        </div>
                                        <div class="thread-content">
                                            <span class="author">Nicole Bell</span>
                                            <span class="preview">Duis mollis, est non commodo luctus, nisi erat porttitor ligula...</span>
                                            <span class="time"> Just Now</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <div class="clearfix">
                                        <div class="thread-image">
                                            <img src="<?= base_url() ?>upload/50_userimagelN2.png" alt="">
                                        </div>
                                        <div class="thread-content">
                                            <span class="author">Kenneth Ross</span>
                                            <span class="preview">Duis mollis, est non commodo luctus, nisi erat porttitor ligula...</span>
                                            <span class="time">14 hrs</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="view-all">
                    <a href="<?= base_url('company/message') ?>">
                        See All
                    </a>
                </li>
            </ul>
        </li>
        <!-- start: USER DROPDOWN -->
        <li class="dropdown current-user">
            <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" data-close-others="true" href="#">
                <img src="<?= base_url() ?>upload/<?= $small_image = $this->session->userdata('logged_in')['user_image_small']; ?>" class="img-circle" alt=""  height="35" width="35"> 
                <span class="username hidden-xs"><?= $this->session->userdata('logged_in')['firstname'] . " " . $this->session->userdata('logged_in')['lastname'] ?></span> <i class="fa fa-caret-down "></i>
            </a>
            <ul class="dropdown-menu dropdown-dark">
                <li>
                    <a href="<?= base_url('authentication/lockscreen') ?>">
                        Lock Screen
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('authentication/logout') ?>">
                        Log Out
                    </a>
                </li>
            </ul>
        </li>
        <!-- end: USER DROPDOWN -->

    </ul>
    <!-- end: TOP NAVIGATION MENU -->
</div>