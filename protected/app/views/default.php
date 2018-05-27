<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo "{$title} - " . settings('company_name'); ?></title>
        <?php
        foreach ($css as $file) {
            echo "\n";
            echo '<link href="' . $file . '" rel="stylesheet" type="text/css" />';
        } echo "\n";
        ?>
        <script type="text/javascript">
            var base_url = '<?php echo base_url(); ?>';
            var site_url = '<?php echo site_url(); ?>';
            var current_url = '<?php echo current_url(); ?>';
        </script>
    </head>

    <body>
        <div class="navbar navbar-inverse">
            <div class="navbar-header">
                <a class="navbar-brand" href="<?php echo site_url(); ?>">
                    <img src="<?php echo base_url('assets/images/logo-unida.png'); ?>" style="display: inline-block;"> SIMPER FIK UNIDA
                    <!--SIP-->
                    <?php // echo settings('company_name'); ?>
                </a>

                <ul class="nav navbar-nav visible-xs-block">
                    <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
                    <li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
                </ul>
            </div>

            <div class="navbar-collapse collapse" id="navbar-mobile">
                <ul class="nav navbar-nav">
                    <li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a></li>
                </ul>
                <p class="navbar-text"><i class="icon-envelop3 position-left"></i> Sistem Informasi Manajemen Persuratan Fakultas Ilmu Kesehatan UNIDA Gontor</p>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown dropdown-user">
                        <a class="dropdown-toggle" data-toggle="dropdown">
                            <span><?php echo $user->fullname; ?></span>
                            <i class="caret"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href="<?php echo site_url('auth/account'); ?>"><i class="icon-cog5"></i> Pengaturan Akun</a></li>
                            <li><a href="<?php echo site_url('auth/logout'); ?>"><i class="icon-switch2"></i> Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <div class="page-container">
            <div class="page-content">
                <div class="sidebar sidebar-main">
                    <div class="sidebar-content">
                        <div class="sidebar-category sidebar-category-visible">
                            <div class="category-content no-padding">
                                <ul class="navigation navigation-main navigation-accordion">

                                    <li class="<?php echo menu_active($menu, 'home'); ?>"><a href="<?php echo site_url(); ?>"><i class="icon-home4"></i> <span>Home</span></a></li>
                                    <li class="<?php echo menu_active($menu, 'inmail'); ?>"><a href="<?php echo site_url('inmail'); ?>"><i class="icon-inbox"></i> <span><?php echo lang('inmail'); ?></span></a></li>
                                    <li class="<?php echo menu_active($menu, 'outmail'); ?>"><a href="<?php echo site_url('outmail'); ?>"><i class="icon-inbox-alt"></i> <span><?php echo lang('outmail'); ?></span></a></li>
                                    <?php if ($this->ion_auth->is_admin()) { ?>
                                        <li class="<?php echo menu_active($menu, 'recap'); ?>">
                                            <a href="#"><i class="icon-clipboard6"></i> <span><?php echo lang('recap'); ?></span></a>
                                            <ul>
                                                <li class="<?php echo menu_active($menu, 'recap_inmail'); ?>"><a href="<?php echo site_url('recap/inmail'); ?>"><?php echo lang('recap') . ' ' . lang('inmail'); ?></a></li>
                                                <li class="<?php echo menu_active($menu, 'recap_outmail'); ?>"><a href="<?php echo site_url('recap/outmail'); ?>"><?php echo lang('recap') . ' ' . lang('outmail'); ?></a></li>
                                            </ul>
                                        </li>
                                        <li class="<?php echo menu_active($menu, 'reference'); ?>">
                                            <a href="#"><i class="icon-archive"></i> <span><?php echo lang('reference'); ?></span></a>
                                            <ul>
                                                <!--<li class="<?php // echo menu_active($menu, 'reference_destination'); ?>"><a href="<?php // echo site_url('reference/destination'); ?>"><?php // echo lang('destination'); ?></a></li>-->
                                                <li class="<?php echo menu_active($menu, 'reference_classification'); ?>"><a href="<?php echo site_url('reference/classification'); ?>"><?php echo lang('classification'); ?></a></li>
                                                <li class="<?php echo menu_active($menu, 'reference_disposition'); ?>"><a href="<?php echo site_url('reference/disposition'); ?>"><?php echo lang('disposition'); ?></a></li>
                                            </ul>
                                        </li>
                                        <li class="<?php echo menu_active($menu, 'user'); ?>"><a href="<?php echo site_url('users'); ?>"><i class="icon-users"></i> <span><?php echo lang('user'); ?></span></a></li>
                                    <?php } ?>
                                </ul>

                            </div>
                        </div>
                    </div>
                    <img class="hidden-sm hidden-xs" src="<?php echo base_url('assets/images/backgrounds/envelope.png'); ?>" style="position: absolute; bottom: 0; width: 260px">
                </div>
                <div class="content-wrapper">
                    <?php echo $output; ?>
                    <div class="footer" style="padding-left: 20px">
                        © 2018. Fakultas Ilmu Kesehatan UNIDA Gontor
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
