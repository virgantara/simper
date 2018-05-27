<div class="content-wrapper">
    <div class="page-header page-header-default">
        <div class="page-header-content">
            <div class="page-title">
                <?php echo $breadcrumbs; ?>
                <h4><?php echo ($data) ? lang('user_edit_heading') : lang('user_add_heading'); ?></h4>
            </div>

            <div class="heading-elements">
                <div class="heading-btn-group">
                    <a href="<?php echo site_url('merchants/users'); ?>" class="btn btn-link btn-float has-text"><i class="icon-list3 text-primary"></i><span><?php echo lang('user_list_heading'); ?></span></a>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <form action="<?php echo site_url('merchants/users/save'); ?>" method="post" class="form-horizontal" id="form">
                    <input type="hidden" name="id" value="<?php echo set_value('id', ($data) ? encode($data->id) : ''); ?>">
                    <div class="panel panel-flat">
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="name"><?php echo lang('user_form_name_label'); ?></label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" required="" id="name" name="fullname" value="<?php echo ($data) ? $data->fullname : ''; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="email"><?php echo lang('user_form_email_label'); ?></label>
                                <div class="col-md-4">
                                    <input type="email" class="form-control" <?php echo ($data) ? 'disabled' : 'required'; ?> id="email" name="email" value="<?php echo ($data) ? $data->email : ''; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="password"><?php echo lang('user_form_password_label'); ?></label>
                                <div class="col-md-4">
                                    <input type="password" class="form-control" <?php echo ($data) ? '' : 'required'; ?> id="password" name="password">
                                    <?php if ($data) { ?>
                                        <span class="help-block">Biarkan kosong jika tidak ingin mengubah password</span>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label" for="telephone"><?php echo lang('user_form_telephone_label'); ?></label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" required="" id="telephone" name="telephone" value="<?php echo ($data) ? $data->telephone : ''; ?>">
                                </div>
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
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var rules_form = {};
</script>