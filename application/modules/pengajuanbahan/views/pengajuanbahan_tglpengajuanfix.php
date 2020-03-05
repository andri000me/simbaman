<?php
/**
 * @author [syafrial zulmi]
 * @email [syafrialzulmi@mail.com]
 * @create date 2019-09-24 06:08:33
 * @modify date 2019-09-24 06:08:33
 * @desc [description]
 */
?>

<?php
if (count($pengajuanbahan_cek) == 0) {
?>
<div class="row" style="margin-bottom:10px">
    <div class="col-lg-12" style="text-align: center;">
        <div class="alert alert-danger alert-dismissible">
            <h4><i class="icon fa fa-warning"></i> Perhatian!</h4>
            Informasi dibahawah sudah dibuatkan generate pengajuan bahan masakan.
            Silahkan untuk melakukan reset pengajuan bahan masakan, bila ada kesalahan/ kekurangan jumlah pasien.
        </div>
    </div>
</div>
<div class="row" style="margin-bottom:10px">
    <div class="col-lg-12" style="text-align: center;">
        <?php if ($add == 1) { ?> 
            <button type="button" class="btn btn-danger resetpengajuanbahan" id="" onclick="javascript:resetPengajuanBahan('<?php echo $idpengajuan;?>')"><i class="fa fa-file"></i> Reset Pengajuan Bahan</button>
            <span id="loading_reset"></span>
        <?php } ?>
    </div>
</div>
<?php
} else {
?>
<div class="row" style="margin-bottom:10px">
    <div class="col-lg-12" style="text-align: center;">
        <div class="alert alert-info alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-warning"></i> Perhatian!</h4>
            Pengajuan bahan masakan sudah di ceklist oleh Admin, Terima kasih.
        </div>
    </div>
</div>
<?php
}
?>



<div class="row" style="margin-bottom:10px">
    <div class="col-lg-5">
        <table class="table table-bordered">
            <tr>
                <th>Tanggal Rekap Pasien</th>
                <td>
                    <?php echo $tglpengajuan;?>
                </td>
            </tr>
            <tr>
                <th width="50%">Tanggal Pengajuan Bahan</th>
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
        <?php
        if (count($pengajuanbahan_cek) == 0) {
        ?>
        <button type="button" class="btn btn-warning" onclick="javascript:form_pengajuandiet('<?php echo $idpengajuan;?>');"><i class="fa fa-user"></i> Pasien Diet <span id="loading_pengajuandiet"></span></button>
        <?php
        }
        ?>
        <button type="button" class="btn btn-default" onclick="javascript:detail_pengajuandiet('<?php echo $idpengajuan;?>');"><i class="fa fa-user"></i> Detail Pasien Diet <span id="loading_detail_pengajuandiet"></span></button>
        <br><br>
        <button type="button" class="btn btn-success" onclick="javascript:form_bahansisa('<?php echo $tanggalpengajuan_bahan;?>');">Sisa Bahan<span id="loading_bahansisa"></span></button>
    </div>
    <div class="col-lg-7">
        <button type="button" class="btn btn-success btn-block" onclick="javascript:detailMenumasakan('<?php echo $jenismenumasakan[0]['idjenismenu'];?>');">Detail Menu Masakan <span id="loading_detailmeunamsakan"></span></button>
    </div>
</div>

<div class="row" style="margin-bottom:10px">

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
                        if ($data['idpengajuandiet'] != '') {
                            $tanda = '<font color="red">*</font>';
                        } else {
                            $tanda = '';
                        }
                    ?>
                    <tr>
                        <td style="text-align: center;"><?php echo $no;?> <?php echo $tanda;?></td>
                        <td><?php echo $data['namabahan'];?></td>
                        <td style="text-align: right;"><?php echo number_format($data['totaljumlahkuantitas'],2);?></td>
                        <td style="text-align: center;"><?php echo $data['satuan'];?></td>
                        <td style="text-align: right;"><?php echo number_format($data['hargasatuansupplier'],2);?></td>
                        <td style="text-align: center;"><?php echo $data['satuansupplier'];?></td>
                        <th style="text-align: right;"><?php echo number_format($data['totalhargatotal'],2,",",".");?></th>
                    </tr>
                    <?php
                    $no++;
                    $hargatotal = $hargatotal + $data['totalhargatotal'];
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

<div class="row" style="margin-bottom:10px">
    <div class="col-lg-12">
        <div class="form-group">
            <label class="col-sm-1 control-label">Kelas</label>
            <div class="col-sm-3">
                <input type="hidden" name="idpengajuan_fix" id="idpengajuan_fix" class="form-control" value="<?php echo $idpengajuan;?>">   
                <select class="form-control" id="idkelas_fix" name="idkelas_fix">
                    <option value="pilihsemua">-- Pilih Semua Kelas</option>
                    <?php
                    foreach ($kelas as $kls) {
                    ?>
                        <option value="<?php echo $kls['idkelas'];?>"><?php echo $kls['namakelas'];?></option>
                    <?php
                    }
                    ?>
                </select>                     
            </div>
            <label class="col-sm-1 control-label">Waktu</label>
            <div class="col-sm-3">
                <select class="form-control" id="idwaktumenu_fix" name="idwaktumenu_fix">
                    <option value="pilihsemua">-- Pilih Semua Waktu</option>
                    <?php
                    foreach ($waktumenu as $waktu) {
                    ?>
                        <option value="<?php echo $waktu['idwaktumenu'];?>"><?php echo $waktu['namawaktumenu'];?></option>
                    <?php
                    }
                    ?>
                </select>                               
            </div>
            <div class="col-sm-4">
                <button type="button" class="btn btn-success" onclick="javascript:cetakbahanmasakanpengajuan();">Cetak Bahan Masakan Pengajuan</button>
            </div>
        </div>
    </div>
</div>