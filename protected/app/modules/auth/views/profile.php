<div class="content-wrapper">
    <div class="page-header page-header-default">
        <div class="page-header-content">
            <div class="page-title">
                <h3>Pengaturan Akun</h3>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <form action="<?php echo site_url('auth/update_account'); ?>" class="form-horizontal" id="form" method="post">
                    <div class="panel panel-flat">
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Nama</label>
                                <div class="col-md-5">
                                    <input type="text" class="form-control" required="" name="fullname" value="<?php echo $user->fullname; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Email</label>
                                <div class="col-md-4">
                                    <input type="email" class="form-control" disabled value="<?php echo $user->email; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Password Lama</label>
                                <div class="col-md-4">
                                    <input type="password" class="form-control" name="password_old">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Password</label>
                                <div class="col-md-4">
                                    <input type="password" class="form-control" name="password">
                                    <span class="help-block">untuk merubah password isi password lama dan password baru</span>

                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="heading-elements action-left">
                                <div class="pull-right">
                                    <button type="submit" class="btn btn-primary"><?php echo lang('button_save'); ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>