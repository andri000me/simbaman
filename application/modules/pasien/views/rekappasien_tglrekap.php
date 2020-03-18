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


<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Tanggal : <?php echo $tglrekap;?></h3>
        <span class="pull-right">
            <span id="loading"></span>
        </span>
    </div>
    <div class="box-body">
        <div class="row" style="margin-bottom:10px">
            <div class="col-lg-12" style="text-align: center;">
                <div class="alert alert-info alert-dismissible">
                    Apabila ada penambahan atau pengurangan data pasien, maka klik tombol Reset Data Pasien untuk mengkondisikan data pasien menjadi kosong <br>
                    dan lakukan klik tombol Import Data untuk mengambil data pasien terbaru 
                <br>
                <button type="button" class="btn btn-danger btn-lg" id="btn_reset" onclick="javascript:reset_pasien('<?php echo $tglrekap;?>');">Reset Data Pasien</button>
                <div id="loading_reset"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
            <?php
            $n = array();
            foreach ($jumlahpasien as $jml) {
                $n[$jml['namabangsal']][$jml['namakelas']] = $jml['jumlahpasien'].'|'.$jml['idrekapjumlahpasien'];
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
                                $pasien = explode('|', $n[$ruangan['namabangsal']][$kls2['namakelas']]);
                                $jumlahpasien = $pasien[0];
                                $idjumlahpasien = $pasien[1];
                                ?>
                                <td>
                                <button type="button" class="btn btn-link" onclick="javascript:form_ubahjumlahpasien('<?php echo $idjumlahpasien;?>');"><?php echo $jumlahpasien?></button>
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
    </div>
</div>