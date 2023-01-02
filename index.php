<?php 
 
include 'config.php';

error_reporting(0);
 
session_start();

if (isset($_POST['g-recaptcha-response']) && isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    
    $secreatkey = "6LdZm2QjAAAAAI1bwBsFBO4ObgQ60ELIJoSEkL9L";
    $ip = $_SERVER['REMOTE_ADDR'];
    $response = $_POST['g-recaptcha-response'];
    $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secreatkey&response=$response&remoteip=$ip";
    $fire = file_get_contents($url);
    $data = json_decode($fire);

    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $sql1 = "SELECT * FROM users WHERE email='$email'";

    $result = mysqli_query($conn, $sql);
    $result2 = mysqli_query($conn, $sql1);


    if($data->success==true && $result->num_rows > 0){
        $row = mysqli_fetch_assoc($result);
        $_SESSION['username'] = $row['username'];
        header("Location: marketplace.php");
    }
    
    elseif($result2->num_rows==false){
        echo "<script>alert('Email salah!')</script>";

    }

    elseif($result->num_rows==false){
        echo "<script>alert('Password salah!')</script>";

    }

    elseif($data->success==false){
        echo "<script>alert('Fill the captcha!')</script>";

    }
    else{
        echo "<script>alert('Tolong lengkapi email, password atau recaptcha')</script>";
    }
}
?>
 
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
 
    <link rel="stylesheet" type="text/css" href="style1.css">

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
 
    <title>Login Form</title>
</head>
<body>
    <div class="alert alert-warning" role="alert">
        <?php echo $_SESSION['error']?>
    </div>
 
    <div class="container">
        <form action="" method="POST" class="login-email">
            <p class="login-text" style="font-size: 2rem; font-weight: 800;">Login</p>
            <div class="input-group">
                <input type="email" placeholder="Email" name="email" value="<?php echo $email; ?>" required>
            </div>
            <div class="input-group">
                <input type="password" placeholder="Password" name="password" value="<?php echo $_POST['password']; ?>" required>
            </div>
            <div class="g-recaptcha" data-sitekey="6LdZm2QjAAAAAKHafA2vRsb4SvenRQ76jPmFtZSD">required> </div>
                <br/>
            <div class="input-group">
                <button name="submit" class="btn">Login</button>
            </div>
            <p class="login-register-text">Anda belum punya akun? <a href="register.php">Register</a></p>
        </form>
    </div>
</body>
</html>