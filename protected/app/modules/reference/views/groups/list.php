<div class="content-wrapper">
    <div class="page-header page-header-default">
        <div class="page-header-content">
            <div class="page-title">
                <?php echo $breadcrumbs; ?>
                <h4><?php echo lang('group_heading'); ?></h4>
            </div>

            <div class="heading-elements">
                <div class="heading-btn-group">
                    <a href="<?php echo site_url('merchants/groups/form'); ?>" class="btn btn-link btn-float has-text"><i class="icon-plus-circle2 text-primary"></i><span><?php echo lang('group_add_heading'); ?></span></a>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="panel panel-flat">
            <table class="table" id="table" data-url="<?php echo site_url('merchants/groups/get_list'); ?>">
                <thead>
                    <tr>
                        <th class="default-sort" data-sort="asc"><?php echo lang('group_name_th'); ?></th>
                        <th><?php echo lang('group_branch_th'); ?></th>
                        <th class="no-sort text-center" style="width: 20px;"><?php echo lang('actions_th'); ?></th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>