<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Cetak Data Peserta Pelatihan</title>
        <meta name="description" content="<?= (isset($app_descs) ? $app_descs : ''); ?>">
        <meta name="author" content="<?= (isset($app_author) ? $app_author : ''); ?>">
        <meta name="keywords" content="<?= (isset($app_keys) ? $app_keys : ''); ?>" />
        <link rel="icon" type="image/png" href="/digitaltalent/assets/img/favicon.ico">
        <style>
            @media print{@page {size: landscape}}
            
            p{
                margin: 1 0;
            }
            h1{
                margin: 1 0;
            }
            h2{
                margin: 1 0;
            }
            
            h3{
                margin: 1 0;
            }
            .print-area{
                margin: auto;
                max-width: 33cm;
                padding: 1cm;
            }
            .garis-header{
                border-top: 2px solid #000;
                width: 100%;

            }
            .tabeldata{
                padding: 20px;
            }
            .tabeldata table{
                width: 100%;
                border-collapse: collapse;
                padding: 0 20px;
            }
            .tabeldata table th{
                border: 1px solid #000; 
                padding: 1px 3px;
            }
            .tabeldata table td{
                border: 1px solid #000; 
                padding: 1px 3px;
                vertical-align: top;
            }
            .date-time{
                position:absolute;
                bottom: 5px;
                right: 5px;
                font-size: 10pt;
                display: none;
            }
            .source{
                position:absolute;
                bottom: 5px;
                left: 5px;
                font-size: 10pt;
                display: none;
            }
            @media print {
                .date-time{
                    display: block;
                }
                .source{
                    display: block;
                }
            }
        </style>
    </head>
    <body>
        <div class="print-area">
            <div class="date-time">Dicetak pada : <?=tgl_indo_time(date('Y-m-d H:i:s'));?></div>
            <div class="source">Sumber : <?=site_url('data/peserta/export-to-pdf');?></div>
            <h3 style="text-align:center;">Daftar Peserta Pelatihan</h3> 
            <?php if($peserta AND count($peserta) > 0){ ?>
                
                <h3 style="text-align:center;"><?=$peserta[0]['nama_opd'];?></h3> 
                <h3 style="text-align:center;">Tahun <?=$peserta[0]['tahun_pelatihan'];?></h3> 
            <?php } ?>
            <div class="garis-header"></div>
            <br>
            <div class="tabeldata" >
                <table table class="table table-striped table-hover table-bordered table-xs" style="font-size:8pt !important;">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>NIK</th>
                            <th>NIB</th>
                            <th>Peserta</th>
                            <th>Tempat/Tanggal Lahir</th>
                            <th>Jenis Kelamin</th>
                            <th>Alamat</th>
                            <th>Pendidikan</th>
                            <th>Pekerjaan</th>
                            <th>Email</th>
                            <th>Pelatihan</th>
                            <th>Tanggal Pelatihan</th>
                            <th>Tempat Pelatihan</th>
                            <th>OPD Penyelenggara</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $t=0; 
                            $total_pelatihan = 0;
                            $total_peserta = count($peserta);
                        if(!empty($peserta)){ $no = 1; 
                            $current_pelatihan = '';
                            foreach($peserta as $data): ?>

                            <?php if($current_pelatihan != $data['id_pelatihan']){  $current_pelatihan = $data['id_pelatihan']; $total_pelatihan = $total_pelatihan + 1; ?>
                                <tr>
                                    <td colspan="14" style=""><b><?=$data['nm_pelatihan'];?></b></td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td align="center"><?=$no++;?></td>
                                <td><?=$data['nik'];?></td>
                                <td><?=$data['no_nib'];?></td>
                                <td><?=$data['nama_lengkap'];?></td>
                                <td><?=$data['tempat_lhr'] . ', ' . tgl_indo($data['tanggal_lhr']);?></td>
                                <td><?=$data['jenis_kelamin'];?></td>
                                <td><?=$data['alamat_peserta'] . ', '. $data['kabkota'] . ', ' . $data['provinsi'] ?></td>
                                <td><?=$data['pendidikan'];?></td>
                                <td><?=$data['pekerjaan'];?></td>
                                <td><?=$data['email'];?></td>
                                <td><?=$data['nm_pelatihan'];?></td>
                                <td><?=tgl_indo($data['tanggal_pelatihan']) . ' - ' . tgl_indo($data['tanggal_pelatihan_akhir']) ;?></td>
                                <td><?=$data['tempat_pelatihan'] ?></td>
                                <td><?=$data['nama_opd'] ?></td>
                            </tr>
                        <?php endforeach; } else{ ?>
                            <tr>
                                <td align="center" colspan="14" >Tidak ada data</td>
                            </tr>
                        <?php } ?>
                        <?php if(!empty($peserta)){ ?>
                    
                        <tr>
                            <th colspan="11"></th>
                            <th colspan="2" style="text-align: left;">Total Pelatihan</th>
                            <th><?=$total_pelatihan;?></th>
                        </tr>
                        <tr>
                            <th colspan="11"></th>
                            <th colspan="2" style="text-align: left;">Total Peserta</th>
                            <th><?=$total_peserta; ?></th>
                        </tr>
                    
                    <?php } ?>
                    </tbody>
                </table>
            </div>
            
        </div>
    </body>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <!-- Bootstrap 4 -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function(){
            window.print();
        })
    </script>
</html>