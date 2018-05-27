<div class="page-header page-header-default">
        <div class="page-header-content">
            <div class="page-title">
                <h3><?php echo ($data) ? lang('edit') : lang('add'); ?> <?php echo lang('disposition'); ?></h3>
            </div>

            <div class="heading-elements">
                <div class="heading-btn-group">
                    <a href="<?php echo site_url('inmail'); ?>" class="btn btn-link btn-float has-text"><i class="icon-list3 text-primary"></i><span><?php echo lang('list') . ' ' . lang('inmail'); ?></span></a>
                    <a href="<?php echo site_url('inmail/disposition/index/' . $id); ?>" class="btn btn-link btn-float has-text"><i class="icon-list3 text-primary"></i><span><?php echo lang('list') . ' ' . lang('disposition'); ?></span></a>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <form action="<?php echo site_url('inmail/disposition/save/' . $id); ?>" class="form-horizontal" method="post" id="form">
                    <input type="hidden" name="id" value="<?php echo ($data) ? encode($data->id) : ''; ?>">
                    <div class="panel panel-flat">
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo lang('date'); ?></label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control pickadate" name="date" required="" value="<?php echo get_date(($data) ? $data->date : date('Y-m-d')); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo lang('to_2'); ?></label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" required="" name="to" value="<?php echo ($data) ? $data->to : ''; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo lang('disposition'); ?></label>
                                <div class="col-md-9">
                                    <select class="bootstrap-select" name="reference" required="" data-live-search="true" data-width="100%">
                                        <?php if ($dispositions) foreach ($dispositions->result() as $disposition) { ?>
                                                <option value="<?php echo $disposition->id; ?>" <?php echo ($data ? ($data->reference == $disposition->id ? 'selected' : '') : '');   ?>><?php echo $disposition->name; ?></option>
                                            <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo lang('note'); ?></label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" required="" name="note" value="<?php echo ($data) ? $data->note : ''; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo lang('from'); ?></label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" required="" name="from" value="<?php echo ($data) ? $data->from : ''; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="heading-elements action-left">
                                <a class="btn btn-default" href="<?php echo site_url('inmail/disposition/index/' . $id); ?>"><?php echo lang('button_cancel'); ?></a>
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