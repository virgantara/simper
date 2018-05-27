<div class="content">
<div class="row">
    <div class="col-sm-12 col-md-6">
        <h2>Welcome, <?php echo $user->fullname; ?>.</h2>
        <p class="text-muted">Have a nice day</p>
        <p>Silahkan tambahkan <a class="btn border-slate text-slate-800 btn-flat" href="<?php echo site_url('inmail/form'); ?>">Surat Masuk</a> atau buat <a class="btn border-slate text-slate-800 btn-flat" href="<?php echo site_url('outmail/form'); ?>">Surat Keluar</a></p>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="panel panel-body">
            <div class="media no-margin">
                <div class="media-body">
                    <h3 class="no-margin text-semibold"><?php echo number_format($total->inmail, 0, ',', '.'); ?></h3>
                    <span class="text-uppercase text-size-mini text-muted">total surat masuk</span>
                </div>
                <div class="media-right media-middle">
                    <i class="icon-inbox icon-3x text-blue-400"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="panel panel-body">
            <div class="media no-margin">
                <div class="media-body">
                    <h3 class="no-margin text-semibold"><?php echo number_format($total->outmail, 0, ',', '.'); ?></h3>
                    <span class="text-uppercase text-size-mini text-muted">total surat keluar</span>
                </div>
                <div class="media-right media-middle">
                    <i class="icon-inbox-alt icon-3x text-danger-400"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="panel panel-flat">
            <div class="panel-heading">
                <h5 class="panel-title">10 Surat Dibuat Terakhir</h5>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nomor</th>
                            <th>Tanggal</th>
                            <!--<th>Perihal</th>-->
                            <th>Jenis</th>
                            <th>Pembuat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($last_mail) foreach ($last_mail->result() as $mail) { ?>
                                <tr>
                                    <td><?php echo $mail->code; ?></td>
                                    <td><?php echo get_date($mail->date); ?></td>
                                    <!--<td><?php // echo $mail->subject;  ?></td>-->
                                    <td><?php echo ($mail->type == 'in') ? 'Masuk' : 'Keluar'; ?></td>
                                    <td><?php echo $mail->creator; ?></td>
                                </tr>
                            <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="panel panel-flat">
            <div class="panel-heading">
                <h5 class="panel-title">Surat Keluar Belum Upload Arsip</h5>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nomor</th>
                            <th>Tanggal</th>
                            <!--<th>Perihal</th>-->
                            <th>Tujuan</th>
                            <th>Pembuat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($outmail) foreach ($outmail->result() as $mail) { ?>
                                <tr>
                                    <td><?php echo $mail->code; ?></td>
                                    <td><?php echo get_date($mail->date); ?></td>
                                    <!--<td><?php // echo $mail->subject;  ?></td>-->
                                    <td><?php echo $mail->to; ?></td>
                                    <td><?php echo $mail->creator; ?></td>
                                </tr>
                            <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>    
</div>    