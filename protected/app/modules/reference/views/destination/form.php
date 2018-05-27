<div class="page-header page-header-default">
        <div class="page-header-content">
            <div class="page-title">
                <h4><?php echo ($data) ? lang('edit') : lang('add'); ?> <?php echo lang('reference'); ?>: <?php echo lang('destination'); ?></h4>
            </div>

            <div class="heading-elements">
                <div class="heading-btn-group">
                    <a href="<?php echo site_url('reference/destination'); ?>" class="btn btn-link btn-float has-text"><i class="icon-list3 text-primary"></i><span><?php echo lang('list'); ?></span></a>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <form action="<?php echo site_url('reference/destination/save'); ?>" method="post" class="form-horizontal" id="form">
                    <input type="hidden" name="id" value="<?php echo set_value('id', ($data) ? encode($data->id) : ''); ?>">
                    <div class="panel panel-flat">
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo lang('code'); ?></label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" required="" name="code" value="<?php echo ($data) ? $data->code : ''; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo lang('name'); ?></label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" required="" name="name" value="<?php echo ($data) ? $data->name : ''; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="heading-elements action-left">
                                <a class="btn btn-default" href="<?php echo site_url('reference/destination'); ?>"><?php echo lang('button_cancel'); ?></a>
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