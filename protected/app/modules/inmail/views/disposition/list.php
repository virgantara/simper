<div class="page-header page-header-default">
        <div class="page-header-content">
            <div class="page-title">    
                <h3><?php echo lang('disposition'); ?>: <?php echo $mail->subject; ?></h3>
            </div>

            <div class="heading-elements">
                <div class="heading-btn-group">
                    <a href="<?php echo site_url('inmail'); ?>" class="btn btn-link btn-float has-text"><i class="icon-list3 text-primary"></i><span><?php echo lang('list').' '. lang('inmail'); ?></span></a>
                    <a href="<?php echo site_url('inmail/disposition/form/'.$id); ?>" class="btn btn-link btn-float has-text"><i class="icon-plus-circle2 text-primary"></i><span><?php echo lang('add').' '. lang('disposition'); ?></span></a>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="panel panel-flat">
            <div class="table-responsive">
            <table class="table table-hover" id="table" data-url="<?php echo site_url('inmail/disposition/get_list/'.$id); ?>">
                <thead>
                    <tr>
                        <th class="default-sort" data-sort="asc"><?php echo lang('date'); ?></th>
                        <th><?php echo lang('to_2'); ?></th>
                        <th><?php echo lang('disposition'); ?></th>
                        <th><?php echo lang('note'); ?></th>
                        <th><?php echo lang('from'); ?></th>
                        <th class="no-sort text-center" style="width: 20px;"><?php echo lang('actions'); ?></th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        </div>
    </div>