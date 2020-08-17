<!DOCTYPE html>
<html lang="en" class="no-js">
    <!--<![endif]-->
    <!-- start: HEAD -->
    <head>
        <?php echo $this->load->view('part/include/header', '', TRUE); ?>
        <!-- end: META -->
        <!-- start: MAIN CSS -->
        <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/animate.css/animate.min.css">
        <!--<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/iCheck/skins/all.css">-->
        <link rel="stylesheet" href="<?= base_url() ?>assets/css/styles.css">
        <link rel="stylesheet" href="<?= base_url() ?>assets/css/styles-responsive.css">
        <!--<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/iCheck/skins/all.css">-->
        <?php
        if ($this->session->userdata('logged_in')['firstname'] == "") {
            redirect(base_url());
        }
        ?>
    </head>
    <!-- end: HEAD -->
    <!-- start: BODY -->
    <body class="lock-screen" >
        <div class="main-ls animated flipInX">
            <div class="logo" style="margin-top: -100px;"> 
                <img src="<?= base_url() ?>assets/images/logo.png">
            </div>
            <div class="box-ls">
                <img alt="" src="<?= base_url() ?>/upload/<?= $this->session->userdata('logged_in')['user_image_big'] ?>" height="90" width="90"/>
                <div class="user-info">
                    <h1><i class="fa fa-lock"></i> <?= $this->session->userdata('logged_in')['firstname'] . " " . $this->session->userdata('logged_in')['lastname'] ?></h1>
                    <span><?= $this->session->userdata('logged_in')['emailaddress']; ?></span>
                    <span><em>Please enter your password to un-lock.</em></span>
                    <?php
                    echo form_open(base_url('authentication/unlock'));
                    ?>
                    <div class="input-group">
                        <input type="hidden" name="user_id" value="<?= $this->session->userdata('logged_in')['emailaddress'] ?>" class="form-control">
                        <input type="password" placeholder="Password" name="password" class="form-control">
                        <h6 class="help-inline"><font size="1" color="red"><?php echo $this->session->flashdata('password'); ?></font></h6>
                        <span class="input-group-btn">
                            <button class="btn btn-green" type="submit">
                                <i class="fa fa-chevron-right"></i>
                            </button> </span>
                    </div>
                    <div class="relogin">
                        <a href="<?= base_url() ?>">
                            Not <?= $this->session->userdata('logged_in')['firstname'] . " " . $this->session->userdata('logged_in')['lastname'] ?>?</a>
                    </div>
                    </form>
                </div>
            </div>
            <?php echo $this->load->view('part/include/footer', '', TRUE); ?>
        </div>
        <!--[if gte IE 9]><!-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
        <!--<![endif]-->
        <script src="<?= base_url() ?>assets/plugins/jquery-ui/jquery-ui-1.10.2.custom.min.js"></script>
        <script src="<?= base_url() ?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?= base_url() ?>assets/plugins/jquery-cookie/jquery.cookie.js"></script>
        <script src="<?= base_url() ?>assets/js/main.js"></script>
        <script>
            jQuery(document).ready(function () {
                Main.init();
            });
        </script>
    </body>
    <!-- end: BODY -->
</html>