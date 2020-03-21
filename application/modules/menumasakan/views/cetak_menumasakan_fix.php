<div class="box-body">
    <div class="row">
        <div class="col-lg-12">
            <div class="callout callout-info">
                <h4 style="width: 100%; border-collapse: collapse;font-size: 12px;">Menu Masakan Yang Dipakai</h4>
            </div>
        </div>                
    </div>
    <?php
    $no = 1;
    foreach ($jenismenumasakan as $jenismenu) {
    ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="callout callout-info">
                <h4 style="width: 100%; border-collapse: collapse;font-size: 12px;"><?php echo $no; ?>. <?php echo $jenismenu['namajenismenu'];?></h4>
            </div>
        </div>                
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table style="width: 100%; border-collapse: collapse;font-size: 12px;">
                    <tr>
                        <th style="padding: 5px;border: 1px solid #000000;font-weight: bold; text-align: center; background-color: #EDEDED;">Waktu / Kelas</th>
                        <?php
                        foreach ($kelasmenumasakan as $kelas) {
                            if ($kelas['idjenismenu'] == $jenismenu['idjenismenu']) {
                            ?>
                            <th style="padding: 5px;width: 20%;border: 1px solid #000000;font-weight: bold; text-align: center; background-color: #EDEDED;"><?php echo $kelas['namakelas']?></th>
                            <?php
                            }
                        }
                        ?>
                    </tr>
                    <?php
                    foreach ($waktumenumasakan as $waktu) {
                        if ($waktu['idjenismenu'] == $jenismenu['idjenismenu']) {
                    ?>
                    <tr>
                        <th style="padding: 5px;border: 1px solid #000000;font-weight: bold; text-align: center; background-color: #EDEDED;"><?php echo $waktu['namawaktumenu'];?></th>
                        <?php
                        foreach ($kelasmenumasakan as $kelas2) {
                            if ($kelas2['idjenismenu'] == $waktu['idjenismenu']) {
                        ?>
                            <td style="padding: 5px;border: 1px solid #000000;">
                            <?php
                            foreach ($menumasakan as $masakan) {
                                if ($masakan['idkelas'] == $kelas2['idkelas'] && $masakan['idwaktumenu'] == $waktu['idwaktumenu']
                                    && $masakan['idjenismenu'] == $kelas2['idjenismenu'] && $masakan['idjenismenu'] == $waktu['idjenismenu']) {
                                    echo $masakan['namamasakan'].'<br>';
                                }
                            }
                            ?>
                            </td>
                        <?php
                            }
                        }
                        ?>
                    </tr>
                    <?php
                        }
                    }
                    ?>
                </table>
            </div>
        </div><!-- /.nav-tabs-custom -->
    </div>
    <?php
    $no++;
    }
    ?>
</div>