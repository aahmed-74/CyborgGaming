<?php
include("init_user.php");
$page= "all";
if(isset($_GET["page"])){
    $page = $_GET["page"];
}
if($page=='all'){
?>

<div class="container mt-5 pt-5">
    <div class="row">
        <div class="col-md-10 m-auto">
            <form method="post" action="?page=savenewaccount">
                <input type="text" name="user" placeholder="Name" class="form-control mb-4">
                <h5 class="text-center my-3"><?php 
                if(isset($_SESSION['error_user'])){
                    echo $_SESSION['error_user'];
                    unset($_SESSION['error_user']);
                }
                ?></h5>
                <input type="emil" name="email" placeholder="E-mail" class="form-control mb-4">
                <h5 class="text-center my-3">
                <?php 
                if(isset($_SESSION['error_user'])){
                    echo $_SESSION['error_user'];
                    unset($_SESSION['error_user']);
                }
                ?></h5>
                <input type="password" name="pass" placeholder="password" class="form-control mb-4">
                <h5 class="text-center my-3"><?php 
                if(isset($_SESSION['error_password'])){
                    echo $_SESSION['error_password'];
                    unset($_SESSION['error_password']);
                }
                ?></h5>
                <input type="submit" value="Create new Account" class="btn btn-success w-100">

            </form>
        </div>
    </div>
</div>
<?php
}else if($page=="savenewaccount"){
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $user= $_POST['user'];
        $email = $_POST['email'];
        $pass = $_POST['pass'];
        if(empty($user)){
            $_SESSION['error_user']='Enter Name';
            header("Location:register.php");

        }elseif(empty($email)){
            $_SESSION['error_email']='Enter Email';
            header("Location:register.php");
        }elseif(empty($pass)){
            $_SESSION['error_password']='Enter Password';
            header("Location:register.php");
        }else{
        $statment = $connect->prepare("INSERT INTO 
        users (username,email,`password`,`status`,`role`,created_at)
        VALUES (?,?,?,'1','user',now())
        ");
        $statment->execute(array($user,$email,$pass));
        $_SESSION['user_login']= $email;
        $_SESSION['username']= $user;
        header('Location:index.php');
        }

    }

}
?>
<?php
include("includes/temp/footer.php");

?>