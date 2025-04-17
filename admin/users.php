<?php
session_start();
if(isset($_SESSION['auth_message'])){
include("init.php");
$page="all";
if(isset($_GET["page"])){
    $page = $_GET["page"];
}
if($page=='all'){
$statment = $connect->prepare("SELECT * FROM users");
$statment->execute();
$ucount = $statment->rowCount();
$result = $statment->fetchAll();
?>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-10 m-auto">
            <?php
            if(isset($_SESSION['message'])){
                echo"<h2 class='alert alert-success text-center'>".$_SESSION['message']."</h2>";
                unset($_SESSION["message"]);
                header("Refresh:3;url=users.php");
            }
            ?>
            <h2 class="text-center">Details of users
                <span class="btn btn-primary"><?php echo $ucount;?></span>
                <a href="?page=create" class="btn btn-success">Add new user</a>
            </h2>
            <table class="table table-dark">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Role</th>
                    <th>Created_at</th>
                    <th>Operation</th>
                </tr>
                </thead>
                <tbody class="text center">
                    <?php
                    foreach ($result as $item) {
                    ?>
                    <tr>
                        <td><?php echo $item['user_id'] ?></td>
                        <td><?php echo $item['username'] ?></td>
                        <td><?php echo $item['email'] ?></td>
                        <td><?php echo $item['status'] ?></td>
                        <td><?php echo $item['role'] ?></td>
                        <td><?php echo $item['created_at'] ?></td>
                        <td>
                        <a href="?page=show&user=<?php echo $item['user_id']?>" class="btn btn-success"><i class="fa-solid fa-eye"></i></a>
                        <a href="?page=edit&user=<?php echo $item['user_id'] ?>" class="btn btn-primary"><i class="fa-solid fa-pen-to-square"></i></a>
                        <a href="?page=delete&user=<?php echo $item['user_id'];?>" class="btn btn-danger"><i class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
}elseif($page== 'show'){
    if(isset($_GET['user'])){
        $user = $_GET['user'];
    }
    $statment = $connect->prepare('SELECT * FROM users WHERE user_id=?');
    $statment->execute(array($user));
    $ucount = $statment->rowCount();
    $result = $statment->fetch();
    ?>
    <div class="container mt-5">
    <div class="row">
        <div class="col-md-10 m-auto">
            <h2 class="text-center">Details of users
                <span class="btn btn-primary"><?php echo $ucount;?></span>
            </h2>
            <table class="table table-dark">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Role</th>
                    <th>Created_at</th>
                    <th>Operation</th>
                </tr>
                </thead>
                <tbody class="text center">
                        <td><?php echo $result['user_id'] ?></td>
                        <td><?php echo $result['username'] ?></td>
                        <td><?php echo $result['email'] ?></td>
                        <td><?php echo $result['status'] ?></td>
                        <td><?php echo $result['role'] ?></td>
                        <td><?php echo $result['created_at'] ?></td>
                        <td>
                        <a href="users.php" class="btn btn-success"><i class="fa-solid fa-house"></i></a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
}elseif($page== 'delete'){
    if(isset($_GET['user'])){
        $user = $_GET['user'];
    }
    $statment = $connect->prepare('DELETE FROM users WHERE user_id=?');
    $statment->execute(array($user));
    $_SESSION['message']="Deleted Successfully";
    header('Location:users.php');
}elseif($page== 'create'){
    ?>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-10 m-auto">
            <h3 class="text-center">Add new user</h3>
            <form action="?page=savecreate" method="post">
                <label>ID</label>
                <input type="text" name="id" class="form-control mb-3"
                placeholder="<?php
                if(isset($_SESSION['error_id'])){
                     echo $_SESSION['error_id'];
                     unset($_SESSION['error_id']);
                }?>">
                <label>Name</label>
                <input type="text" name="user" class="form-control mb-3" 
                value="<?php
                if(isset($_SESSION['error_name'])){
                     echo $_SESSION['error_name'];
                     unset($_SESSION['error_name']);
                }
                ?>">
                <label>Email</label>
                <input type="email" name="email" class="form-control mb-3"
                value="<?php
                if(isset($_SESSION['error_email'])){
                     echo $_SESSION['error_email'];
                     unset($_SESSION['error_email']);
                }?>"
                >
                <label>Password</label>
                <input type="password" name="pass" class="form-control mb-3">
                <label>Status</label>
                <select name="status" class="form-control mb-3">
                    <option value="0">Block</option>
                    <option value="1">Active</option>
                </select>
                <select name="role" class="form-control mb-3">
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
                <input type="submit" name="submit" value="Insert" class="btn btn-success form-control mb-3">
            </form>
            </div>
        </div>
    </div>
    
<?php
}elseif($page== 'savecreate'){
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $id = $_POST['id'];
        $user = $_POST['user'];
        $email = $_POST['email'];
        $pass = $_POST['pass'];
        $status = $_POST['status'];
        $role = $_POST['role'];
        try{
        $statment= $connect->prepare('INSERT INTO
        users(user_id,username,email,`password`,`status`,`role`,created_at)
        VALUES(?,?,?,?,?,?,now())
        ');
        $statment->execute(array($id, $user, $email, $pass, $status,$role));
        $_SESSION['message']='Created Successfully';

        header('Location:users.php');
        }catch(PDOException $e){
            $_SESSION['error_id']='Enter another id';
            $_SESSION['error_name']=$user;
            $_SESSION['error_email']=$email;
            echo"<h4 class='alert alert-danger text-center'>Duplicated ID</h4>";
            header("Refresh:3;url=users.php?page=create");

        }
    }
}elseif($page== "edit"){
    if(isset($_GET['user'])){
        $user = $_GET['user'];
    }
    $statment=$connect->prepare('SELECT * FROM users WHERE user_id=?');
    $statment->execute(array($user));
    $result=$statment->fetch();
    ?>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-10 m-auto">
            <h3 class="text-center">Edit user</h3>
            <form action="?page=saveedit&old_id=<?php echo $result['user_id'];?>" method="post">
                <label>ID</label>
                <input type="text" name="new_id" class="form-control mb-3" value="<?php echo $result['user_id'];?>">
                <label>Name</label>
                <input type="text" name="user" class="form-control mb-3" value="<?php echo $result['username'];?>">
                <label>Email</label>
                <input type="email" name="email" class="form-control mb-3" value="<?php echo $result['email'];?>">
                <select name="status" class="form-control mb-3">
                    <?php
                        if($result['status']==1){
                            
                            echo "<option value='0'>Block</option>";
                            echo "<option value='1' selected>Active</option>";
                        }else{
                            echo "<option value='0'selected>Block</option>";
                            echo "<option value='1'>Active</option>";
                        }           
                    ?>
                </select>
                <select name="role" class="form-control mb-3">
                    <?php
                    if($result["role"]=='admin'){
                        echo "<option value='admin' selected>Admin</option>";
                        echo "<option value='user'>User</option>";
                    }else{
                        echo "<option value='admin'>Admin</option>";
                        echo "<option value='user' selected>User</option>";
                    }
                    ?>
                </select>
                <input type="submit" name="submit" value="Insert" class="btn btn-success form-control mb-3">
            </form>
            </div>
        </div>
    </div>
    <?php
}elseif($page== "saveedit"){

        if(isset($_GET["old_id"])){
            $old_id = $_GET["old_id"];
        }
        if($_SERVER["REQUEST_METHOD"]== "POST"){
            $new_id=$_POST["new_id"];
            $user = $_POST["user"];
            $email = $_POST["email"];
            $status = $_POST["status"];
            $role = $_POST["role"];
            try{
                $statment=$connect->prepare("UPDATE users SET
                user_id=?,
                username=?,
                email=?,
                `status`=?,
                `role`=?
                WHERE user_id=?
                ");
                $statment->execute(array($new_id, $user, $email, $status, $role, $old_id));
                $_SESSION['message']='Edit succesfully';
                header('Location:users.php');
            }catch(PDOException $e){
                echo "<h4 class='alert alert-danger text-center'>Dublicated ID</h4>";
                header("Refresh:3;url=users.php?page=edit&user=$old_id");
            }

        }
}
?>
<?php
include("includes/temp/footer.php");
}else{
    $_SESSION['message_login'] ='Enter data first';
    header('Location:../login.php');
}
?>