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
        
        $(document).on('click', '#tampilinfo', function() {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url().'grup/infomodul'; ?>",
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
            var namagrup = $('#namagrup').val();
            if (namagrup == '') {
                $("#loading").html("<i class='fa fa-exclamation-triangle'></i> Nama grup harus diisi.");
                $("#namagrup").focus();
            } else {
                $.ajax({
                    type: "POST",
                    data: $(this).serialize(),
                    url: "<?php echo base_url().'grup/savedata'; ?>",
                    beforeSend: function(){
                        $("#loading").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
                    },
                    success: function(resp){
                        $("#loading").html("");
                        if (resp == 101){
                            $("#loading").html("Berhasil menyimpan data");
                            window.location.assign("<?php echo base_url().'grup'; ?>");
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
            var idgrup = $(this).attr("dataid");
            $.ajax({
                type: "POST",
                url: "<?php echo base_url().'grup/loadformdelete'; ?>",
                data: {"idgrup":idgrup},
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
            var idgrup = $('#idgrup').val();
            $.ajax({
                type: "POST",
                data: {"idgrup":idgrup,"stat":"delete"},
                url: "<?php echo base_url().'grup/deletedata'; ?>",
                beforeSend: function(){
                    $("#loading_delete").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
                },
                success: function(resp){
                    if (resp == 101){
                        $("#modal").modal('hide');
                        window.location.assign("<?php echo base_url().'grup'; ?>");
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
            var idgrup = $(this).attr("dataid");
            var publish = $(this).attr("datastat");
            $.ajax({
                type: "POST",
                data: {"idgrup":idgrup,"publish":publish},
                url: "<?php echo base_url().'grup/statpublish'; ?>",
                beforeSend: function(){
                    $("#loading").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
                },
                success: function(resp){
                    if (resp == 101){
                        $("#loading").html("Berhasil merubah status publish");
                        window.location.assign("<?php echo base_url().'grup'; ?>");
                    } else if (resp == 100){
                        $("#loading").html("Gagal merubah status publish");
                    }
                },
                error:function(event, textStatus, errorThrown) {
                   alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
                }
            });
        });
        
    });
    
    function toggleView(idmodul,idgrup){
        if($('#cekView'+idmodul).prop("checked")) {
            var cek = 1;
            $('#cekAdd'+idmodul).attr('disabled', false);
            $('#cekEdit'+idmodul).attr('disabled', false);
            $('#cekDelete'+idmodul).attr('disabled', false);
        } else {
            var cek = 0;
            $('#cekAdd'+idmodul).attr('disabled', true);
            $('#cekEdit'+idmodul).attr('disabled', true);
            $('#cekDelete'+idmodul).attr('disabled', true);
        }
        $.ajax({
            type: "POST",	
            data: {"idgrup":idgrup,"idmodul":idmodul,"cek":cek},
            url: "<?php echo base_url().'grup/update_view'; ?>",
            beforeSend: function(){
                $("#loading").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
            },
            success: function(resp){
                if (resp == 101){
//                    alert("Berhasil merubah status Lihat data");
                    $("#loading").html("");
                } else if (resp == 100){
                    alert("Gagal merubah status Lihat data");
                    $("#loading").html("");
                }
            }
        });
    };

    function toggleAdd(idmodul,idgrup){
        if($('#cekAdd'+idmodul).prop("checked")) {
            var cek = 1;
        } else {
            var cek = 0;
        }
        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>grup/update_action",
            data: {"idgrup":idgrup,"idmodul":idmodul,"cek":cek,"stat":"Add"},
            beforeSend: function(){
                $("#loading").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
            },
            success: function(resp){
                if (resp == 101){
//                    alert("Berhasil merubah status Tambah data");
                    $("#loading").html("");
                } else if (resp == 100){
                    alert("Gagal merubah status Tambah data");
                    $("#loading").html("");
                }
            }
        });
    };

    function toggleEdit(idmodul,idgrup){
        if($('#cekEdit'+idmodul).prop("checked")) {
            var cek = 1;
        } else {
            var cek = 0;
        }
        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>grup/update_action",
            data: {"idgrup":idgrup,"idmodul":idmodul,"cek":cek,"stat":"Edit"},
            beforeSend: function(){
                $("#loading").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
            },
            success: function(resp){
                if (resp == 101){
//                    alert("Berhasil merubah status Ubah data");
                    $("#loading").html("");
                } else if (resp == 100){
                    alert("Gagal merubah status Ubah data");
                    $("#loading").html("");
                }
            }
        });
    };

    function toggleDelete(idmodul,idgrup){
        if($('#cekDelete'+idmodul).prop("checked")) {
            var cek = 1;
        } else {
            var cek = 0;
        }
        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>grup/update_action",
            data: {"idgrup":idgrup,"idmodul":idmodul,"cek":cek,"stat":"Delete"},
            beforeSend: function(){
                $("#loading").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
            },
            success: function(resp){
                if (resp == 101){
//                    alert("Berhasil merubah status Hapus data");
                    $("#loading").html("");
                } else if (resp == 100){
                    alert("Gagal merubah status Hapus data");
                    $("#loading").html("");
                }
            }
        });
    };
</script>