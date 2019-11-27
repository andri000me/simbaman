

<div class="modal-content">
    <div class="modal-header bg-primary">
	<button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
	<h4 id="modal-default-label" class="modal-title text-center">Detail Data Pasien</h4>
    </div>
    <div class="modal-body">
	    <div class="row">
            <div class="col-xs-12">
                <?php
                // print_r($detail);
                ?>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="text-align: center;" width="5%">Kode</th>
                                <th style="text-align: center;" width="25%">Ruang</th>
                                <th style="text-align: center;" width="5%">Kode</th>
                                <th style="text-align: center;" width="25%">Bangsal</th>
                                <th>Kelas</th>
                                <th style="text-align: center;" width="15%">Jumlah Pasien</th>
                                <th style="text-align: center;" width="10%">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $jumlah = 0;
                            foreach ($detail as $data) {
                            ?>
                            <tr>
                                <td style="text-align: center;"><?php echo $data['koderuang'];?></td>
                                <td><?php echo $data['namaruang'];?></td>
                                <td style="text-align: center;"><?php echo $data['kodebangsal'];?></td>
                                <td><?php echo $data['namabangsal'];?></td>
                                <td><?php echo $data['namakelas'];?></td>
                                <td style="text-align: center;"><?php echo $data['jumlahpasien'];?></td>
                                <td style="text-align: center;"><?php echo $data['tanggalrekap'];?></td>    
                            </tr>
                            <?php
                            $jumlah=$data['jumlahpasien']+$jumlah;
                            }
                            ?>
                            <tr>
                                <td colspan="5" style="text-align: center;">Jumlah Pasien</td>
                                <td style="text-align: center;"><?php echo $jumlah;?></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div><!-- /.nav-tabs-custom -->
        </div><!-- /.row -->
    </div>
    <div class="modal-footer">
	<button type="button" data-dismiss="modal" class="btn btn-default"><i class="fa fa-power-off"></i> Tutup</button>
    </div>
</div>