<?php

/**
 * @author [syafrial zulmi]
 * @email [syafrialzulmi@mail.com]
 * @create date 2019-09-21 13:27:50
 * @modify date 2019-09-21 13:27:50
 * @desc [description]
 */

?>

<div class="box">
    <div class="box-body">

<?php
if (count($jumlahpasien) == 0) {
?>
<div class="row" style="margin-bottom:10px">
    <div class="col-lg-12" style="text-align: center;">
        <div class="alert alert-danger alert-dismissible">
            <h4><i class="icon fa fa-warning"></i> Perhatian!</h4>
            Data pasien belum tersedia, silahkan rekap data pasien terlebih dahulu.
        </div>
    </div>
</div>
<?php
} else {

?>

<div class="row" style="margin-bottom:10px">
    <div class="col-lg-12" style="text-align: center;">
        <div class="alert alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-warning"></i> Perhatian!</h4>
            Informasi dibahawah hanya review pengajuan bahan masakan.
            Silahkan untuk melakukan proses pengajuan bahan masakan.
        </div>
    </div>
</div>

<div class="row" style="margin-bottom:10px">
    <div class="col-lg-12" style="text-align: center;">
        <?php if ($add == 1) { ?> 
            <button type="button" class="btn btn-success generatepengajuanbahan" id="" onclick="javascript:generatePengajuanBahan_semua('<?php echo $tanggalrekappasien;?>','<?php echo $tanggalpengajuan;?>')"><i class="fa fa-file"></i> Proses Pengajuan Bahan Masakan <span id="loading_generate"></span></button>
        <?php } ?>
    </div>
</div>

<div class="row" style="margin-bottom:10px">
    <div class="col-lg-5">
        <table class="table table-bordered">            
            <tr>
                <th>Tanggal Rekap Pasien</th>
                <td>
                    <?php echo $tglrekappasien;?>
                </td>
            </tr>
            <?php
            $no = 1;
            foreach($pengajuan as $tanggalpengajuan){
            ?>
            <tr>
                <th width="50%">Tanggal Pengajuan Bahan <?php echo $no;?></th>
                <td>
                    <?php echo $tanggalpengajuan;?>
                </td>
            </tr> 
            <?php
            $no++;
            }
            ?>                                
        </table>
    </div>
    <div class="col-lg-3">
        <table class="table table-bordered">
        <?php
            $jmlpasien = [];
            foreach ($jumlahpasien as $kelaspasien) {
            ?>
            <tr>
                <th><?php echo $kelaspasien['namakelas'];?></th>
                <td><?php echo $kelaspasien['jumlahpasien'];?></td>
            </tr>
            <?php
                $jmlpasien[] = $kelaspasien['jumlahpasien'];
            }
            ?>
            <tr>
                <th width="60%">Jumlah pasien</th>
                <td><?php echo array_sum($jmlpasien);?></td>
            </tr>
        </table>
    </div>    
</div>

<div class="row" style="margin-bottom:10px">
    <?php
    $i = 0;
    foreach ($jenismenumasakan as $jenis_menumasakan) {
    ?>
    <div class="col-lg-4">
        <table class="table table-bordered">
            <tr>
                <th width="40%">Menu Masakan</th>
                <td>
                    <?php echo $jenis_menumasakan[0]['namajenismenu'];?>
                </td>
            </tr>
            <?php
            foreach ($menumasakanwaktu[$i] as $waktu) {
            ?>
            <tr>
                <th>Waktu <?php echo $waktu['waktu'];?></th>
                <td><?php echo $waktu['namawaktumenu'];?></td>
            </tr>
            <?php
            }
            ?>
        </table>
        <button type="button" class="btn btn-success" onclick="javascript:detailMenumasakan('<?php echo $jenis_menumasakan[0]['idjenismenu'];?>');">Detail Menu Masakan : <?php echo $jenis_menumasakan[0]['namajenismenu'];?> <span id="loading_detailmeunamsakan_<?php echo $jenis_menumasakan[0]['idjenismenu'];?>"></span></button>
        <br>
        <?php
        $tanggal_rekappasien = $tanggalrekappasien.'<br>';
        $id_jenis_menumasakan = $jenis_menumasakan[0]['idjenismenu'].'<br>';
        $tgl_pengajuanbahan = $tgltgl[$i];
        ?>
        <?php if ($add == 2) { //1?> 
            <button type="button" class="btn btn-primary btn-block generatepengajuanbahan" id="button_generate" onclick="javascript:generatePengajuanBahan('<?php echo $tanggal_rekappasien;?>','<?php echo $id_jenis_menumasakan;?>','<?php echo $tgl_pengajuanbahan;?>')"><i class="fa fa-file"></i> Generate Pengajuan Bahan</button>
            <span id="loading_generate"></span>
        <?php } ?>
    </div>
    <?php
    $i++;
    }
    ?>
</div>

<div class="row" style="margin-bottom:10px">
    <div class="col-lg-12">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <?php
                $nom = 1;
                foreach($pengajuan as $tanggalpengajuan){
                    if ($nom == 1) {
                        $act = "active";
                        $expanded = "true";
                    } else {
                        $act = "";
                        $expanded = "false";
                    }
                ?>
                <li class="<?php echo $act;?>"><a href="#tab_<?php echo $nom;?>" data-toggle="tab" aria-expanded="<?php echo $expanded;?>">Pengajuan Bahan (<?php echo $tanggalpengajuan;?>)</a></li>
                <?php
                $nom++;
                }
                ?>          
            </ul>
            <div class="tab-content">
                <?php
                $nomo = 1;
                foreach ($pengajuanbahan as $pengajuan_bahan) {
                    if ($nomo == 1) {
                        $act = "active";
                    } else {
                        $act = "";
                    }
                ?>
                <div class="tab-pane <?php echo $act;?>" id="tab_<?php echo $nomo;?>">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="5%" style="text-align: center;">No</th>
                                    <th style="text-align: center;">Nama Bahan</th>
                                    <th width="15%" style="text-align: center;">Jml Kebutuhan</th>
                                    <th width="5%" style="text-align: center;">Satuan</th>
                                    <th width="15%" style="text-align: center;">Harga Supplier</th>
                                    <th width="5%" style="text-align: center;">Satuan</th>
                                    <th width="25%" style="text-align: center;">Total Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $hargatotal[$nomo] = 0;
                                foreach ($pengajuan_bahan as $data) {
                                ?>
                                <tr>
                                    <td style="text-align: center;"><?php echo $no;?></td>
                                    <td><?php echo $data['namabahan'];?></td>
                                    <td style="text-align: right;"><?php echo number_format($data['jumlahkuantitas'],2);?></td>
                                    <td style="text-align: center;"><?php echo $data['satuan'];?></td>
                                    <td style="text-align: right;"><?php echo number_format($data['hargasatuansupplier'],2);?></td>
                                    <td style="text-align: center;"><?php echo $data['satuansupplier'];?></td>
                                    <th style="text-align: right;"><?php echo number_format($data['hargatotal'],2,",",".");?></th>
                                </tr>
                                <?php
                                $no++;
                                $hargatotal[$nomo] = $hargatotal[$nomo] + $data['hargatotal'];
                                }
                                ?>
                                <tr>
                                    <th colspan="6" style="text-align: right;">Harga Total Pengajuan Bahan Masakan</th>
                                    <th style="text-align: right;"><?php echo number_format($hargatotal[$nomo],2,",",".");?></th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php
                $nomo++;
                }
                ?>                
            </div>
        </div>
    </div>
</div>
<?php
}
?>
    </div>
</div>