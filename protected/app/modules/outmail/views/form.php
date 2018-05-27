 <div class="page-header page-header-default">
        <div class="page-header-content">
            <div class="page-title">
                <h3><?php echo ($data) ? lang('edit') : lang('add'); ?> <?php echo lang('outmail'); ?></h3>
            </div>

            <div class="heading-elements">
                <div class="heading-btn-group">
                    <a href="<?php echo site_url('outmail'); ?>" class="btn btn-link btn-float has-text"><i class="icon-list3 text-primary"></i><span><?php echo lang('list'); ?></span></a>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <form action="<?php echo site_url('outmail/save'); ?>" class="form-horizontal" method="post" id="form" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo ($data) ? encode($data->id) : ''; ?>">
                    <div class="panel panel-flat">
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo lang('date'); ?></label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control pickadate" name="date" required="" value="<?php echo get_date(($data) ? $data->date : date('Y-m-d')); ?>">
                                </div>
                            </div>
                            <?php if (!$data) { ?>
<!--                                <div class="form-group">
                                    <label class="col-md-3 control-label"><?php // echo lang('destination'); ?></label>
                                    <div class="col-md-4">
                                        <select class="bootstrap-select" name="destination" required="" data-live-search="true" data-width="100%">
                                            <?php // if ($destinations) foreach ($destinations->result() as $destination) { ?>
                                                    <option value="<?php // echo $destination->code; ?>" <?php // echo ($data ? ($data->destination == $destination->id ? 'selected' : '') : '');   ?>><?php // echo $destination->name; ?></option>
                                                <?php // } ?>
                                        </select>
                                    </div>
                                </div>-->
                                <div class="form-group">
                                    <label class="col-md-3 control-label"><?php echo lang('classification'); ?></label>
                                    <div class="col-md-4">
                                        <select class="bootstrap-select" name="classification" required="" data-live-search="true" data-width="100%">
                                            <?php if ($classifications) foreach ($classifications->result() as $classification) { ?>
                                                    <option value="<?php echo $classification->code; ?>" <?php // echo ($data ? ($data->classification == $classification->id ? 'selected' : '') : '');  ?>><?php echo $classification->name; ?></option>
                                                <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo lang('address'); ?></label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" required="" name="to" value="<?php echo ($data) ? $data->to : ''; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo lang('subject'); ?></label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" required="" name="subject" value="<?php echo ($data) ? $data->subject : 'Untitled'; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo lang('from'); ?></label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" required="" name="from" value="<?php echo ($data) ? $data->from : ''; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo lang('information'); ?></label>
                                <div class="col-md-4">
                                    <select class="form-control" name="information" required="">
                                        <option value="Biasa" <?php echo ($data ? ($data->information == 'Biasa' ? 'selected' : '') : ''); ?>>Biasa</option>
                                        <option value="Penting" <?php echo ($data ? ($data->information == 'Penting' ? 'selected' : '') : ''); ?>>Penting</option>
                                        <option value="Rahasia" <?php echo ($data ? ($data->information == 'Rahasia' ? 'selected' : '') : ''); ?>>Rahasia</option>
                                        <option value="Segera" <?php echo ($data ? ($data->information == 'Segera' ? 'selected' : '') : ''); ?>>Segera</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="heading-elements action-left">
                                <a class="btn btn-default" href="<?php echo site_url('outmail'); ?>"><?php echo lang('button_cancel'); ?></a>
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