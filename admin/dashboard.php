<?php
session_start();
if(isset($_SESSION['auth_message'])){
    include("init.php");
    $statment1=$connect->prepare("SELECT * FROM users");
    $statment1->execute();
    $userCount=$statment1->rowCount();
    
    $statment2=$connect->prepare("SELECT * FROM categories");
    $statment2->execute();
    $catCount=$statment2->rowCount();
    
    $statment3=$connect->prepare("SELECT * FROM posts");
    $statment3->execute();
    $postsCount=$statment3->rowCount();
    
    $statment4=$connect->prepare("SELECT * FROM comments");
    $statment4->execute();
    $commentCount=$statment4->rowCount();
    ?>
    
    <div class="container mt-5 pt-5">
        <div class="row">
            <div class="col-md-3 text-center" >
                <div class="box">
                <i class="fa-solid fa-user fa-2xl"></i>
                <h3 class="my-3">Users</h3>
                <h5><?php echo $userCount; ?></h5>
                <a href="users.php" class="btn btn-success"> Show</a>
                </div>
            </div>
            <div class="col-md-3 text-center" >
                <div class="box">
                <i class="fa-solid fa-shapes fa-2xl"></i>
                <h3 class="my-3">Categories</h3>
                <h5><?php echo $catCount; ?></h5>
                <a href="categories.php" class="btn btn-warning"> Show</a>
                </div>
            </div>
            <div class="col-md-3 text-center" >
                <div class="box">
                <i class="fa-regular fa-address-card fa-2xl"></i>
                <h3 class="my-3">Posts</h3>
                <h5><?php echo $postsCount; ?></h5>
                <a href="posts.php" class="btn btn-primary"> Show</a>
                </div>
            </div>
            <div class="col-md-3 text-center" >
                <div class="box">
                <i class="fa-regular fa-comment fa-2xl"></i>
                <h3 class="my-3">Comments</h3>
                <h5><?php echo $commentCount; ?></h5>
                <a href="comments.php" class="btn btn-danger"> Show</a>
                </div>
            </div>
        </div>
    </div>


<?php
include("includes/temp/footer.php");
}else{
    $_SESSION['message_login'] ='Enter data first';
    header('Location:../login.php');
}
?>