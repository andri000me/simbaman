<?php
    //$this->load->view('access/js');
?>
<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>Admin</b> Bank Soal</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <!--<p class="login-box-msg">Sign in to start your session</p>-->
        <form action="#" method="post" style="margin-bottom: 30px; margin-top: 30px;">
            <div class="form-group has-feedback">
                <input type="test" class="form-control" placeholder="Email" id="email">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <?php echo $image;?>
                </div><!-- /.col -->
                <div class="col-xs-6">
                    <input type="text" class="form-control" id="keycaptcha" name="keycaptcha">
                </div><!-- /.col -->
            </div>
            <br>
            <div class="row">
                <div class="col-xs-12">
                    <div id="alert">&nbsp;</div>
                </div><!-- /.col -->
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <button type="button" class="btn btn-primary btn-block btn-flat"><i class="fa fa-send"></i> Kirim Email</button>
                </div><!-- /.col -->
            </div>
            <br>
            <a href="login">Login</a><br>
        </form>
        <hr>
        <div style="text-align: center;">
            Suport by Codeigniter and Admin LTE <br>
            Copyright Administrator © 2016
        </div>

      </div><!-- /.login-box-body -->
</div><!-- /.login-box -->