<?php

/**
 * @author [syafrial zulmi]
 * @email [syafrialzulmi@mail.com]
 * @create date 2019-09-22 09:20:22
 * @modify date 2019-10-08 06:07:32
 * @desc [description]
 */
?>

<div class="modal-content">
    <div class="modal-header bg-primary">
	<button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
	<h4 id="modal-default-label" class="modal-title text-center">Detail Menu Masakan : <?php echo $jenismenumasakan[0]['namajenismenu'];?></h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-xs-12">
            <?php
            // $n = array();
            // foreach ($menumasakan as $masakan) {
            //     $n[$masakan['idkelas']][$masakan['idwaktumenu']] = $masakan['namamasakan'];
            // }
            ?>
                <table class="table table-bordered">
                    <tr>
                        <th width="" style="text-align: center;">Waktu / Kelas</th>
                        <?php
                        foreach ($kelasmenumasakan as $kelas) {
                            ?>
                            <th width="20%" style="text-align: center;"><?php echo $kelas['namakelas']?></th>
                            <?php
                        }
                        ?>
                    </tr>
                    <?php
                    foreach ($waktumenumasakan as $waktu) {
                    ?>
                    <tr>
                        <th><?php echo $waktu['namawaktumenu'];?></th>
                        <?php
                        foreach ($kelasmenumasakan as $kelas2) {
                        ?>
                            <td>
                            <?php
                            foreach ($menumasakan as $masakan) {
                                if ($masakan['idkelas'] == $kelas2['idkelas'] && $masakan['idwaktumenu'] == $waktu['idwaktumenu']) {
                                    echo $masakan['namamasakan'].'<br>';
                                }
                            }
                            ?>
                            </td>
                        <?php
                        }
                        ?>
                    </tr>
                    <?php
                    }
                    ?>
                </table>
            </div><!-- /.nav-tabs-custom -->
        </div>
    </div>
    <div class="modal-footer">
	<button type="button" data-dismiss="modal" class="btn btn-default"><i class="fa fa-power-off"></i> Tutup</button>
    </div>
</div>