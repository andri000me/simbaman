<?php

/**
 * @author [syafrial zulmi]
 * @email [syafrialzulmi@mail.com]
 * @create date 2019-09-21 13:27:50
 * @modify date 2019-09-21 13:27:50
 * @desc [description]
 */

?>

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
            Silahkan untuk melakukan generate pengajuan bahan masakan.
        </div>
    </div>
</div>

<div class="row" style="margin-bottom:10px">
    <div class="col-lg-12" style="text-align: center;">
        <?php if ($add == 1) { ?> 
            <button type="button" class="btn btn-success generatepengajuanbahan" id="" onclick="javascript:generatePengajuanBahan('<?php echo $tanggalrekappasien;?>','<?php echo $jenismenumasakan[0]['idjenismenu']?>','<?php echo $tglpengajuanbahan;?>')"><i class="fa fa-file"></i> Generate Pengajuan Bahan</button>
            <span id="loading_generate"></span>
        <?php } ?>
    </div>
</div>

<div class="row" style="margin-bottom:10px">
    <div class="col-lg-5">
        <table class="table table-bordered">
            <tr>
                <th width="50%">Tanggal Pengajuan Bahan</th>
                <td>
                    <?php echo $tglpengajuan;?>
                </td>
            </tr>
            <tr>
                <th>Tanggal Rekap Pasien</th>
                <td>
                    <?php echo $tglrekappasien;?>
                </td>
            </tr>                       
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
    <div class="col-lg-4">
        <table class="table table-bordered">
            <tr>
                <th width="40%">Menu Masakan</th>
                <td>
                    <?php echo $jenismenumasakan[0]['namajenismenu'];?>
                </td>
            </tr>
            <?php
            foreach ($menumasakanwaktu as $waktu) {
            ?>
            <tr>
                <th>Waktu <?php echo $waktu['waktu'];?></th>
                <td><?php echo $waktu['namawaktumenu'];?></td>
            </tr>
            <?php
            }
            ?>
        </table>
    </div>
</div>

<div class="row" style="margin-bottom:10px">
    <div class="col-lg-5">
        
    </div>
    <div class="col-lg-7">
        <button type="button" class="btn btn-success btn-block" onclick="javascript:detailMenumasakan('<?php echo $jenismenumasakan[0]['idjenismenu'];?>');">Detail Menu Masakan <span id="loading_detailmeunamsakan"></span></button>
    </div>
</div>

<div class="row" style="margin-bottom:10px">
    <div class="col-lg-12">
        <?php //print_r($pengajuanbahan);?>
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
                    $hargatotal = 0;
                    foreach ($pengajuanbahan as $data) {
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
                    $hargatotal = $hargatotal + $data['hargatotal'];
                    }
                    ?>
                    <tr>
                        <th colspan="6" style="text-align: right;">Harga Total Pengajuan Bahan Masakan</th>
                        <th style="text-align: right;"><?php echo number_format($hargatotal,2,",",".");?></th>
                    </tr>
                </tbody>
            </table>
        </div>       
    </div>
</div>

<?php
}
?>