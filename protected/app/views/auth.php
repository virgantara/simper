<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo "{$title}"; ?></title>

        <?php
        foreach ($css as $file) {
            echo "\n    ";
            echo '<link href="' . $file . '" rel="stylesheet" type="text/css" />';
        } echo "\n";
        ?>
        <script type="text/javascript">
            var base_url = '<?php echo base_url(); ?>';
            var site_url = '<?php echo site_url(); ?>';
            var current_url = '<?php echo current_url(); ?>';
        </script>
    </head>
    <body class="login-container" style="background: url(../assets/images/backgrounds/seamless.png)">
        <div class="page-container">
            <div class="page-content">
                <div class="content-wrapper">
                    <div class="text-center">
                        <h5 class="content-group-lg"><?php echo lang('login_heading'); ?></h5>
                    </div>
                    <div class="content pb-20">
                        <form action="<?php echo current_url(); ?>" method="post" id="login">
                            <input type="hidden" value="<?php echo $this->input->get('back'); ?>" name="back">
                            <div class="panel panel-body login-form">
                                <div class="text-center">
                                    <h5 class="content-group-lg"><small class="display-block"><?php echo lang('login_subheading'); ?></small></h5>
                                </div>

                                <div class="form-group has-feedback has-feedback-left">
                                    <input type="email" name="identity" id="identity" class="form-control" placeholder="<?php echo lang('login_identity_label'); ?>" autocomplete="off" >
                                    <div class="form-control-feedback">
                                        <i class="icon-user text-muted"></i>
                                    </div>
                                </div>

                                <div class="form-group has-feedback has-feedback-left">
                                    <input type="password" name="password" id="password" class="form-control" placeholder="<?php echo lang('login_password_label'); ?>" autocomplete="off" >
                                    <div class="form-control-feedback">
                                        <i class="icon-lock2 text-muted"></i>
                                    </div>
                                </div>

                                <div class="form-group login-options">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label class="checkbox-inline">
                                                <input type="checkbox" class="styled" name="remember" value="1">
                                                <?php echo lang('login_remember_label'); ?>
                                            </label>
                                        </div>
                                        <!--                                        <div class="col-sm-6 text-right">
                                                                                    <a href="login_password_recover.html">Forgot password?</a>
                                                                                </div>-->
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn bg-blue btn-block"><?php echo lang('login_submit_btn'); ?> <i class="icon-arrow-right14 position-right"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
        foreach ($js as $file) {
            echo "\n    ";
            echo '<script src="' . $file . '"></script>';
        } echo "\n";
        ?>
    </body>
</html>
