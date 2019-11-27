<div class="modal-content">
    <div class="modal-header bg-primary">
	<button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
	<h4 id="modal-default-label" class="modal-title text-center">Detail Pengajuan Pasien Diet <span id="loading_hapusbahandiet"></span></h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="text-align:center;">Diet</th>
                                <th style="text-align:center;">Pasien</th>
                                <th style="text-align:center;">Ruang</th>
                                <th style="text-align:center;">Bangsal</th>
                                <th style="text-align:center;">Kelas</th>
                                <th style="text-align:center;">Bahan Masakan</th>
                                <th style="text-align:center;">Pengurangan</th>
                                <th style="text-align:center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($pengajuandetail as $diet) {
                            ?>
                            <tr>
                                <td><?php echo $diet['namadiet'];?></td>
                                <td><?php echo $diet['jumlahpasien'];?></td>
                                <td><?php echo $diet['namaruang'];?></td>
                                <td><?php echo $diet['namabangsal'];?></td>
                                <td><?php echo $diet['namakelas'];?></td>
                                <td><?php echo $diet['namabahan'];?></td>
                                <td><?php echo $diet['kuantitaspengurangan'];?> <?php echo $diet['satuan'];?></td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-xs" onclick="javascript:ubah_bahandiet('<?php echo $diet['idpengajuanbahandietdetail'];?>');"><i class="fa fa-edit"></i></button>
                                    <button type="button" id="delete_<?php echo $diet['idpengajuanbahandietdetail'];?>" class="btn btn-danger btn-xs" onclick="javascript:hapus_bahandiet('<?php echo $diet['idpengajuanbahandietdetail'];?>','<?php echo $diet['idpengajuan'];?>');"><i class="fa fa-trash-o"></i></button>
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div><!-- /.nav-tabs-custom -->
        </div>
    </div>
    <div class="modal-footer">
	<button type="button" data-dismiss="modal" class="btn btn-default"><i class="fa fa-power-off"></i> Tutup</button>
    </div>
</div>