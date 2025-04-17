<?php
session_start();
include("init_user.php");
$page = 'all';
if(isset($_GET["page"])){
    $page = $_GET["page"];
}
if($page=='all'){
?>

<div class="container mt-5  b-5">
    <div class="row">
        <div class="col-md-10 m-auto">
            <h4 class="text-center mt-5">Login page</h4>
            <?php
            if(isset($_SESSION['message_login'])){
                echo "<h4 class='alert alert-danger text-center'>".$_SESSION['message_login']."</h4>";
                unset($_SESSION["message_login"]);
            }
            ?>
            <form method="post" action="?page=logincheck">
                <label>Email</label>
                <input type="email" name="email" class="form-control mb-3" placeholder="Email">
                <label>Password</label>
                <input type="password" name="pass" class="form-control mb-3" placeholder="password">
                <input type="submit" value="Login" class="btn btn-success form-control mb-3">

            </form>
        </div>
    </div>
</div>

<?php
}elseif($page== 'logincheck'){
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $email=$_POST['email'];
        $pass=$_POST['pass'];
        $statment=$connect->prepare('SELECT * FROM users WHERE email=? AND `password`=? ');
        $statment->execute(array($email,$pass));
        $userCount=$statment->rowCount();
        if($userCount>0){
            $result=$statment->fetch();
            if($result['status']==1){
                if($result['role']=='admin'){
                    $_SESSION['auth_message']=$email;
                    header('Location:admin/dashboard.php');
                }else{
                    $_SESSION['user_login']= $email;
                    $_SESSION['username']= $result['username'];
                    header('Location:index.php');
                }
            }else{
                $_SESSION['message_login'] = 'NOT Active';
                header('Location:login.php');            }
        }else{
            $_SESSION['message_login'] = 'NOT FOUND ACCOUNT REGISTER FIRST';
            header('Location:login.php');
        }
    }
}
?>
<?php
include("includes/temp/footer.php");
?>