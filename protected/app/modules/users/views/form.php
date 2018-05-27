 <div class="page-header page-header-default">
        <div class="page-header-content">
            <div class="page-title">
                <h3><?php echo ($data) ? lang('edit') : lang('add'); ?> User</h3>
            </div>

            <div class="heading-elements">
                <div class="heading-btn-group">
                    <a href="<?php echo site_url('users'); ?>" class="btn btn-link btn-float has-text"><i class="icon-list3 text-primary"></i><span><?php echo lang('list'); ?></span></a>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <form action="<?php echo site_url('users/save'); ?>" method="post" class="form-horizontal" id="form">
                    <input type="hidden" name="id" value="<?php echo ($data) ? encode($data->id) : ''; ?>">
                    <div class="panel panel-flat">
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Nama</label>
                                <div class="col-md-5">
                                    <input type="text" class="form-control" required="" name="fullname" value="<?php echo ($data) ? $data->fullname : ''; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Email</label>
                                <div class="col-md-4">
                                    <input type="email" class="form-control" <?php echo ($data) ? 'disabled' : 'required'; ?> name="email" value="<?php echo ($data) ? $data->email : ''; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Password</label>
                                <div class="col-md-4">
                                    <input type="password" class="form-control" <?php echo ($data) ? '' : 'required'; ?> name="password">
                                    <?php if ($data) { ?>
                                        <span class="help-block">Biarkan kosong jika tidak ingin mengubah password</span>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="heading-elements action-left">
                                <a class="btn btn-default" href="<?php echo site_url('users'); ?>"><?php echo lang('button_cancel'); ?></a>
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