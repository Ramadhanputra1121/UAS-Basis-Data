<?php
session_start();

if($_SESSION["code"] != $_POST["kode"]){
    //jika code captcha salah mmaka akan kembali ke halaman sebelumnya
    echo "<script>alert('captcha yang anda masukkan salah');window.history.go(-1);</script>";
}else{ ?>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
    <br><br>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Register</h3>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <?php echo $_POST['name']; ?>
                        </div>
                        <div class="form-group">
                            <?php echo $_POST['email']; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>