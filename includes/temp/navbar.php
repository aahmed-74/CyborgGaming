<header class="header-area header-sticky">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="main-nav">
                    <!-- ***** Logo Start ***** -->
                    <a href="index.php" class="logo">
                        <img src="includes/assets/images/logo.png" alt="">
                    </a>
                    <!-- ***** Logo End ***** -->
                    <!-- ***** Search End ***** -->
                    <div class="search-input">
                      <form id="search" action="#">
                        <input type="text" placeholder="Type Something" id='searchText' name="searchKeyword" onkeypress="handle" />
                        <i class="fa fa-search"></i>
                      </form>
                    </div>
                    <!-- ***** Search End ***** -->
                    <!-- ***** Menu Start ***** -->
                    <ul class="nav">
                        <li><a href="index.php" class="active">Home</a></li>
                        <li><a href="browse.php">Browse</a></li>
                        <li><a href="details.php">Details</a></li>
                        <?php
                        if(isset($_SESSION['user_login'])){
                            echo '<li><a href="streams.php">Streams</a></li>';
                            echo'<li><a href="logout.php">Logout</a></li>';
                        }else{
                            echo '<li><a href="login.php">Login</a></li>';
                            echo '<li><a href="register.php">Register</a></li>';
                        }
                        ?>
                        <li><a href="profile.php">
                        <?php if(isset($_SESSION['username'])){
                                echo $_SESSION['username'];
                        }else{
                            echo 'Profile';
                        }
                            ?>
                            
                        <img src="includes/assets/images/profile-header.jpg" alt=""></a></li>';
                    </ul>   
                    <a class='menu-trigger'>
                        <span>Menu</span>
                    </a>
                    <!-- ***** Menu End ***** -->
                </nav>
            </div>
        </div>
    </div>
  </header>