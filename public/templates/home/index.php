<?php
    declare(strict_types=1);

use Class\Controller\LoginController;
use Class\Controller\UserController;
    require("../header.php");
    require("../../../app/config/db_connection.php");
    require("../../../app/classes/model/user.php");
    require("../../../app/classes/controller/user.controller.php");
    require("../../../app/classes/controller/login.controller.php");

    $remEmail = $_COOKIE['rememberEmail'] ?? '';

    if(isset($_POST['register'])) {
        $login = $_POST['login'];
        $email = $_POST['email'];
        $pwd = $_POST['password'];
        $pwdRepeat = $_POST['password-rep'];

        $signup = new UserController($email,$login,$pwd,$pwdRepeat);

        $signup->registerUser();
    }
    
    if(isset($_POST['login-sub'])) {
        $email = $_POST['l-email'];
        $password = $_POST['l-password'];

        $userLogin = new LoginController($email,$password);

        if(isset($_POST['remember'])) {
            setcookie("rememberEmail", $email, time() + 60*60*24*30);
        }
        $userLogin->loginUser();
    }
?>
    <div class="head-cont">
        <ul>
            <li>Home</li>
            <li>Profile</li>
            <li>Content</li>
        </ul>
        <div>
            <?php 
                if(isset($_SESSION['email'])) {
                    echo "<p>".$_SESSION['email']."</p>";
                    echo "<p>".$_SESSION['login']."</p>";
                    echo "<a href='logout.php'>Logout</a>";
                }
            ?>
        </div>
    </div>
    <h1>Login/Register</h1>  
    <div class="login-form l-cont">
        <h3>Login</h3>
        <form action="" method="POST">
            <label>
                Email
                <input type="email" name="l-email" value = "<?php echo htmlspecialchars($remEmail) ?>"><br />
            </label>
            <label>
                Password
                <input type="password" name="l-password"><br />
            </label>
            <label>
                <input type="checkbox" name="remember" id="rem-box">Remember me<br />
            </label>
            <input type="submit" name="login-sub" value="Log in">
        </form>
    </div>
    <div class="register-form l-cont">
        <h3>Register</h3>
        <form action="" method="POST">
            <label>
                Email
                <input type="email" name="email" ><br />
            </label>
            <label>
                Login
                <input type="text" name="login" ><br />
            </label>
            <label>
                Password
                <input type="password" name="password"><br />
            </label>
            <label>
                Repeat password
                <input type="password" name="password-rep"><br />
            </label>
            <input type="submit" name="register">
        </form>
    </div>
<?php require("../footer.php"); ?>
