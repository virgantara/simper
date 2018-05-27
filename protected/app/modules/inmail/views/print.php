<!doctype>
<html>
    <head>
        <title>Cetak E-Disposisi</title>
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
                <h2>FAKULTAS ILMU KESEHATAN<br>UNIVERSITAS DARUSSALAM GONTOR<br>LEMBAR DISPOSISI</h2>
            </center>
            <table>
                <tr>
                    <td width="35%;">Tanggal Terima Surat Masuk</td>
                    <td width="8px">:</td>
                    <td><?php echo get_date($data->date_in); ?></td>
                </tr>
                <tr>
                    <td>Nomor Urut Surat Masuk</td>
                    <td>:</td>
                    <td><?php echo number_format($data->sequence, 0, ',', '.'); ?></td>
                </tr>
                <tr>
                    <td>Klasifikasi</td>
                    <td>:</td>
                    <td><?php echo $data->classification_name; ?></td>
                </tr>
                <tr>
                    <td>Tanggal Surat Masuk</td>
                    <td>:</td>
                    <td><?php echo get_date($data->date); ?></td>
                </tr>
                <tr>
                    <td>Nomor Surat Masuk</td>
                    <td>:</td>
                    <td><?php echo $data->code; ?></td>
                </tr>
                <tr>
                    <td>Hal/Perihal</td>
                    <td>:</td>
                    <td><?php echo $data->subject; ?></td>
                </tr>
<!--                <tr>
                    <td>Disposisi</td>
                    <td>:</td>
                    <td><?php // echo $data->disposition_name; ?></td>
                </tr>
                <tr>
                    <td>Catatan</td>
                    <td>:</td>
                    <td><?php // echo $data->disposition_note; ?></td>
                </tr>-->
            </table>
            <br><br>
            <table class="table-bordered">
                <thead>
                    <tr>
                        <th width="10%">Tanggal</th>
                        <th width="15%">Kepada</th>
                        <th width="20%">Disposisi</th>
                        <th width="20%">Catatan</th>
                        <th width="15%">Dari</th>
                        <th width="10%">Paraf</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="height: 400px">&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>
</html>