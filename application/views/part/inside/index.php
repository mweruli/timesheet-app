<!DOCTYPE html>
<html lang="en">
    <head>
        <?php echo $this->load->view('part/include/header', '', TRUE); ?>
        <?php echo $this->load->view('css/cssallpages', '', TRUE); ?>
        <!-- end: CSS REQUIRED FOR THIS SUBVIEW CONTENTS-->
        <!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
        <?php echo $this->load->view('css/css_formelement', '', TRUE); ?>
        <?php echo $this->load->view('css/css_table', '', TRUE); ?>
        <!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->
        <?php echo $this->load->view('css/cssallpagesnext', '', TRUE); ?>
        <script src="<?= base_url() ?>assets/validate/moment.min.js"></script>
        <script src="<?= base_url() ?>assets/validate/print.min.js"></script>
        <link rel="stylesheet" href="<?= base_url() ?>assets/validate/daterangepicker.css">
        <script src="<?= base_url() ?>assets/validate/daterangepicker.js"></script>
        <link rel="stylesheet" href="<?= base_url() ?>assets/validate/print.min.css">
    </head>
    <!-- end: HEAD -->
    <!-- start: BODY -->
    <body class="sidebar-close footer-fixed">
        <!-- start: SLIDING BAR (SB) -->
        <?php
        echo $this->load->view('part/inside/upperslide', '', TRUE);
        //Global Variables
        $small_image = $this->session->userdata('logged_in')['user_image_small'];
        $medium_image = $this->session->userdata('logged_in')['user_image_medium'];
        $large_image = $this->session->userdata('logged_in')['user_image_big'];
        //Names
        $firstname = $this->session->userdata('logged_in')['firstname'];
        $lastname = $this->session->userdata('logged_in')['lastname'];
        ?>
        <!-- end: SLIDING BAR -->
        <div class="main-wrapper">
            <!-- start: TOPBAR -->
            <header class="topbar navbar navbar-inverse navbar-fixed-top inner">
                <!-- start: TOPBAR CONTAINER -->
                <div class="container">
                    <div class="navbar-header">
                        <a href="#" class="sb-toggle-left">
                            <i class="fa fa-globe toggle-icon"></i> <i class="fa fa-caret-right"></i>
                        </a>
                        <a class="sb-toggle-left hidden-md hidden-lg" href="#main-navbar">
                            <i class="fa fa-bars"></i>
                        </a>
                        <!-- start: LOGO -->
                        <a class="navbar-brand" href="#">
                            <img src="<?= base_url() ?>assets/images/logo.png" alt="Alfabiz Timesheet"/>
                        </a>
                        <!-- end: LOGO -->
                    </div>
                    <?php echo $this->load->view('part/inside/profile_menu', '', TRUE); ?>
                </div>
                <!-- end: TOPBAR CONTAINER -->
            </header>
            <!-- end: TOPBAR -->
            <!-- start: PAGESLIDE LEFT -->
            <a class="closedbar inner hidden-sm hidden-xs" href="#">
            </a>
            <nav id="pageslide-left" class="pageslide inner">
                <div class="navbar-content">
                    <!-- start: SIDEBAR -->
                    <div class="main-navigation left-wrapper transition-left">
                        <div class="navigation-toggler hidden-sm hidden-xs">
                            <a href="#main-navbar" class="sb-toggle-left">
                            </a>
                        </div>
                        <div class="user-profile border-top padding-horizontal-10 block">
                            <div class="inline-block">
                                <img src="<?= base_url() ?>upload/<?= $medium_image ?>" alt="" width="60" height="60">
                            </div>
                            <div class="inline-block">
                                <h5 class="no-margin"> Welcome </h5>
                                <h4 class="no-margin"><?= $firstname . " " . neat_trim($lastname, 1, '.') ?></h4>
                                <a class="btn user-options sb_toggle ">
                                    <i class="fa fa-cog"></i>
                                </a>
                            </div>
                        </div>
                        <!-- start: MAIN NAVIGATION MENU -->
                        <?php echo $this->load->view('part/inside/nav', '', TRUE); ?>
                        <!-- end: MAIN NAVIGATION MENU -->
                    </div>
                    <!-- end: SIDEBAR -->
                </div>
                <div class="slide-tools">
                    <div class="col-xs-6 text-left no-padding">
                        <a class="btn btn-sm status" href="#">
                            Status <i class="fa fa-dot-circle-o text-green"></i> <span>Online</span>
                        </a>
                    </div>
                    <div class="col-xs-6 text-right no-padding">
                        <a class="btn btn-sm log-out text-right" href="<?= base_url() ?>">
                            <i class="fa fa-power-off"></i> Log Out
                        </a>
                    </div>
                </div>
            </nav>
            <!-- end: PAGESLIDE LEFT -->
            <!-- start: PAGESLIDE RIGHT -->
            <div id="pageslide-right" class="pageslide slide-fixed inner">

            </div>
            <!-- end: PAGESLIDE RIGHT -->
            <!-- start: MAIN CONTAINER -->
            <div class="main-container inner">
                <!-- start: PAGE -->
                <div class="main-content" >
                    <!-- start: PANEL CONFIGURATION MODAL FORM -->
                    <div class="modal fade" id="panel-config" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                        &times;
                                    </button>
                                    <h4 class="modal-title">Panel Configuration</h4>
                                </div>
                                <div class="modal-body">
                                    Here will be a configuration form
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">
                                        Close
                                    </button>
                                    <button type="button" class="btn btn-primary">
                                        Save changes
                                    </button>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->
                    <!-- end: SPANEL CONFIGURATION MODAL FORM -->
                    <div class="container">
                        <!-- start: PAGE HEADER -->
                        <!-- start: TOOLBAR -->
                        <div class="toolbar row" style="max-height: 100px;height: 100%;" hidden="true">
                            <div class="col-sm-6 hidden-xs">
                                <div class="page-header">
                                    <h1>Dashboard <small>overview &amp; stats </small></h1>
                                </div>
                            </div>
                            <?php echo $this->load->view('part/inside/upbar', '', TRUE); ?>
                        </div>
                        <!-- end: TOOLBAR -->
                        <!-- end: PAGE HEADER -->
                        <!-- start: BREADCRUMB -->
                        <?php echo $this->load->view('part/inside/subline', '', TRUE); ?>
                        <!-- end: BREADCRUMB -->
                        <!-- start: PAGE CONTENT -->
                        <?php
                        $this->load->view($content_part);
                        ?>
                        <!-- end: PAGE CONTENT-->
                    </div>
                    <div class="subviews">
                        <div class="subviews-container"></div>
                    </div>
                </div>
                <!-- end: PAGE -->
            </div>
            <!-- end: MAIN CONTAINER -->
            <!-- start: FOOTER -->
            <?php echo $this->load->view('part/inside/footer_in', '', TRUE); ?>
            <!-- end: FOOTER -->
            <!-- start: SUBVIEW SAMPLE CONTENTS -->
            <!-- *** NEW NOTE *** -->
            <?php echo $this->load->view('part/inside/newnote', '', TRUE); ?>
            <!-- *** READ NOTE *** -->
            <?php echo $this->load->view('part/inside/readnote', '', TRUE); ?>
            <!-- *** SHOW CALENDAR *** -->
            <?php echo $this->load->view('part/inside/showcalendar', '', TRUE); ?>
            <!-- *** NEW EVENT *** -->
            <?php echo $this->load->view('part/inside/newevent', '', TRUE); ?>
            <!-- *** READ EVENT *** -->
            <?php echo $this->load->view('part/inside/readevent', '', TRUE); ?>
            <!-- *** NEW CONTRIBUTOR *** -->
            <?php echo $this->load->view('part/inside/newcontributor', '', TRUE); ?>
            <!-- *** SHOW CONTRIBUTORS *** -->
            <?php echo $this->load->view('part/inside/showcontributors', '', TRUE); ?>
            <!-- end: SUBVIEW SAMPLE CONTENTS -->
        </div>
        <?php echo $this->load->view('js/alljspages', '', TRUE); ?>
        <?php echo $this->load->view('js/formelement', '', TRUE); ?>
        <?php echo $this->load->view('js/js_notification', '', TRUE); ?>
        <?php echo $this->load->view('js/js_userprofile', '', TRUE); ?>
        <script src="<?= base_url() ?>assets/js/main.js"></script>
        <?php echo $this->load->view('js/js_table', '', TRUE); ?>
        <script>
            jQuery(document).ready(function () {
                Main.init();
                SVExamples.init();
                FormElements.init();
//                TableData.init();
//                PagesUserProfile.init();
//                Index.init();
//                UINotifications.init();
            });
        </script>
    </body>
    <!-- end: BODY -->
</html>