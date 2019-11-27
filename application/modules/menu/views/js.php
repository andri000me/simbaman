<script type="text/javascript">
    $(document).ready(function () {
        $("#tableListData").DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": false,
            "info": true,
            "autoWidth": true
        });
        
        $(document).on('click', '#cari_icon', function() {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url().'menu/searchicon'; ?>",               
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
        });
        
        $(document).on('click', '#tampilinfo', function() {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url().'menu/infomodul'; ?>",
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
        });
        
        $("#formoid").submit(function(event) {
            event.preventDefault();
            var namamenu = $('#namamenu').val();
            var ikonmenu = $('#ikonmenu').val();
            var urutanmenu = $('#urutanmenu').val();
            if (namamenu == '') {
                $("#loading").html("<i class='fa fa-exclamation-triangle'></i> Nama menu harus diisi.");
                $("#namamenu").focus();
            } else if (urutanmenu == '') {
                $("#loading").html("<i class='fa fa-exclamation-triangle'></i> Nomor urut menu harus diisi.");
                $("#urutanmenu").focus();
            } else if (ikonmenu == '') {
                $("#loading").html("<i class='fa fa-exclamation-triangle'></i> Ikon menu harus diisi, dengan mencari ikon tekan tombol Pilih Ikon.");
                $("#ikonmenu").focus();
            } else {
                $.ajax({
                    type: "POST",
                    data: $(this).serialize(),
                    url: "<?php echo base_url().'menu/savedata'; ?>",
                    beforeSend: function(){
                        $("#loading").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
                    },
                    success: function(resp){
                        $("#loading").html("");
                        if (resp == 101){
                            $("#loading").html("Berhasil menyimpan data");
                            window.location.assign("<?php echo base_url().'menu'; ?>");
                        } else if (resp == 100){
                            $("#loading").html("Gagal menyimpan data");;
                        }
                    },
                    error: function(event, textStatus, errorThrown) {
                       alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
                    }
                });
            }
        });
        
        $(document).on('click', '#confirmasiDelete', function() {
            var idmenu = $(this).attr("dataid");
            $.ajax({
                type: "POST",
                url: "<?php echo base_url().'menu/loadformdelete'; ?>",
                data: {"idmenu":idmenu},
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
        });
        
        $(document).on('click', '#hapus_data', function() {
            var idmenu = $('#idmenu').val();
            $.ajax({
                type: "POST",
                data: {"idmenu":idmenu,"stat":"delete"},
                url: "<?php echo base_url().'menu/deletedata'; ?>",
                beforeSend: function(){
                    $("#loading_delete").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
                },
                success: function(resp){
                    if (resp == 101){
                        $("#modal").modal('hide');
                        window.location.assign("<?php echo base_url().'menu'; ?>");
                    } else if (resp == 100){
                        $("#modal").modal('hide');
                    }
                },
                error:function(event, textStatus, errorThrown) {
                   alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
                }
            });
        });
        
        $(document).on('click', '#cekPublish', function() {
            var idmenu = $(this).attr("dataid");
            var publish = $(this).attr("datastat");
            $.ajax({
                type: "POST",
                data: {"idmenu":idmenu,"publish":publish},
                url: "<?php echo base_url().'menu/statpublish'; ?>",
                beforeSend: function(){
                    $("#loading").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
                },
                success: function(resp){
                    if (resp == 101){
                        $("#loading").html("Berhasil merubah status publish");
                        window.location.assign("<?php echo base_url().'menu'; ?>");
                    } else if (resp == 100){
                        $("#loading").html("Gagal merubah status publish");
                    }
                },
                error:function(event, textStatus, errorThrown) {
                   alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
                }
            });
        });
        
        /*modul*/
        
        $("#formmodulid").submit(function(event) {
            event.preventDefault();
            var idmenu = $('#idmenu').val();
            var namamodul = $('#namamodul').val();
            var linkmodul = $('#linkmodul').val();
            var urutanmodul = $('#urutanmodul').val();
            if (namamodul == '') {
                $("#loading").html("<i class='fa fa-exclamation-triangle'></i> Nama modul harus diisi.");
                $("#namamodul").focus();
            } else if (linkmodul == '') {
                $("#loading").html("<i class='fa fa-exclamation-triangle'></i> Link modul harus diisi.");
                $("#linkmodul").focus();
            } else if (urutanmodul == '') {
                $("#loading").html("<i class='fa fa-exclamation-triangle'></i> Nomor urut modul harus diisi.");
                $("#linkmodul").focus();
            } else {
                $.ajax({
                    type: "POST",
                    data: $(this).serialize(),
                    url: "<?php echo base_url().'menu/savedata_modul'; ?>",
                    beforeSend: function(){
                        $("#loading").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
                    },
                    success: function(resp){
                        if (resp == 101){
                            $("#loading").html("Berhasil menyimpan data");
                            window.location.assign("<?php echo base_url().'menu/menudetail/'; ?>"+idmenu);
                        } else if (resp == 100){
                            $("#loading").html("Gagal menyimpan data");;
                        }
                    },
                    error: function(event, textStatus, errorThrown) {
                       alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
                    }
                });
            }
        });
        
        $(document).on('click', '#confirmasiEdit_Modul', function() {
            var idmodul = $(this).attr("dataid");
            $.ajax({
                type: "POST",
                data: {"idmodul":idmodul},
                url: "<?php echo base_url().'menu/moduldetail'; ?>",
                beforeSend: function(){
                    $("#loading").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
                },
                success: function(resp){
                    var obj = jQuery.parseJSON(resp);
                    $("#idmodul").val(obj.idmodul);
                    $("#namamodul").val(obj.namamodul);
                    $("#linkmodul").val(obj.linkmodul);
                    $("#urutanmodul").val(obj.urutan);
                    $("#keteranganmodul").val(obj.keterangan);
                    $('html, body').animate({ scrollTop: 0 }, 'fast');
                    $("#namamodul").focus();
                },
                error:function(event, textStatus, errorThrown) {
                   alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
                }
            });
        });
        
        $(document).on('click', '#confirmasiDelete_Modul', function() {
            var idmodul = $(this).attr("dataid");
            $.ajax({
                type: "POST",
                url: "<?php echo base_url().'menu/konfirmasihapus_modul'; ?>",
                data: {"idmodul":idmodul},
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
        });

        $(document).on('click', '#hapus_data_Modul', function() {
            var idmenu = $('#idmenu').val();
            var idmodul = $('#idmodulx').val();
            $.ajax({
                type: "POST",
                data: {"idmodul":idmodul,"stat":"delete"},
                url: "<?php echo base_url().'menu/deletedata_modul'; ?>",
                beforeSend: function(){
                    $("#loading_delete").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
                },
                success: function(resp){
                    if (resp == 101){
                        $("#modal").modal('hide');
                        window.location.assign("<?php echo base_url().'menu/menudetail/'; ?>"+idmenu);
                    } else if (resp == 100){
                        $("#modal").modal('hide');
                    }
                },
                error:function(event, textStatus, errorThrown) {
                   alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
                }
            });
        });
        
        $(document).on('click', '#cekPublish_Modul', function() {
            var idmenu = $(this).attr("dataidmenu");
            var idmodul = $(this).attr("dataid");
            var publish = $(this).attr("datastat");
            $.ajax({
                type: "POST",
                data: {"idmodul":idmodul,"publish":publish},
                url: "<?php echo base_url().'menu/statpublish_modul'; ?>",
                beforeSend: function(){
                    $("#loading").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
                },
                success: function(resp){
                    window.location.assign("<?php echo base_url().'menu/menudetail/'; ?>"+idmenu);
                },
                error:function(event, textStatus, errorThrown) {
                   alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
                }
            });
        });
    });
    
    
</script>