<!DOCTYPE html>
<html lang="en" class="no-js">
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
         <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/bootstrap/css/bootstrap.min.css">
       
    </head>
    <!-- end: HEAD -->
    <!-- start: BODY -->
    <body class="login">
        <div class="row">
            <div class="main-login col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
                <div class="logo">
                    <img src="<?= base_url() ?>assets/images/logo.png">
                </div>
                <!-- start: LOGIN BOX -->
                <div class="box-login">
                    <h3>Sign in to your account</h3>
<!--                    <p>
                        Please enter your name and password to log in.
                    </p>-->
                    <?php
                    $attributes = array(
                        'class' => 'form-login'
                    );
                    echo form_open(base_url('authentication/login'), $attributes);
                    echo '<font size="2" color="red">' . $this->session->flashdata('status') . '</font>';
                    echo '<font size="2" color="green">' . $this->session->flashdata('success') . '</font><br><br>';
                    ?>
                    <!--                    <div class="errorHandler alert alert-danger no-display">
                                            <i class="fa fa-remove-sign"></i> You have some form errors. Please check below.
                                        </div>-->
                    <fieldset>
                        <div class="form-group">
                            <span class="input-icon">
                                <input type="text" class="form-control" name="user_id" placeholder="User Email">
                                <i class="fa fa-user"></i> </span>
                            <div class="control-group error">
                                <h6 class="help-inline"><font size="1" color="red"><?php echo $this->session->flashdata('user_id'); ?></font></h6>
                            </div>
                        </div>
                        <div class="form-group form-actions">
                            <span class="input-icon">
                                <input type="password" class="form-control password" name="password" placeholder="Password">
                                <i class="fa fa-lock"></i>
                                <div class="control-group error">
                                    <h6 class="help-inline"><font size="1" color="red"> <?php echo $this->session->flashdata('password'); ?></font></h6>
                                </div>
                                <a class="forgot" href="#">
                                    I forgot my password
                                </a> 
                            </span>
                        </div>
                        <div class="form-actions">
                            <label for="remember" class="checkbox-inline">
                                <input type="checkbox" class="grey remember" id="remember" name="remember">
                                Keep me signed in
                            </label>
                            <button type="submit" class="btn btn-green pull-right">
                                Login <i class="fa fa-arrow-circle-right"></i>
                            </button>
                        </div>
                        <div class="new-account">
                            Don't have an account yet?
                            <a href="#" class="register">
                                Contact Administrator
                            </a>
                        </div>
                    </fieldset>
                    </form>
                    <!-- start: COPYRIGHT -->
                    <?php echo $this->load->view('part/include/footer', '', TRUE); ?>
                    <!-- end: COPYRIGHT -->
                </div>
                <!-- end: LOGIN BOX -->
                <!-- start: FORGOT BOX -->
                <div class="box-forgot">
                    <h3>Forget Password?</h3>
                    <p>
                        Enter your e-mail address below to reset your password.
                    </p>
                    <?php
                    $attributesxd = array(
                        'class' => 'form-forgot',
                        'role' => 'form'
                    );
                    echo form_open(base_url("authentication/forgot_pass"), $attributesxd);
                    ?>
                    <form class="form-forgot">
                        <!--                        <div class="errorHandler alert alert-danger no-display">
                                                    <i class="fa fa-remove-sign"></i> You have some form errors. Please check below.
                                                </div>-->
                        <fieldset>
                            <div class="form-group">
                                <span class="input-icon">
                                    <input type="email" class="form-control" name="email" placeholder="Email">
                                    <i class="fa fa-envelope"></i> </span>
                            </div>
                            <div class="form-actions">
                                <a class="btn btn-light-grey go-back">
                                    <i class="fa fa-chevron-circle-left"></i> Log-In
                                </a>
                                <button type="submit" class="btn btn-green pull-right">
                                    Submit <i class="fa fa-arrow-circle-right"></i>
                                </button>
                            </div>
                        </fieldset>
                    </form>
                    <!-- start: COPYRIGHT -->
                    <?php echo $this->load->view('part/include/footer', '', TRUE); ?>
                    <!-- end: COPYRIGHT -->
                </div>
                <div class="box-register">
                    <h3>Request For An Account</h3>
                    <p>
                        Enter your personal details below:
                    </p>
                    <?php
                    $attributesx = array(
                        'class' => 'form-register',
                        'role' => 'form'
                    );
                    echo form_open(base_url("authentication/resquestaccount"), $attributesx);
                    ?>
                    <!--                        <div class="errorHandler alert alert-danger no-display">
                                                <i class="fa fa-remove-sign"></i> You have some form errors. Please check below.
                                            </div>-->
                    <fieldset>
                        <div class="form-group">
                            <input type="text" class="form-control" name="firstname" id="firstname" placeholder="First Name">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Last Name">
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <input type="date" data-date-format="dd-mm-yyyy" data-date-viewmode="years" name="date_of_birth" class="form-control date-picker">
                                <span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div>
                                <label class="radio-inline">
                                    <input type="radio"  value="Female" name="id_gender">
                                    Female
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" value="Male" name="id_gender">
                                    Male
                                </label>
                            </div>
                        </div>
                        <p>
                            Enter your account details below:
                        </p>
                        <div class="form-group">
                            <span class="input-icon">
                                <input type="email" class="form-control" name="email" placeholder="Email">
                                <i class="fa fa-envelope"></i> </span>
                        </div>
                        <div class="form-group">
                            <div>
                                <label  class="checkbox-inline">
                                    <input type="checkbox"  id="agree" name="agree">
                                    I agree to the Terms of Service and Privacy Policy
                                </label>
                            </div>
                        </div>
                        <div class="form-actions">
                            Already have an account?
                            <a href="#" class="go-back">
                                Log-in
                            </a>
                            <button type="submit" class="btn btn-green pull-right">
                                Submit <i class="fa fa-arrow-circle-right"></i>
                            </button>
                        </div>
                    </fieldset>
                    </form>
                    <!-- start: COPYRIGHT -->
                    <?php echo $this->load->view('part/include/footer', '', TRUE); ?>
                    <!-- end: COPYRIGHT -->
                </div>
                <!-- end: FORGOT BOX -->
                <!-- start: REGISTER BOX -->
                <!-- end: REGISTER BOX -->
            </div>
        </div>
        <script src="<?= base_url() ?>assets/plugins/jQuery/jquery-2.1.1.min.js"></script>
        <script src="<?= base_url() ?>assets/validate/formValidation.min.js"></script>
        <script src="<?= base_url() ?>assets/validate/bootstrap.min.js"></script>
        <script src="<?= base_url() ?>assets/plugins/jquery-ui/jquery-ui-1.10.2.custom.min.js"></script>
        <script src="<?= base_url() ?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
        <!--<script src="<?= base_url() ?>assets/plugins/iCheck/jquery.icheck.min.js"></script>-->
        <script src="<?= base_url() ?>assets/plugins/jquery.transit/jquery.transit.js"></script>
        <script src="<?= base_url() ?>assets/plugins/TouchSwipe/jquery.touchSwipe.min.js"></script>
        <script src="<?= base_url() ?>assets/js/main.js"></script>
        <script src="<?= base_url() ?>assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
        <script src="<?= base_url() ?>assets/js/login.js"></script>
        <script src="<?= base_url() ?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
        <script src="<?= base_url() ?>assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
        <script src="<?= base_url() ?>assets/watable/jquery.watable.js"></script>
        <script>
            var ask_foraccount = "<?php echo base_url("authentication/resquestaccount"); ?>";
            jQuery(document).ready(function () {
                $('#form_register')
                        .formValidation({
                            framework: 'bootstrap',
                            icon: {
//                                valid: 'glyphicon glyphicon-ok',
//                                invalid: 'glyphicon glyphicon-remove',
//                                validating: 'glyphicon glyphicon-refresh'
                            },
                            fields: {
                                firstname: {
                                    validators: {
                                        notEmpty: {
                                            message: 'First Name is required'
                                        },
                                        regexp: {
                                            regexp: /^[a-zA-Z\s]+$/,
                                            message: 'First Name can only consist of alphabetical characters'
                                        }
                                    }
                                },
                                lastname: {
                                    validators: {
                                        notEmpty: {
                                            message: 'Last Name is required'
                                        },
                                        regexp: {
                                            regexp: /^[a-zA-Z\s]+$/,
                                            message: 'Last Name can only consist of alphabetical characters'
                                        }
                                    }
                                },
                                date_of_birth: {
                                    validators: {
                                        notEmpty: {
                                            message: 'Date of Birth is required'
                                        }
                                        ,
                                        date: {
                                            format: 'mm/dd/yyyy',
                                            message: 'The date is not a valid'
                                        }
                                    }
                                },
                                id_gender: {
                                    validators: {
                                        notEmpty: {
                                            message: 'Gender Option is required'
                                        }
                                    }
                                }
                            }
                        });
                Main.init();
                Login.init();
            });
        </script>
    </body>
</html>