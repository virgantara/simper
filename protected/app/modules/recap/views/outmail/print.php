<!doctype>
<html>
    <head>
        <title>Cetak Rekap Surat Keluar</title>
        <style>
            html{
                min-height:100%;
                position:relative;
            }
            body {
                width: 100%;
                height: 100%;
                margin: 0;
                padding: 0;
                background-color: #FFF;
                /*font: 16pt Arial, "Helvetica Neue", Helvetica, sans-serif;*/
                color: #000;
                font-family: Times New Roman;
                font-size: 12pt;
                /*                font-style: normal;
                                font-variant: normal;*/
            }
            * {
                box-sizing: border-box;
                -moz-box-sizing: border-box;
            }
            .page {
                width: 210mm;
                min-height: 297mm;
                padding: 4.4mm;
                margin: 10mm auto;
                border: 1px #D3D3D3 solid;
                /*border-radius: 5px;*/
                background: white;
                box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            }

            table{
                /*display: block;*/ 
                width: 100%;
                border-collapse: collapse;
                border-spacing: 0;
            }
            table tr th,
            table tr td{
                vertical-align: middle;
                padding: 2px;
                font-size: 11pt;
            }
            .table-bordered tr th,
            .table-bordered tr td{
                border: 1px #000 solid;
            }
            @page {
                size: A4;
                margin: 0;
                size: portrait
            }
            @media print {
                @page {
                    size: A4;
                    margin: 0;
                    size: portrait
                }
                html, body {
                    width: 210mm;
                    height: 297mm;        
                }
                .page {
                    margin: 0;
                    padding: 4.4mm;
                    border: initial;
                    border-radius: initial;
                    width: initial;
                    min-height: initial;
                    box-shadow: initial;
                    background: initial;
                    page-break-after: always;
                }
            }
        </style>
    </head>
    <body>
        <div class="page">
            <center>
                <img src="<?php echo base_url('assets/images/logo-unida.png'); ?>" width="65px">
                <h3 style="margin-top: 2px;">REKAPITULASI SURAT MASUK FAKULTAS ILMU KESEHATAN<br>UNIVERSITAS DARUSSALAM GONTOR</h3>
            </center>
            <table class="table-bordered">
                <thead>
                    <tr>
                        <th width="5%">Nomor Urut Surat</th>
                        <th width="10%">Tanggal</th>
                        <th width="15%">Nomor Surat Keluar</th>
                        <th width="15%">Alamat</th>
                        <th width="15%">Perihal</th>
                        <th width="15%">Pengirim</th>
                        <th width="10%">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($mails)foreach($mails->result() as $data){ ?>
                    <tr>
                        <td><?php echo number_format($data->sequence, 0, ',', '.'); ?></td>
                        <td><?php echo get_date($data->date); ?></td>
                        <td><?php echo $data->code; ?></td>
                        <td><?php echo $data->to; ?></td>
                        <td><?php echo $data->subject; ?></td>
                        <td><?php echo $data->from; ?></td>
                        <td><?php echo $data->information; ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </body>
</html>