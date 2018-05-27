<div class="page-header page-header-default">
        <div class="page-header-content">
            <div class="page-title">
                <h3>User</h3>
            </div>

            <div class="heading-elements">
                <div class="heading-btn-group">
                    <a href="<?php echo site_url('users/form'); ?>" class="btn btn-link btn-float has-text"><i class="icon-plus-circle2 text-primary"></i><span><?php echo lang('add'); ?></span></a>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="panel panel-flat">
            <table class="table" id="table" data-url="<?php echo site_url('users/get_list'); ?>">
                <thead>
                    <tr>
                        <th class="default-sort" data-sort="asc">Email</th>
                        <th>Nama</th>
                        <th class="no-sort text-center" style="width: 20px;"><?php echo lang('actions_th'); ?></th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>