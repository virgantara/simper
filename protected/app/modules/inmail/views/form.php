<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h3><?php echo ($data) ? lang('edit') : lang('add'); ?> <?php echo lang('inmail'); ?></h3>
        </div>

        <div class="heading-elements">
            <div class="heading-btn-group">
                <a href="<?php echo site_url('inmail'); ?>" class="btn btn-link btn-float has-text"><i class="icon-list3 text-primary"></i><span><?php echo lang('list'); ?></span></a>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <form action="<?php echo site_url('inmail/save'); ?>" class="form-horizontal" method="post" id="form" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo ($data) ? encode($data->id) : ''; ?>">
                <div class="panel panel-flat">
                    <div class="panel-body">
                        <!--                        <div class="tabbable">
                                                    <ul class="nav nav-tabs">
                                                        <li class="active"><a href="#general" data-toggle="tab">Data</a></li>
                                                        <li><a href="#disposition" data-toggle="tab">E-Disposisi</a></li>
                                                    </ul>
                                                    <div class="tab-content">
                                                        <div class="tab-pane active" id="general">-->
                        <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo lang('number'); ?> Surat Masuk</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" required="" name="code" value="<?php echo ($data) ? $data->code : ''; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo lang('date_in'); ?> Surat</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control pickadate" name="date_in" required="" value="<?php echo get_date(($data) ? $data->date_in : date('Y-m-d')); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo lang('date'); ?> Surat</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control pickadate" name="date" required="" value="<?php echo get_date(($data) ? $data->date : date('Y-m-d')); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo lang('classification'); ?></label>
                            <div class="col-md-4">
                                <select class="bootstrap-select" name="classification" required="" data-live-search="true" data-width="100%">
                                    <?php if ($classifications) foreach ($classifications->result() as $classification) { ?>
                                            <option value="<?php echo $classification->id; ?>" <?php echo ($data ? ($data->classification == $classification->id ? 'selected' : '') : ''); ?>><?php echo $classification->name; ?></option>
                                        <?php } ?>
                                </select>
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
                            <label class="col-md-3 control-label"><?php echo lang('to'); ?></label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" required="" name="to" value="<?php echo ($data) ? $data->to : ''; ?>">
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
                        <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo lang('file'); ?></label>
                            <div class="col-md-4">
                                <input type="file" class="form-control" <?php echo ($data) ? '' : 'required'; ?> name="file">
                                <?php if ($data) { ?>
                                    <small>*Biarkan kosong jika tidak ingin merubah file</small>
                                <?php } ?>
                            </div>
                        </div>
                        <!--                                </div>
                                                        <div class="tab-pane" id="disposition">
                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label"><?php echo lang('disposition'); ?></label>
                                                                <div class="col-md-9">
                                                                    <select class="bootstrap-select" name="disposition_reference" required="" data-live-search="true" data-width="100%">
                        <?php if ($dispositions) foreach ($dispositions->result() as $disposition) { ?>
                                                                                                <option value="<?php echo $disposition->id; ?>" <?php echo ($data ? ($data->disposition_reference == $disposition->id ? 'selected' : '') : ''); ?>><?php echo $disposition->name; ?></option>
                            <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label"><?php echo lang('note'); ?></label>
                                                                <div class="col-md-9">
                                                                    <input type="text" class="form-control" required="" name="disposition_note" value="<?php echo ($data) ? $data->disposition_note : ''; ?>">
                                                                </div>
                                                            </div>
                                                        </div>-->
                        <!--</div>-->
                        <!--</div>-->
                    </div>
                    <div class="panel-footer">
                        <div class="heading-elements action-left">
                            <a class="btn btn-default" href="<?php echo site_url('inmail'); ?>"><?php echo lang('button_cancel'); ?></a>
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