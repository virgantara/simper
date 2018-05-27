<div class="page-header page-header-default">
        <div class="page-header-content">
            <div class="page-title">    
                <h3><?php echo lang('inmail'); ?></h3>
            </div>

            <div class="heading-elements">
                <div class="heading-btn-group">
                    <a href="<?php echo site_url('inmail/form'); ?>" class="btn btn-link btn-float has-text"><i class="icon-plus-circle2 text-primary"></i><span><?php echo lang('add'); ?></span></a>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="panel panel-flat">
            <div class="table-responsive">
            <table class="table table-hover" id="table" data-url="<?php echo site_url('inmail/get_list'); ?>">
                <thead>
                    <tr>
                        <th class="default-sort" data-sort="asc"><?php echo lang('number'); ?></th>
                        <th><?php echo lang('date'); ?></th>
                        <th><?php echo lang('date_in'); ?></th>
                        <th><?php echo lang('from'); ?></th>
                        <th><?php echo lang('subject'); ?></th>
                        <th><?php echo lang('to'); ?></th>
                        <th><?php echo lang('information'); ?></th>
                        <!--<th><?php echo lang('disposition'); ?></th>-->
                        <th class="no-sort text-center" style="width: 20px;"><?php echo lang('actions'); ?></th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        </div>
    </div>