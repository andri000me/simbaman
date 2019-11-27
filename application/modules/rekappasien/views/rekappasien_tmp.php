<?php
error_reporting(0);
/**
 * @author [syafrial zulmi]
 * @email [syafrialzulmi@mail.com]
 * @create date 2019-09-14 10:37:25
 * @modify date 2019-09-14 10:37:25
 * @desc [description]
 */
?>

<div class="row" style="margin-bottom:10px">
    <div class="col-lg-12">
        <h3>Tanggal : <?php echo $tglrekap;?></h3>
    </div>
</div>

<div class="row" style="margin-bottom:10px">
    <div class="col-lg-12" style="text-align: center;">
        <button type="button" class="btn btn-success btn-lg" id="btn_importdata_tmp" onclick="javascript:importdata('<?php echo $tglrekap;?>');">Import Data</button>
        <div id="loading_import"></div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="table-responsive">
    <?php
    $n = array();
    foreach ($jumlahpasien as $jml) {
        $n[$jml['namabangsal']][$jml['namakelas']] = $jml['jumlahpasien'];
    }
    ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="text-align: center;" width="20">No</th>
                    <th style="text-align: center;" width="200">Ruang</th>
                    <th style="text-align: center;" width="200">Bangsal</th>
                    <?php
                    foreach ($grupkelas as $kls) {
                        ?>
                        <th style="text-align: center;" width="50"><?php echo $kls['namakelas'];?></th>
                        <?php
                    }
                    ?>
                    <th style="text-align: center;" width="50">Jumlah Pasien</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <?php
                $no = 1;
                $jum = 1;
                foreach($grupruangan as $ruangan){
                    if($jum <= 1) {
                        ?>
                        <td rowspan="<?php echo $ruangan['jml']?>"><?php echo $no;?></td>
                        <td rowspan="<?php echo $ruangan['jml']?>"><?php echo $ruangan['namaruang']?></td>
                        <?php
                        $jum = $ruangan['jml'];      
                        $no++;
                    } else {
                        $jum = $jum - 1;
                    }
                ?>
                    <td><?php echo $ruangan['namabangsal']?></td> 
                    <?php
                    foreach ($grupkelas as $kls2) {
                        $pasien = $n[$ruangan['namabangsal']][$kls2['namakelas']];
                        ?>
                        <td>
                        <?php echo $pasien?>
                        </td>
                        <?php
                    }
                    ?>                            
                    <td><?php echo $ruangan['jumlahpasien']?></td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<div class="row" style="margin-bottom:10px">
    <div class="col-lg-12" style="text-align: center;">
        <button type="button" class="btn btn-success btn-lg" id="btn_importdata_tmp" onclick="javascript:importdata('<?php echo $tglrekap;?>');">Import Data</button>
        <div id="loading_import"></div>
    </div>
</div>