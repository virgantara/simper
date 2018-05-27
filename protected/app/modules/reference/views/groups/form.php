<div class="content-wrapper">
    <div class="page-header page-header-default">
        <div class="page-header-content">
            <div class="page-title">
                <?php echo $breadcrumbs; ?>
                <h4><?php echo ($data) ? lang('group_edit_heading') : lang('group_add_heading'); ?></h4>
            </div>

            <div class="heading-elements">
                <div class="heading-btn-group">
                    <a href="<?php echo site_url('merchants'); ?>" class="btn btn-link btn-float has-text"><i class="icon-list3 text-primary"></i><span><?php echo lang('merchant_list_heading'); ?></span></a>
                    <a href="<?php echo site_url('merchants/groups'); ?>" class="btn btn-link btn-float has-text"><i class="icon-list3 text-primary"></i><span><?php echo lang('group_list_heading'); ?></span></a>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <form action="<?php echo site_url('merchants/groups/save'); ?>" method="post" class="form-horizontal" id="form">
                    <input type="hidden" name="id" value="<?php echo set_value('id', ($data) ? encode($data->id) : ''); ?>">
                    <div class="panel panel-flat">
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="name"><?php echo lang('group_form_name_label'); ?></label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" required="" id="name" name="name" placeholder="<?php echo lang('group_form_name_placeholder'); ?>" value="<?php echo ($data) ? $data->name : ''; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo lang('group_form_branch_label'); ?></label>
                                <div class="col-md-4">
                                    <select class="bootstrap-select" required="" name="branch" data-live-search="true" data-width="100%">
                                        <option value=""></option>
                                        <?php if ($branches) { ?>
                                            <?php foreach ($branches->result() as $branch) { ?>
                                                <option value="<?php echo $branch->id; ?>" <?php echo ($data) ? ($data->branch == $branch->id) ? 'selected' : '' : ''; ?>><?php echo $branch->name; ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="heading-elements action-left">
                                <a class="btn btn-default" href="<?php echo site_url('merchants/groups'); ?>"><?php echo lang('button_cancel'); ?></a>
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