<script type="text/javascript">

    $(document).ready(function () {
        $("#formoid").submit(function(event) {
            event.preventDefault();
            $.ajax({
                type: "POST",
                data: $(this).serialize(),
                url: "<?php echo base_url().'menumasakan/savedata_menumasakan'; ?>",
                beforeSend: function(){
                    $("#loading").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
                    $("#submitButton").attr("disabled",true);
                },
                success: function(resp){
                    window.location.assign("<?php echo base_url().'menumasakan/loadform_menumasakan/';?>"+resp);
                },
                error: function(event, textStatus, errorThrown) {
                    alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
                }
            });
        });

    });

    function konfirmasi_hapusmenumasakan(idmenumasakan) {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url().'menumasakan/loadformdelete_menumasakan'; ?>",
            data: {"idmenumasakan":idmenumasakan},
            beforeSend: function(){
                $("#loading").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
            },
            success: function(resp){
                $("#modal").modal('show');
                $("#content_modal").html(resp);
                $("#loading").html("");
            },
            error:function(event, textStatus, errorThrown) {
                alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
            }
        });
    };

    function hapus_menumasakan()
    {
        var idmenumasakan = $('#idmenumasakan_delete').val();
        var idkelas = $('#idkelas_delete').val();
        var idjenismenu = $('#idjenismenu_delete').val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url().'menumasakan/savedata_menumasakan'; ?>",
            data: {"idmenumasakan":idmenumasakan,"stat":"delete"},
            beforeSend: function(){
                $("#loading").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
                $("#hapus_data").attr("disabled",true);
            },
            success: function(resp){
                var url = "<?php echo base_url()?>"+"menumasakan/loadform_menumasakan/"+idkelas+"/"+idjenismenu;
                window.location.assign(url);
            },
            error:function(event, textStatus, errorThrown) {
                alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
            }
        });
    }
</script>

<?php    
    $sess_data['url'] = $this->input->server('REQUEST_URI');    
    $this->session->set_userdata($sess_data);
?>

<section class="content">
<!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Tambah Menu Masakan</h3>
            <span class="pull-right">
                <span id="loading"></span>
            </span>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-lg-12">
                    <form class="form-horizontal" id="formoid" action="" title="" method="post">
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Kelas</label>
                            <div class="col-sm-10">
                                <input type="hidden" class="form-control" id="idmenumasakan" name="idmenumasakan" value="">
                                <select class="form-control" name="idkelas" id="idkelas" readonly>
                                    <option value="">-- Pilih Kelas</option>
                                    <?php
                                    foreach ($kelas as $kls) {
                                    ?>
                                        <option value="<?php echo $kls['idkelas'];?>" <?php if ($kls['idkelas'] == $idkelas) { echo 'selected';}?>><?php echo $kls['namakelas'];?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Jenis Menu</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="idjenismenu" id="idjenismenu">
                                    <option value="">-- Pilih Jenis Menu</option>
                                    <?php
                                    foreach ($jenismenu as $jns) {
                                    ?>
                                        <option value="<?php echo $jns['idjenismenu'];?>" <?php if ($jns['idjenismenu'] == $idjenismenu) { echo 'selected';}?>><?php echo $jns['namajenismenu'];?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Waktu Menu</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="idwaktumenu" id="idwaktumenu">
                                    <option value="">-- Pilih Waktu Menu</option>
                                    <?php
                                    foreach ($waktumenu as $waktu) {
                                    ?>
                                        <option value="<?php echo $waktu['idwaktumenu'];?>"><?php echo $waktu['namawaktumenu'];?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Masakan</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="idmasakan" id="idmasakan">
                                    <option value="">-- Pilih Masakan</option>
                                    <?php
                                    foreach ($masakan as $msk) {
                                    ?>
                                        <option value="<?php echo $msk['idmasakan'];?>"><?php echo $msk['namamasakan'];?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" class="btn btn-success" id="submitButton" name="submitButton" value="Simpan">
                                <a type="button" class="btn btn-danger" href="<?php echo base_url()?>menumasakan"><i class="fa fa-reply"></i> Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php
    if (count($get_DataKelasMenuMasakan) != 0) {
    ?>
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Menu Kelas : <?php echo $namakelas[0]['namakelas'];?></h3>            
        </div>

        <div class="box-body">
            <div class="row">
                <div class="col-lg-12">
                    <h2>
                        Jenis Menu : <?php if ($idjenismenu != NULL) { echo $namakelas[0]['namajenismenu'];}?>
                    </h2>

                    <table class="table table-bordered">
                        <tr>
                            <th width="25%" style="text-align: center;">Waktu</th>
                            <th style="text-align: center;">Menu Masakan</th>
                        </tr>
                        <?php
                        foreach ($waktumenumasakan as $waktu) {
                        ?>
                        <tr>
                            <td><?php echo $waktu['namawaktumenu'];?> </td>
                            <td>
                                <table class="table table-bordered">
                                    <?php
                                    foreach ($menumasakan as $masak) {
                                        if ($masak['idwaktumenu'] == $waktu['idwaktumenu']) {
                                    ?>
                                    <tr>
                                        <td width="50%"><?php echo $masak['namamasakan'];?></td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm" onclick="javascript:konfirmasi_hapusmenumasakan('<?php echo $masak['idmenumasakan'];?>');"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    <?php
                                       }
                                    }
                                    ?>
                                </table>
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php
    }
    ?>
</section>
            <hr>
            <?php
            if (count($get_DataKelasMenuMasakan) != 0) {
            ?>
            
            <?php
            } else {
                echo '';
            }
            ?>
        </div>
        <!-- <div class="box-footer"> -->
            
        <!-- </div>/.box-footer -->
    </div>

<div id="modal" tabindex="-1" role="dialog" aria-labelledby="modal-default-label" aria-hidden="true" class="modal fade" data-backdrop="static">
    <div class="modal-dialog modal-lg" id="content_modal">  	
    </div>
</div>