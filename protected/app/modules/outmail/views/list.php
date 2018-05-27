<div class="page-header page-header-default">
        <div class="page-header-content">
            <div class="page-title">    
                <h3><?php echo lang('outmail'); ?></h3>
            </div>

            <div class="heading-elements">
                <div class="heading-btn-group">
                    <a href="<?php echo site_url('outmail/form'); ?>" class="btn btn-link btn-float has-text"><i class="icon-plus-circle2 text-primary"></i><span><?php echo lang('add'); ?></span></a>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="panel panel-flat">
            <table class="table table-hover" id="table" data-url="<?php echo site_url('outmail/get_list'); ?>">
                <thead>
                    <tr>
                        <th class="default-sort" data-sort="asc"><?php echo lang('number'); ?></th>
                        <th><?php echo lang('date'); ?></th>
                        <th><?php echo lang('address'); ?></th>
                        <th><?php echo lang('subject'); ?></th>
                        <th><?php echo lang('from'); ?></th>
                        <th><?php echo lang('information'); ?></th>
                        <th class="no-sort text-center" style="width: 20px;"><?php echo lang('actions'); ?></th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
<div id="modal-upload" class="modal fade">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title">Upload File</h5>
            </div>
            <form id="form-upload" method="post" class="" action="<?php echo site_url('outmail/upload_file'); ?>" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="id" id="id" value="">
                    <div class="form-group">
                        <div class="col-md-12">
                            <input type="file" required="" name="file" id="file" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                    <button type="button" onclick="submit_upload()" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>