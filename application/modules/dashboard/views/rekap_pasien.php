<div class="modal-content">
    <div class="modal-header bg-primary">
	<button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
	<h4 id="modal-default-label" class="modal-title text-center">Rekap Data Pasien</h4>
    </div>
    <div class="modal-body">
        <div class="row" style="margin-bottom:10px">
            <div class="col-lg-12">
                <h3>Tanggal : <?php echo $tglrekap;?></h3>
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
    <div class="modal-footer">
	    <button type="button" data-dismiss="modal" class="btn btn-default"><i class="fa fa-power-off"></i> Tutup</button>
    </div>
</div>