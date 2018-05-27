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
            <div class="panel-body">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Dari Tanggal</label>
                        <input type="text" id="date-start" class="form-control pickadate" value="<?php echo date('d/m/Y'); ?>">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Sampai Tanggal</label>
                        <input type="text" id="date-end" class="form-control pickadate" value="<?php echo date('d/m/Y'); ?>">
                    </div>
                </div>
                <div class="col-sm-3">
                    <br>
                    <button type="button" id="filter" class="btn btn-primary">Filter <i class="icon-arrow-right14 position-right"></i></button>
                    <button type="button" id="print" class="btn btn-success" data-type="out">Cetak <i class="icon-printer position-right"></i></button>
                </div>
            </div>
        </div>
        <div class="panel panel-flat">
            <div class="table-responsive">
                <table class="table table-hover" id="table-recap" data-url="<?php echo site_url('recap/outmail/get_list'); ?>">
                    <thead>
                        <tr>
                            <th class="default-sort" data-sort="asc">Nomor Urut Surat</th>
                            <th>Tanggal</th>
                            <th>Nomor Surat Keluar</th>
                            <th>Alamat</th>
                            <th>Perihal</th>
                            <th>Pengirim</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>