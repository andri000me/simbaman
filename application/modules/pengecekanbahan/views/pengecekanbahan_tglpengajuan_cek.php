<?php

/**
 * @author [syafrial zulmi]
 * @email [syafrialzulmi@mail.com]
 * @create date 2019-10-08 05:54:30
 * @modify date 2019-10-08 05:54:30
 * @desc [description]
 */

?>

<?php 
if (count($cektglpengajuanbahan) == 0) {
?>
<div class="row" style="margin-bottom:10px">
    <div class="col-lg-12" style="text-align: center;">
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-warning"></i> Perhatian!</h4>
            Data bahan masakan pengajuan belum tersedia, silahkan mengajukan bahan masakan terlebih dahulu.
        </div>
    </div>
</div>
<?php
} else {
?>

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
                <td><?php echo number_format($kelaspasien['jumlahpasien'],0);?></td>
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
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th width="5%" style="text-align: center;">No</th>
                        <th style="text-align: center;">Nama Bahan</th>
                        <th width="10%" style="text-align: center;">Kebutuhan</th>
                        <th width="5%" style="text-align: center;">Satuan</th>
                        <th width="10%" style="text-align: center;">Harga Supplier (RP)</th>
                        <th width="5%" style="text-align: center;">Satuan</th>
                        <th width="15%" style="text-align: center;">Harga (Rp)</th>
                        <th width="8%" style="text-align: center;">Cek</th>
                        <th width="10%" style="text-align: center;">Realisasi</th>
                        <th width="15%" style="text-align: center;">Harga Realisasi (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $hargatotal = 0;
                    $hargatotal_realisasi = 0;
                    foreach ($pengajuanbahan as $data) {
                        if ($data['idpengajuandiet'] != '') {
                            $tanda = '<font color="red">*</font>';
                        } else {
                            $tanda = '';
                        }
                    ?>
                    <tr>
                        <td style="text-align: center;"><?php echo $no;?> <?php echo $tanda;?></td>
                        <td><?php echo $data['namabahan'];?></td>
                        <td style="text-align: right;"><?php echo number_format($data['jumlahkuantitas'],2);?></td>
                        <td style="text-align: center;"><?php echo $data['satuan'];?></td>
                        <td style="text-align: right;"><?php echo number_format($data['hargasatuansupplier'],2);?></td>
                        <td style="text-align: center;"><?php echo $data['satuansupplier'];?></td>
                        <th style="text-align: right;"><?php echo number_format($data['hargatotal'],2,",",".");?></th>
                        
                        <td style="text-align: center;">
                            <?php
                            if ($data['idbahanpengajuan'] == '') {
                            ?>
                                <span id="button_hide_<?php echo $data['idbahansupplier']?>">
                                    <button type="button" class="btn btn-xs btn-success cek_pengajuan_<?php echo $data['idbahansupplier']?>" onclick="javascript:cek_pengajuan('<?php echo $data['idpengajuan']?>','<?php echo $data['idbahansupplier']?>','sesuai');":><i class="fa fa-thumbs-o-up"></i></button>
                                    <button type="button" class="btn btn-xs btn-danger cek_pengajuan_<?php echo $data['idbahansupplier']?>" onclick="javascript:cek_pengajuan('<?php echo $data['idpengajuan']?>','<?php echo $data['idbahansupplier']?>','tidak_sesuai');"><i class="fa fa-thumbs-o-down"></i></button>
                                </span>
                            <?php
                            } else {
                            ?>
                                <button type="button" class="btn btn-xs btn-warning cek_pengajuan_<?php echo $data['idbahansupplier']?>" onclick="javascript:cek_pengajuan('<?php echo $data['idpengajuan']?>','<?php echo $data['idbahansupplier']?>','kembali');"><i class="fa fa-retweet"></i></button>
                            <?php                                
                            }
                            ?>
                        </td>
                        <?php
                        if ($data['kesesuaian'] == 'tidak_sesuai') {
                            $font_color = "red";
                        } else {
                            $font_color = "black";
                        }
                        ?>
                        <th style="text-align: right;">
                            <span id="kebutuhan_realisasi_<?php echo $data['idbahansupplier']?>">
                                <font color="<?php echo $font_color;?>">
                                    <?php
                                    if ($data['jumlahkuantitasreal'] == '') {
                                        echo '';
                                    } else {
                                        echo number_format($data['jumlahkuantitasreal'],2);
                                    }
                                    ?>
                                </font>
                            </span>
                        </th>
                        <th style="text-align: right;">
                            <span id="harga_realisasi_<?php echo $data['idbahansupplier']?>">
                                <font color="<?php echo $font_color;?>">
                                    <?php
                                    if ($data['hargatotalreal'] == '') {
                                        echo '';
                                    } else {
                                        echo number_format($data['hargatotalreal'],2,",",".");
                                    }
                                    ?>
                                </font>
                            </span>
                        </th>
                    </tr>
                    <?php
                    $no++;
                    $hargatotal = $hargatotal + $data['hargatotal'];
                    $hargatotal_realisasi = $hargatotal_realisasi + $data['hargatotalreal'];
                    }
                    ?>
                    <tr>
                        <th colspan="6" style="text-align: right;">Harga Total Pengajuan</th>
                        <th style="text-align: right;"><?php echo number_format($hargatotal,2,",",".");?></th>
                        <th colspan="2" style="text-align: right;">Harga Total Realisasi</th>
                        <th style="text-align: right;"><?php echo number_format($hargatotal_realisasi,2,",",".");?></th>
                    </tr>
                </tbody>
            </table>
        </div>       
    </div>
</div>

<div class="row" style="margin-bottom:10px">
    <div class="col-lg-12" style="text-align: center;">
        <a target="_blank" href="<?php echo base_url()?>pengecekanbahan/cetakpengecekan/<?php echo $idpengajuan;?>" class="btn btn-success">Cetak Pengecekan</a>
    </div>
</div>

<?php
}
?>
