<div id="konten_prediksi">
    <div class="box">
        <div class="box-header with-border">
            <h3 style="text-align: center;">
                Prediksi Kebutuhan Bahan Selama <?php echo $bulan;?> Bulan <br>
                Mulai tanggal <?php echo $tgl_prediksi?> s/d <?php echo $tgl_sekarang?>
            </h3>
        </div>        
        <div class="box-body">
            <div class="row" style="margin-bottom:10px">
                <div class="col-lg-12" style="text-align: center;">
                    <a target="_blank" href="<?php echo base_url()?>prediksipengajuan/cetakprediksi/<?php echo $bulan;?>" class="btn btn-success">Cetak Prediksi Pengajuan Bahan</a>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="5%" style="text-align: center;">No</th>
                                    <th style="text-align: center;">Nama Bahan</th>
                                    <th width="15%" style="text-align: center;">Jml Kebutuhan</th>
                                    <th width="5%" style="text-align: center;">Satuan</th>
                                    <th width="15%" style="text-align: center;">Harga Supplier</th>
                                    <th width="25%" style="text-align: center;">Total Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $hargatotal = 0;
                                foreach ($prediksi as $data) {
                                ?>
                                <tr>
                                    <td style="text-align: center;"><?php echo $no;?></td>
                                    <td><?php echo $data['namabahan'];?></td>
                                    <td style="text-align: right;"><?php echo number_format($data['rata_kuantitasreal'],2);?></td>
                                    <td style="text-align: center;"><?php echo $data['satuan'];?></td>
                                    <td style="text-align: right;"><?php echo number_format($data['hargasatuansupplier'],2);?></td>
                                    <th style="text-align: right;"><?php echo number_format($data['rata_totalreal'],2,",",".");?></th>
                                </tr>
                                <?php
                                $no++;
                                $hargatotal = $hargatotal + $data['rata_totalreal'];
                                }
                                ?>
                                <tr>
                                    <th colspan="5" style="text-align: right;">Harga Total Prediksi Pengajuan Bahan Masakan</th>
                                    <th style="text-align: right;"><?php echo number_format($hargatotal,2,",",".");?></th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> 
        </div>
    </div>
</div>