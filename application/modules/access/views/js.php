<script>
$(document).ready(function () {
    
    $("#username").focus();
    
    $(document).on('click', '#ceklogin', function() {
        var username = $('#username').val();
        var password = $('#password').val();
        var keycaptcha = $('#keycaptcha').val();
        if(username == ""){
            $("#alert").html("Username harus diisi!");
            $("#username").focus();
            return false;
        } else if (password == ""){
            $("#alert").html("Password harus diisi!");
            $("#password").focus();
            return false;
        } else if (keycaptcha == ""){
            $("#alert").html("Captcha harus diisi!");
            $("#keycaptcha").focus();
            return false;
        } else {
            $.ajax({
                type: "POST",
                data: {"username":username,"password":password,"keycaptcha":keycaptcha},
                url: "<?php echo base_url().'access/ceklogin'; ?>",
                beforeSend: function(){
                    $("#alert").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
                },
                success: function(resp){
                    if (resp == 101){
                        $("#alert").html("Username salah!");
                        $("#username").focus();
                    } else if (resp == 102) {
                        $("#alert").html("Password salah");
                        $("#password").focus();
                    } else if (resp == 103) {
                        $("#alert").html("Username dan Password tidak terdaftar!");
                        $("#username").focus();
                    } else if (resp == 104) {
                        $("#alert").html("Captcha salah!");
                        $("#keycaptcha").focus();
                    } else if (resp == 109){
                        $("#alert").html("<img src='../assets/dist/img/loading.gif'>");
                        cekLoginSuccess();
                    } 
                },
                error:function(event, textStatus, errorThrown) {
                   alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
                }
            });
        }

    });
});

function cekLoginSuccess(){
    window.location.replace("<?php echo base_url(); ?>");
};
</script>